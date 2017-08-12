<?php if (!defined('FW')) die('Forbidden');

if(!function_exists('jevelin_shortcode_text_group_css')) :
	function jevelin_shortcode_text_group_css ($data) {
		$atts = jevelin_shortcode_options($data,'text-group'); ob_start(); ?>


			<?php if( $atts['paragraph_whitespace'] == false ) : ?>
				#text-group-<?php echo esc_attr( $atts['id'] ); ?> p {
					margin-bottom: 0;
				}
			<?php endif; ?>


		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:text_group','jevelin_shortcode_text_group_css');
endif;
?>