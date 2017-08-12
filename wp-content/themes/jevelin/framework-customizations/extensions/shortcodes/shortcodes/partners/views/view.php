<?php if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
/*-----------------------------------------------------------------------------------*/
/* Partners HTML
/*-----------------------------------------------------------------------------------*/
$class = '';
$class.= ( isset( $atts['padding'] ) && $atts['padding'] == true ) ? ' sh-partners-carousel-additional-padding' : '';
$autoplay = ( isset( $atts['autoplay'] ) && $atts['autoplay'] > 0 ) ? ( $atts['autoplay'] * 1000 ) : 5000;
?>

<div id="partners-<?php echo esc_attr( $atts['id'] ); ?>" class="sh-partners-carousel<?php echo esc_attr( $class ); ?>" data-autoplay="<?php echo intval( $autoplay ); ?>" data-id="<?php echo intval( $atts['columns'] ); ?>">
	<?php foreach( $atts['partners'] as $content ) : ?>
		<div class="<?php if( isset($content['website']) && $content['website'] ) : ?>sh-partners-carousel-item-link<?php endif; ?>">
			<?php if( isset($content['website']) && $content['website'] ) : ?>
				<a href="<?php echo esc_url( $content['website'] ); ?>" target="_blank">
			<?php endif; ?>

			<img src="<?php echo jevelin_get_image($content['logo']); ?>" alt="<?php echo esc_attr( $content['company'] ); ?>" />

			<?php if( isset($content['website']) && $content['website'] ) : ?>
				</a>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
</div>
