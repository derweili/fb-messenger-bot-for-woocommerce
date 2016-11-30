<?php
if (!defined('ABSPATH'))
{
   exit();
}

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
 

/**
* Delete all plugin data on deinstallation
*/
class DERWEILI_Mbot_Uninstall
{

	
	function __construct()
	{
		$this->remove_site_from_whitelisted_domains();
		$this->remove_options();
	}

	function remove_site_from_whitelisted_domains() {

		$settings = new DERWEEILI_MBOT_WOOCOMMERCE_SETTINGS_PAGE();
		$settings->domain_whitelisting_button('remove');

	}

	function remove_options() {
		
		delete_option( 'derweili_mbot_page_token' );
		delete_option( 'derweili_mbot_verify_token' );
		delete_option( 'derweili_mbot_messenger_app_id' );
		delete_option( 'derweili_mbot_page_id' );

		delete_option( 'derweili_mbot_checkbox_size' );
		delete_option( 'derweili_mbot_button_color' );
		delete_option( 'derweili_mbot_fb_checkbox_prechecked' );
		delete_option( 'derweili_mbot_fb_checkbox_allow_login' );
	}

}

new DERWEILI_Mbot_Uninstall();