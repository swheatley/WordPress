<?php if (!defined('FW')) die('Forbidden');
if(!function_exists('jevelin_shortcode_single_image_css')) :
	function jevelin_shortcode_single_image_css ($data) {
		$atts = jevelin_shortcode_options($data,'single-image'); ob_start(); ?>


			#single-image-<?php echo esc_attr($atts['id']); ?> {
				<?php if( isset($atts['alignment']) && $atts['alignment'] == 'center' ) : ?>
					text-align: center;
				<?php elseif( isset($atts['alignment']) && $atts['alignment'] == 'right' ) : ?>
					text-align: right;
				<?php else : ?>
					text-align: left;
				<?php endif; ?>
			}

			<?php if( isset($atts['radius']) && $atts['radius'] ) : ?>
				#single-image-<?php echo esc_attr($atts['id']); ?> .sh-single-image-container {
					border-radius: <?php echo esc_attr($atts['radius']); ?>px;
				}
			<?php endif; ?>

		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:single_image','jevelin_shortcode_single_image_css');
endif;
?>
