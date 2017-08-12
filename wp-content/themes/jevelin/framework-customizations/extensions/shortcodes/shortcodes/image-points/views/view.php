<?php
/*-----------------------------------------------------------------------------------*/
/* Image Points HTML
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
if( isset($atts['source']) && $atts['source'] != 'large' ) :
	$source = 'full';
else :
	$source = 'large';
endif;
?>

<div id="image-points-<?php echo esc_attr($atts['id']); ?>" class="sh-image-points">
	<img class="sh-image-url" src="<?php echo jevelin_get_image_size($atts['image'],$source); ?>" alt="" />
	<?php $i = 0; foreach($atts['points'] as $point) : $i++; ?>
		<?php
			$right_side = '';
			if( $point['left'] > 65 ) :
				$right_side.= ' sh-image-point-right';
			else :
				$right_side.= '';
			endif;

			if( $point['left'] > 50 ) :
				$right_side.= ' sh-image-point-right-mobile';
			else :
				$right_side.= '';
			endif;
		?>
		<div class="sh-animated zoomIn sh-image-point<?php echo esc_attr( $right_side ); ?>" 
			style="animation-delay: <?php echo intval( $i ) * 0.25; ?>s; top: <?php echo esc_attr( $point['top'] ); ?>%; left: <?php echo esc_attr( $point['left'] ); ?>%;" >
			<i class="ti-plus"></i>
			<span class="sh-image-point-tooltip"><?php echo wp_kses_post($point['content']); ?></span>
		</div>
	<?php endforeach; ?>
</div>