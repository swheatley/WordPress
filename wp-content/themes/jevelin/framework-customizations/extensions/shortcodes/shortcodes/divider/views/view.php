<?php
/*-----------------------------------------------------------------------------------*/
/* Divider HTML
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }

$content = jevelin_get_picker_value( $atts['content'], 'none' );
$content_atts = jevelin_get_picker( $atts['content'] );
$width_atts = jevelin_get_picker( $atts['width'] );
?>

<div id="divider-<?php echo esc_attr($atts['id']); ?>" class="sh-divider sh-divider-<?php echo esc_attr( $atts['alignment'] ); ?> sh-divider-content-<?php echo esc_attr( $content ); ?>">
	<?php if( $content == 'icon_option' ) : ?>
		<div class="sh-divider-content">
			<span class="sh-divider-icon">
				<?php
					if( $content_atts['icon_multiplier'] == '3' ) :
						echo '<i class="'.esc_attr( $content_atts['icon'] ).'"></i>&nbsp;<i class="'.esc_attr( $content_atts['icon'] ).'"></i>&nbsp;<i class="'.esc_attr( $content_atts['icon'] ).'"></i>';
					elseif( $content_atts['icon_multiplier'] == '2' ) :
						echo '<i class="'.esc_attr( $content_atts['icon'] ).'"></i>&nbsp;<i class="'.esc_attr( $content_atts['icon'] ).'"></i>';
					elseif( $content_atts['icon_multiplier'] == '5' ) :
						echo '<i class="'.esc_attr( $content_atts['icon'] ).'"></i>&nbsp;<i class="'.esc_attr( $content_atts['icon'] ).'"></i>&nbsp;<i class="'.esc_attr( $content_atts['icon'] ).'"></i>&nbsp;<i class="'.esc_attr( $content_atts['icon'] ).'"></i>&nbsp;<i class="'.esc_attr( $content_atts['icon'] ).'"></i>';
					else :
						echo '<i class="'.esc_attr( $content_atts['icon'] ).'"></i>';
					endif;
				?>
			</span>
		</div>
	<?php elseif( $content == 'title_option' ) : ?>
		<div class="sh-divider-content">
			<span class="sh-divider-title">
				<?php echo jevelin_remove_p( wp_kses_post( $content_atts['title'] ) ); ?>
			</span>
		</div>
	<?php elseif( $content == 'title_box_option' ) : ?>
		<div class="sh-divider-content">
			<span class="sh-divider-title-box">
				<?php echo jevelin_remove_p( wp_kses_post( $content_atts['title_box'] ) ); ?>
			</span>
		</div>
	<?php else : ?>
		<div class="sh-divider-line"></div>
	<?php endif; ?>
</div>
