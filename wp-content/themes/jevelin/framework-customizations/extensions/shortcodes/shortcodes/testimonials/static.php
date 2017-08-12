<?php if (!defined('FW')) die('Forbidden');

if(!function_exists('jevelin_shortcode_testimonials_css')) :
	function jevelin_shortcode_testimonials_css ($data) {
		$atts = jevelin_shortcode_options($data,'testimonials');
		$description_styles = $atts['description_styles'];
		ob_start(); ?>


			<?php if( $atts['color_heading'] ) : ?>
				#testimonials-<?php echo esc_attr( $atts['id'] ); ?> .sh-testimonials-name h3 {
					color: <?php echo esc_attr( $atts['color_heading'] ); ?>;
				}
			<?php endif; ?>

			<?php if( $atts['color_job'] ) : ?>
				#testimonials-<?php echo esc_attr( $atts['id'] ); ?> .sh-testimonials-job {
					color: <?php echo esc_attr( $atts['color_job'] ); ?>;
				}
			<?php endif; ?>

			<?php if( !$atts['color_job'] && $atts['style'] == 'style5' ) : ?>
				
				#testimonials-<?php echo esc_attr( $atts['id'] ); ?> .sh-testimonials-job {
					color: <?php echo esc_attr( jevelin_option('accent_color') ); ?>;
				}
	
			<?php endif; ?>

			<?php if( $atts['color_text'] ) : ?>
				#testimonials-<?php echo esc_attr( $atts['id'] ); ?> .sh-testimonials-quote-icon i,
				#testimonials-<?php echo esc_attr( $atts['id'] ); ?> .sh-testimonials-quote,
				#testimonials-<?php echo esc_attr( $atts['id'] ); ?>.sh-testimonials-style2 .sh-testimonials-quote:after,
				#testimonials-<?php echo esc_attr( $atts['id'] ); ?>.sh-testimonials-style2 .sh-testimonials-quote:before {
					color: <?php echo esc_attr( $atts['color_text'] ); ?>;
				}
			<?php endif; ?>

			<?php if( $atts['color_switch'] ) : ?>
				#testimonials-<?php echo esc_attr( $atts['id'] ); ?> .sh-testimonials-switch > div {
					border-color: <?php echo esc_attr( $atts['color_switch'] ); ?>;
				}
				#testimonials-<?php echo esc_attr( $atts['id'] ); ?> .sh-testimonials-switch i {
					color: <?php echo esc_attr( $atts['color_switch'] ); ?>;
				}
			<?php endif; ?>

			<?php if( $atts['color_quote'] ) : ?>
				#testimonials-<?php echo esc_attr( $atts['id'] ); ?> .sh-testimonials-quote:before,
				#testimonials-<?php echo esc_attr( $atts['id'] ); ?> .sh-testimonials-quote:after {
					color: <?php echo esc_attr( $atts['color_quote'] ); ?>!important;
				}
			<?php endif; ?>

			<?php if( $atts['line_text'] ) : ?>
				#testimonials-<?php echo esc_attr( $atts['id'] ); ?>.sh-testimonials-style3 .sh-testimonials-item-container,
				#testimonials-<?php echo esc_attr( $atts['id'] ); ?>.sh-testimonials-style4 .sh-testimonials-table-icon {
					border-color: <?php echo esc_attr( $atts['line_text'] ); ?>!important;
				}
			<?php endif; ?>

			#testimonials-<?php echo esc_attr( $atts['id'] ); ?> .sh-testimonials-container:hover .sh-testimonials-bottom,
			#testimonials-<?php echo esc_attr( $atts['id'] ); ?> .sh-testimonials-top {
				background-color: <?php echo ( $atts['color_accent'] ) ? esc_attr( $atts['color_accent'] ) : esc_attr( jevelin_option('accent_color') ); ?>;
			}

			#testimonials-<?php echo esc_attr( $atts['id'] ); ?> .sh-testimonials-quote {

				<?php if( isset($description_styles['bold']) && $description_styles['bold'] == true ) : ?>
					font-weight: bold;
				<?php endif; ?>

				<?php if( isset($description_styles['italic']) && $description_styles['italic'] == true ) : ?>
					font-style: italic;
				<?php endif; ?>
				
				<?php if( isset($description_styles['underline']) && $description_styles['underline'] == true ) : ?>
					text-decoration: underline;
				<?php endif; ?>

				<?php if( $atts['description_size'] ) : ?>
					font-size: <?php echo jevelin_addpx( $atts['description_size'] ); ?>;
				<?php endif; ?>

			}

			<?php if( $atts['style'] == 'style6' && jevelin_option('accent_color') ) : ?>
				#testimonials-<?php echo esc_attr( $atts['id'] ); ?>.sh-testimonials-style6 .sh-testimonials-quote-icon-container {
					background-color: <?php echo esc_attr( jevelin_option('accent_color') ); ?>;
				}
			<?php endif; ?>

		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:testimonials','jevelin_shortcode_testimonials_css');
endif;
?>