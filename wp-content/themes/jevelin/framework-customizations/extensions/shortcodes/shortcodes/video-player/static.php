<?php if (!defined('FW')) die('Forbidden');
if(!function_exists('jevelin_shortcode_video_player_css')) :
	function jevelin_shortcode_video_player_css ($data) {
		$atts = jevelin_shortcode_options($data,'video_player'); ob_start(); ?>


			<?php if( $atts['width'] ) : ?>
				#video-player-<?php echo esc_attr($atts['id']); ?> {
					width: <?php echo esc_attr($atts['width']); ?>;
				}
			<?php endif; ?>


		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:video_player','jevelin_shortcode_video_player_css');
endif;
?>