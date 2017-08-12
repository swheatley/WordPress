<?php if (!defined('FW')) die('Forbidden');
if(!function_exists('jevelin_shortcode_partners_css')) :
	function jevelin_shortcode_partners_css ($data) {
		$atts = jevelin_shortcode_options($data,'partners'); ob_start(); ?>

			
			<?php if( $atts['columns'] > 0 ) : ?>
				#partners-<?php echo esc_attr( $atts['id'] ); ?> .sh-partners-item {
					width: <?php
						if( $atts['columns'] == '1') :
							echo '100';
						elseif( $atts['columns'] == '2') :
							echo '50';
						elseif( $atts['columns'] == '3') :
							echo '33';
						elseif( $atts['columns'] == '4') :
							echo '25';
						else :
							echo '20';
						endif;
					?>%;
				}
			<?php endif; ?>

			<?php if( $atts['columns'] > 3 ) : ?>
				@media (max-width: 1000px) {

					#partners-<?php echo esc_attr( $atts['id'] ); ?> .sh-partners-item {
						width: 33%;
					}
					
				}
			<?php endif; ?>

			<?php if( $atts['columns'] > 2 ) : ?>
				@media (max-width: 850px) {

					#partners-<?php echo esc_attr( $atts['id'] ); ?> .sh-partners-item {
						width: 50%;
					}

				}
			<?php endif; ?>	


			<?php if( isset($atts['line']) && $atts['line'] == true ) : ?>
				#partners-<?php echo esc_attr( $atts['id'] ); ?> .slick-slide:not(:last-child) {
					border-right: 1px solid rgba(0,0,0,0.08);
				}
			<?php endif; ?>	


		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:partners','jevelin_shortcode_partners_css');
endif;
?>