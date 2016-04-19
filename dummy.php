<?php

$verify_token = ""; // Verify token
$token = ""; // Page token

if (file_exists(__DIR__.'/config.php')) {
    $config = include __DIR__.'/config.php';
    $verify_token = $config['verify_token'];
    $token = $config['token'];
}

require_once(dirname(__FILE__) . '/vendor/autoload.php');

use pimax\FbBotApp;
use pimax\Messages\Message;
use pimax\Messages\MessageButton;
use pimax\Messages\StructuredMessage;
use pimax\Messages\MessageElement;
use pimax\Messages\MessageReceiptElement;
use pimax\Messages\Address;
use pimax\Messages\Summary;
use pimax\Messages\Adjustment;

// Make Bot Instance
$bot = new FbBotApp($token);

// Receive something
if (!empty($_REQUEST['hub_mode']) && $_REQUEST['hub_mode'] == 'subscribe' && $_REQUEST['hub_verify_token'] == $verify_token) {

    // Webhook setup request
    echo $_REQUEST['hub_challenge'];
} else {

    // Other event

    $data = json_decode(file_get_contents("php://input"), true);

    file_put_contents("log.html", $data['entry'][0]['messaging']);
    //file_put_contents("log.html", '<br />', FILE_APPEND);

    if (!empty($data['entry'][0]['messaging'])) {
        foreach ($data['entry'][0]['messaging'] as $message) {

            // Skipping delivery messages
            if (!empty($message['delivery'])) {
                continue;
            }

            $command = "";

            // When bot receive message from user
            if (!empty($message['message'])) {
                $command = $message['message']['text'];

            // When bot receive button click from user
            } else if (!empty($message['postback'])) {
                $command = $message['postback']['payload'];
            } else if (!empty($message['optin'])) {
                $bot->send(new Message($message['sender']['id'], 'Vielen Dank für deine Bestellung' ));
                //$bot->send(new Message($message['sender']['id'], 'Optin Key' ));
                //$bot->send(new Message($message['sender']['id'], $message['optin']['ref'] ));
                $command = 'Bestellung';
            }

            // Handle command
            switch ($command) {

                // When bot receive "text"
                case 'Text':
                    $bot->send(new Message($message['sender']['id'], 'This is a simple text message.' ));
                    break;
                // When bot receive "text"
                case 'Messenger ID':
                    $bot->send(new Message($message['sender']['id'], 'Deine Messenger ID lautet: 
' . $message['sender']['id']));
                    break;

                // When bot receive "button"
                case 'Jetzt anhoeren':
                  $bot->send(new StructuredMessage($message['sender']['id'],
                      StructuredMessage::TYPE_BUTTON,
                      [
                          'text' => 'Jetzt anhoeren auf:',
                          'buttons' => [
                              new MessageButton(MessageButton::TYPE_POSTBACK, 'iTunes'),
                              new MessageButton(MessageButton::TYPE_POSTBACK, 'Google Play'),
                              new MessageButton(MessageButton::TYPE_POSTBACK, 'Amazon'),
                              new MessageButton(MessageButton::TYPE_POSTBACK, 'Spotify')
                          ]
                      ]
                  ));
                break;

                // When bot receive "button"
                case 'Button':
                  $bot->send(new StructuredMessage($message['sender']['id'],
                      StructuredMessage::TYPE_BUTTON,
                      [
                          'text' => 'Choose category',
                          'buttons' => [
                              new MessageButton(MessageButton::TYPE_POSTBACK, 'First button'),
                              new MessageButton(MessageButton::TYPE_POSTBACK, 'Second button'),
                              new MessageButton(MessageButton::TYPE_POSTBACK, 'Third button')
                          ]
                      ]
                  ));
                break;

                // When bot receive "generic"
                case 'Bandmitglieder':

                    $bot->send(new StructuredMessage($message['sender']['id'],
                        StructuredMessage::TYPE_GENERIC,
                        [
                            'elements' => [
                                new MessageElement("The Project", "", "https://www.theprojectmusic.de/assets/img/band-gesamt-1500.jpg", [
                                    new MessageButton(MessageButton::TYPE_POSTBACK, 'Jetzt anhoeren'),
                                    new MessageButton(MessageButton::TYPE_WEB, 'Website', 'https://www.theprojectmusic.de')
                                ]),

                                new MessageElement("Maren", "Gesang, Klavier", "https://www.theprojectmusic.de/assets/img/maren.jpg", [
                                    //new MessageButton(MessageButton::TYPE_POSTBACK, 'First button'),
                                    //new MessageButton(MessageButton::TYPE_POSTBACK, 'Second button')
                                ]),

                                new MessageElement("Hessi", "Gitarre, Klavier", "https://www.theprojectmusic.de/assets/img/hessi.jpg", [
                                    //new MessageButton(MessageButton::TYPE_POSTBACK, 'First button'),
                                    //new MessageButton(MessageButton::TYPE_POSTBACK, 'Second button')
                                ])
                            ]
                        ]
                    ));
                    
                break;

                // When bot receive "receipt"
                case 'Bestellung':
                    $bot->send(new StructuredMessage($message['sender']['id'],
                        StructuredMessage::TYPE_RECEIPT,
                        [
                            'recipient_name' => 'Fox Brown',
                            'order_number' => rand(10000, 99999),
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
                break;

                // Other message received -> Send Original Message back to sender
                default:
                    $bot->send(new Message($message['sender']['id'], $command));
            }
        }
    }
}
//$bot->send(new Message(995353523866516, 'This is a simple text message.' ));

/*
$bot->send(new StructuredMessage($message['sender']['995353523866516'],
    StructuredMessage::TYPE_RECEIPT,
    [
        'recipient_name' => 'Fox Brown',
        'order_number' => rand(10000, 99999),
        'currency' => 'USD',
        'payment_method' => 'VISA',
        'order_url' => 'http://facebook.com',
        'timestamp' => time(),
        'elements' => [
           'title' => 'Long Nights and Hurricanes',
           'subtitle' => '',
           'quantity' => '1',
           'price' => '7',
           'currency' => 'EURO',
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
));*/