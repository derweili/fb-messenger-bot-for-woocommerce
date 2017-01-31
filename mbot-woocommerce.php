<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Messengerbot for WooCommerce
 * Plugin URI:        http://www.derweili.de
 * Description:       Stay in contact with you customers via Facebook Messenger. Send them notifications when the order status changes.
 * Version:           1.21
 * Author:            derweili
 * Author URI:        http://www.derweili.de/
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Domain Path:       /languages/
 * Text Domain:		  mbot-woocommerce
 * GitHub Plugin URI: https://github.com/derweili/fb-messenger-bot-for-woocommerce
 *
 */
if (!defined('ABSPATH'))
{
   exit();
}





/**
* Plugin Class
*/
class DERWEILI_WOOCOMMERCE_FBBOT
{
	
	public function __construct()
	{
		$this->load_vendors();
		$this->define_credentials();


		if ( $this->credentials_not_empty() ) {
			$this->load_dependencies();
		}

		add_action( 'admin_init', array( &$this, 'load_admin_dependencies' ) );
		add_action( 'init', array( &$this, 'load_text_domain' ) );
		add_action( 'wp_head', array( &$this, 'inline_css' ) );
		register_activation_hook( dirname( __FILE__ ) . '/install.php', 'mbot_install_mbot' );

	}

	// include php messenger sdk
	private function load_vendors() {

		include('vendor/fb-messenger-php/FbBotApp.php');
		include('vendor/fb-messenger-php/Messages/Message.php');
		include('vendor/fb-messenger-php/Messages/MessageButton.php');
		include('vendor/fb-messenger-php/Messages/StructuredMessage.php');
		include('vendor/fb-messenger-php/Messages/MessageElement.php');
		include('vendor/fb-messenger-php/Messages/MessageReceiptElement.php');
		include('vendor/fb-messenger-php/Messages/Address.php');
		include('vendor/fb-messenger-php/Messages/Summary.php');
		include('vendor/fb-messenger-php/Messages/Adjustment.php');

	}

	// Save credentials in php constants
	private function define_credentials() {
		
		//Define Messenger App Token
		define( "mbot_woocommerce_token", get_option( 'derweili_mbot_page_token' ) );

		//Define Webhook Verify Token
		define("mbot_woocommerce_verify_token", get_option( 'derweili_mbot_verify_token' ) );

		//Define Messenger App ID
		define("mbot_woocommerce_app_id", get_option( 'derweili_mbot_messenger_app_id' ) );

		//Define Page ID
		define("mbot_woocommerce_page_id", get_option( 'derweili_mbot_page_id' ) );

	}

	// function to check if credentials are stored and available
	private function credentials_not_empty() {
		if ( !empty( mbot_woocommerce_token ) && !empty( mbot_woocommerce_verify_token ) && !empty( mbot_woocommerce_app_id ) && !empty( mbot_woocommerce_page_id ) ){

			define( 'mbot_credentials_defined', true);

			return true;
		}else{

			define( 'mbot_credentials_defined', false);

			return false;
		}
	}


	// load other dependencies
	private function load_dependencies() {
		
		include('inc/error-log.php');
		include('inc/WooOrderMessage.php');
		include('inc/derweili-message.php');
		include('inc/derweili-structured-message.php');
		include('inc/woocommerce-thank-you.php');
		include('inc/filter-functions.php');
		include('inc/checkout-fields.php');
		include('inc/mbot-order.php');
		include('inc/footer-script.php');
		include('inc/shipping.php');

		include('inc/webhook-setup.php');
		include('webhook.php');

	}

	public function load_admin_dependencies() {

		include('inc/woocommerce-order-status-messages.php');
		include('inc/settingspage.php');
		include('inc/domain-whitelisting.php');
		include('inc/update.php');
		include('inc/guide.php');
		include('inc/order-status-action-manager.php');

		add_filter( 'woocommerce_get_settings_pages', array( &$this, 'load_wc_settings' ) ); // Add Settings Page
		

	}

	public function load_wc_settings( $settings ){
		$settings[] = include( 'inc/wc-plugin-settings.php' );  
    	return $settings;
	}

	public function load_filter_functions() {

		include('inc/filter-functions.php');


	}

	/**
	 * Load plugin textdomain.
	 *
	 * @since 1.0.0
	 */
	public function load_text_domain() {
	  //load_plugin_textdomain( 'mbot-woocommerce', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 

		$domain = 'mbot-woocommerce';
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
		// wp-content/languages/plugin-name/plugin-name-de_DE.mo
		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		// wp-content/plugins/plugin-name/languages/plugin-name-de_DE.mo
		load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );

	}

	public function inline_css() {
		?>
		<style>.mbot-woocommerce-hiddenfield{display:none;}</style>
		<?php
	}

}

// Init App

new DERWEILI_WOOCOMMERCE_FBBOT;