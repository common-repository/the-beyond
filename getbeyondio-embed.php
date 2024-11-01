<?php
/**
 * Plugin Name: The Beyond for WordPress
 * Plugin URI: https://help.beyondpage.info/s/cUJ?ref=wp_org
 * Version: 0.1.0
 * Author: getbeyond.io
 * Author URI: https://www.getbeyond.io/?ref=wp_org
 * Description: <a href="https://www.getbeyond.io/?ref=wp_org"><strong>The Beyond</strong></a> is the flexible space for all your FAQ, Terms of Conditions, comprehensive product documentation and all sorts of unexciting but necessary content. In <strong>Beyond</strong>, your content is easily maintainable, which also helps you reduce support load. <a href="https://www.getbeyond.io/signup.html?ref=wp_org" target="_blank">Register your Beyond account here</a>.
 * Text Domain: getbeyondio
 * Domain Path: /languages
 * License: GPL2
 *
 * @author Daniel Sitek <dan.sitek@gmail.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

if ( ! defined( 'GETBEYONDIO_PLUGIN_VERSION' ) ) {
	define( 'GETBEYONDIO_PLUGIN_VERSION', '0.1.0' );
}

if ( ! defined( 'GETBEYONDIO_PLUGIN_ABSPATH' ) ) {
	define( 'GETBEYONDIO_PLUGIN_ABSPATH', trailingslashit( __DIR__ ) );
}


if ( ! function_exists( 'getbeyondio_embed_plugin_shortcode' ) ) :
/**
 * Create Shortcode [getbeyond href="url"]Link title[/getbeyond]
 *
 * @param array  $atts
 * @param string $content
 * @return void
 */
function getbeyondio_embed_plugin_shortcode( $atts, $content = null ) {

    $atts = shortcode_atts(
        array(
            'href' => null,
        ),
        $atts,
        'getbeyond'
    );

    $href = esc_url( $atts['href'] );
    $title = sanitize_text_field( $content );
    $content = sanitize_text_field( $content );
    
    if ( empty($content) || empty($href) ) {
        return;
    }

    $linkHtml = '<a href="%1$s" data-beyond title="%2$s" target="_blank">%3$s</a>';
    return sprintf( $linkHtml, $href, $title, $content );
}

add_shortcode( 'getbeyond', 'getbeyondio_embed_plugin_shortcode' );

endif;


if ( ! function_exists( 'getbeyondio_embed_plugin_js' ) ) :
/**
 * Load plugin js file.
 *
 * @return void
 */
function getbeyondio_embed_plugin_js() {

    $file = plugins_url( 'src/embed.js', __FILE__ );

    wp_register_script( 'getbeyondio_embed_js', $file, array(), GETBEYONDIO_PLUGIN_VERSION, true );
    wp_enqueue_script( 'getbeyondio_embed_js' );
}

add_action( 'wp_enqueue_scripts', 'getbeyondio_embed_plugin_js' );

endif;


if ( ! function_exists( 'getbeyondio_embed_plugin_admin_js' ) ) :
/**
 * Load admin js file.
 *
 * @return void
 */
function getbeyondio_embed_plugin_admin_js() {

    $file = plugins_url( 'src/admin.js', __FILE__ );

    wp_register_script( 'getbeyondio_admin_js', $file, array( 'jquery' ), GETBEYONDIO_PLUGIN_VERSION, true );
    $config = array(
        'msg' => array(
            'url'  => __( 'Enter the article URL from Beyond. Use shortened link.', 'getbeyondio' ),
            'title' => __( 'Enter the title.', 'getbeyondio' ),
        )
    );
    wp_localize_script( 'getbeyondio_admin_js', 'getbeyondioAdminJs', $config );
    wp_enqueue_script( 'getbeyondio_admin_js' );
}

add_action( 'admin_enqueue_scripts', 'getbeyondio_embed_plugin_admin_js' );

endif;


if ( ! function_exists( 'getbeyondio_embed_plugin_media_button' ) ) :
/**
 * Add button before wysiwyg window
 *
 * @param string $editor_id
 * @return void
 */
function getbeyondio_embed_plugin_media_button( $editor_id ) {

    $img = '<span class="wp-media-buttons-icon">';
    $img .= '<svg style="display: block; width: 100%; height: auto;" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><path d="M33.727 5.06c10.592 0 14.757 11.545 8.18 17.85 9.038 6.56 4.075 20.03-7.455 20.03H20.146V26.126h-6.26C10.883 33.18.572 30.95.572 23.33c0-7.9 10.43-9.575 13.317-2.79h6.26V5.06h13.58zm-6.73 32.295l7.455.015c7.958 0 7.92-11.245-.038-11.245h-7.418v11.23zm0-26.71v9.894h6.73c6.874 0 6.874-9.894 0-9.894h-6.73z" fill="#D20036" fill-rule="evenodd"/></svg>';
    $img .= '</span> ';

    echo sprintf( '<button type="button" class="button insert-getbeoynd-link js-insert-getbeyond-link" data-editor="%1$s">%2$s</button>',
        esc_attr( $editor_id ),
        $img . __( 'Insert Beyond Link', 'getbeyondio' )
    );
}

add_action( 'media_buttons', 'getbeyondio_embed_plugin_media_button' );

endif;
