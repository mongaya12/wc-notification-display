<?php
/**
 * Plugin Name: Woocommerce Notification Display
 * Plugin URI: 
 * Description: Woocommerce notification message will help you to boost your sales by displaying information to customer  about promotions, offers and sales on the shop page, product page, cart page and during check-out process.
 * Version: 1.0
 * Author: Paul Jason Mongaya
 * Author URI: http://www.mywebsite.com
 */

if ( !defined( 'ABSPATH' ) ) {
    die;
}

define('WCND_DIR__PATH', plugin_dir_path( __FILE__ ) );
define('WCND_URL__PATH', plugin_dir_url( __FILE__ ) );

require_once WCND_DIR__PATH . 'includes/wcnd-notice-functions.php';
require_once WCND_DIR__PATH . 'includes/wcnd-encoded-data-functions.php';

/**
* Detect plugin. For use in Admin area only.
*/
$wcnd_status = true;
if ( ! in_array( 
    'woocommerce/woocommerce.php', 
    apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) 
   )  ) {

    add_action( 'admin_notices', 'wcnd_admin_notice_error' );
    
    $wcnd_status = false;

}

require_once WCND_DIR__PATH . 'includes/class-wcnd-database.php';
require_once WCND_DIR__PATH . 'includes/class-validate-messages.php';
require_once WCND_DIR__PATH . 'includes/class-wc-notification-display.php';

//GLOBAL - CHECK STATUS IF WOOCMMERCE IS INSTALLED RETURN BOOLEAN;
$GLOBAL['wcnd_status'] = $wcnd_status;

function WNDD(){
    return new WoocommerceNotificationDisplayDatabase();
}

function WNDS() {
    return new WoocommerceNotificationDisplaySetup();
}
