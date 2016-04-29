<?php

//Load WordPress functions

if ( !isset($wp_did_header) ) {

    define('WP_USE_THEMES', false);
    require('../../../wp-load.php');



//echo mbot_woocommerce_verify_token;
$bot = new FbBotApp(mbot_woocommerce_token);


    //Chef if something is received
    if (!empty($_REQUEST['hub_mode']) && $_REQUEST['hub_mode'] == 'subscribe' && $_REQUEST['hub_verify_token'] == mbot_woocommerce_verify_token) {

        // Webhook setup request
        file_put_contents("log.html", $_REQUEST['hub_challenge']);
        echo $_REQUEST['hub_challenge'];

    } else {

        // Other event
        $data = json_decode(file_get_contents("php://input"), true);
    
        //Log latest connections    
        
        $logdata = print_r($data['entry'][0]['messaging'], true);

        file_put_contents("log.html", $logdata);

        if (!empty($data['error'])) {
            file_put_contents("error.html", $data['error']['message']);
            $bot->send( new Message( 995353523866516, 'error message: ' . $message['error']['message'] ) );
        }

        if (!empty($data['entry'][0]['messaging'])) {
            foreach ($data['entry'][0]['messaging'] as $message) {


                $command = "";

                //If Authentication Callback is received
                if (!empty($message['optin'])) {

                    $bot->send( new Message( 995353523866516, 'optinmessage: ' . $message['optin']['ref'] ) );
                    $bot->send( new Message( 995353523866516, 'sender id: ' . $message['sender']['id'] ) );

                    //Is order subsciption
                    if (derweili_mob_woocommerce_startswith($message['optin']['ref'], 'derweiliSubscribeToOrder' )) {
                        $bot->send( new Message( 995353523866516, 'Message starts with derweiliSubscribeToOrder' ) );
                        
                        $orderid = str_replace("derweiliSubscribeToOrder", "", $message['optin']['ref']);
                        $order = new WC_Order($orderid);



                        //save messenger id to order
                        add_post_meta($orderid, 'derweili_mbot_woocommerce_customer_messenger_id', $message['sender']['id'], true);

                        //save messenger id to user if available
                        if ($order->get_user_id() != 0) {
                            //add_user_meta( $order->get_user_id(), 'derweili_mbot_woocommerce_messenger_id', $message['sender']['id'], true );
                        }
                        
                        //send text message to messenger
                        $bot->send( new Message( $message['sender']['id'], 'Danke für Ihre Bestellung, sie werden ab sofort über den Bestellstatus per Chat informiert. ' ) );
                        //send Order notification to messenger
                        $bot->send(new WooOrderMessage( $message['sender']['id'], $order ) );

                    };

                };

            }; //endforeach
        }else{

            $order = new WC_Order(2387);
            $bot->send( new Message( 995353523866516, 'Danke für Ihre Bestellung, sie werden ab sofort über den Bestellstatus per Chat informiert. ' ) );
            $bot->send(new WooOrderMessage( 995353523866516, $order ) );

            echo get_current_user_id();


        }; //endif

       

    }

}


