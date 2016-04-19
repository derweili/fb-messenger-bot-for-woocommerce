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

    //$order = new WC_Order(2381);


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
        }

        if (!empty($data['entry'][0]['messaging'])) {
            foreach ($data['entry'][0]['messaging'] as $message) {


                $command = "";

                //If Authentication Callback is received
                if (!empty($message['optin'])) {

                    //Is order subsciption
                    if (startswith($message['optin']['ref'], 'subscribeToOrder' )) {
                        $orderid = str_replace("subscribeToOrder", "", $message['optin']['ref']);
                        
                        $bot->send( new Message( $message['sender']['id'], 'Danke für Ihre Bestellung, sie werden ab sofort über den Bestellstatus per Chat informiert. ' ) );
                        add_post_meta($orderid, 'derweili_mbot_woocommerce_customer_messenger_id', $message['sender']['id'], true);                      
                        //WooCommerce_Send_order($bot, $message, $orderid);

                        $order = new WC_Order($orderid);

                        $recipient_name = print_r($order->get_formatted_shipping_full_name(), true);

                        $new_structured_message = new StructuredMessage($message['sender']['id'],
                            StructuredMessage::TYPE_RECEIPT,
                            [
                                'recipient_name' => 'Fox Brown',
                                'order_number' => rand(10000, 99999),
                                'currency' => 'USD',
                                'payment_method' => 'VISA',
                                'order_url' => 'http://facebook.com',
                                'timestamp' => time(),
                                'elements' => [
                                    new MessageReceiptElement("First item", "Item description", "", 1, 300, "EUR"),
                                ],
                                'address' => new Address([
                                    'country' => 'US',
                                    'state' => 'CA',
                                    'postal_code' => 94025,
                                    'city' => 'Menlo Park',
                                    'street_1' => '1 Hacker Way',
                                    'street_2' => ''
                                ]),
                                'summary' => new Summary([
                                    'subtotal' => 2300,
                                    'shipping_cost' => 150,
                                    'total_tax' => 50,
                                    'total_cost' => 2500,
                                ]),
                                'adjustments' => [
                                    new Adjustment([
                                        'name' => 'New Customer Discount',
                                        'amount' => 20
                                    ]),
                                    new Adjustment([
                                        'name' => '$10 Off Coupon',
                                        'amount' => 10
                                    ])
                                ]
                            ]
                        );


                        $ordernumber = print_r($order->get_order_number(), true);
                        $new_structured_message->order_number = '#' . $ordernumber;
                        $new_structured_message->recipient_name = $order->get_formatted_shipping_full_name();
                        $new_structured_message->currency = 'EUR';
                        $new_structured_message->payment_method = $order->payment_method_title;

                        $time = strtotime( $order->order_date );
                        //$new_structured_message->timestamp = $time;


                        //Address
                        $address = [
                            'country' => $order->shipping_country,
                            'state' => '#',
                            'postal_code' => $order->shipping_postcode,
                            'city' => $order->shipping_city,
                            'street_1' => $order->shipping_address_1,
                            'street_2' => $order->shipping_address_2
                        ];
                        $new_structured_message->address->data = $address;



                        $summary = [
                            'subtotal' => number_format( $order->get_subtotal(), 2 ),
                            'shipping_cost' => number_format( $order->order_shipping, 2 ),
                            'total_tax' => number_format( $order->order_tax, 2 ),
                            'total_cost' => number_format( $order->order_total, 2 ),
                        ];

                        

                        $new_structured_message->summary->data = $summary;


                        $element = [
                            'quantity' => 2300.111,
                            'price' => 150,
                            'total_tax' => 50,
                            'total_cost' => 2500,
                        ];


                        $orderitems = $order->get_items();

                        $count = 0;
                        foreach ($orderitems as $item) {
                    $product = new WC_product($item['product_id']);
                    $image_id = $product->get_image_id();
                    $imgurl = wp_get_attachment_url($image_id);
                            $new_structured_message->elements[$count]->quantity = $item['qty'];
                            $new_structured_message->elements[$count]->price = number_format( $item['line_subtotal'], 2 );
                            $new_structured_message->elements[$count]->currency = $new_structured_message->currency;
                            $new_structured_message->elements[$count]->title = $item['name'];
                            $new_structured_message->elements[$count]->image_url = '';
                            $new_structured_message->elements[$count]->subtitle = 'subtitle';
                            $new_structured_message->elements[$count]->buttons = array();

                            $count++;
                        }

                        //Send Order*/
                        $bot->send($new_structured_message);


                    };

                };

            }; //endforeach
        }else{
            //Testing
            $message['sender']['id'] = 995353523866516;
            $order = new WC_Order(2382);
            echo $order->get_formatted_shipping_full_name();

            //WooCommerce_Send_order($bot, $message, $order);
            $bot->send(new Message($message['sender']['id'], 'Test' ));


                $new_structured_message = new StructuredMessage($message['sender']['id'],
                    StructuredMessage::TYPE_RECEIPT,
                    [
                        'recipient_name' => 'Fox Brown',
                        'order_number' => rand(10000, 99999),
                        'currency' => 'USD',
                        'payment_method' => 'VISA',
                        'order_url' => 'http://facebook.com',
                        'timestamp' => time(),
                        'elements' => [
                            new MessageReceiptElement("First item", "Item description", "", 80, 300, "EUR"),
                        ],
                        'address' => new Address([
                            'country' => 'US',
                            'state' => 'CA',
                            'postal_code' => 94025,
                            'city' => 'Menlo Park',
                            'street_1' => '1 Hacker Way',
                            'street_2' => ''
                        ]),
                        'summary' => new Summary([
                            'subtotal' => 2300,
                            'shipping_cost' => 150,
                            'total_tax' => 50,
                            'total_cost' => 2500,
                        ]),
                        /*'adjustments' => [
                            new Adjustment([
                                'name' => 'New Customer Discount',
                                'amount' => 20
                            ]),
                            new Adjustment([
                                'name' => '$10 Off Coupon',
                                'amount' => 10
                            ])
                        ]*/
                    ]
                );
                $ordernumber = print_r($order->get_order_number(), true);
                //$new_structured_message->order_number = '#' . $ordernumber;
                $new_structured_message->recipient_name = $order->get_formatted_shipping_full_name();
                $new_structured_message->currency = 'EUR';
                $new_structured_message->payment_method = $order->payment_method_title;
                $new_structured_message->timestamp = strtotime( $order->order_date );


                //Address
                $address = [
                    'country' => $order->shipping_country,
                    'state' => '#',
                    'postal_code' => $order->shipping_postcode,
                    'city' => $order->shipping_city,
                    'street_1' => $order->shipping_address_1,
                    'street_2' => $order->shipping_address_2
                ];
                $new_structured_message->address->data = $address;



                $summary = [
                    'subtotal' => number_format( $order->get_subtotal(), 2 ),
                    'shipping_cost' => number_format( $order->order_shipping, 2 ),
                    'total_tax' => number_format( $order->order_tax, 2 ),
                    'total_cost' => number_format( $order->order_total, 2 ),
                ];

                

                $new_structured_message->summary->data = $summary;


                $element = [
                    'quantity' => 2300.111,
                    'price' => 150,
                    'total_tax' => 50,
                    'total_cost' => 2500,
                ];


                $orderitems = $order->get_items();

                $count = 0;
                foreach ($orderitems as $item) {
                    $product = new WC_product($item['product_id']);
                    $image_id = $product->get_image_id();
                    $imgurl = wp_get_attachment_url($image_id);

                    $new_structured_message->elements[$count]->quantity = $item['qty'];
                    $new_structured_message->elements[$count]->price = number_format( $item['line_subtotal'], 2 );
                    $new_structured_message->elements[$count]->currency = $new_structured_message->currency;
                    $new_structured_message->elements[$count]->title = $item['name'];
                    $new_structured_message->elements[$count]->image_url = $imgurl;
                    $new_structured_message->elements[$count]->subtitle = 'subtitle';
                    $new_structured_message->elements[$count]->buttons = array();

                    $count++;
                }

                //Send Order*/
                $bot->send($new_structured_message);

                //$new_structured_message->elements[3]->quantity = 5;
                //$se->elements[3]->quantity = 5;
                //$new_structured_message->elements[3]->quantity = 5;
 echo '<hr />';
               print_r($new_structured_message->elements);
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


