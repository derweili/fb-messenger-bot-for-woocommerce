<?php


class DERWEEILI_MBOT_WOOCOMMERCE_SETTINGS_PAGE {
    /**
     * Bootstraps the class and hooks required actions & filters.
     *
     */
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
                'desc'     => __( 'Your Callback URL is:', 'mbot-woocommmerce' ) . ' <input type="text" disabled>' . plugin_dir_url( __FILE__ ) . 'webhook.php</input>' ,
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
}

DERWEEILI_MBOT_WOOCOMMERCE_SETTINGS_PAGE::init();

