<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'id' => array( 'type' => 'unique' ),
	'general' => array(
		'title'   => esc_html__( 'General', 'jevelin' ),
		'type'    => 'tab',
		'options' => array(

			'partners' => array(
				'label'         => esc_html__( 'Partners', 'jevelin' ),
				'popup-title'   => esc_html__( 'Add/Edit Partners', 'jevelin' ),
				'desc'          => esc_html__( 'Here you can add, remove and edit your Testimonials.', 'jevelin' ),
				'type'          => 'addable-popup',
				'template'      => '<img src="{{=logo.url}}" class="sh-builder-option-image" height="65" /> <div>{{=company}}</div>',
				'size'			=> 'medium',
				'popup-options' => array(

					'logo' => array(
						'label' => esc_html__( 'Logo', 'jevelin' ),
						'desc'  => esc_html__( 'Upload a logo', 'jevelin' ),
						'type'  => 'upload',
					),

					'company'   => array(
						'label' => esc_html__( 'Company', 'jevelin' ),
						'desc'  => esc_html__( 'Enter company name', 'jevelin' ),
						'type'  => 'text'
					),

					'website'   => array(
						'label' => esc_html__( 'Website', 'jevelin' ),
						'desc'  => esc_html__( 'Enter company website', 'jevelin' ),
						'type'  => 'text'
					),

				)
			),

			'autoplay' => array(
				'type'  => 'slider',
				'value' => '5',
				'label' => esc_html__('Autoplay Speed', 'jevelin'),
				'desc'  => esc_html__('Choose autoplay speed (in seconds)', 'jevelin'),
				'properties' => array(
					'min' => 1,
					'max' => 10,
					'step' => 0.1
				),
				'inline' => false,
			),

		),
	),
	'styling' => array(
		'title'   => esc_html__( 'Styling', 'jevelin' ),
		'type'    => 'tab',
		'options' => array(

			'columns' => array(
				'type'    => 'radio',
				'label'   => esc_html__('Columns', 'jevelin'),
				'desc'  => esc_html__( 'Select partner column count', 'jevelin' ),
				'value'	  => '5',
				'choices' => array(
					'5' => esc_html__('5 columns', 'jevelin'),
					'4' => esc_html__('4 columns', 'jevelin'),
					'3' => esc_html__('3 columns', 'jevelin'),
					'2' => esc_html__('2 columns', 'jevelin'),
					'1' => esc_html__('1 columns', 'jevelin'),
				)
			),

			'line' => array(
				'type' => 'switch',
				'label' => esc_html__( 'Divider Line', 'jevelin' ),
				'desc' => esc_html__( 'Enable or disable divider line', 'jevelin' ),
				'value' => false,
				'left-choice' => array(
					'value' => false,
					'label' => esc_html__('Off', 'jevelin'),
				),
				'right-choice' => array(
					'value' => true,
					'label' => esc_html__('On', 'jevelin'),
				),
			),

			'padding'   => array(
				'type' => 'switch',
				'label' => esc_html__( 'Additional padding', 'jevelin' ),
				'desc'  => esc_html__( 'Enable or disable additional padding', 'jevelin' ),
				'value' => false,
				'left-choice' => array(
					'value' => false,
					'label' => esc_html__('Off', 'jevelin'),
				),
				'right-choice' => array(
					'value' => true,
					'label' => esc_html__('On', 'jevelin'),
				),
			),

		),
	),

);
