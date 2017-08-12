<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

/**
 * @var $instance
 * @var $before_widget
 * @var $after_widget
 * @var $title
 */


?>

<?php if ( ! empty( $instance ) ) : ?>
	<?php
		$elements = jevelin_option( 'post_elements' );
		echo wp_kses_post( $before_widget );
	?>
	<div class="wrap-recent-posts">
		<?php echo wp_kses_post( $title ); ?>
		<div class="sh-recent-posts-widgets">
			<?php
			$limit = ( $params['items_per_page'] > 0 ) ? intval( $params['items_per_page'] ) : 3;
			$posts = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => $limit ) );
			if( count($posts) > 0 ) :
				while ( $posts->have_posts() ) : $posts->the_post(); ?>

					<div class="sh-recent-posts-widgets-item">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="sh-recent-posts-widgets-item-thumb">
								<a href="<?php echo esc_url( get_permalink() ); ?>">
									<?php echo jevelin_image_ratio( get_the_ID(), 'thumbnail' ); ?>

									<div class="sh-mini-overlay">
										<div class="sh-mini-overlay-container">
											<div class="sh-table-full">
												<div class="sh-table-cell">
													<i class="icon-link"></i>
												</div>
											</div>
										</div>
									</div>

									<div class="sh-recent-posts-widgets-count">
										<?php echo get_comments_number( '0', '1', '%' ); ?>
									</div>
								</a>
							</div>
							<div class="sh-recent-posts-widgets-item-content">
						<?php endif; ?>

							<?php if( jevelin_option( 'blog_style', 'style1' ) == 'style2' ) : ?>

								<span class="post-meta-categories">
						            <?php echo jevelin_show_categories(); ?>
						        </span>

								<a href="<?php echo esc_url( get_permalink() ); ?>">
									<h6><?php echo get_the_title(); ?></h6>
								</a>

							<?php else : ?>
								<a href="<?php echo esc_url( get_permalink() ); ?>">
									<h6><?php echo get_the_title(); ?></h6>
								</a>
								<div class="sh-recent-posts-widgets-item-meta">
							        <?php esc_html_e( 'By', 'jevelin' ); ?>
							        <a href="<?php echo esc_url( home_url('/') ); ?>author/<?php the_author_meta('user_url'); ?>" class="post-meta-author">
							            <?php echo get_the_author(); ?>
							        </a>
								</div>
							<?php endif; ?>

						<?php if ( has_post_thumbnail() ) : ?>
							</div>
						<?php endif; ?>
					</div>

				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
	<?php echo wp_kses_post( $after_widget ); ?>
<?php endif; ?>
