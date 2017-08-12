<?php
/*-----------------------------------------------------------------------------------*/
/* Button HTML
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
$animated = ( isset( $atts['animation'] ) && $atts['animation'] != 'none' ) ? ' sh-animated '. $atts['animation'] : '';
$animated_delay = ( $animated && $atts['animation_delay'] ) ? 'data-wow-delay="'. $atts['animation_delay'] .'s"' : '';
$animated_speed = ( $animated && $atts['animation_speed'] ) ? 'data-wow-duration="'. $atts['animation_speed'] .'s"' : '';
?>

<div id="button-<?php echo esc_attr($atts['id']); ?>" class="sh-button-container sh-button-style-<?php echo esc_attr($atts['style']); ?><?php echo esc_attr( $animated ); ?>"<?php echo wp_kses_post( $animated_speed ) . wp_kses_post( $animated_delay ); ?>>
	<a href="<?php echo esc_url($atts['url']); ?>" target="<?php echo esc_attr($atts['target']); ?>" class="sh-button sh-button-<?php echo esc_attr($atts['size']); ?> <?php if( $atts['icon'] ) : ?>sh-button-icon-<?php echo esc_attr($atts['icon_alignment']); ?><?php endif; ?>">

		<?php if( $atts['icon'] ) : ?>
			<span class="sh-button-icon">
				<i class="<?php echo esc_attr($atts['icon']); ?>"></i>
			</span>
		<?php endif; ?>

		<?php if( $atts['text'] ) : ?>
			<span class="sh-button-text">
				<?php echo esc_attr($atts['text']); ?>
			</span>
		<?php endif; ?>

		<?php if( $atts['tale'] != 'none' && $atts['style'] != '3' ) : ?>
			<span class="sh-button-tale sh-button-tale-<?php echo esc_attr($atts['tale']); ?>"></span>
		<?php endif; ?>

	</a>
	<?php if( $atts['style'] == '4' ) : ?>

		<div class="sh-button sh-button-<?php echo esc_attr($atts['size']); ?> sh-button-icon-<?php echo esc_attr($atts['icon_alignment']); ?> sh-button-hidden">
			<?php if( $atts['icon'] ) : ?>
				<span class="sh-button-icon">
					<i class="<?php echo esc_attr($atts['icon']); ?>"></i>
				</span>
			<?php endif; ?>

			<?php if( $atts['text'] ) : ?>
				<span class="sh-button-text">
					<?php echo esc_attr($atts['text']); ?>
				</span>
			<?php endif; ?>
		</div>

	<?php endif; ?>
</div>