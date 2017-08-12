<?php
/*-----------------------------------------------------------------------------------*/
/* Heading HTML
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
$size = ( isset( $atts['size']['size'] ) ) ? $atts['size']['size'] : 'default';
$size_atts = jevelin_get_picker( $atts['size'] );
$size_class = ' size-'.$size;

$animated = ( isset( $atts['animation'] ) && $atts['animation'] != 'none' ) ? ' sh-animated '. $atts['animation'] : '';
$animated_delay = ( $animated && $atts['animation_delay'] ) ? 'data-wow-delay="'. $atts['animation_delay'] .'s"' : '';
$animated_speed = ( $animated && $atts['animation_speed'] ) ? 'data-wow-duration="'. $atts['animation_speed'] .'s"' : '';
?>

<div class="sh-heading<?php echo esc_attr( $animated ); ?>" id="heading-<?php echo esc_attr( $atts['id'] ); ?>"<?php echo wp_kses_post( $animated_speed ) . wp_kses_post( $animated_delay ); ?>>
	<<?php echo esc_attr($atts['heading']); ?> class="sh-heading-content<?php echo esc_attr( $size_class ); ?> text-<?php echo esc_attr( $atts['alignment'] ); ?>">
		<?php echo jevelin_remove_p($atts['content']); ?>
	</<?php echo esc_attr($atts['heading']); ?>>
</div>