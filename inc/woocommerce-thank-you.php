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
	
	function __construct()
	{
		add_filter( 'woocommerce_thankyou_order_received_text',  array( &$this, 'woocommerce_thank_you_message' ), 10, 2 );

		// place messenger script into footer
		add_action('wp_footer',  array( &$this, 'woocommerce_thank_you_script' ), 10);
	}

	function woocommerce_thank_you_message( $example, $order ) {

		//get messenger id from user
		//$usermessengerid = get_user_meta( $order->get_user_id(), 'derweili_mbot_woocommerce_messenger_id', true );
		//if ( empty( $usermessengerid ) ) { // Display send to messenger button if no messenger id is stored
		$messenger_checkbox_user_ref = get_post_meta( $order->id, 'derweili_mbot_messenger_checkbox_user_ref', true );
		$messenger_checkbox_checked = get_post_meta( $order->id, 'derweili_mbot_messenger_checkbox_user_test', true );
		$this->messenger_checkbox = $messenger_checkbox_checked;
		$this->messenger_checkbox_user_ref = $messenger_checkbox_user_ref;
		$this->order_id = $order->id;

		if ( !empty( $messenger_checkbox_user_ref ) && !empty( $messenger_checkbox_checked ) && 'checked' == $messenger_checkbox_checked ) {
			
			//directy call Facebook
			return $this->display_send_to_messenger_button( $example, $order );
		}else{
			//display send to messenger button
		    return $this->display_send_to_messenger_button( $example, $order );
		}
	}


	function woocommerce_thank_you_script(){ ?>
		<script>
		  /*window.fbAsyncInit = function() {
			    FB.init({
			      appId      : '<?php echo mbot_woocommerce_app_id; ?>',
			      xfbml      : true,
			      version    : 'v2.6'
			    });
			  };*/




			  (function(d, s, id){
			     var js, fjs = d.getElementsByTagName(s)[0];
			     if (d.getElementById(id)) {return;}
			     js = d.createElement(s); js.id = id;
			     js.src = "//connect.facebook.net/en_US/sdk.js";
			     fjs.parentNode.insertBefore(js, fjs);
			   }(document, 'script', 'facebook-jssdk'));

				
					  <?php 
					  	if ( 'checked' == $this->messenger_checkbox) {
					  		echo "jQuery(document).ready(function($) {
					window.fbAsyncInit = function() {";
					  		echo "FB.init({
						      appId      : '" . mbot_woocommerce_app_id . "',
						      xfbml      : true,
						      version    : 'v2.6'
						    });";
					  		echo "FB.AppEvents.logEvent('MessengerCheckboxUserConfirmation', null, {
					            'app_id':'" . mbot_woocommerce_app_id . "',
					            'page_id':'" . mbot_woocommerce_page_id . "',
					            'ref':'derweiliSubscribeToOrder" . $this->order_id . "',
					            'user_ref':'" . $this->messenger_checkbox_user_ref . "'
					          });";

					        echo "};
				}); // ready";
					  	}
					  ?>





		</script>
	<?php
	}

	function display_send_to_messenger_button( $example, $order ){
		    
		    $send_to_messenger_button = '<div class="fb-send-to-messenger" 
		                  messenger_app_id="' . mbot_woocommerce_app_id . '" 
		                  page_id="' . mbot_woocommerce_page_id . '" 
		                  data-ref="derweiliSubscribeToOrder' . $order->id . '" 
		                  color="blue" 
		                  size="standard"></div>';
		    return '<div style="width: 100%; background-color:white; padding: 20px; margin-bottom:20px;"><h3>' . __( 'Get notified about Updates via Facebook Messenger', 'mbot-woocommerce' ) . '</h3>' . $send_to_messenger_button . '</div>' . $example;

	}

}

new Derweili_Mbot_Thank_You_Page;

//
// hook into thank you page
//




