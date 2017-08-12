<?php
/**
 * Post format - Video
 */

if( !isset($style) ) :
	$style = jevelin_post_option( get_queried_object_id(), 'page-blog-style' );
endif;

/* Layout for masonry style */
if ( $style == 'masonry' || $style == 'masonry masonry-shadow' ) :
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
		<div class="post-container">
			<?php jevelin_popover( jevelin_post_option( get_the_ID(), 'post-popover' ) ); ?>

			<?php if( jevelin_post_option( get_the_ID(), 'post-video' ) ) : ?>
				<div class="post-meta-video">
					<div class="ratio-container">
						<div class="ratio-content">
							<?php echo wp_oembed_get( jevelin_post_option( get_the_ID(), 'post-video' ) ); ?>
						</div>
					</div>
				</div>
			<?php else : ?>
				<div class="post-meta-thumb"></div>
			<?php endif; ?>

			<div class="post-content-container">
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="post-title">
					<h2>
						<?php jevelin_sticky_post(); ?>
						<?php the_title(); ?>
					</h2>
				</a>

				<div class="post-meta post-meta-one">
					<?php jevelin_meta_one(); ?>
				</div>

				<div class="post-content">
					<?php the_excerpt(); ?>
				</div>

				<div class="post-meta post-meta-two">
					<?php jevelin_meta_two(); ?>
				</div>
			</div>

		</div>
	</article>

	<?php
		/* Layout for Masonry version 2 */
		elseif( $style == 'masonry masonry2' ) :
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
		<div class="post-container">
			<?php jevelin_popover( jevelin_post_option( get_the_ID(), 'post-popover' ) ); ?>

			<?php if( jevelin_post_option( get_the_ID(), 'post-video' ) ) : ?>
				<div class="post-meta-video">
					<div class="ratio-container">
						<div class="ratio-content">
							<?php echo wp_oembed_get( jevelin_post_option( get_the_ID(), 'post-video' ) ); ?>
						</div>
					</div>
				</div>
			<?php else : ?>
				<div class="post-meta-thumb"></div>
			<?php endif; ?>

			<div class="post-content-container">

				<div class="post-meta post-meta-one">
					<?php jevelin_meta_one(); ?>
				</div>

				<a href="<?php echo esc_url( get_permalink() ); ?>" class="post-title">
					<h2>
						<?php jevelin_sticky_post(); ?>
						<?php the_title(); ?>
					</h2>
				</a>

				<div class="post-content">
					<?php if( jevelin_option( 'post_desc', 45 ) == 45 ) : ?>
						<?php echo wp_trim_words( get_the_content() , '17' ); ?>
					<?php else : ?>
						<?php echo wp_trim_words( get_the_content() , esc_attr( jevelin_option( 'post_desc', 45 ) ) ); ?>
					<?php endif; ?>
				</div>

				<div class="post-meta post-meta-two">
					<?php jevelin_meta_two( 0, 'icon icon-bubble' ); ?>
				</div>
			</div>

		</div>
	</article>


<?php
	/* Layout for grid style */
	elseif( $style == 'grid' ) :
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
		<div class="post-container">
			<?php jevelin_popover( jevelin_post_option( get_the_ID(), 'post-popover' ) ); ?>

			<?php if( jevelin_post_option( get_the_ID(), 'post-video' ) ) : ?>
				<div class="post-meta-video">
					<div class="ratio-container">
						<div class="ratio-content">
							<?php echo wp_oembed_get( jevelin_post_option( get_the_ID(), 'post-video' ) ); ?>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<a href="<?php echo esc_url( get_permalink() ); ?>" class="post-title">
				<h2>
					<?php jevelin_sticky_post(); ?>
					<?php the_title(); ?>
				</h2>
			</a>

			<div class="post-meta post-meta-one">
				<?php jevelin_meta_one(); ?>
			</div>

			<div class="post-content">
				<?php the_excerpt(); ?>
			</div>

			<div class="post-meta post-meta-two">
				<?php jevelin_meta_two(); ?>
			</div>

		</div>
	</article>


<?php
	/* Layout for mix style */
	elseif ( $style == 'mix masonry2' ) :
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
		<div class="post-container">

			<div class="row">
				<div class="col-md-6 post-column-left">

					<?php jevelin_popover( jevelin_post_option( get_the_ID(), 'post-popover' ) ); ?>
					<?php if( jevelin_post_option( get_the_ID(), 'post-video' ) ) : ?>
						<div class="post-meta-video">
							<div class="ratio-container">
								<div class="ratio-content">
									<?php echo wp_oembed_get( jevelin_post_option( get_the_ID(), 'post-video' ) ); ?>
								</div>
							</div>
						</div>
					<?php endif; ?>

				</div>
				<div class="col-md-6 post-column-right">

					<div class="post-content-container">
						<div class="">
							<div class="post-meta post-meta-one">
								<?php jevelin_meta_one(); ?>
							</div>

							<a href="<?php echo esc_url( get_permalink() ); ?>" class="post-title">
								<h2>
									<?php jevelin_sticky_post(); ?>
									<?php the_title(); ?>
								</h2>
							</a>

							<div class="post-content">
								<?php echo wp_trim_words( get_the_content() , '17' ); ?>
							</div>

							<div class="post-meta post-meta-two">
								<?php jevelin_meta_two( 0, 'icon icon-bubble' ); ?>
							</div>
						</div>
					</div>

				</div>
			</div>

		</div>
	</article>


<?php
	/* Layout for minimalistic style */
	elseif( $style == 'minimalistic' ) :
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
		<div class="post-container">
			<?php jevelin_popover( jevelin_post_option( get_the_ID(), 'post-popover' ) ); ?>

			<?php if( jevelin_post_option( get_the_ID(), 'post-video' ) ) : ?>
				<div class="post-meta-video">
					<div class="ratio-container">
						<div class="ratio-content">
							<?php echo wp_oembed_get( jevelin_post_option( get_the_ID(), 'post-video' ) ); ?>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<a href="<?php echo esc_url( get_permalink() ); ?>" class="post-title">
				<h2>
					<?php jevelin_sticky_post(); ?>
					<?php the_title(); ?>
				</h2>
			</a>

			<div class="post-meta post-meta-two">
				<?php jevelin_meta_two(); ?>
			</div>

			<div class="post-content">
				<?php the_excerpt(); ?>
			</div>

			<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="post-readmore sh-default-color sh-columns">
				<div><?php _e( 'Read more', 'jevelin' ); ?></div>
				<div><i class="ti-angle-right"></i></div>
			</a>

		</div>
	</article>


<?php
	/* Layout for standard medium and small styles */
	elseif( $style == 'medium' || $style == 'small' ) :
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post-item'); ?>>
		<div class="post-container sh-group">
			<?php jevelin_popover( jevelin_post_option( get_the_ID(), 'post-popover' ) ); ?>

			<?php if( jevelin_post_option( get_the_ID(), 'post-video' ) ) : ?>
				<div class="post-left-side">

					<div class="post-meta-video">
						<div class="ratio-container">
							<div class="ratio-content">
								<?php echo wp_oembed_get( jevelin_post_option( get_the_ID(), 'post-video' ) ); ?>
							</div>
						</div>
					</div>

				</div>
			<?php endif; ?>
			<div class="post-right-side">

				<a href="<?php echo esc_url( get_permalink() ); ?>" class="post-title">
					<h2>
						<?php jevelin_sticky_post(); ?>
						<?php the_title(); ?>
					</h2>
				</a>

				<div class="post-meta post-meta-one">
					<?php jevelin_meta_one(); ?>
				</div>

				<div class="post-content">
					<?php the_excerpt(); ?>
				</div>

				<div class="post-meta post-meta-two">
					<?php jevelin_meta_two(); ?>
				</div>

			</div>

		</div>
	</article>

<?php
	/* Layout for standard large and single post style */
	else :
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('post-item post-item-single'); ?>>
		<div class="post-container">
			<?php jevelin_popover( jevelin_post_option( get_the_ID(), 'post-popover' ) ); ?>

			<?php if( jevelin_post_option( get_the_ID(), 'post-video' ) ) : ?>
				<div class="post-meta-video">
					<div class="ratio-container">
						<div class="ratio-content">
							<?php echo wp_oembed_get( jevelin_post_option( get_the_ID(), 'post-video' ) ); ?>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<a href="<?php echo esc_url( get_permalink() ); ?>" class="post-title">
				<?php if( !is_single() ) : ?>
					<h2><?php the_title(); ?></h2>
				<?php else : ?>
					<h1><?php the_title(); ?></h1>
				<?php endif; ?>
			</a>

			<div class="post-meta-data sh-columns">
				<div class="post-meta post-meta-one">
					<?php jevelin_meta_one(); ?>
				</div>
				<div class="post-meta post-meta-two">
					<?php jevelin_meta_two(); ?>
				</div>
			</div>

			<?php if( get_the_excerpt() || the_content() ) : ?>
				<div class="post-content">
					<?php
						if( !is_single() ) :
							the_excerpt();
						else :
							the_content();
						endif;
					?>
				</div>
			<?php endif; ?>

		</div>
	</article>

<?php endif; ?>
