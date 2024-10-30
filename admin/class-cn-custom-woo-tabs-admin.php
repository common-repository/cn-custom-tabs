<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://coderninja.in
 * @since      1.0.0
 *
 * @package    Cn_Custom_Woo_Tabs
 * @subpackage Cn_Custom_Woo_Tabs/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cn_Custom_Woo_Tabs
 * @subpackage Cn_Custom_Woo_Tabs/admin
 * @author     shivam sharma <shivamsharma.shivam2@gmail.com>
 */
class Cn_Custom_Woo_Tabs_Admin {

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

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$query = new Cn_Custom_Woo_Tabs_Query();
		$this->query=$query;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cn-custom-woo-tabs-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script($this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cn-custom-woo-tabs-admin.js', array( 'jquery' ), $this->version, false );

		global $post;
			if ( $post->post_type === 'product' ) {
				// Enqueue WordPress' built-in editor functions - added in WPv4.8
				if ( function_exists( 'wp_enqueue_editor' ) ) {
					wp_enqueue_editor();
				}
				// styles
				wp_enqueue_style( 'custom-tabs-styles' , plugin_dir_url( __FILE__ ) .'assets/tabs/custom-tabs.css', '', '', 'all' );
				wp_enqueue_script('custom-tabs', plugin_dir_url( __FILE__ ) . 'assets/tabs/custom-tabs.js', array( 'jquery' ), '');
			}
		

	}

	public function cn_custom_woo_tabs_plugin_menu(){
		add_submenu_page('woocommerce', 'Cn Custom Tabs', 'Cn Custom Tabs', 'manage_options', 'cn-custom-woo-tabs', array($this, 'cn_custom_woo_tabs_menu'));
	}
	public function cn_custom_woo_tabs_menu(){
	}

	/**
	 * Register the Custom Tabs Title
	 *
	 * @since    1.0.0
	 */
	public function render_cn_custom_tabs() {
		echo "<li class=\"wc_product_tabs_tab\">
		<a href=\"#woocommerce_custom_product_tabs\"><span>" . __( 'Cn Custom Tabs') . "</span></a></li>";
	}
	/**
	 * Register the Custom Tabs panel
	 *
	 * @since    1.0.0
	 */
	public function product_page_custom_tabs_panel() {
		global $post;
		$post->ID;
		$tab_data = maybe_unserialize( get_post_meta( $post->ID, 'cn_woo_products_tabs', true ) );
		$tab_data['id'];
		$cn_title=$tab_data['title'];
		$cntabcontent=$tab_data['content'];
		// Display the custom tab panel
			echo '<div id="woocommerce_custom_product_tabs" class="panel wc-metaboxes-wrapper woocommerce_options_panel">';
			echo '<div id="cn_options_group" class="options_group">';
			$tabdefult=count($tab_data)+1;
			echo '<strong>Create New Tabs</strong>';
			echo '<div class="cn-woo-custom-tab-divider"></div>';
			echo $this->add_tab_html($tabdefult, $post);
			if ($tab_data) {
				echo '<strong>Update Tabs</strong>';
				echo '<div class="cn-woo-custom-tab-divider"></div>';
				echo $this->generate_tab_html($tab_data, $post);
			}
			//echo display_add_tabs_container();
			echo $this->display_number_of_tabs($tabdefult);
			echo '</div>';	
			echo '</div>';
	}
	public function generate_tab_html( $tab_data, $post ) {
	 	$i = 1;
		foreach ($tab_data as $tab ) {
			echo '<div class="cntab_'.$i.'">';
			$this->display_woocommerce_wp_text_input( $i, $tab );
			// Tab content wysiwyg
			$this->display_woocommerce_wp_wysiwyg_input( $i, $tab );
			echo '<div class="button-secondary cn_delete_tabs" id="cn_delete_tabs_'.$i.'"><i class="dashicons dashicons-minus-alt inline-button-dashicons"></i>Delete this Tab</div>
				<input type="hidden" value="' . $i . '" id="number_of_tabs'.$i.'" name="delete_tabs_'.$i.'" >';
			echo $this->display_yikes_tab_divider( $i, count( $tab_data ) );
			echo '</div>';
			$i++;
		}
	}

	public function add_tab_html($i, $post ) {
	 	$tab=array('title'=>'','content'=>'');
			$this->display_woocommerce_wp_text_input( $i, $tab );
			// Tab content wysiwyg
			$this->display_woocommerce_wp_wysiwyg_input( $i, $tab );

			$this->display_yikes_tab_divider( $i, count( $tab_data ) );
	}

	public function display_number_of_tabs( $tab_count ) {
		$return_html = '';
		$return_html .= '<input type="hidden" value="' . $tab_count . '" id="number_of_tabs" name="number_of_tabs" >';
		// $return_html .= '<input type="hidden" value="' . admin_url( 'admin-ajax.php' ) . '" id="admin_ajax" name="admin_ajax" >';
		return $return_html;
	}
	public function save_tab_data($post_id, $post) {
		if ( empty( $post_id ) ) {
			return;
		}
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
		$tab_data = array();

		if (isset($_POST['number_of_tabs'])) {
			$number_of_tabs =absint(isset( $_POST['number_of_tabs'] ) ? $_POST['number_of_tabs'] : '');
		}else{
			$number_of_tabs=1;
		}
		$i = 1;
		while( $i <= $number_of_tabs ) {

			$tab_title= sanitize_text_field(isset( $_POST['cn_custom_tabs_tab_title_' . $i] ) ? stripslashes( $_POST['cn_custom_tabs_tab_title_' . $i] ) : '');
			
			$tab_content = wp_kses(isset( $_POST['cn_custom_product_tabs_tab_content_' . $i] ) ? stripslashes( $_POST['cn_custom_product_tabs_tab_content_' . $i] ) : '',$allowed_html);
			if ( empty( $tab_title ) && empty( $tab_content ) ) {
				// clean up if the custom tabs are removed
				unset( $tab_data[$i] );
			
			} else {
				$tab_id = '';
				if ( $tab_title ) {
					$tab_id = uniqid();
				}

				// push the data to the array
				$tab_data[$i] = array( 'title' => $tab_title, 'id' => $tab_id, 'content' => $tab_content);
			}	
			$i++;
		}
		if ( ! empty( $tab_data ) ) {				
			update_post_meta( $post_id, 'cn_woo_products_tabs', $tab_data );
		}
	}

	public function display_woocommerce_wp_text_input( $i, $tab ) {
		woocommerce_wp_text_input( array( 'id' => 'cn_custom_tabs_tab_title_' . $i , 'label' => __( 'Tab Title', '' ), 'description' => '', 'value' => $tab['title'] , 'placeholder' => __( 'Custom Tab Title' , '' ), 'class' => 'woo_tabs_title_field') );
	}

	public function display_woocommerce_wp_wysiwyg_input( $i, $tab ) {
		echo '<div class="form-field-tinymce cn_custom_tab_content 
		cn_custom_product_tabs_tab_content_' . $i . '_field">';
			$this->woocommerce_wp_wysiwyg_input( array( 
				'id' => 'cn_custom_product_tabs_tab_content_' . $i , 
				'label' => __( 'Content', 'cn-custom-woocommerce-product-tabs' ), 
				'placeholder' => __( 'HTML and text to display.'), 
				'value' => $tab['content'], 
				'style' => 'width:100%;min-height:10rem;', 
				'class' => 'woo_tabs_content_field',
				'number' => $i
			) );
		echo '</div>';
	}
	public function display_yikes_tab_divider( $i, $tab_count ) {
		$return_html = '';
		if ( $i != $tab_count ) { 
			$return_html .= '<div class="cn-woo-custom-tab-divider"></div>';
		}

		return $return_html;
	}
	public function woocommerce_wp_wysiwyg_input( $field ) {

		if ( ! isset( $field['placeholder'] ) ) $field['placeholder'] = '';
		if ( ! isset( $field['class'] ) ) $field['class'] = '';
		if ( ! isset( $field['value'] ) ) $field['value'] = '';

		$editor_settings = array(
			'textarea_name' => $field['id']
		);
		
		wp_editor( $field['value'], $field['id'], $editor_settings );
		
		if ( isset( $field['description'] ) && $field['description'] ) {
			echo '<span class="description">' . $field['description'] . '</span>';
		}
	}
	public function cn_custom_woo_tabs_editor_font_buttons( $buttons ) {
		array_unshift( $buttons, 'fontselect' ); 
		array_unshift( $buttons, 'fontsizeselect' ); 
		return $buttons;
	}

	

}
