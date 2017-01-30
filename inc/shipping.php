<?php

if (!defined('ABSPATH'))
{
   exit();
}


/**
* NOTE: Shipping Handler
* @since 1.15
*/
class Derweili_Order_Shipping_Handler
{

	private $order_id = null;
	private $tracking_plugin = null;

	// General Shipping Info
	private $tracking_code = null;
	private $tracking_provider_name = null;
	private $tracking_url = null;


	// Aftership details
	private $tracking_provider = null;
	
	function __construct( $order_id )
	{
		
		$this->order_id = $order_id;

		$this->get_shipping_type();

	}


	private function get_shipping_type() {

		if ( ! empty( get_post_meta( $this->order_id, '_aftership_tracking_number', true ) ) ) {
			
			$this->tracking_plugin = "aftership";

		}elseif ( ! empty( get_post_meta( $this->order_id, '_tracking_number', true ) ) ) {
			
			$this->tracking_plugin = "WooCommerceShipmentTracking";

		}elseif ( ! empty( get_post_meta( $this->order_id, '_wcst_order_trackno', true ) ) ) {
			
			$this->tracking_plugin = "wcst";

		}

	}

	public function has_shipping() {
		if ( null != $this->tracking_plugin ) return true;
	}

	private function get_shipping_details() {

		switch ( $this->tracking_plugin ) {
			case 'aftership':
				
				$this->get_aftership_details();

				break;
			case 'WooCommerceShipmentTracking':
				
				$this->get_woocommerce_shipment_tracking();

				break;
			case 'wcst':
				
				$this->get_wcst_tracking();

				break;

			default:
				# code...
				break;
		}

	}

	private function get_aftership_details() {

		$this->tracking_code = get_post_meta( $this->order_id, '_aftership_tracking_number', true );
		$this->tracking_provider_name = get_post_meta( $this->order_id, '_aftership_tracking_provider_name', true );
		$this->tracking_provider = get_post_meta( $this->order_id, '_aftership_tracking_provider', true );
		
		$this->tracking_url = "https://track.aftership.com/" . $this->tracking_provider . "/" . $this->tracking_code;

	}

	private function get_woocommerce_shipment_tracking() {

		$this->tracking_code = get_post_meta( $this->order_id, '_tracking_number', true );
		$this->tracking_provider_name = get_post_meta( $this->order_id, '_tracking_provider', true );
		
		$this->tracking_url = get_post_meta( $this->order_id, '_custom_tracking_link', true );

	}

	private function get_wcst_tracking() {

		$this->tracking_code = get_post_meta( $this->order_id, '_wcst_order_trackno', true );
		$this->tracking_provider_name = get_post_meta( $this->order_id, '_wcst_order_trackname', true );
		
		$this->tracking_url = get_post_meta( $this->order_id, '_wcst_order_track_http_url', true );

	}

	public function get_tracking_url() {

		$this->get_shipping_details();

		return $this->tracking_url;

	}

}