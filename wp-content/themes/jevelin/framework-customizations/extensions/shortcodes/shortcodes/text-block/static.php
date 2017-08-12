<?php if (!defined('FW')) die('Forbidden');

if(!function_exists('jevelin_shortcode_text_block_css')) :
	function jevelin_shortcode_text_block_css ($data) {
		$atts = jevelin_shortcode_options($data,'text-block'); ob_start(); ?>


			<?php if( ( isset($atts['text_size']) && $atts['text_size'] ) ||
					  ( isset($atts['margin']) && $atts['margin'] ) || 
					  ( isset($atts['text_color']) && $atts['text_color'] ) ) : ?>
				#text-block-<?php echo esc_attr( $atts['id'] ); ?> {
					<?php if( $atts['text_size'] ) : ?>
						font-size: <?php echo jevelin_addpx( $atts['text_size'] ); ?>;
					<?php endif; ?>

					<?php if( $atts['text_color'] ) : ?>
						color: <?php echo esc_attr( $atts['text_color'] ); ?>;
					<?php endif; ?>

					<?php if( $atts['margin'] ) : ?>
						margin: <?php echo esc_attr( $atts['margin'] ); ?>;
					<?php endif; ?>	
				}
			<?php endif; ?>

			<?php if( ( isset($atts['line_height']) && $atts['line_height'] ) ) : ?>
				#text-block-<?php echo esc_attr( $atts['id'] ); ?> p,
				#text-block-<?php echo esc_attr( $atts['id'] ); ?> {
					line-height: <?php echo jevelin_addpx( $atts['line_height'] ); ?>;
				}
			<?php endif; ?>

			#text-block-<?php echo esc_attr( $atts['id'] ); ?> .drop-cap {
				font-weight: bold;
				font-size: 50px;
				display: block;
				float: left;
				margin: 8px 10px 0 0;
			}

			<?php if( $atts['paragraph_whitespace'] == false ) : ?>
				#text-block-<?php echo esc_attr( $atts['id'] ); ?> p {
					margin-bottom: 0;
				}
			<?php endif; ?>


		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:text_block','jevelin_shortcode_text_block_css');
endif;
?>