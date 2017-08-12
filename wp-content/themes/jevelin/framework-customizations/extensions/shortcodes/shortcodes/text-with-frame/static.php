<?php if (!defined('FW')) die('Forbidden');

if(!function_exists('jevelin_shortcode_text_with_frame_css')) :
	function jevelin_shortcode_text_with_frame_css ($data) {
		$atts = jevelin_shortcode_options($data,'text_with_frame'); ob_start(); ?>

			<?php if( $atts['line_color'] ) : ?>
				#text-with-frame-<?php echo esc_attr( $atts['id'] ); ?> .sh-text-with-frame-container {
					border-color: <?php echo esc_attr( $atts['line_color'] ); ?>;
				}
			<?php endif; ?>

			<?php if( $atts['text_font'] == 'additional1' || $atts['text_font'] == 'additional2' || $atts['text_font'] == 'heading' ) : ?>
				#text-with-frame-<?php echo esc_attr( $atts['id'] ); ?> .sh-text-with-frame-container p {

					<?php if( $atts['text_font'] == 'additional1' ) : ?>
						font-family: '<?php echo esc_attr( jevelin_option_value('additional_font1','family') ); ?>'!important;
					<?php elseif( $atts['text_font'] == 'additional2' ) : ?>
						font-family: '<?php echo esc_attr( jevelin_option_value('additional_font2','family') ); ?>'!important;
					<?php elseif( $atts['text_font'] == 'body' ) : ?>
						font-family: '<?php echo esc_attr( jevelin_option_value('styling_body','family') ); ?>'!important;
					<?php endif; ?>
					
				}
			<?php endif; ?>

			<?php if( $atts['heading_font'] == 'additional1' || $atts['heading_font'] == 'additional2' || $atts['heading_font'] == 'body' ) : ?>
				#text-with-frame-<?php echo esc_attr( $atts['id'] ); ?> .sh-text-with-frame-container h1,
				#text-with-frame-<?php echo esc_attr( $atts['id'] ); ?> .sh-text-with-frame-container h2,
				#text-with-frame-<?php echo esc_attr( $atts['id'] ); ?> .sh-text-with-frame-container h3,
				#text-with-frame-<?php echo esc_attr( $atts['id'] ); ?> .sh-text-with-frame-container h4,
				#text-with-frame-<?php echo esc_attr( $atts['id'] ); ?> .sh-text-with-frame-container h5,
				#text-with-frame-<?php echo esc_attr( $atts['id'] ); ?> .sh-text-with-frame-container h6 {

					<?php if( $atts['heading_font'] == 'additional1' ) : ?>
						font-family: '<?php echo esc_attr( jevelin_option_value('additional_font1','family') ); ?>'!important;
					<?php elseif( $atts['heading_font'] == 'additional2' ) : ?>
						font-family: '<?php echo esc_attr( jevelin_option_value('additional_font2','family') ); ?>'!important;
					<?php elseif( $atts['heading_font'] == 'body' ) : ?>
						font-family: '<?php echo esc_attr( jevelin_option_value('styling_body','family') ); ?>'!important;
					<?php endif; ?>
					
				}
			<?php endif; ?>

		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:text_with_frame','jevelin_shortcode_text_with_frame_css');
endif;
?>