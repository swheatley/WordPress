<?php
/**
 * 404 page
 */

if( jevelin_option( '404_status', true ) == false ) {
	wp_redirect( esc_url( home_url('/') ) ); exit;
}

$default_title = esc_html__( 'Oops, This Page Could Not Be Found!', 'jevelin' );
$default_text = esc_html__( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'jevelin' );
$default_button = esc_html__( 'Reload', 'jevelin' );

get_header();
?>

<div id="sh-404" class="sh-404 sh-table">
	<div class="sh-table-cell">
		<span class="sh-404-title"><?php esc_html_e( '4', 'jevelin' ); ?></span>
	</div>
	<div class="sh-table-cell">
		<span class="sh-404-title"><?php esc_html_e( '0', 'jevelin' ); ?></span>
		<div>
			<h3><?php echo esc_attr( jevelin_option( '404_title', $default_title ) ); ?></h3>
			<p><?php echo esc_attr( jevelin_option( '404_text', $default_text ) ); ?></p>
			<a href="" class="sh-404-button">
				<i class="fa fa-refresh"></i>
				<?php echo esc_attr( jevelin_option( '404_button', $default_button ) ); ?>
			</a>
		</div>
	</div>
	<div class="sh-table-cell">
		<span class="sh-404-title"><?php esc_html_e( '4', 'jevelin' ); ?></span>
	</div>
</div>

<div id="sh-404-mobile" class="sh-404">
	<div class="sh-table-cell">
		<span class="sh-404-title sh-404-mobile-title"><?php esc_html_e( '404', 'jevelin' ); ?></span>
		<div>
			<h3><?php echo esc_attr( jevelin_option( '404_title', $default_title ) ); ?></h3>
			<p><?php echo esc_attr( jevelin_option( '404_text', $default_text ) ); ?></p>
			<a href="" class="sh-404-button">
				<i class="fa fa-refresh"></i>
				<?php echo esc_attr( jevelin_option( '404_button', $default_button ) ); ?>
			</a>
		</div>
	</div>
</div>

<?php get_footer(); ?>