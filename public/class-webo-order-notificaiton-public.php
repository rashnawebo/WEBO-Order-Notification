<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://webo.digital/
 * @since      1.0.0
 *
 * @package    Webo_Order_Notificaiton
 * @subpackage Webo_Order_Notificaiton/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Webo_Order_Notificaiton
 * @subpackage Webo_Order_Notificaiton/public
 * @author     WEBO Digital <hello@webo.digital>
 */
class Webo_Order_Notificaiton_Public {

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
		 * defined in Webo_Order_Notificaiton_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Webo_Order_Notificaiton_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/webo-order-notificaiton-public.css', array(), $this->version, 'all' );

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
		 * defined in Webo_Order_Notificaiton_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Webo_Order_Notificaiton_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/webo-order-notificaiton-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Fire this action when execution starts
	 *
	 * @return void
	 */
	public function webo_order_notificaiton_init_action()
	{
		return $this->set_products_cookie_on_client();
	}

	/**
	 * Render notification template on frontend
	 *
	 * @return template
	 */
	public function webo_order_notificaiton_render_template()
	{
		ob_start();
		require( WON_PLUGIN_PATH . 'public/partials/won-notification-template.php');
		$html = ob_get_contents();
		ob_end_clean();
		echo $html;

	}

	/**
	 * set cookie of products on client browser if not exist on activation
	 *
	 * @return void
	 */
	private function set_products_cookie_on_client()
	{
		if ( isset($_COOKIE['won_cookie_expiry'])) {
			return;
		}

		$empty_value = get_option('won_notification_setting', 'empty_value');
		if ( $empty_value == 'empty_value') {
			$num_of_days    = 3;
			$popup_interval = time()+300;
			$cookie_expiry  = 5;

			$data = array(
				'num_of_days'    => $num_of_days,
				'cookie_expiry'  => $popup_interval,
				'popup_interval' => $cookie_expiry,
			);
			$updated = update_option('won_notification_setting', json_encode($data));
			if ($updated == false) {
				exit( sprintf( 'Error activating the plugin. Please try again.' ) );
			}
		} else {
			$notification_setting = get_option('won_notification_setting');
			$notification         = json_decode($notification_setting);

			$num_of_days    = is_null($notification) ? 3 : $notification->num_of_days;
			$popup_interval = is_null($notification) ? null : $notification->popup_interval;
			$cookie_expiry  = is_null($notification) ? time()+300 : time() + $notification->cookie_expiry;
		}

		$args = array(
			'numberposts' => -1,
			'post_type'   => wc_get_order_types(),
			'post_status' => array_keys( wc_get_order_statuses() ),
			'order'       => 'DESC',
			'orderby'     => 'date',
			'date_query'  => array(
				array(
					'after' => $num_of_days.' day ago'
				)
			)
		);

		$customer_orders = get_posts( $args );

		$display_records = [];
		$counter = 0;
		foreach($customer_orders as $key => $customer_order) {
			$order         = wc_get_order( $customer_order->ID );
			$order_data    = $order->get_data();
			$products      = $order->get_items();
			$customer_name = $order_data['billing']['first_name'] . ' ' . $order_data['billing']['last_name'];
			$order_time    = $order->get_date_created();
			$order_time    = strtotime($order_time);
			$time_diff     = human_time_diff($order_time, strtotime(date("Y-m-d H:i:s")));
			foreach ($products as $k => $product) {
				$product_id = $product->get_product_id();
				$image_url = get_the_post_thumbnail_url($product_id, 'thumbnail');
				$product_url = get_permalink($product_id);
				$display_records[$counter]['customer_name'] = $customer_name;
				$display_records[$counter]['time_ago']      = $time_diff;
				$display_records[$counter]['product_id']    = $product_id;
				$display_records[$counter]['product_name']  = $product->get_name();
				$display_records[$counter]['product_url']   = $product_url;
				$display_records[$counter]['image_url']     = $image_url;
				$counter++;
			}
		}

		$won_site_path =  parse_url(get_option('siteurl'), PHP_URL_PATH);
		$won_site_host =  parse_url(get_option('siteurl'), PHP_URL_HOST);

		setcookie('won_cookie_expiry', $cookie_expiry, $cookie_expiry, $won_site_path, $won_site_host);
		setcookie('won_orders', json_encode($display_records, JSON_UNESCAPED_SLASHES), $cookie_expiry, $won_site_path, $won_site_host);
	}

}
