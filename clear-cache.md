# WP - Clear cloudflare and Varnish caché on update

```php
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
```


##Dónde obtener las credenciales de Cloudflare
Para que el script se comunique con Cloudflare, debes reemplazar las dos constantes al inicio del código:

## CF_ZONE_ID:

Entra al panel de Cloudflare y selecciona el dominio fernandoaylwin.cl.

En la pestaña Overview (Información general), baja en la columna de la derecha hasta la sección API. Ahí verás tu Zone ID.

## CF_API_TOKEN:

Haz clic en el ícono de tu perfil (arriba a la derecha en Cloudflare) > My Profile > API Tokens.

Haz clic en Create Token.

Usa la plantilla Cache Purge (o crea uno personalizado con el permiso Zone - Cache Purge - Edit).

Selecciona el dominio correspondiente, genera el Token y cópialo.

## Ventajas de esta solución
Cero bloatware: Eliminas el plugin "Proxy Cache Purge", liberando memoria y quitando menús innecesarios del panel.
Proceso silencioso: Trabaja en segundo plano sin interfaces molestas ni llamadas externas comerciales.
Precisión: Al actualizar una página (como el Home), borra inmediatamente el caché de Varnish y manda la instrucción por API a Cloudflare en un solo disparo.
