<?php
/*-----------------------------------------------------------------------------------*/
/* WooCommerce Categories HTML
/*-----------------------------------------------------------------------------------*/
?>
<div class="sh-woocommerce-categories" id="woocommerce-categories-<?php echo esc_attr( $atts['id'] ); ?>" data-id="<?php echo intval( $atts['columns'] ); ?>">
	<div class="row">
		<?php
		$categories_query = array();
		if( isset($atts['categories']) && count($atts['categories']) > 0 ) :
			$categories_query = $atts['categories'];
		endif;
		$order = ( isset($atts['order']) && $atts['order'] ) ? esc_attr( $atts['order'] ) : 'desc';

		$columns = 'col-md-6 col-sm-6';
		if( $atts['columns'] == 3 && count( $categories_query ) > 2 ) :
			$columns = 'col-md-4 col-sm-4';
		endif;

		$categories = get_categories( array( 'taxonomy' => 'product_cat', 'include' => $categories_query, 'orderby' => $order, 'empty' => 1 ) );
		foreach( $categories as $cat ) :
			$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
			$image = wp_get_attachment_url( $thumbnail_id ); ?>

			<div class="<?php echo esc_attr( $columns ); ?> sh-woocommerce-categories-item">
				<a href="<?php echo get_term_link( $cat->slug, 'product_cat' ); ?>">
					<div class="sh-ratio">
			            <div class="sh-ratio-container">
			                <div class="sh-ratio-content sh-woocommerce-categories-content">
								<div class="sh-woocommerce-categories-thumb" style="background-image: url(<?php echo esc_url( $image ); ?>);"></div>
								<h3>
									<?php echo esc_attr( $cat->name ); ?> <span class="sh-woocommerce-categories-count"><?php echo esc_attr( $cat->count ); ?></span>
								</h3>
			                </div>
			            </div>
			        </div>
				</a>
			</div>

		<?php endforeach; ?>
	</div>
</div>
