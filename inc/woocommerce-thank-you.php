<?php
if (!defined('ABSPATH'))
{
   exit();
}


function derweili_mbot_woocommerce_thank_you_message( $example, $order ) {
    // Maybe modify $example in some way.
    $send_to_messenger_button = '<div class="fb-send-to-messenger" 
                  messenger_app_id="1605921326398974" 
                  page_id="193236457477337" 
                  data-ref="subscribeToOrder' . $order->id . '" 
                  color="blue" 
                  size="large"></div>';
    return '<div style="width: 100%; background-color:white; padding: 20px; margin-bottom:20px;"><strong></strong>' . $send_to_messenger_button . '</div>' . $example;
}
add_filter( 'woocommerce_thankyou_order_received_text', 'derweili_mbot_woocommerce_thank_you_message', 10, 2 );




add_action('wp_footer', 'derweili_mbot_woocommerce_thank_you_script', 10);

function derweili_mbot_woocommerce_thank_you_script(){ ?>
	<script>
	  window.fbAsyncInit = function() {
	    FB.init({
	      appId      : '1605921326398974',
	      xfbml      : true,
	      version    : 'v2.6'
	    });
	  };

	  (function(d, s, id){
	     var js, fjs = d.getElementsByTagName(s)[0];
	     if (d.getElementById(id)) {return;}
	     js = d.createElement(s); js.id = id;
	     js.src = "//connect.facebook.net/en_US/sdk.js";
	     fjs.parentNode.insertBefore(js, fjs);
	   }(document, 'script', 'facebook-jssdk'));
	</script>
<?php
}