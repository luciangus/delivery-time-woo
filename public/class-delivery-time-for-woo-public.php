<?php

/**
 * The public-facing functionality of the plugin.
 *
  * @since      1.0.0
 *
 * @package    Delivery_Time_For_Woo
 * @subpackage Delivery_Time_For_Woo/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Delivery_Time_For_Woo
 * @subpackage Delivery_Time_For_Woo/public
 */
class Delivery_Time_For_Woo_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		// Display delivery time days on product and archive page
		add_action( 'woocommerce_before_add_to_cart_form', array( $this, 'dft_display_delivery_time' ) );
		add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'dft_display_delivery_time' ) );

		// Handle AJAX call to display description text
		add_action( 'wp_ajax_get_dt_desc', array( $this, 'get_dt_desc' ) );
		add_action( 'wp_ajax_nopriv_get_dt_desc', array( $this, 'get_dt_desc' ) );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/delivery-time-for-woo-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/delivery-time-for-woo-public.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( $this->plugin_name, 'front_ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

	}

	/**
	 * Display delivery time on single product page and archive page
	 *
	 * @since    1.0.0
	 */
	public function dft_display_delivery_time() {
		$dtf_display_on = json_decode( get_option( 'dtf_display_on' ) );

		// check if settings not saved on single product page
		if( is_product() ) {
			if( !in_array( 'dtf_is_single', $dtf_display_on ) ) {
				return;
			}
		}

		// check if settings not saved on archive page
		if( is_product_category() || is_shop() ) {
			if( !in_array( 'dtf_is_archive', $dtf_display_on ) ) {
				return;
			}
		}

		$num_of_days = $this->check_delivery_time();
		
		if( !empty( $num_of_days ) && $num_of_days > 0 ) {
			$dtf_color = get_option( 'dtf_color' );
			$dt_desc = get_post_meta( get_the_ID(), '_dft_product_delivery_desc_field', true );
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/delivery-time-for-woo-public-display.php';
		}

	}

	/**
	 * Decide if delivery time will display or not
	 *
	 * @since    1.0.0
	 * @return   $delivery_time
	 */
	public function check_delivery_time() {
		$dt_per_settings = get_option( 'dtf_delivery_time' );
		$dt_per_product = get_post_meta( get_the_ID(), '_dft_product_delivery_time_field', true );

		if( empty( $dt_per_product ) || $dt_per_product == 0 ) {
			$delivery_time = $dt_per_settings;
		}

		if( empty( $dt_per_settings ) || $dt_per_settings == 0 ) {
			$delivery_time = '';
		}

		if( !empty( $dt_per_product ) && $dt_per_product > 0 ) {
			$delivery_time = $dt_per_product;
		}

		if( $dt_per_product < 0 || $dt_per_settings < 0 ) {
			$delivery_time = '';
		}

		return $delivery_time; 
	}

	/**
	 * Get product Description on AJAX call
	 *
	 * @since    1.0.0
	 */
	public function get_dt_desc() {
		$p_id = isset( $_POST['p_id'] ) && !empty( $_POST['p_id'] ) ? $_POST['p_id'] : 0;
		$desc = '';
		if( $p_id > 0 ) {
			$desc = get_post_meta( $p_id, '_dft_product_delivery_desc_field', true );	
		}
		echo json_encode( array( 'success' => 'yes', 'desc' => $desc ) );
		exit();
	}
}
