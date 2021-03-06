<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://webo.digital/
 * @since      1.0.0
 *
 * @package    Webo_Order_Notificaiton
 * @subpackage Webo_Order_Notificaiton/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Webo_Order_Notificaiton
 * @subpackage Webo_Order_Notificaiton/admin
 * @author     WEBO Digital <hello@webo.digital>
 */
class Webo_Order_Notificaiton_Admin {

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
		 * defined in Webo_Order_Notificaiton_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Webo_Order_Notificaiton_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/webo-order-notificaiton-admin.css', array(), $this->version, 'all' );

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
		 * defined in Webo_Order_Notificaiton_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Webo_Order_Notificaiton_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/webo-order-notificaiton-admin.js', array( 'jquery' ), $this->version, false );

	}

	//create menu
	public function won_notification_setting_menu()
	{
		add_submenu_page( 'options-general.php', 'Webo Order Notification', 'Order Notification', 'manage_options', 'webo-order-notification', array($this, 'webo_order_notificaiton'));
	}

	//display template
	public function webo_order_notificaiton()
	{
		$empty_value = get_option('won_notification_setting', 'empty_value');
		if ( $empty_value == 'empty_value') {
			$num_of_days    = 3;
			$popup_interval = 5;
			$cookie_expiry  = 5;
		} else {
			$notification_setting = get_option('won_notification_setting');
			$notification         = json_decode($notification_setting);

			$num_of_days    = is_null($notification) ? 3 : $notification->num_of_days;
			$popup_interval = is_null($notification) ? 5 : $notification->popup_interval;
			$cookie_expiry  = is_null($notification) ? 5 : $notification->cookie_expiry;
		}

		ob_start();
		include_once WON_PLUGIN_PATH . 'admin/partials/order-notification-template.php';
		$template = ob_get_contents();
		ob_clean();
		echo $template;
	}

	//save settings
	public function won_save_notification_setting()
	{
		$num_of_days    = sanitize_text_field($_POST['num_of_days']);
		$cookie_expiry  = sanitize_text_field($_POST['cookie_expiry']);

		if ( ! is_numeric($num_of_days) || ! is_numeric($cookie_expiry) || ! is_numeric($popup_interval)) {
			$redirect = add_query_arg( 'status', 'validation_error', wp_get_referer() );
			wp_redirect( $redirect );
			exit;
		}

		$data = array(
			'num_of_days'    => $num_of_days,
			'cookie_expiry'  => $cookie_expiry,
			'popup_interval' => 7000
		);

		$updated = update_option('won_notification_setting', json_encode($data));
		if ($updated) {
			$redirect = add_query_arg( 'status', 'success', wp_get_referer() );
		} else {
			$redirect = add_query_arg( 'status', 'error', wp_get_referer() );
		}
		wp_redirect( $redirect );
		exit;
	}
}
