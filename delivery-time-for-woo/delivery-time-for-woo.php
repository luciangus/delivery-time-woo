<?php

/**
 * Plugin Name:       Delivery Time for WooCommerce
 * Description:       Shows the delivery time for a product in Woocommerce. 
 * Version:           1.0.0
 * Author:            Luciana
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       delivery-time-for-woo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'DELIVERY_TIME_FOR_WOO_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-delivery-time-for-woo-activator.php
 */
function activate_delivery_time_for_woo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-delivery-time-for-woo-activator.php';
	Delivery_Time_For_Woo_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-delivery-time-for-woo-deactivator.php
 */
function deactivate_delivery_time_for_woo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-delivery-time-for-woo-deactivator.php';
	Delivery_Time_For_Woo_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_delivery_time_for_woo' );
register_deactivation_hook( __FILE__, 'deactivate_delivery_time_for_woo' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-delivery-time-for-woo.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_delivery_time_for_woo() {

	$plugin = new Delivery_Time_For_Woo();
	$plugin->run();

}
run_delivery_time_for_woo();
