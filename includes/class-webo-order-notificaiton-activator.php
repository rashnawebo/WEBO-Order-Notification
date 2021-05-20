<?php

/**
 * Fired during plugin activation
 *
 * @link       https://webo.digital/
 * @since      1.0.0
 *
 * @package    Webo_Order_Notificaiton
 * @subpackage Webo_Order_Notificaiton/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Webo_Order_Notificaiton
 * @subpackage Webo_Order_Notificaiton/includes
 * @author     WEBO Digital <hello@webo.digital>
 */
class Webo_Order_Notificaiton_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate()
	{
		if ( ! class_exists( 'WooCommerce' ) ) {
			exit( sprintf( 'WooCommerce Must be activated before activating this plugin.' ) );
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
