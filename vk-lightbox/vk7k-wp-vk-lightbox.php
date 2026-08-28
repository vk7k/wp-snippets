<?php
/**
 * Plugin Name: VK7K Lightbox
 * Plugin URI:  https://github.com/vk7k/wp-snippets
 * Description: Lightbox flotante responsivo que muestra páginas en un iframe mediante enlaces con rel="vk7k-lightbox".
 * Version:     1.0.0
 * Author:      Victor Mellado (vk7k)
 * Author URI:  https://victormellado.cl
 * License:     MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: vk7k-lightbox
 */

defined( 'ABSPATH' ) || exit;

add_action('wp_footer', function () {
    ?>
    <!-- HTML del Lightbox -->
    <div class="vk7k-lightbox" style="display: none;">
        <div class="vk7k-lightbox-floating-bar">
            <div>
                <button class="vk7k-lightbox-closebutton" aria-label="Cerrar">&times;</button>
            </div>
        </div> 
        <a href="#" class="vk7k-lightbox-prev" aria-label="Anterior"></a>
        <div class="vk7k-lightbox-inner">
            <iframe class="vk7k-lightbox-iframe"></iframe>
        </div> 
        <a href="#" class="vk7k-lightbox-next" aria-label="Siguiente"></a>
    </div>

    <!-- CSS del Lightbox -->
    <style>
        .vk7k-lightbox-floating-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 60px;
            width: 100vw;
            text-align: center;
            background-color: black;
            z-index: 10005;
        }

        .vk7k-lightbox-floating-bar div {
            width: 100%;
            max-width: 720px;
            margin: auto;
            text-align: right;
        }

        .vk7k-lightbox {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            overflow: auto; /* Permitir scroll en todo el lightbox */
        }

        .vk7k-lightbox-inner {
            position: relative;
            max-width: 650px;
            width: 100%;
            min-width: 300px;
            background: #fff;
            margin-top: 120px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .vk7k-lightbox-iframe {
            width: 100%;
            height: auto; /* Altura ajustable */
            border: none;
            border-radius: 5px;
        }

        .vk7k-lightbox-closebutton {
            font-size: 26px;
            color: white;
            border: 0;
            background-color: black;
            margin: 8px 16px;
            cursor: pointer;
        }

        .vk7k-lightbox-closebutton:hover {
            background: #333;
        }

        .vk7k-lightbox-prev, .vk7k-lightbox-next {
            position: fixed;
            transform: translateY(40vh);
            background: white;
            color: #333;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10002;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-decoration: none;
        }

        .vk7k-lightbox-prev {
            left: 20px;
        }

        .vk7k-lightbox-next {
            right: 20px;
        }

        .vk7k-lightbox-prev::before, .vk7k-lightbox-next::before {
            content: '';
            display: block;
            width: 0;
            height: 0;
            border-style: solid;
        }

        .vk7k-lightbox-prev::before {
            border-width: 10px 15px 10px 0;
            border-color: transparent #333 transparent transparent;
        }

        .vk7k-lightbox-next::before {
            border-width: 10px 0 10px 15px;
            border-color: transparent transparent transparent #333;
        }

        .vk7k-lightbox-prev:hover, .vk7k-lightbox-next:hover {
            background: #f0f0f0;
        }

        @media (max-width: 768px) {
            .vk7k-lightbox-prev, .vk7k-lightbox-next {
                font-size: 20px;
            }
        }

        /* Spinner de precarga */
        .vk7k-lightbox-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid orange;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            z-index: 10000;
        }

        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }
    </style>

    <!-- JavaScript del Lightbox -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const lightbox = document.querySelector('.vk7k-lightbox');
            if (!lightbox) return;

            const iframe = lightbox.querySelector('.vk7k-lightbox-iframe');
            const closeButton = lightbox.querySelector('.vk7k-lightbox-closebutton');
            const prevButton = lightbox.querySelector('.vk7k-lightbox-prev');
            const nextButton = lightbox.querySelector('.vk7k-lightbox-next');
            const spinner = document.createElement('div');
            spinner.className = 'vk7k-lightbox-spinner';
            lightbox.appendChild(spinner);

            let links = Array.from(document.querySelectorAll('a[rel="vk7k-lightbox"]'));
            let currentIndex = -1;

            // Función para mostrar el lightbox
            function openLightbox(index) {
                currentIndex = index;
                const url = links[currentIndex].getAttribute('href');
                iframe.src = url;
                lightbox.style.display = 'flex';
                spinner.style.display = 'block';
                updateNavigation();
                document.body.style.overflow = 'hidden'; // Evitar scroll en el fondo
            }

            // Función para actualizar botones de navegación
            function updateNavigation() {
                prevButton.style.display = currentIndex > 0 ? 'flex' : 'none';
                nextButton.style.display = currentIndex < links.length - 1 ? 'flex' : 'none';
            }

            // Función para cerrar el lightbox
            function closeLightbox() {
                lightbox.style.display = 'none';
                iframe.src = '';
                document.body.style.overflow = 'auto'; // Restaurar scroll en el fondo
            }

            function monitorIframeHeight() {
                iframe.onload = function () {
                    adjustIframeHeight();
                    spinner.style.display = 'none';
                };

                function adjustIframeHeight() {
                    try {
                        const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                        if (iframeDoc) {
                            const height = iframeDoc.documentElement.scrollHeight + 160;
                            iframe.style.height = `${height}px`;
                            const lightboxInner = document.querySelector('.vk7k-lightbox-inner');
                            if (lightboxInner) {
                                lightboxInner.style.height = `${height}px`;
                            }
                        }
                    } catch (error) {
                        // Acceso cross-origin restringido, usar altura por defecto
                        iframe.style.height = '80vh';
                    }
                }
            }

            // Eventos en los enlaces
            links.forEach((link, index) => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    openLightbox(index);
                    monitorIframeHeight();
                });
            });

            // Eventos de navegación
            prevButton.addEventListener('click', function (e) {
                e.preventDefault();
                if (currentIndex > 0) openLightbox(currentIndex - 1);
            });

            nextButton.addEventListener('click', function (e) {
                e.preventDefault();
                if (currentIndex < links.length - 1) openLightbox(currentIndex + 1);
            });

            // Evento para cerrar
            closeButton.addEventListener('click', closeLightbox);
            lightbox.addEventListener('click', function (e) {
                if (e.target === lightbox) closeLightbox();
            });
        });
    </script>
    <?php
});
