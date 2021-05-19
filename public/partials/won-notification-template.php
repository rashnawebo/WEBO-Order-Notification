<?php
/*
$order                    = wc_get_order( $customer_order->ID );
$order_data               = $order->get_data();
$products                 = $order->get_items();
$order_billing_first_name = $order_data['billing']['first_name'];
$order_billing_last_name  = $order_data['billing']['last_name'];
$order_time               = $order->get_date_created();
$order_time               = strtotime($order_time);
$time_diff                = human_time_diff($order_time, strtotime(date("Y-m-d H:i:s")));

foreach ($products as $key => $product) {
	$product_name = $product->get_name();
	$product_id = $product->get_product_id();
} */
?>
<div class="won webo-order-notification">
	<a href="" target="_blank">
		<div class="won-notification">
			<div class="won-product-image">
				<img src="">
			</div>
			<div class="won-order-content">
				<p class="won-billing-name"> recently purchased</p>
				<p class="won-product-name" ><b></b></p>
				<small>About <span class="won-time-diff"></span> ago</small>
			</div>
		</div>
	</a>
	<span class="won-close">x</span>
</div>