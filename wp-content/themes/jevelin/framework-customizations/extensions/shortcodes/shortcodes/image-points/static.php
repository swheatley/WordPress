<?php if (!defined('FW')) die('Forbidden');
if(!function_exists('jevelin_shortcode_image_points_css')) :
	function jevelin_shortcode_image_points_css ($data) {
		$atts = jevelin_shortcode_options($data,'image_points');
		$accent_color = ( esc_attr($atts['pointer_color']) ) ? esc_attr($atts['pointer_color']) : esc_attr(jevelin_option('accent_color'));
		ob_start(); ?>


			<?php if( $accent_color ) : ?>
				#image-points-<?php echo esc_attr($atts['id']); ?> .sh-image-point{
					background-color: <?php echo esc_attr($accent_color); ?>;
				}
			<?php endif; ?>


		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:image_points','jevelin_shortcode_image_points_css');
endif;
?>