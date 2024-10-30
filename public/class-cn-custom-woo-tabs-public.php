<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://coderninja.in
 * @since      1.0.0
 *
 * @package    Cn_Custom_Woo_Tabs
 * @subpackage Cn_Custom_Woo_Tabs/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Cn_Custom_Woo_Tabs
 * @subpackage Cn_Custom_Woo_Tabs/public
 * @author     shivam sharma <shivamsharma.shivam2@gmail.com>
 */
class Cn_Custom_Woo_Tabs_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $tab_data = false;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$query = new Cn_Custom_Woo_Tabs_Query();
		$this->query=$query;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cn_Custom_Woo_Tabs_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cn_Custom_Woo_Tabs_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cn-custom-woo-tabs-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cn_Custom_Woo_Tabs_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cn_Custom_Woo_Tabs_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cn-custom-woo-tabs-public.js', array( 'jquery' ), $this->version, false );

	}

	public function add_cn_custom_woo_tabs($tabs ) { 
    	global $product;
		if ($this->product_has_custom_tabs($product) ) {
			//print_r($this->tab_data);
			foreach ($this->tab_data as $tab ) {
				$tab_title = __( $tab['title'], 'woocommerce-custom-product-tabs-lite' );
				
				$tabs[ $tab['id'] ] = array(
					'title'    => apply_filters( 'add_cn_custom_woo_tabs_title', $tab_title, $product, $this ),
					'priority' => 25,
					'callback' => array( $this, 'custom_product_tabs_panel_content' ),
					'content'  => $tab['content'],  // custom field
				);
			}
		}
		return $tabs;
	} 
	private function product_has_custom_tabs( $product ) {
		if (false === $this->tab_data ) {
			$this->tab_data = maybe_unserialize( $product->get_meta( 'cn_woo_products_tabs', true, 'edit' ) );
		}
		return ! empty( $this->tab_data ); //&& ! empty( $this->tab_data[0] ) && ! empty( $this->tab_data[0]['title'] );
	}

	public function custom_product_tabs_panel_content( $key, $tab ) {

		// allow shortcodes to function
		$allowed_html = [
						'a'=> ['href'=> [],
						'title' => [],],
						'br'=> [],
						'h1'=> [],
						'h2'=> [],
						'h3'=> [],
						'em'=> [],
						'strong' => [],
					];
		$content = apply_filters( 'the_content', $tab['content'] );
		$content = str_replace( ']]>', ']]&gt;', $content );

		echo apply_filters( 'cn_custom_woo_tabs_heading', '<h2>' . $tab['title'] . '</h2>', $tab );
		echo apply_filters( 'cn_custom_woo_tabs_content', wp_kses($content,$allowed_html), $tab );
	}
         
}
