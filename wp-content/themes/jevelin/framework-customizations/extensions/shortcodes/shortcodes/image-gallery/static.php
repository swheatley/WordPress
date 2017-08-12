<?php if (!defined('FW')) die('Forbidden');
if(!function_exists('jevelin_shortcode_image_gallery_css')) :
	function jevelin_shortcode_image_gallery_css ($data) {
		$atts = jevelin_shortcode_options($data,'image-gallery'); ob_start(); ?>


			<?php if( $atts['margin'] > 0 ) : ?>
				#image-gallery-<?php echo esc_attr($atts['id']); ?> .sh-gallery-item {
					margin: <?php echo esc_attr($atts['margin']); ?>px;
				}
				#image-gallery-<?php echo esc_attr($atts['id']); ?> {
					margin: -<?php echo esc_attr($atts['margin']); ?>px;
				}
			<?php endif; ?>


		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:image_gallery','jevelin_shortcode_image_gallery_css');
endif;
?>