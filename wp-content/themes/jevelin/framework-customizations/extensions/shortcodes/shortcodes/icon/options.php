<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(

	'id' => array( 'type' => 'unique' ),

	'icon'    => array(
		'type'  => 'new-icon',
		'label' => esc_html__('Icon', 'jevelin'),
		'desc'   => esc_html__( 'Select Icon', 'jevelin' ),
		'set' => 'jevelin-icons',
		'value' => 'ti-check'
	),

	/*'url'   => array(
		'type'  => 'text',
		'label' => esc_html__( 'URL', 'jevelin' ),
		'desc'   => esc_html__( 'Enter URL', 'jevelin' ),
	),*/

    'alignment' => array(
        'label'   => esc_html__('Alignment', 'jevelin'),
        'desc'    => esc_html__('Choose alignment', 'jevelin'),
        'type'    => 'radio',
        'choices' => array(
            'center' => esc_html__('Center', 'jevelin'),
            'left' => esc_html__('Left', 'jevelin'),
            'right' => esc_html__('Right', 'jevelin'),
        ),
        'value' => 'center'
    ),

    'shadow' => array(
		'label'   => esc_html__('Shadow', 'jevelin'),
		'desc'    => esc_html__('Choose shadow', 'jevelin'),
		'type'    => 'radio',
		'choices' => array(
			'none' => esc_html__('None', 'jevelin'),
			'small' => esc_html__('Small', 'jevelin'),
			'large' => esc_html__('Large', 'jevelin'),
		),
		'value' => 'none'
	),

	'icon_size' => array(
		'type'  => 'select',
		'label' => esc_html__('Size', 'jevelin'),
		'desc'  => wp_kses( __( 'Enter icon size (with <b>px</b>)', 'jevelin' ), jevelin_allowed_html() ),
		'type'  => 'text',
		'attr'  => array( 'style' => 'max-width: 70px;' ),
		'value' => '30px'
	),

	'icon_color' => array(
	    'type'  => 'color-picker',
	    'label' => esc_html__('Color', 'jevelin'),
	    'desc'  => esc_html__('Select icon color or leave blank for default body color', 'jevelin'),
	    'value' => '',
	),

	'icon_second_color' => array(
	    'type'  => 'color-picker',
	    'label' => esc_html__('Second Color', 'jevelin'),
	    'desc'  => esc_html__('Select icon color to create a gradient color (Only for chrome, safari and opera browsers)', 'jevelin'),
	    'value' => '',
	),

	'icon_hover_color' => array(
	    'type'  => 'color-picker',
	    'label' => esc_html__('Hover Color', 'jevelin'),
	    'desc'  => esc_html__('Select hover color', 'jevelin'),
	    'value' => '',
	),

	'icon_hover_second_color' => array(
	    'type'  => 'color-picker',
	    'label' => esc_html__('Second Hover Color', 'jevelin'),
	    'desc'  => esc_html__('Select icon hover color to create a hover gradient color (Only for chrome, safari and opera browsers)', 'jevelin'),
	    'value' => '',
	),

);
