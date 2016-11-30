<?php
if (!defined('ABSPATH'))
{
   exit();
}


/**
* Override values with "#" when empty to prevent API error
*/

add_filter( 'derweili_mbot_wooorder_address_country', 'derweili_mbot_prevent_empty_value', 100 );
add_filter( 'derweili_mbot_wooorder_address_state', 'derweili_mbot_prevent_empty_value', 100 );
add_filter( 'derweili_mbot_wooorder_address_postcode', 'derweili_mbot_prevent_empty_value', 100 );
add_filter( 'derweili_mbot_wooorder_address_city', 'derweili_mbot_prevent_empty_value', 100 );
add_filter( 'derweili_mbot_wooorder_address_street_1', 'derweili_mbot_prevent_empty_value', 100 );

function derweili_mbot_prevent_empty_value( $shipping_state ) {
	if ( empty( $shipping_state ) ) {
		return '#';
	}else{
		return $shipping_state;
	}
}


function derweili_mbot_woocommerce_startswith($haystack, $needle){ 
    return strpos($haystack, $needle) === 0;
}