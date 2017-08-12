<?php
/*-----------------------------------------------------------------------------------*/
/* Testiomonials HTML
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
$i = 0;

/* Autoplay */
$autoplay = ( isset( $atts['autoplay']['autoplay'] ) ) ? $atts['autoplay']['autoplay'] : 'off';
$autoplay_atts = jevelin_get_picker( $atts['autoplay'] );
$autoplay_data = '';
if( $autoplay == 'on' ) :
	$autoplay_data = ' data-autoplay="'.intval( $autoplay_atts['animation_speed'] * 1000 ).'"';
endif;
?>

<script type="text/javascript">
jQuery(document).ready(function ($) {

	$('#testimonials-slider-<?php echo esc_js( $atts['id'] ); ?>').on('init', function(event, slick, currentSlide, nextSlide){
		$('#testimonials-<?php echo esc_js( $atts['id'] ); ?> .sh-testimonials-switch').css( 'opacity','1' );
	});

	$('#testimonials-slider-<?php echo esc_js( $atts['id'] ); ?>').slick({
		dots: false,
		arrows: true,
		infinite: true,
		speed: 500,
		slidesToShow: <?php echo ($atts['style'] == 'style4' || $atts['style'] == 'style5') ? '3' : '1'; ?>,
		fade: <?php echo ($atts['style'] != 'style4' && $atts['style'] != 'style5') ? 'true' : 'false'; ?>,
		responsive: [
			{
				breakpoint: 1000,
				settings: {
					slidesToShow: 1
				}
			}
		],
		adaptiveHeight: true,
		autoplay: <?php if( $autoplay == 'on' ) { echo 'true'; } else { echo 'false'; } ?>,
		autoplaySpeed: 5000,
	});

	function testimonials_slider_update_<?php echo esc_js( $atts['id'] ); ?>() {
		$('#testimonials-slider-<?php echo esc_js( $atts['id'] ); ?> .slick-slide').css('height', '');
		var stHeight = $('#testimonials-slider-<?php echo esc_js( $atts['id'] ); ?> .slick-track').height();
		$('#testimonials-slider-<?php echo esc_js( $atts['id'] ); ?> .slick-slide').css('height',stHeight + 'px' );
	}

	testimonials_slider_update_<?php echo esc_js( $atts['id'] ); ?>();
	$(window).on( 'load resize', function() {
		setTimeout(function(){
			testimonials_slider_update_<?php echo esc_js( $atts['id'] ); ?>();
		}, 50);
	});

	$('#testimonials-<?php echo esc_js( $atts['id'] ); ?> .sh-testimonials-prev').on( 'click', function() {
		$('#testimonials-slider-<?php echo esc_js( $atts['id'] ); ?>').slick('slickPrev');
	});

	$('#testimonials-<?php echo esc_js( $atts['id'] ); ?> .sh-testimonials-next').on( 'click', function() {
		$('#testimonials-slider-<?php echo esc_js( $atts['id'] ); ?>').slick('slickNext');
	});

});
</script>

<div id="testimonials-<?php echo esc_attr( $atts['id'] ); ?>" class="sh-testimonials sh-testimonials-<?php echo esc_attr( $atts['style'] ); ?>"<?php echo esc_attr( $autoplay_data ); ?>>
	<div class="sh-testimonials-group" id="testimonials-slider-<?php echo esc_attr( $atts['id'] ); ?>">
		<?php if( in_array( $atts['style'], array('style3') ) ) : $j = 0; ?>
			<?php foreach( $atts['testimonials'] as $item ) : $j++; $i++; ?>

				<?php if( $j == 1 ) : ?>
					<div class="sh-testimonials-item">
				<?php endif; ?>

					<div class="sh-testimonials-item-container">
						<div class="sh-testimonials-table sh-table text-left">
							<div class="sh-testimonials-table-icon sh-table-cell text-center">
								<div class="sh-testimonials-quote-icon">
									<i class="ti-quote-right"></i>
								</div>
							</div>
							<?php if( jevelin_get_image($item['avatar']) ) : ?>
								<div class="sh-testimonials-table-image sh-table-cell">
									<div class="sh-testimonials-image" style="background-image: url(<?php echo jevelin_get_image($item['avatar']); ?>);"></div>
								</div>
							<?php endif; ?>
							<div class="sh-testimonials-table-name sh-table-cell">
								<div class="sh-testimonials-name">
									<h3><?php echo esc_attr( $item['name'] ); ?></h3>
								</div>
								<div class="sh-testimonials-job">
									<?php echo esc_attr( $item['job'] ); ?>
								</div>
							</div>
							<div class="sh-testimonials-table-quote sh-table-cell-top">
								<div class="sh-testimonials-quote">
									<?php echo esc_attr( $item['quote'] ); ?>
								</div>
							</div>
						</div>
					</div>

				<?php if( $j == 2 || $i == count($atts['testimonials']) ) : $j = 0; ?>
					</div>
				<?php endif; ?>

			<?php endforeach; ?>
		<?php else : ?>
			<?php foreach( $atts['testimonials'] as $item ) : ?>
				<div class="sh-testimonials-item">

					<?php if( in_array( $atts['style'], array('style4','style5') ) ) : ?>

						<div class="sh-testimonials-item-container" style="background-image: url(<?php echo jevelin_get_image($item['avatar'], 'large'); ?>);">
							<div class="sh-testimonials-item-top">
								<div class="sh-testimonials-name">
									<h3><?php echo esc_attr( $item['name'] ); ?></h3>
								</div>
								<div class="sh-testimonials-job">
									<?php echo esc_attr( $item['job'] ); ?>
								</div>
							</div>

							<div class="sh-testimonials-table sh-table">
								<div class="sh-testimonials-table-icon sh-table-cell">
									<i class="ti-quote-right"></i>
								</div>
								<div class="sh-testimonials-table-quote sh-table-cell-top">
									<div class="sh-testimonials-quote">
										<?php echo esc_attr( $item['quote'] ); ?>
									</div>
								</div>
							</div>
						</div>

					<?php elseif( in_array( $atts['style'], array('style2') ) ) : ?>

						<div class="sh-testimonials-top">
							<div class="sh-testimonials-image" style="background-image: url(<?php echo jevelin_get_image($item['avatar']); ?>);"></div>

							<div class="sh-testimonials-top-aside">
								<div class="sh-testimonials-name">
									<h3><?php echo esc_attr( $item['name'] ); ?></h3>
								</div>

								<div class="sh-testimonials-job">
									<?php echo esc_attr( $item['job'] ); ?>
								</div>
							</div>
						</div>
						<div class="sh-testimonials-quote">
							<?php echo esc_attr( $item['quote'] ); ?>
						</div>

					<?php else : ?>

						<div class="sh-testimonials-table sh-table">
							<div class="sh-table-cell" style="width: 50%;">
								<div class="sh-testimonials-switch sh-testimonials-switch-left sh-group">
									<div class="sh-testimonials-prev">
										<i class="icon-arrow-left"></i>
									</div>
								</div>
							</div>
							<div class="sh-table-cell sh-testimonials-center">
								<div class="sh-testimonials-image" style="background-image: url(<?php echo jevelin_get_image($item['avatar']); ?>);"></div>

								<?php if( $atts['style'] == 'style6' ) : ?>
									<div class="sh-testimonials-quote-icon-container">
										<div class="sh-testimonials-quote-icon text-center">
											<i class="ti-quote-right"></i>
										</div>
									</div>
								<?php endif; ?>
							</div>
							<div class="sh-table-cell" style="width: 50%;">
								<div class="sh-testimonials-switch sh-testimonials-switch-right sh-group">
									<div class="sh-testimonials-next">
										<i class="icon-arrow-right"></i>
									</div>
								</div>
							</div>
						</div>

						<div class="sh-testimonials-quote">
							<?php echo esc_attr( $item['quote'] ); ?>
						</div>

						<div class="sh-testimonials-name">
							<h3><?php echo esc_attr( $item['name'] ); ?></h3>
						</div>

						<div class="sh-testimonials-job">
							<?php echo esc_attr( $item['job'] ); ?>
						</div>

						<?php if( $atts['style'] == 'style1' ) : ?>
							<div class="sh-testimonials-quote-icon text-center">
								<i class="ti-quote-right"></i>
							</div>
						<?php endif; ?>

					<?php endif; ?>

				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>

	<?php if( count($atts['testimonials']) > 0 && !in_array( $atts['style'], array('style1','style6') ) ) : ?>
		<?php if( $atts['style'] != 'style3' || ( $atts['style'] == 'style3' && count($atts['testimonials']) > 2 ) ) : ?>
			<?php if( $atts['style'] != 'style4' && $atts['style'] != 'style5' || ( $atts['style'] == 'style4' && count($atts['testimonials']) > 3 ) ) : ?>
				<div class="sh-testimonials-switch sh-group">
					<div class="sh-testimonials-prev">
						<i class="icon-arrow-left"></i>
					</div>
					<div class="sh-testimonials-next">
						<i class="icon-arrow-right"></i>
					</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	<?php endif; ?>
</div>