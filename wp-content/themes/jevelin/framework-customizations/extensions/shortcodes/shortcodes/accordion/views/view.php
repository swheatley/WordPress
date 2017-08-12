<?php
/*-----------------------------------------------------------------------------------*/
/* Accordion HTML
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
$style = ( isset( $atts['style']['style'] ) ) ? $atts['style']['style'] : 'style1';
$style_atts = jevelin_get_picker( $atts['style'] );
?>

<div class="sh-accordion sh-accordion-<?php echo esc_attr( $style ); ?> panel-group" id="accordion-<?php echo esc_attr( $atts['id'] ); ?>" role="tablist" aria-multiselectable="true">
	<?php
		$i = 0;
		if( isset($atts['collapsed']) && $atts['collapsed'] != true ) :
			$i++;
		endif;

		foreach( $atts['testimonials'] as $item ) :
			$i++;
			$collapse = 'collapse-'.$atts['id'].'-'.$i;
			$heading = 'heading-'.$atts['id'].'-'.$i;
	?>
		<div class="sh-accordion-item panel panel-default">
			<div class="panel-heading" role="tab" id="<?php echo esc_attr( $heading ); ?>">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion-<?php echo esc_attr( $atts['id'] ); ?>" href="#<?php echo esc_attr( $collapse ); ?>" aria-expanded="<?php echo ($i == 1) ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $collapse ); ?>" class="<?php echo ($i != 1) ? 'collapsed' : ''; ?>">

						<?php if( isset($atts['icon_position']) && $atts['icon_position'] != 'right' ) : ?>

							<div class="sh-table">
								<div class="sh-table-cell sh-accordion-icon-cell">
									<span class="sh-accordion-icon">

										<?php if( isset($atts['icon_close']) && $atts['icon_close'] ) : ?>
											<i class="open-icon <?php echo esc_attr($atts['icon']); ?>"></i>
											<i class="close-icon <?php echo esc_attr($atts['icon_close']); ?>"></i>
										<?php else : ?>
											<i class="<?php echo esc_attr($atts['icon']); ?>"></i>
										<?php endif; ?>

									</span>
								</div>
								<div class="sh-table-cell sh-accordion-content-cell">
									<span class="sh-accordion-title"><?php echo esc_attr( $item['title'] ); ?></span>
								</div>
							</div>

						<?php else : ?>

							<div class="sh-table">
								<div class="sh-table-cell-top sh-accordion-content-cell">
									<span><?php echo esc_attr( $item['title'] ); ?></span>
								</div>
								<div class="sh-table-cell-top sh-accordion-icon-cell">
									<span class="sh-accordion-icon">

										<?php if( isset($atts['icon_close']) && $atts['icon_close'] ) : ?>
											<i class="open-icon <?php echo esc_attr($atts['icon']); ?>"></i>
											<i class="close-icon <?php echo esc_attr($atts['icon_close']); ?>"></i>
										<?php else : ?>
											<i class="<?php echo esc_attr($atts['icon']); ?>"></i>
										<?php endif; ?>

									</span>
								</div>
							</div>

						<?php endif; ?>

					</a>
				</h4>
			</div>
			<div id="<?php echo esc_attr( $collapse ); ?>" class="panel-collapse collapse<?php echo ($i == 1) ? ' in' : ''; ?>" role="tabpanel" aria-labelledby="<?php echo esc_attr( $heading ); ?>">
				<div class="panel-body">

					<div class="sh-table">
						<?php if( isset($atts['icon_position']) && $atts['icon_position'] != 'right' ) : ?>

							<div class="sh-table-cell-top sh-accordion-icon-cell">
								<span class="sh-accordion-icon">

									<?php if( isset($atts['icon_close']) && $atts['icon_close'] ) : ?>
										<i class="open-icon <?php echo esc_attr($atts['icon']); ?>"></i>
										<i class="close-icon <?php echo esc_attr($atts['icon_close']); ?>"></i>
									<?php else : ?>
										<i class="<?php echo esc_attr($atts['icon']); ?>"></i>
									<?php endif; ?>

								</span>
							</div>

						<?php endif; ?>
						<div class="sh-table-cell-top sh-accordion-content-cell">
							<?php add_filter('wp_kses_allowed_html','jevelin_allow_iframe_tags', 1); ?>
							<?php echo wp_kses_post( apply_filters( 'the_content', $item['content'] ) ); ?>
							<?php remove_filter('wp_kses_allowed_html','jevelin_allow_iframe_tags', 1); ?>
						</div>
					</div>

				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>
