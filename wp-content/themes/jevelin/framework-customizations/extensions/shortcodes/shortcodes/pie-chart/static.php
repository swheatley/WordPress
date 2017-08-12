<?php if (!defined('FW')) die('Forbidden');
if(!function_exists('jevelin_shortcode_pie_chart_css')) :
	function jevelin_shortcode_pie_chart_css ($data) {
		$atts = jevelin_shortcode_options($data,'pie_chart');
		$percentage = intval($atts['percentage']);
		if( $percentage > 100 || $percentage < 0 ) :
			$percentage = 100;
		endif;

		$text_color = ( $atts['text_color'] ) ? $atts['text_color'] : '';
		$accent_color = ( $atts['accent_color'] ) ? $atts['accent_color'] : jevelin_option('accent_color');
		$accent_hover_color = ( $atts['accent_hover_color'] ) ? esc_attr( $atts['accent_hover_color'] ) : '';
		$line_color = ( $atts['line_color'] ) ? $atts['line_color'] : '';
		$background_color = ( $atts['background_color'] ) ? $atts['background_color'] : 'none';
		ob_start(); ?>


			#piechart-<?php echo esc_attr($atts['id']); ?>.sh-piechart-circle .circle_animation {
			    animation: piechart_<?php echo esc_attr($atts['id']); ?>_circle 2s cubic-bezier(0.785, 0.135, 0.150, 0.860) forwards;
			}

			#piechart-<?php echo esc_attr($atts['id']); ?>.sh-piechart-circle .sh-piechart-pointer {
			    animation: piechart_<?php echo esc_attr($atts['id']); ?>_circle_pointer 2s cubic-bezier(0.785, 0.135, 0.150, 0.860) forwards;
			}

			#piechart-<?php echo esc_attr($atts['id']); ?>.sh-piechart-rhomb .rhomb_animation {
			    animation: piechart_<?php echo esc_attr($atts['id']); ?>_rhomb  2s cubic-bezier(0.785, 0.135, 0.150, 0.860) forwards;
			}

			#piechart-<?php echo esc_attr($atts['id']); ?> .sh-piechart-pointer {
				background-color: <?php echo esc_attr( $accent_color ); ?>;
			}

			<?php if( $text_color ) : ?>
				#piechart-<?php echo esc_attr($atts['id']); ?> .sh-piechart-percentage {
					color: <?php echo esc_attr( $text_color ); ?>!important;
				}
			<?php endif; ?>

			<?php if( $accent_hover_color ) : ?>
				#piechart-<?php echo esc_attr($atts['id']); ?>:hover .sh-piechart-animation {
					stroke: <?php echo esc_attr( $accent_hover_color ); ?>;
				}

				#piechart-<?php echo esc_attr($atts['id']); ?>:hover .sh-piechart-pointer {
					background-color: <?php echo esc_attr( $accent_hover_color ); ?>;
				}
			<?php endif; ?>

			@keyframes piechart_<?php echo esc_attr($atts['id']); ?>_circle {
				to { stroke-dashoffset: <?php echo ( 100- intval( $percentage ) ) * 6; ?>; }
			}

			@keyframes piechart_<?php echo esc_attr($atts['id']); ?>_circle_pointer {
				from { 	transform: rotate(-90deg) translateX(95px) rotate(0deg); }
				to   {  transform: rotate(<?php echo ( intval( $percentage ) * 3.6 -90); ?>deg) translateX(95px) rotate(-360deg); }
			}

			@keyframes piechart_<?php echo esc_attr($atts['id']); ?>_rhomb {
				to { stroke-dashoffset: <?php echo 800-(800*( ( intval( $percentage ) *0.8/100)/2 )); ?>; }
			}


		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:pie_chart','jevelin_shortcode_pie_chart_css');
endif;
?>