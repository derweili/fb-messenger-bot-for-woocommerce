<?php

//echo dirname(__FILE__);


//Load WordPress functions

if ( !isset($wp_did_header) ) {

	//Load Wordpress Functions
   // $wp_did_header = true;
   // require_once( '../../../wp-load.php' );
   // wp();
   // require_once( ABSPATH . WPINC . '/template-loader.php' );
    define('WP_USE_THEMES', false);
    require('../../../wp-load.php');



//echo mbot_woocommerce_verify_token;
$bot = new FbBotApp(mbot_woocommerce_token);


    //Chef if something is received
    if (!empty($_REQUEST['hub_mode']) && $_REQUEST['hub_mode'] == 'subscribe' && $_REQUEST['hub_verify_token'] == mbot_woocommerce_verify_token) {

        // Webhook setup request
        file_put_contents("log.html", $_REQUEST['hub_challenge']);
        echo $_REQUEST['hub_challenge'];

        $bot->send( new Message( 995353523866516, 'Hub reveived' ) );
    } else {

        // Other event
        $data = json_decode(file_get_contents("php://input"), true);
    
        //Log latest connections    
        
        $logdata = print_r($data['entry'][0]['messaging'], true);

        file_put_contents("log.html", $logdata);

        if (!empty($data['error'])) {
            file_put_contents("error.html", $data['error']['message']);
            $bot->send( new Message( 995353523866516, 'Error Message' ) );
        }

        if (!empty($data['entry'][0]['messaging'])) {
            $bot->send( new Message( 995353523866516, 'messaging not empty' ) );
            foreach ($data['entry'][0]['messaging'] as $message) {
                $bot->send( new Message( 995353523866516, 'foreach messaging' ) );


                $command = "";

                //If Authentication Callback is received
                if (!empty($message['optin'])) {
                    $bot->send( new Message( 995353523866516, 'optin not empty' ) );

                    //Is order subsciption
                    if (startswith($message['optin']['ref'], 'derweiliSubscribeToOrder' )) {
                        $bot->send( new Message( 995353523866516, 'optin starty with derweiliSubscibeToOrder' ) );
                        $orderid = str_replace("derweiliSubscribeToOrder", "", $message['optin']['ref']);
                        $order = new WC_Order($orderid);


                        //save messenger id to order
                        add_post_meta($orderid, 'derweili_mbot_woocommerce_customer_messenger_id', $message['sender']['id'], true);

                        //save messenger id to user if available
                        if ($order->get_user_id() != 0) {
                            add_user_meta( $order->get_user_id(), 'derweili_mbot_woocommerce_messenger_id', $message['sender']['id'], true );
                        }
                        
                        //send text message to messenger
                        $bot->send( new Message( $message['sender']['id'], 'Danke für Ihre Bestellung, sie werden ab sofort über den Bestellstatus per Chat informiert. ' ) );
                        //send Order notification to messenger
                        $bot->send(new WooOrderMessage( $message['sender']['id'], $order ) );

                    };

                };

            }; //endforeach
        }else{
            $bot->send( new Message( 995353523866516, 'messages empty' ) );
            //Testing
            $message['sender']['id'] = 995353523866516;
            $order = new WC_Order(2385);
            echo $order->get_formatted_shipping_full_name();



#######


           $bot->send(new WooOrderMessage( $message['sender']['id'], $order ) );


#########
echo $order->order_currency;
echo $order->get_total_discount();

 echo '<hr />';
               echo '<hr alt/>';
               
               echo time();

               echo '<hr />';
               echo strtotime($order->order_date);

                $product = new WC_product($item['product_id']);
                $image_id = $product->get_image_id();
                $imgurl = wp_get_attachment_url($image_id);
               

               //echo $new_structured_message->elements[0]->quantity;

        }; //endif

       

    }

}
//$derweili_mbot = new FbBotApp($token);


