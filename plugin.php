<?php
/**
 * Plugin Name: gutenberg-sidebar
 * Plugin URI: https://alialaa.com/
 * Description: Sidebar for the block editor.
 * Author: Ali Alaa
 * Author URI: https://alialaa.com/
 */

if( ! defined( 'ABSPATH') ) {
    exit;
}

include_once('src/metabox.php');

function myprefix_enqueue_assets() {
    wp_enqueue_script(
        'myprefix-gutenberg-sidebar',
        plugins_url( 'build/index.js', __FILE__ ),
        array( 'wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data' )
    );
}
add_action( 'enqueue_block_editor_assets', 'myprefix_enqueue_assets' );