<?php
/*-----------------------------------------------------------------------------------*/
/* Icons HTML
/*-----------------------------------------------------------------------------------*/

if( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
if( !isset( $atts['style'] ) || !$atts['style'] ) :
	$atts['style'] = 'style1';
endif;
?>

<div id="icon-group-<?php echo esc_attr( $atts['id'] ); ?>" class="sh-icon-group sh-icon-group-<?php echo esc_attr( $atts['alignment'] ); ?> sh-icon-group-<?php echo esc_attr( $atts['style'] ); ?>">
	<?php foreach( $atts['icons'] as $icon ) : ?>

		<div class="sh-icon-group-item">
			<div class="sh-icon-group-item-container">
				<?php if( $icon['link'] ) : ?>
					<a href="<?php echo esc_url( $icon['link'] ); ?>" target="_blank">
				<?php endif; ?>

					<i class="<?php echo esc_attr( $icon['icon'] ); ?>"></i>

				<?php if( $icon['link'] ) : ?>
					</a>
				<?php endif; ?>
			</div>
		</div>

	<?php endforeach; ?>
</div>
