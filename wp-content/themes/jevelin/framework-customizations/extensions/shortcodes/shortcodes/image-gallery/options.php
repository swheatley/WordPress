<?php if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }
$options = array(
	'id' => array( 'type' => 'unique' ),

	'images' => array(
	    'label' => esc_html__('Images', 'jevelin'),
	    'desc'  => esc_html__('To select multiple images use the CTRL key for PC or COMMAND key for MAC.', 'jevelin'),
	    'type'  => 'multi-upload',
	    'images_only' => true,
	),

	'columns' => array(
		'type'  => 'radio',
		'label' => esc_html__('Image Columns', 'jevelin'),
		'desc'  => esc_html__('Choose image columns count', 'jevelin'),
		'choices' => array(
			'1columns' => esc_html__('1 Columns', 'jevelin'),
			'2columns' => esc_html__('2 Columns', 'jevelin'),
			'3columns' => esc_html__('3 Columns', 'jevelin'),
			'4columns' => esc_html__('4 Columns', 'jevelin'),
			'5columns' => esc_html__('5 columns', 'jevelin'),
		),
		'value'	  => '3columns',
	),

	'image_ratio' => array(
		'type'  => 'select',
		'label' => esc_html__('Image Ratio', 'jevelin'),
		'desc'  => esc_html__('Choose image ratio', 'jevelin'),
		'choices' => array(
			'landscape' => esc_html__('Landscape', 'jevelin'),
			'portrait' => esc_html__('Portrait', 'jevelin'),
			'square' => esc_html__('Square', 'jevelin'),
		),
		'value'	  => 'square',
	),

	'dots' => array(
		'type'  => 'select',
		'label' => esc_html__('Dots Style', 'jevelin'),
		'desc'  => esc_html__('Choose dots style', 'jevelin'),
		'choices' => array(
			'dots1' => esc_html__('Below Images', 'jevelin'),
			'dots2' => esc_html__('On Images', 'jevelin'),
			'disable' => esc_html__('Disable', 'jevelin'),
		),
		'value'	=> 'dots1',
	),

	'autoplay' => array(
	    'type'  => 'multi-picker',
		'label' => false,
		'desc'  => false,
	    'value' => array(
	        'mobile' => 'off',
	    ),
	    'picker' => array(
			'autoplay' => array(
				'type' => 'switch',
				'label' => esc_html__( 'Autoplay', 'jevelin' ),
				'desc' => esc_html__( 'Enable or disable autoplay', 'jevelin' ),
				'value' => 'off',
				'left-choice' => array(
					'value' => 'off',
					'label' => esc_html__('Off', 'jevelin'),
				),
				'right-choice' => array(
					'value' => 'on',
					'label' => esc_html__('On', 'jevelin'),
				),
			),
	    ),
	    'choices' => array(
	        'on' => array(
				'animation_speed' => array(
				    'type'  => 'slider',
				    'value' => 3,
				    'properties' => array(
				        'min' => 0,
				        'max' => 6,
				        'step' => 0.1,
				    ),
				    'label' => esc_html__('Animation Speed', 'jevelin'),
				    'desc'  => esc_html__('Choose animation speed (seconds)', 'jevelin'),
				),
	        ),
	    ),
	),

	'overlay' => array(
		'type' => 'switch',
		'label' => esc_html__( 'Overlay', 'jevelin' ),
		'desc' => esc_html__( 'Enable or disable overlay', 'jevelin' ),
		'value' => 'on',
		'left-choice' => array(
			'value' => 'off',
			'label' => esc_html__('Off', 'jevelin'),
		),
		'right-choice' => array(
			'value' => 'on',
			'label' => esc_html__('On', 'jevelin'),
		),
	),

	'margin'  => array(
	    'label' => esc_html__( 'Image Margin', 'jevelin' ),
	    'desc'  => esc_html__( 'Select image margin for white space around them', 'jevelin' ),
	    'type'  => 'slider',
	    'value' => 0,
	    'properties' => array(
	        'min' => 0,
	        'max' => 30,
	        'sep' => 1,
	    ),
	),

);
