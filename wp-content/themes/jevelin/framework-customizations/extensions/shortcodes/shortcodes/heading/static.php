<?php if (!defined('FW')) die('Forbidden');

if(!function_exists('jevelin_shortcode_heading_css')) :
	function jevelin_shortcode_heading_css ($data) {
		$atts = jevelin_shortcode_options($data,'heading');
		$style = ( isset( $atts['style']['style'] ) ) ? esc_attr($atts['style']['style']) : 'style1';
		$style_atts = jevelin_get_picker( $atts['style'] );

		$size = ( isset( $atts['size']['size'] ) ) ? esc_attr($atts['size']['size']) : 'default';
		$size_atts = jevelin_get_picker( $atts['size'] );
		ob_start(); ?>

			<?php if( $atts['margin'] ) : ?>
				#heading-<?php echo esc_attr( $atts['id'] ); ?>  {
					margin: <?php echo esc_attr( $atts['margin'] ); ?>;
				}
			<?php endif; ?>

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

				<?php if( $atts['letter_spacing'] ) : ?>
					letter-spacing: <?php echo jevelin_addpx( $atts['letter_spacing'] ); ?>;
				<?php endif; ?>

				<?php if( $atts['weight'] != '100' ) : ?>
					font-weight: <?php echo esc_attr( $atts['weight'] ); ?>!important;
				<?php endif; ?>

				<?php if( $atts['text_color'] ) : ?>
					color: <?php echo esc_attr( $atts['text_color'] ); ?>;
				<?php endif; ?>

				<?php if( isset( $style_atts['background_color'] ) && $style_atts['background_color'] ) : ?>
					background-color: <?php echo esc_attr( $style_atts['background_color'] ); ?>;
				<?php endif; ?>

				<?php if( isset( $style_atts['background_image'] ) && $style_atts['background_image'] ) : ?>
					background-image: url(<?php echo jevelin_get_image($style_atts['background_image']); ?>);
				<?php endif; ?>
			}

			<?php if( $atts['hover_color'] ) : ?>
				<?php if( $atts['hover_element'] == 'section') : ?>
					.sh-section:hover #heading-<?php echo esc_attr( $atts['id'] ); ?> .sh-heading-content {
				<?php elseif( $atts['hover_element'] == 'column') : ?>
					.sh-column:hover #heading-<?php echo esc_attr( $atts['id'] ); ?> .sh-heading-content {
				<?php else : ?>
					#heading-<?php echo esc_attr( $atts['id'] ); ?>:hover .sh-heading-content {
				<?php endif; ?>
					color: <?php echo esc_attr( $atts['hover_color'] ); ?>;
				}
			<?php endif; ?>


			<?php if( $atts['font'] == 'additional1' || $atts['font'] == 'additional2' || $atts['font'] == 'body' ) : ?>
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
			<?php endif; ?>

			<?php if( $atts['font_bold'] == 'additional1' || $atts['font_bold'] == 'additional2' || $atts['font_bold'] == 'body' ) : ?>
				#heading-<?php echo esc_attr( $atts['id'] ); ?> .sh-heading-content strong,
				#heading-<?php echo esc_attr( $atts['id'] ); ?> .sh-heading-additional-text strong {

					<?php if( $atts['font_bold'] == 'additional1' ) : ?>
						font-family: '<?php echo jevelin_option_value('additional_font1','family'); ?>'!important;
					<?php elseif( $atts['font_bold'] == 'additional2' ) : ?>
						font-family: '<?php echo jevelin_option_value('additional_font2','family'); ?>'!important;
					<?php elseif( $atts['font_bold'] == 'body' ) : ?>
						font-family: '<?php echo jevelin_option_value('styling_body','family'); ?>'!important;
					<?php endif; ?>
					
				}
			<?php endif; ?>


		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:heading','jevelin_shortcode_heading_css');
endif;
?>