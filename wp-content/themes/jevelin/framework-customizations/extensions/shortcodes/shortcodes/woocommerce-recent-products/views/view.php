<?php
/*-----------------------------------------------------------------------------------*/
/* Accordion HTML
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
$class = '';
if( isset( $atts['carousel'] ) && $atts['carousel'] == true ) :
	$class = ' sh-recent-products-carousel';
endif;

$class2 = '';
if( isset( $atts['style'] ) && $atts['style'] == 'style2' ) :
	$class2 = 'sh-woocommerce-products-style2';
endif;
?>

<div class="sh-woocommerce-products<?php echo esc_attr($class); ?>" id="woocommerce-products-<?php echo esc_attr( $atts['id'] ); ?>" data-id="<?php echo intval( $atts['columns'] ); ?>">

	<?php if( $atts['filter'] != 'none' ) : ?>
		<div class="sh-filter-container sh-portfolio-filter-<?php echo esc_attr( $atts['filter'] ); ?>">
			<div class="sh-filter" id="filter-<?php echo esc_attr( $atts['id'] ); ?>" data-type="woocommerce">
				<span class="sh-filter-item active" data-filter="*">
					<div class="sh-filter-item-content"><?php esc_html_e( 'All', 'jevelin' ); ?></div>
				</span>
				<?php foreach( get_terms('product_cat') as $cat ) : ?>
					<span class="sh-filter-item" data-filter=".product_cat-<?php echo esc_js( $cat->slug ); ?>">
						<div class="sh-filter-item-content"><?php echo esc_attr( $cat->name ); ?></div>
					</span>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="<?php echo esc_attr( $class2 ); ?>">
		<?php
			if ( class_exists( 'WooCommerce' ) ) :
				echo do_shortcode( '[recent_products per_page="'.esc_attr( $atts['per_page'] ).'" columns="'.esc_attr( $atts['columns'] ).'" orderby="'.esc_attr( $atts['order_by'] ).'" order="'.esc_attr( $atts['order'] ).'"]' );
			endif;
		?>
	</div>
</div>
