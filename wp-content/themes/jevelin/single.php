<?php 
/**
 * Single Post
 */
if( defined('FW') ) :
	$elements = jevelin_option( 'post_elements' );
	if( jevelin_option( 'post_layout' ) == 'sidebar-left' || jevelin_option( 'post_layout' ) == 'sidebar-right' ) :
		$layout_sidebar = esc_attr( jevelin_option( 'post_layout' ) );
	endif;
else :
	$layout_sidebar = 'sidebar-right';
endif;

get_header();
?>

<div id="content" class="<?php if( isset($layout_sidebar) && $layout_sidebar ) : ?>content-with-<?php echo esc_attr( $layout_sidebar ); endif; ?>">
	<div class="blog-single blog-style-large">
		<?php
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();

					get_template_part( 'content', 'format-'.get_post_format() ); ?>


					<?php /* Clear unclosed floats */ ?>
					<div class="sh-clear"></div>


					<?php /* Show page links navigation */ ?>
					<?php jevelin_page_links(); ?>


					<?php /* Show Tags */ ?>
					<?php if( count( wp_get_post_tags( get_the_ID() ) ) > 0 ) : ?>
						<div class="sh-blog-tags">
							<h5><?php esc_html_e( 'Tags In', 'jevelin' ); ?></h5>
							<div class="sh-blog-tags-list">
								<?php foreach( get_the_tags( get_the_ID() ) as $tag ) :
									$term_link = get_tag_link( $tag->term_id );
								?>
									<a href="<?php echo esc_url( $term_link ); ?>" class="sh-blog-tag-item">
										<?php echo esc_attr( $tag->name ); ?>
									</a>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>

					
					<div class="sh-blog-single-meta row">
						<div class="col-md-6 col-sm-6 col-xs-6">
							
							<?php /* Show social share */ ?>
							<?php if( !defined('FW') || ( isset($elements['share']) && $elements['share'] == true ) ) : ?>
								<div class="sh-blog-social">
									<?php jevelin_share(); ?> 
								</div>
							<?php endif; ?>

						</div>
						<div class="col-md-6 col-sm-6">
							
							<?php /* Show next / previous post links */ ?>
							<?php if( !defined('FW') || ( isset($elements['prev_next']) && $elements['prev_next'] == true ) ) :
									$prev_post = get_previous_post();
									$next_post = get_next_post();
									$page_switcher = '<div class="sh-page-switcher">';

									if( isset($prev_post->ID) && get_permalink($prev_post->ID) ) :
										$page_switcher.= '<a class="sh-page-switcher-button" href="'.esc_url( get_permalink($prev_post->ID) ).'"><i class="ti-arrow-left"></i></a>';
									else :
										$page_switcher.= '<a class="sh-page-switcher-button sh-page-switcher-disabled" href="#"><i class="ti-arrow-left"></i></a>';
									endif;

									$page_switcher.= '<span class="sh-page-switcher-content">'.jevelin_count_posts().'</span>';

									if( isset($next_post->ID) && get_permalink($next_post->ID) ) :
										$page_switcher.= '<a class="sh-page-switcher-button" href="'.esc_url( get_permalink($next_post->ID) ).'"><i class="ti-arrow-right"></i></a>';
									else :
										$page_switcher.= '<a class="sh-page-switcher-button sh-page-switcher-disabled" href="#"><i class="ti-arrow-right"></i></a>';
									endif;

									$page_switcher.= '</div>';
									echo wp_kses_post( $page_switcher );
							endif; ?>

						</div>
					</div>


					<?php /* Show information about author */ ?>
					<?php if( ( !defined('FW') || ( isset($elements['athor_box']) && $elements['athor_box'] == true ) ) && get_the_author_meta( 'description' ) ) : ?>
						<div class="sh-post-author sh-table">
							<div class="sh-post-author-avatar sh-table-cell-top">
								<?php echo get_avatar( get_the_author_meta( 'ID' ), '185' ); ?>
							</div>
							<div class="sh-post-author-info sh-table-cell-top">
								<h4><?php the_author(); ?></h4>
								<div><?php the_author_meta( 'description' ); ?></div>
							</div>
						</div>
					<?php endif; ?>


				<?php endwhile;

				/* Show comments */
				if( !defined('FW') || ( isset($elements['comments']) && $elements['comments'] == true ) ) :
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

					if ( is_singular() ) :
						wp_enqueue_script( 'comment-reply' );
					endif;
				endif;

				else :
					get_template_part( 'content', 'none' );
				endif;
			?>

		</div>
	</div>
	<?php if( isset($layout_sidebar) && $layout_sidebar ) : ?>
		<div id="sidebar" class="<?php echo esc_attr( $layout_sidebar ); ?>">
			<?php get_sidebar(); ?>
		</div>
	<?php endif; ?>

<?php get_footer(); ?>
