<?php
/*-----------------------------------------------------------------------------------*/
/* Icon Box HTML
/*-----------------------------------------------------------------------------------*/

if( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
?>

<div class="sh-icon sh-icon-<?php echo esc_attr( $atts['alignment'] ); ?>" id="icon-<?php echo esc_attr( $atts['id'] ); ?>">
	<div class="sh-icon-container">
		<i class="sh-icon-data <?php echo esc_attr( $atts['icon'] ); ?>"></i>
	</div>
</div>