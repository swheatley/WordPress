<?php if (!defined('FW')) die('Forbidden');
if(!function_exists('jevelin_shortcode_divider_css')) :
	function jevelin_shortcode_divider_css ($data) {
		$atts = jevelin_shortcode_options($data,'divider');
		$content = jevelin_get_picker_value( $atts['content'], 'none' );
		$content_atts = jevelin_get_picker( $atts['content'] );
		$width_atts = jevelin_get_picker( $atts['width'] );
		ob_start(); ?>


			#divider-<?php echo esc_attr($atts['id']); ?> {
				<?php if( $atts['margin'] ) : ?>
					margin: <?php echo esc_attr( $atts['margin'] ); ?>!important;
				<?php endif; ?>
			}

			<?php if( $content == 'none' ) : ?>
				#divider-<?php echo esc_attr($atts['id']); ?>.sh-divider-content-none .sh-divider-line {

					<?php if( isset($atts['radius']) && $atts['radius'] ) : ?>
						border-radius: <?php echo esc_attr($atts['radius']); ?>px;
					<?php endif; ?>

					<?php if( isset($atts['height']) && $atts['height'] ) : ?>
						border-top-width: <?php echo esc_attr( $atts['height'] ); ?>px;
					<?php endif; ?>

					<?php if( isset($atts['line_color']) && $atts['line_color'] ) : ?>
						border-top-color: <?php echo esc_attr( $atts['line_color'] ); ?>;
					<?php endif; ?>

					<?php if( isset($atts['type']) && $atts['type'] ) : ?>
						border-top-style: <?php echo esc_attr( $atts['type'] ); ?>;
					<?php endif; ?>

					<?php if( isset($width_atts['fixed_width']) && $width_atts['fixed_width'] ) : ?>
						max-width: <?php echo esc_attr( $width_atts['fixed_width'] ); ?>px;
					<?php endif; ?>
				}
			<?php else : ?>
				<?php if( isset($width_atts['fixed_width']) && $width_atts['fixed_width'] ) : ?>
					#divider-<?php echo esc_attr($atts['id']); ?> .sh-divider-content {
						<?php if( isset($width_atts['fixed_width']) && $width_atts['fixed_width'] ) : ?>
							max-width: <?php echo esc_attr( $width_atts['fixed_width'] ); ?>px;
						<?php endif; ?>
					}
				<?php endif; ?>

				#divider-<?php echo esc_attr($atts['id']); ?> .sh-divider-content:before,
				#divider-<?php echo esc_attr($atts['id']); ?> .sh-divider-content:after {
					<?php if( isset($atts['height']) && $atts['height'] ) : ?>
						border-top-width: <?php echo esc_attr( $atts['height'] ); ?>px;
						margin-top: -<?php
							if( $atts['height'] <= 5 ) :
								echo esc_attr( $atts['height'] );
							else :
								echo ( esc_attr( $atts['height'] ) / 2) + ( esc_attr( $atts['height'] ) * 0.5 );
							endif;
						?>px;
					<?php endif; ?>

					<?php if( isset($atts['line_color']) && $atts['line_color'] ) : ?>
						border-top-color: <?php echo esc_attr( $atts['line_color'] ); ?>;
					<?php endif; ?>

					<?php if( isset($atts['type']) && $atts['type'] ) : ?>
						border-top-style: <?php echo esc_attr( $atts['type'] ); ?>;
					<?php endif; ?>
				}
			<?php endif; ?>

			<?php if( $content == 'title_option' ) : ?>
				#divider-<?php echo esc_attr($atts['id']); ?> .sh-divider-title {
					<?php if( isset($content_atts['title_color']) && $content_atts['title_color'] ) : ?>
						color: <?php echo esc_attr($content_atts['title_color']); ?>;
					<?php endif; ?>
				}
			<?php elseif( $content == 'title_box_option' ) : ?>
				#divider-<?php echo esc_attr($atts['id']); ?> .sh-divider-title-box {
					<?php if( isset($content_atts['title_color']) && $content_atts['title_color'] ) : ?>
						color: <?php echo esc_attr($content_atts['title_color']); ?>;
					<?php endif; ?>

					<?php if( isset($content_atts['title_background_color']) && $content_atts['title_background_color'] ) : ?>
						background-color: <?php echo esc_attr($content_atts['title_background_color']); ?>;
					<?php endif; ?>

					<?php if( isset($content_atts['title_radius']) && $content_atts['title_radius'] ) : ?>
						border-radius: <?php echo esc_attr($content_atts['title_radius']); ?>px;
					<?php endif; ?>
				}
			<?php elseif( $content == 'icon_option' ) : ?>
				#divider-<?php echo esc_attr($atts['id']); ?> .sh-divider-icon {
					<?php if( isset($content_atts['icon_color']) && $content_atts['icon_color'] ) : ?>
						color: <?php echo esc_attr($content_atts['icon_color']); ?>;
					<?php endif; ?>

					<?php if( isset( $content_atts['icon_size'] ) && $content_atts['icon_size'] ) : ?>
						font-size: <?php echo jevelin_addpx( $content_atts['icon_size'] ); ?>;
					<?php endif; ?>
				}
			<?php endif; ?>

			<?php if( isset($content_atts['font']) && ( $content_atts['font'] == 'additional1' || $content_atts['font'] == 'additional2' || $content_atts['font'] == 'body' ) ) : ?>
				#divider-<?php echo esc_attr($atts['id']); ?> .sh-divider-title,
				#divider-<?php echo esc_attr($atts['id']); ?> .sh-divider-title-box {

					<?php if( $content_atts['font'] == 'additional1' ) : ?>
						font-family: '<?php echo jevelin_option_value('additional_font1','family'); ?>'!important;
					<?php elseif( $content_atts['font'] == 'additional2' ) : ?>
						font-family: '<?php echo jevelin_option_value('additional_font2','family'); ?>'!important;
					<?php elseif( $content_atts['font'] == 'body' ) : ?>
						font-family: '<?php echo jevelin_option_value('styling_body','family'); ?>'!important;
					<?php endif; ?>

				}
			<?php endif; ?>

		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:divider','jevelin_shortcode_divider_css');
endif;
?>
