<?php

function WooCommerce_Send_order($message, $order){

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
    /*foreach ($orderitems as $item) {

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
    }*/


    return $new_structured_message;


}