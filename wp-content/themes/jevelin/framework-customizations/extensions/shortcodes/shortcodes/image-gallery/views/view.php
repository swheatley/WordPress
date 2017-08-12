<?php
/*-----------------------------------------------------------------------------------*/
/* Image Points HTML
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }

if( $atts['image_ratio'] == 'landscape' ) :
	$image_ratio = 'post-thumbnail';
elseif( $atts['image_ratio'] == 'portrait' ) :
	$image_ratio = 'jevelin-portrait';
else :
	$image_ratio = 'jevelin-square';
endif;

$class = '';
if( isset( $atts['overlay'] ) || $atts['overlay'] == 'off' ) :
	$class = ' sh-image-gallery-noverlay';
endif;

/* Autoplay */
$autoplay = ( isset( $atts['autoplay']['autoplay'] ) ) ? $atts['autoplay']['autoplay'] : 'off';
$autoplay_atts = jevelin_get_picker( $atts['autoplay'] );
$autoplay_data = '';
if( $autoplay_atts['animation_speed'] ) :
	$autoplay_data = ' data-autoplay="'.intval( $autoplay_atts['animation_speed'] * 1000 ).'"';
endif;
?>

<div id="image-gallery-<?php echo esc_attr($atts['id']); ?>" class="sh-image-gallery<?php echo esc_attr( $class ); ?> sh-image-gallery-container sh-image-gallery-<?php echo esc_attr( $atts['dots'] ); ?>" <?php echo wp_kses_post( $autoplay_data ); ?> data-columns="<?php echo preg_replace( "/[^0-9]/","", intval( $atts['columns'] ) ); ?>">
	<?php foreach($atts['images'] as $image) : ?>
		<div class="sh-image-gallery-item">

			<div class="sh-gallery-item">
				<div class="post-meta-thumb">
					<img src="<?php echo jevelin_get_small_thumb( $image['attachment_id'], $image_ratio ); ?>" alt="<?php echo esc_attr( jevelin_get_image_alt( $image['attachment_id'] ) ); ?>" />
					<?php if( !isset( $atts['overlay'] ) || $atts['overlay'] != 'off' ) : ?>
						<?php jevelin_blog_overlay( jevelin_get_image_size($image, 'large'), 0, 1, ':imgCollection'.$atts['id'] ); ?>
					<?php endif; ?>
				</div>
			</div>

		</div>
	<?php endforeach; ?>
</div>
