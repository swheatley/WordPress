<?php if (!defined('FW')) die('Forbidden');

if(!function_exists('jevelin_shortcode_heading_simple_css')) :
	function jevelin_shortcode_heading_simple_css ($data) {
		$atts = jevelin_shortcode_options($data,'heading-simple');
		$size = ( isset( $atts['size']['size'] ) ) ? esc_attr($atts['size']['size']) : 'default';
		$size_atts = jevelin_get_picker( $atts['size'] );
		$size_class = ' size-'.$size;
		ob_start(); ?>


			#heading-<?php echo esc_attr( $atts['id'] ); ?>  {
				<?php if( $atts['margin'] ) : ?>
					margin: <?php echo esc_attr( $atts['margin'] ); ?>;
				<?php endif; ?>
			}

			<?php if( $size_atts['responsive_size'] ) : ?>
			@media (max-width: 1024px) {
				#heading-<?php echo esc_attr( $atts['id'] ); ?> .sh-heading-content {
					font-size: <?php echo jevelin_addpx( $size_atts['responsive_size'] ); ?>!important;
				}
			}
			<?php endif; ?>

			#heading-<?php echo esc_attr( $atts['id'] ); ?> .sh-heading-content {
				<?php if( $size_atts['desktop_size'] ) : ?>
					font-size: <?php echo jevelin_addpx( $size_atts['desktop_size'] ); ?>;
				<?php endif; ?>

				<?php if( $atts['line_height'] ) : ?>
					line-height: <?php echo jevelin_addpx( $atts['line_height'] ); ?>!important;
				<?php endif; ?>

				<?php if( $atts['weight'] != '100' ) : ?>
					font-weight: <?php echo esc_attr( $atts['weight'] ); ?>!important;
				<?php endif; ?>

				<?php if( $atts['letter_spacing'] ) : ?>
					letter-spacing: <?php echo jevelin_addpx( $atts['letter_spacing'] ); ?>;
				<?php endif; ?>

				<?php if( $atts['color_text'] ) : ?>
					color: <?php echo esc_attr( $atts['color_text'] ); ?>;
				<?php endif; ?>
			}

			#heading-<?php echo esc_attr( $atts['id'] ); ?> .sh-heading-content,
			#heading-<?php echo esc_attr( $atts['id'] ); ?> .sh-heading-additional-text {

				<?php if( $atts['font'] == 'additional1' ) : ?>
					font-family: '<?php echo jevelin_option_value('additional_font1','family'); ?>'!important;
				<?php elseif( $atts['font'] == 'additional2' ) : ?>
					font-family: '<?php echo jevelin_option_value('additional_font2','family'); ?>'!important;
				<?php elseif( $atts['font'] == 'body' ) : ?>
					font-family: '<?php echo jevelin_option_value('styling_body','family'); ?>'!important;
				<?php endif; ?>

			}

			<?php if( $atts['italic'] == true ) : ?>
				#heading-<?php echo esc_attr( $atts['id'] ); ?> .sh-heading-content {
					font-style: italic!important;
				}
			<?php endif; ?>


		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:heading_simple','jevelin_shortcode_heading_simple_css');
endif;
?>
