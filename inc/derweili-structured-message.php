<?php
if (!defined('ABSPATH'))
{
   exit();
}


/**
 * Class StructuredMessage
 *
 * @package pimax\Messages
 */
class Der_Weili_Structured_Message extends pimax\Messages\StructuredMessage
{

    protected $get_data_return = array();

    protected $recipient_type = 'id';
    
    /**
     * StructuredMessage constructor.
     *
     * @param string $recipient
     * @param string $type
     * @param array  $data
     */
    public function __construct($recipient, $type, $data)
    {

        if( $is_reference ) $this->recipient_type = 'user_ref';

        $this->recipient = $recipient;
        $this->type = $type;

        switch ($type)
        {
            case self::TYPE_BUTTON:
                $this->title = $data['text'];
                $this->buttons = $data['buttons'];
            break;

            case self::TYPE_GENERIC:
                $this->elements = $data['elements'];
            break;

            case self::TYPE_RECEIPT:
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
            break;
        }
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
        $this->get_data_return['recipient'] = array();
        $this->get_data_return['recipient'][$this->recipient_type] = $this->recipient;

        

        return $this->get_data_return;
    }
}