<?php if (!defined('FW')) die('Forbidden');

if(!function_exists('jevelin_shortcode_portfolio_fancy_css')) :
	function jevelin_shortcode_portfolio_fancy_css ($data) {
		$atts = jevelin_shortcode_options($data,'empty-space');
        $padding_mobile = ( isset( $atts['padding_mobile']['padding_mobile'] ) ) ? esc_attr($atts['padding_mobile']['padding_mobile']) : '';
		$padding_mobile_atts = jevelin_get_picker( $atts['padding_mobile'] );
		ob_start(); ?>

			<?php if( isset( $atts['overlay_color'] ) && $atts['overlay_color'] && isset( $atts['overlay_second_color'] ) && $atts['overlay_second_color'] ) :
				$first_color = ( strpos($atts['overlay_color'], 'rgba' ) !== false) ? esc_attr( $atts['overlay_color'] ) : jevelin_hex2rgba( $atts['overlay_color'] );
				$second_color = ( strpos($atts['overlay_second_color'], 'rgba') !== false) ?  esc_attr( $atts['overlay_second_color'] ) : jevelin_hex2rgba( $atts['overlay_second_color'] );
			?>
				#portfolio-fancy-<?php echo esc_attr( $atts['id'] ); ?> .sh-portfolio-fancy-item-overlay-bg {
					background: <?php echo esc_attr( $first_color ); ?>;
					background: -moz-linear-gradient(45deg, <?php echo esc_attr( $first_color ); ?> 0%, <?php echo esc_attr( $second_color ); ?> 100%);
					background: -webkit-linear-gradient(45deg, <?php echo esc_attr( $first_color ); ?> 0%, <?php echo esc_attr( $second_color ); ?> 100%);
					background: linear-gradient(45deg, <?php echo esc_attr( $first_color ); ?> 0%, <?php echo esc_attr( $second_color ); ?> 100%);
				}
			<?php elseif( isset( $atts['overlay_color'] ) && $atts['overlay_color'] ) : ?>
				#portfolio-fancy-<?php echo esc_attr( $atts['id'] ); ?> .sh-portfolio-fancy-item-overlay-bg {
					background: <?php echo esc_attr( $atts['overlay_color'] ); ?>;
				}
			<?php endif; ?>

			<?php if( isset( $atts['padding'] ) && $atts['padding'] && $atts['padding'] != '0px 0px 0px 0px' ) : ?>
				#portfolio-fancy-filter-<?php echo esc_attr( $atts['id'] ); ?> {
    				padding: <?php echo esc_attr($atts['padding']); ?>;
				}
			<?php endif; ?>

			<?php if( isset( $padding_mobile ) && $padding_mobile == 'on' && $padding_mobile_atts['padding'] ) : ?>
				@media (max-width: 1024px) {
					#portfolio-fancy-filter-<?php echo esc_attr( $atts['id'] ); ?> {
						padding: <?php echo esc_attr( $padding_mobile_atts['padding'] ); ?>;
					}
				}
			<?php endif; ?>

		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:portfolio_fancy','jevelin_shortcode_portfolio_fancy_css');
endif;
?>
