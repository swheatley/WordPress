<?php if (!defined('FW')) die('Forbidden');

if(!function_exists('jevelin_shortcode_timeline_css')) :
	function jevelin_shortcode_timeline_css ($data) {
		$atts = jevelin_shortcode_options($data,'timeline');
		$style = ( isset( $atts['style']['style'] ) ) ? esc_attr($atts['style']['style']) : 'style1';
		$style_atts = jevelin_get_picker( $atts['style'] );
		ob_start(); ?>


			<?php if( $atts['title_color'] ) : ?>
				#timeline-<?php echo esc_attr( $atts['id'] ); ?> h3 {
					color: <?php echo esc_attr($atts['title_color']); ?>;
				}
			<?php endif; ?>

			<?php if( $atts['content_color'] ) : ?>
				#timeline-<?php echo esc_attr( $atts['id'] ); ?> .sh-timeline-content {
					color: <?php echo esc_attr($atts['content_color']); ?>;
				}
			<?php endif; ?>

			<?php
				$accent_color = ( esc_attr($atts['accent_color']) ) ? esc_attr($atts['accent_color']) : esc_attr(jevelin_option('accent_color'));
				if( $accent_color && $style != 'style2' && $style != 'style2 style3' ) :
			?>
				#timeline-<?php echo esc_attr( $atts['id'] ); ?> .sh-timeline-item:hover .sh-timeline-box {
					background-color: <?php echo esc_attr( $accent_color ); ?>;
				}

				#timeline-<?php echo esc_attr( $atts['id'] ); ?> .sh-timeline-item:hover .sh-timeline-box-tale {
					border-left-color: <?php echo esc_attr( $accent_color ); ?>!important;
					border-right-color: <?php echo esc_attr( $accent_color ); ?>!important;
				}

				#timeline-<?php echo esc_attr( $atts['id'] ); ?> .sh-timeline-item:hover .sh-timeline-box-circle {
					border-color: <?php echo esc_attr( $accent_color ); ?>;
				}
			<?php elseif( $accent_color && $style == 'style2' || $style == 'style2 style3' ) :?>

				#timeline-<?php echo esc_attr( $atts['id'] ); ?>.sh-timeline-2 .sh-timeline-box-left i,
				#timeline-<?php echo esc_attr( $atts['id'] ); ?>.sh-timeline-2 .sh-timeline-box-right i,
				#timeline-<?php echo esc_attr( $atts['id'] ); ?>.sh-timeline-2.style3 .sh-timeline-box-left i,
				#timeline-<?php echo esc_attr( $atts['id'] ); ?>.sh-timeline-2.style3 .sh-timeline-box-right i, {
					color: <?php echo esc_attr( $accent_color ); ?>;
				}

				#timeline-<?php echo esc_attr( $atts['id'] ); ?>.sh-timeline-2 .sh-timeline-box-circle,
				#timeline-<?php echo esc_attr( $atts['id'] ); ?>.sh-timeline-2.style3 .sh-timeline-box-circle {
					background-color: <?php echo esc_attr( $accent_color ); ?>;
				}

			<?php endif; ?>

			<?php if( $atts['date_background_color'] ) : ?>
				#timeline-<?php echo esc_attr( $atts['id'] ); ?> .sh-timeline-item .sh-timeline-box {
					background-color: <?php echo esc_attr($atts['date_background_color']); ?>;
				}

				#timeline-<?php echo esc_attr( $atts['id'] ); ?>.sh-timeline .sh-timeline-item .sh-timeline-box-tale {
					border-left-color: <?php echo esc_attr($atts['date_background_color']); ?>!important;
					border-right-color: <?php echo esc_attr($atts['date_background_color']); ?>!important;
				}

				#timeline-<?php echo esc_attr( $atts['id'] ); ?>.sh-timeline-2 .sh-timeline-item .sh-timeline-box-tale,
				#timeline-<?php echo esc_attr( $atts['id'] ); ?>.sh-timeline-2.style3 .sh-timeline-item .sh-timeline-box-tale,
				#timeline-<?php echo esc_attr( $atts['id'] ); ?>.sh-timeline .sh-timeline-item .sh-timeline-box-circle {
					border-color: <?php echo esc_attr($atts['date_background_color']); ?>;
				}
			<?php endif; ?>

			<?php if( $atts['border_color'] ) : ?>
				#timeline-<?php echo esc_attr( $atts['id'] ); ?> .sh-timeline-item .sh-timeline-box {
					border: 1px solid <?php echo esc_attr($atts['border_color']); ?>!important;
				}

				#timeline-<?php echo esc_attr( $atts['id'] ); ?> .sh-timeline-box-tale:after {
					border-left-color: <?php echo esc_attr($atts['border_color']); ?>!important;
					border-right-color: <?php echo esc_attr($atts['border_color']); ?>!important;
				}
			<?php endif; ?>

			<?php if( ( $style == 'style2' || $style == 'style2 style3' ) && $atts['date_color'] ) : ?>
				#timeline-<?php echo esc_attr( $atts['id'] ); ?> .sh-timeline-item .sh-timeline-date {
					color: <?php echo esc_attr($atts['date_color']); ?>;
				}
			<?php elseif( $atts['date_color'] ) : ?>
				#timeline-<?php echo esc_attr( $atts['id'] ); ?> .sh-timeline-item .sh-timeline-box {
					color: <?php echo esc_attr($atts['date_color']); ?>;
				}
			<?php endif; ?>


		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:timeline','jevelin_shortcode_timeline_css');
endif;
?>