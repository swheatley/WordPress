<?php if (!defined('FW')) die('Forbidden');

if(!function_exists('jevelin_shortcode_icon_box_css')) :
	function jevelin_shortcode_icon_box_css ($data) {
		$atts = jevelin_shortcode_options($data,'icon-box');
		$style = ( isset( $atts['style']['style'] ) && $atts['style']['style'] ) ? esc_attr($atts['style']['style']) : 'style1';
		$style_atts = jevelin_get_picker( $atts['style'] );
		ob_start(); ?>


			#iconbox-<?php echo esc_attr( $atts['id'] ); ?> .sh-iconbox-title h3 {
				<?php if( $atts['color_title'] ) : ?>
					color: <?php echo esc_attr( $atts['color_title'] ); ?>;
				<?php endif; ?>
				
				<?php if( $atts['font_size'] ) : ?>
					font-size: <?php echo esc_attr( $atts['font_size'] ); ?>;
				<?php endif; ?>

				<?php if( $atts['weight'] != 'default' ) : ?>
					font-weight: <?php echo esc_attr( $atts['weight'] ); ?>!important;
				<?php endif; ?>

				<?php if( $atts['font'] == 'additional1' ) : ?>
					font-family: '<?php echo jevelin_option_value('additional_font1','family'); ?>'!important;
				<?php elseif( $atts['font'] == 'additional2' ) : ?>
					font-family: '<?php echo jevelin_option_value('additional_font2','family'); ?>'!important;
				<?php elseif( $atts['font'] == 'body' ) : ?>
					font-family: '<?php echo jevelin_option_value('styling_body','family'); ?>'!important;
				<?php endif; ?>
			}

			<?php if( isset($atts['alignment']) && $atts['alignment'] == 'right' && $atts['icon_size'] ) : 
				$alignment_size = preg_replace("/[^0-9]/","", esc_attr( $atts['icon_size'] ) );
				if( $alignment_size > 20 ) : ?>
					#iconbox-<?php echo esc_attr( $atts['id'] ); ?>.sh-iconbox-right .sh-iconbox-aside {
						margin-right: <?php echo intval($alignment_size) * 0.2; ?>px;
					}
				<?php endif; ?>
			<?php endif; ?>

			<?php if( isset($atts['alignment']) && $atts['alignment'] == 'left' && $atts['icon_size'] ) : 
				$alignment_size = preg_replace("/[^0-9]/","",$atts['icon_size']);
				if( $alignment_size > 20 ) : ?>
					#iconbox-<?php echo esc_attr( $atts['id'] ); ?>.sh-iconbox-left .sh-iconbox-aside {
						margin-left: <?php echo intval($alignment_size) * 0.2; ?>px;
					}
				<?php endif; ?>
			<?php endif; ?>

			<?php if( isset($style_atts['color_line']) && $style_atts['color_line'] ) : ?>
				#iconbox-<?php echo esc_attr( $atts['id'] ); ?>.sh-iconbox-style4 .sh-iconbox-seperator {
					background-color: <?php echo esc_attr( $style_atts['color_line'] ); ?>;
				}
				
				#iconbox-<?php echo esc_attr( $atts['id'] ); ?>.sh-iconbox-style5 .sh-iconbox-title,
				#iconbox-<?php echo esc_attr( $atts['id'] ); ?>.sh-iconbox-style1 .sh-iconbox-icon-shape,
				#iconbox-<?php echo esc_attr( $atts['id'] ); ?>.sh-iconbox-style7 .sh-iconbox-icon-shape,
				#iconbox-<?php echo esc_attr( $atts['id'] ); ?>.sh-iconbox-style10 .sh-iconbox-top {
					border-color: <?php echo esc_attr( $style_atts['color_line'] ); ?>;
				}

				#iconbox-<?php echo esc_attr( $atts['id'] ); ?>.sh-iconbox-style1 .sh-iconbox-icon2 i {
					color: <?php echo esc_attr( $style_atts['color_line'] ); ?>;
				}
			<?php endif; ?>

			<?php if( isset($style_atts['background_color']) && $style_atts['background_color'] ) : ?>
				#iconbox-<?php echo esc_attr( $atts['id'] ); ?>.sh-iconbox-style8 .sh-iconbox-icon-shape,
				#iconbox-<?php echo esc_attr( $atts['id'] ); ?>.sh-iconbox-style9 .sh-iconbox-icon-shape {
					background-color: <?php echo esc_attr( $style_atts['background_color'] ); ?>;
				}
			<?php endif; ?>

			<?php if( $atts['icon_size'] ) : ?>
				#iconbox-<?php echo esc_attr( $atts['id'] ); ?> .sh-iconbox-hover {
					font-size: <?php echo esc_attr( $atts['icon_size'] ); ?>;
				}

				<?php if( $atts['alignment'] == 'left' ) : ?>

					<?php if( in_array($style, array( 'style2', 'style3', 'style4', 'style5', 'style6' )) ) : ?>
						#iconbox-<?php echo esc_attr( $atts['id'] ); ?>.sh-iconbox-left .sh-iconbox-aside {
							padding-left: <?php echo esc_attr( $atts['icon_size'] ) + 30; ?>px;
						}
					<?php endif; ?>

				<?php elseif( $atts['alignment'] == 'right' ) : ?>

					<?php if( in_array($style, array( 'style2', 'style3', 'style4', 'style5', 'style6' )) ) : ?>
						#iconbox-<?php echo esc_attr( $atts['id'] ); ?>.sh-iconbox-right .sh-iconbox-aside {
							padding-right: <?php echo esc_attr( $atts['icon_size'] ) + 30; ?>px;
						}
					<?php endif; ?>

				<?php endif; ?>
			<?php endif; ?>

			<?php if( $atts['color_icon'] ) : ?>
				#iconbox-<?php echo esc_attr( $atts['id'] ); ?> .sh-iconbox-hover {
					color: <?php echo esc_attr($atts['color_icon']); ?>;
				}

				#iconbox-<?php echo esc_attr( $atts['id'] ); ?>.sh-iconbox-style6 .sh-iconbox-hover {
					text-shadow: -3px 2px <?php echo jevelin_hex2rgba( esc_attr($atts['color_icon']), 0.3 ); ?>;
				}
			<?php endif; ?>

			<?php if( $atts['color_text'] ) : ?>
				#iconbox-<?php echo esc_attr( $atts['id'] ); ?> .sh-iconbox-content {
					color: <?php echo esc_attr($atts['color_text']); ?>;
				}
			<?php endif; ?>

			<?php if( $atts['color_icon_hover'] ) : ?>
				#iconbox-<?php echo esc_attr( $atts['id'] ); ?>:hover .sh-iconbox-hover {
					color: <?php echo esc_attr($atts['color_icon_hover']); ?>;
				}
			<?php endif; ?>

			<?php if( $atts['color_text_hover'] ) : ?>
				#iconbox-<?php echo esc_attr( $atts['id'] ); ?>:hover .sh-iconbox-title h3 {
					color: <?php echo esc_attr($atts['color_text_hover']); ?>;
				}
			<?php endif; ?>

			<?php if( ( isset($style_atts['background_color']) && $style_atts['background_color'] ) || ( isset($style_atts['image_background']) && jevelin_get_image($style_atts['image_background']) ) ) : ?>
				#iconbox-<?php echo esc_attr( $atts['id'] ); ?>:not(.sh-iconbox-style11),
				#iconbox-<?php echo esc_attr( $atts['id'] ); ?>.sh-iconbox-style11 .sh-iconbox-container {
					<?php if( isset($style_atts['background_color']) && $style_atts['background_color'] ) : ?>
						background-color: <?php echo esc_attr( $style_atts['background_color'] ); ?>;
					<?php endif; ?>

					<?php if( isset($style_atts['image_background']) && jevelin_get_image($style_atts['image_background']) ) : ?>
						background-image: url(<?php echo jevelin_get_image($style_atts['image_background']); ?>);
					<?php endif; ?>
				}
			<?php endif; ?>

			<?php if( !$atts['icon'] ) : ?>
				#iconbox-<?php echo esc_attr( $atts['id'] ); ?> .sh-iconbox-aside {
					padding-left: 0px!important;
					padding-right: 0px!important;
				}
			<?php endif; ?>


		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:icon_box','jevelin_shortcode_icon_box_css');
endif;
?>