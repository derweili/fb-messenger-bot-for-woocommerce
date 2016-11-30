<?php
if (!defined('ABSPATH'))
{
   exit();
}


add_action( 'wp_footer', 'derweili_footer_script' );
function derweili_footer_script() {

	?>
	
		<script>
			
			<?php do_action( 'derweili_mbot_before_fb_js_sdk' ) ?>

			(function(d, s, id){
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) {return;}
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/en_US/sdk.js";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));

			window.fbAsyncInit = function() {
				FB.init({
				  appId      : '<?php echo mbot_woocommerce_app_id; ?>',
				  xfbml      : true,
				  version    : 'v2.6'
				});

				<?php do_action( 'derweili_mbot_after_fb_init' ) ?>

			}


		</script>


	<?php

}


add_action( 'derweili_mbot_before_fb_js_sdk', 'derweili_checkbox_script_before_init');

function derweili_checkbox_script_before_init() {

	echo 'var messengerCheckboxUserTest = jQuery("#messenger_checkbox_user_test");';

}


add_action( 'derweili_mbot_after_fb_init', 'derweili_checkbox_script');

function derweili_checkbox_script() {
	global $woocommerce;

	if ( is_checkout() && ! is_wc_endpoint_url('order-received') ) : // Check if user is on checkout page but not on order-received page

	?>
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
	<?php

	endif; // is_checkout

}


