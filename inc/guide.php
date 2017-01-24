<?php


/**
* NOTE: Guide the user while the configuration process of the plugin
*/
class Derweili_Mbot_Guild
{
	
	function __construct()
	{

		if ( isset( $_GET["page"] ) &&  isset( $_GET["tab"] ) && "wc-settings" == $_GET["page"] && "mbot_settings" == $_GET["tab"] ) {

			if ( ! isset( $_GET["section"] ) || empty( $_GET["section"] ) ) {
				add_action( 'admin_enqueue_scripts',  array( &$this, 'load_guide_scripts' ) );

				add_action('admin_footer', array( &$this, 'load_thickboxes' ) );
			}
			
		}

	}



	function load_guide_scripts() {

	        

	        //if ( isset( $_GET["page"] ) &&  isset( $_GET["tab"] ) && "wc-settings" == $_GET["page"] && "mbot_settings" == $_GET["tab"] ) {

	        	
	        	wp_enqueue_script( 'derweili_underscore', plugins_url('', dirname( dirname(__FILE__) ) . "/mbot-woocommerce.php") . '/js/underscore-1.4.4.js', array(), '1.4.4', true );

	        	wp_enqueue_script( 'derweili_backbone', plugins_url('', dirname( dirname(__FILE__) ) . "/mbot-woocommerce.php") . '/js/backbone-min.js', array(), 1.0, true );

	        	wp_enqueue_script( 'qtip', plugins_url('', dirname( dirname(__FILE__) ) . "/mbot-woocommerce.php") . '/js/jquery.qtip.js', array(), 1.0, true );

	        	wp_enqueue_script( 'derweili_jquery_ui', plugins_url('', dirname( dirname(__FILE__) ) . "/mbot-woocommerce.php") . '/js/jquery-ui-1.10.2.custom.js', array(), '1.10.2', true );
	        	
	        	wp_enqueue_script( 'mbot_guide_tourist_js', plugins_url('', dirname( dirname(__FILE__) ) . "/mbot-woocommerce.php") . '/js/tourist.min.js', array( 'derweili_backbone' ), 1.0, true );
	        	

		        wp_register_style( 'mbot_guide_css', plugins_url('', dirname( dirname(__FILE__) ) . "/mbot-woocommerce.php") . '/css/jquery.qtip.css', false, '1.0.0' );

		        wp_register_style( 'mbot_tourist_css', plugins_url('', dirname( dirname(__FILE__) ) . "/mbot-woocommerce.php") . '/css/tourist.css', false, '1.0.0' );
		       
		        wp_register_style( 'mbot_custom_guide_css', plugins_url('', dirname( dirname(__FILE__) ) . "/mbot-woocommerce.php") . '/css/guide.css', false, '1.0.0' );
		        
		        wp_enqueue_style( 'mbot_custom_guide_css' );
		        wp_enqueue_style( 'mbot_guide_css' );
		        wp_enqueue_style( 'mbot_tourist_css' );


	        	//if ( ! mbot_credentials_defined ) {
	        	wp_enqueue_script( 'mbot_guide', plugins_url('', dirname( dirname(__FILE__) ) . "/mbot-woocommerce.php") . '/js/guide.js', array('mbot_guide_tourist_js', 'qtip' ), 1.0, true );
	        	//}

	        	add_thickbox();

	        //}

	        

	}


	function load_thickboxes() {

		?>

<div id="derweiliThickboxPageID" style="display:none;">
    <h2>Facebook Page ID</h2>
    <p>You can find your Page ID on your Facebook Page in the "About Section"</p>
    <img src="<?php echo plugins_url('', dirname( dirname(__FILE__) ) . "/mbot-woocommerce.php"); ?>/img/guide/page-id.png" alt="Page ID" width="100%">
</div>

<div id="derweiliThickboxAppID" style="display:none;">
    <h2>Facebook App ID</h2>
    <h3>1. Creat an App <a href="https://developers.facebook.com/apps" target="_blank">here…</a></h3>
    <h3>2. Choose Basic Setup</h3>
    <img src="<?php echo plugins_url('', dirname( dirname(__FILE__) ) . "/mbot-woocommerce.php"); ?>/img/guide/choose-app-setup.png" alt="Choose Setup" width="100%">

	<h3>3. Give you App a name, a contact mail and a choose a category e.g. "App for Messenger"</h3>
    <img src="<?php echo plugins_url('', dirname( dirname(__FILE__) ) . "/mbot-woocommerce.php"); ?>/img/guide/create-app-form.png" alt="Create App Form" width="100%">

	<h3>You can find you App ID in the upper left corner of the App Setting Screen.</h3>
    <img src="<?php echo plugins_url('', dirname( dirname(__FILE__) ) . "/mbot-woocommerce.php"); ?>/img/guide/app-id.png" alt="Create App Form" width="100%">
</div>

<div id="derweiliThickboxPageToken" style="display:none;">
    <h2>Facebook Page Token</h2>
    <h3>1. Open You Facebook App Settings</h3>
    <h3>2. Go To "Products">"Settings">"Token Generation"</h3>
    <h3>3. Choose your Page</h3>
    <h3>4. You will get a Token for you page</h3>

    <img src="<?php echo plugins_url('', dirname( dirname(__FILE__) ) . "/mbot-woocommerce.php"); ?>/img/guide/page-token.png" alt="Choose Setup" width="100%">

</div>

<a href="#" class="button-primary" id="mbot_settings_tutorial_button">Need Help? Start the Tutorial</a>

		<?php

	}


}

new Derweili_Mbot_Guild();