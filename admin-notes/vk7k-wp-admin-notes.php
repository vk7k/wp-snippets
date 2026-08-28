<?php
/**
 * Plugin Name: VK7K Admin Notes
 * Plugin URI:  https://github.com/vk7k/wp-snippets
 * Description: Notas internas, avisos y recordatorios en pantallas específicas del panel de administración de WordPress por roles o usuarios.
 * Version:     1.0.0
 * Author:      Victor Mellado (vk7k)
 * Author URI:  https://victormellado.cl
 * License:     MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: vk7k-admin-notes
 */

defined( 'ABSPATH' ) || exit;

class VK7K_Admin_Notes {

    const OPTION_KEY = 'vk7k_admin_notes';

    public static function init() {
        add_action( 'admin_menu', [ __CLASS__, 'add_admin_menu' ] );
        add_action( 'admin_init', [ __CLASS__, 'handle_actions' ] );
        add_action( 'admin_notices', [ __CLASS__, 'display_admin_notices' ] );
    }

    /**
     * Registra el menú bajo Herramientas > Notas Internas
     */
    public static function add_admin_menu() {
        add_management_page(
            __( 'Notas Internas', 'vk7k-admin-notes' ),
            __( 'Notas Internas', 'vk7k-admin-notes' ),
            'manage_options',
            'vk7k-admin-notes',
            [ __CLASS__, 'render_admin_page' ]
        );
    }

    /**
     * Obtiene todas las notas guardadas
     */
    public static function get_notes() {
        $notes = get_option( self::OPTION_KEY, [] );
        return is_array( $notes ) ? $notes : [];
    }

    /**
     * Guarda el array de notas
     */
    public static function save_notes( array $notes ) {
        return update_option( self::OPTION_KEY, $notes );
    }

    /**
     * Procesa acciones de guardado, edición y eliminación
     */
    public static function handle_actions() {
        if ( ! isset( $_POST['vk7k_notes_action'] ) && ! isset( $_GET['vk7k_delete_note'] ) ) {
            return;
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        // Eliminar nota
        if ( isset( $_GET['vk7k_delete_note'] ) ) {
            $note_id = sanitize_text_field( $_GET['vk7k_delete_note'] );
            check_admin_referer( 'vk7k_delete_note_' . $note_id );

            $notes = self::get_notes();
            if ( isset( $notes[ $note_id ] ) ) {
                unset( $notes[ $note_id ] );
                self::save_notes( $notes );
            }

            wp_safe_redirect( admin_url( 'tools.php?page=vk7k-admin-notes&message=deleted' ) );
            exit;
        }

        // Guardar o Editar nota
        if ( isset( $_POST['vk7k_notes_action'] ) && $_POST['vk7k_notes_action'] === 'save_note' ) {
            check_admin_referer( 'vk7k_save_note_nonce' );

            $note_id = ! empty( $_POST['note_id'] ) ? sanitize_text_field( $_POST['note_id'] ) : 'note_' . time() . '_' . wp_rand( 100, 999 );
            $title   = isset( $_POST['note_title'] ) ? sanitize_text_field( $_POST['note_title'] ) : '';
            $content = isset( $_POST['note_content'] ) ? wp_kses_post( $_POST['note_content'] ) : '';
            $screen  = isset( $_POST['note_screen'] ) ? sanitize_text_field( trim( $_POST['note_screen'] ) ) : '';
            $type    = isset( $_POST['note_type'] ) && in_array( $_POST['note_type'], [ 'info', 'warning', 'error', 'success' ], true ) ? $_POST['note_type'] : 'info';
            $perm    = isset( $_POST['note_permission'] ) ? sanitize_text_field( trim( $_POST['note_permission'] ) ) : 'administrator';
            $active  = isset( $_POST['note_active'] ) ? 1 : 0;

            if ( empty( $title ) && empty( $content ) ) {
                wp_safe_redirect( admin_url( 'tools.php?page=vk7k-admin-notes&message=error_empty' ) );
                exit;
            }

            $notes = self::get_notes();
            $notes[ $note_id ] = [
                'id'         => $note_id,
                'title'      => $title,
                'content'    => $content,
                'screen'     => $screen,
                'type'       => $type,
                'permission' => $perm,
                'active'     => $active,
                'updated_at' => current_time( 'mysql' ),
            ];

            self::save_notes( $notes );
            wp_safe_redirect( admin_url( 'tools.php?page=vk7k-admin-notes&message=saved' ) );
            exit;
        }
    }

    /**
     * Muestra los avisos en las pantallas configuradas
     */
    public static function display_admin_notices() {
        if ( ! is_admin() ) {
            return;
        }

        $screen = get_current_screen();
        if ( ! $screen ) {
            return;
        }

        $current_user = wp_get_current_user();
        if ( ! $current_user || ! $current_user->exists() ) {
            return;
        }

        $notes = self::get_notes();
        if ( empty( $notes ) ) {
            return;
        }

        foreach ( $notes as $note ) {
            if ( empty( $note['active'] ) ) {
                continue;
            }

            // 1. Validar pantalla (Screen ID)
            $target_screen = ! empty( $note['screen'] ) ? trim( $note['screen'] ) : '';
            if ( $target_screen !== '' && $target_screen !== '*' ) {
                if ( $screen->id !== $target_screen && $screen->base !== $target_screen ) {
                    continue;
                }
            }

            // 2. Validar permisos (Role o Username)
            $permission = ! empty( $note['permission'] ) ? trim( $note['permission'] ) : 'administrator';
            $has_access = false;

            if ( in_array( $permission, (array) $current_user->roles, true ) ) {
                $has_access = true;
            } elseif ( strcasecmp( $current_user->user_login, $permission ) === 0 ) {
                $has_access = true;
            } elseif ( $permission === '*' || $permission === 'all' ) {
                $has_access = true;
            }

            if ( ! $has_access ) {
                continue;
            }

            // 3. Renderizar Notice
            $type_class = 'notice-' . ( in_array( $note['type'], [ 'info', 'warning', 'error', 'success' ], true ) ? $note['type'] : 'info' );
            ?>
            <div class="notice <?php echo esc_attr( $type_class ); ?> is-dismissible" style="padding-top: 10px; padding-bottom: 10px;">
                <?php if ( ! empty( $note['title'] ) ) : ?>
                    <p style="font-weight: 600; margin-bottom: 4px; font-size: 14px;">
                        📌 <?php echo esc_html( $note['title'] ); ?>
                    </p>
                <?php endif; ?>
                <?php if ( ! empty( $note['content'] ) ) : ?>
                    <div style="font-size: 13px; line-height: 1.5;">
                        <?php echo wp_kses_post( wpautop( $note['content'] ) ); ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php
        }
    }

    /**
     * Renderiza la página de administración
     */
    public static function render_admin_page() {
        $notes   = self::get_notes();
        $edit_id = isset( $_GET['edit'] ) ? sanitize_text_field( $_GET['edit'] ) : '';
        $editing = ( $edit_id && isset( $notes[ $edit_id ] ) ) ? $notes[ $edit_id ] : null;
        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">📌 <?php esc_html_e( 'Gestor de Notas Internas de Administración', 'vk7k-admin-notes' ); ?></h1>
            <hr class="wp-header-end">

            <?php if ( isset( $_GET['message'] ) ) : ?>
                <?php if ( $_GET['message'] === 'saved' ) : ?>
                    <div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Nota guardada exitosamente.', 'vk7k-admin-notes' ); ?></p></div>
                <?php elseif ( $_GET['message'] === 'deleted' ) : ?>
                    <div class="notice notice-info is-dismissible"><p><?php esc_html_e( 'Nota eliminada.', 'vk7k-admin-notes' ); ?></p></div>
                <?php elseif ( $_GET['message'] === 'error_empty' ) : ?>
                    <div class="notice notice-error is-dismissible"><p><?php esc_html_e( 'Debes ingresar un título o contenido para la nota.', 'vk7k-admin-notes' ); ?></p></div>
                <?php endif; ?>
            <?php endif; ?>

            <div style="display: flex; gap: 20px; margin-top: 20px; flex-wrap: wrap;">
                <!-- Formulario -->
                <div style="flex: 1; min-width: 320px; background: #fff; padding: 20px; border: 1px solid #ccd0d4; border-radius: 4px;">
                    <h2><?php echo $editing ? esc_html__( 'Editar Nota', 'vk7k-admin-notes' ) : esc_html__( 'Añadir Nueva Nota', 'vk7k-admin-notes' ); ?></h2>
                    <form method="post" action="">
                        <?php wp_nonce_field( 'vk7k_save_note_nonce' ); ?>
                        <input type="hidden" name="vk7k_notes_action" value="save_note">
                        <input type="hidden" name="note_id" value="<?php echo esc_attr( $editing['id'] ?? '' ); ?>">

                        <p>
                            <label for="note_title"><strong><?php esc_html_e( 'Título o Resumen:', 'vk7k-admin-notes' ); ?></strong></label><br>
                            <input type="text" id="note_title" name="note_title" value="<?php echo esc_attr( $editing['title'] ?? '' ); ?>" class="large-text" placeholder="Ej: Advertencia sobre actualización de productos" required>
                        </p>

                        <p>
                            <label for="note_content"><strong><?php esc_html_e( 'Contenido de la Nota:', 'vk7k-admin-notes' ); ?></strong></label><br>
                            <textarea id="note_content" name="note_content" rows="5" class="large-text" placeholder="Escribe el recordatorio o advertencia aquí..."><?php echo esc_textarea( $editing['content'] ?? '' ); ?></textarea>
                        </p>

                        <p>
                            <label for="note_screen"><strong><?php esc_html_e( 'Pantalla objetivo (Screen ID):', 'vk7k-admin-notes' ); ?></strong></label><br>
                            <input type="text" id="note_screen" name="note_screen" value="<?php echo esc_attr( $editing['screen'] ?? '' ); ?>" class="regular-text" placeholder="Ej: dashboard, edit-post, * (todas)">
                            <br><small style="color: #666;"><?php esc_html_e( 'Deja en blanco o escribe * para mostrar en todo el panel de administración.', 'vk7k-admin-notes' ); ?></small>
                        </p>

                        <p>
                            <label for="note_type"><strong><?php esc_html_e( 'Tipo de Aviso (Color):', 'vk7k-admin-notes' ); ?></strong></label><br>
                            <select id="note_type" name="note_type">
                                <option value="info" <?php selected( $editing['type'] ?? 'info', 'info' ); ?>><?php esc_html_e( 'Info (Azul)', 'vk7k-admin-notes' ); ?></option>
                                <option value="warning" <?php selected( $editing['type'] ?? 'info', 'warning' ); ?>><?php esc_html_e( 'Advertencia (Amarillo/Naranja)', 'vk7k-admin-notes' ); ?></option>
                                <option value="error" <?php selected( $editing['type'] ?? 'info', 'error' ); ?>><?php esc_html_e( 'Peligro / Error (Rojo)', 'vk7k-admin-notes' ); ?></option>
                                <option value="success" <?php selected( $editing['type'] ?? 'info', 'success' ); ?>><?php esc_html_e( 'Éxito (Verde)', 'vk7k-admin-notes' ); ?></option>
                            </select>
                        </p>

                        <p>
                            <label for="note_permission"><strong><?php esc_html_e( 'Permiso (Rol o Nombre de Usuario):', 'vk7k-admin-notes' ); ?></strong></label><br>
                            <input type="text" id="note_permission" name="note_permission" value="<?php echo esc_attr( $editing['permission'] ?? 'administrator' ); ?>" class="regular-text" placeholder="administrator, editor, o usuario_exacto">
                            <br><small style="color: #666;"><?php esc_html_e( 'Roles: administrator, editor, author, contributor. O escribe un username específico.', 'vk7k-admin-notes' ); ?></small>
                        </p>

                        <p>
                            <label>
                                <input type="checkbox" name="note_active" value="1" <?php checked( $editing['active'] ?? 1, 1 ); ?>>
                                <strong><?php esc_html_e( 'Nota Activa', 'vk7k-admin-notes' ); ?></strong>
                            </label>
                        </p>

                        <p>
                            <input type="submit" class="button button-primary" value="<?php echo $editing ? esc_attr__( 'Actualizar Nota', 'vk7k-admin-notes' ) : esc_attr__( 'Guardar Nota', 'vk7k-admin-notes' ); ?>">
                            <?php if ( $editing ) : ?>
                                <a href="<?php echo esc_url( admin_url( 'tools.php?page=vk7k-admin-notes' ) ); ?>" class="button"><?php esc_html_e( 'Cancelar', 'vk7k-admin-notes' ); ?></a>
                            <?php endif; ?>
                        </p>
                    </form>
                </div>

                <!-- Lista de Notas -->
                <div style="flex: 2; min-width: 320px;">
                    <h2><?php esc_html_e( 'Notas Existentes', 'vk7k-admin-notes' ); ?></h2>
                    <?php if ( empty( $notes ) ) : ?>
                        <p><?php esc_html_e( 'No hay notas registradas todavía.', 'vk7k-admin-notes' ); ?></p>
                    <?php else : ?>
                        <table class="widefat fixed striped">
                            <thead>
                                <tr>
                                    <th><?php esc_html_e( 'Título / Contenido', 'vk7k-admin-notes' ); ?></th>
                                    <th><?php esc_html_e( 'Pantalla', 'vk7k-admin-notes' ); ?></th>
                                    <th><?php esc_html_e( 'Permiso', 'vk7k-admin-notes' ); ?></th>
                                    <th><?php esc_html_e( 'Tipo', 'vk7k-admin-notes' ); ?></th>
                                    <th><?php esc_html_e( 'Estado', 'vk7k-admin-notes' ); ?></th>
                                    <th><?php esc_html_e( 'Acciones', 'vk7k-admin-notes' ); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ( $notes as $note ) : ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo esc_html( $note['title'] ); ?></strong>
                                            <div style="color: #666; font-size: 12px; margin-top: 4px;">
                                                <?php echo esc_html( wp_trim_words( strip_tags( $note['content'] ), 15 ) ); ?>
                                            </div>
                                        </td>
                                        <td><code><?php echo esc_html( ! empty( $note['screen'] ) ? $note['screen'] : '*' ); ?></code></td>
                                        <td><code><?php echo esc_html( $note['permission'] ); ?></code></td>
                                        <td><span class="badge" style="text-transform: capitalize;"><?php echo esc_html( $note['type'] ); ?></span></td>
                                        <td><?php echo ! empty( $note['active'] ) ? '🟢 Activa' : '⚪ Inactiva'; ?></td>
                                        <td>
                                            <a href="<?php echo esc_url( admin_url( 'tools.php?page=vk7k-admin-notes&edit=' . urlencode( $note['id'] ) ) ); ?>" class="button button-small"><?php esc_html_e( 'Editar', 'vk7k-admin-notes' ); ?></a>
                                            <a href="<?php echo esc_url( wp_nonce_url( admin_url( 'tools.php?page=vk7k-admin-notes&vk7k_delete_note=' . urlencode( $note['id'] ) ), 'vk7k_delete_note_' . $note['id'] ) ); ?>" class="button button-small button-link-delete" onclick="return confirm('¿Seguro que deseas eliminar esta nota?');"><?php esc_html_e( 'Eliminar', 'vk7k-admin-notes' ); ?></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
}

VK7K_Admin_Notes::init();
