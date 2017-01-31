<?php
if (!defined('ABSPATH'))
{
   exit();
}


/**
* 
*/
class Derweili_Mbot_Thank_You_Page
{

	private $order_id;
	private $messenger_checkbox;
	private $messenger_checkbox_user_ref;

	private $checkbox_prechecked = false;
	private $checkbox_allow_login = false;
	private $buttom_size = 'large';
	private $button_color = 'blue';
	private $button_enforce_login = 'false';


	function __construct()
	{
		add_filter( 'woocommerce_thankyou_order_received_text',  array( &$this, 'woocommerce_thank_you_message' ), 10, 2 );

		$this->set_ui_settings();

		// place messenger script into footer
		add_action('derweili_mbot_after_fb_init',  array( &$this, 'woocommerce_thank_you_script' ), 10);
	}

	// handle send-to-messenger style attributes
	function set_ui_settings(){

		$buttom_size = get_option( 'derweili_mbot_button_size', 'large' );
			$this->buttom_size = $buttom_size;


		$button_color = get_option( 'derweili_mbot_button_color', 'blue' );
			$this->button_color = $button_color;


		$button_enforce_login = get_option( 'derweili_mbot_button_enforce_login', 'false' );
			$this->button_enforce_login = $button_enforce_login;


	}


	// check if user checked the checkbox plugin
	// display send to messenger plugin if checkbox has not been checked
	function woocommerce_thank_you_message( $example, $order ) {

		//get messenger id from user
		$messenger_checkbox_user_ref = get_post_meta( $order->id, 'derweili_mbot_messenger_checkbox_user_ref', true );
		$messenger_checkbox_checked = get_post_meta( $order->id, 'derweili_mbot_messenger_checkbox_user_test', true );
		$this->messenger_checkbox = $messenger_checkbox_checked;
		$this->messenger_checkbox_user_ref = $messenger_checkbox_user_ref;
		$this->order_id = $order->id;

		if ( !empty( $messenger_checkbox_user_ref ) && !empty( $messenger_checkbox_checked ) && 'checked' == $messenger_checkbox_checked ) {
			
			return $example;

		}else{

		    return $this->display_send_to_messenger_button( $example, $order );

		}
	}


	// send user confirmation if user checked the checkbox plugin on checkout page
	function woocommerce_thank_you_script(){ ?>

				
		<?php 


			if ( 'checked' == $this->messenger_checkbox) {

				derweili_mbot_log( 'Load user checkbox confirmation script for order ' . $this->order_id );

				echo "FB.AppEvents.logEvent('MessengerCheckboxUserConfirmation', null, {
		        'app_id':'" . mbot_woocommerce_app_id . "',
		        'page_id':'" . mbot_woocommerce_page_id . "',
		        'ref':'derweiliSubscribeToOrder" . $this->order_id . "',
		        'user_ref':'" . $this->messenger_checkbox_user_ref . "'
		      });";

			}
		?>


	<?php
	}
	// display send to messenger
	function display_send_to_messenger_button( $example, $order ){

			derweili_mbot_log( 'Display send to messenger button for order ' . $order->id );
		    
		    $send_to_messenger_button = '<div class="fb-send-to-messenger" 
		                  messenger_app_id="' . mbot_woocommerce_app_id . '" 
		                  page_id="' . mbot_woocommerce_page_id . '" 
		                  data-ref="derweiliSubscribeToOrder' . $order->id . '" 
		                  color="' . $this->button_color . '" 
		                  enforce_login="' . $this->button_enforce_login . '" 
		                  size="' . $this->buttom_size . '"></div>';
		    return '<div style="width: 100%; background-color:white; padding: 20px; margin-bottom:20px;"><h3>' . __( 'Get notified about Updates via Facebook Messenger', 'mbot-woocommerce' ) . '</h3>' . $send_to_messenger_button . '</div>' . $example;

	}

}

new Derweili_Mbot_Thank_You_Page;