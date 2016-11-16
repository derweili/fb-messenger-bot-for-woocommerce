<?php


/*
<div class="fb-messenger-checkbox"  
  origin=PAGE_URL
  page_id=PAGE_ID
  messenger_app_id=APP_ID
  user_ref="UNIQUE_REF_PARAM" 
  prechecked="true" 
  allow_login="true" 
  size="large"></div> 
  */








/**
* 
*/
class Derweili_Mbot_Checkout_Code
{	

	private $user_ref;

	private $is_checkout_page = false;
	
	function __construct()
	{

		// set Individual user reference
		$this->user_ref = mt_rand() . microtime();
		$this->user_ref = str_replace(' ', '_', $this->user_ref );

		add_action( 'woocommerce_after_order_notes', array( &$this, 'checkout_messenger_checkbox' ) );
		add_action( 'wp_footer', array( &$this, 'woocommerce_checkout_script' ) );

		add_action('woocommerce_checkout_update_order_meta', array( &$this, 'save_messenger_checkbox_fields' ) );

	}


	public function woocommerce_checkout_script(){


				if ( $this->is_checkout_page ) { // show script only on checkout
?>



		<script>

			var messengerCheckboxUserTest = jQuery("#messenger_checkbox_user_test");

		  window.fbAsyncInit = function() {
		    FB.init({
		      appId      : '<?php echo mbot_woocommerce_app_id; ?>',
		      xfbml      : true,
		      version    : 'v2.6'
		    });

		    FB.Event.subscribe('messenger_checkbox', function(e) {
		      console.log("messenger_checkbox event");
		      console.log(e);
		      
		      if (e.event == 'rendered') {
		        console.log("Plugin was rendered");
		      } else if (e.event == 'checkbox') {
		        var checkboxState = e.state;
		        console.log("Checkbox state: " + checkboxState);

		        jQuery( messengerCheckboxUserTest ).val( checkboxState );

		      } else if (e.event == 'not_you') {
		        console.log("User clicked 'not you'");
		      } else if (e.event == 'hidden') {
		        console.log("Plugin was hidden");
		      }
		      
		    });
		  };
		</script>

	<?php
		}// endif 

	}

	public function checkout_messenger_checkbox( $checkout ) {


			$checkbox_plugin_code = '
			<div class="fb-messenger-checkbox"  
			  origin=' . get_home_url() . '
			  page_id=' . mbot_woocommerce_page_id . '
			  messenger_app_id=' . mbot_woocommerce_app_id . '
			  user_ref="' . $this->user_ref . '" 
			  prechecked="false" 
			  allow_login="true" 
			  size="large"></div>
		  ';


		    echo '<div id="my_custom_checkout_field"><h3>' . __('Contact Options') . '</h3><strong>Receive updates in Messenger</strong>' . $checkbox_plugin_code;

		    woocommerce_form_field( 'messenger_checkbox_user_ref', array(
		        'type'          => 'text',
		        'class'         => array('my-field-class form-row-wide'),
		        //'label'         => __('Fill in this field'),
		        'placeholder'   => __('Enter something'),
		        ), $this->user_ref);
		    woocommerce_form_field( 'messenger_checkbox_user_test', array(
		        'type'          => 'text',
		        'class'         => array('my-field-class form-row-wide'),
		        //'label'         => __('Fill in this field'),
		        'placeholder'   => __('Enter something'),
		        ), 'test');

		    echo '</div>';


		    $this->is_checkout_page = true;
	}


	function save_messenger_checkbox_fields( $order_id ) {

	   if ( ! empty( $_POST['messenger_checkbox_user_ref'] ) ) {
	       update_post_meta( $order_id, 'derweili_mbot_messenger_checkbox_user_ref', $_POST['messenger_checkbox_user_ref'] );
	   }
	   if ( ! empty( $_POST['messenger_checkbox_user_test'] ) ) {
	       update_post_meta( $order_id, 'derweili_mbot_messenger_checkbox_user_test', $_POST['messenger_checkbox_user_test'] );
	   }

	 }



}

new Derweili_Mbot_Checkout_Code;