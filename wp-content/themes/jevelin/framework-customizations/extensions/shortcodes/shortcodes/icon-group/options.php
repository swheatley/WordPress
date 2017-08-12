<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(

	'id' => array( 'type' => 'unique' ),

	'icons' => array(
		'label'         => esc_html__( 'Icons', 'jevelin' ),
		'popup-title'   => esc_html__( 'Add/Edit Icons', 'jevelin' ),
		'desc'          => esc_html__( 'Here you can add, remove and edit your icons', 'jevelin' ),
		'type'          => 'addable-popup',
		'template'      => '<i class="{{=icon}}" style="font-size: 21px;"></i>',
		'size'			=> 'medium',
		'popup-options' => array(

			'icon'    => array(
				'type'  => 'new-icon',
				'label' => esc_html__('Icon', 'jevelin'),
				'desc'   => esc_html__( 'Select Icon', 'jevelin' ),
				'set' => 'jevelin-icons',
				'value' => 'ti-check'
			),

			'link'    => array(
				'label' => esc_html__( 'Link', 'jevelin' ),
				'desc'  => esc_html__( 'Enter icon link', 'jevelin' ),
				'type'  => 'text'
			),

		)
	),

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

	'style' => array(
        'label'   => esc_html__('Style', 'jevelin'),
        'desc'    => esc_html__('Choose icon style', 'jevelin'),
        'type'    => 'radio',
        'choices' => array(
            'style1' => esc_html__('Style 1', 'jevelin'),
            'style2' => esc_html__('Style 2', 'jevelin'),
        ),
        'value' => 'style1'
    ),

	'icon_color' => array(
	    'type'  => 'rgba-color-picker',
	    'label' => esc_html__('Color', 'jevelin'),
	    'desc'  => esc_html__('Select icon color or leave blank for default body color', 'jevelin'),
	    'value' => '',
	),

);
