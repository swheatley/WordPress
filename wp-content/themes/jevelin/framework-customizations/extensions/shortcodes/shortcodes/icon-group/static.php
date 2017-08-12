<?php if (!defined('FW')) die('Forbidden');

if(!function_exists('jevelin_shortcode_icon_group_css')) :
	function jevelin_shortcode_icon_group_css ($data) {
		$atts = jevelin_shortcode_options($data,'icon-group'); ob_start(); ?>

			<?php if( ( isset( $atts['icon_size'] ) && $atts['icon_size'] ) || ( isset( $atts['icon_color'] ) && $atts['icon_color'] ) ) : ?>
				#icon-group-<?php echo esc_attr( $atts['id'] ); ?> .sh-icon-group-item i {
					<?php if( $atts['icon_color'] ) : ?>
						color: <?php echo esc_attr( $atts['icon_color'] ); ?>;
					<?php endif; ?>
				}
			<?php endif; ?>

		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:icon_group','jevelin_shortcode_icon_group_css');
endif;
?>