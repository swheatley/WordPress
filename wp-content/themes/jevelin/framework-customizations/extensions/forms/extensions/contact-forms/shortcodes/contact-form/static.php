<?php if (!defined('FW')) die('Forbidden');

wp_enqueue_script(
	'fw-form-script',
	fw_get_template_customizations_directory_uri('/extensions/forms/extensions/contact-forms/static/script.js'),
	array('jquery'),
	fw()->manifest->get_version(),
	true
);


if(!function_exists('jevelin_shortcode_contact_form_css')) :
	function jevelin_shortcode_contact_form_css ($data) {
		$atts = jevelin_shortcode_options($data,'contact_form');
		//$style = ( isset( $atts['style']['style'] ) ) ? esc_attr($atts['style']['style']) : 'style1';
		//$style_atts = jevelin_get_picker( $atts['style'] );
		ob_start(); ?>

			<?php if( $atts['submit_width'] == 'full' ) : ?>
				#contact-form-<?php echo esc_attr( $atts['id'] ); ?> input[type="submit"] {
					width: 100%;
				}
			<?php endif; ?>


			<?php if( isset( $atts['submit_background_color'] ) && $atts['submit_background_color'] ) : ?>
				#contact-form-<?php echo esc_attr( $atts['id'] ); ?> input[type="submit"] {
					background-color: <?php echo esc_attr( $atts['submit_background_color'] ); ?>!important;
				}
			<?php endif; ?>

			<?php if( isset( $atts['submit_background_hover_color'] ) && $atts['submit_background_hover_color'] ) : ?>
				#contact-form-<?php echo esc_attr( $atts['id'] ); ?> input[type="submit"]:hover {
					background-color: <?php echo esc_attr( $atts['submit_background_hover_color'] ); ?>!important;
				}
			<?php endif; ?>

			<?php if( $atts['text_color'] ) : ?>
				#contact-form-<?php echo esc_attr( $atts['id'] ); ?> label {
					color: <?php echo esc_attr( $atts['text_color'] ); ?>!important;
				}
			<?php endif; ?>

			<?php if( $atts['input_text_color'] ) : ?>
				#contact-form-<?php echo esc_attr( $atts['id'] ); ?> input:not([type="submit"]),
				#contact-form-<?php echo esc_attr( $atts['id'] ); ?> textarea,
				#contact-form-<?php echo esc_attr( $atts['id'] ); ?> .placeholder {
					color: <?php echo esc_attr( $atts['input_text_color'] ); ?>;
				}
			<?php endif; ?>

			<?php if( $atts['input_border_color'] ) : ?>
				#contact-form-<?php echo esc_attr( $atts['id'] ); ?> input:not([type="submit"]),
				#contact-form-<?php echo esc_attr( $atts['id'] ); ?> textarea,
				#contact-form-<?php echo esc_attr( $atts['id'] ); ?> .placeholder {
					border-color: <?php echo esc_attr( $atts['input_border_color'] ); ?>;
				}
			<?php endif; ?>

			<?php if( $atts['input_background_color'] ) : ?>
				#contact-form-<?php echo esc_attr( $atts['id'] ); ?> input:not([type="submit"]),
				#contact-form-<?php echo esc_attr( $atts['id'] ); ?> textarea,
				#contact-form-<?php echo esc_attr( $atts['id'] ); ?> .placeholder {
					background-color: <?php echo esc_attr( $atts['input_background_color'] ); ?>;
				}
			<?php endif; ?>

			<?php if( isset($atts['style']) && $atts['style'] == 'style2' ) : ?>
				#contact-form-<?php echo esc_attr( $atts['id'] ); ?> label {
					display: none;
				}

				#contact-form-<?php echo esc_attr( $atts['id'] ); ?>.contact-form input[type="submit"] {
				    display: table;
				    margin: 0 auto;
				}

				#contact-form-<?php echo esc_attr( $atts['id'] ); ?>.contact-form input,
				#contact-form-<?php echo esc_attr( $atts['id'] ); ?>.contact-form textarea {
				    text-align: center;
				    border-radius: 25px;
				}

			<?php elseif( isset($atts['style']) && $atts['style'] == 'style3' ) : ?>
				#contact-form-<?php echo esc_attr( $atts['id'] ); ?> label {
					display: none;
				}

				#contact-form-<?php echo esc_attr( $atts['id'] ); ?>.contact-form input[type="submit"] {
				    display: table;
				    margin: 0 auto;
				}

				#contact-form-<?php echo esc_attr( $atts['id'] ); ?>.contact-form input,
				#contact-form-<?php echo esc_attr( $atts['id'] ); ?>.contact-form textarea {
				    text-align: left;
				    border-radius: 25px;
				    padding-left: 30px;
				    padding-right: 30px;
				}

				#contact-form-<?php echo esc_attr( $atts['id'] ); ?>.contact-form input[type="submit"] {
					text-align: center;
				}

			<?php elseif( isset($atts['style']) && $atts['style'] == 'style4' ) : ?>

				#contact-form-<?php echo esc_attr( $atts['id'] ); ?> label {
					display: none;
				}

				#contact-form-<?php echo esc_attr( $atts['id'] ); ?> .wrap-forms input,
				#contact-form-<?php echo esc_attr( $atts['id'] ); ?> .wrap-forms textarea,
				#contact-form-<?php echo esc_attr( $atts['id'] ); ?> .wrap-forms select {
					/*background-color: transparent;
					color: #fff;
					border: 1px solid rgba( 255,255,255,0.5);*/
					border-radius: 100px;
					padding: 0 30px!important;
				}

				#contact-form-<?php echo esc_attr( $atts['id'] ); ?> > form > div:last-child input {
					line-height: 40px!important;
					height: 50px!important;
					padding-left: 35px!important;
					padding-right: 35px!important;
				}

				@media (min-width: 700px) {
					#contact-form-<?php echo esc_attr( $atts['id'] ); ?> .wrap-forms {
						display: table-cell;
						width: 100%;
					}

					#contact-form-<?php echo esc_attr( $atts['id'] ); ?> > form > div:last-child {
						display: table-cell;
					}

					#contact-form-<?php echo esc_attr( $atts['id'] ); ?> > form > div:last-child input {
						margin-left: 15px;
					}

				}

			<?php elseif( isset($atts['style']) && $atts['style'] == 'style5' ) : ?>

				#contact-form-<?php echo esc_attr( $atts['id'] ); ?> label {
					display: none;
				}

				#contact-form-<?php echo esc_attr( $atts['id'] ); ?>.contact-form input[type="submit"] {
					display: table;
					margin: 0 auto;
				}

				#contact-form-<?php echo esc_attr( $atts['id'] ); ?>.contact-form input {
					line-height: 60px!important;
				}

				#contact-form-<?php echo esc_attr( $atts['id'] ); ?>.contact-form input,
				#contact-form-<?php echo esc_attr( $atts['id'] ); ?>.contact-form textarea {
					text-align: left;
					border-radius: 25px;
					padding: 29px 30px;
					border-width: 0px;
				}

				#contact-form-<?php echo esc_attr( $atts['id'] ); ?>.contact-form textarea {
					height: auto;
					min-height: 180px;
				}

				#contact-form-<?php echo esc_attr( $atts['id'] ); ?>.contact-form input[type="submit"] {
					text-align: center;
				}

			<?php endif; ?>

		<?php $css = ob_get_contents(); ob_end_clean();
		wp_add_inline_style( 'jevelin-responsive', jevelin_compress( $css ) );
	}
	add_action('fw_ext_shortcodes_enqueue_static:contact_form','jevelin_shortcode_contact_form_css');
endif;
?>
