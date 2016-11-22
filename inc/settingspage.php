<?php


class DERWEEILI_MBOT_WOOCOMMERCE_SETTINGS_PAGE {


    /**
     * Bootstraps the class and hooks required actions & filters.
     *
     */
    function __construct()
    {
        $this->domain_whitelisting_button();

        $this->init();

    }

    public static function init() {
        add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
        add_action( 'woocommerce_settings_tabs_settings_tab_demo', __CLASS__ . '::settings_tab' );
        add_action( 'woocommerce_update_options_settings_tab_demo', __CLASS__ . '::update_settings' );
    }
    
    
    /**
     * Add a new settings tab to the WooCommerce settings tabs array.
     *
     * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
     * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
     */
    public static function add_settings_tab( $settings_tabs ) {
        $settings_tabs['settings_tab_demo'] = __( 'Messenger Bot', 'mbot-woocommmerce' );
        return $settings_tabs;
    }
    /**
     * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
     *
     * @uses woocommerce_admin_fields()
     * @uses self::get_settings()
     */
    public static function settings_tab() {
        woocommerce_admin_fields( self::get_settings() );
    }
    /**
     * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
     *
     * @uses woocommerce_update_options()
     * @uses self::get_settings()
     */
    public static function update_settings() {
        woocommerce_update_options( self::get_settings() );


    }
    /**
     * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
     *
     * @return array Array of settings for @see woocommerce_admin_fields() function.
     */
    public static function get_settings() {
        $settings = array(
            'facebook_api_credentials_title' => array(
                'name'     => __( 'Facebook API Credentials', 'mbot-woocommmerce' ),
                'type'     => 'title',
                'desc'     => __( 'Your Callback URL is:', 'mbot-woocommmerce' ) . ' <u>' . plugin_dir_url( __FILE__ ) . 'webhook.php</u>' ,
                'id'       => 'derweili_mbot_fb_credentials_title'
            ),
            'page_token' => array(
                'name' => __( 'Page Tooken', 'mbot-woocommmerce' ),
                'type' => 'text',
                'desc' => __( '', 'mbot-woocommmerce' ),
                'id'   => 'derweili_mbot_page_token'
            ),
            'verify_tooken' => array(
                'name' => __( 'Verify Token', 'mbot-woocommmerce' ),
                'type' => 'text',
                'desc' => __( '', 'mbot-woocommmerce' ),
                'id'   => 'derweili_mbot_verify_token'
            ),
            'Page_ID' => array(
                'name' => __( 'Page ID', 'mbot-woocommmerce' ),
                'type' => 'text',
                'desc' => __( '', 'mbot-woocommmerce' ),
                'id'   => 'derweili_mbot_page_id'
            ),
            'Messenger_APP_ID' => array(
                'name' => __( 'Messenger App ID', 'mbot-woocommmerce' ),
                'type' => 'text',
                'desc' => __( '', 'mbot-woocommmerce' ),
                'id'   => 'derweili_mbot_messenger_app_id'
            ),
            'section_end' => array(
                 'type' => 'sectionend',
                 'id' => 'wc_settings_tab_demo_section_end'
            )
        );
        return apply_filters( 'wc_settings_tab_demo_settings', $settings );
    }


    private function domain_whitelisting( $action_type = 'add' ) {
        $ch = curl_init();

        $post_params = array(
            'setting_type' => 'domain_whitelisting', 
            'whitelisted_domains' => array( get_home_url() ), 
            'domain_action_type' => $action_type, 
        );

        $post_params = http_build_query( $post_params );

        curl_setopt($ch, CURLOPT_URL,"https://graph.facebook.com/v2.6/me/thread_settings?access_token=" . mbot_woocommerce_token);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_params );


        // in real life you should use something like:
        // curl_setopt($ch, CURLOPT_POSTFIELDS, 
        //          http_build_query(array('postvar1' => 'value1')));

        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);

        curl_close ($ch);

        // further processing ....

        //echo "whitelistfunction";
        //var_dump( $server_output );

        //if ($server_output == "OK") {  } else { }

    }

    
    public function domain_whitelisting_button() {


            if ( isset( $_GET["tab"]) && $_GET["tab"] == "settings_tab_demo" ) {


                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL,"https://graph.facebook.com/v2.6/me/thread_settings?fields=whitelisted_domains&access_token=" . mbot_woocommerce_token );
                curl_setopt($ch, CURLOPT_POST, 0);
                //curl_setopt($ch, CURLOPT_POSTFIELDS,
                //            "setting_type=domain_whitelisting&whitelisted_domains=" . get_home_url() . "&domain_action_type=" . $action_type );

                // in real life you should use something like:
                // curl_setopt($ch, CURLOPT_POSTFIELDS, 
                //          http_build_query(array('postvar1' => 'value1')));

                // receive server response ...
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $server_output = curl_exec ($ch);

                curl_close ($ch);

                // further processing ....
              //var_dump( $server_output );
              //var_dump( json_decode( $server_output ) );
              $server_output_json = json_decode( $server_output );
              //echo "<br />";
              //echo $server_output;
              //echo count( $server_output_json->data );

              //echo $whitelisted_urls = $server_output_json->data[0]->whitelisted_domains;

              if ( in_array( get_home_url(), $whitelisted_urls)) {
                  // everythin is ok
              }else{

                $this->domain_whitelisting();

              }

           
        }

    }


}

$derweili_mbot_settings_page = new DERWEEILI_MBOT_WOOCOMMERCE_SETTINGS_PAGE();


