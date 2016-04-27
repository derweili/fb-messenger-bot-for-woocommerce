<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Facebook Messenger Bot Version 2
 * Plugin URI:        http://www.derweili.de
 * Description:       Stay in contact with you customers via Facebook Messenger. Send them notifications when order status changes.
 * Version:           1.0
 * Author:            derweili
 * Author URI:        http://www.derweili.de/
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Domain Path:       /mbot-for-woocommerce/languages/
 * GitHub Plugin URI: https://github.com/derweili/fb-messenger-bot-for-woocommerce
 *
 */
if (!defined('ABSPATH'))
{
   exit();
}


//Include PHP Classes for API Call and Structured Messages
include('vendor/pimax/fb-messenger-php/FbBotApp.php');
include('vendor/pimax/fb-messenger-php/Messages/Message.php');
include('vendor/pimax/fb-messenger-php/Messages/MessageButton.php');
include('vendor/pimax/fb-messenger-php/Messages/StructuredMessage.php');
include('vendor/pimax/fb-messenger-php/Messages/MessageElement.php');
include('vendor/pimax/fb-messenger-php/Messages/MessageReceiptElement.php');
include('vendor/pimax/fb-messenger-php/Messages/Address.php');
include('vendor/pimax/fb-messenger-php/Messages/Summary.php');
include('vendor/pimax/fb-messenger-php/Messages/Adjustment.php');


include('inc/WooOrderMessage.php');
include('inc/woocommerce-thank-you.php');
include('inc/woocommerce-order-status-messages.php');
include('inc/settingspage.php');

//Define Messenger App Token
define( "mbot_woocommerce_token", get_option( 'derweili_mbot_page_token' ) );

//Define Messenger App Token
define("mbot_woocommerce_verify_token", get_option( 'derweili_mbot_verify_token' ) );

//Define Messenger App Token
define("mbot_woocommerce_app_id", get_option( 'derweili_mbot_messenger_app_id' ) );

//Define Messenger App Token
define("mbot_woocommerce_page_id", get_option( 'derweili_mbot_page_id' ) );



function startswith($haystack, $needle){ 
    return strpos($haystack, $needle) === 0;
}

