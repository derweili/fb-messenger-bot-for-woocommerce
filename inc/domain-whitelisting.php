<?php

/**
* Whitelisting
* @since 1.7
*/
class Derweili_Mbot_Domain_Whitelisting
{
	
	function __construct()
	{
		$this->whitelising_handler();
	}

	public function whitelising_handler() {


            if ( isset( $_GET["tab"]) && $_GET["tab"] == "mbot_settings" ) {


                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL,"https://graph.facebook.com/v2.6/me/thread_settings?fields=whitelisted_domains&access_token=" . mbot_woocommerce_token );
                curl_setopt($ch, CURLOPT_POST, 0);

                // receive server response ...
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $server_output = curl_exec ($ch);

                curl_close ($ch);

                $server_output_json = json_decode( $server_output );


                $whitelisted_urls = $server_output_json->data[0]->whitelisted_domains;

                if ( is_array( $whitelisted_urls ) ) {
                
                  if ( in_array( get_home_url(), $whitelisted_urls) || in_array( 'https://' . $_SERVER['HTTP_HOST'] , $whitelisted_urls) ) {
                      // everythin is ok
                  }else{

                    $this->whitelist_domain();

                  }

                } // is_array
           
        }

    }


    /*
    * Send the Site URL to facebook as Whitelisted URL
    */
    public function whitelist_domain( $action_type = 'add' ) {
        $ch = curl_init();

        $post_params = array(
            'setting_type' => 'domain_whitelisting', 
            'whitelisted_domains' => array( get_home_url(), 'https://' . $_SERVER['HTTP_HOST'] ), 
            'domain_action_type' => $action_type, 
        );

        $post_params = http_build_query( $post_params );

        curl_setopt($ch, CURLOPT_URL,"https://graph.facebook.com/v2.6/me/thread_settings?access_token=" . mbot_woocommerce_token );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_params );



        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);

        curl_close ($ch);


    }


}

function derweili_mbot_standard_domain_whitelisting() {

    new Derweili_Mbot_Domain_Whitelisting();

}

add_action ( "admin_head", "derweili_mbot_standard_domain_whitelisting" );