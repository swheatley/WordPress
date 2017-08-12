<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$favicon = array(
    'type'  => 'hidden',
    'value' => 'outdated',
);

if ( !function_exists( 'has_site_icon' ) || ! has_site_icon() ) :
	$favicon = array(
		'label' => esc_html__( 'Favicon', 'jevelin' ),
		'desc'  => esc_html__( 'Upload a 32px x 32px (ico/png) image', 'jevelin' ),
		'type'  => 'upload'
	);
endif;

$google_api_key = 'https://developers.google.com/maps/documentation/javascript/get-api-key';

$options = array(
	'general' => array(
		'title'   => esc_html__( 'General', 'jevelin' ),
		'type'    => 'tab',
		'options' => array(
			'general-box' => array(
				'title'   => esc_html__( 'General Settings', 'jevelin' ),
				'type'    => 'box',
				'options' => array(

					'demo_content' => array(
						'type'  => 'html-full',
						'value' => '',
						'label' => false,
						'html'  => '
						<div class="fw-backend-option-design-default sh-demo-content-title">
							<div class="fw-backend-option-label">
								<label for="fw-option-responsive_layout">'.esc_html__( 'Demo Content', 'jevelin' ).'</label>
							</div>
						</div>
						<div class="sh-demo-content-link">
							<a href="'.admin_url( 'tools.php?page=fw-backups-demo-content' ).'">'.esc_html__( ' Click here', 'jevelin' ).'</a>
							'.esc_html__( 'to install a demo content', 'jevelin' ).'
						</div>',
					),

					'page_layout' => array(
					    'type'  => 'multi-picker',
						'label' => false,
						'desc'  => false,
					    'value' => array(
					        'page_layout' => 'full',
					    ),
					    'picker' => array(
					        'page_layout' => array(
					            'label'   => esc_html__('Page Layout', 'jevelin'),
					            'desc'    => esc_html__('Choose main page layout. Boxed layout will not work together with left header', 'jevelin'),
					            'type'    => 'radio',
					            'choices' => array(
					                'full' => esc_html__('Full Width', 'jevelin'),
					                'boxed' => esc_html__('Boxed Layout', 'jevelin'),
					            ),
					        )
					    ),
					    'choices' => array(
					        'boxed' => array(
						        'border_style' => array(
						            'label'   => esc_html__('Border Style', 'jevelin'),
						            'desc'    => esc_html__('Choose content border style', 'jevelin'),
						            'type'    => 'radio',
						            'choices' => array(
						                'none' => esc_html__('None', 'jevelin'),
						                'shadow' => esc_html__('Shadow', 'jevelin'),
						                'line' => esc_html__('Line', 'jevelin'),
						            ),
						            'value' => 'shadow'
						        ),

								'background_color' => array(
								    'label' => esc_html__('Background Color', 'jevelin'),
								    'desc'  => esc_html__('Select background color', 'jevelin'),
								    'type'  => 'color-picker',
								    'value' => '#fafafa'
								),
					        ),
					    ),
					),

					'performance' => array(
						'label' => esc_html__( 'Performance Mode', 'jevelin' ),
						'desc'  => esc_html__( 'Enable or disable performance mode. Combines JS and CSS files and caches dynamic CSS code', 'jevelin' ),
						'type'  => 'switch',
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

					'white_borders' => array(
						'label' => esc_html__( 'White Frame', 'jevelin' ),
						'desc'  => esc_html__( 'Enable or disable white frame around the page', 'jevelin' ),
						'type'  => 'switch',
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

					'white_borders_only_on_pages' => array(
						'label' => esc_html__( 'White Frame Only in Pages', 'jevelin' ),
						'desc'  => esc_html__( 'Enable or disable white frame only in pages', 'jevelin' ),
						'type'  => 'switch',
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

					'favicon' => $favicon,

					'responsive_layout' => array(
						'label' => esc_html__( 'Responsive Layout', 'jevelin' ),
						'desc'  => esc_html__( 'Enable or disable responsive layout for mobile devices', 'jevelin' ),
						'type'  => 'switch',
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

					'smooth-scrooling' => array(
						'label' => esc_html__( 'Smooth Scrooling', 'jevelin' ),
						'desc'  => esc_html__( 'Enable or disable smooth scrolling for webkit browers like Chrome', 'jevelin' ),
						'type'  => 'switch',
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

					'back_to_top' => array(
					    'type'  => 'select',
					    'value' => '1',
					    'label' => esc_html__('Back To Top Button', 'jevelin'),
					    'desc'  => esc_html__('Choose style for "Back to top" button or disable it', 'jevelin'),
					    'choices' => array(
					        'disabled' => esc_html__( 'Disabled', 'jevelin' ),
					        '1' => esc_html__( 'Style 1', 'jevelin' ),
					        '1 filled' => esc_html__( 'Style 1 (filled)', 'jevelin' ),
					        '2' => esc_html__( 'Style 2', 'jevelin' ),
					        '2 filled' => esc_html__( 'Style 2 (filled)', 'jevelin' ),
					        '3' => esc_html__( 'Style 3', 'jevelin' ),
					    ),
					),

					'back_to_top_rounded' => array(
					    'label' => esc_html__('Back To Top Button Rounded', 'jevelin'),
						'desc'  => esc_html__( 'Enable or disable rounded corners for back to top button', 'jevelin' ),
						'type'  => 'switch',
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

					'rtl_support' => array(
						'label' => esc_html__( 'RTL Support', 'jevelin' ),
						'desc'  => esc_html__( 'Enable or disable RTL(Right to Left) support', 'jevelin' ),
						'type'  => 'switch',
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

					'crispy_images' => array(
						'label' => esc_html__( 'Crispy Images', 'jevelin' ),
						'desc'  => esc_html__( 'Enable or disable crispy images effect', 'jevelin' ),
						'type'  => 'switch',
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

					'page_comments' => array(
						'label' => esc_html__( 'Comments', 'jevelin' ),
						'desc'  => esc_html__( 'Enable or disable post comments and page comments', 'jevelin' ),
						'type'  => 'switch',
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

					'one_pager' => array(
						'label' => esc_html__( 'One Page Navigation', 'jevelin' ),
						'desc'  => esc_html__( 'Enable or disable one page navigation', 'jevelin' ),
						'type'  => 'switch',
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

					'api_key' => array(
					    'type'  => 'text',
					    'label' => esc_html__('Google Maps API Key (outdated method)', 'jevelin'),
					    'desc'  => esc_html__('Please set Google Maps API key under Google Maps element options', 'jevelin').'</a>',
					),

				)
			),
		)
	)
);
