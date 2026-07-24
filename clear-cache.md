# WP - Clear cloudflare and Varnish caché on update

´´´php
<?php
/**
 * Purga automática de Varnish y Cloudflare al guardar cambios
 */

// --- CONFIGURACIÓN DE CLOUDFLARE ---
define( 'CF_ZONE_ID', 'TU_ZONE_ID_AQUI' );
define( 'CF_API_TOKEN', 'TU_API_TOKEN_AQUI' );

add_action( 'save_post', 'auto_purge_varnish_and_cloudflare', 10, 3 );

function auto_purge_varnish_and_cloudflare( $post_id, $post, $update ) {
    // Evitar ejecuciones en guardados automáticos o revisiones
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( wp_is_post_revision( $post_id ) ) return;
    if ( get_post_status( $post_id ) !== 'publish' ) return;

    // URLs asociadas a la actualización
    $post_url = get_permalink( $post_id );
    $home_url = home_url( '/' );

    $urls_to_purge = array_unique( array( $home_url, $post_url ) );

    // 1. PURGA EN VARNISH (Servidor Local)
    foreach ( $urls_to_purge as $url ) {
        wp_remote_request( $url, array(
            'method'    => 'PURGE',
            'sslverify' => false,
            'timeout'   => 5,
        ) );
    }

    // 2. PURGA EN CLOUDFLARE (Vía API REST)
    if ( CF_ZONE_ID !== 'TU_ZONE_ID_AQUI' && CF_API_TOKEN !== 'TU_API_TOKEN_AQUI' ) {
        $cf_endpoint = "https://api.cloudflare.com/client/v4/zones/" . CF_ZONE_ID . "/purge_cache";

        // Purgar URLs específicas (Home + Página editada)
        $body = json_encode( array(
            'files' => array_values( $urls_to_purge )
        ) );

        // *Nota: Si prefieres que al guardar se limpie TODO Cloudflare en vez de solo las URLs editadas,
        // reentaza la línea de arriba por:
        // $body = json_encode( array( 'purge_everything' => true ) );

        wp_remote_post( $cf_endpoint, array(
            'headers' => array(
                'Authorization' => 'Bearer ' . CF_API_TOKEN,
                'Content-Type'  => 'application/json',
            ),
            'body'      => $body,
            'timeout'   => 5,
            'sslverify' => true,
        ) );
    }
}
´´´
