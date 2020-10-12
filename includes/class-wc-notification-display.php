<?php

/** 
 *  
 * Woocommerce Notification Display Setup
 * 
 * @package Woocommerce Notification Display
 * @author Paul Jason Mongaya
 * @since 1.0.0
 * 
 * 
 */

defined( 'ABSPATH' ) || exit;

/**
 * 
 * Main Woocommerce Notification Display
 * 
 */

Class WoocommerceNotificationDisplaySetup {

    /**
     * Woocommerce Notification Display.
     *
     * @var string
     */
    public $version = '1.0.0';

    /**
     * Woocommerce Notification Display Plugin Status
     * 
     * @var boolean
     */
    public $plugin_status; 

    public function __construct() {

        global $wcnd_status;
        $this->plugin_status = $wcnd_status;

        if( $this->plugin_status ){

            $this->initialize();

        }

    }

    public function initialize() {

        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts_styles' ) );
        add_action( 'admin_menu', array( $this, 'create_subpage_under_woocommerce' ), 99 );

    }

    public function create_subpage_under_woocommerce() {

        add_submenu_page(
            'woocommerce', 
            'Notification Messages', 
            'Notification Messages',
            'manage_options', 
            'wcnd-dashboard', 
            array( $this, 'wcnd_dashboard' )
        );

    }

    public function wcnd_dashboard() {

        require_once WCND_DIR__PATH . 'includes/admin/views/html-wcnd-dashboard.php';
        require_once WCND_DIR__PATH . 'includes/admin/views/html-wcnd-add-new-msg.php';

    }


    public function enqueue_admin_scripts_styles() {

        global $pagenow;
        
        if( ( $pagenow == 'admin.php' ) && $_GET['page'] == 'wcnd-dashboard'  ) {
            wp_register_style('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
            wp_enqueue_style( 'wcnd-fontawesome-icons' , WCND_URL__PATH . 'assets/libs/fontawesome/css/all.css',  array(), false );
            wp_enqueue_style( 'wcnd-admin-dashboard' , WCND_URL__PATH . 'assets/css/wcnd-admin-dashboard.css',  array(), false );
    
            wp_enqueue_style('jquery-ui');
    
            wp_enqueue_script('jquery-ui-datepicker');
    
            wp_enqueue_script( 'wcnd-admin-scripts' , WCND_URL__PATH . 'assets/js/wcnd-admin-scripts.js',  array(), false, true);
            wp_localize_script( 'wcnd-admin-scripts', 'wcnd_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce('ajax-nonce') ) );
        }

    }

    public function list_of_message_types() {

        $msg_type   = array(
            'Select',
            'Deadline',
            'Custom Message',
            'Minimum Amount'
        );

        return $msg_type;
        
    }

    public function list_of_page_types( $pro = false ) {

        if( $pro == true ) {

            $page_type  = array( 
                'pro'   => array(
                    'product_page'      => 'Product Page',
                    'shop_page'         => 'Shop Page',
                    'cart_page'         => 'Cart Page',
                    'checkout_page'     => 'Checkout Page'
                )
            );

        } else {

            $page_type  = array( 
                'free'  => array(
                    'product_page'      => 'Product Page',
                    'shop_page'         => 'Shop Page'
                ),
                'pro'   => array(
                    'cart_page'         => 'Cart Page',
                    'checkout_page'     => 'Checkout Page'
                )
                
            );

        }

        return $page_type;

    }

    public function list_of_templates( $pro = false ) {


        if( $pro == true ) {
            $templates = array(
                'Select',
                'Template 1',
                'Template 2',
                'Template 3',
                'Template 4'
            );
        } else {
            $templates = array(
                'Select',
                'Template 1',
                'Template 2',
            );
        }
        

        return $templates;

    }

}

new WoocommerceNotificationDisplaySetup();