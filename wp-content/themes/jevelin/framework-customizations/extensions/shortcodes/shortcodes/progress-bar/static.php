<?php if (!defined('FW')) die('Forbidden');
if(!function_exists('jevelin_shortcode_progress_bar_css')) :
	function jevelin_shortcode_progress_bar_css ($data) {
		$atts = jevelin_shortcode_options($data,'progress-bar');
		$accent_color = ( $atts['accent_color'] ) ? $atts['accent_color'] : jevelin_option('accent_color');
		ob_start(); ?>

			
			#progress-<?php echo esc_attr( $atts['id'] ); ?> .sh-progress-status-value {
				background-color: <?php echo esc_attr( $accent_color ); ?>;
			}

			#progress-<?php echo esc_attr( $atts['id'] ); ?> .sh-progress-status-value-edge {
				border-left-color: <?php echo esc_attr( $accent_color ); ?>;
			}

			#progress-<?php echo esc_attr( $atts['id'] ); ?> .sh-progress-status-value:before {
				border-color: <?php echo esc_attr( $accent_color ) ?>;
			}

			<?php if( $atts['background_color'] ) : ?>
				#progress-<?php echo esc_attr( $atts['id'] ); ?>.sh-progress-style1 .sh-progress-status,
				#progress-<?php echo esc_attr( $atts['id'] ); ?>.sh-progress-style2 .sh-progress-content-container,
				#progress-<?php echo esc_attr( $atts['id'] ); ?>.sh-progress-style3 .sh-progress-content-container,
				#progress-<?php echo esc_attr( $atts['id'] ); ?>.sh-progress-style4 .sh-progress-status,
				#progress-<?php echo esc_attr( $atts['id'] ); ?>.sh-progress-style5 .sh-progress-status {
					background-color: <?php echo esc_attr( $atts['background_color'] ); ?>;
				}
			<?php endif; ?>		


		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:progress_bar','jevelin_shortcode_progress_bar_css');
endif;
?>