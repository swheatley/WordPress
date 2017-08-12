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

<?php if( $atts['filter'] != 'none' ) : ?>
	<div class="sh-filter-container sh-portfolio-filter-<?php echo esc_attr( $atts['filter'] ); ?>">
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
<?php endif; ?>

<div id="portfolio-<?php echo esc_attr( $atts['id'] ); ?>" class="sh-portfolio sh-portfolio-columns<?php echo esc_attr( $atts['columns'] ); ?> sh-portfolio-style-<?php echo esc_attr( $atts['style'] ); ?>">
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
				$item_category.= 'category-'.esc_attr( $category->slug ).' ';
			endforeach;
		?>

		<div class="<?php echo esc_attr( $item_category ); ?>sh-portfolio-item sh-portfolio-<?php echo esc_attr( $atts['style'] ); ?> sh-portfolio-overlay-style-<?php echo esc_attr( $atts['overlay'] ); ?>">

			<?php if( jevelin_get_thumb( get_the_ID(), $image_ratio ) ) : ?>
				<div class="sh-portfolio-image">
					<div class="sh-portfolio-image-position">
						<?php if( $atts['image_ratio'] == 'square' ) : ?>
							<?php echo jevelin_image_ratio( get_the_ID(), 'jevelin-square' ); ?>
						<?php else : ?>
							<img class="sh-portfolio-img" src="<?php echo jevelin_get_thumb( get_the_ID(), $image_ratio ); ?>" alt="" />
						<?php endif; ?>
					</div>

					<?php if( $atts['style'] == 'default2' ) : ?>
						<div class="sh-portfolio-title-container">
							<h3 class="sh-portfolio-title">
								<?php the_title(); ?>
							</h3>
						</div>
					<?php endif; ?>

					<?php if( $atts['overlay'] != 'overlay4' && $atts['overlay'] != 'overlay4 overlay5' ) : ?>
						<?php if( $page_link ) : ?>
							<a href="<?php the_permalink(); ?>" class="sh-portfolio-overlay sh-portfolio-<?php echo esc_attr( $atts['overlay'] ); ?>">
						<?php endif; ?>
					<?php else : ?>
						<div class="sh-portfolio-overlay sh-portfolio-<?php echo esc_attr( $atts['overlay'] ); ?>">
					<?php endif; ?>

						<?php if( $atts['overlay'] != 'none') : ?>
							<?php if( $atts['overlay'] == 'overlay4' || $atts['overlay'] == 'overlay4 overlay5' ) : ?>

								<div class="sh-portfolio-overlay4-container">

									<?php if( $atts['overlay'] != 'overlay4 overlay5') : ?>
										<div class="sh-portfolio-overlay4-title">
											<?php the_title(); ?>
										</div>
										<div class="sh-portfolio-overlay4-categories">
											<?php
												foreach($categories2 as $category) :
													echo '<a href="'.esc_attr( get_home_url('/') ).'/'.esc_attr( $portfolio_categories_url ).'/'.esc_attr( $category->slug ).'/" class="sh-portfolio-category">'.esc_attr( $category->name ).'</a>';
													if( $category !== end($categories) ) :
														echo '<span class="sh-whitespace-small"></span>';
													endif;
												endforeach;
											?>
										</div>
									<?php endif; ?>

									<div class="sh-portfolio-overlay4-icons sh-table">

										<?php if( $page_link ) : ?>
							                <a href="<?php the_permalink(); ?>" class="sh-overlay-item sh-table-cell">
							                    <div class="sh-overlay-item-container">
							                        <i class="icon-link"></i>
							                    </div>
							                </a>
						                <?php endif; ?>

						                <a href="<?php echo jevelin_get_thumb( get_the_ID(), $image_ratio ); ?>" class="sh-overlay-item sh-table-cell" rel="lightbox">
						                    <div class="sh-overlay-item-container">
						                        <i class="icon-magnifier-add"></i>
						                    </div>
						                </a>

									</div>
								</div>

							<?php elseif( $atts['overlay'] == 'overlay3') : ?>

								<div class="sh-portfolio-overlay3-data">
									<div class="sh-portfolio-overlay3-title">
										<?php the_title(); ?>
									</div>
									<?php echo jevelin_get_excerpt( 10, get_the_excerpt() ); ?>

									<div class="sh-portfolio-overlay3-bar">
										<div class="sh-table">
											<div class="sh-portfolio-overlay1-icon sh-table-cell">
												<i class="icon-link"></i>
											</div>
											<div class="sh-portfolio-overlay1-categories sh-table-cell">
												<?php
													foreach($categories as $category) :
														echo '<span class="sh-portfolio-category">'.esc_attr( $category ).'</span>';
														if($category !== end($categories)) :
															echo '<span class="sh-whitespace-small"></span>';
														endif;
													endforeach;
												?>
											</div>
										</div>
									</div>
								</div>

							<?php elseif( $atts['overlay'] == 'overlay2') : ?>

								<div class="sh-portfolio-overlay2-data">
									<div class="sh-portfolio-overlay2-title">
										<?php the_title(); ?>
									</div>
									<?php echo jevelin_get_excerpt( 10, get_the_excerpt() ); ?>
								</div>

								<div class="sh-portfolio-overlay2-bar">
									<div class="sh-table">
										<div class="sh-portfolio-overlay1-icon sh-table-cell">
											<i class="icon-link"></i>
										</div>
										<div class="sh-portfolio-overlay1-categories sh-table-cell">
											<?php
												foreach($categories as $category) :
													echo '<span class="sh-portfolio-category">'.esc_attr( $category ).'</span>';
													if($category !== end($categories)) :
														echo '<span class="sh-whitespace-small"></span>';
													endif;
												endforeach;
											?>
										</div>
									</div>
								</div>

							<?php else : ?>

								<div class="sh-portfolio-overlay1-bar">
									<div class="sh-table">
										<div class="sh-portfolio-overlay1-icon sh-table-cell">
											<i class="icon-link"></i>
										</div>
										<div class="sh-portfolio-overlay1-categories sh-table-cell">
											<?php
												foreach($categories as $category) :
													echo '<span class="sh-portfolio-category">'.esc_attr( $category ).'</span>';
													if($category !== end($categories)) :
														echo '<span class="sh-whitespace-small"></span>';
													endif;
												endforeach;
											?>
										</div>
									</div>
								</div>

							<?php endif; ?>
						<?php endif; ?>


					<?php if( $atts['overlay'] != 'overlay4' && $atts['overlay'] != 'overlay4 overlay5' ) : ?>
						</a>
					<?php else : ?>
						</div>
					<?php endif; ?>


				</div>
			<?php endif; ?>

			<?php if( $atts['style'] == 'default' || $atts['style'] == 'default-shadow' || $atts['style'] == 'default2' ) : ?>

				<div class="sh-portfolio-content-container">
					<?php if( $atts['style'] == 'default' || $atts['style'] == 'default-shadow' ) : ?>
						<?php if( $page_link ) : ?>
							<a href="<?php the_permalink(); ?>">
								<h3 class="sh-portfolio-title">
									<?php the_title(); ?>
								</h3>
							</a>
						<?php else : ?>
							<a>
								<h3 class="sh-portfolio-title">
									<?php the_title(); ?>
								</h3>
							</a>
						<?php endif; ?>
					<?php endif; ?>

					<div class="sh-portfolio-description">
						<?php echo get_the_excerpt(); ?>
					</div>
				</div>

			<?php endif; ?>

			<?php if( $atts['style'] == 'minimalistic' ) : ?>
				<div class="sh-portfolio-content-container sh-columns">
					<div>
						<?php if( $page_link ) : ?>
							<a href="<?php the_permalink(); ?>">
								<h3 class="sh-portfolio-title">
									<?php the_title(); ?>
								</h3>
							</a>
						<?php else : ?>
							<a>
								<h3 class="sh-portfolio-title">
									<?php the_title(); ?>
								</h3>
							</a>
						<?php endif; ?>
					</div>
					<div>
						<div class="sh-portfolio-categories">
							<?php $i = 0;
								foreach($categories as $category) :
									if( $i == 0 ) :
										echo '<span class="sh-portfolio-category">'.esc_attr( $category ).'</span>';
										$i++;
									endif;
								endforeach;
							?>
						</div>
					</div>
				</div>
			<?php endif; ?>

		</div>
	<?php endwhile; ?>
</div>
<?php endif; ?>
