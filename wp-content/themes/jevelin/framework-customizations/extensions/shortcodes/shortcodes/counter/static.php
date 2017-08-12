<?php if (!defined('FW')) die('Forbidden');
if(!function_exists('jevelin_shortcode_counter_css')) :
	function jevelin_shortcode_counter_css ($data) {
		$atts = jevelin_shortcode_options($data,'counter');
		$style = ( isset( $atts['style']['style'] ) ) ? esc_attr($atts['style']['style']) : 'style1';
		$style_atts = jevelin_get_picker( $atts['style'] );
		$size = ( isset( $atts['number_size']['number_size'] ) ) ? esc_attr($atts['number_size']['number_size']) : 'default';
		$size_atts = jevelin_get_picker( $atts['number_size'] );
		ob_start(); ?>

			<?php if( $size_atts['responsive_size'] ) : ?>
			@media (max-width: 1024px) {
				#counter-<?php echo esc_attr($atts['id']); ?> .sh-counter-number {
					font-size: <?php echo jevelin_addpx( $size_atts['responsive_size'] ); ?>!important;
				}
			}
			<?php endif; ?>

			<?php if( isset($atts['icon_color']) && $atts['icon_color'] ) : ?>
			#counter-<?php echo esc_attr($atts['id']); ?> .sh-counter-icon {
				color: <?php echo esc_attr( $atts['icon_color'] ); ?>;
			}
			<?php endif; ?>

			<?php if( isset( $atts['number_weight'] ) && $atts['number_weight'] != '700' ) : ?>
			#counter-<?php echo esc_attr($atts['id']); ?> .sh-counter-number {
				font-weight: <?php echo esc_attr( $atts['number_weight'] ); ?>!important;
			}
			<?php endif; ?>

			<?php if( $size_atts['desktop_size'] ) : ?>
			#counter-<?php echo esc_attr($atts['id']); ?> .sh-counter-number {
				font-size: <?php echo jevelin_addpx( $size_atts['desktop_size'] ); ?>;
			}
			<?php endif; ?>

			<?php if( isset($atts['number_color']) && $atts['number_color'] ) : ?>
			#counter-<?php echo esc_attr($atts['id']); ?> .sh-counter-number {
				color: <?php echo esc_attr( $atts['number_color'] ); ?>;
			}
			<?php endif; ?>

			<?php if( isset($atts['title_color']) && $atts['title_color'] ) : ?>
			#counter-<?php echo esc_attr($atts['id']); ?> .sh-counter-title {
				color: <?php echo esc_attr( $atts['title_color'] ); ?>;
			}
			<?php endif; ?>

			<?php if( isset($atts['subtitle_color']) && $atts['subtitle_color'] ) : ?>
			#counter-<?php echo esc_attr($atts['id']); ?> .sh-counter-subtitle {
				color: <?php echo esc_attr( $atts['subtitle_color'] ); ?>;
			}
			<?php endif; ?>

			<?php if( $style == 'style2' && isset($style_atts['divider_color']) && $style_atts['divider_color'] ) : ?>
			#counter-<?php echo esc_attr($atts['id']); ?>.sh-counter-style2 .sh-counter-divider {
				border-color: <?php echo esc_attr( $style_atts['divider_color'] ); ?>;
			}
			<?php endif; ?>

			<?php if( $style == 'style3' && isset($style_atts['divider_color']) && $style_atts['divider_color'] ) : ?>
			#counter-<?php echo esc_attr($atts['id']); ?>.sh-counter-style3 .text-left {
				border-color: <?php echo esc_attr( $style_atts['divider_color'] ); ?>;
			}
			<?php endif; ?>

			<?php if( $style == 'style5' && isset($style_atts['icon_border_color']) && $style_atts['icon_border_color'] ) : ?>
			#counter-<?php echo esc_attr($atts['id']); ?>.sh-counter-style5 .sh-counter-icon {
				border-color: <?php echo esc_attr( $style_atts['icon_border_color'] ); ?>;
			}
			<?php endif; ?>

			<?php if( $style == 'style5' && isset($style_atts['icon_background_color']) && $style_atts['icon_background_color'] ) : ?>
			#counter-<?php echo esc_attr($atts['id']); ?>.sh-counter-style5 .sh-counter-icon {
				background-color: <?php echo esc_attr( $style_atts['icon_background_color'] ); ?>;
			}
			<?php endif; ?>

			<?php if( $style == 'style6' && isset($style_atts['divider_color']) && $style_atts['divider_color'] ) : ?>
			#counter-<?php echo esc_attr($atts['id']); ?>.sh-counter-style6 .sh-counter-divider {
				border-color: <?php echo esc_attr( $style_atts['divider_color'] ); ?>;
			}
			<?php endif; ?>

			<?php if( $style == 'style6' && isset($style_atts['divider_style']) && $style_atts['divider_style'] ) : ?>
			#counter-<?php echo esc_attr($atts['id']); ?>.sh-counter-style6 .sh-counter-divider {
				border-style: <?php echo esc_attr( $style_atts['divider_style'] ); ?>;
			}
			<?php endif; ?>

			#counter-<?php echo esc_attr($atts['id']); ?> .sh-counter-number {
				<?php if( $atts['font'] == 'additional1' ) : ?>
					font-family: '<?php echo jevelin_option_value('additional_font1','family'); ?>'!important;
				<?php elseif( $atts['font'] == 'additional2' ) : ?>
					font-family: '<?php echo jevelin_option_value('additional_font2','family'); ?>'!important;
				<?php elseif( $atts['font'] == 'body' ) : ?>
					font-family: '<?php echo jevelin_option_value('styling_body','family'); ?>'!important;
				<?php endif; ?>
			}


		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:counter','jevelin_shortcode_counter_css');
endif;
?>
