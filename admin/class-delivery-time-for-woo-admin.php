<?php

/**
 * The admin-specific functionality of the plugin.
 * @since      1.0.0
 *
 * @package    Delivery_Time_For_Woo
 * @subpackage Delivery_Time_For_Woo/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Delivery_Time_For_Woo
 * @subpackage Delivery_Time_For_Woo/admin
 */
class Delivery_Time_For_Woo_Admin {

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

		// Add admin setting menu for this plugin
		add_action( 'admin_menu', array( $this, 'delivery_time_for_woo_admin_page' ) );

		/**
		 * Functionlaity performs upon save settings
		 * Action defined in admin/partial/delivery-time-for-woo-admin-display.php
		 */
		add_action( 'admin_post_nopriv_save_delivery_time_for_woo_settings', array( $this, 'save_delivery_time_for_woo_settings' ) );
		add_action( 'admin_post_save_delivery_time_for_woo_settings', array( $this, 'save_delivery_time_for_woo_settings') );


		// Display Delivery time and Delivery time description Fields on product edit page
		add_action( 'woocommerce_product_options_general_product_data', array( $this, 'dtf_woocommerce_product_custom_fields' ) );
		// Save Delivery time and Delivery time description Fields on product edit page
		add_action( 'woocommerce_process_product_meta', array( $this, 'dtf_woocommerce_product_custom_fields_save' ) );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		
		wp_enqueue_style( 'wp-color-picker');

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/delivery-time-for-woo-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

	
		wp_enqueue_script( 'wp-color-picker');

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/delivery-time-for-woo-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add admin setings menu page
	 *
	 * @since    1.0.0
	 */
	public function delivery_time_for_woo_admin_page() {
		add_menu_page(
			'Delivery Time for WooCommerce Settings Page', //Page Title
			'Delivery Time for WooCommerce', //Menu Title
			'manage_options', //Capability
			'delivery_time_woo_settings', //Page slug
			array( $this, 'delivery_time_woo_tab_data' ), //Callback to print html
			'dashicons-admin-tools' // admin settigns icon
		);
	}

	/**
	 * Add admin setings page HTML
	 *
	 * @since    1.0.0
	 */
	public function delivery_time_woo_tab_data() {
		$saved = isset( $_GET['saved'] ) ? $_GET['saved'] : '';

		$dtf_delivery_time = get_option( 'dtf_delivery_time' );
		$dtf_display_on = json_decode( get_option( 'dtf_display_on' ) );
		$dtf_color = get_option( 'dtf_color' );

		require_once 'partials/delivery-time-for-woo-admin-display.php';
	}


	/**
	 * Admin setings page HTML save fields funcion
	 *
	 * @since    1.0.0
	 */
	public function save_delivery_time_for_woo_settings() {
		// Get values from POST
		$enable_delivery_time = isset( $_POST[ 'dtf_delivery_time' ] ) ? $_POST[ 'dtf_delivery_time'] : '';
		$dtf_display_on = isset( $_POST[ 'dtf_display_on' ] ) ? $_POST[ 'dtf_display_on'] : array();
		$dtf_color = isset( $_POST[ 'dtf_color' ] ) ? $_POST[ 'dtf_color'] : '';

		// Save value in `wp_options`
		update_option( 'dtf_delivery_time', $enable_delivery_time );
		update_option( 'dtf_display_on', json_encode( $dtf_display_on ) );
		update_option( 'dtf_color', $dtf_color );

		// Redirect after save the value
		wp_redirect( $_SERVER['HTTP_REFERER'].'&saved=saved'); 

	}

	/**
	 * Admin product edit page create Delivery time and Delivery time description Fields
	 *
	 * @since    1.0.0
	 */
	public function dtf_woocommerce_product_custom_fields() {
	    global $woocommerce, $post;
	    echo '<div class="product_custom_field">';

	    //Custom Product Delivery time Field
	    woocommerce_wp_text_input(
	        array(
	            'id' => '_dft_product_delivery_time_field',
	            'placeholder' => 'Delivery time',
	            'label' => __( 'Delivery time', 'woocommerce' ),
	            'type' => 'number',
	            'custom_attributes' => array(
	                'step' => 'any',
	                'min' => '-1'
	            ),
	            'value' => get_post_meta( $post->ID, '_dft_product_delivery_time_field', true )
	        )
	    );
	    
	    //Custom Product Delivery time description Textarea
	    woocommerce_wp_textarea_input(
	        array(
	            'id' => '_dft_product_delivery_desc_field',
	            'placeholder' => 'Delivery time description',
	            'label' => __( 'Delivery time description', 'woocommerce' ),
	            'value' => get_post_meta( $post->ID, '_dft_product_delivery_desc_field', true )
	        )
	    );
	    echo '</div>';
	}

	/**
	 * Admin product edit page save Delivery time and Delivery time description Fields
	 *
	 * @since    1.0.0
	 * @param    $post_id int
	 */
	public function dtf_woocommerce_product_custom_fields_save( $post_id ) {
		
		// Custom Product Delivery time Field save
	    if ( isset( $_POST['_dft_product_delivery_time_field'] ) ) {
	        update_post_meta( $post_id, '_dft_product_delivery_time_field', $_POST['_dft_product_delivery_time_field'] );
	    }
	
		// Custom Product Textarea Field save
	    if ( isset( $_POST['_dft_product_delivery_desc_field'] ) ) {
	        update_post_meta( $post_id, '_dft_product_delivery_desc_field', esc_html( $_POST['_dft_product_delivery_desc_field'] ) );
	    }
	}
}
