<?php
if (!defined('ABSPATH'))
{
   exit();
}


class WooOrderMessage extends pimax\Messages\StructuredMessage {

    /**
     * @var false|boolean
     */
    protected $is_reference = null;
    /**
     * @var array
     */
    protected $get_data_return = array();


	public function __construct( $recipient, $order, $is_reference = false )
    {
        $this->recipient = $recipient;
        $this->type = "receipt";
        $this->is_reference = $is_reference;


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

            $image_url = "";
            $product_id = $item["product_id"];
            if ( has_post_thumbnail( $product_id ) ) {
                $image_url = get_the_post_thumbnail_url( $product_id, "full" );
            }

        	$this->elements[] = new pimax\Messages\MessageReceiptElement(
	        		$item['name'], //headline
	        		"", //subline
	        		$image_url, //image url
	        		$item['qty'], //quantity
	        		number_format( $item['line_subtotal'], 2 ), //price
	        		$order->order_currency //currency
        		);
        }

        //Address
        $this->address = new pimax\Messages\Address([
                            'country' => apply_filters( 'derweili_mbot_wooorder_address_country', $order->shipping_country ),
                            'state' => apply_filters( 'derweili_mbot_wooorder_address_state', $order->shipping_state ),
                            'postal_code' => apply_filters( 'derweili_mbot_wooorder_address_postcode', $order->shipping_postcode ),
                            'city' => apply_filters( 'derweili_mbot_wooorder_address_city', $order->shipping_city ),
                            'street_1' => apply_filters( 'derweili_mbot_wooorder_address_street_1', $order->shipping_address_1 ),
                            'street_2' => apply_filters( 'derweili_mbot_wooorder_address_street_2', $order->shipping_address_2 ),
                        ]);

        //Summary
        $this->summary = new pimax\Messages\Summary([
                            'subtotal' => number_format( $order->get_subtotal(), 2 ),
                            'shipping_cost' => number_format( $order->order_shipping, 2 ),
                            'total_tax' => number_format( $order->get_total_tax(), 2 ),
                            'total_cost' => number_format( $order->order_total, 2 ),
                        ]);

        // fees
        if ( $order->get_fees() ) { //Only display cupouns and discount when available

            foreach ( $order->get_fees() as $order_fee) {
                $this->adjustments[] =
                new pimax\Messages\Adjustment([
                    'name' => $order_fee["name"],
                    'amount' => $order_fee["line_total"]
                ]);
            }
        	

        }

        //Adjustments (Cupouns/Discount)
        if ($order->get_total_discount() != 0) { //Only display cupouns and discount when available

            $this->adjustments[] =
                new pimax\Messages\Adjustment([
                    'name' => 'Gutscheine und Rabatte',
                    'amount' => $order->get_total_discount()
                ]);

        }
        
    }



    public function getData()
    {
        $result = [
            'attachment' => [
                'type' => 'template',
                'payload' => [
                    'template_type' => $this->type
                ]
            ]
        ];

        switch ($this->type)
        {
            case self::TYPE_BUTTON:
                $result['attachment']['payload']['text'] = $this->title;
                $result['attachment']['payload']['buttons'] = [];

                foreach ($this->buttons as $btn) {
                    $result['attachment']['payload']['buttons'][] = $btn->getData();
                }

            break;

            case self::TYPE_GENERIC:
                $result['attachment']['payload']['elements'] = [];

                foreach ($this->elements as $btn) {
                    $result['attachment']['payload']['elements'][] = $btn->getData();
                }
            break;

            case self::TYPE_RECEIPT:
                $result['attachment']['payload']['recipient_name'] = $this->recipient_name;
                $result['attachment']['payload']['order_number'] = $this->order_number;
                $result['attachment']['payload']['currency'] = $this->currency;
                $result['attachment']['payload']['payment_method'] = $this->payment_method;
                $result['attachment']['payload']['order_url'] = $this->order_url;
                $result['attachment']['payload']['timestamp'] = $this->timestamp;
                $result['attachment']['payload']['elements'] = [];

                foreach ($this->elements as $btn) {
                    $result['attachment']['payload']['elements'][] = $btn->getData();
                }

                $result['attachment']['payload']['address'] = $this->address->getData();
                $result['attachment']['payload']['summary'] = $this->summary->getData();
                $result['attachment']['payload']['adjustments'] = [];

                foreach ($this->adjustments as $btn) {
                    $result['attachment']['payload']['adjustments'][] = $btn->getData();
                }
            break;
        }

        $this->get_data_return['message'] = $result;

        if ( $this->is_reference ) {
            $this->get_data_return['recipient'] = [
                'user_ref' => $this->recipient
            ];
        }else{
            $this->get_data_return['recipient'] = [
                'id' => $this->recipient
            ];
        }

        return $this->get_data_return;
        
    }



}
