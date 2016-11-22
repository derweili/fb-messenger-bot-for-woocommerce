<?php
/**
* handle order status updates
*/
class DERWEILI_STATUS_UPDATE_MESSAGES
{

	private $bot;
	private $receiver_id;
	private $order_id;
	private $message;

	
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

	private function prepare_message_update( $order_id ) {

		$this->order_id = $order_id;

		$this->bot = new pimax\FbBotApp( mbot_woocommerce_token );

		$this->receiver_id = get_post_meta( $order_id, 'derweili_mbot_woocommerce_customer_messenger_id', true );
	}

	private function exec_message_update(){
		$this->bot->send(new pimax\Messages\Message( $this->receiver_id, $this->message ));
	}

	public function derweili_mbot_woocommerce_orderstatus_message_pending( $order_id ) {
	
		$order = new Derweili_Mbot_Order( $order_id );	

		$order->send_text_message( __( 'Your order is no pendig.', 'mbot-woocommerce' ) );		

	}

	public function derweili_mbot_woocommerce_orderstatus_message_failed( $order_id ) {
		
		$this->prepare_message_update( $order_id );

		$this->message = apply_filters( 'derweili_mbot_woocommerce_message_failed', __( 'Your order failed.', 'mbot-woocommerce' ), $order_id, $this->receiver_id );
		
		$bot->send(new pimax\Messages\Message($receiver_id, $message ));
		
		$this->exec_message_update();

		error_log("$order_id set to PENDING", 0);
	}


	public function derweili_mbot_woocommerce_orderstatus_message_hold( $order_id ) {
		
		$this->prepare_message_update( $order_id );

		$this->message = apply_filters( 'derweili_mbot_woocommerce_message_hold', __( 'Your order is now on hold.', 'mbot-woocommerce' ), $order_id, $this->receiver_id );

		$this->exec_message_update();

		error_log("$order_id set to ON HOLD", 0);
	}


	public function derweili_mbot_woocommerce_orderstatus_message_processing( $order_id ) {
		
		$this->prepare_message_update( $order_id );

		$this->message = apply_filters( 'derweili_mbot_woocommerce_message_processing', __( 'Your order is now processing', 'mbot-woocommerce' ), $order_id, $this->receiver_id );

		$this->exec_message_update();

		error_log("$order_id set to PROCESSING", 0);

	}	


	public function derweili_mbot_woocommerce_orderstatus_message_completed( $order_id ) {
		
		$this->prepare_message_update( $order_id );

		$this->message = apply_filters( 'derweili_mbot_woocommerce_message_completed', __( 'Your order has been completed', 'mbot-woocommerce' ), $order_id, $this->receiver_id );

		$this->exec_message_update();

		error_log("$order_id set to COMPLETED", 0);

	}


	public function derweili_mbot_woocommerce_orderstatus_message_refunded($order_id) {
		
		$this->prepare_message_update( $order_id );

		$this->message = apply_filters( 'derweili_mbot_woocommerce_message_refunded', __( 'Your order has been refunded', 'mbot-woocommerce' ), $order_id, $this->receiver_id );

		$this->exec_message_update();

		error_log("$order_id set to REFUNDED", 0);

	}


	public function derweili_mbot_woocommerce_orderstatus_message_cancelled($order_id) {

		echo "<h1>test</h1>";

		$order = new Derweili_Mbot_Order( intval( $order_id ) );
		$order->send_text_message( __( 'Your order has been cancelled', 'mbot-woocommerce' ) );
		
		/*$this->prepare_message_update( $order_id );

		$this->message = apply_filters( 'derweili_mbot_woocommerce_message_cancelled', __( 'Your order has been cancelled', 'mbot-woocommerce' ), $order_id, $this->receiver_id );

		$this->exec_message_update();

		error_log("$order_id set to CANCELLED", 0);*/
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