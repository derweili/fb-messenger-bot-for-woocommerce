<?php
if (!defined('ABSPATH'))
{
   exit();
}

if ( 1 == 2 ){

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
            add_action( 'woocommerce_settings_tabs_mbot_settings', __CLASS__ . '::settings_tab' );
            add_action( 'woocommerce_update_options_mbot_settings', __CLASS__ . '::update_settings' );


        }
        
        
        /**
         * Add a new settings tab to the WooCommerce settings tabs array.
         *
         * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
         * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
         */
        public static function add_settings_tab( $settings_tabs ) {
            $settings_tabs['mbot_settings'] = __( 'Messenger Bot', 'mbot-woocommmerce' );
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
                    'desc'     => __( 'Your Callback URL is:', 'mbot-woocommmerce' ) . ' <u>' . get_home_url() . '/mbot-callback-webhook/</u>' ,
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
               /* 'checkbox-prechecked' => array(
                    'name'     => __( 'Precheck checkbox?', 'mbot-woocommmerce' ),
                    'type'     => 'checkbox',
                    //'desc'     => __( 'Your Callback URL is:', 'mbot-woocommmerce' ) . ' <u>' . plugin_dir_url( __FILE__ ) . 'webhook.php</u>' ,
                    'id'       => 'derweili_mbot_fb_checkbox_prechecked'
                ),
                'checkbox-allow-login' => array(
                    'name'     => __( 'Allow Login', 'mbot-woocommmerce' ),
                    'type'     => 'checkbox',
                    //'desc'     => __( 'Your Callback URL is:', 'mbot-woocommmerce' ) . ' <u>' . plugin_dir_url( __FILE__ ) . 'webhook.php</u>' ,
                    'id'       => 'derweili_mbot_fb_checkbox_allow_login'
                ),*/
                'checkbox-size' => array(
                    'name' => __( 'Checkbox size', 'mbot-woocommmerce' ),
                     'type' => 'select',
                     'id' => 'derweili_mbot_checkbox_size',
                     'options' => array(
                        'standard' => 'Standard',
                        'small' => 'Small',
                        'medium' => 'Medium',
                        'large' => 'Large',
                        'xlarge' => 'xLarge',
                      )
                ),
                'send-to-messenger-color' => array(
                    'name' => __( 'Send to Messenger Button color', 'mbot-woocommmerce' ),
                     'type' => 'select',
                     'id' => 'derweili_mbot_button_color',
                     'options' => array(
                        'blue' => 'Blau',
                        'white' => 'Weiß',
                      )
                ),
                'section_end' => array(
                     'type' => 'sectionend',
                     'id' => 'wc_mbot_settings_section_end'
                )
            );
            return apply_filters( 'wc_mbot_settings_settings', $settings );
        }



    }

    $derweili_mbot_settings_page = new DERWEEILI_MBOT_WOOCOMMERCE_SETTINGS_PAGE();




    add_filter( 'woocommerce_get_sections_mbot_settings', 'derweili_add_messages_settings_section' );
    function derweili_add_messages_settings_section( $sections ) {
        
        $sections['mbot_messages'] = __( 'Nachrichten', 'text-domain' );
        $sections['testsection'] = __( 'testsection', 'text-domain' );
        return $sections;
        
    }

}
/*
add_filter( 'woocommerce_get_settings_pages', 'so_26355697_add_settings_page' );
function so_26355697_add_settings_page( $settings ) {
    $settings[] = include( 'wc-plugin-settings.php' );  
    return $settings;
}*/