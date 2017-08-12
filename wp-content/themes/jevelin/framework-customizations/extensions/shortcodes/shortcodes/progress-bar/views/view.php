<?php
/*-----------------------------------------------------------------------------------*/
/* Progress Bar HTML
/*-----------------------------------------------------------------------------------*/
if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
$accent_color = ( $atts['accent_color'] ) ? $atts['accent_color'] : jevelin_option('accent_color');

if( $atts['percentage'] > 100) :
	$percentage = 100;
elseif( $atts['percentage'] <= 100 && $atts['percentage'] >= 0 ) :
	$percentage = esc_attr($atts['percentage']);
else :
	$percentage = 0;
endif;
?>

<div id="progress-<?php echo esc_attr( $atts['id'] ); ?>" class="sh-progress sh-progress-<?php echo esc_attr( $atts['style'] ); ?>">
	<?php if( $atts['style'] == 'style2' || $atts['style'] == 'style3' ) : ?>

		<div class="sh-progress-item">
			<div class="sh-progress-content">
				<div class="sh-progress-content-container">
					<div class="sh-progress-status-value" data-width="<?php echo intval( $percentage ); ?>">
						<div class="sh-progress-status-value-edge"></div>
					</div>
					<div class="sh-progress-title"><?php echo esc_attr( $atts['title'] ); ?></div>
					<div class="sh-progress-value2"><?php echo intval( $percentage ); ?>%</div>
				</div>
			</div>
		</div>

	<?php elseif( $atts['style'] == 'style4' || $atts['style'] == 'style5' ) : ?>

		<div class="sh-progress-item">
			<div class="row">
				<div class="col-md-8 col-sm-8 col-xs-8">
					<div class="sh-progress-title">
						<?php echo esc_attr( $atts['title'] ); ?>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-4">
					<div class="sh-progress-value2">
						<?php echo intval( $percentage ); ?>%
					</div>
				</div>
			</div>
	
			<div class="sh-progress-content">
				<div class="sh-progress-content-container">
					<div class="sh-progress-status">
						<div class="sh-progress-status-value" data-width="<?php echo intval( $percentage ); ?>"></div>
					</div>
				</div>
			</div>
		</div>

	<?php else : ?>

		<div class="sh-progress-item">
			<div class="sh-progress-title"><?php echo esc_attr( $atts['title'] ); ?></div>
			<div class="sh-progress-content">
				<div class="sh-progress-content-container">
					<div class="sh-progress-status">
						<div class="sh-progress-status-value" data-width="<?php echo intval( $percentage ); ?>"></div>
					</div>
				</div>
				<div class="sh-progress-value2">
					<?php echo intval( $percentage ); ?>%
				</div>
			</div>
		</div>

	<?php endif; ?>
</div>