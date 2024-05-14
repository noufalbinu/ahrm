<?php
/**
 * @package vBookPackages
 * @version 1.0
 */
/*
Plugin Name: AdroitHRM
Plugin URI: https://www.wpadroit.com/plugins/ahrm
Description: .
Author: Noufal Binu
Version: 1.0.0
Author URI: https://www.wpadroit.com/
Text Domain: vBook
*/


// If this file is called firectly, abort!!!
defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );
// Require once the Composer Autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}
/**
 * The code that runs during plugin activation
 */
function activate_zon_packages() {
	Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_zon_packages' );
/**
 * The code that runs during plugin deactivation
 */
function deactivate_zon_packages() {
	Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_zon_packages' );
/**
 * Initialize all the core classes of the plugin
 */
if ( class_exists( 'Inc\\Init' ) ) {
	Inc\Init::registerServices();
}


/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function vbook_vbook_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'vbook_vbook_block_init' );


/**
 * Custom Block Category
 */
function wpdocs_filter_block_categories_when_post_provided( $block_categories, $editor_context ) {
    if ( ! empty( $editor_context->post ) ) {
        array_push(
            $block_categories,
            array(
                'slug'  => 'vbook',
                'title' => __( 'vbook', 'vbook' ),
                'icon'  => null,
            )
        );
    }
    return $block_categories;
}

add_filter( 'block_categories_all', 'wpdocs_filter_block_categories_when_post_provided', 1, 12 );