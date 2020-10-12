<?php
/** 
 *  
 * Woocommerce Notification Display Create Tables
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
 * Woocommerce Notification Display Create Tables
 * 
 */
Class WoocommerceNotificationDisplayDatabase {

    /**
     * 
     * Woocommerce Notification Display Tables Version
     * 
     * @var string
     * 
     */
    public $db_version = '1.0.0';

    /**
     * 
     * Woocommerce Notification Table Prefix
     * 
     * @var string
     */
    public $table_prefix = '';

    /**
     * 
     * Woocommerce Notification Table Names
     * 
     * @var string
     * 
     */
    public $db_tb_messages  = 'wcnd_messages';

    /**
     * 
     * Woocommerce Notification Table
     * 
     */
    private $table_name = '';


    public function __construct() {

        global $wpdb;
        $this->table_prefix = $wpdb->prefix;
        $this->table_name = $wpdb->prefix . $this->db_tb_messages;

        add_action( 'init', array( $this, 'initialize') );

    }

    public function initialize() {

        $this->create_tables();
        $this->setup_ajax_handlers();

    }

    public function create_tables() {

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        $table_name     = $this->table_prefix . $this->db_tb_messages;

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id int(10) unsigned NOT NULL AUTO_INCREMENT,
        templateID int(10) NOT NULL,
        messageType int(10) NOT NULL,
        pageType varchar(255) NOT NULL,
        messages varchar(500) NOT NULL,
        startDate varchar(100) NOT NULL,
        endDate varchar(100) NOT NULL,
        btnText varchar(255) NOT NULL,
        btnUrl varchar(255) NOT NULL,
        created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at timestamp NOT NULL,
        PRIMARY KEY  (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

        dbDelta( $sql );

    }

    public function setup_ajax_handlers() {

        add_action( 'wp_ajax_delete_single_row_message', array( $this, 'delete_row_message' ) );

        add_action( 'wp_ajax_get_row_message', array( $this, 'get_one_message' ) );

        add_action( 'wp_ajax_update_row_message', array( $this, 'update_row_message' ) );

        add_action( 'wp_ajax_save_notification_wcnd', array( $this, 'save_message_data' ) );

    } 

    public function is_valid_value( $val, $ver = false ) {

        // version default free = false
        if( $ver == false ) {

        }

    }

    public function save_message_data( ) {

        global $wpdb;

        $msg_type       = (int) $_POST['message_type'];
        $page_display   = sanitize_text_field( $_POST['page_display'] );
        $template_id    = (int) $_POST['template_id'];
        $start_date     = sanitize_text_field( $_POST['start_date'] );
        $end_date       = sanitize_text_field( $_POST['end_date'] );
        $msg_box        = sanitize_textarea_field( $_POST['message_box'] );
        $btn_text       = sanitize_text_field( $_POST['button_text'] );
        $btn_url        = sanitize_text_field( $_POST['button_url'] );
        $nonce          = $_POST['nonce'];

        $data = array(
            'msg_type'          => $msg_type,
            'page_display'      => $page_display,
            'template_id'       => $template_id,
            'start_date'        => $start_date,
            'end_date'          => $end_date,
            'msg_box'           => $msg_box,
            'btn_text'          => $btn_text,
            'btn_url'           => $btn_url
        );

        if( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
            die('Busted!');

        $table_name     = $wpdb->prefix . $this->db_tb_messages;    

        $savemsg        = $wpdb->insert( $table_name, 
        array( 
            'templateId'        => $data['template_id'], 
            'messageType'       => $data['msg_type'],
            'pageType'          => $data['page_display'],
            'messages'          => $data['msg_box'],
            'startDate'         => $data['start_date'],
            'endDate'           => $data['end_date'],
            'btnText'           => $data['btn_text'],
            'btnUrl'            => $data['btn_url'] 
            ) 
        );

        wp_send_json_success(
            wp_json_encode( $savemsg )
        );

        die();

    }

    public function notification_messages() {

        global $wpdb;

        $messages = $wpdb->get_results( 
            $wpdb->prepare("SELECT *  FROM {$this->table_name} ORDER BY id DESC") 
         );

        return $messages; 

    }

    public function delete_row_message() {

        global $wpdb;
        
        $nonce  = $_POST['nonce'];
        $id     = (int) $_POST['messageID'];

        if( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
            die('Busted!');

        $delete_msg = $wpdb->delete( $this->table_name, array( 'id' => $id ) );

        wp_send_json_success(
            wp_json_encode( $delete_msg )
        );

        die();

    }

    public function get_one_message() {

        global $wpdb;

        $nonce  = $_POST['nonce'];
        $id     = (int) $_POST['messageID'];

        if( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
            die('Busted!');

        $message = $wpdb->get_results( 
        $wpdb->prepare("SELECT * FROM {$this->table_name} WHERE id={$id}") 
            );
        
        $castArr        = $message;
        $html_output    = array();

        if( empty( $castArr ) ) {
            $html_output['error'] = true;

            wp_send_json_success( 
                $html_output
            );

            die();
        }
        
        ob_start();
        include WCND_DIR__PATH . 'includes/admin/views/html-wcnd-edit-msg.php';
        $content = ob_get_clean();
        
        $html_output['content'] = $content;
        $html_output['error']   = false;

        wp_send_json_success( 
            $html_output
        );
        
        die();

    }


    public function update_row_message() {

        global $wpdb;

        $msg_type       = (int) $_POST['message_type'];
        $page_display   = sanitize_text_field( $_POST['page_display'] );
        $template_id    = (int) $_POST['template_id'];
        $start_date     = sanitize_text_field( $_POST['start_date'] );
        $end_date       = sanitize_text_field( $_POST['end_date'] );
        $msg_box        = sanitize_textarea_field( $_POST['message_box'] );
        $btn_text       = sanitize_text_field( $_POST['button_text'] );
        $btn_url        = sanitize_text_field( $_POST['button_url'] );
        $msgId          = (int) $_POST['messageId'];
        $nonce          = $_POST['nonce'];

        $data = array(
            'msg_type'          => $msg_type,
            'page_display'      => $page_display,
            'template_id'       => $template_id,
            'start_date'        => $start_date,
            'end_date'          => $end_date,
            'msg_box'           => $msg_box,
            'btn_text'          => $btn_text,
            'btn_url'           => $btn_url
        );

        if( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
            die('Busted!');

        $update_msg = $wpdb->update( $this->table_name, 
        array( 
            'templateId'        => $data['template_id'], 
            'messageType'       => $data['msg_type'],
            'pageType'          => $data['page_display'],
            'messages'          => $data['msg_box'],
            'startDate'         => $data['start_date'],
            'endDate'           => $data['end_date'],
            'btnText'           => $data['btn_text'],
            'btnUrl'            => $data['btn_url'],
            'updated_at'        => current_time('G'),
        ), array('id' => $msgId) );
        
        wp_send_json_success(
            wp_json_encode( $update_msg )
        );

        die();

    }

}

new WoocommerceNotificationDisplayDatabase();