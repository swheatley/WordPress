<?php
/* Template Name: Blog */
get_header();

if( jevelin_post_option( get_the_ID(), 'page_layout' ) == 'sidebar-right' || jevelin_post_option( get_the_ID(), 'page_layout' ) == 'sidebar-left' ) :
	$layout_sidebar = esc_attr( jevelin_post_option( get_the_ID(), 'page_layout' ) );
endif;

$categories_query = array();
if( count(jevelin_post_option( get_the_ID(), 'page_blog_category' )) > 0 ) :
	$categories_query = jevelin_post_option( get_the_ID(), 'page_blog_category' );
endif;
$categories_tabs = $categories_query;
if( !count($categories_tabs) ) :
	$categories_tabs = get_terms( array(
	    'taxonomy' => 'category',
	    'hide_empty' => false,
		'fields' => 'ids'
	));
endif;

$this_category = ( isset($_GET['category']) && $_GET['category'] ) ? esc_attr($_GET['category']) : '';
?>

<?php if( jevelin_post_option( get_the_ID(), 'page_blog_categories_tab' ) == 'on' ) : ?>
	<div class="sh-filter-blog sh-filter-container sh-portfolio-filter-style3 sh-portfolio-filter-style4">
		<div class="sh-filter">
			<span class="sh-filter-item<?php echo ( !$this_category ) ? ' active' : ''; ?>">
				<a href="<?php echo esc_url( get_the_permalink() )?>" class="sh-filter-item-content">All</a>
			</span>

			<?php foreach( $categories_tabs as $category_id ) :
				$category = get_term_by('id', $category_id, 'category');
				if( $category->count > 0 ) : ?>

				<span class="sh-filter-item<?php echo ( $this_category == $category->slug ) ? ' active' : ''; ?>">
					<a href="<?php echo esc_url( add_query_arg( 'category', esc_attr( $category->slug ), get_the_permalink() ) ); ?>" class="sh-filter-item-content">
						<?php echo esc_attr( $category->name ); ?>
					</a>
				</span>

			<?php endif; endforeach; ?>
		</div>
	</div>
<?php endif; ?>

	<div id="content" class="<?php if( isset($layout_sidebar) && $layout_sidebar ) : ?>content-with-<?php echo esc_attr( $layout_sidebar ); endif; ?>">
		<div class="sh-group blog-list blog-style-<?php echo jevelin_post_option( get_the_ID(), 'page-blog-style', 'large' ); ?>">
			<?php
				if( is_front_page() ) {
					$page = (get_query_var('page')) ? get_query_var('page') : 1;
				} else {
					$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
				}

				$cat_att = 'category__in';
				$cat_var = $categories_query;
				if( $this_category ) {
					$cat_att = 'category_name';
					$cat_var = esc_attr( $this_category );
				}

				$blog_post_per_page = jevelin_option( 'blog-items', 12 );
				$posts = new WP_Query( array('post_type' => 'post', 'paged' => $page, $cat_att => $cat_var, 'posts_per_page' => $blog_post_per_page ) );
				if( count($posts) > 0 ) :

					while ( $posts->have_posts() ) : $posts->the_post();

						if( get_post_format() ) :
							get_template_part( 'content', 'format-'.get_post_format() );
						else :
							get_template_part( 'content' );
						endif;

					endwhile;

				else :

					get_template_part( 'content', 'none' );

				endif;
			?>
		</div>

		<?php jevelin_pagination( $posts ); ?>

	</div>
	<?php if( isset($layout_sidebar) && $layout_sidebar ) : ?>
		<div id="sidebar" class="<?php echo esc_attr( $layout_sidebar ); ?>">
			<?php get_sidebar(); ?>
		</div>
	<?php endif; ?>


<?php get_footer(); ?>
