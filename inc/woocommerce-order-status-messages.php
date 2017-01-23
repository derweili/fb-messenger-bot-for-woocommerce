<?php
if (!defined('ABSPATH'))
{
   exit();
}


/**
* handle order status updates and customer note
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
		$order->send_text_message( get_site_option( 'derweili_mbot_pending_order_message' ) );

	}

	public function derweili_mbot_woocommerce_orderstatus_message_failed( $order_id ) {

		derweili_mbot_log( 'Send order status notification for failed order.' );

		$order = new Derweili_Mbot_Order( $order_id );
		$order->send_text_message( get_site_option( 'derweili_mbot_failed_order_message' ) );

	}


	public function derweili_mbot_woocommerce_orderstatus_message_hold( $order_id ) {

		derweili_mbot_log( 'Send order status notification for status "on hold".' );

		$order = new Derweili_Mbot_Order( $order_id );
		$order->send_text_message( get_site_option( 'derweili_mbot_on_hold_order_message' ) );

	}


	public function derweili_mbot_woocommerce_orderstatus_message_processing( $order_id ) {

		derweili_mbot_log( 'Send order status notification for status "processing".' );

		$order = new Derweili_Mbot_Order( $order_id );
		$order->send_text_message( get_site_option( 'derweili_mbot_new_order_message' ) );

	}	


	public function derweili_mbot_woocommerce_orderstatus_message_completed( $order_id ) {

		derweili_mbot_log( 'Send order status notification for completed order.' );

		$order = new Derweili_Mbot_Order( $order_id );
		$order->send_text_message( get_site_option( 'derweili_mbot_completed_order_message' ) );

	}


	public function derweili_mbot_woocommerce_orderstatus_message_refunded($order_id) {

		derweili_mbot_log( 'Send order status notification for refunded order.' );

		$order = new Derweili_Mbot_Order( $order_id );
		$order->send_text_message( get_site_option( 'derweili_mbot_refunded_order_message' ) );
		
	}


	public function derweili_mbot_woocommerce_orderstatus_message_cancelled( $order_id ) {

		derweili_mbot_log( 'Send order status notification for cancelled order.' );

		$order = new Derweili_Mbot_Order( $order_id );
		$order->send_text_message( get_site_option( 'derweili_mbot_cancelled_order_message' ) );
		
	}


	public function derweili_mbot_woocommerce_new_order_note() {

		if ( isset( $_POST['post_id'] ) && isset( $_POST['note'] ) && isset( $_POST['note_type'] ) && 'customer' == $_POST['note_type'] ) {

			if ( current_user_can( 'manage_woocommerce' ) ) { // check if user can manage orders

				derweili_mbot_log( 'Send order note to customer.' );

				$order = new Derweili_Mbot_Order( intval( $_POST['post_id'] ) );
				$order->send_text_message( $_POST['note'] );

			}

		}
	}

}

new DERWEILI_STATUS_UPDATE_MESSAGES;