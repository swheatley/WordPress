<?php
/**
 * Single Product Sale Flash
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

?>
<?php if ( $product->is_on_sale() ) : ?>

	<?php
		if ( $product->is_in_stock() ) {
			echo apply_filters( 'woocommerce_sale_flash', '<span class="sh-popover-mini">' . esc_html__( 'Sale!', 'jevelin' ) . '</span>', $post, $product );
		} else {
			echo apply_filters( 'woocommerce_sale_flash', '<span class="sh-popover-mini sh-popover-mini-dark">' . esc_html__( 'Sold out', 'jevelin' ) . '</span>', $post, $product );
		}
	?>
	
<?php endif; ?>
