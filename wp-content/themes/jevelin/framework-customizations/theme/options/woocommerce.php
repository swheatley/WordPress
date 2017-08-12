<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'woocommerce' => array(
		'title'   => esc_html__( 'WooCommerce', 'jevelin' ),
		'type'    => 'tab',
		'icon'	  => 'fa fa-phone',
		'options' => array(
			'woocommerce-box' => array(
				'title'   => esc_html__( 'WooCommerce Settings', 'jevelin' ),
				'type'    => 'box',
				'options' => array(

					'wc_sort' => array(
						'type' => 'switch',
						'label' => esc_html__( 'WooCommerce Sort', 'jevelin' ),
						'desc' => esc_html__( 'Enable or disable WooCommerce product sorting dropdown', 'jevelin' ),
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

					'wc_style' => array(
					    'type'  => 'radio',
					    'value' => 'style1',
					    'label' => esc_html__('WooCommerce Item Style', 'jevelin'),
					    'desc'  => esc_html__('Choose WooCommerce item style', 'jevelin'),
					    'choices' => array(
					        'style1' => esc_html__( 'Style 1', 'jevelin' ),
					        'style2' => esc_html__( 'Style 2', 'jevelin' ),
					    ),
					    'inline' => false,
					),

					'wc_columns' => array(
					    'type'  => 'radio',
					    'value' => '4',
					    'label' => esc_html__('WooCommerce Columns', 'jevelin'),
					    'desc'  => esc_html__('Choose WooCommerce product column count', 'jevelin'),
					    'choices' => array(
					        '2' => esc_html__( '2 columns', 'jevelin' ),
					        '3' => esc_html__( '3 columns', 'jevelin' ),
					        '4' => esc_html__( '4 columns', 'jevelin' ),
					    ),
					    'inline' => false,
					),

					'wc_layout' => array(
					    'type'  => 'radio',
					    'value' => 'sidebar-left',
					    'label' => esc_html__('WooCommerce Layout', 'jevelin'),
					    'desc'  => esc_html__('Choose WooCommerce layout', 'jevelin'),
					    'choices' => array(
                            'default' => esc_html__( 'Default', 'jevelin' ),
                            'sidebar-left' => esc_html__( 'Sidebar Left', 'jevelin' ),
                            'sidebar-right' => esc_html__( 'Sidebar Right', 'jevelin' ),
					    ),
					    'inline' => false,
					),

					'wc_items' => array(
					    'type'  => 'slider',
					    'value' => 12,
					    'properties' => array(
					        'min' => 1,
					        'max' => 40,
					    ),
					    'label' => esc_html__('Items Per Page', 'jevelin'),
					    'desc'  => esc_html__('Choose WooCommerce products per page', 'jevelin'),
					),

					'wc_items_additional_information' => array(
					    'type'  => 'radio',
					    'value' => 'cat',
					    'choices' => array(
					        'none' => esc_html__( 'None', 'jevelin' ),
					        'desc' => esc_html__( 'Short description', 'jevelin' ),
					        'cat' => esc_html__( 'Categories', 'jevelin' ),
					    ),
					    'label' => esc_html__('Items Additional Information', 'jevelin'),
					    'desc'  => esc_html__('Choose what kind of additional information will be shown under product title', 'jevelin'),
					),

					'wc_related' => array(
						'type' => 'switch',
						'label' => esc_html__( 'Related Products', 'jevelin' ),
						'desc' => esc_html__( 'Enable or disable "Related products" in single product page', 'jevelin' ),
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

					'wc_banner' => array(
						'label' => esc_html__( 'Banner', 'jevelin' ),
						'desc'  => esc_html__( 'You can upload a banner image, which will be shown in checkout page', 'jevelin' ),
						'type'  => 'upload'
					),

				)
			),
		)
	)
);
