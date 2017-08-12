<?php
/*-----------------------------------------------------------------------------------*/
/* Pie Chart HTML
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
$percentage = intval($atts['percentage']);
if( $percentage > 100 || $percentage < 0 ) {
	$percentage = 100;
}

$text_color = ( $atts['text_color'] ) ? $atts['text_color'] : '';
$accent_color = ( $atts['accent_color'] ) ? $atts['accent_color'] : jevelin_option('accent_color');
$accent_hover_color = ( $atts['accent_hover_color'] ) ? $atts['accent_hover_color'] : '';
$line_color = ( $atts['line_color'] ) ? $atts['line_color'] : '';
$background_color = ( $atts['background_color'] ) ? $atts['background_color'] : 'none';
?>

<?php if( $atts['type'] == 'rhomb' ) : ?>

	<div id="piechart-<?php echo esc_attr($atts['id']); ?>" class="sh-piechart sh-piechart-rhomb" data-id="<?php echo esc_js( 800-(800*( ( intval( $percentage ) *0.8/100)/2 )) ); ?>">
		<div class="sh-piechart-percentage">
			<span class="sh-piechart-percentage-number"><?php echo intval( $percentage ); ?></span>
			<span class="sh-piechart-percentage-symbol">%</span>
		</div>
		<svg width="162" height="162" xmlns="http://www.w3.org/2000/svg">
			<rect width="162" height="162" class="sh-piechart-background" stroke-width="10" stroke="<?php echo esc_attr( $line_color ); ?>" fill="<?php echo esc_attr( $background_color ); ?>" />
			<rect width="162" height="162" class="rhomb_animation sh-piechart-animation" stroke-width="10" stroke-linecap="round" stroke="<?php echo esc_attr( $accent_color ); ?>" fill="none" />
			<rect width="162" height="162" class="rhomb_animation sh-piechart-animation" stroke-width="10" stroke-linecap="round" stroke="<?php echo esc_attr( $accent_color ); ?>" fill="none" transform="rotate(90, 100, 100) scale(1,-1) translate(0,-200)" />
		</svg>
	</div>

<?php else : ?>

	<div id="piechart-<?php echo esc_attr($atts['id']); ?>" class="sh-piechart sh-piechart-circle" data-id="<?php echo esc_js((100- intval( $percentage ) ) *6 ); ?>">
		<div class="sh-piechart-percentage">
			<span class="sh-piechart-percentage-number"><?php echo intval( $percentage ); ?></span>
			<span class="sh-piechart-percentage-symbol">%</span>
		</div>
		<svg width="200" height="200" xmlns="http://www.w3.org/2000/svg">
			<circle class="sh-piechart-background" r="96" cy="100" cx="100" stroke-width="4" stroke="<?php echo esc_attr( $line_color ); ?>" fill="<?php echo esc_attr( $background_color ); ?>"/>
			<circle class="circle_animation sh-piechart-animation" r="96" cy="100" cx="100" stroke-width="4" stroke="<?php echo esc_attr( $accent_color ); ?>" fill="none"/>
		</svg>
		<div class="sh-piechart-pointer sh-piechart-animation"></div>
	</div>

<?php endif; ?>