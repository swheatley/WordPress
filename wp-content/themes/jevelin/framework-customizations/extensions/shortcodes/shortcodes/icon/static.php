<?php if (!defined('FW')) die('Forbidden');

if(!function_exists('jevelin_shortcode_icon_css')) :
	function jevelin_shortcode_icon_css ($data) {
		$atts = jevelin_shortcode_options($data,'icon'); ob_start(); ?>

			<?php if( ( isset( $atts['icon_size'] ) && $atts['icon_size'] ) || ( isset( $atts['icon_color'] ) && $atts['icon_color'] ) ) : ?>
				#icon-<?php echo esc_attr( $atts['id'] ); ?> .sh-icon-data {
					<?php if( $atts['icon_size'] ) : ?>
						font-size: <?php echo jevelin_addpx( $atts['icon_size'] ); ?>;
					<?php endif; ?>

					<?php if( $atts['icon_color'] ) : ?>
						color: <?php echo esc_attr( $atts['icon_color'] ); ?>;
					<?php endif; ?>
				}
			<?php endif; ?>

			<?php if( ( isset( $atts['icon_hover_color'] ) && $atts['icon_hover_color'] ) ) : ?>
				#icon-<?php echo esc_attr( $atts['id'] ); ?>:hover .sh-icon-data {
					color: <?php echo esc_attr( $atts['icon_hover_color'] ); ?>;
				}
			<?php endif; ?>

			<?php if( isset( $atts['shadow'] ) && $atts['shadow'] != 'none' ) : ?>
				#icon-<?php echo esc_attr( $atts['id'] ); ?> .sh-icon-data {
					<?php if( $atts['shadow'] == 'small' ) : ?>
						text-shadow: 0px 2px 10px rgb(25, 25, 25);
					<?php else : ?>
						text-shadow: 0px 5px 35px rgb(15, 15, 15);
					<?php endif; ?>
				}
			<?php endif; ?>

			<?php if( isset( $atts['icon_second_color'] ) && $atts['icon_second_color'] && isset( $atts['icon_color'] ) && $atts['icon_color'] ) : ?>
				#icon-<?php echo esc_attr( $atts['id'] ); ?> .sh-icon-data {
					background: -webkit-linear-gradient(45deg, <?php echo esc_attr( $atts['icon_color'] ); ?>, <?php echo esc_attr( $atts['icon_second_color'] ); ?>);
				    -webkit-background-clip: text;
				    -webkit-text-fill-color: transparent;
				}
			<?php endif; ?>

			<?php if( isset( $atts['icon_hover_second_color'] ) && $atts['icon_hover_second_color'] && isset( $atts['icon_hover_color'] ) && $atts['icon_hover_color'] ) : ?>
				#icon-<?php echo esc_attr( $atts['id'] ); ?> .sh-icon-data:hover {
					background: -webkit-linear-gradient(45deg, <?php echo esc_attr( $atts['icon_hover_color'] ); ?>, <?php echo esc_attr( $atts['icon_hover_second_color'] ); ?>);
				    -webkit-background-clip: text;
				    -webkit-text-fill-color: transparent;
				}
			<?php endif; ?>


		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:icon','jevelin_shortcode_icon_css');
endif;
?>
