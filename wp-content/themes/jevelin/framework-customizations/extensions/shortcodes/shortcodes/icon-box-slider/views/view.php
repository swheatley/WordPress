<?php
/*-----------------------------------------------------------------------------------*/
/* Icon Box HTML
/*-----------------------------------------------------------------------------------*/

if( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
$class = '';
if( count( $atts['slides'] ) < 5 ) :
	$class = ' sh-iconbox-slider-dynamic';
endif;
?>

<div class="sh-iconbox-slider<?php echo esc_attr( $class ); ?>" id="iconbox-slider-<?php echo esc_attr( $atts['id'] ); ?>">

	<div class="sh-iconbox-slider-content" id="iconbox-slider-content-<?php echo esc_attr( $atts['id'] ); ?>">
		<?php foreach( $atts['slides'] as $slide ) :
			$color = ( isset( $slide['color'] ) && $slide['color'] ) ? 'background-color: '.$slide['color'].';' : '';
		?>
			<div class="sh-iconbox-slider-item" style="<?php echo esc_attr( $color ); ?>background-image: url( <?php echo esc_url( jevelin_get_image($slide['image'])); ?> );">
				<div class="sh-iconbox-slider-item-content">
					<div class="container">
						<div class="sh-iconbox-slider-item-content-container">
							<?php echo do_shortcode( $slide['content']); ?>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

	<div class="container">
		<div class="sh-iconbox-slider-tabs" id="iconbox-slider-tabs-<?php echo esc_attr( $atts['id'] ); ?>">
			<?php foreach( $atts['slides'] as $slide ) : ?>
				<div class="sh-iconbox-slider-tab">

					<div class="sh-iconbox-slider-tab-container">
						<div class="sh-iconbox-slider-tab-content">
							<i class="<?php echo esc_attr( $slide['icon'] ); ?>"></i>
							<h5><?php echo esc_attr( $slide['title'] ); ?></h5>
						</div>
						<i class="sh-iconbox-slider-tab-icon <?php echo esc_attr( $slide['icon'] ); ?>"></i>
					</div>

				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<script type="text/javascript">
		jQuery(document).ready(function($){
			$('#iconbox-slider-content-<?php echo esc_attr( $atts['id'] ); ?>').slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: <?php echo ( $atts['arrows'] == 'off' ) ? 'false' : 'true'; ?>,
				fade: true,
				asNavFor: '#iconbox-slider-tabs-<?php echo esc_attr( $atts['id'] ); ?>',
		        prevArrow: '<button type="button" class="slick-prev"><span class="ti-angle-left"></span></button>',
		        nextArrow: '<button type="button" class="slick-next"><span class="ti-angle-right"></span></button>',
				autoplay: <?php echo ( $atts['autoplay'] == 'off' ) ? 'false' : 'true'; ?>,
				autoplaySpeed: 6000,
			});
			$('#iconbox-slider-tabs-<?php echo esc_attr( $atts['id'] ); ?>').slick({
				slidesToShow: <?php echo ( count($atts['slides'] ) < 5 ) ? esc_js( count($atts['slides']) ) : 5; ?>,
				slidesToScroll: 1,
				asNavFor: '#iconbox-slider-content-<?php echo esc_attr( $atts['id'] ); ?>',
				arrows: false,
				dots: false,
				centerMode: <?php echo ( count($atts['slides'] ) < 6 ) ? 'false' : 'true'; ?>,
				focusOnSelect: true,
				  responsive: [
				  	{
						breakpoint: 1000,
							settings: {
							slidesToShow: <?php echo ( count($atts['slides'] ) < 3 ) ? esc_js( count($atts['slides']) ) : 3; ?>,
						}
				    },
				    {
				      breakpoint: 600,
				      settings: {
				        slidesToShow: <?php echo ( count($atts['slides'] ) < 2 ) ? 1 : 2; ?>,
				      }
				    }
				  ]
			});
		});
	</script>

</div>
