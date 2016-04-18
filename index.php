<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Facebook Messenger Bot Version 2
 * Plugin URI:        http://www.werbeagenten.de
 * Description:       Stay in contact with you customers via Facebook Messenger. Send them notifications when order status changes.
 * Version:           1.0
 * Author:            derweili
 * Author URI:        http://www.derweili.de/
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Domain Path:       /mbot-for-woocommerce/languages/
 * GitHub Plugin URI: https://github.com/angelleye/paypal-woocommerce
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

include('inc/woocommerce-settings.php');
include('inc/woocommerce-thank-you.php');

//Define Messenger App Token
define("mbot_woocommerce_token", "EAAW0k7Iyff4BALJPNJorl031tIJYtyuJzDZCfpSPZB125kZCBGnS9hrt8QIYZCvguzCEx0sW1OR2orQUwMcZBqr3XJz7pD5lFvT8Uvez3oPCU2qvkc1byPRw1pZAl4diD9dKYdwwTZBb054wVnxjwF6WaSLlwEwoxwJe40ezt4cfQZDZD");

//Define Messenger App Token
define("mbot_woocommerce_verify_token", "my_test_verify_tooken_for_alles_teuer_shop_messenger_bot");

//add_action('wp_head','hook_css');

function hook_css() {
	echo 'test';

	$bot = new FbBotApp(mbot_woocommerce_token);

	$bot->send(new Message('995353523866516', 'Vielen Dank für deine Bestellung' ));
	

}

function startswith($haystack, $needle){ 
    return strpos($haystack, $needle) === 0;
}