<?php

$verify_token = ""; // Verify token
$token = ""; // Page token

if (file_exists(__DIR__.'/config.php')) {
    $config = include __DIR__.'/config.php';
    $verify_token = $config['verify_token'];
    $token = $config['token'];
}

//require_once(__DIR__ . '/vendor/autoload.php');

require_once(__DIR__ . '/vendor/pimax/fb-messenger-php/FbBotApp.php');
require_once(__DIR__ . '/vendor/pimax/fb-messenger-php/Messages/Message.php');
require_once(__DIR__ . '/vendor/pimax/fb-messenger-php/Messages/MessageButton.php');
require_once(__DIR__ . '/vendor/pimax/fb-messenger-php/Messages/StructuredMessage.php');
require_once(__DIR__ . '/vendor/pimax/fb-messenger-php/Messages/MessageElement.php');
require_once(__DIR__ . '/vendor/pimax/fb-messenger-php/Messages/MessageReceiptElement.php');
require_once(__DIR__ . '/vendor/pimax/fb-messenger-php/Messages/Address.php');
require_once(__DIR__ . '/vendor/pimax/fb-messenger-php/Messages/Summary.php');
require_once(__DIR__ . '/vendor/pimax/fb-messenger-php/Messages/Adjustment.php');
/*
use pimax\FbBotApp;
use pimax\Messages\Message;
use pimax\Messages\MessageButton;
use pimax\Messages\StructuredMessage;
use pimax\Messages\MessageElement;
use pimax\Messages\MessageReceiptElement;
use pimax\Messages\Address;
use pimax\Messages\Summary;
use pimax\Messages\Adjustment;
*/
// Make Bot Instance

