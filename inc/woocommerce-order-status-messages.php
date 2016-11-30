<?php
if (!defined('ABSPATH'))
{
   exit();
}


/**
* handle order status updates
*/
class DERWEILI_STATUS_UPDATE_MESSAGES
{

	private $bot;
	private $receiver_id;
	private $order_id;
	private $message;

	/**
	* Hook into order status updates and send fb message to user
	*/
	public function __construct()
	{
		add_action( 'woocommerce_order_status_pending', array( &$this, 'derweili_mbot_woocommerce_orderstatus_message_pending') );
		add_action( 'woocommerce_order_status_failed', array( &$this, 'derweili_mbot_woocommerce_orderstatus_message_failed' ) );
		add_action( 'woocommerce_order_status_on-hold', array( &$this, 'derweili_mbot_woocommerce_orderstatus_message_hold' ) );
		add_action( 'woocommerce_order_status_processing', array( &$this, 'derweili_mbot_woocommerce_orderstatus_message_processing' ) );
		add_action( 'woocommerce_order_status_completed', array( &$this, 'derweili_mbot_woocommerce_orderstatus_message_completed' ) );
		add_action( 'woocommerce_order_status_refunded', array( &$this, 'derweili_mbot_woocommerce_orderstatus_message_refunded' ) );
		add_action( 'woocommerce_order_status_cancelled', array( &$this, 'derweili_mbot_woocommerce_orderstatus_message_cancelled' ) );
		
		add_action( 'wp_ajax_woocommerce_add_order_note', array( &$this, 'derweili_mbot_woocommerce_new_order_note' ), 1 );

	}

	public function derweili_mbot_woocommerce_orderstatus_message_pending( $order_id ) {

		$order = new Derweili_Mbot_Order( $order_id );
		$order->send_text_message( __( 'Your order is now pendig.', 'mbot-woocommerce' ) );

	}

	public function derweili_mbot_woocommerce_orderstatus_message_failed( $order_id ) {

		$order = new Derweili_Mbot_Order( $order_id );
		$order->send_text_message( __( 'Your order unfortunately failed.', 'mbot-woocommerce' ) );

	}


	public function derweili_mbot_woocommerce_orderstatus_message_hold( $order_id ) {

		$order = new Derweili_Mbot_Order( $order_id );
		$order->send_text_message( __( 'Your order is now on hold.', 'mbot-woocommerce' ) );

	}


	public function derweili_mbot_woocommerce_orderstatus_message_processing( $order_id ) {

		$order = new Derweili_Mbot_Order( $order_id );
		$order->send_text_message( __( 'Your order is now processing', 'mbot-woocommerce' ) );

	}	


	public function derweili_mbot_woocommerce_orderstatus_message_completed( $order_id ) {

		$order = new Derweili_Mbot_Order( $order_id );
		$order->send_text_message( __( 'Your order has been completed', 'mbot-woocommerce' ) );

	}


	public function derweili_mbot_woocommerce_orderstatus_message_refunded($order_id) {

		$order = new Derweili_Mbot_Order( $order_id );
		$order->send_text_message( __( 'Your order has been refunded', 'mbot-woocommerce' ) );
		
	}


	public function derweili_mbot_woocommerce_orderstatus_message_cancelled( $order_id ) {

		//echo "<h1>test</h1>";

		$order = new Derweili_Mbot_Order( $order_id );
		$order->send_text_message( __( 'Your order has been cancelled', 'mbot-woocommerce' ) );
		

	}


	public function derweili_mbot_woocommerce_new_order_note() {

		if ( isset( $_POST['post_id'] ) && isset( $_POST['note'] ) && isset( $_POST['note_type'] ) && 'customer' == $_POST['note_type'] ) {

			if ( current_user_can( 'manage_woocommerce' ) ) { // check if user can manage orders

				$order = new Derweili_Mbot_Order( intval( $_POST['post_id'] ) );
				$order->send_text_message( $_POST['note'] );

			}

		}
	}

}

new DERWEILI_STATUS_UPDATE_MESSAGES;