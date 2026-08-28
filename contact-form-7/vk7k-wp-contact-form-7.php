<?php
/**
 * Plugin Name: VK7K Contact Form 7 Redirect
 * Plugin URI:  https://github.com/vk7k/wp-snippets
 * Description: Redirecciona al usuario a URLs específicas o páginas de agradecimiento tras el envío exitoso en Contact Form 7.
 * Version:     1.0.0
 * Author:      Victor Mellado (vk7k)
 * Author URI:  https://victormellado.cl
 * License:     MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: vk7k-cf7-redirect
 */

defined( 'ABSPATH' ) || exit;

/**
 * Inyecta el script de redirección de Contact Form 7 en el pie de página
 */
add_action( 'wp_footer', function() {
    ?>
    <script>
    document.addEventListener('wpcf7mailsent', function(event) {
        
        // ============================================================
        // 1. Configuración de Rutas de Redirección: 'ID_Formulario': 'URL_o_Ruta_Destino'
        // ============================================================
        const redirectRoutes = {
            '2665': 'https://tusitio.com/?p=3330',      // Formulario ID 2665 -> URL o ID
            '2339': 'https://tusitio.com/gracias/',     // Formulario ID 2339 -> Slug o página
            // 'POST_ID_CF7': 'https://tusitio.com/pagina-destino/'
        };

        // 2. Mensaje de éxito visual (opcional)
        const successMessageInnerText = '📧✔ Redirigiendo...';

        // 3. Retardo en segundos antes de redirigir
        const delayInSecondsAfterSent = 2;

        const submittedForm = String(event.detail.contactFormId);
        
        if (Object.prototype.hasOwnProperty.call(redirectRoutes, submittedForm)) {
            const targetUrl = redirectRoutes[submittedForm];
            
            const successMessage = document.querySelector('.wpcf7-response-output');
            if (successMessage) {
                successMessage.style.color = '#2a5b74';
                successMessage.innerText = successMessageInnerText;
            }
            
            // Retardo antes de la redirección
            setTimeout(function() {
                window.location.href = targetUrl;
            }, delayInSecondsAfterSent * 1000);
        }
        
    }, false);
    </script>
    <?php
}, 99 );
