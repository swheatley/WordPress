<?php
/*-----------------------------------------------------------------------------------*/
/* Portfolio HTML
/*-----------------------------------------------------------------------------------*/

if( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
if( function_exists('fw_ext_portfolio_get_gallery_images') ) :
	$ext_portfolio_instance = fw()->extensions->get( 'portfolio' );
	$ext_portfolio_settings = $ext_portfolio_instance->get_settings();
	$portfolio_categories_url = $ext_portfolio_settings['taxonomy_slug'];
	$page_link = ( isset( $atts['page_link'] ) && $atts['page_link'] == true ) ? true : false;
?>


<div id="portfolio-fancy-filter-<?php echo esc_attr( $atts['id'] ); ?>" class="sh-filter-container sh-filter-fancy-container sh-portfolio-filter-<?php echo esc_attr( $atts['filter'] ); ?> sh-portfolio-filter-alignment-<?php echo esc_attr( $atts['filter_alignment'] ); ?> sh-portfolio-filter-mobile-alignment-<?php echo esc_attr( $atts['filter_mobile_alignment'] ); ?>">
	<?php if( $atts['filter_icon'] ) : ?>
		<div class="sh-filer-icon">
			<i class="<?php echo esc_attr( $atts['filter_icon'] ); ?>"></i>
		</div>
	<?php endif; ?>

	<div class="sh-filter" id="filter-<?php echo esc_attr( $atts['id'] ); ?>">
		<span class="sh-filter-item active" data-filter="*">
			<div class="sh-filter-item-content"><?php esc_html_e( 'All', 'jevelin' ); ?></div>
		</span>
		<?php foreach( get_terms('fw-portfolio-category') as $cat ) : ?>
			<span class="sh-filter-item" data-filter=".category-<?php echo esc_js( $cat->slug ); ?>">
				<div class="sh-filter-item-content"><?php echo esc_attr( $cat->name ); ?></div>
			</span>
		<?php endforeach; ?>
	</div>
</div>

<div id="portfolio-fancy-<?php echo esc_attr( $atts['id'] ); ?>" class="sh-portfolio-fancy sh-portfolio-fancy-columns<?php echo esc_attr( $atts['columns'] ); ?>">
	<?php
	$categories_query = array();
	if( count($atts['categories']) > 0 ) :
		$categories_query[] = array(
			'taxonomy' => 'fw-portfolio-category',
			'field' => 'id',
			'terms' => $atts['categories']
		);
	endif;

	if( $atts['image_ratio'] == 'landscape' ) :
		$image_ratio = 'post-thumbnail';
	elseif( $atts['image_ratio'] == 'portrait' ) :
		$image_ratio = 'jevelin-portrait';
	elseif( $atts['image_ratio'] == 'square' ) :
		$image_ratio = 'jevelin-square';
	else :
		$image_ratio = 'large';
	endif;

	$orderby = ( isset($atts['order_by']) && $atts['order_by'] ) ? esc_attr( $atts['order_by'] ) : 'post_date';
	$order = ( isset($atts['order']) && $atts['order'] ) ? esc_attr( $atts['order'] ) : 'desc';
	$limit = ( is_numeric($atts['limit']) ) ? intval( $atts['limit'] ) : 6;

	$loop = new WP_Query( array( 'post_type' => 'fw-portfolio', 'order' => 'DESC', 'posts_per_page' => $limit, 'tax_query' => $categories_query, 'orderby' => $orderby, 'order' => $order ) );
	while ( $loop->have_posts() ) : $loop->the_post(); ?>

		<?php
			$categories = wp_get_post_terms( get_the_ID(), 'fw-portfolio-category', array("fields" => "names"));
			$categories2 = wp_get_post_terms( get_the_ID(), 'fw-portfolio-category', array("fields" => "all"));
			$item_category = '';
			foreach($categories2 as $category) :
				$item_category.= ' category-'.esc_attr( $category->slug );
			endforeach;
		?>

		<div class="sh-portfolio-fancy-item<?php echo esc_attr( $item_category ); ?>" id="portfolio-<?php echo get_the_ID(); ?>">
			<div class="sh-portfolio-fancy-itemc-container">
				<img class="sh-portfolio-img" src="<?php echo jevelin_get_thumb( get_the_ID(), $image_ratio ); ?>" alt="" />

				<a href="<?php the_permalink(); ?>" class="sh-portfolio-fancy-item-overlay-bg"></a>
				<div class="sh-portfolio-fancy-item-overlay">
					<div class="sh-portfolio-fancy-item-overlay-container">
						<a href="<?php the_permalink(); ?>" class="sh-portfolio-fancy-item-overlay-title">
							<h3><?php the_title(); ?></h3>
						</a>
						<div class="sh-portfolio-fancy-item-overlay-categories">
							<?php
								foreach($categories2 as $category) :
									echo '<a href="'.esc_attr( get_site_url( get_current_blog_id() ) ).'/'.esc_attr( $portfolio_categories_url ).'/'.esc_attr( $category->slug ).'/" class="sh-portfolio-category sh-heading-font">'.esc_attr( $category->name ).'</a>';
									if( $category !== end($categories2) ) :
										echo '<span>,</span> ';
									endif;
								endforeach;
							?>
						</div>
						<a href="<?php echo jevelin_get_thumb( get_the_ID(), $image_ratio ); ?>" rel="lightbox" class="sh-portfolio-fancy-item-overlay-lightbox">
							<i class="icon icon-size-fullscreen"></i>
						</a>
					</div>
				</div>
			</div>
		</div>

	<?php endwhile; ?>
</div>
<?php endif; ?>
