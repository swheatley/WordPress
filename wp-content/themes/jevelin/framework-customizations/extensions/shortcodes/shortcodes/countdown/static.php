<?php if (!defined('FW')) die('Forbidden');

wp_enqueue_script(
	'jevelin-countdown',
	fw_get_template_customizations_directory_uri('/extensions/shortcodes/shortcodes/countdown/static/jquery.countdown.min.js'),
	array('jquery'),
	fw()->manifest->get_version(),
	true
);

if(!function_exists('jevelin_shortcode_countdown_css')) :
	function jevelin_shortcode_countdown_css ($data) {
		$atts = jevelin_shortcode_options($data,'countdown'); ob_start(); ?>

			<?php if( isset($atts['title_size']) && $atts['title_size'] ) : ?>
			#countdown-<?php echo esc_attr($atts['id']); ?> > div > div {
				font-size: <?php echo esc_attr( $atts['title_size'] ); ?>;
			}
			<?php endif; ?>

			<?php if( isset($atts['number_color']) && $atts['number_color'] ) : ?>
			#countdown-<?php echo esc_attr($atts['id']); ?> > div > span {
				color: <?php echo esc_attr( $atts['number_color'] ); ?>!important;
			}
			<?php endif; ?>

			<?php if( isset($atts['title_color']) && $atts['title_color'] ) : ?>
			#countdown-<?php echo esc_attr($atts['id']); ?> > div > div {
				color: <?php echo esc_attr( $atts['title_color'] ); ?>!important;
			}
			<?php endif; ?>

			<?php if( isset($atts['border_color']) && $atts['border_color'] ) : ?>
				#countdown-<?php echo esc_attr($atts['id']); ?>.sh-countdown-style1 > div,
				#countdown-<?php echo esc_attr($atts['id']); ?>.sh-countdown-style2 > div > div,
				#countdown-<?php echo esc_attr($atts['id']); ?>.sh-countdown-style3 > .weeks {
					border-color: <?php echo esc_attr( $atts['border_color'] ); ?>!important;
				}
			<?php endif; ?>

			<?php if( isset($atts['bold']) && $atts['bold'] == 'bold' ) : ?>
				#countdown-<?php echo esc_attr($atts['id']); ?> > div > span {
					font-weight: bold;
				}
			<?php endif; ?>


		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:countdown','jevelin_shortcode_countdown_css');
endif;
?>
