<?php


/**
* NOTE: Guide the user while the configuration process of the plugin
*/
class Derweili_Mbot_Guild
{
	
	function __construct()
	{
		add_action( 'admin_enqueue_scripts',  array( &$this, 'load_guide_scripts' ) );
	}



	function load_guide_scripts() {

	        

	        if ( isset( $_GET["page"] ) &&  isset( $_GET["tab"] ) && "wc-settings" == $_GET["page"] && "mbot_settings" == $_GET["tab"] ) {

	        	//wp_enqueue_script( 'backbone', plugins_url('', dirname( dirname(__FILE__) ) . "/mbot-woocommerce.php") . '/js/backbone-min.js');
	        	wp_enqueue_script( 'mbot_guide_tourist_js', plugins_url('', dirname( dirname(__FILE__) ) . "/mbot-woocommerce.php") . '/js/tourist.min.js', array('backbone'), 1.0, true );

		        wp_register_style( 'mbot_guide_css', plugins_url('', dirname( dirname(__FILE__) ) . "/mbot-woocommerce.php") . '/css/tourist.css', false, '1.0.0' );
		        
		        wp_enqueue_style( 'mbot_guide_css' );


	        	//if ( ! mbot_credentials_defined ) {
	        	wp_enqueue_script( 'mbot_guide', plugins_url('', dirname( dirname(__FILE__) ) . "/mbot-woocommerce.php") . '/js/guide.js', array('mbot_guide_tourist_js'), 1.0, true );
	        	//}



	        }

	        

	}

}

new Derweili_Mbot_Guild();