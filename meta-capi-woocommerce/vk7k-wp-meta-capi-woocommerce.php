<?php
/**
 * Plugin Name: VK7K Meta CAPI for WooCommerce
 * Plugin URI:  https://github.com/vk7k/wp-snippets
 * Description: Captura cookies de Meta (_fbp, _fbc), IP y User Agent al crear pedidos en WooCommerce y envía eventos Purchase a Meta Conversions API (CAPI) al completar la orden.
 * Version:     1.0.0
 * Author:      Victor Mellado (vk7k)
 * Author URI:  https://victormellado.cl
 * License:     MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: vk7k-meta-capi-woo
 */

defined( 'ABSPATH' ) || exit;

// ============================================================
// SNIPPET 1 - Capturar fbp/fbc/IP/UA al crear pedido
// ============================================================
add_action( 'woocommerce_checkout_create_order', function( $order, $data ) {
    $fbp = isset( $_COOKIE['_fbp'] ) ? sanitize_text_field( $_COOKIE['_fbp'] ) : '';
    $fbc = isset( $_COOKIE['_fbc'] ) ? sanitize_text_field( $_COOKIE['_fbc'] ) : '';
    $ip  = '';
    if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
        $ip = explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] )[0];
    } else {
        $ip = isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : '';
    }
    $ua = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] ) : '';
    $order->update_meta_data( '_meta_fbp', $fbp );
    $order->update_meta_data( '_meta_fbc', $fbc );
    $order->update_meta_data( '_meta_client_ip', sanitize_text_field( $ip ) );
    $order->update_meta_data( '_meta_client_ua', $ua );
}, 10, 2 );

// ============================================================
// SNIPPET 2 - Purchase a Meta CAPI al completar pedido
// ============================================================
add_action( 'woocommerce_order_status_completed', function( $order_id ) {

    // Ruta del log configurable
    $upload_dir = wp_upload_dir();
    $log_file   = $upload_dir['basedir'] . '/meta-capi-woo.log';
    
    if ( ! file_exists( $log_file ) ) {
        file_put_contents( $log_file, '' );
        chmod( $log_file, 0640 );
    }

    $log = function( $mensaje ) use ( $log_file ) {
        file_put_contents(
            $log_file,
            date('Y-m-d H:i:s') . ' | ' . $mensaje . "\n",
            FILE_APPEND
        );
    };

    $log( "Pedido completado: #{$order_id}" );

    $order = wc_get_order( $order_id );
    if ( ! $order ) {
        $log( "ERROR: No se pudo obtener el pedido #{$order_id}." );
        return;
    }

    if ( $order->get_meta( '_meta_capi_sent' ) === 'yes' ) {
        $log( "AVISO: Evento ya enviado anteriormente para pedido #{$order_id}. Saliendo." );
        return;
    }

    if ( str_contains( $order->get_billing_email(), '+test' ) ) {
        $log( "AVISO: Email de prueba detectado (+test), saliendo sin enviar a CAPI." );
        return;
    }

    // Configuración de credenciales Meta CAPI
    $access_token = 'TU_META_ACCESS_TOKEN_AQUI';
    $pixel_id     = 'TU_PIXEL_ID_AQUI';

    $email = hash( 'sha256', strtolower( trim( $order->get_billing_email() ) ) );
    $phone = hash( 'sha256', preg_replace( '/\D/', '', $order->get_billing_phone() ) );
    $fn    = hash( 'sha256', strtolower( trim( $order->get_billing_first_name() ) ) );
    $ln    = hash( 'sha256', strtolower( trim( $order->get_billing_last_name() ) ) );

    $fbp = $order->get_meta( '_meta_fbp' );
    $fbc = $order->get_meta( '_meta_fbc' );
    $ip  = $order->get_meta( '_meta_client_ip' );
    $ua  = $order->get_meta( '_meta_client_ua' );

    $log( "Cliente: " . $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() . " | Email: " . $order->get_billing_email() );
    $log( "Total: " . $order->get_total() . " " . $order->get_currency() );
    $log( "Cookies FB — fbp:" . ( $fbp ?: 'vacío' ) . " | fbc:" . ( $fbc ?: 'vacío' ) );

    $items         = $order->get_items();
    $content_ids   = [];
    $content_names = [];
    foreach ( $items as $item ) {
        $content_ids[]   = (string) $item->get_product_id();
        $content_names[] = $item->get_name();
    }

    $log( "Productos: " . implode( ', ', $content_names ) );

    $payload = [
        'data' => [
            [
                'event_name'    => 'Purchase',
                'event_time'    => time(),
                'event_id'      => 'woo_' . $order_id,
                'action_source' => 'website',
                'user_data'     => [
                    'em'                => [ $email ],
                    'ph'                => [ $phone ],
                    'fn'                => [ $fn ],
                    'ln'                => [ $ln ],
                    'fbp'               => $fbp,
                    'fbc'               => $fbc,
                    'client_ip_address' => $ip,
                    'client_user_agent' => $ua,
                ],
                'custom_data'   => [
                    'currency'     => $order->get_currency() ?: 'CLP',
                    'value'        => floatval( $order->get_total() ),
                    'order_id'     => $order_id,
                    'content_ids'  => $content_ids,
                    'content_name' => implode( ', ', $content_names ),
                    'content_type' => 'product',
                ],
            ],
        ],
    ];

    $log( "Enviando payload a Meta CAPI..." );

    $response = wp_remote_post(
        "https://graph.facebook.com/v19.0/{$pixel_id}/events?access_token={$access_token}",
        [
            'headers'   => [ 'Content-Type' => 'application/json' ],
            'body'      => wp_json_encode( $payload ),
            'timeout'   => 15,
            'blocking'  => true,
            'sslverify' => true,
        ]
    );

    if ( is_wp_error( $response ) ) {
        $log( "ERROR WP: " . $response->get_error_message() );
    } else {
        $code = wp_remote_retrieve_response_code( $response );
        $body = wp_remote_retrieve_body( $response );
        $log( "Respuesta HTTP {$code}: {$body}" );
    }

    $order->update_meta_data( '_meta_capi_sent', 'yes' );
    $order->save();

    $log( "--- FIN ---" );

}, 10 );
