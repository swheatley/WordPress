<?php
/*-----------------------------------------------------------------------------------*/
/* Heading Animated HTML
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
$class = ( $atts['custom_class'] ) ? ' '. $atts['custom_class'] : '';
if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
$size = ( isset( $atts['size']['size'] ) ) ? $atts['size']['size'] : 'default';
$size_atts = jevelin_get_picker( $atts['size'] );
$size_class = ' size-'.$size;

if( $atts['loop'] == 'enable' ) {
	$loop = 'true';
} else {
	$loop = 'false';
}
?>

<script>
jQuery(document).ready(function ($) {
	$("#heading-animated-<?php echo esc_js( $atts['id'] ); ?> .sh-heading-animated-typed").typed({
		strings: [<?php
			$i = 0; $placeholder = '';
			foreach($atts['content'] as $content) :
				if( $i == 0 ) {
					$placeholder = $content;
				}
				echo '"'.wp_kses_post($content).'",'; $i++;
			endforeach;
		?> ],
		contentType: 'html',
		typeSpeed: 0,
		loop: <?php echo esc_attr($loop); ?>,
		startDelay: 300,
		typeSpeed: 80,
		backSpeed: 0,
		backDelay: 700,
	});
});
</script>

<div class="sh-heading" id="heading-animated-<?php echo esc_attr( $atts['id'] ); ?>">
	<<?php echo esc_attr($atts['heading']); ?> class="sh-heading-content<?php echo esc_attr( $size_class ); ?> sh-heading-animated-content<?php echo esc_attr( $class ); ?>">
		<?php if( $atts['content_fixed'] ) : ?>
			<span class="sh-heading-animated-fixed">
				<?php echo esc_attr( $atts['content_fixed'] ); ?>
			</span>
		<?php endif; ?>

		<span class="sh-heading-animated-typed">
			<?php /*echo wp_kses_post( $placeholder );*/ ?>
		</span>
	</<?php echo esc_attr($atts['heading']); ?>>
</div>