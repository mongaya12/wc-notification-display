<?php 
    defined( 'ABSPATH' ) || exit;
?>

<div class="wcnd-box-template wcnd-template-1" >
    <div class="template-box-style">
        <p><?php echo esc_html($data['message']); ?> <a href="<?php echo esc_html( $data['btnUrl'] ); ?>" class="wcnd_anchor_template"><?php echo esc_html( $data['btnText'] ); ?></a></p>
    </div>
</div>