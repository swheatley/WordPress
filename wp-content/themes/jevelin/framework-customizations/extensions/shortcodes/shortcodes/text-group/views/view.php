<?php
/*-----------------------------------------------------------------------------------*/
/* Text Group HTML
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
?>

<div id="text-group-<?php echo esc_attr( $atts['id'] ); ?>" class="sh-text-group">

	<?php if( $atts['content'] && $atts['content_two'] ) : ?>
		<div class="row">
			<div class="col-md-6">
				<?php echo do_shortcode( $atts['content'] ); ?>
			</div>
			<div class="col-md-6">
				<?php echo do_shortcode( $atts['content_two'] ); ?>
			</div>
		</div>
	<?php elseif( $atts['content_two'] ) : ?>
		<div class="row">
			<div class="col-md-12">
				<?php echo do_shortcode( $atts['content_two'] ); ?>
			</div>
		</div>
	<?php elseif( $atts['content'] ) : ?>
		<div class="row">
			<div class="col-md-12">
				<?php echo do_shortcode( $atts['content'] ); ?>
			</div>
		</div>
	<?php endif; ?>

</div>