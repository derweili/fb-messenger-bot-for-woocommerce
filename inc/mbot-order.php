<?php
if (!defined('ABSPATH'))
{
   exit();
}



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

			derweili_mbot_log( "New User ID " . $new_user_id . " added for Order " . $this->order_id );

		//file_put_contents("log2.html", 'After add user id – user id = : ' . $this->user_id, FILE_APPEND);
        //file_put_contents("log2.html", print_r( '<hr />', true ), FILE_APPEND);

	
		}else{

			derweili_mbot_log( "Tried to add user id " . $new_user_id . " but a user ID " . $this->user_id .  " already exists for order " . $this->order_id );

			return false;

		}


	}

	public function add_user_reference( $new_user_reference ) {

		if ( empty( $this->user_id ) ) {

			$this->add_user_id( $new_user_reference );
			
			add_post_meta( $this->order_id, 'derweili_mbot_woocommerce_customer_ref', true, true);
			
			$this->is_reference = true;

			derweili_mbot_log( "New User Reference " . $new_user_reference . " added for Order " . $this->order_id );



		}else{

			derweili_mbot_log( "Tried to add user reference " . $new_user_reference . " but a user ID " . $this->user_id .  " already exists for order " . $this->order_id );

			return false;

		}

	}

	public function send_text_message( $message ) {

		derweili_mbot_log( 'send text message' );
		derweili_mbot_log( new Der_Weili_Message( $this->user_id, $message, $this->is_reference ) );
		return $this->bot->send( new Der_Weili_Message( $this->user_id, $message, $this->is_reference ) );


	}

	public function send_order() {
		derweili_mbot_log( 'send receipt' );
		derweili_mbot_log( new WooOrderMessage( $this->user_id, $this->order, $this->is_reference ) );
		return $this->bot->send(new WooOrderMessage( $this->user_id, $this->order, $this->is_reference ) );
	}

}