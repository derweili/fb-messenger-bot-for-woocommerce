<?php
class WooOrderMessage extends pimax\Messages\StructuredMessage {

	public function __construct( $recipient, $order )
    {
        $this->recipient = $recipient;
        $this->type = "receipt";

        $this->recipient_name = $order->get_formatted_shipping_full_name();
        $this->order_number = $order->get_order_number();
        //$this->order_number = rand(10000, 99999);
        $this->currency = $order->order_currency;
        $this->payment_method = $order->payment_method_title;
        $this->order_url = 'http://derweili.de/';
        $this->timestamp = strtotime( $order->order_date );
        $this->elements = [];


        //Elements
        foreach ($order->get_items() as $item) {
        	$this->elements[] = new pimax\Messages\MessageReceiptElement(
	        		$item['name'], //headline
	        		"", //subline
	        		"", //image url
	        		$item['qty'], //quantity
	        		number_format( $item['line_subtotal'], 2 ), //price
	        		$order->order_currency //currency
        		);
        }

        //Address
        $this->address = new pimax\Messages\Address([
                            'country' => $order->shipping_country,
                            'state' => '#',
                            'postal_code' => $order->shipping_postcode,
                            'city' => $order->shipping_city,
                            'street_1' => $order->shipping_address_1,
                            'street_2' => $order->shipping_address_2
                        ]);

        //Summary
        $this->summary = new pimax\Messages\Summary([
                            'subtotal' => number_format( $order->get_subtotal(), 2 ),
                            'shipping_cost' => number_format( $order->order_shipping, 2 ),
                            'total_tax' => number_format( $order->order_tax, 2 ),
                            'total_cost' => number_format( $order->order_total, 2 ),
                        ]);

        //Adjustments (Cupouns/Discount)
        if ($order->get_total_discount() != 0) { //Only display cupouns and discount when available

        	$this->adjustments = [
        		new pimax\Messages\Adjustment([
                    'name' => 'Gutscheine und Rabatte',
                    'amount' => $order->get_total_discount()
                ])
        	];

        }
        
    }

}
