<?php

//Send order status notifications

function derweili_mbot_woocommerce_orderstatus_message_pending($order_id) {
	$bot = new FbBotApp(mbot_woocommerce_token);
	$receiver_id = get_post_meta($order_id, 'derweili_mbot_woocommerce_customer_messenger_id', true);
	$message = apply_filters( 'derweili_mbot_woocommerce_message_pending', 'Your order is no pendig.', $order_id, $receiver_id );
	$bot->send(new Message($receiver_id, $message ));

	error_log("$order_id set to PENDING", 0);
}
function derweili_mbot_woocommerce_orderstatus_message_failed($order_id) {
	$bot = new FbBotApp(mbot_woocommerce_token);
	$receiver_id = get_post_meta($order_id, 'derweili_mbot_woocommerce_customer_messenger_id', true);
	$message = apply_filters( 'derweili_mbot_woocommerce_message_failed', 'Your order failed.', $order_id, $receiver_id );
	$bot->send(new Message($receiver_id, $message ));

	error_log("$order_id set to FAILED", 0);
}
function derweili_mbot_woocommerce_orderstatus_message_hold($order_id) {
	$bot = new FbBotApp(mbot_woocommerce_token);
	$receiver_id = get_post_meta($order_id, 'derweili_mbot_woocommerce_customer_messenger_id', true);
	$message = apply_filters( 'derweili_mbot_woocommerce_message_hold', 'Your order is now on hold.', $order_id, $receiver_id );
	$bot->send(new Message($receiver_id, $message ));

	error_log("$order_id set to ON HOLD", 0);
}
function derweili_mbot_woocommerce_orderstatus_message_processing($order_id) {
	$bot = new FbBotApp(mbot_woocommerce_token);
	$receiver_id = get_post_meta($order_id, 'derweili_mbot_woocommerce_customer_messenger_id', true);
	$message = apply_filters( 'derweili_mbot_woocommerce_message_processing', 'Your order is now processing', $order_id, $receiver_id );
	$bot->send(new Message($receiver_id, $message ));

	error_log("$order_id set to PROCESSING", 0);
}
function derweili_mbot_woocommerce_orderstatus_message_completed($order_id) {
	$bot = new FbBotApp(mbot_woocommerce_token);
	$receiver_id = get_post_meta($order_id, 'derweili_mbot_woocommerce_customer_messenger_id', true);
	$message = apply_filters( 'derweili_mbot_woocommerce_message_completed', 'Your order has been completed', $order_id, $receiver_id );
	$bot->send(new Message($receiver_id, $message ));

	error_log("$order_id set to COMPLETED", 0);
}
function derweili_mbot_woocommerce_orderstatus_message_refunded($order_id) {
	$bot = new FbBotApp(mbot_woocommerce_token);
	$receiver_id = get_post_meta($order_id, 'derweili_mbot_woocommerce_customer_messenger_id', true);
	$message = apply_filters( 'derweili_mbot_woocommerce_message_refunded', 'Your order has been refunded', $order_id, $receiver_id );
	$bot->send(new Message($receiver_id, $message ));

	error_log("$order_id set to REFUNDED", 0);
}
function derweili_mbot_woocommerce_orderstatus_message_cancelled($order_id) {
	$bot = new FbBotApp(mbot_woocommerce_token);
	$receiver_id = get_post_meta($order_id, 'derweili_mbot_woocommerce_customer_messenger_id', true);
	$message = apply_filters( 'derweili_mbot_woocommerce_message_cancelled', 'Your order has been cancelled', $order_id, $receiver_id );
	$bot->send(new Message($receiver_id, $message ));

	error_log("$order_id set to CANCELLED", 0);
}


add_action( 'woocommerce_order_status_pending', 'derweili_mbot_woocommerce_orderstatus_message_pending');
add_action( 'woocommerce_order_status_failed', 'derweili_mbot_woocommerce_orderstatus_message_failed');
add_action( 'woocommerce_order_status_on-hold', 'derweili_mbot_woocommerce_orderstatus_message_hold');
// Note that it’s woocommerce_order_status_on-hold, not on_hold.
add_action( 'woocommerce_order_status_processing', 'derweili_mbot_woocommerce_orderstatus_message_processing');
add_action( 'woocommerce_order_status_completed', 'derweili_mbot_woocommerce_orderstatus_message_completed');
add_action( 'woocommerce_order_status_refunded', 'derweili_mbot_woocommerce_orderstatus_message_refunded');
add_action( 'woocommerce_order_status_cancelled', 'derweili_mbot_woocommerce_orderstatus_message_cancelled');

