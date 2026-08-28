<?php
/**
 * Plugin Name: VK7K Gutenberg Justify Button
 * Plugin URI:  https://github.com/vk7k/wp-snippets
 * Description: Añade el botón de justificar a nivel de bloque (Párrafo y Encabezado) en el editor Gutenberg de WordPress.
 * Version:     1.0.0
 * Author:      Victor Mellado (vk7k) & Gemini
 * Author URI:  https://victormellado.cl
 * License:     MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: vk7k-justify-text
 */

defined( 'ABSPATH' ) || exit;

// Enqueue CSS (Same selectors as V12, targeting the class on the block)
add_action( 'enqueue_block_editor_assets', 'vk7k_justify_enqueue_editor_styles' );
function vk7k_justify_enqueue_editor_styles() {
    // Specificity for editor + !important
    $editor_css = ".editor-styles-wrapper p.has-text-align-justify, .editor-styles-wrapper h1.has-text-align-justify, .editor-styles-wrapper h2.has-text-align-justify, .editor-styles-wrapper h3.has-text-align-justify, .editor-styles-wrapper h4.has-text-align-justify, .editor-styles-wrapper h5.has-text-align-justify, .editor-styles-wrapper h6.has-text-align-justify { text-align: justify !important; }";
    // Fallback for potential structure changes or other block types if needed
    $editor_css .= " .has-text-align-justify { text-align: justify !important; }";
    wp_add_inline_style( 'wp-block-editor', $editor_css );
}

add_action( 'wp_enqueue_scripts', 'vk7k_justify_add_frontend_styles' );
function vk7k_justify_add_frontend_styles() {
    // Apply to paragraph or generally
    $frontend_css = "p.has-text-align-justify, h1.has-text-align-justify, h2.has-text-align-justify, h3.has-text-align-justify, h4.has-text-align-justify, h5.has-text-align-justify, h6.has-text-align-justify { text-align: justify !important; }";
    $frontend_css .= " .has-text-align-justify { text-align: justify !important; }"; // General fallback
    wp_add_inline_style( 'wp-block-library', $frontend_css );
}

// Main logic via footer script
add_action( 'admin_print_footer_scripts', 'vk7k_justify_add_button_via_footer', 999 );

function vk7k_justify_add_button_via_footer() {
    // Only run on block editor screens
    $screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
    if ( ! $screen || ! method_exists( $screen, 'is_block_editor' ) || ! $screen->is_block_editor() ) {
        return;
    }
    ?>
    <script>
        wp.domReady( function() {
            setTimeout(function() {
                // Check necessary components
                if ( typeof wp === 'undefined' || !wp.data || !wp.element || !wp.blockEditor || !wp.components || !wp.i18n || !wp.blocks || typeof wp.data.select !== 'function' || typeof wp.data.dispatch !== 'function' ) {
                    return;
                }

                var el = wp.element.createElement;
                var BlockControls = wp.blockEditor.BlockControls;
                var ToolbarGroup = wp.components.ToolbarGroup;
                var ToolbarButton = wp.components.ToolbarButton;
                var JustifyIcon = el( 'svg', { width: 24, height: 24, viewBox: '0 0 24 24' },
                    el( 'path', { d: 'M4 21h16v-2H4v2zm0-4h16v-2H4v2zm0-4h16v-2H4v2zm0-4h16V7H4v2zm0-4h16V3H4v2z' } )
                );
                var __ = wp.i18n.__;

                // --- Filter Block Types to Add Our Control ---
                const allowedBlocks = [ 'core/paragraph', 'core/heading' ];

                wp.hooks.addFilter(
                    'editor.BlockEdit',
                    'vk7k/add-justify-toolbar-button',
                    function ( BlockEdit ) {
                        return function ( props ) {
                            if ( allowedBlocks.includes( props.name ) && props.isSelected ) {
                                const { attributes, setAttributes } = props;
                                const { className } = attributes;

                                const hasJustify = className && className.includes('has-text-align-justify');

                                return el(
                                    wp.element.Fragment,
                                    {},
                                    el( BlockEdit, props ),
                                    el( BlockControls,
                                        { group: 'block' },
                                        el( ToolbarGroup, null,
                                            el( ToolbarButton, {
                                                icon: JustifyIcon,
                                                title: __( 'Justify', 'vk7k-justify-text' ),
                                                onClick: function() {
                                                    let nextClassName = className || '';
                                                    if ( hasJustify ) {
                                                        nextClassName = nextClassName.replace( /has-text-align-justify/g, '' ).replace( /\s\s+/g, ' ' ).trim();
                                                    } else {
                                                        nextClassName = nextClassName.replace( /has-text-align-(left|center|right)/g, '' ).replace( /\s\s+/g, ' ' ).trim();
                                                        nextClassName = nextClassName ? nextClassName + ' has-text-align-justify' : 'has-text-align-justify';
                                                    }
                                                    setAttributes( { className: nextClassName } );
                                                },
                                                isActive: hasJustify,
                                            } )
                                        )
                                    )
                                );
                            }
                            return el( BlockEdit, props );
                        };
                    }
                );
            }, 300);
        });
    </script>
    <?php
}