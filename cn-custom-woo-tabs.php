<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://coderninja.in
 * @since             1.0.0
 * @package           Cn_Custom_Woo_Tabs
 *
 * @wordpress-plugin
 * Plugin Name:       Cn Custom Tabs
 * Plugin URI:        http://demo.coderninja.in/woo_custom_tabs/
 * Description:       Multiple Custom Tabs for WooCommerce Products.
 * Version:           1.2.0
 * Author:            shivam sharma
 * Author URI:        http://coderninja.in
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cn-custom-woo-tabs
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Define URL //
$path_array  = wp_upload_dir();
$upload_url=$path_array['baseurl'];
define( 'CN_CUSTOM_TABS_DIR', plugin_dir_path( __FILE__ ) );
define( 'CN_CUSTOM_TABS_URI', plugin_dir_url( __FILE__ ) );
define( 'CN_UPLOAD_URI', $upload_url);
// Define URL //

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CN_CUSTOM_WOO_TABS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cn-custom-woo-tabs-activator.php
 */
function activate_cn_custom_woo_tabs() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cn-custom-woo-tabs-activator.php';
	Cn_Custom_Woo_Tabs_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cn-custom-woo-tabs-deactivator.php
 */
function deactivate_cn_custom_woo_tabs() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cn-custom-woo-tabs-deactivator.php';
	Cn_Custom_Woo_Tabs_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cn_custom_woo_tabs' );
register_deactivation_hook( __FILE__, 'deactivate_cn_custom_woo_tabs' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cn-custom-woo-tabs.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cn_custom_woo_tabs() {

	$plugin = new Cn_Custom_Woo_Tabs();
	$plugin->run();

}
run_cn_custom_woo_tabs();
