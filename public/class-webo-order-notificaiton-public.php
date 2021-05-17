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

	public function webo_order_notificaiton_render_template()
	{
		/**
		 * This function is provided for displaying notification popup on the aite
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Webo_Order_Notificaiton_Loader as all of the hooks are defined
		 * in that particular class .
		 *
		 * Action hooked used: wp_footer
		 * Inputs $days  Number of days that shows order
		 * Input $cache_days Number of cache days
		 *
		 * The Webo_Order_Notificaiton_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//$days = $_POST['days'];
		$args = array(
			'numberposts' => -1,
			'post_type'   => wc_get_order_types(),
			'post_status' => array_keys( wc_get_order_statuses() ),
			'order'       => 'DESC',
			'orderby'     => 'date',
			'date_query'  => array(
				array(
					'after' => '1 day ago'
				)
			)
		);

		$customer_orders = get_posts( $args );


		if($customer_orders)
		{
			foreach ($customer_orders as $customer_order) 
			{
				ob_start();
				require( WON_PLUGIN_PATH . 'public/partials/won-notification-template.php');
				$html = ob_get_contents();
				ob_end_clean();	
				echo $html;
			}			
		}		
	}

}
