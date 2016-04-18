<?php

//echo dirname(__FILE__);


//Load WordPress functions

if ( !isset($wp_did_header) ) {

	//Load Wordpress Functions
    $wp_did_header = true;
    require_once( '../../../wp-load.php' );
    wp();
    require_once( ABSPATH . WPINC . '/template-loader.php' );

    echo mbot_woocommerce_verify_token;
    //Chef if something is received
    if (!empty($_REQUEST['hub_mode']) && $_REQUEST['hub_mode'] == 'subscribe' && $_REQUEST['hub_verify_token'] == 'my_test_verify_tooken_for_alles_teuer_shop_messenger_bot') {

        // Webhook setup request
        echo $_REQUEST['hub_challenge'];

    } else {

        // Other event
        $data = json_decode(file_get_contents("php://input"), true);
    
        //Log all connections    
        file_put_contents("log.html", $data['entry'][0]['messaging']);


        if (!empty($data['entry'][0]['messaging'])) {
            foreach ($data['entry'][0]['messaging'] as $message) {

                $command = "";

                //If Authentication Callback is received
                if (!empty($message['optin'])) {

                    //Is order subsciption
                    if (startswith($message['optin']['ref'], 'subscribeToOrder' )) {
                        $orderid = str_replace("subscribeToOrder", "", $message['optin']['ref']);
                        
                        $bot->send(new Message($message['sender']['id'], 'Thank you for you order. ' . $orderid ));
                        
                        WooCommerce_Send_order($bot, $orderid);

                    };

                };

            }; //endforeach
        }; //endif


    }

}
//$derweili_mbot = new FbBotApp($token);


