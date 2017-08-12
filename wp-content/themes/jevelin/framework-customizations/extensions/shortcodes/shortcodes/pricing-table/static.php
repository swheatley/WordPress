<?php if (!defined('FW')) die('Forbidden');

if(!function_exists('jevelin_shortcode_pricing_table_css2')) :
	function jevelin_shortcode_pricing_table_css2 ($data) {
		$atts = jevelin_shortcode_options($data,'pricing-table');
		$accent_color = ( $atts['accent_color'] ) ? $atts['accent_color'] : jevelin_option('accent_color');
		ob_start(); ?>


			<?php if( jevelin_get_image($atts['image']) ) : ?>
				#pricing-<?php echo esc_attr( $atts['id'] ); ?>.sh-pricing-style1 .sh-pricing-top,
				#pricing-<?php echo esc_attr( $atts['id'] ); ?>.sh-pricing-style2 .sh-pricing-top,
				#pricing-<?php echo esc_attr( $atts['id'] ); ?>.sh-pricing-style3,
				#pricing-<?php echo esc_attr( $atts['id'] ); ?>.sh-pricing-style4 {
					background-image: url(<?php echo jevelin_get_image($atts['image']); ?>);
					background-position: 50% 50%;
					background-size: cover;
				}
			<?php endif; ?>

			<?php if( in_array( $atts['font'], array( 'additional1', 'additional2', 'body' ) ) ) : ?>
				#pricing-<?php echo esc_attr( $atts['id'] ); ?> .sh-pricing-name h2 {
					<?php if( $atts['font'] == 'additional1' ) : ?>
						font-family: '<?php echo jevelin_option_value('additional_font1','family'); ?>'!important;
					<?php elseif( $atts['font'] == 'additional2' ) : ?>
						font-family: '<?php echo jevelin_option_value('additional_font2','family'); ?>'!important;
					<?php elseif( $atts['font'] == 'body' ) : ?>
						font-family: '<?php echo jevelin_option_value('styling_body','family'); ?>'!important;
					<?php endif; ?>
				}
			<?php endif; ?>

			<?php if( $atts['text_color'] ) : ?>
				#pricing-<?php echo esc_attr( $atts['id'] ); ?> .sh-pricing-icon,
				#pricing-<?php echo esc_attr( $atts['id'] ); ?> .sh-pricing-content-item,
				#pricing-<?php echo esc_attr( $atts['id'] ); ?> .sh-pricing-amount,
				#pricing-<?php echo esc_attr( $atts['id'] ); ?>.sh-pricing-style4 .sh-pricing-top,
				#pricing-<?php echo esc_attr( $atts['id'] ); ?>.sh-pricing-style3 .sh-pricing-top-aside {
					color: <?php echo esc_attr( $atts['text_color'] ); ?>!important;
				}
			<?php endif; ?>

			<?php if( $atts['background_text_color'] ) : ?>
				#pricing-<?php echo esc_attr( $atts['id'] ); ?>.sh-pricing-style1 .sh-pricing-top,
				#pricing-<?php echo esc_attr( $atts['id'] ); ?>.sh-pricing-style2 .sh-pricing-top,
				#pricing-<?php echo esc_attr( $atts['id'] ); ?>.sh-pricing-style4 .sh-pricing-top,
				#pricing-<?php echo esc_attr( $atts['id'] ); ?>.sh-pricing-style1 .sh-pricing-name h2,
				#pricing-<?php echo esc_attr( $atts['id'] ); ?>.sh-pricing-style2 .sh-pricing-name h2,
				#pricing-<?php echo esc_attr( $atts['id'] ); ?>.sh-pricing-style3 .sh-pricing-name h2,
				#pricing-<?php echo esc_attr( $atts['id'] ); ?>.sh-pricing-style4 .sh-pricing-name h2 {
					color: <?php echo esc_attr( $atts['background_text_color'] ); ?>!important;
				}
			<?php endif; ?>

			<?php if( $atts['background_color'] ) : ?>
				#pricing-<?php echo esc_attr( $atts['id'] ); ?> .sh-pricing-icon,
				#pricing-<?php echo esc_attr( $atts['id'] ); ?> {
					background-color: <?php echo esc_attr( $atts['background_color'] ); ?>;
				}
			<?php endif; ?>

			<?php if( $atts['border_color'] ) : ?>
				#pricing-<?php echo esc_attr( $atts['id'] ); ?>,
				#pricing-<?php echo esc_attr( $atts['id'] ); ?> .sh-pricing-content-item,
				#pricing-<?php echo esc_attr( $atts['id'] ); ?> .sh-pricing-style3 .sh-pricing-content-item:first-child,
				#pricing-<?php echo esc_attr( $atts['id'] ); ?> .sh-pricing-style4 .sh-pricing-content-item:first-child {
					border-color: <?php echo esc_attr( $atts['border_color'] ); ?>!important;
				}
			<?php endif; ?>

			<?php if( $atts['border_line'] == false ) : ?>
				#pricing-<?php echo esc_attr( $atts['id'] ); ?> {
					border-width: 0!important;
				}
			<?php endif; ?>

			<?php if( $accent_color ) : ?>
				#pricing-<?php echo esc_attr( $atts['id'] ); ?>.sh-pricing-style1 .sh-pricing-top,
				#pricing-<?php echo esc_attr( $atts['id'] ); ?>.sh-pricing-style2 .sh-pricing-top,
				#pricing-<?php echo esc_attr( $atts['id'] ); ?>.sh-pricing-style3 .sh-pricing-name,
				#pricing-<?php echo esc_attr( $atts['id'] ); ?> .sh-pricing-button1 {
					background-color: <?php echo esc_attr( $accent_color ); ?>;
				}

				#pricing-<?php echo esc_attr( $atts['id'] ); ?>.sh-pricing-20 .sh-pricing-name:after {
					border-top-color: <?php echo esc_attr( $accent_color ); ?>;
				}

				#pricing-<?php echo esc_attr( $atts['id'] ); ?> .sh-pricing-button2 {
					color: <?php echo esc_attr( $accent_color ); ?>;
				}
			<?php endif; ?>


		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:pricing_table','jevelin_shortcode_pricing_table_css2');
endif;
?>