<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://webo.digital/
 * @since             1.0.0
 * @package           Webo_Order_Notificaiton
 *
 * @wordpress-plugin
 * Plugin Name:       WEBO Order Notification
 * Plugin URI:        https://webo.digital/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            WEBO Digital
 * Author URI:        https://webo.digital/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       webo-order-notificaiton
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WEBO_ORDER_NOTIFICAITON_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-webo-order-notificaiton-activator.php
 */
function activate_webo_order_notificaiton() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-webo-order-notificaiton-activator.php';
	Webo_Order_Notificaiton_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-webo-order-notificaiton-deactivator.php
 */
function deactivate_webo_order_notificaiton() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-webo-order-notificaiton-deactivator.php';
	Webo_Order_Notificaiton_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_webo_order_notificaiton' );
register_deactivation_hook( __FILE__, 'deactivate_webo_order_notificaiton' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-webo-order-notificaiton.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_webo_order_notificaiton() {

	$plugin = new Webo_Order_Notificaiton();
	$plugin->run();

}
run_webo_order_notificaiton();
