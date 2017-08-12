<?php ob_start("jevelin_compress"); ?>
    jQuery(document).ready(function ($) {
        "use strict";

        <?php
        /*-----------------------------------------------------------------------------------*/
        /* Theme Options - JS Code
        /*-----------------------------------------------------------------------------------*/
        ?>

        <?php if( jevelin_option('custom_js') ) : ?>
            <?php echo wp_kses_post( jevelin_option('custom_js') ); ?>
        <?php endif; ?>

    });

<?php ob_end_flush(); ?>
