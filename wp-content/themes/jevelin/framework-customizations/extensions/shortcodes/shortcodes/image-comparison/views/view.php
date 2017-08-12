<?php
/*-----------------------------------------------------------------------------------*/
/* Single Image HTML
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
$animated = ( isset( $atts['animation'] ) && $atts['animation'] != 'none' ) ? ' sh-animated '. $atts['animation'] : '';
$animated_delay = ( $animated && $atts['animation_delay'] ) ? 'data-wow-delay="'. $atts['animation_delay'] .'s"' : '';
$animated_speed = ( $animated && $atts['animation_speed'] ) ? 'data-wow-duration="'. $atts['animation_speed'] .'s"' : '';

if( isset($atts['source']) && $atts['source'] != 'large' ) :
	$source = 'full';
else :
	$source = 'large';
endif;
?>

<script type="text/javascript">
	jQuery(window).load(function(){
		jQuery("#image-comparison-<?php echo esc_js($atts['id']); ?>").twentytwenty({
			default_offset_pct: 0.5,
		});
	});
</script>

<div id="image-comparison-<?php echo esc_attr($atts['id']); ?>" class="sh-image-comparison<?php echo esc_attr( $animated ); ?>"<?php echo wp_kses_post( $animated_speed ) . wp_kses_post( $animated_delay ); ?>>
	<img src="<?php echo jevelin_get_image_size($atts['image_b'], $source); ?>" alt="<?php echo esc_attr($atts['text_b']); ?>" />
	<img src="<?php echo jevelin_get_image_size($atts['image_a'], $source); ?>" alt="<?php echo esc_attr($atts['text_a']); ?>" />
</div>