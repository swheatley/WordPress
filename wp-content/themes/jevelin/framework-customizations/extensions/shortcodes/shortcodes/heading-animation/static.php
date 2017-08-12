<?php if (!defined('FW')) die('Forbidden');
if(!function_exists('jevelin_shortcode_heading_animation_css')) :
	function jevelin_shortcode_heading_animation_css ($data) {
		$atts = jevelin_shortcode_options($data,'heading-animation');
		$size = ( isset( $atts['size']['size'] ) ) ? esc_attr($atts['size']['size']) : 'default';
		$size_atts = jevelin_get_picker( $atts['size'] );
		ob_start(); ?>


			<?php if( isset($atts['margin']) && $atts['margin'] ) : ?>
				#heading-animated-<?php echo esc_attr( $atts['id'] ); ?> {
					margin: <?php echo esc_attr( $atts['margin'] ); ?>;
				}
			<?php endif; ?>
			
			<?php if( $size_atts['responsive_size'] ) : ?>
				@media (max-width: 1024px) {
					#heading-animated-<?php echo esc_attr( $atts['id'] ); ?> .sh-heading-content {
						font-size: <?php echo jevelin_addpx( $size_atts['responsive_size'] ); ?>!important;
					}
				}
			<?php endif; ?>

			#heading-animated-<?php echo esc_attr( $atts['id'] ); ?> .sh-heading-animated-content {
				<?php if( $size_atts['desktop_size'] ) : ?>
					font-size: <?php echo jevelin_addpx( $size_atts['desktop_size'] ); ?>;
				<?php endif; ?>

				<?php if( $atts['line_height'] ) : ?>
					line-height: <?php echo esc_attr( $atts['line_height'] ); ?>;
				<?php endif; ?>

				<?php if( $atts['alignment'] ) : ?>
					text-align: <?php echo esc_attr( $atts['alignment'] ); ?>;
				<?php endif; ?>

				<?php if( $atts['font'] == 'additional1' ) : ?>
					font-family: '<?php echo esc_attr( jevelin_option_value('additional_font1','family') ); ?>'!important;
				<?php elseif( $atts['font'] == 'additional2' ) : ?>
					font-family: '<?php echo esc_attr( jevelin_option_value('additional_font2','family') ); ?>'!important;
				<?php elseif( $atts['font'] == 'body' ) : ?>
					font-family: '<?php echo esc_attr( jevelin_option_value('styling_body','family') ); ?>'!important;
				<?php endif; ?>
			}

			<?php if( isset($atts['color']) && $atts['color'] ) : ?>
				#heading-animated-<?php echo esc_attr( $atts['id'] ); ?> .sh-heading-animated-typed,
				#heading-animated-<?php echo esc_attr( $atts['id'] ); ?>  .typed-cursor {
					color: <?php echo esc_attr( $atts['color'] ); ?>;
				}
			<?php endif; ?>

			<?php if( isset($atts['fixed_color']) && $atts['fixed_color'] ) : ?>
				#heading-animated-<?php echo esc_attr( $atts['id'] ); ?> .sh-heading-animated-fixed {
					color: <?php echo esc_attr( $atts['fixed_color'] ); ?>;
				}
			<?php endif; ?>


		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:heading_animation','jevelin_shortcode_heading_animation_css');
endif;
?>