<?php

function WooCommerce_Send_order($bot, $order_id){

	$order = new WC_Order($order_id);

	$order_number = $order->get_order_number();

	$bot->send(new StructuredMessage($message['sender']['id'],
	    StructuredMessage::TYPE_RECEIPT,
	    [
	        'recipient_name' => 'Fox Brown',
	        'order_number' => $order_id,
	        'currency' => 'EUR',
	        'payment_method' => 'VISA',
	        'order_url' => 'http://facebook.com',
	        'timestamp' => time(),
	        'elements' => [
	            new MessageReceiptElement("First item", "Item description", "", 1, 300, "EUR"),
	            new MessageReceiptElement("Second item", "Item description", "", 2, 200, "EUR"),
	            new MessageReceiptElement("Third item", "Item description", "", 3, 1800, "EUR"),
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
	));


}