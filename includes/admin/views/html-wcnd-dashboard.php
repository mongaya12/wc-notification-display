<?php 

/**
 * 
 * WCND - Admin View Dashboard
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$notification_msg = WNDD();
?>

<div class="wrap-wcnd-dashboard">
    <div class="wcnd-layout__header">
        <div class="wcnd-head-helper">
            <div class="wcnd-head__title">
                <?php esc_html_e( 'WooCommerce Custom Notification Messages', 'wc-notification-display' ); ?>
                <span>
                <?php esc_html_e( 'Shop', 'wc-notification-display' ); ?> <i class="far fa-dot-circle"></i> 
                <?php esc_html_e( 'Products', 'wc-notification-display' ); ?> <i class="far fa-dot-circle"></i> 
                <?php esc_html_e( 'Cart', 'wc-notification-display' ); ?> <i class="far fa-dot-circle"></i> 
                <?php esc_html_e( 'Checkout Page', 'wc-notification-display' ); ?></span>
            </div>
        </div>
    </div>
    <div class="wcnd-body-content">
        <div class="wcnd-items-tab">
            <ul>
                <li class="wcnd-tab-active">
                    <a href="#messages-list" class="wcnd-tab-item">
                        <i class="fas fa-comment-dots"></i>
                        <?php esc_html_e( 'Messages', 'wc-notification-display' ); ?>
                    </a>
                </li>
                <li>
                    <a href="#templates-list" class="wcnd-tab-item">
                        <i class="fas fa-folder-open"></i>
                        <?php esc_html_e( 'Templates', 'wc-notification-display' ); ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="wcnd-tab-contents">
            <div id="messages-list" class="wcnd-hide wcnd-default-show messages-list-wrapper">
                <a href="" class="wcnd-add-new-msg">
                    <?php esc_html_e( 'ADD MESSAGE', 'wc-notification-display' ); ?>
                </a>
               <table>
                   <thead>
                       <th><?php esc_html_e( 'Index', 'wc-notification-display' ); ?></th>
                       <th><?php esc_html_e( 'Type', 'wc-notification-display' ); ?></th>
                       <th><?php esc_html_e( 'Message', 'wc-notification-display' ); ?></th>
                       <th><?php esc_html_e( 'Button Text', 'wc-notification-display' ); ?></th>
                       <th><?php esc_html_e( 'Button URL', 'wc-notification-display' ); ?></th>
                       <th><?php esc_html_e( 'Controls', 'wc-notification-display' ); ?></th>
                   </thead>
                   <tbody>
                    <?php 
                        if( $notification_msg->notification_messages() ){
                            $counter = 1;
                            foreach( $notification_msg->notification_messages() as $key ) { ?>
                                <tr>
                                    <td>
                                        <?php 
                                            echo esc_html( $counter ); 
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            echo esc_html( wcnd_message_type( $key->messageType ) ); 
                                        ?>
                                    </td>
                                    <td class="ncwd-custom-message">
                                        <?php 
                                            echo esc_html(  $key->messages  ); 
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            echo esc_html(  $key->btnText  ); 
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            echo esc_html(  $key->btnUrl  ); 
                                        ?>
                                    </td>
                                    <td>
                                        <div class="wcnd-block-wrapper">
                                            <a href="" class="action-wcnd-btn wcnd-action-edit" data-wcnd-id="<?php 
                                            echo esc_html( $key->id ); 
                                        ?>">
                                                <?php esc_html_e( 'Edit', 'wc-notification-display' ); ?>
                                            </a>
                                        </div>
                                        <div class="wcnd-block-wrapper">
                                            <a href="" class="action-wcnd-btn wcnd-action-delete" data-wcnd-id="<?php 
                                            echo esc_html( $key->id ); 
                                        ?>" >
                                                <?php esc_html_e( 'Delete', 'wc-notification-display' ); ?>   
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                    <?php
                            $counter++;
                            }
                        }
                    ?>
                       
                       
                   </tbody>
               </table>
            </div>
            <div id="templates-list" class="wcnd-hide templates-list-wrapper">
                        kjasdfklasdklfaklsdflkasdfkjl
            </div>
        </div>
    </div>
</div>