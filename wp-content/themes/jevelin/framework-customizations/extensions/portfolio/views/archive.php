<?php
/**
 * Portfolio Archive posts
 */
/*if( jevelin_post_option( get_the_ID(), 'page_layout' ) == 'sidebar-right' || jevelin_post_option( get_the_ID(), 'page_layout' ) == 'sidebar-left' ) :
	$layout_sidebar = esc_attr( jevelin_post_option( get_the_ID(), 'page_layout' ) );
endif;

$class = '';
if( function_exists('fw_ext_page_builder_is_builder_post') && !fw_ext_page_builder_is_builder_post( get_queried_object_id() ) ) {
	$class = ' page-default-content';
}*/
	wp_reset_postdata();
	$portfolio1 = get_page_by_path( 'portfolio' );
	$portfolio2 = get_page_by_path( 'portfolio-page' );
	$custom_portfolio_page = jevelin_option( 'portfolio_main_page' );

	if( $custom_portfolio_page > 0 && is_string( get_post_status( $custom_portfolio_page ) ) ) :
		wp_redirect( get_the_permalink( $custom_portfolio_page ) );
	else :
		if( get_the_ID() != $portfolio1->ID && get_the_ID() != $portfolio1->ID ) :
			if( isset( $portfolio1->ID ) && $portfolio1->ID > 0 ) :
				wp_redirect( get_the_permalink( $portfolio1->ID ) );
			elseif( isset( $portfolio2->ID ) && $portfolio2->ID > 0 ) :
				wp_redirect( get_the_permalink( $portfolio2->ID ) );
			else :
				wp_redirect( get_home_url( '/' ) );
			endif;
		else :
			wp_redirect( get_home_url( '/' ) );
		endif;
	endif;
exit;

/*
get_header(); ?>

	<div id="content" class="page-content <?php if( isset($layout_sidebar) && $layout_sidebar ) : ?>content-with-<?php echo esc_attr( $layout_sidebar ); endif; ?><?php echo esc_attr( $class ); ?>">

		<?php
			while ( have_posts() ) : the_post();
				the_content();
			endwhile;
			wp_reset_postdata();
		?>

		<div class="sh-clear"></div>

		<?php
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

			if ( is_singular() ) :
				wp_enqueue_script( 'comment-reply' );
			endif;
		?>

	</div>
	<?php if( isset($layout_sidebar) && $layout_sidebar ) : ?>
		<div id="sidebar" class="<?php echo esc_attr( $layout_sidebar ); ?>">
			<?php get_sidebar(); ?>
		</div>
	<?php endif; ?>

<?php get_footer(); ?>
*/
