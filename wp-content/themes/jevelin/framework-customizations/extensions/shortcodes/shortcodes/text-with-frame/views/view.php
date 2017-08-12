<?php
/*-----------------------------------------------------------------------------------*/
/* Text Block HTML
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
$animated = ( isset( $atts['animation'] ) && $atts['animation'] != 'none' ) ? ' sh-animated '. $atts['animation'] : '';
$animated_delay = ( $animated && $atts['animation_delay'] ) ? 'data-wow-delay="'. $atts['animation_delay'] .'s"' : '';
$animated_speed = ( $animated && $atts['animation_speed'] ) ? 'data-wow-duration="'. $atts['animation_speed'] .'s"' : '';
?>

<div class="sh-text-with-frame<?php echo esc_attr( $animated ); ?>" id="text-with-frame-<?php echo esc_attr( $atts['id'] ); ?>"<?php echo wp_kses_post( $animated_speed ) . wp_kses_post( $animated_delay ); ?>>
	<div class="sh-text-with-frame-container">
		<?php echo wp_kses_post( do_shortcode( $atts['content']) ); ?>
	</div>
</div>