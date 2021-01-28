<?php
/**
 * Plugin Name:       WP Reactr
 * Plugin URI:        https://github.com/patrickposner/wp-reactr
 * Description:       React boilerplate for WordPress plugins
 * Version:           0.1.0
 * Author:            Patrick Posner
 * Author URI:        https://patrickposner.dev/
 * Text Domain:       wp-reactr
 * License:           GPL-3.0
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WPR_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'WPR_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );

// localize.
$textdomain_dir = plugin_basename( dirname( __FILE__ ) ) . '/languages';
load_plugin_textdomain( 'wp-headless-experiments', false, $textdomain_dir );


// run autoloader.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

/**
 * Initialize WP Reactr Plugin
 *
 * @since 1.0.0
 */
function wpreactr_init() {
	wpreactr\WPR_Shortcode::get_instance();
	wpreactr\WPR_Rest_Route::get_instance();
}
add_action( 'plugins_loaded', 'wpreactr_init' );
