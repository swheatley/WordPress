<?php
/**
 * Portfolio Taxonomy
 */

$term_id = get_queried_object()->term_id;
get_header(); ?>
	<div id="content">

		<div class="sh-portfolio sh-portfolio-columns3 sh-portfolio-style-default-shadow">
			<?php
			$portfolio_items = new WP_Query(array(
				'post_type' => 'fw-portfolio',
				'post_status' => 'publish',
				'posts_per_page' => 9999,
				'tax_query' => array(
					array(
						'taxonomy' => 'fw-portfolio-category',
						'field' => 'id',
						'terms' => intval($term_id),
					)
				),
			));
			while ( $portfolio_items->have_posts() ) : $portfolio_items->the_post(); ?>

				<div class="sh-portfolio-item sh-portfolio-default-shadow sh-portfolio-overlay-style-overlay4">

					<div class="sh-portfolio-image">
						<div class="sh-portfolio-image-position">
							<img class="sh-portfolio-img" src="<?php echo jevelin_get_thumb( get_the_ID(), 'post-thumbnail' ); ?>" alt="" />
						</div>
						<div class="sh-portfolio-overlay sh-portfolio-overlay4">
							<div class="sh-portfolio-overlay4-container">
								<div class="sh-portfolio-overlay4-icons sh-table">

					                <a href="<?php the_permalink(); ?>" class="sh-overlay-item sh-table-cell">
					                    <div class="sh-overlay-item-container">
					                        <i class="icon-link"></i>
					                    </div>
					                </a>
					                <a href="<?php echo jevelin_get_thumb( get_the_ID(), 'large' ); ?>" class="sh-overlay-item sh-table-cell" rel="lightbox">
					                    <div class="sh-overlay-item-container">
					                        <i class="icon-magnifier-add"></i>
					                    </div>
					                </a>

								</div>
							</div>
						</div>
					</div>
					<div class="sh-portfolio-content-container">
						<a href="<?php the_permalink(); ?>">
							<h3 class="sh-portfolio-title">
								<?php the_title(); ?>
							</h3>
						</a>

						<div class="sh-portfolio-description">
							<?php echo jevelin_get_excerpt( 15, get_the_content() ); ?>
						</div>
					</div>

				</div>
			<?php endwhile; ?>
		</div>

	</div>
<?php get_footer(); ?>
