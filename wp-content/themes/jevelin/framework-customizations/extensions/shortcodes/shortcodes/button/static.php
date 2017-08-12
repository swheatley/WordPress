<?php if (!defined('FW')) die('Forbidden');

if(!function_exists('jevelin_shortcode_button_css')) :
	function jevelin_shortcode_button_css ($data) {
		$atts = jevelin_shortcode_options($data,'button'); ob_start(); ?>


			#button-<?php echo esc_attr($atts['id']); ?> .sh-button {

				<?php if( isset($atts['radius']) && $atts['radius'] ) : ?>
					border-radius: <?php echo esc_attr($atts['radius']); ?>px;
				<?php endif; ?>

				<?php if( isset($atts['background_color']) && $atts['background_color'] ) : ?>
					background-color: <?php echo esc_attr( $atts['background_color'] ); ?>;
				<?php endif; ?>

				<?php if( isset($atts['text_color']) && $atts['text_color'] ) : ?>
					color: <?php echo esc_attr( $atts['text_color'] ); ?>;
				<?php endif; ?>

				<?php if( isset($atts['border_hover_color']) && $atts['border_hover_color'] ) : ?>
					border: 2px solid transparent;
				<?php endif; ?>

				<?php if( isset($atts['border_color']) && $atts['border_color'] ) : ?>
					border: <?php echo esc_attr( $atts['border_size'] ); ?>px solid <?php echo esc_attr( $atts['border_color'] ); ?>;
				<?php endif; ?>

				<?php if( jevelin_get_image($atts['image']) ) : ?>
					background-image: url(<?php echo jevelin_get_image($atts['image']); ?>);
				<?php endif; ?>

				<?php if( isset($atts['shadow']) && $atts['shadow'] == 'simple' ) : ?>
					box-shadow: 0px 3px 0px rgba(0,0,0,0.15);
				<?php elseif( isset($atts['shadow']) && $atts['shadow'] == 'far' ) : ?>
					box-shadow: 0px 3px 10px rgba(0,0,0,0.25);
				<?php elseif( isset($atts['shadow']) && $atts['shadow'] == 'near' ) : ?>
					box-shadow: 0px 2px 2px rgba(0,0,0,0.15);
				<?php endif; ?>

				<?php if( isset($atts['full']) && $atts['full'] == true ) : ?>
					display: block!important;
					width: 100%;
				<?php endif; ?>
			}

			#button-<?php echo esc_attr( $atts['id'] ); ?>  {
				<?php if( $atts['margin'] ) : ?>
					margin: <?php echo esc_attr( $atts['margin'] ); ?>;
				<?php endif; ?>

				<?php if( isset($atts['alignment']) && $atts['alignment'] == 'center' ) : ?>
					text-align: center;
				<?php elseif( isset($atts['alignment']) && $atts['alignment'] == 'right' ) : ?>
					text-align: right;
				<?php endif; ?>
			}

			#button-<?php echo esc_attr($atts['id']); ?>:not(.sh-button-style-2) .sh-button:hover {
				<?php if( isset($atts['background_hover_color']) && $atts['background_hover_color'] ) : ?>
					background-color: <?php echo esc_attr( $atts['background_hover_color'] ); ?>;
				<?php endif; ?>

				<?php if( isset($atts['text_hover_color']) && $atts['text_hover_color'] ) : ?>
					color: <?php echo esc_attr( $atts['text_hover_color'] ); ?>;
				<?php endif; ?>

				<?php if( isset($atts['border_hover_color']) && $atts['border_hover_color'] ) : ?>
					border: <?php echo esc_attr( $atts['border_size'] ); ?>px solid <?php echo esc_attr( $atts['border_hover_color'] ); ?>;
				<?php endif; ?>
			}

			#button-<?php echo esc_attr($atts['id']); ?>.sh-button-style-2 .sh-button:after {
				<?php if( isset($atts['background_hover_color']) && $atts['background_hover_color'] ) : ?>
					background-color: <?php echo esc_attr( $atts['background_hover_color'] ); ?>;
				<?php endif; ?>
			}

			#button-<?php echo esc_attr($atts['id']); ?>.sh-button-style-2 .sh-button:hover {
				<?php if( isset($atts['text_hover_color']) && $atts['text_hover_color'] ) : ?>
					color: <?php echo esc_attr( $atts['text_hover_color'] ); ?>;
				<?php endif; ?>

				<?php if( isset($atts['border_hover_color']) && $atts['border_hover_color'] ) : ?>
					border: <?php echo esc_attr( $atts['border_size'] ); ?>px solid <?php echo esc_attr( $atts['border_hover_color'] ); ?>;
				<?php endif; ?>
			}		

			<?php if( $atts['tale'] != 'none' ) : ?>
				#button-<?php echo esc_attr($atts['id']); ?>  .sh-button-tale {
					<?php if( isset($atts['background_color']) && $atts['background_color'] ) : ?>
						border-top-color: <?php echo esc_attr( $atts['background_color'] ); ?>;
					<?php endif; ?>
				}

				#button-<?php echo esc_attr($atts['id']); ?>:hover  .sh-button-tale {
					<?php if( isset($atts['background_hover_color']) && $atts['background_hover_color'] ) : ?>
						border-top-color: <?php echo esc_attr( $atts['background_hover_color'] ); ?>;
					<?php endif; ?>
				}
			<?php endif; ?>


			<?php if( isset($atts['border_color']) && $atts['border_color'] && $atts['style'] == 3 ) : ?>
				#button-<?php echo esc_attr($atts['id']); ?> .sh-button-icon-right:after,
				#button-<?php echo esc_attr($atts['id']); ?> .sh-button-icon-left:after {
					border-color: <?php echo esc_attr( $atts['border_color'] ); ?>!important;
				}
			<?php endif; ?>


			<?php if( $atts['alignment_mobile'] == 'center' ) : ?>
				@media (max-width: 800px) {
					#button-<?php echo esc_attr($atts['id']); ?> {
						text-align: center;
					}
				}
			<?php endif; ?>


		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:button','jevelin_shortcode_button_css');
endif;
?>