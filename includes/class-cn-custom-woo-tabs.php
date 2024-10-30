<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://coderninja.in
 * @since      1.0.0
 *
 * @package    Cn_Custom_Woo_Tabs
 * @subpackage Cn_Custom_Woo_Tabs/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Cn_Custom_Woo_Tabs
 * @subpackage Cn_Custom_Woo_Tabs/includes
 * @author     shivam sharma <shivamsharma.shivam2@gmail.com>
 */
class Cn_Custom_Woo_Tabs {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Cn_Custom_Woo_Tabs_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'CN_CUSTOM_WOO_TABS_VERSION' ) ) {
			$this->version = CN_CUSTOM_WOO_TABS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'cn-custom-woo-tabs';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Cn_Custom_Woo_Tabs_Loader. Orchestrates the hooks of the plugin.
	 * - Cn_Custom_Woo_Tabs_i18n. Defines internationalization functionality.
	 * - Cn_Custom_Woo_Tabs_Admin. Defines all hooks for the admin area.
	 * - Cn_Custom_Woo_Tabs_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cn-custom-woo-tabs-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cn-custom-woo-tabs-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-cn-custom-woo-tabs-admin.php';

		/**
		 * The class responsible for defining all sql query
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cn-custom-woo-tabs-query.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-cn-custom-woo-tabs-public.php';

		$this->loader = new Cn_Custom_Woo_Tabs_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Cn_Custom_Woo_Tabs_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Cn_Custom_Woo_Tabs_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Cn_Custom_Woo_Tabs_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		// $this->loader->add_action( 'admin_menu', $plugin_admin, 'cn_custom_woo_tabs_plugin_menu' );
		///
		$this->loader->add_action( 'woocommerce_product_write_panel_tabs', $plugin_admin, 'render_cn_custom_tabs') ;
		$this->loader->add_action( 'woocommerce_product_data_panels', $plugin_admin, 'product_page_custom_tabs_panel');
		$this->loader->add_action( 'woocommerce_process_product_meta', $plugin_admin, 'save_tab_data', 10, 2 );
		// $this->loader->add_action( 'admin_notices',$plugin_admin, 'my_error_notice' );
		
		// add_filter //
		$this->loader->add_filter( 'wp_default_editor', create_function('', 'return "tinymce";'));
		$this->loader->add_filter( 'mce_buttons_2', 'cn_custom_woo_tabs_editor_font_buttons' );



	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Cn_Custom_Woo_Tabs_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_filter( 'woocommerce_product_tabs', $plugin_public , 'add_cn_custom_woo_tabs'  );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Cn_Custom_Woo_Tabs_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
