<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

/**
 * Load framework
 */
require_once ( trailingslashit( get_template_directory() ) . '/inc/init.php' );


/**
 * Load TGM Plugin
 */
if( !function_exists('jevelin_register_required_plugins') ) :
    require_once ( trailingslashit( get_template_directory() ) . '/inc/plugins/TGM-Plugin-Activation/class-tgm-plugin-activation.php' );
    function jevelin_register_required_plugins() {

        tgmpa(array(
            array(
                'name'      => esc_html__( 'Unyson', 'jevelin' ),
                'slug'      => 'unyson',
                'required'  => true,
            ),

            array(
                'name'      => esc_html__( 'WooCommerce', 'jevelin' ),
                'slug'      => 'woocommerce',
                'required'  => false,
            ),

            array(
                'name'      => esc_html__( 'Revolution slider', 'jevelin' ),
                'slug'      => 'revslider',
                'source'    => trailingslashit( get_template_directory() ) . '/inc/plugins/revslider.zip',
                'required'  => false,
                'version'   => '5.4.1',
            ),

            array(
                'name'      => esc_html__( 'Envato WordPress Toolkiter', 'jevelin' ),
                'slug'      => 'envato-wordpress-toolkit',
                'source'    => trailingslashit( get_template_directory() ) . '/inc/plugins/envato.zip',
                'required'  => false,
                'version'   => '1.7.3',
            ),
        ), array( 'is_automatic' => true ));

    }
    add_action( 'tgmpa_register', 'jevelin_register_required_plugins' );
endif;
