<?php

/** 
 *  
 * Woocommerce Notification Display Message
 * 
 * @package Woocommerce Notification Display Template
 * @author Paul Jason Mongaya
 * @since 1.0.0
 * 
 * 
 */

defined( 'ABSPATH' ) || exit;

/**
 * 
 * Display Template Front End
 * 
 */

Class WoocommerceNotificationDisplayMessageTemplate {

    public function __construct() {

        $this->initialize();

    }

    public function initialize() {

        add_action( 'wp_enqueue_scripts', array( $this, 'scripts_styles_frontend' ) );
        add_action( 'wp_loaded', array( $this, 'template_html' ) );

    }

    public function scripts_styles_frontend() {

        wp_enqueue_style( 'wcnd-fontawesome-icons' , WCND_URL__PATH . 'assets/libs/fontawesome/css/all.css',  array(), false );
        wp_enqueue_style( 'wcnd-front-end' , WCND_URL__PATH . 'assets/css/wcnd-front-end-template.css',  array(), false );

    }

    public function get_template_html_by_id( $id ) {

        switch ($id) {
            
            case '1':
                return WCND_DIR__PATH . "templates/wcnd-template-1.php"; 
                break;
            
            case '2':
                return WCND_DIR__PATH . "templates/wcnd-template-2.php";
                break;

            default:
                return WCND_DIR__PATH . "templates/wcnd-template-1.php";
                break;

        }

    }

    public function hook_product_page_wc( $data = array() ) {
        
        if( ! $data )
            return;

        ob_start();
        include $this->get_template_html_by_id( $data['templateID'] );
        $content = ob_get_clean();
        echo $content;
        
    }

    public function hook_shop_page_wc( $data = array() ) {

        if( ! $data )
            return;

        ob_start();
        include $this->get_template_html_by_id( $data['templateID'] );
        $content = ob_get_clean();
        echo $content;
    }

    public function hook_template_to_wc( $data = array() ) {


        if( $data['page_type'] == 'product_page'   ) {

            add_action( 'woocommerce_before_main_content' , array( $this, 'hook_product_page_wc' ),10 );
            $this->hook_product_page_wc($data);

        }

        if( $data['page_type'] == 'shop_page'  ) {

            add_action( 'woocommerce_before_main_content' , array( $this, 'hook_shop_page_wc' ),10 );
            $this->hook_shop_page_wc($data);

        }
        

    }

    public function template_html() {

        $msg_data = $this->start_end_date();

        if( $msg_data ) {

            foreach( $msg_data as $data ) {

                if( $data->templateID == 1 ) {

                    $arr_msg = array(
                        'page_type'     => $data->pageType,
                        'templateID'    => $data->templateID,
                        'btnText'       => $data->btnText,
                        'btnUrl'        => $data->btnUrl,
                        'message'       => $data->messages
                    );

                    $this->hook_template_to_wc( $arr_msg );

                }

            }

        }

    }

    private function start_end_date() {

        $current_date   = current_time('m-d-Y');
        $msg_data       = WNDD()->get_start_date($current_date);
        $filter_date    = array();

        if( $msg_data ) {

            foreach( $msg_data as $data => $val ) {

                $endDate        = strtotime( $data['endDate'] );
                $current_date   = strtotime( $current_date );

                if( $endDate >= $current_date ) {
                    $filter_date[$data] = $val;
                }

            }

        } else {

            $filter_date = 'Empty';

        }

        return $filter_date;

    } 


}

new WoocommerceNotificationDisplayMessageTemplate();