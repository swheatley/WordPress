<?php
/*-----------------------------------------------------------------------------------*/
/* Video Player HTML
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
$class = ( isset($atts['custom_class']) && $atts['custom_class'] ) ? ' '.esc_attr( $atts['custom_class'] ) : '';
if( $atts['image'] ) :
	$class.= ' sh-video-player-image-placeholder';
endif;

if( $atts['video_ratio'] == '4_3' ) :
	$class.= ' sh-video-player-4_3';
endif;
?>

<div id="video-player-<?php echo esc_attr($atts['id']); ?>" class="sh-video-player sh-placement-<?php echo esc_attr($atts['placement']).$class; ?>">
	<div class="sh-video-player-container">
		<div class="sh-video-player-content">
			<?php echo wp_oembed_get( esc_url($atts['url']) ); ?>
		</div>
	</div>

	<?php if( $atts['image'] ) : ?>
		<div class="sh-video-player-image-container">
			<div class="sh-video-player-image">
				<img src="<?php echo jevelin_get_image($atts['image']); ?>" alt="" />
			</div>
			<div class="sh-video-player-image-play">
				<i class="icon-control-play"></i>
			</div>
		</div>
	<?php endif; ?>
</div>
