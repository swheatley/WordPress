<?php
/*-----------------------------------------------------------------------------------*/
/* Single Image HTML
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
$animated = ( isset( $atts['animation'] ) && $atts['animation'] != 'none' ) ? ' sh-animated '. $atts['animation'] : '';
$animated_delay = ( $animated && $atts['animation_delay'] ) ? 'data-wow-delay="'. $atts['animation_delay'] .'s"' : '';
$animated_speed = ( $animated && $atts['animation_speed'] ) ? 'data-wow-duration="'. $atts['animation_speed'] .'s"' : '';

$overlay = ( isset( $atts['overlay']['overlay'] ) ) ? $atts['overlay']['overlay'] : 'disabled';
$overlay_atts = jevelin_get_picker( $atts['overlay'] );

$class = '';
if( isset( $atts['shadow'] ) && $atts['shadow'] != 'disabled' ) :
	$class.= ' sh-single-image-'. $atts['shadow'] ;
endif;

if( $overlay == 'overlay1' ) :
	$class.= ' sh-single-image-has-'. $overlay;
endif;
?>

<div id="single-image-<?php echo esc_attr($atts['id']); ?>" class="sh-single-image<?php echo esc_attr( $class ) . esc_attr( $animated ); ?>"<?php echo wp_kses_post( $animated_speed ) . wp_kses_post( $animated_delay ); ?>>
	<?php if( isset($atts['popover']) && $atts['popover']) : ?>
		<div class="sh-popover-mini"><?php echo esc_attr( $atts['popover'] ); ?></div>
	<?php endif; ?>

	<div class="sh-single-image-container">

		<?php if( jevelin_get_image($atts['image']) ) : ?>
			<?php if( $atts['lightbox'] == true ) : ?>
				<a href="<?php echo esc_url( jevelin_get_image($atts['image']) ); ?>" rel="lightbox">
					<img class="sh-image-url" src="<?php echo esc_url( jevelin_get_image_size($atts['image'], 'large' ) ); ?>" alt="<?php echo esc_attr( jevelin_get_image_alt( $atts['image'] ) ); ?>" />
				</a>
			<?php elseif( $atts['url'] ) : ?>
				<a href="<?php echo esc_url($atts['url']); ?>">
					<img class="sh-image-url" src="<?php echo esc_url( jevelin_get_image_size($atts['image'], 'large' ) ); ?>" alt="<?php echo esc_attr( jevelin_get_image_alt( $atts['image'] ) ); ?>" />
				</a>
			<?php else : ?>
				<img class="sh-image-url" src="<?php echo esc_url( jevelin_get_image_size($atts['image'], 'large' ) ); ?>" alt="<?php echo esc_attr( jevelin_get_image_alt( $atts['image'] ) ); ?>" />
			<?php endif; ?>
		<?php endif; ?>

		<?php if( $overlay == 'overlay1' ) : ?>
			<?php if( $atts['lightbox'] == true ) : ?>
				<a class="sh-single-image-overlay" href="<?php echo esc_url( jevelin_get_image($atts['image']) ); ?>" rel="lightbox" class="sh-single-image-overlay">
			<?php elseif( $atts['url'] ) : ?>
				<a class="sh-single-image-overlay" href="<?php echo esc_url( $atts['url'] ); ?>">
			<?php else : ?>
				<a class="sh-single-image-overlay">
			<?php endif; ?>
				<div class="sh-custom-button-preset1">
					<span><?php echo esc_attr( $overlay_atts['button_name'] ); ?></span>
					<?php if( $overlay_atts['button_icon'] ) : ?>
						<i class="<?php echo esc_attr( $overlay_atts['button_icon'] ); ?>"></i>
					<?php endif; ?>
				</div>
			</a>
		<?php endif; ?>
	</div>

</div>
