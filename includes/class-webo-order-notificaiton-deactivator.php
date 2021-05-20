<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://webo.digital/
 * @since      1.0.0
 *
 * @package    Webo_Order_Notificaiton
 * @subpackage Webo_Order_Notificaiton/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Webo_Order_Notificaiton
 * @subpackage Webo_Order_Notificaiton/includes
 * @author     WEBO Digital <hello@webo.digital>
 */
class Webo_Order_Notificaiton_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate()
	{
		//delete cookie
		$won_site_path =  parse_url(get_option('siteurl'), PHP_URL_PATH);
		$won_site_host =  parse_url(get_option('siteurl'), PHP_URL_HOST);

		setcookie('won_cookie_expiry', null, -3600, $won_site_path, $won_site_host);
		setcookie('won_orders', null, -3600, $won_site_path, $won_site_host);
	}

}
