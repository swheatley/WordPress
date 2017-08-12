<?php
/*-----------------------------------------------------------------------------------*/
/* Event HTML
/*-----------------------------------------------------------------------------------*/
if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
?>

<div id="event-<?php echo esc_attr( $atts['id'] ); ?>" class="sh-event">
	<div class="sh-event-container sh-columns">
		<div>
			<h3 class="sh-event-title"><?php echo esc_attr( $atts['title'] ); ?></h3>
			<div class="sh-event-desc"><?php echo esc_attr( $atts['desc'] ); ?></div>
		</div>
		<div>
			<a href="<?php echo esc_url( $atts['button_link'] ); ?>" class="sh-event-button">
				<?php echo esc_attr( $atts['button_name'] ); ?>
			</a>
		</div>
	</div>
</div>