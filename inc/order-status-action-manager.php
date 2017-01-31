<?php

/**
* NOTE: Support for WooCommerce Order Status & Action Manager
* @since 1.16
*/
class Derweili_Custom_Order_Status_Handler
{

	public $custom_order_status = array();
	
	function __construct()
	{

		add_action( 'add_meta_boxes', array( &$this, 'add_custom_order_status_messengerbot_metabox' ) );
		add_action('save_post', array( &$this, 'save_custom_order_status_messengerbot_metabox' ), 1, 2); // save the custom fields

		$this->get_custom_order_status();
		$this->register_custom_order_status_messages();

			
	}


	function get_custom_order_status(){
		$args = array(
			'posts_per_page'   => -1,
			'post_type'        => 'wc_custom_statuses',
			'post_status'      => 'publish',
		);
		$custom_order_statuses_objects = get_posts( $args );

		foreach ($custom_order_statuses_objects as $status) {

			$label = get_post_meta( $status->ID, '__label', true );

			$this->custom_order_status[$label] = array(
				'label' => $label,
				'title' => $status->post_title,
				'message' => get_post_meta( $status->ID, '_derweili_mbot_custom_status_message', true ),
				'ID' => $status->ID,

			);
		}
		derweili_mbot_log($this->custom_order_status);

	}

	// Add Metabox for Custom Order Status Post type
	public function add_custom_order_status_messengerbot_metabox(){
		
		add_meta_box('custom_order_status_messengerbot_message', __('Messenger Bot', 'mbot-woocommerce'), array( &$this, 'custom_order_status_messengerbot_metabox_content'), 'wc_custom_statuses', 'normal', 'default');
	}

	public function custom_order_status_messengerbot_metabox_content(){
		global $post;
		
		// Noncename needed to verify where the data originated
		echo '<input type="hidden" name="derweili_mbot_custom_status_noncename" id="derweili_mbot_custom_status_noncename" value="' . 
		wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
		
		// Get the location data if its already been entered
		$location = get_post_meta($post->ID, '_derweili_mbot_custom_status_message', true);
		
		// Echo out the field
		echo '<textarea name="_derweili_mbot_custom_status_message" value="' . $location  . '" class="widefat" >' . $location  . '</textarea>';

	}



	// Save the Metabox Data

	public function save_custom_order_status_messengerbot_metabox($post_id, $post) {
		
		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		/*if ( !wp_verify_nonce( $_POST['derweili_mbot_custom_status_noncename'], plugin_basename(__FILE__) )) {
		return $post->ID;
		}*/

		// Is the user allowed to edit the post or page?
		if ( !current_user_can( 'edit_post', $post->ID ))
			return $post->ID;

		// OK, we're authenticated: we need to find and save the data
		// We'll put it into an array to make it easier to loop though.
		
		$events_meta['_derweili_mbot_custom_status_message'] = $_POST['_derweili_mbot_custom_status_message'];
		
		// Add values of $events_meta as custom fields
		
		foreach ($events_meta as $key => $value) { // Cycle through the $events_meta array!
			
			if( $post->post_type == 'revision' ) return; // Don't store custom data twice
						
			if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
				update_post_meta($post->ID, $key, $value);
			} else { // If the custom field doesn't have a value
				add_post_meta($post->ID, $key, $value);
			}
			if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
		}

	}


	public function register_custom_order_status_messages() {
		foreach ($this->custom_order_status as $key => $value) {
			add_action( 'woocommerce_order_status_' . $key, array( &$this, 'derweili_mbot_woocommerce_orderstatus_custom' ) );
		}
	}

	public function derweili_mbot_woocommerce_orderstatus_custom( $order_id ) {


		$order = new Derweili_Mbot_Order( $order_id );

		$order_status = $order->order->get_status();

		if ( array_key_exists( $order_status, $this->custom_order_status)) {
			
			if ( ! empty( $this->custom_order_status[$order_status]['message'] )) {
				$order->send_text_message( $this->custom_order_status[$order_status]['message'] );
			}

		}





	}



}

new Derweili_Custom_Order_Status_Handler();