<?php

	add_action( 'init', 'mbot_webhook_endpoint' );
	add_action( 'parse_request', 'mbot_webhook_parse_request' );


function mbot_webhook_endpoint(){

	// access webhook at url such as http://[your site]/mailchimp/webhook
    add_rewrite_rule( 'mbot-callback-webhook' , 'index.php?mbot-callback-webhook=1', 'top' );
    add_rewrite_tag( '%mbot-callback-webhook%' , '([^&]+)' );

}

function mbot_webhook_parse_request( &$wp )
{
   
    if ( array_key_exists( 'mbot-callback-webhook', $wp->query_vars ) ) {
        
        //mcwh_action_webhook();
        do_action( 'mbot_messenger_callback_webhook' );

        exit();
    }
    
}