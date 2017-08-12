<?php
/**
 * Footer Copyrights HTML
 */

$style_val = jevelin_option('copyright_style');
$style = ( isset( $style_val['style'] ) ) ? esc_attr($style_val['style']) : 'style1';
$style_atts = jevelin_get_picker( $style_val );

$logo = '
<div class="sh-copyrights-logo">
	<img src="'.esc_attr( jevelin_option_image('copyright_logo') ).'" class="sh-copyrights-image" alt="" />
</div>';

$dev = 'http://shufflehound.com';
$text = '
<div class="sh-copyrights-text">
	<span class="developer-copyrights '.(( jevelin_option('copyright_deveveloper', true) == false ) ? ' sh-hidden' : '' ).'">
		'.esc_html__( 'WordPress Theme built by', 'jevelin' ).' <a href="'.esc_attr( $dev ).'" target="blank"><strong>'.esc_html__( 'Shufflehound', 'jevelin' ).'</strong>.</a>
	</span>
	<span>'.wp_kses_post( jevelin_remove_p( jevelin_option('copyright_text') ) ).'</span>
</div>';
?>
	<div class="sh-copyrights">
		<div class="container container-padding">
			<?php if( $style == 'style2' ) : ?>

				<div class="sh-copyrights-style2">
					<div class="sh-table-full">
						<?php if( jevelin_option_image('copyright_logo') ) : ?>
							<div class="sh-table-cell">
								<?php echo wp_kses( $logo, jevelin_allowed_html_basic() ); ?>
							</div>
						<?php endif; ?>
						<div class="sh-table-cell">
							<?php echo do_shortcode(wp_kses( $text, jevelin_allowed_html_basic() )); ?>
						</div>
					</div>
				</div>

			<?php else : ?>

				<div class="sh-copyrights-style1">
					<div class="sh-table-full">
						<?php if( jevelin_option_image('copyright_logo') ) : ?>
							<div class="sh-table-cell">
								<?php echo wp_kses( $logo, jevelin_allowed_html_basic() ); ?>
							</div>
						<?php endif; ?>
						<div class="sh-table-cell">
							<?php echo do_shortcode(wp_kses( $text, jevelin_allowed_html_basic() )); ?>
						</div>
					</div>
				</div>
				<?php if( $style_atts['social'] == true ) : ?>
					<div class="sh-copyrights-style1" style="float: right;">
						<div class="sh-table-cell">
							<div class="sh-copyrights-social">
								<?php echo jevelin_social_media('footer'); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>

			<?php endif; ?>

		</div>
	</div>
