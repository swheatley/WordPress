<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'id' => array( 'type' => 'unique' ),

	'general' => array(
		'title'   => esc_html__( 'General', 'jevelin' ),
		'type'    => 'tab',
		'options' => array(

			'table'         => array(
				'type'  => 'table',
				'label' => false,
				'desc'  => false,
			),

			'table_fix' => array(
				'type'  => 'html-full',
				'value' => '',
				'label' => false,
				'html'  => "<script>jQuery(document).ready(function ($){ setTimeout(function(){ jQuery('.fw-backend-option-type-table select ').val('tabular'); }, 10); });</script>",
			),

		),
	),

	'styling' => array(
		'title'   => esc_html__( 'Styling', 'jevelin' ),
		'type'    => 'tab',
		'options' => array(

			'style' => array(
				'type'    => 'radio',
				'label'   => esc_html__('Style', 'jevelin'),
				'desc'  => esc_html__('Choose main style', 'jevelin'),
				'choices' => array(
					'style1' => esc_html__('Style 1', 'jevelin'),
					'style2' => esc_html__('Style 2', 'jevelin'),
					'style3' => esc_html__('Style 3', 'jevelin'),
				),
				'value'	  => 'style1',
			),

		),
	),
);
