<?php if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }

$options = array(
	'content' => array(
	    'type'  => 'textarea',
	    'label' => esc_html__('Content', 'jevelin'),
	    'desc'  => esc_html__('Enter your custom JavaScript content', 'jevelin'),
	    'value' => 'alert("This is simple JavaScript output!");'
	),
);
