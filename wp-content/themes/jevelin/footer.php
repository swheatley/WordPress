<?php
/**
 * Footer
 */
?>

	<?php if( jevelin_post_option( get_the_ID(), 'page_layout' ) != 'full' ) : ?>
		</div>
	<?php endif; ?>
	</div>

		<footer class="sh-footer">
			<?php if( jevelin_footer_enabled() == 'on' ) : ?>

				<div class="sh-footer-widgets">
					<div class="container">
						<div class="sh-footer-columns">
							<?php
								/* Show theme footer widgets */
								dynamic_sidebar( 'footer-widgets' );
							?>
						</div>
					</div>
				</div>

			<?php endif; ?>
			<?php
				if( jevelin_copyrights_enabled() == 'on' ) :
					/* Inlcude theme copyrights bar */
					get_template_part('inc/templates/copyrights' );
				endif;
			?>
		</footer>
	</div>


	<?php if( jevelin_post_option( get_the_ID(), 'back_to_top' ) != 'none' ) :

		/* Inlcude back to top button HTML */
		get_template_part('inc/templates/back_to_top' );

	endif; ?>
</div>

<?php wp_footer(); ?>

</body>
</html>
