<?php
/*-----------------------------------------------------------------------------------*/
/* Google maps HTML
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
?>

<div class="sh-google-map" id="google-map-<?php echo esc_attr($atts['id']); ?>">
	<div class="fw-map" <?php echo fw_attr_to_html($map_data_attr); ?>>
		<div class="fw-map-canvas"></div>
	</div>
</div>