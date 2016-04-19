<?php


function derweili_mbot_message_order_status_completed( $order_id ) {
	//error_log( "Order complete for order $order_id", 0 );
	$bot = new FbBotApp(mbot_woocommerce_token);
	$receiver_ID = get_post_meta($order_id, 'derweili_mbot_woocommerce_customer_messenger_id', true);
	$bot->send(new Message($receiver_ID, 'Ihre Bestellung wurde versendet.' ));
}
add_action( 'woocommerce_order_status_completed', 'derweili_mbot_message_order_status_completed' );


function derweili_mbot_message_order_status_processing( $order_id ) {
	//error_log( "Order complete for order $order_id", 0 );
	$bot = new FbBotApp(mbot_woocommerce_token);
	$receiver_ID = get_post_meta($order_id, 'derweili_mbot_woocommerce_customer_messenger_id', true);
	$bot->send(new Message($receiver_ID, 'Der Status ihrer Bestellung wurde zu "in Bearbeitung" gändert.' ));
}
add_action( 'woocommerce_order_status_processing', 'derweili_mbot_message_order_status_processing' );


function derweili_mbot_message_order_status_refunded( $order_id ) {
	//error_log( "Order complete for order $order_id", 0 );
	$bot = new FbBotApp(mbot_woocommerce_token);
	$receiver_ID = get_post_meta($order_id, 'derweili_mbot_woocommerce_customer_messenger_id', true);
	$bot->send(new Message($receiver_ID, 'Ihre Bestellung wurde zurückerstattet.' ));
}
add_action( 'woocommerce_order_status_refunded', 'derweili_mbot_message_order_status_refunded' );


function derweili_mbot_message_order_status_cancelled( $order_id ) {
	//error_log( "Order complete for order $order_id", 0 );
	$bot = new FbBotApp(mbot_woocommerce_token);
	$receiver_ID = get_post_meta($order_id, 'derweili_mbot_woocommerce_customer_messenger_id', true);
	$bot->send(new Message($receiver_ID, 'Ihre Bestellung wurde storniert.' ));
}
add_action( 'woocommerce_order_status_cancelled', 'derweili_mbot_message_order_status_cancelled' );