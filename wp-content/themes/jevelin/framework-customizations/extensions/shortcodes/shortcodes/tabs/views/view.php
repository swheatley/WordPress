<?php
/*-----------------------------------------------------------------------------------*/
/* Tabs HTML
/*-----------------------------------------------------------------------------------*/
if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
?>

<div id="tabs-<?php echo esc_attr( $atts['id'] ); ?>" class="sh-tabs sh-tabs-<?php echo esc_attr( $atts['style'] ); ?>">
	<!-- Tabs -->
	<ul class="nav nav-tabs sh-tabs-filter sh-noselect" role="tablist">
		<?php $i = 0;
		foreach( $atts['tabs'] as $item ) :
			$i++;
			$id = 'tab-'. $atts['id'] .'-'.$i;
		?>
			<li role="presentation" class="<?php echo ($i == 1) ? ' active' : ''; ?>">
				<a href="#<?php echo esc_attr( $id ); ?>" role="tab" data-toggle="tab">
					<?php if( isset($item['icon']) && $item['icon'] ) : ?>
						<span class="sh-tabs-icon">
							<i class="<?php echo esc_attr( $item['icon'] ); ?>"></i>
						</span>
					<?php endif; ?>

					<?php echo esc_attr( $item['title'] ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>

	<!-- Content -->
	<div class="tab-content">
		<?php $i = 0;
		foreach( $atts['tabs'] as $item ) :
			$i++;
			$id = 'tab-'.esc_attr( $atts['id'] ).'-'.$i;
		?>
			<div role="tabpanel" class="tab-pane fade<?php echo ($i == 1) ? ' in active' : ''; ?>" id="<?php echo esc_attr( $id ); ?>">
				<?php echo do_shortcode( $item['content'] ); ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>