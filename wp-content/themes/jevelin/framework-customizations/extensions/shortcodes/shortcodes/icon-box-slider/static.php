<?php if (!defined('FW')) die('Forbidden');
if(!function_exists('jevelin_shortcode_icon_box_slider_css')) :
	function jevelin_shortcode_icon_box_slider_css ($data) {
		$atts = jevelin_shortcode_options($data,'icon-box-slider'); ob_start(); ?>

			<?php
			$accent_color = ( esc_attr($atts['accent_color']) ) ? $atts['accent_color'] : jevelin_option('accent_color');
			if( $accent_color ) : ?>

                #iconbox-slider-<?php echo esc_attr( $atts['id'] ); ?> .sh-iconbox-slider-tab.slick-current .sh-iconbox-slider-tab-content i {
                    color: <?php echo esc_attr( $accent_color ); ?>!important;
                }
                #iconbox-slider-<?php echo esc_attr( $atts['id'] ); ?> .sh-iconbox-slider-tab.slick-current:after {
                    background-color: <?php echo esc_attr( $accent_color ); ?>!important;
                }

			<?php endif; ?>

			<?php if( isset( $atts['height'] ) && $atts['height'] != '600px' && $atts['height'] ) : ?>
				@media (max-width: 1024px) {
					#iconbox-slider-<?php echo esc_attr( $atts['id'] ); ?> .sh-iconbox-slider-item {
						height: <?php echo jevelin_addpx( $atts['height'] ); ?>
					}
				}
			<?php endif; ?>

			<?php if( isset( $atts['slide_title_color'] ) && $atts['slide_title_color'] ) : ?>
				#iconbox-slider-<?php echo esc_attr( $atts['id'] ); ?> .sh-iconbox-slider-item * {
					color: <?php echo esc_attr( $atts['slide_title_color'] ); ?>!important;
				}
			<?php endif; ?>

			<?php if( isset( $atts['slide_descr_color'] ) && $atts['slide_descr_color'] ) : ?>
				#iconbox-slider-<?php echo esc_attr( $atts['id'] ); ?> .sh-iconbox-slider-item p,
				#iconbox-slider-<?php echo esc_attr( $atts['id'] ); ?> .sh-iconbox-slider-item p * {
					color: <?php echo esc_attr( $atts['slide_descr_color'] ); ?>!important;
					opacity: 1;
				}
			<?php endif; ?>

		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:icon_box_slider','jevelin_shortcode_icon_box_slider_css');
endif;
?>
