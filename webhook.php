<?php

//Load WordPress functions

if ( !isset($wp_did_header) ) {

    define('WP_USE_THEMES', false);
    require('../../../wp-load.php');



//echo mbot_woocommerce_verify_token;
$bot = new pimax\FbBotApp(mbot_woocommerce_token);

$data = json_decode(file_get_contents("php://input"), true);
$logdata = print_r($data['entry'], true);
file_put_contents("log2.html", $logdata);

    //Chef if something is received
    if (!empty($_REQUEST['hub_mode']) && $_REQUEST['hub_mode'] == 'subscribe' && $_REQUEST['hub_verify_token'] == mbot_woocommerce_verify_token) {

        // Webhook setup request
        file_put_contents("log.html", $_REQUEST['hub_challenge']);
        echo $_REQUEST['hub_challenge'];

    } else {

        // Other event
        $data = json_decode(file_get_contents("php://input"), true);
    

        // Log Webhook Calls if wp_debug is turned on
        if (defined('WP_DEBUG') && true === WP_DEBUG) {
        //Log latest connections    
            $logdata = print_r($data['entry'], true);

            file_put_contents("log.html", '<hr>', FILE_APPEND);
            file_put_contents("log.html", $logdata, FILE_APPEND);

        }


        if (!empty($data['entry'][0]['messaging'])) {
            foreach ($data['entry'][0]['messaging'] as $message) {


                $command = "";

                //If Authentication Callback is received
                if ( !empty( $message['optin'] ) ) {

                    //$bot->send( new pimax\Messages\Message( $message['sender']['id'], 'Optin, sender id: ' . $message['sender']['id'] ) );
                    
                    //Is order subsciption
                    if (derweili_mbot_woocommerce_startswith($message['optin']['ref'], 'derweiliSubscribeToOrder' )) {

                        $orderid = str_replace("derweiliSubscribeToOrder", "", $message['optin']['ref']);
                        $order = new WC_Order($orderid);



                        // store user messenger id as post meta
                        if ( isset( $message['sender']['id'] ) ) {
                            add_post_meta($orderid, 'derweili_mbot_woocommerce_customer_messenger_id', $message['sender']['id'], true);
                            $receiver_id = $message['sender']['id'];
                        }elseif ( isset( $message['optin']['user_ref'] ) ){
                            add_post_meta($orderid, 'derweili_mbot_woocommerce_customer_messenger_id', $message['optin']['user_ref'], true);
                            $receiver_id = $message['optin']['user_ref'];
                        }

                        // store user messenger id as user meta
                        if ($order->get_user_id() != 0) {
                            //add_user_meta( $order->get_user_id(), 'derweili_mbot_woocommerce_messenger_id', $message['sender']['id'], true );
                        }
                        
                        //send text message to messenger
                        $bot->send( new pimax\Messages\Message( $receiver_id, __('Thank you for your order, you will be immediately notified when your order status changes.', 'mbot-woocommerce') ) );
                        //send Order notification to messenger
                        $bot->send(new WooOrderMessage( $receiver_id, $order ) );

                        do_action('derweili_mbot_woocommerce_after_optin_message', $message, $order );

                    };

                };

            }; //endforeach
        }else{



        }; //endif

    }

}

