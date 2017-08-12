<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/**
 * Framework options
 *
 * @var array $options Fill this array with options to generate framework settings form in backend
 */

$options = array(
	fw()->theme->get_options( 'general' ),
	fw()->theme->get_options( 'styling' ),
	fw()->theme->get_options( 'header' ),
	fw()->theme->get_options( 'footer' ),
	fw()->theme->get_options( 'titlebar' ),
	fw()->theme->get_options( 'social_media' ),
	fw()->theme->get_options( 'blog' ),
	fw()->theme->get_options( 'portfolio' ),
	fw()->theme->get_options( 'lightbox' ),
	fw()->theme->get_options( 'woocommerce' ),
	fw()->theme->get_options( 'page_loader' ),
	fw()->theme->get_options( '404_page' ),
	fw()->theme->get_options( 'notice' ),
	fw()->theme->get_options( 'custom_code' ),
	//fw()->theme->get_options( 'info' ),
	fw()->theme->get_options( 'documentation' ),
	fw()->theme->get_options( 'support' ),
);
