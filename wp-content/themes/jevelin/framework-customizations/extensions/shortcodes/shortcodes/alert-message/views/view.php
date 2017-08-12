<?php
/*-----------------------------------------------------------------------------------*/
/* Alert Message HTML
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
?>

<div id="alert-<?php echo esc_attr($atts['id']); ?>" class="sh-alert sh-alert-<?php echo esc_attr($atts['type']); ?>">
	<div class="sh-alert-data sh-table">
		<?php if( $atts['alignment'] != 'center' ) : ?>

			<?php if( $atts['icon'] ) : ?>
				<div class="sh-table-cell sh-alert-data-icon">
					<i class="<?php echo esc_attr($atts['icon']); ?> sh-alert-icon"></i>
				</div>
			<?php endif; ?>
			<div class="sh-table-cell width-full">
				<?php if( $atts['title'] ) : ?>
					<h3 class="sh-alert-title">
						<?php echo esc_attr($atts['title']); ?>
					</h3>
				<?php endif; ?>

				<?php if( $atts['text'] ) : ?>
					<div class="sh-alert-text">
						<?php echo esc_attr($atts['text']); ?>
					</div>
				<?php endif; ?>
			</div>

		<?php else : ?>

			<div class="sh-table-cell-top sh-alert-center width-full">
			
				<?php if( $atts['title'] ) : ?>
					<h3 class="sh-alert-title">
						<?php if( $atts['icon'] ) : ?>
							<i class="<?php echo esc_attr($atts['icon']); ?> sh-alert-icon"></i>
						<?php endif; ?>

						<?php echo esc_attr($atts['title']); ?>
					</h3>
				<?php endif; ?>

				<?php if( $atts['text'] ) : ?>
					<div class="sh-alert-text">
						<?php echo esc_attr($atts['text']); ?>
					</div>
				<?php endif; ?>
			</div>

		<?php endif; ?>
	</div>
	<?php if( $atts['close'] != false ) : ?>
	<div class="sh-alert-close">
		<div class="sh-table-full">
			<div class="sh-table-cell">
				<i class="ti-close"></i>
			</div>
		</div>
	</div>
	<?php endif; ?>
</div>