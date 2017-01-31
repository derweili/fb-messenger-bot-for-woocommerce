<?php

function derweili_mbot_check_update() {

	$plugin_data = get_plugin_data( dirname( dirname(__FILE__) ) . "/mbot-woocommerce.php" );
	//var_dump($plugin_data);
	define( "mbot_woocommerce_plugin_version", $plugin_data["Version"] );
	
	$stored_plugin_version = get_site_option( 'mbot_woocommerce_plugin_version' );
    if ( $stored_plugin_version != mbot_woocommerce_plugin_version ) {

    	if ( empty( $stored_plugin_version ) ) { $stored_plugin_version = 0; } else { $stored_plugin_version = str_replace( '.', '', $stored_plugin_version ); }; 

        do_action( 'mbot_woocommerce_plugin_update', $stored_plugin_version );
        
        if ( add_site_option( 'mbot_woocommerce_plugin_version', $plugin_data["Version"] ) ) {
        	update_site_option( 'mbot_woocommerce_plugin_version', $plugin_data["Version"] );
        }

    }

}
add_action( 'admin_head', 'derweili_mbot_check_update' );
//add_action( 'register_activation_hook', 'derweili_mbot_check_update' );



/**
* NOTE: flush rewrite rules and webhook endpoint on every plugin update
* @since 1.7
*/ 

function derweili_mbot_default_updates() {

	if ( function_exists( 'mbot_webhook_endpoint' ) ) {
		mbot_webhook_endpoint(); // register webhook endpoints
	}

	flush_rewrite_rules(); // flush rewrite rules


	$settings = new Derweili_Mbot_Domain_Whitelisting();
	$settings->whitelist_domain();

}
add_action( 'mbot_woocommerce_plugin_update', 'derweili_mbot_default_updates' );



/**
* NOTE: Migrate from static text to woocommerce settings
* @since 1.7
*/
function derweili_mbot_migrate_message_text( $version ) {
	if ( 16 >= $version ) {
		
		add_option( 'derweili_mbot_new_order_message', __( 'Thank you for your order, you will be immediately notified when your order status changes.', 'mbot-woocommerce' ) );
		add_option( 'derweili_mbot_pending_order_message', __( 'Your order is now pendig.', 'mbot-woocommerce' ) );
		add_option( 'derweili_mbot_failed_order_message', __( 'Your order unfortunately failed.', 'mbot-woocommerce' ) );
		add_option( 'derweili_mbot_on_hold_order_message', __( 'Your order is now on hold.', 'mbot-woocommerce' ) );
		add_option( 'derweili_mbot_processing_order_message', __( 'Your order is now processing', 'mbot-woocommerce' ) );
		add_option( 'derweili_mbot_completed_order_message', __( 'Your order has been completed', 'mbot-woocommerce' ) );
		add_option( 'derweili_mbot_refunded_order_message', __( 'Your order has been refunded', 'mbot-woocommerce' ) );
		add_option( 'derweili_mbot_cancelled_order_message', __( 'Your order has been cancelled', 'mbot-woocommerce' ) );


	}else{
	}
}

add_action( 'mbot_woocommerce_plugin_update', 'derweili_mbot_migrate_message_text' );


/**
* NOTE: Migrate from static text to woocommerce settings
* @since 1.17
*/
function derweili_mbot_migrate_display_settings( $version ) {
	if ( 117 >= $version ) {
		
		update_option( 'derweili_mbot_checkbox_size', 'large' );
		update_option( 'derweili_mbot_fb_checkbox_prechecked', 'true' );
		update_option( 'derweili_mbot_fb_checkbox_allow_login', 'true' );
		update_option( 'derweili_mbot_button_size', 'large' );
		update_option( 'derweili_mbot_button_color', 'blue' );
		update_option( 'derweili_mbot_button_enforce_login', 'false' );

	}else{
	}
}

add_action( 'mbot_woocommerce_plugin_update', 'derweili_mbot_migrate_display_settings' );