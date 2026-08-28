<?php
/**
 * Plugin Name: VK7K Varnish Clear Cache
 * Plugin URI:  https://github.com/vk7k/wp-snippets
 * Description: Purga automática de caché en servidores Varnish (CloudPanel / VPS) al publicar o actualizar entradas y páginas.
 * Version:     1.0.0
 * Author:      Victor Mellado (vk7k)
 * Author URI:  https://victormellado.cl
 * License:     MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: vk7k-varnish-cache
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'VARNISH_PURGE_MAX_RETRIES' ) ) {
    define( 'VARNISH_PURGE_MAX_RETRIES', 3 );
}
if ( ! defined( 'VARNISH_PURGE_RETRY_DELAY' ) ) {
    define( 'VARNISH_PURGE_RETRY_DELAY', 1 );
}
if ( ! defined( 'VARNISH_LOG_MAX_SIZE' ) ) {
    define( 'VARNISH_LOG_MAX_SIZE', 5242880 ); // 5MB
}

add_action( 'admin_menu', 'vk7k_varnish_add_settings_page' );
add_action( 'admin_init', 'vk7k_varnish_register_settings' );
add_action( 'save_post', 'vk7k_varnish_purge_on_save', 10, 3 );

/**
 * Validar formato de servidor (host:puerto o http://host:puerto)
 */
function vk7k_varnish_validate_server( $server ) {
    if ( empty( $server ) ) {
        return '';
    }
    
    $server = trim( $server );
    
    // Permitir: 127.0.0.1:6081, localhost:6081, example.com:6081
    if ( ! preg_match( '/^[a-zA-Z0-9\.\-:]+$/', $server ) ) {
        return '';
    }
    
    // Si contiene :, validar que puerto sea numérico
    if ( strpos( $server, ':' ) !== false ) {
        $parts = explode( ':', $server );
        $port = isset( $parts[1] ) ? $parts[1] : '';
        if ( ! ctype_digit( $port ) || (int) $port < 1 || (int) $port > 65535 ) {
            return '';
        }
    }
    
    return $server;
}

/**
 * Sanitizar y validar entrada de servidor
 */
function vk7k_varnish_sanitize_server( $server ) {
    $server = sanitize_text_field( $server );
    $validated = vk7k_varnish_validate_server( $server );
    
    if ( empty( $validated ) ) {
        add_settings_error(
            'varnish_server',
            'invalid_server',
            'Formato inválido. Usa: 127.0.0.1:6081 o localhost:6081',
            'error'
        );
        return get_option( 'varnish_server', '127.0.0.1:6081' );
    }
    
    return $validated;
}

/**
 * Agregar página de settings
 */
function vk7k_varnish_add_settings_page() {
    add_options_page(
        'Configuración de Varnish',
        'Varnish Cache',
        'manage_options',
        'varnish-settings',
        'vk7k_varnish_settings_page_html'
    );
}

/**
 * Registrar settings con sanitización
 */
function vk7k_varnish_register_settings() {
    register_setting( 
        'varnish_settings_group', 
        'varnish_server',
        array(
            'type'              => 'string',
            'sanitize_callback' => 'vk7k_varnish_sanitize_server',
            'default'           => '127.0.0.1:6081',
        )
    );
    
    register_setting( 
        'varnish_settings_group', 
        'varnish_enabled',
        array(
            'type'              => 'boolean',
            'sanitize_callback' => function( $value ) {
                return $value ? 1 : 0;
            },
            'default'           => 1,
        )
    );
    
    register_setting( 
        'varnish_settings_group', 
        'varnish_purge_homepage',
        array(
            'type'              => 'boolean',
            'sanitize_callback' => function( $value ) {
                return $value ? 1 : 0;
            },
            'default'           => 1,
        )
    );
    
    add_settings_section(
        'varnish_main_section',
        'Configuración de Varnish',
        'vk7k_varnish_section_callback',
        'varnish-settings'
    );
    
    add_settings_field(
        'varnish_enabled_field',
        'Habilitar purga automática',
        'vk7k_varnish_enabled_field_callback',
        'varnish-settings',
        'varnish_main_section'
    );
    
    add_settings_field(
        'varnish_server_field',
        'Varnish Server',
        'vk7k_varnish_server_field_callback',
        'varnish-settings',
        'varnish_main_section'
    );
    
    add_settings_field(
        'varnish_purge_homepage_field',
        'Purgar homepage',
        'vk7k_varnish_purge_homepage_field_callback',
        'varnish-settings',
        'varnish_main_section'
    );
}

function vk7k_varnish_section_callback() {
    echo '<p>Configura tu servidor Varnish (CloudPanel u otro VPS).</p>';
}

function vk7k_varnish_enabled_field_callback() {
    $value = get_option( 'varnish_enabled', 1 );
    echo '<label><input type="checkbox" name="varnish_enabled" value="1" ' . checked( $value, 1, false ) . '> Activar purga automática</label>';
}

function vk7k_varnish_server_field_callback() {
    $value = esc_attr( get_option( 'varnish_server', '127.0.0.1:6081' ) );
    echo '<input type="text" name="varnish_server" value="' . $value . '" placeholder="127.0.0.1:6081" style="width: 300px; padding: 8px;">';
    echo '<p style="margin: 8px 0 0 0; color: #666; font-size: 13px;"><code>host:puerto</code> ejemplo: <code>127.0.0.1:6081</code></p>';
}

function vk7k_varnish_purge_homepage_field_callback() {
    $value = get_option( 'varnish_purge_homepage', 1 );
    echo '<label><input type="checkbox" name="varnish_purge_homepage" value="1" ' . checked( $value, 1, false ) . '> Purgar homepage también</label>';
}

/**
 * HTML de settings page
 */
function vk7k_varnish_settings_page_html() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    
    if ( isset( $_GET['settings-updated'] ) ) {
        add_settings_error( 'varnish_messages', 'varnish_message', 'Configuración guardada.', 'updated' );
    }
    
    settings_errors( 'varnish_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'varnish_settings_group' );
            do_settings_sections( 'varnish-settings' );
            submit_button();
            ?>
        </form>
        
        <hr style="margin-top: 40px;">
        <h2>Últimas purgas</h2>
        <?php vk7k_varnish_show_recent_logs(); ?>
    </div>
    <?php
}

/**
 * Setup logs con límite de tamaño
 */
function vk7k_setup_varnish_log_directory() {
    $upload = wp_upload_dir();
    $log_dir = $upload['basedir'] . '/agencia-logs';
    
    if ( file_exists( $log_dir ) ) {
        return $log_dir;
    }
    
    if ( ! wp_mkdir_p( $log_dir ) ) {
        return false;
    }
    
    @file_put_contents( $log_dir . '/.htaccess', "Order deny,allow\nDeny from all\n" );
    @file_put_contents( $log_dir . '/index.php', "<?php // Silence\n" );
    
    return $log_dir;
}

/**
 * Logging con rotación automática
 */
function vk7k_varnish_log( $mensaje, $tipo = 'info' ) {
    $log_dir = vk7k_setup_varnish_log_directory();
    if ( ! $log_dir ) {
        return;
    }
    
    $log_file = $log_dir . '/varnish-purge.log';
    
    // Verificar si el log excede tamaño máximo
    if ( file_exists( $log_file ) && filesize( $log_file ) > VARNISH_LOG_MAX_SIZE ) {
        // Rotar: guardar con timestamp
        $backup = $log_file . '.' . date( 'Y-m-d-H-i-s' );
        @rename( $log_file, $backup );
    }
    
    $fecha = current_time( 'Y-m-d H:i:s' );
    $tipo = strtoupper( $tipo );
    $entrada = "[{$fecha}] [{$tipo}] {$mensaje}" . PHP_EOL;
    
    @file_put_contents( $log_file, $entrada, FILE_APPEND );
}

/**
 * Mostrar logs recientes
 */
function vk7k_varnish_show_recent_logs() {
    $log_dir = vk7k_setup_varnish_log_directory();
    if ( ! $log_dir ) {
        echo '<p style="color: #999;">No hay logs.</p>';
        return;
    }
    
    $log_file = $log_dir . '/varnish-purge.log';
    if ( ! file_exists( $log_file ) ) {
        echo '<p style="color: #999;">No hay logs.</p>';
        return;
    }
    
    $lines = file( $log_file, FILE_IGNORE_NEW_LINES );
    $recent = array_slice( $lines, -10 );
    
    echo '<pre style="background: #f5f5f5; padding: 12px; border-radius: 4px; font-size: 12px; max-height: 300px; overflow: auto;">';
    foreach ( array_reverse( $recent ) as $line ) {
        $color = strpos( $line, '[ERROR]' ) !== false ? '#d32f2f' : '#666';
        $color = strpos( $line, '[INFO]' ) !== false ? '#1976d2' : $color;
        echo '<span style="color: ' . $color . ';">' . esc_html( $line ) . '</span>' . PHP_EOL;
    }
    echo '</pre>';
}

/**
 * Purga URL en Varnish
 */
function vk7k_varnish_purge_url( $url, $varnish_server, $retries = VARNISH_PURGE_MAX_RETRIES ) {
    if ( ! filter_var( $url, FILTER_VALIDATE_URL ) ) {
        vk7k_varnish_log( "URL inválida: {$url}", 'error' );
        return false;
    }
    
    // Construir URL hacia Varnish
    $parsed = parse_url( $url );
    $path = isset( $parsed['path'] ) ? $parsed['path'] : '/';
    $query = isset( $parsed['query'] ) ? '?' . $parsed['query'] : '';
    $varnish_url = 'http://' . $varnish_server . $path . $query;
    
    for ( $attempt = 1; $attempt <= $retries; $attempt++ ) {
        $response = wp_remote_request( $varnish_url, array(
            'method'      => 'PURGE',
            'sslverify'   => false,
            'timeout'     => 5,
            'redirection' => 0,
        ) );
        
        if ( is_wp_error( $response ) ) {
            $error = $response->get_error_message();
            
            if ( $attempt < $retries ) {
                vk7k_varnish_log( "Reintento {$attempt}/{$retries}: {$error}", 'warning' );
                sleep( VARNISH_PURGE_RETRY_DELAY );
                continue;
            }
            
            vk7k_varnish_log( "ERROR: {$error}", 'error' );
            return false;
        }
        
        $codigo = wp_remote_retrieve_response_code( $response );
        
        if ( $codigo === 200 || $codigo === 204 ) {
            vk7k_varnish_log( "OK: {$url} [Status: {$codigo}]", 'info' );
            return true;
        }
        
        if ( $attempt < $retries ) {
            vk7k_varnish_log( "Reintento {$attempt}/{$retries}: Status {$codigo}", 'warning' );
            sleep( VARNISH_PURGE_RETRY_DELAY );
            continue;
        }
        
        vk7k_varnish_log( "ERROR: Status {$codigo}", 'error' );
        return false;
    }
    
    return false;
}

/**
 * Hook principal al guardar post
 */
function vk7k_varnish_purge_on_save( $post_id, $post, $update ) {
    if ( ! get_option( 'varnish_enabled', 1 ) ) {
        return;
    }
    
    $varnish_server = get_option( 'varnish_server', '127.0.0.1:6081' );
    if ( empty( $varnish_server ) ) {
        vk7k_varnish_log( 'Varnish no configurado', 'error' );
        return;
    }
    
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    if ( wp_is_post_revision( $post_id ) ) {
        return;
    }
    
    if ( get_post_status( $post_id ) !== 'publish' ) {
        return;
    }
    
    $cacheable_types = apply_filters( 'varnish_purge_post_types', array( 'post', 'page' ) );
    if ( ! in_array( $post->post_type, $cacheable_types, true ) ) {
        return;
    }
    
    $post_url = get_permalink( $post_id );
    vk7k_varnish_log( "Purga: {$post->post_title}", 'info' );
    
    vk7k_varnish_purge_url( $post_url, $varnish_server );
    
    if ( get_option( 'varnish_purge_homepage', 1 ) ) {
        vk7k_varnish_purge_url( home_url( '/' ), $varnish_server );
    }
}
