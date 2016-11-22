<?php

/**
* 
*/
class Derweili_Mbot_Order
{	
	private $order_id;

	public $order;

	public $bot;

	public $is_reference;

	public $user_id;

	
	function __construct( $order_id )
	{
	
		$this->order_id = $order_id;

		var_dump($this->order_id);

		$this->get_order();
		$this->get_user_id();
		$this->is_reference();
		$this->init_bot();

	}

	private function get_order() {
		
		$this->order = new WC_Order( $this->order_id );

	}

	public function  get_user_id() {
		$this->user_id = get_post_meta( $this->order_id, 'derweili_mbot_woocommerce_customer_messenger_id', true );
	}

	private function is_reference() {
		
		$this->is_reference = get_post_meta( $this->order_id, 'derweili_mbot_woocommerce_customer_ref', true );

	}

	private function init_bot() {
		
		$this->bot = new pimax\FbBotApp( mbot_woocommerce_token );

	}

	public function add_user_id( $new_user_id ) {
		
		if ( empty( $this->user_id ) ) {
		
			add_post_meta($this->order_id, 'derweili_mbot_woocommerce_customer_messenger_id', $new_user_id, true);

			$this->is_reference = false;

			$this->get_user_id();
		
		}else{

			return false;

		}


	}

	public function add_user_reference( $new_user_reference ) {

		if ( $this->add_user_id( $new_user_reference ) ) {
			
			add_post_meta( $this->order_id, 'derweili_mbot_woocommerce_customer_ref', true, true);
			
			$this->is_reference();
			
			return true;

		}else{
			return false;
		}

	}

	public function send_text_message( $message ) {
		//var_dump($this->user_id);
		//$this->bot->send(new pimax\Messages\Message( $this->user_id, $this->order ) );
		return $this->bot->send( new Der_Weili_Message( $this->user_id, $message, $this->is_reference ) );


	}

	public function send_order() {
		return $this->bot->send(new WooOrderMessage( $this->user_id, $this->order, $this->is_reference ) );
	}

}