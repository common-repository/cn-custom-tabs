<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://coderninja.in
 * @since      1.0.0
 *
 * @package    Cn_Custom_Woo_Tabs
 * @subpackage Cn_Custom_Woo_Tabs/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Cn_Custom_Woo_Tabs
 * @subpackage Cn_Custom_Woo_Tabs/includes
 * @author     shivam sharma <shivamsharma.shivam2@gmail.com>
 */
class Cn_Custom_Woo_Tabs_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'cn-custom-woo-tabs',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
