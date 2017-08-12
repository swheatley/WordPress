<?php if (!defined('FW')) die('Forbidden');
if(!function_exists('jevelin_shortcode_event_css')) :
	function jevelin_shortcode_event_css ($data) {
		$atts = jevelin_shortcode_options($data,'event'); ob_start(); ?>

			<?php if( $atts['title_color'] ) : ?>
				#event-<?php echo esc_attr( $atts['id'] ); ?> .sh-event-title {
					color: <?php echo esc_attr( $atts['title_color'] ); ?>;
				}
			<?php endif; ?>

			<?php if( $atts['desc_color'] ) : ?>
				#event-<?php echo esc_attr( $atts['id'] ); ?> .sh-event-desc {
					color: <?php echo esc_attr( $atts['desc_color'] ); ?>;
				}
			<?php endif; ?>

			<?php if( $atts['line_color'] ) : ?>
				#event-<?php echo esc_attr( $atts['id'] ); ?>.sh-event {
					border-color: <?php echo esc_attr( $atts['line_color'] ); ?>;
				}
			<?php endif; ?>

			#event-<?php echo esc_attr( $atts['id'] ); ?> .sh-event-title {
				border-color: <?php echo esc_attr( jevelin_option('accent_color') ); ?>;
			}

			#event-<?php echo esc_attr( $atts['id'] ); ?> .sh-event-button:hover {
				border-color: <?php echo esc_attr( jevelin_option('accent_color') ); ?>;
				background-color: <?php echo esc_attr( jevelin_option('accent_color') ); ?>;
			}

		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:event','jevelin_shortcode_event_css');
endif;
?>