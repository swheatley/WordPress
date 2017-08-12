<?php
/*-----------------------------------------------------------------------------------*/
/* Heading HTML
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
$style = ( isset( $atts['style']['style'] ) ) ? $atts['style']['style'] : 'style1';
$style_atts = jevelin_get_picker( $atts['style'] );

$size = ( isset( $atts['size']['size'] ) ) ? $atts['size']['size'] : 'default';
$size_atts = jevelin_get_picker( $atts['size'] );

$class = ( $atts['custom_class'] ) ? ' '.$atts['custom_class'] : '';
$class.= ' size-'.$size;
$animated = ( isset( $atts['animation'] ) && $atts['animation'] != 'none' ) ? ' sh-animated '. $atts['animation'] : '';
$animated_delay = ( $animated && $atts['animation_delay'] ) ? 'data-wow-delay="'. $atts['animation_delay'] .'s"' : '';
$animated_speed = ( $animated && $atts['animation_speed'] ) ? 'data-wow-duration="'. $atts['animation_speed'] .'s"' : '';
?>

<?php if( $style == 'style2' ) : ?>

	<div class="sh-heading sh-heading-style2" id="heading-<?php echo esc_attr( $atts['id'] ); ?><?php echo esc_attr( $animated ); ?>"<?php echo wp_kses_post( $animated_speed ) . wp_kses_post( $animated_delay ); ?>>
		<div class="sh-heading-additional">
			<div class="sh-table-full">
				<div class="sh-table-cell">
					<<?php echo esc_attr($atts['heading']); ?> class="sh-heading-content<?php echo esc_attr( $class ); ?>">
						<?php echo jevelin_remove_p($atts['content']); ?>
					</<?php echo esc_attr($atts['heading']); ?>>
				</div>
			</div>
		</div>
		<?php if( $style_atts['background_text'] ) : ?>
			<div class="sh-heading-additional-text sh-noselect">
				<?php echo esc_attr( $style_atts['background_text'] ); ?>
			</div>
		<?php endif; ?>
	</div>

<?php else : ?>

	<div class="sh-heading sh-heading-<?php echo esc_attr( $style ); ?><?php echo esc_attr( $animated ); ?>" id="heading-<?php echo esc_attr( $atts['id'] ); ?>"<?php echo esc_attr( $animated_speed ) . esc_attr( $animated_delay ) ; ?>>
		<<?php echo esc_attr($atts['heading']); ?> class="sh-heading-content<?php echo esc_attr( $class ); ?>">
			<?php echo jevelin_replace_p($atts['content']); ?>
		</<?php echo esc_attr($atts['heading']); ?>>
	</div>

<?php endif; ?>