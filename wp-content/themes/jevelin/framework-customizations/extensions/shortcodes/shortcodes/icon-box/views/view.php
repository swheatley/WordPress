<?php
/*-----------------------------------------------------------------------------------*/
/* Icon Box HTML
/*-----------------------------------------------------------------------------------*/

if( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
$style = ( isset( $atts['style']['style'] ) && $atts['style']['style'] ) ? esc_attr($atts['style']['style']) : 'style1';
$style_atts = jevelin_get_picker( $atts['style'] );

$class = '';
if( $style == 8 && !$style_atts['color_background'] ) {
	$class.= ' sh-iconbox-nobg';
}

if( isset($style_atts['active_hover_action']) && $style_atts['active_hover_action'] == true && $style == 'style11') :
	$class.= ' sh-iconbox-active-hover-action';
endif;

if( isset( $style_atts['shape'] ) && $style_atts['shape'] ) :
	$shape = $style_atts['shape'];
else :
	if( in_array($style, array( 'style2', 'style3', 'style4', 'style5', 'style6' )) ) :
		$shape = 'square';
	else :
		$shape = 'circle';
	endif;
endif;
?>

<div class="sh-iconbox sh-iconbox-<?php echo esc_attr( $style ); ?> sh-iconbox-<?php echo esc_attr( $atts['alignment'] ); ?><?php echo esc_attr( $class ); ?>" id="iconbox-<?php echo esc_attr( $atts['id'] ); ?>">

	<?php if( $style == 'style10' || $style == 'style11' ) : ?>

		<div class="sh-iconbox-container">
			<div class="sh-iconbox-top">
				<?php if( $atts['icon'] ) : ?>
					<div class="sh-iconbox-icon">
						<div class="sh-iconbox-icon-shape sh-iconbox-square">
							<i class="sh-iconbox-hover <?php echo esc_attr( $atts['icon'] ); ?>"></i>
						</div>
					</div>
				<?php endif; ?>

				<?php if( $atts['title'] ) : ?>
					<div class="sh-iconbox-title">
						<h3><?php echo esc_attr( $atts['title'] ); ?></h3>
					</div>
				<?php endif; ?>
			</div>
			<div class="sh-iconbox-bottom">
				<div class="sh-iconbox-content">
					<?php echo wp_kses_post( $atts['content'] ); ?>
				</div>
			</div>
		</div>

	<?php else : ?>

		<div class="sh-iconbox-icon">
			<div class="sh-iconbox-icon-shape sh-iconbox-<?php echo esc_attr( $shape ); ?>">
				<i class="sh-iconbox-hover <?php echo esc_attr( $atts['icon'] ); ?>"></i>

				<?php if( in_array( $style, array('style1') ) ) : ?>
					<div class="sh-iconbox-icon2">
						<i class="<?php echo esc_attr( $style_atts['icon'] ); ?>"></i>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="sh-iconbox-aside">
			<div class="sh-iconbox-title">
				<?php if( $atts['url'] ) : ?>
					<a href="<?php echo esc_url( $atts['url'] ); ?>">
						<h3><?php echo esc_attr( $atts['title'] ); ?></h3>
					</a>
				<?php else : ?>
					<h3><?php echo esc_attr( $atts['title'] ); ?></h3>
				<?php endif; ?>
			</div>
			<div class="sh-iconbox-seperator"></div>
			<div class="sh-iconbox-content">
				<?php echo wp_kses_post( $atts['content'] ); ?>
			</div>
		</div>

	<?php endif; ?>
</div>