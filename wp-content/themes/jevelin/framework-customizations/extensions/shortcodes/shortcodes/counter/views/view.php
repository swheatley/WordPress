<?php
/*-----------------------------------------------------------------------------------*/
/* Counter HTML
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
$style = ( isset( $atts['style']['style'] ) ) ? $atts['style']['style'] : 'style1';
$style_atts = jevelin_get_picker( $atts['style'] );

if( isset( $atts['number_size'] ) ) :
	$size = ( isset( $atts['number_size']['number_size'] ) ) ? $atts['number_size']['number_size'] : 'default';
	$size_atts = jevelin_get_picker( $atts['number_size'] );
	$size_class = ' size-'.$size;
else :
	$size_class = '';
endif;
?>

<div id="counter-<?php echo esc_attr($atts['id']); ?>" class="sh-counter sh-counter-<?php echo esc_attr( $style ); ?>">
	<?php if( $style == 'style2' || $style == 'style6' ) : ?>

		<div class="sh-counter-icon"><i class="<?php echo esc_attr($atts['icon']); ?>"></i></div>
		<div class="sh-counter-number sh-counter-animate<?php echo esc_attr( $size_class ); ?>"><?php echo intval($atts['number']); ?></div>
		<div class="sh-counter-divider"></div>
		<span class="sh-counter-title"><?php echo esc_attr($atts['title']); ?></span>
		<?php if( $atts['subtitle'] ) : ?>
			<div class="sh-counter-subtitle"><?php echo esc_attr($atts['subtitle']); ?></div>
		<?php endif; ?>

	<?php elseif( $style == 'style3' ) : ?>

		<?php if( $atts['icon'] ) : ?>
			<div class="sh-counter-icon"><i class="<?php echo esc_attr($atts['icon']); ?>"></i></div>
		<?php endif; ?>
		<div class="sh-table">
			<div class="sh-table-cell text-right">
				<div class="sh-counter-number sh-counter-animate"><?php echo intval($atts['number']); ?></div>
			</div>
			<div class="sh-table-cell text-left">
				<span class="sh-counter-title"><?php echo esc_attr($atts['title']); ?></span>
				<?php if( $atts['subtitle'] ) : ?>
					<div class="sh-counter-subtitle"><?php echo esc_attr($atts['subtitle']); ?></div>
				<?php endif; ?>
			</div>
		</div>

	<?php elseif( $style == 'style4' ) : ?>

		<div class="sh-counter-icon"><i class="<?php echo esc_attr($atts['icon']); ?>"></i></div>
		<div>
			<span class="sh-counter-number sh-counter-animate<?php echo esc_attr( $size_class ); ?>"><?php echo intval($atts['number']); ?></span>
			<span class="sh-counter-title"><?php echo esc_attr($atts['title']); ?></span>
		</div>
		<?php if( $atts['subtitle'] ) : ?>
			<div class="sh-counter-subtitle"><?php echo esc_attr($atts['subtitle']); ?></div>
		<?php endif; ?>

	<?php elseif( $style == 'style5' ) : ?>

		<div class="sh-counter-icon"><i class="<?php echo esc_attr($atts['icon']); ?>"></i></div>
		<div class="sh-counter-number sh-counter-animate<?php echo esc_attr( $size_class ); ?>"><?php echo intval($atts['number']); ?></div>
		<span class="sh-counter-title"><?php echo esc_attr($atts['title']); ?></span>
		<?php if( $atts['subtitle'] ) : ?>
			<div class="sh-counter-subtitle"><?php echo esc_attr($atts['subtitle']); ?></div>
		<?php endif; ?>

	<?php else : ?>

		<div class="sh-counter-number sh-counter-animate<?php echo esc_attr( $size_class ); ?>"><?php echo intval($atts['number']); ?></div>
		<div class="sh-counter-topbar">
			<div class="sh-counter-icon">
				<i class="<?php echo esc_attr($atts['icon']); ?>"></i>
			</div>
			<h3 class="sh-counter-title">
				<?php echo esc_attr($atts['title']); ?>
			</h3>
		</div>

		<?php if( $atts['subtitle'] ) : ?>
			<div class="sh-counter-subtitle"><?php echo esc_attr($atts['subtitle']); ?></div>
		<?php endif; ?>

	<?php endif; ?>
</div>
