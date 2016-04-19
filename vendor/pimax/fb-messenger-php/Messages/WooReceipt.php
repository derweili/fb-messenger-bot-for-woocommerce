<?php

//namespace pimax\Messages;

/**
 * Class StructuredMessage
 *
 * @package pimax\Messages
 */
class WooReceipt extends Message
{
    /**
     * Structured message button type
     */

    /**
     * Structured message generic type
     */

    /**
     * Structured message receipt type
     */
    const TYPE_RECEIPT = "receipt";

    /**
     * @var null|string
     */
    protected $type = null;

    /**
     * @var null|string
     */
    protected $title = null;

    /**
     * @var null|string
     */
    protected $subtitle = null;

    /**
     * @var array
     */
    protected $elements = [];

    /**
     * @var array
     */
    protected $buttons = [];

    /**
     * @var null|string
     */
    protected $recipient_name = null;

    /**
     * @var null|integer
     */
    protected $order_number = null;

    /**
     * @var string
     */
    protected $currency = "USD";

    /**
     * @var null|string
     */
    protected $payment_method = null;

    /**
     * @var null|string
     */
    protected $order_url = null;

    /**
     * @var null|integer
     */
    protected $timestamp = null;

    /**
     * @var array
     */
    protected $address = [];

    /**
     * @var array
     */
    protected $summary = [];

    /**
     * @var array
     */
    protected $adjustments = [];

    /**
     * StructuredMessage constructor.
     *
     * @param $recipient
     * @param $type
     * @param $data
     */
    public function __construct($recipient, $data)
    {
        $this->recipient = $recipient;

            $this->recipient_name = $data['recipient_name'];
            $this->order_number = $data['order_number'];
            $this->currency = $data['currency'];
            $this->payment_method = $data['payment_method'];
            $this->order_url = $data['order_url'];
            $this->timestamp = $data['timestamp'];
            $this->elements = $data['elements'];
            $this->address = $data['address'];
            $this->summary = $data['summary'];
            $this->adjustments = $data['adjustments'];
    }

    /**
     * Get Data
     *
     * @return array
     */
    public function getData()
    {
        $result = [
            'attachment' => [
                'type' => 'template',
                'payload' => [
                    'template_type' => 'receipt'
                ]
            ]
        ];



        $result['attachment']['payload']['recipient_name'] = $this->recipient_name;
        $result['attachment']['payload']['order_number'] = $this->order_number;
        $result['attachment']['payload']['currency'] = $this->currency;
        $result['attachment']['payload']['payment_method'] = $this->payment_method;
        $result['attachment']['payload']['order_url'] = $this->order_url;
        $result['attachment']['payload']['timestamp'] = $this->timestamp;
        $result['attachment']['payload']['elements'] = [];

        foreach ($this->elements as $btn) {
            $element = [
                'title' => $btn[0],
                'subtitle' => $btn[1],
                'image_url' => $btn[2],
                'quantity' => $btn[3],
                'price' => $btn[4],
                'currency' => $btn[5],
            ];
            $result['attachment']['payload']['elements'][] = $element;
        }

        $result['attachment']['payload']['address'] = $this->address;
        $result['attachment']['payload']['summary'] = $this->summary;
        $result['attachment']['payload']['adjustments'] = [];

        foreach ($this->adjustments as $btn) {
            $result['attachment']['payload']['adjustments'][] = $btn;
        }

        return [
            'recipient' =>  [
                'id' => $this->recipient
            ],
            'message' => $result
        ];
    }
}