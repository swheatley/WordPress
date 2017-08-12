<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'portfolio' => array(
		'title'   => esc_html__( 'Portfolio', 'jevelin' ),
		'type'    => 'tab',
		'icon'	  => 'fa fa-phone',
		'options' => array(
			'lightbox-box' => array(
				'title'   => esc_html__( 'Portfolio Options', 'jevelin' ),
				'type'    => 'box',
				'options' => array(

					'portfolio_related' => array(
						'type' => 'switch',
						'label' => esc_html__( 'Related items', 'jevelin' ),
						'desc' => esc_html__( 'Enable or disable "Related items" in single portfolio page', 'jevelin' ),
						'value' => true,
						'left-choice' => array(
							'value' => false,
							'label' => esc_html__('Off', 'jevelin'),
						),
						'right-choice' => array(
							'value' => true,
							'label' => esc_html__('On', 'jevelin'),
						),
					),

					'portfolio_share' => array(
						'type' => 'switch',
						'label' => esc_html__( 'Social Share', 'jevelin' ),
						'desc' => esc_html__( 'Enable or disable social share buttons in single portfolio page', 'jevelin' ),
						'value' => true,
						'left-choice' => array(
							'value' => false,
							'label' => esc_html__('Off', 'jevelin'),
						),
						'right-choice' => array(
							'value' => true,
							'label' => esc_html__('On', 'jevelin'),
						),
					),

					'portfolio_single_image' => array(
						'type' => 'switch',
						'label' => esc_html__( 'Opened Portfolio Image Size', 'jevelin' ),
						'desc' => esc_html__( 'Use full size image, if image quality is lower than expected.', 'jevelin' ),
						'value' => 'large',
						'left-choice' => array(
							'value' => 'large',
							'label' => esc_html__('Large', 'jevelin'),
						),
						'right-choice' => array(
							'value' => 'full',
							'label' => esc_html__('Full', 'jevelin'),
						),
					),

					'portfolio_main_page' => array(
						'type'  => 'text',
						'value' => '',
						'label' => esc_html__('Portfolio Main Page ID', 'jevelin'),
						'desc'  => esc_html__('Enter portfolio main page ID, useful to change default portfolio breadcrumbs page', 'jevelin'),
					),

				)
			),
		)
	)
);
