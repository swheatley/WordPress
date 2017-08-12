<?php if (!defined('FW')) die('Forbidden');

if(!function_exists('jevelin_shortcode_section_css')) :
	function jevelin_shortcode_section_css ($data) {
		$atts = jevelin_shortcode_options($data,'section');
		$background_type = jevelin_get_picker_value( $atts['background'], 'none' );
		$background_type_atts = jevelin_get_picker( $atts['background'] );
		$padding_mobile = ( isset( $atts['padding_mobile']['padding_mobile'] ) ) ? esc_attr($atts['padding_mobile']['padding_mobile']) : '';
		$padding_mobile_atts = jevelin_get_picker( $atts['padding_mobile'] );
		ob_start(); ?>


			.sh-section-<?php echo esc_attr( $atts['id'] ); ?> {
				padding: <?php echo esc_attr($atts['padding']); ?>;

				<?php if( $atts['text_color'] ) : ?>
					color: <?php echo esc_attr($atts['text_color']); ?>;
				<?php endif; ?>

				<?php if( $atts['z_index'] ) : ?>
					z-index: <?php echo esc_attr($atts['z_index']); ?>;
				<?php endif; ?>

				<?php if( $background_type != 'parallax_simple' && $background_type != 'video' && jevelin_get_image($atts['background_image'] ) ) : ?>
					background-image: url(<?php echo esc_url(jevelin_get_image(($atts['background_image']))); ?>);
				<?php endif; ?>

				<?php if( isset($background_type_atts['background_image_options']) && $background_type_atts['background_image_options'] == 'repeat' ) : ?>
					background-repeat: repeat;
					background-size: auto;
				<?php elseif( isset($background_type_atts['background_image_options']) && $background_type_atts['background_image_options'] == 'norepeat' ) : ?>
					background-repeat: no-repeat;
					background-size: auto;
				<?php elseif( isset($background_type_atts['background_image_options']) && $background_type_atts['background_image_options'] == 'norepeat-top' ) : ?>
					background-repeat: no-repeat;
					background-size: auto;
					background-position: 50% 0%;
				<?php elseif( isset($background_type_atts['background_image_options']) && $background_type_atts['background_image_options'] == 'norepeat-bottom' ) : ?>
					background-repeat: no-repeat;
					background-size: auto;
					background-position: 50% 100%;
				<?php endif; ?>

				<?php if( $atts['background_color_overlay'] != true && $atts['background_color'] && $atts['background_color'] != '#ffffff' ) : ?>
					background-color: <?php echo esc_attr($atts['background_color']); ?>;
				<?php endif; ?>

				<?php if( isset( $atts['custom_css'] ) && $atts['custom_css'] ) : ?>
					<?php echo esc_attr($atts['custom_css']); ?>;
				<?php endif; ?>

			}


			<?php if( $padding_mobile_atts['padding'] ) : ?>
			@media (max-width: 800px) {
				.sh-section-<?php echo esc_attr( $atts['id'] ); ?> {
					padding: <?php echo esc_attr( $padding_mobile_atts['padding'] ); ?>;
				}
			}
			<?php endif; ?>


			<?php if( $atts['diognal_sides'] == true && ( $atts['background_color_overlay'] != true && $atts['background_color'] ) ) : ?>
				.sh-section-<?php echo esc_attr( $atts['id'] ); ?> {
				    overflow: visible;
				}

				.sh-section-<?php echo esc_attr( $atts['id'] ); ?>::after {
					bottom: 0;
				    transform-origin: left bottom;
				    transform: skewY(3deg);
					content: '';
				    width: 100%;
				    height: 100%;
				    position: absolute;
				    background: inherit;
				    z-index: 1;
				    transition: ease all .5s;
				}

				.sh-section-<?php echo esc_attr( $atts['id'] ); ?>::before {
				    content: '';
				    width: 100%;
				    height: 100%;
				    position: absolute;
				    background: inherit;
				    z-index: 1;
				    transition: ease all .5s;
				    top: 0;
				    transform-origin: right top;
				    transform: skewY(3deg);
				}
			<?php endif; ?>

			.sh-section-overlay-<?php echo esc_attr( $atts['id'] ); ?>{
				z-index: -1000;
				background: <?php echo esc_attr($atts['background_color']); ?>;
				position: absolute;
				top: 0; bottom: 0; left: 0; right: 0;
			}

			.sh-section-overlay-front {
				z-index: 0;
			}


		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:section','jevelin_shortcode_section_css');
endif;
?>
