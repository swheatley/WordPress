<?php if (!defined('FW')) die('Forbidden');

if(!function_exists('jevelin_shortcode_team_css')) :
	function jevelin_shortcode_team_css ($data) {
		$atts = jevelin_shortcode_options($data,'team-member');	ob_start(); ?>


			<?php if( $atts['color_name'] ) : ?>
			#team-<?php echo esc_attr( $atts['id'] ); ?> .sh-team-name h3 {
				color: <?php echo esc_attr( $atts['color_name'] ); ?>
			}
			<?php endif; ?>

			<?php if( $atts['color_role'] ) : ?>
			#team-<?php echo esc_attr( $atts['id'] ); ?> .sh-team-role {
				color: <?php echo esc_attr( $atts['color_role'] ); ?>!important;
			}
			<?php endif; ?>

			<?php if( $atts['color_description'] ) : ?>
			#team-<?php echo esc_attr( $atts['id'] ); ?> .sh-team-description {
				color: <?php echo esc_attr( $atts['color_description'] ); ?>;
			}
			<?php endif; ?>

			#team-<?php echo esc_attr( $atts['id'] ); ?>.sh-team-social-overlay .sh-team-icons {
				background-color: <?php echo ( $atts['color_accent'] ) ? $atts['color_accent'] : jevelin_option('accent_color'); ?>;
			}


		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:team_member','jevelin_shortcode_team_css');
endif;
?>