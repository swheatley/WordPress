<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$ext_instance = fw()->extensions->get( 'portfolio' );

fw_include_file_isolated( $ext_instance->get_path( '/static.php' ) );
