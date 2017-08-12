<?php
/*-----------------------------------------------------------------------------------*/
/* Pricing Table HTML
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
$first_symbol = ( isset( $atts['first_symbol'] ) ) ? $atts['first_symbol'] : true;
$style = ( isset( $atts['style']['style'] ) ) ? $atts['style']['style'] : 'style1';
$style_atts = jevelin_get_picker( $atts['style'] );
$class = ( $style_atts['icon'] ) ? ' sh-pricing-with-icon' : '';

if( isset( $atts['enlarge'] ) && $atts['enlarge'] == true ) :
	$class.= ' sh-pricing-enlarge';
endif;
?>

<div class="sh-pricing sh-pricing-<?php echo esc_attr( $style ); ?> sh-pricing-content-<?php echo esc_attr( $atts['content_alignment'] ); ?><?php echo esc_attr( $class ); ?>" id="pricing-<?php echo esc_attr( $atts['id'] ); ?>">


<?php if( isset( $atts['popover'] ) && $atts['popover'] ) : ?>
	<span class="sh-popover-mini sh-popover-mini-center sh-animated fadeIn">
	<?php echo esc_attr( $atts['popover'] ); ?>
	</span>
<?php endif; ?>




	<div class="sh-pricing-top">
		<div class="sh-table-full">
			<div class="sh-table-cell">
				<div class="sh-pricing-name">
					<?php if( $atts['name'] ) : ?>
						<h2><?php echo esc_attr( $atts['name'] ); ?></h2>
					<?php endif; ?>
				</div>
				<div class="sh-pricing-top-aside">
					<?php if( $atts['price'] ) : ?>
						<div class="sh-pricing-price">
							<?php if( $first_symbol == true ) : ?>
								<?php echo preg_replace('/^([\<\sa-z\d\/\>]*)(([$\;]+)|([\"\'\w]))/', '$1<span class="sh-pricing-currency">$2</span>', esc_attr( $atts['price'] )); ?>
							<?php else : ?>
								<?php echo esc_attr( $atts['price'] ); ?>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<?php if( $atts['description'] ) : ?>
						<div class="sh-pricing-description">
							<?php echo esc_attr( $atts['description'] ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="sh-pricing-content">

		<?php if( $style_atts['icon'] ) : ?>
			<div class="sh-pricing-icon">
				<i class="<?php echo esc_attr( $style_atts['icon'] ); ?>"></i>
			</div>
		<?php endif; ?>

		<?php foreach( $atts['content'] as $content ) : ?>
			<div class="sh-pricing-content-item">
				<i class="<?php echo esc_attr( $content['icon'] ); ?>"></i>
				<span class="sh-pricing-amount"><?php echo esc_attr( $content['amount'] ); ?></span>
				<span><?php echo esc_attr( $content['description'] ); ?></span>
			</div>
		<?php endforeach; ?>

	</div>
	<?php if( $atts['button_status'] == true ) : ?>
		<div class="sh-pricing-bottom">

			<a href="<?php echo esc_url($atts['button_url']); ?>" class="sh-pricing-button sh-pricing-button-<?php echo esc_attr( $atts['button_style'] ); ?>">
				<span><?php echo esc_attr( $atts['button_name'] ); ?></span>
			</a>

		</div>
	<?php endif; ?>
</div>
