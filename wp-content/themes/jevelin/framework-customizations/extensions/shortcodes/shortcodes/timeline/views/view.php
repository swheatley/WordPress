<?php
/*-----------------------------------------------------------------------------------*/
/* Timeline HTML
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
$style = ( isset( $atts['style']['style'] ) ) ? esc_attr($atts['style']['style']) : 'style1';
$style_atts = jevelin_get_picker( $atts['style'] );
?>

<?php if( $style == 'style2' || $style == 'style2 style3' ) : ?>

	<div class="sh-timeline-2 sh-timeline-<?php echo esc_attr( $style ); ?>" id="timeline-<?php echo esc_attr( $atts['id'] ); ?>">
		<?php
			$i = 0;
			foreach( $atts['timeline'] as $item ) : $i++;
				if( isset( $item['image'] ) && isset( $item['image']['attachment_id'] ) && $item['image']['attachment_id'] ) :
					$image_src = wp_get_attachment_image_src( esc_attr($item['image']['attachment_id'] ), 'medium' );
				endif;

				if( isset( $image_src ) && isset( $image_src[0] ) && $image_src ) :
					$image = esc_url( $image_src[0] );
				else :
					$image = '';
				endif;
		?>
			<div class="sh-timeline-item">
				<div class="sh-timeline-item-container">
					<div class="sh-timeline-box sh-timeline-box-left">
						<div class="sh-table">
							<?php if( $image ) : ?>
								<div class="sh-table-cell sh-timeline-image">
									<a href="<?php echo jevelin_get_image( $item['image'] ); ?>" rel="lightbox" class="sh-timeline-image-container" style="background-image: url(<?php echo esc_url($image); ?>);"></a>
								</div>
							<?php endif; ?>
							<div class="sh-timeline-content-container sh-table-cell<?php if( !$image ) : ?> sh-timeline-content-full<?php endif; ?>">
								<h3>
									<?php if( isset($item['icon']) && $item['icon'] ) : ?>
										<i class="<?php echo esc_attr($item['icon']); ?>"></i>
									<?php endif; ?>
									<?php echo esc_attr($item['title']); ?>
								</h3>
								<div class="sh-timeline-content">
									<?php add_filter('wp_kses_allowed_html','jevelin_allow_iframe_tags', 1); ?>
									<?php echo wp_kses_post( apply_filters( 'the_content', $item['content'] ) ); ?>
									<?php remove_filter('wp_kses_allowed_html','jevelin_allow_iframe_tags', 1); ?>
								</div>
							</div>
						</div>
						<div class="sh-timeline-box-circle"></div>
						<div class="sh-timeline-box-tale"></div>
						<div class="sh-timeline-date">
							<?php echo esc_attr($item['date']); ?>
						</div>
					</div>

					<div class="sh-timeline-box sh-timeline-box-right">
						<div class="sh-table">
							<div class="sh-timeline-content-container sh-table-cell<?php if( !$image ) : ?> sh-timeline-content-full<?php endif; ?>">
								<h3>
									<?php echo esc_attr($item['title']); ?>
									<?php if( isset($item['icon']) && $item['icon'] ) : ?>
										<i class="<?php echo esc_attr($item['icon']); ?>"></i>
									<?php endif; ?>
								</h3>
								<div class="sh-timeline-content">
									<?php add_filter('wp_kses_allowed_html','jevelin_allow_iframe_tags', 1); ?>
									<?php echo wp_kses_post( apply_filters( 'the_content', $item['content'] ) ); ?>
									<?php remove_filter('wp_kses_allowed_html','jevelin_allow_iframe_tags', 1); ?>
								</div>
							</div>
							<div class="sh-table-cell sh-timeline-image">
								<a href="<?php echo jevelin_get_image( $item['image'] ); ?>" rel="lightbox" class="sh-timeline-image-container" style="background-image: url(<?php echo esc_url($image); ?>);"></a>
							</div>
						</div>
						<div class="sh-timeline-box-circle"></div>
						<div class="sh-timeline-box-tale"></div>
						<div class="sh-timeline-date">
							<?php echo esc_attr($item['date']); ?>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

<?php else : ?>

	<div class="sh-timeline" id="timeline-<?php echo esc_attr( $atts['id'] ); ?>">
		<?php foreach( $atts['timeline'] as $item ) : ?>
			<div class="sh-timeline-item">
				<div class="sh-timeline-item-container">
					<div class="sh-timeline-box">
						<?php echo esc_attr($item['date']); ?>
						<div class="sh-timeline-box-circle"></div>
						<div class="sh-timeline-box-tale"></div>
					</div>
					<h3><?php echo esc_attr($item['title']); ?></h3>
					<div class="sh-timeline-content">
						<?php echo wp_kses_post($item['content']); ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

<?php endif; ?>
