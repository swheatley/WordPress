<?php if (!defined('FW')) die('Forbidden');
if(!function_exists('jevelin_shortcode_tabs_css')) :
	function jevelin_shortcode_tabs_css ($data) {
		$atts = jevelin_shortcode_options($data,'tabs'); ob_start(); ?>


			<?php if( $atts['text_color'] ) : ?>
				#tabs-<?php echo esc_attr( $atts['id'] ); ?> .sh-tabs-filter li:not(.active) a,
				#tabs-<?php echo esc_attr( $atts['id'] ); ?> .tab-pane {
					color: <?php echo esc_attr( $atts['text_color'] ); ?>!important;
				}
			<?php endif; ?>

			<?php 
			$accent_color = ( esc_attr($atts['accent_color']) ) ? $atts['accent_color'] : jevelin_option('accent_color');
			if( $accent_color ) : ?>

				#tabs-<?php echo esc_attr( $atts['id'] ); ?> .sh-tabs-filter li.active a,
				#tabs-<?php echo esc_attr( $atts['id'] ); ?> .sh-tabs-filter li:hover a {
					color: <?php echo esc_attr( $accent_color ); ?>!important;
				}

				#tabs-<?php echo esc_attr( $atts['id'] ); ?> .sh-tabs-filter li.active a {
					border-bottom-color: <?php echo esc_attr( $accent_color ); ?>!important;
				}
			<?php endif; ?>

			<?php if( $atts['border_accent_color'] ) : ?>
				#tabs-<?php echo esc_attr( $atts['id'] ); ?> .sh-tabs-filter li a:after {
					background-color: <?php echo esc_attr( $atts['border_accent_color'] ); ?>!important;
				}
			<?php else : ?>
				#tabs-<?php echo esc_attr( $atts['id'] ); ?> .sh-tabs-filter li a:after {
					background-color: <?php echo jevelin_option( 'accent_color' ); ?>!important;
				}
			<?php endif; ?>

			<?php if( $atts['border_color'] ) : ?>
				#tabs-<?php echo esc_attr( $atts['id'] ); ?> .nav-tabs,
				#tabs-<?php echo esc_attr( $atts['id'] ); ?> .sh-tabs-filter li {
					border-color: <?php echo esc_attr( $atts['border_color'] ); ?>!important;
				}
			<?php endif; ?>


		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:tabs','jevelin_shortcode_tabs_css');
endif;
?>