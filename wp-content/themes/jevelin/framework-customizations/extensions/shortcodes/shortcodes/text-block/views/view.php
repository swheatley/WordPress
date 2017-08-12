<?php
/*-----------------------------------------------------------------------------------*/
/* Text Block HTML
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
$class = ( $atts['class'] ) ? ' '. $atts['class'] : '';
?>

<div id="text-block-<?php echo esc_attr( $atts['id'] ); ?>" class="sh-text-block<?php echo esc_attr( $class ); ?>">
	<?php echo do_shortcode( $atts['content'] ); ?>
</div>