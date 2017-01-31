<?php

class WC_Settings_My_Plugin extends WC_Settings_Page {

    /**
     * Constructor
     */
    public function __construct() {

        $this->id    = 'mbot_settings';

        add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_tab' ), 50 );
        add_action( 'woocommerce_sections_' . $this->id, array( $this, 'output_sections' ) );
        add_action( 'woocommerce_settings_' . $this->id, array( $this, 'output' ) );
        add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );

    }

    /**
     * Add plugin options tab
     *
     * @return array
     */
    public function add_settings_tab( $settings_tabs ) {
        $settings_tabs[$this->id] = __( 'Messenger Bot', 'woocommerce-settings-tab-demo' );
        return $settings_tabs;
    }

    /**
     * Get sections
     *
     * @return array
     */
    public function get_sections() {

        $sections = array(
            ''         => __( 'API Credentials', 'mbot-woocommmerce' ),
            'screen-settings'         => __( 'Appearance', 'mbot-woocommmerce' ),
            'messages'         => __( 'Messages', 'mbot-woocommmerce' ),
            //'section 2'         => __( 'Section 2', 'mbot-woocommmerce' ),

        );

        return apply_filters( 'woocommerce_get_sections_' . $this->id, $sections );
    }


    /**
     * Get sections
     *
     * @return array
     */
    public function get_settings( $section = null ) {

        switch( $section ){

            case 'messages':
                $settings = array(
                    'section_title' => array(
                        'name'     => __( 'Messages', 'mbot-woocommmerce' ),
                        'type'     => 'title',
                        'desc'     => '',
                        'id'       => 'derweili_mbot_messages_title'
                    ),
                    'new_order_message' => array(
                        'name' => __( 'New Order', 'mbot-woocommmerce' ),
                        'type' => 'text',
                        'desc' => __( 'This is the message the user will recieve when they placed the order.', 'mbot-woocommmerce' ),
                        'id'   => 'derweili_mbot_new_order_message'
                    ),
                    'pending_order_message' => array(
                        'name' => __( 'Pending Order', 'mbot-woocommmerce' ),
                        'type' => 'text',
                        'desc' => __( 'This is the message the user will recieve when the order status changed to "pending".', 'mbot-woocommmerce' ),
                        'id'   => 'derweili_mbot_pending_order_message'
                    ),
                    'failed_order_message' => array(
                        'name' => __( 'Failed Order', 'mbot-woocommmerce' ),
                        'type' => 'text',
                        'desc' => __( 'This is the message the user will recieve when the order failed.', 'mbot-woocommmerce' ),
                        'id'   => 'derweili_mbot_failed_order_message'
                    ),
                    'on_hold_message' => array(
                        'name' => __( 'On Hold', 'mbot-woocommmerce' ),
                        'type' => 'text',
                        'desc' => __( 'This is the message the user will recieve when the order gets the status "on hold".', 'mbot-woocommmerce' ),
                        'id'   => 'derweili_mbot_on_hold_order_message'
                    ),
                    'processing_message' => array(
                        'name' => __( 'Processing', 'mbot-woocommmerce' ),
                        'type' => 'text',
                        'desc' => __( 'This is the message the user will recieve when the order gets the status "processing".', 'mbot-woocommmerce' ),
                        'id'   => 'derweili_mbot_processing_order_message'
                    ),
                    'completed_message' => array(
                        'name' => __( 'Completed Order', 'mbot-woocommmerce' ),
                        'type' => 'text',
                        'desc' => __( 'This is the message the user will recieve when the order gets the status "completed".', 'mbot-woocommmerce' ),
                        'id'   => 'derweili_mbot_completed_order_message'
                    ),
                    'refunded_message' => array(
                        'name' => __( 'Refunded Order', 'mbot-woocommmerce' ),
                        'type' => 'text',
                        'desc' => __( 'This is the message the user will recieve when the order gets the status "refunded".', 'mbot-woocommmerce' ),
                        'id'   => 'derweili_mbot_refunded_order_message'
                    ),
                    'cancelled_message' => array(
                        'name' => __( 'Cancelled Order', 'mbot-woocommmerce' ),
                        'type' => 'text',
                        'desc' => __( 'This is the message the user will recieve when the order gets the status "cancelled".', 'mbot-woocommmerce' ),
                        'id'   => 'derweili_mbot_cancelled_order_message'
                    ),
                    'section_end' => array(
                         'type' => 'sectionend',
                         'id' => 'wc_settings_tab_demo_section_end_section-2'
                    )
                );
            break;

            case 'screen-settings':


                 $settings = array(
                            'facebook_api_credentials_title' => array(
                            'name'     => __( 'Appearance of the Facebook Messenger Plugins', 'mbot-woocommmerce' ),
                            'type'     => 'title',
                            //'desc'     => __( 'Your Callback URL is:', 'mbot-woocommmerce' ) . ' <u>' . get_home_url() . '/mbot-callback-webhook/</u>' . '<br />' .  __( 'Following URLs are currently whitelisted for the use of the messenger checkbox plugin: <br />', 'mbot-woocommmerce' ) . derweili_get_whitelisted_domains() ,
                            'id'       => 'derweili_mbot_fb_screen_settings_title'
                        ),
                        'checkbox-size' => array(
                            'name' => __( 'Checkbox size', 'mbot-woocommmerce' ),
                             'type' => 'select',
                             'id' => 'derweili_mbot_checkbox_size',
                             'options' => array(
                                'small' => __('Small', 'mbot-woocommmerce' ) ,
                                'medium' => __('Medium', 'mbot-woocommerce' ),
                                'large' => __('Large', 'mbot-woocommere' ),
                                'standard' => __( 'Standard', 'mbot-wooocommerce' ),
                                'xlarge' => __('xLarge', 'mbot-woocommere' )
                              )
                        ),

                       /*'checkbox-prechecked' => array(
                            'name'     => __( 'precheck the checkbox', 'mbot-woocommmerce' ),
                            'type'     => 'checkbox',
                            //'desc'     => __( 'Your Callback URL is:', 'mbot-woocommmerce' ) . ' <u>' . plugin_dir_url( __FILE__ ) . 'webhook.php</u>' ,
                            'id'       => 'derweili_mbot_fb_checkbox_prechecked'
                        ),*/
                        'checkbox-prechecked' => array(
                            'name' => __( 'Initial checkbox status', 'mbot-woocommmerce' ),
                            'type' => 'select',
                            'id'       => 'derweili_mbot_fb_checkbox_prechecked',
                             'options' => array(
                                'true' => __('Checked', 'mbot-woocommmerce' ) ,
                                'false' => __('Unchecked', 'mbot-woocommerce' ),
                            )
                        ),
                        'checkbox-login' => array(
                            'name' => __( 'Allow / disallow login', 'mbot-woocommmerce' ),
                            'type' => 'select',
                            'id'       => 'derweili_mbot_fb_checkbox_allow_login',
                            'options' => array(
                                'true' => __( 'Allow Login', 'mbot-woocommmerce' ) ,
                                'false' => __( 'Disallow Login', 'mbot-woocommerce' ),
                            )
                        ),
                        'button-size' => array(
                            'name' => __( 'Send-to-Messenger Button size', 'mbot-woocommmerce' ),
                             'type' => 'select',
                             'id' => 'derweili_mbot_button_size',
                             'options' => array(
                                'large' => __('Large', 'mbot-woocommere' ),
                                'standard' => __( 'Standard', 'mbot-wooocommerce' ),
                                'xlarge' => __('xLarge', 'mbot-woocommere' )
                            )
                        ),
                        'send-to-messenger-color' => array(
                            'name' => __( 'Send to Messenger Button color', 'mbot-woocommmerce' ),
                             'type' => 'select',
                             'id' => 'derweili_mbot_button_color',
                             'options' => array(
                                'blue' => __('Blue', 'mbot-woocommerce' ),
                                'white' => __('Weiß', 'mbot-woocommerce')
                              )
                        ),
                        'send-to-messenger-login' => array(
                            'name' => __( 'Send-to-Messenger User Login', 'mbot-woocommmerce' ),
                             'type' => 'select',
                             'id' => 'derweili_mbot_button_enforce_login',
                             'options' => array(
                                'true' => __('Enforce Login for every user', 'mbot-woocommerce' ),
                                'false' => __('Enable Login only for logged out users', 'mbot-woocommerce' )
                              )
                        ),
                        'section_end' => array(
                             'type' => 'sectionend',
                             'id' => 'wc_mbot_settings_section_end'
                        )
                    );



            break;

            case 'section-2':
                $settings = array(
                    'section_title' => array(
                        'name'     => __( 'Section Two Title', 'mbot-woocommmerce' ),
                        'type'     => 'title',
                        'desc'     => '',
                        'id'       => 'wc_settings_tab_demo_section_title'
                    ),
                    'title' => array(
                        'name' => __( 'Section Two Title', 'mbot-woocommmerce' ),
                        'type' => 'text',
                        'desc' => __( 'This is some helper text', 'mbot-woocommmerce' ),
                        'id'   => 'wc_settings_tab_demo_title'
                    ),
                    'description' => array(
                        'name' => __( 'Section Two Description', 'mbot-woocommmerce' ),
                        'type' => 'textarea',
                        'desc' => __( 'This is a paragraph describing the setting. Lorem ipsum yadda yadda yadda. Lorem ipsum yadda yadda yadda. Lorem ipsum yadda yadda yadda. Lorem ipsum yadda yadda yadda.', 'mbot-woocommmerce' ),
                        'id'   => 'wc_settings_tab_demo_description'
                    ),
                    'section_end' => array(
                         'type' => 'sectionend',
                         'id' => 'wc_settings_tab_demo_section_end'
                    )
                );


            break;

            default : // API Credentials

             $settings = array(
                        'facebook_api_credentials_title' => array(
                        'name'     => __( 'Facebook API Credentials', 'mbot-woocommmerce' ),
                        'type'     => 'title',
                        'desc'     => __( 'Your Callback URL is:', 'mbot-woocommmerce' ) . ' <u>' . get_home_url() . '/mbot-callback-webhook/</u>' . '<br />' .  __( 'Following URLs are currently whitelisted for the use of the messenger checkbox plugin: <br />', 'mbot-woocommmerce' ) . derweili_get_whitelisted_domains() ,
                        'id'       => 'derweili_mbot_fb_credentials_title'
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
                    'section_end' => array(
                         'type' => 'sectionend',
                         'id' => 'wc_mbot_settings_section_end'
                    )
                );
            break;

        }

        return apply_filters( 'wc_settings_tab_demo_settings', $settings, $section );

    }

    /**
     * Output the settings
     */
    public function output() {
        global $current_section;
        $settings = $this->get_settings( $current_section );
        WC_Admin_Settings::output_fields( $settings );
    }


    /**
     * Save settings
     */
    public function save() {
        global $current_section;
        $settings = $this->get_settings( $current_section );
        WC_Admin_Settings::save_fields( $settings );
    }

}

return new WC_Settings_My_Plugin();