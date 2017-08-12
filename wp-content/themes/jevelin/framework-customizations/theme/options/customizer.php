<?php
if ( is_customize_preview() || ( is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX ) || defined( 'DOING_CRON' ) ) {
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

$options = array(
    'customizer_general' => array(
        'type' => 'box',
        'title' => esc_html__('General', 'jevelin'),
        //'priority' => 'high',
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
            						'label' => esc_html__( 'Performance', 'jevelin' ),
            						'desc'  => esc_html__( 'Enable or disable performance boost', 'jevelin' ),
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

            					'white_borders' => array(
            						'label' => esc_html__( 'White Frame', 'jevelin' ),
            						'desc'  => esc_html__( 'Enable or disable white frame around the page. Notice: This is an expermental feature!', 'jevelin' ),
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

        ),
    ),
    'customizer_styling' => array(
        'type' => 'box',
        'title' => esc_html__('Styling', 'jevelin'),
        //'priority' => 'high',
        'options' => array(


            'styling_body_background' => array(
                'type'  => 'rgba-color-picker',
                'value' => '#ffffff',
                'label' => esc_html__('Body Background Color', 'jevelin'),
                'desc'  => esc_html__('Select body background color', 'jevelin'),
            ),

            'styling_body' => array(
                'type'  => 'typography-v2',
                'value'      => array(
                    'family'    => 'Raleway',
                    'subset'    => 'latin',
                    'variation' => 'regular',
                    'size'      => 14,
                    'line-height' => 0,
                    'letter-spacing' => 0,
                    'color'     => '#8d8d8d'
                ),
                'components' => array(
                    'family'         => true,
                    'size'           => true,
                    'line-height'    => true,
                    'letter-spacing' => true,
                    'color'          => true
                ),
                'label' => esc_html__('Body Font', 'jevelin'),
                'desc'  => esc_html__('Choose default body font settings', 'jevelin'),
            ),

            'google_fonts_subset' => array(
                'type'  => 'checkboxes',
                'value' => array(
                    'latin' => true,
                ),
                'label' => esc_html__('Choose the character sets', 'jevelin'),
                'desc'  => esc_html__('Select the character sets you want to use for fonts (will be used only if available)', 'jevelin'),
                'choices' => array(
                    'greek' => esc_html__('Greek ', 'jevelin'),
                    'greek-ext' => esc_html__('Greek Extended', 'jevelin'),
                    'latin' => esc_html__('Latin', 'jevelin'),
                    'vietnamese' => esc_html__('Vietnamese', 'jevelin'),
                    'cyrillic-ext' => esc_html__('Cyrillic Extended', 'jevelin'),
                    'latin-ext' => esc_html__('Latin Extended', 'jevelin'),
                    'cyrillic' => esc_html__('Cyrillic ', 'jevelin'),
                ),
                'inline' => true,
            ),

            'title_styling_body' => array(
                'type'  => 'html-full',
                'value' => '',
                'label' => false,
                'html'  => '<h3 class="hndle sh-custom-group-divder"><span>'.esc_html__('General', 'jevelin').'</span></h3>',
            ),

            'accent_color' => array(
                'type'  => 'rgba-color-picker',
                'value' => '#47c9e5',
                'label' => esc_html__('Accent Color', 'jevelin'),
                'desc'  => esc_html__('Select page accent color', 'jevelin'),
            ),

            'accent_hover_color' => array(
                'type'  => 'rgba-color-picker',
                'value' => '#15bee4',
                'label' => esc_html__('Accent Hover Color', 'jevelin'),
                'desc'  => esc_html__('Select page accent color on hover', 'jevelin'),
            ),

            'link_color' => array(
                'type'  => 'rgba-color-picker',
                'value' => '#16acce',
                'label' => esc_html__('Link Color', 'jevelin'),
                'desc'  => esc_html__('Select page link color', 'jevelin'),
            ),

            'link_hover_color' => array(
                'type'  => 'rgba-color-picker',
                'value' => '#10a0c0',
                'label' => esc_html__('Link Hover Color', 'jevelin'),
                'desc'  => esc_html__('Select page link color on hover', 'jevelin'),
            ),

            'title_styling_headings' => array(
                'type'  => 'html-full',
                'value' => '',
                'label' => false,
                'html'  => '<h3 class="hndle sh-custom-group-divder"><span>'.esc_html__('Headings', 'jevelin').'</span></h3>',
            ),

            'styling_headings' => array(
                'type'  => 'typography-v2',
                'value'      => array(
                    'family'    => 'Raleway',
                    'subset'    => 'latin',
                    'variation' => '700',
                    'color'     => '#3f3f3f'
                ),
                'components' => array(
                    'family'         => true,
                    'size'           => false,
                    'line-height'    => false,
                    'letter-spacing' => false,
                    'color'          => true
                ),
                'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                'label' => esc_html__('Headings', 'jevelin'),
                'desc'  => esc_html__('Choose default font settings for all headings', 'jevelin'),
            ),

            'styling_h1' => array(
                'type'  => 'slider',
                'value' => 30,
                'properties' => array(
                    'min' => 5,
                    'max' => 65,
                ),
                'label' => esc_html__('Heading 1', 'jevelin'),
                'desc'  => esc_html__('Select heading 1 font size (pixels)', 'jevelin'),
            ),

            'styling_h2' => array(
                'type'  => 'slider',
                'value' => 24,
                'properties' => array(
                    'min' => 5,
                    'max' => 65,
                ),
                'label' => esc_html__('Heading 2', 'jevelin'),
                'desc'  => esc_html__('Select heading 2 font size (pixels)', 'jevelin'),
            ),

            'styling_h3' => array(
                'type'  => 'slider',
                'value' => 21,
                'properties' => array(
                    'min' => 5,
                    'max' => 65,
                ),
                'label' => esc_html__('Heading 3', 'jevelin'),
                'desc'  => esc_html__('Select heading 3 font size (pixels)', 'jevelin'),
            ),

            'styling_h4' => array(
                'type'  => 'slider',
                'value' => 18,
                'properties' => array(
                    'min' => 5,
                    'max' => 65,
                ),
                'label' => esc_html__('Heading 4', 'jevelin'),
                'desc'  => esc_html__('Select heading 4 font size (pixels)', 'jevelin'),
            ),

            'styling_h5' => array(
                'type'  => 'slider',
                'value' => 16,
                'properties' => array(
                    'min' => 5,
                    'max' => 65,
                ),
                'label' => esc_html__('Heading 5', 'jevelin'),
                'desc'  => esc_html__('Select heading 5 font size (pixels)', 'jevelin'),
            ),

            'styling_h6' => array(
                'type'  => 'slider',
                'value' => 14,
                'properties' => array(
                    'min' => 5,
                    'max' => 65,
                ),
                'label' => esc_html__('Heading 6', 'jevelin'),
                'desc'  => esc_html__('Select heading 6 font size (pixels)', 'jevelin'),
            ),


            'title_styling_header' => array(
                'type'  => 'html-full',
                'value' => '',
                'label' => false,
                'html'  => '<h3 class="hndle sh-custom-group-divder"><span>'.esc_html__('Header', 'jevelin').'</span></h3>',
            ),

            'header_background_color' => array(
                'type'  => 'rgba-color-picker',
                'value' => '#fff',
                'label' => esc_html__('Header Background Color', 'jevelin'),
                'desc'  => esc_html__('Select header background color', 'jevelin'),
            ),

            'header_background_image' => array(
                'label' => esc_html__( 'Header Background Image', 'jevelin' ),
                'desc'  => esc_html__( 'Upload a header background image. Note: Image will only appear when background color transparancy will be set', 'jevelin' ),
                'type'  => 'upload'
            ),

            'header_text_color' => array(
                'type'  => 'rgba-color-picker',
                'value' => '#8d8d8d',
                'label' => esc_html__('Header Text Color', 'jevelin'),
                'desc'  => esc_html__('Select header text color', 'jevelin'),
            ),

            'header_border_color' => array(
                'type'  => 'rgba-color-picker',
                'value' => 'rgba( 0,0,0,0.08 )',
                'label' => esc_html__('Header Border Color', 'jevelin'),
                'desc'  => esc_html__('Select header border color', 'jevelin'),
            ),

            'header_top_background_color' => array(
                'type'  => 'rgba-color-picker',
                'value' => '#47c9e5',
                'label' => esc_html__('Top Bar Background Color', 'jevelin'),
                'desc'  => esc_html__('Select top bar background color', 'jevelin'),
            ),

            'header_top_color' => array(
                'type'  => 'color-picker',
                'value' => '#fff',
                'label' => esc_html__('Top Bar Color', 'jevelin'),
                'desc'  => esc_html__('Select top bar color', 'jevelin'),
            ),


            'title_styling_nav' => array(
                'type'  => 'html-full',
                'value' => '',
                'label' => false,
                'html'  => '<h3 class="hndle sh-custom-group-divder"><span>'.esc_html__('Navigation', 'jevelin').'</span></h3>',
            ),

            'header_nav_size' => array(
                'type'  => 'text',
                'value' => '14px',
                'attr'  => array( 'style' => 'max-width: 70px' ),
                'label' => esc_html__('Navigation Size', 'jevelin'),
                'desc'  => wp_kses( __( 'Enter your navigation size (with <b>px</b>)', 'jevelin' ), jevelin_allowed_html() ),
            ),

            'header_nav_color' => array(
                'type'  => 'rgba-color-picker',
                'value' => 'rgba(61,61,61,0.69)',
                'label' => esc_html__('Navigation Color', 'jevelin'),
                'desc'  => esc_html__('Select navigation color', 'jevelin'),
            ),

            'header_nav_hover_color' => array(
                'type'  => 'rgba-color-picker',
                'value' => 'rgba(61,61,61,0.80)',
                'label' => esc_html__('Navigation Hover Color', 'jevelin'),
                'desc'  => esc_html__('Select navigation color on hover', 'jevelin'),
            ),

            'header_nav_active_color' => array(
                'type'  => 'rgba-color-picker',
                'value' => '#47c9e5',
                'label' => esc_html__('Active Navigation Color', 'jevelin'),
                'desc'  => esc_html__('Select active navigation color', 'jevelin'),
            ),

            'header_nav_active_background_color' => array(
                'type'  => 'rgba-color-picker',
                'label' => esc_html__('Active Navigation Background Color', 'jevelin'),
                'desc'  => esc_html__('Select active navigation background color (optional)', 'jevelin'),
                'value' => ''
            ),


            'title_styling_menu' => array(
                'type'  => 'html-full',
                'value' => '',
                'label' => false,
                'html'  => '<h3 class="hndle sh-custom-group-divder"><span>'.esc_html__('Dropdown / Menu', 'jevelin').'</span></h3>',
            ),

            'menu_background_color' => array(
                'type'  => 'rgba-color-picker',
                'value' => '#232323',
                'label' => esc_html__('Menu Background Color', 'jevelin'),
                'desc'  => esc_html__('Select menu background color', 'jevelin'),
            ),

            'menu_link_color' => array(
                'type'  => 'rgba-color-picker',
                'value' => '#aaaaaa',
                'label' => esc_html__('Menu Link Color', 'jevelin'),
                'desc'  => esc_html__('Select menu link color', 'jevelin'),
            ),

            'menu_link_hover_color' => array(
                'type'  => 'rgba-color-picker',
                'value' => '#ffffff',
                'label' => esc_html__('Menu Link Hover and Active Color', 'jevelin'),
                'desc'  => esc_html__('Select menu link hover and active color', 'jevelin'),
            ),

            'menu_link_border_color' => array(
                'type'  => 'rgba-color-picker',
                'value' => '#303030',
                'label' => esc_html__('Menu Link Border Color', 'jevelin'),
                'desc'  => esc_html__('Select menu link border color', 'jevelin'),
            ),


            'title_styling_sidebar' => array(
                'type'  => 'html-full',
                'value' => '',
                'label' => false,
                'html'  => '<h3 class="hndle sh-custom-group-divder"><span>'.esc_html__('Sidebar', 'jevelin').'</span></h3>',
            ),

            'sidebar_headings' => array(
                'type'  => 'typography-v2',
                'value'      => array(
                    'size'     => '14',
                    'color'     => '#505050'
                ),
                'components' => array(
                    'family'         => false,
                    'size'           => true,
                    'line-height'    => false,
                    'letter-spacing' => false,
                    'color'          => true
                ),
                'label' => esc_html__('Sidebar Headings', 'jevelin'),
                'desc'  => esc_html__('Choose default sidebar heading font settings', 'jevelin'),
            ),

            'sidebar_border_color' => array(
                'type'  => 'rgba-color-picker',
                'label' => esc_html__('Sidebar Border Color', 'jevelin'),
                'desc'  => esc_html__('Select sidebar border color', 'jevelin'),
                'value' => '#e3e3e3'
            ),


            'title_footer_styling' => array(
                'type'  => 'html-full',
                'value' => '',
                'label' => false,
                'html'  => '<h3 class="hndle sh-custom-group-divder"><span>'.esc_html__('Footer Styling', 'jevelin').'</span></h3>',
            ),

            'footer_background_color' => array(
                'type'  => 'rgba-color-picker',
                'value' => '#262626',
                'label' => esc_html__('Footer Background Color', 'jevelin'),
                'desc'  => esc_html__('Select footer background color', 'jevelin'),
            ),

            'footer_background_image' => array(
                'label' => esc_html__( 'Footer Background Image', 'jevelin' ),
                'desc'  => esc_html__( 'Upload a footer background image. Note: Image will appear only when background color transparancy will be set', 'jevelin' ),
                'type'  => 'upload'
            ),

            'footer_headings' => array(
                'type'  => 'typography-v2',
                'value'      => array(
                    'size'     => '20',
                    'color'     => '#ffffff'
                ),
                'components' => array(
                    'family'         => false,
                    'size'           => true,
                    'line-height'    => false,
                    'letter-spacing' => false,
                    'color'          => true
                ),
                'label' => esc_html__('Footer Headings', 'jevelin'),
                'desc'  => esc_html__('Choose default footer heading font settings', 'jevelin'),
            ),

            'footer_text_color' => array(
                'type'  => 'color-picker',
                'value' => '#e3e3e3',
                'label' => esc_html__('Footer Text Color', 'jevelin'),
                'desc'  => esc_html__('Select footer text color', 'jevelin'),
            ),

            'footer_link_color' => array(
                'type'  => 'color-picker',
                'value' => '#ffffff',
                'label' => esc_html__('Footer Link Color', 'jevelin'),
                'desc'  => esc_html__('Select footer link color', 'jevelin'),
            ),

            'footer_hover_color' => array(
                'type'  => 'color-picker',
                'value' => '#47c9e5',
                'label' => esc_html__('Footer Hover Color', 'jevelin'),
                'desc'  => esc_html__('Select footer color on hover', 'jevelin'),
            ),

            'footer_icon_color' => array(
                'type'  => 'rgba-color-picker',
                'value' => '#f7f7f7',
                'label' => esc_html__('Footer Icon Color', 'jevelin'),
                'desc'  => esc_html__('Select footer icon color', 'jevelin'),
            ),

            'footer_border_color' => array(
                'type'  => 'rgba-color-picker',
                'value' => 'rgba(255,255,255,0.10)',
                'label' => esc_html__('Footer Border Color', 'jevelin'),
                'desc'  => esc_html__('Select footer border color', 'jevelin'),
            ),


            'title_copyright_styling' => array(
                'type'  => 'html-full',
                'value' => '',
                'label' => false,
                'html'  => '<h3 class="hndle sh-custom-group-divder"><span>'.esc_html__('Copyright Styling', 'jevelin').'</span></h3>',
            ),

            'copyright_background_color' => array(
                'type'  => 'rgba-color-picker',
                'value' => '#222222',
                'label' => esc_html__('Copyright Background Color', 'jevelin'),
                'desc'  => esc_html__('Select copyright background color', 'jevelin'),
            ),

            'copyright_text_color' => array(
                'type'  => 'color-picker',
                'value' => '#ffffff',
                'label' => esc_html__('Copyright Text Color', 'jevelin'),
                'desc'  => esc_html__('Select copyright text color', 'jevelin'),
            ),

            'copyright_link_color' => array(
                'type'  => 'color-picker',
                'value' => '#ffffff',
                'label' => esc_html__('Copyright Link Color', 'jevelin'),
                'desc'  => esc_html__('Select copyright link color', 'jevelin'),
            ),

            'copyright_hover_color' => array(
                'type'  => 'color-picker',
                'value' => '#c0e3eb',
                'label' => esc_html__('Copyright Link Hover Color', 'jevelin'),
                'desc'  => esc_html__('Select copyright link color on hover', 'jevelin'),
            ),

            'copyright_border_color' => array(
                'type'  => 'rgba-color-picker',
                'value' => 'rgba(255,255,255,0.15)',
                'label' => esc_html__('Copyright Border Color', 'jevelin'),
                'desc'  => esc_html__('Select copyright border color', 'jevelin'),
            ),


            'additional_styling' => array(
                'type'  => 'html-full',
                'value' => '',
                'label' => false,
                'html'  => '<h3 class="hndle sh-custom-group-divder"><span>'.esc_html__('Adittional Styling', 'jevelin').'</span></h3>',
            ),

            'additional_font1' => array(
                'type'  => 'typography-v2',
                'value'      => array(
                    'family'    => 'Raleway',
                    'subset'    => 'latin',
                ),
                'components' => array(
                    'family'         => true,
                    'size'           => false,
                    'line-height'    => false,
                    'letter-spacing' => false,
                    'color'          => false
                ),
                'label' => esc_html__('Adittional Font 1', 'jevelin'),
                'desc'  => esc_html__('Used adittional font for WoocCmmerce sale popover', 'jevelin'),
            ),

            'additional_font2' => array(
                'type'  => 'typography-v2',
                'value'      => array(
                    'family'    => 'Raleway',
                    'subset'    => 'latin',
                ),
                'components' => array(
                    'family'         => true,
                    'size'           => false,
                    'line-height'    => false,
                    'letter-spacing' => false,
                    'color'          => false
                ),
                'label' => esc_html__('Adittional Font 2', 'jevelin'),
                'desc'  => esc_html__('Used adittional font for heading and other shortcodes', 'jevelin'),
            ),

            'popover_color' => array(
                'type'  => 'color-picker',
                'label' => esc_html__('Popover Background Color', 'jevelin'),
                'desc'  => esc_html__('Select popover background color. Leave empty for default accent color', 'jevelin'),
            ),

            'popover_font' => array(
                'type'  => 'select',
                'label' => esc_html__('Popover Font Famility', 'jevelin'),
                'desc'  => esc_html__( 'Select popover font famility source', 'jevelin' ),
                'choices' => array(
                    'heading' => esc_html__( 'Heading', 'jevelin' ),
                    'body' => esc_html__( 'Body', 'jevelin' ),
                    'additional1' => esc_html__( 'Additional font 1', 'jevelin' ),
                    'additional2' => esc_html__( 'Additional font 2', 'jevelin' ),
                ),
                'value'   => 'additional1',
            ),


        ),
    ),

    'customizer_header' => array(
        'type' => 'box',
        'title' => esc_html__('Header', 'jevelin'),
        //'priority' => 'high',
        'options' => array(


                    'logo' => array(
                        'label' => esc_html__( 'Logo1', 'jevelin' ),
                        'desc'  => esc_html__( 'Upload a logo image (max height 250px) ', 'jevelin' ),
                        'type'  => 'upload',
                        'images_only' => true,
                    ),

                    'logo_sticky' => array(
                        'label' => esc_html__( 'Sticky Header Logo (optional)', 'jevelin' ),
                        'desc'  => esc_html__( 'Upload a sticky logo image (max height 250px) ', 'jevelin' ),
                        'type'  => 'upload',
                        'images_only' => true,
                    ),

                    'logo_light' => array(
                        'label' => esc_html__( 'Header Light Logo Version (optional)', 'jevelin' ),
                        'desc'  => esc_html__( 'Upload a light logo version (max height 250px) ', 'jevelin' ),
                        'type'  => 'upload',
                        'images_only' => true,
                    ),

                    'title_header_settings' => array(
                        'type'  => 'html-full',
                        'value' => '',
                        'label' => false,
                        'html'  => '<h3 class="hndle sh-custom-group-divder"><span>'.esc_html__('Header Settings', 'jevelin').'</span></h3>',
                    ),

                    'ipad_landscape_full_navigation' => array(
                        'label' => esc_html__( 'iPad landscape navigation', 'jevelin' ),
                        'desc'  => esc_html__( 'Enable or disable iPad landscape to use desktop navigation (expermetal feature)', 'jevelin' ),
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

                    'header_logo_sizes' => array(
                        'type'  => 'multi-picker',
                        'label' => false,
                        'desc'  => false,
                        'value' => array(
                            'header_logo_sizes' => 'orginal',
                            'manual' => array(
                                'standard_height' => '40',
                                'sticky_height' => '40',
                                'responsive_height' => '40',
                            ),
                        ),
                        'picker' => array(
                            'header_logo_sizes' => array(
                                'type' => 'switch',
                                'label' => esc_html__( 'Header Logo Sizes', 'jevelin' ),
                                'desc' => esc_html__( 'Switch between orgianl and manual header logo sizing', 'jevelin' ),
                                'value' => true,
                                'left-choice' => array(
                                    'value' => 'orginal',
                                    'label' => esc_html__('Orginal', 'jevelin'),
                                ),
                                'right-choice' => array(
                                    'value' => 'manual',
                                    'label' => esc_html__('Manual', 'jevelin'),
                                ),
                            )
                        ),
                        'choices' => array(
                            'manual' => array(
                                'standard_height' => array(
                                    'type'  => 'slider',
                                    'value' => '50',
                                    'label' => esc_html__('Logo Height', 'jevelin'),
                                    'desc'  => esc_html__('Choose header logo height size', 'jevelin'),
                                    'properties' => array(
                                        'min' => 20,
                                        'max' => 250,
                                        'step' => 1
                                    ),
                                    'inline' => false,
                                ),

                                'sticky_height' => array(
                                    'type'  => 'slider',
                                    'value' => '40',
                                    'label' => esc_html__('Sticky Logo Height', 'jevelin'),
                                    'desc'  => esc_html__('Choose sticky logo height size', 'jevelin'),
                                    'properties' => array(
                                        'min' => 20,
                                        'max' => 250,
                                        'step' => 1
                                    ),
                                    'inline' => false,
                                ),

                                'responsive_height' => array(
                                    'type'  => 'slider',
                                    'value' => '30',
                                    'label' => esc_html__('Responsive Logo Height', 'jevelin'),
                                    'desc'  => esc_html__('Choose responsive logo height size', 'jevelin'),
                                    'properties' => array(
                                        'min' => 20,
                                        'max' => 250,
                                        'step' => 1
                                    ),
                                    'inline' => false,
                                ),
                            ),
                        ),
                    ),

                    'header_layout' => array(
                        'type'  => 'radio',
                        'value' => '1',
                        'label' => esc_html__('Header Layout', 'jevelin'),
                        'desc'  => esc_html__('Choose main header layout', 'jevelin'),
                        'choices' => array(
                            '1' => esc_html__( 'Header 1', 'jevelin' ),
                            '2' => esc_html__( 'Header 2', 'jevelin' ),
                            '3' => esc_html__( 'Header 3', 'jevelin' ),
                            '4' => esc_html__( 'Header 4', 'jevelin' ),
                            '5' => esc_html__( 'Header 5', 'jevelin' ),
                            '6' => esc_html__( 'Header 6 (side navigation)', 'jevelin' ),
                            '7' => esc_html__( 'Header 7 (side navigation)', 'jevelin' ),
                            'left-1' => esc_html__( 'Left Header 1', 'jevelin' ),
                            'left-2' => esc_html__( 'Left Header 2', 'jevelin' ),
                        ),
                        'inline' => false,
                    ),

                    'header_width' => array(
                        'type' => 'switch',
                        'label' => esc_html__( 'Header Width', 'jevelin' ),
                        'desc' => esc_html__( 'Select header width', 'jevelin' ),
                        'value' => 'default',
                        'left-choice' => array(
                            'value' => 'default',
                            'label' => esc_html__('Default', 'jevelin'),
                        ),
                        'right-choice' => array(
                            'value' => 'full',
                            'label' => esc_html__('Full', 'jevelin'),
                        ),
                    ),

                    'header_sticky' => array(
                        'type' => 'switch',
                        'label' => esc_html__( 'Sticky Header', 'jevelin' ),
                        'desc' => esc_html__( 'Enable or disable sticky header', 'jevelin' ),
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

                    'header_elements' => array(
                        'type'  => 'checkboxes',
                        'value' => array(
                            'social' => true,
                            'social_mobile' => true,
                            'search' => true,
                            'woo_cart' => true,
                            'woo_account' => false,
                        ),
                        'label' => esc_html__('Header Elements', 'jevelin'),
                        'desc'  => esc_html__('Select header elements you want to see', 'jevelin'),
                        'choices' => array(
                            'social' => esc_html__('Social Media', 'jevelin'),
                            'social_mobile' => esc_html__('Social Media (mobile)', 'jevelin'),
                            'search' => esc_html__('Search', 'jevelin'),
                            'woo_cart' => esc_html__('WooCommerce Cart', 'jevelin'),
                            'woo_account' => esc_html__('WooCommerce Account', 'jevelin'),
                        ),
                        'inline' => false,
                    ),

                    'header_uppercase' => array(
                        'type' => 'switch',
                        'label' => esc_html__( 'Navigation Uppercase', 'jevelin' ),
                        'desc' => esc_html__( 'Enable or disable uppercase navigation text transformation', 'jevelin' ),
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


                    'title_topbar' => array(
                        'type'  => 'html-full',
                        'value' => '',
                        'label' => false,
                        'html'  => '<h3 class="hndle sh-custom-group-divder"><span>'.esc_html__('Top Bar Settings', 'jevelin').'</span></h3>',
                    ),

                    'topbar_status' => array(
                        'type' => 'switch',
                        'label' => esc_html__( 'Topbar', 'jevelin' ),
                        'desc' => esc_html__( 'Enable or disable header topbar', 'jevelin' ),
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

                    'contact_phone' => array(
                        'type'  => 'text',
                        'value' => '+123 456 678 890',
                        'label' => esc_html__('Contact Phone', 'jevelin'),
                        'desc'  => esc_html__('Enter contact phone', 'jevelin'),
                    ),

                    'contact_email' => array(
                        'type'  => 'text',
                        'value' => 'info@mysite.com',
                        'label' => esc_html__('Contact E-mail', 'jevelin'),
                        'desc'  => esc_html__('Enter contact e-mail', 'jevelin'),
                    ),

                    'contact_location' => array(
                        'type'  => 'text',
                        'value' => 'Main street 12',
                        'label' => esc_html__('Contact Location', 'jevelin'),
                        'desc'  => esc_html__('Enter contact location', 'jevelin'),
                    ),

                    'contact_workhours' => array(
                        'type'  => 'text',
                        'value' => '',
                        'label' => esc_html__('Contact Working hours', 'jevelin'),
                        'desc'  => esc_html__('Enter working hours', 'jevelin'),
                    ),


                    'title_header_animations' => array(
                        'type'  => 'html-full',
                        'label' => false,
                        'html'  => '
                        <h3 class="hndle sh-custom-group-divder">
                            <span>'.esc_html__('Header Animations', 'jevelin').'</span>
                        </h3>',
                    ),

                    'header_animation_dropdown_delay' => array(
                        'type'  => 'slider',
                        'value' => '1',
                        'label' => esc_html__('Header Dropdown Closing Delay', 'jevelin'),
                        'desc'  => esc_html__('Choose header dropdown closing delay speed (seconds)', 'jevelin'),
                        'properties' => array(
                            'min' => 0,
                            'max' => 4,
                            'step' => 0.1
                        ),
                        'inline' => false,
                    ),

                    'header_animation_dropdown_speed' => array(
                        'type'  => 'slider',
                        'value' => '0.3',
                        'label' => esc_html__('Header Dropdown Opening Speed', 'jevelin'),
                        'desc'  => esc_html__('Choose header dropdown opening speed (seconds)', 'jevelin'),
                        'properties' => array(
                            'min' => 0,
                            'max' => 4,
                            'step' => 0.1
                        ),
                        'inline' => false,
                    ),

                    'header_animation_dropdown' => array(
                        'type'  => 'radio',
                        'value' => 'easeOutQuint',
                        'label' => esc_html__('Header Dropdown Animation', 'jevelin'),
                        'desc'  => esc_html__('Choose dropdown animation', 'jevelin'),
                        'choices' => array(
                            'linear' => esc_html__( 'Linear', 'jevelin' ),
                            'easeOutQuint' => esc_html__( 'Fast to slow', 'jevelin' ),
                            'easeInExpo' => esc_html__( 'Slow to fast', 'jevelin' ),
                            'easeInOutExpo' => esc_html__( 'Slow to fast (2)', 'jevelin' ),
                            'easeOutBounce' => esc_html__( 'Bounce', 'jevelin' ),
                        ),
                        'inline' => false,
                    ),


        ),
    ),

    'customizer_footer' => array(
        'type' => 'box',
        'title' => esc_html__('Footer', 'jevelin'),
        //'priority' => 'high',
        'options' => array(


                    'footer_widgets' => array(
                        'type' => 'switch',
                        'label' => esc_html__( 'Footer Widgets', 'jevelin' ),
                        'desc' => esc_html__( 'Enable or disable footer widgets', 'jevelin' ),
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

                    'footer_width' => array(
                        'type' => 'switch',
                        'label' => esc_html__( 'Footer Width', 'jevelin' ),
                        'desc' => esc_html__( 'Select footer width', 'jevelin' ),
                        'value' => 'default',
                        'left-choice' => array(
                            'value' => 'default',
                            'label' => esc_html__('Default', 'jevelin'),
                        ),
                        'right-choice' => array(
                            'value' => 'full',
                            'label' => esc_html__('Full', 'jevelin'),
                        ),
                    ),

                    'footer_columns' => array(
                        'type'  => 'radio',
                        'value' => '4',
                        'label' => esc_html__('Footer Columns', 'jevelin'),
                        'desc'  => esc_html__('Select footer column count', 'jevelin'),
                        'choices' => array(
                            '1' => esc_html__( '1 Columns', 'jevelin' ),
                            '2' => esc_html__( '2 Columns', 'jevelin' ),
                            '3' => esc_html__( '3 Columns', 'jevelin' ),
                            '4' => esc_html__( '4 Columns', 'jevelin' ),
                            '5' => esc_html__( '5 Columns', 'jevelin' ),
                        ),
                    ),

                    'footer_parallax' => array(
                        'type' => 'switch',
                        'label' => esc_html__( 'Footer Parallax', 'jevelin' ),
                        'desc' => esc_html__( 'Enable or disable whole footer to act as an parallax element', 'jevelin' ),
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


                    'copyright_title' => array(
                        'type'  => 'html-full',
                        'value' => '',
                        'label' => false,
                        'html'  => '<h3 class="hndle sh-custom-group-divder"><span>'.esc_html__('Copyright Settings', 'jevelin').'</span></h3>',
                    ),

                    'copyright_bar' => array(
                        'type' => 'switch',
                        'label' => esc_html__( 'Copyright Bar', 'jevelin' ),
                        'desc' => esc_html__( 'Enable or disable copyright bar', 'jevelin' ),
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

                    'copyright_style' => array(
                        'type'  => 'multi-picker',
                        'label' => false,
                        'desc'  => false,
                        'value' => array(
                            'style' => 'style1',
                            'style1' => array(
                                'social' => true,
                            ),
                        ),
                        'picker' => array(
                            'style' => array(
                                'label'   => esc_html__('Copyright Style', 'jevelin'),
                                'desc'    => esc_html__('Choose main style for copyrights', 'jevelin'),
                                'type'    => 'radio',
                                'choices' => array(
                                    'style1' => esc_html__('Style 1', 'jevelin'),
                                    'style2' => esc_html__('Style 2', 'jevelin'),
                                ),
                            )
                        ),
                        'choices' => array(
                            'style1' => array(
                                'social' => array(
                                    'type' => 'switch',
                                    'label' => esc_html__( 'Social Icons', 'jevelin' ),
                                    'desc' => esc_html__( 'Enable or disable social icons', 'jevelin' ),
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
                            ),
                        ),
                    ),

                    'copyright_logo' => array(
                        'label' => esc_html__( 'Footer Logo', 'jevelin' ),
                        'desc'  => esc_html__( 'Upload a footer logo image', 'jevelin' ),
                        'type'  => 'upload'
                    ),

                    'copyright_text' => array(
                        'type'   => 'wp-editor',
                        'teeny'  => true,
                        'reinit' => true,
                        'size'   => 'large',
                        'label'  => esc_html__( 'Copyright Text', 'jevelin' ),
                        'desc'   => esc_html__( 'Enter some description about copyright in your website', 'jevelin' ).'
                            <script>jQuery(document).ready(function ($) { setTimeout(function(){ $("#textarea_dynamic_id-tmce").trigger("click"); }, 1); });</script>',
                        'editor_height' => 110,
                    ),

                    'copyright_deveveloper' => array(
                        'type' => 'switch',
                        'label' => esc_html__( 'Developer Copyrights', 'jevelin' ),
                        'desc' => esc_html__( 'Enable or disable theme developer copyrights', 'jevelin' ),
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


        ),
    ),
    'customizer_titlebar' => array(
        'type' => 'box',
        'title' => esc_html__('Titlebar', 'jevelin'),
        //'priority' => 'high',
        'options' => array(


                    'titlebar' => array(
                        'type' => 'switch',
                        'label' => esc_html__( 'Titlebar', 'jevelin' ),
                        'desc' => esc_html__( 'Enable or disable titlebar', 'jevelin' ),
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

                    'titlebar_layout' => array(
                        'type'  => 'radio',
                        'label' => esc_html__('Titlebar Layout', 'jevelin'),
                        'desc'  => esc_html__('Choose titlebar layout', 'jevelin'),
                        'choices' => array(
                            'side' => esc_html__( 'Sides', 'jevelin' ),
                            'center' => esc_html__( 'Center', 'jevelin' ),
                        ),
                        'value' => 'side',
                        'inline' => false,
                    ),

                    'titlebar_height' => array(
                        'type'  => 'select',
                        'label' => esc_html__('Titlebar Height', 'jevelin'),
                        'desc'  => esc_html__('Choose titlebar height', 'jevelin'),
                        'choices' => array(
                            'small' => esc_html__( 'Small', 'jevelin' ),
                            'medium' => esc_html__( 'Medium', 'jevelin' ),
                            'large' => esc_html__( 'Large', 'jevelin' ),
                        ),
                        'value' => 'medium',
                    ),

                    'titlebar_background' => array(
                        'label' => esc_html__( 'Titlebar Background Image', 'jevelin' ),
                        'desc'  => esc_html__( 'Upload a background image for titlebar', 'jevelin' ),
                        'type'  => 'upload'
                    ),

                    'titlebar_background_parallax' => array(
                        'type' => 'switch',
                        'label' => esc_html__( 'Parallax Background', 'jevelin' ),
                        'desc' => esc_html__( 'Enable or disable parallax background', 'jevelin' ),
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

                    'titlebar-background-color' => array(
                        'type'  => 'color-picker',
                        'value' => '#fbfbfb',
                        'label' => esc_html__('Titlebar Background Color', 'jevelin'),
                        'desc'  => esc_html__('Select titlebar background color', 'jevelin'),
                    ),

                    'titlebar-title-color' => array(
                        'type'  => 'color-picker',
                        'label' => esc_html__('Titlebar Title Color', 'jevelin'),
                        'desc'  => esc_html__('Select titlebar title color', 'jevelin'),
                    ),

                    'titlebar-breadcrumbs-color' => array(
                        'type'  => 'color-picker',
                        'label' => esc_html__('Titlebar Breadcrumbs Color', 'jevelin'),
                        'desc'  => esc_html__('Select titlebar breadcrumbs color', 'jevelin'),
                    ),

                    'titlebar-home-title' => array(
                        'type'  => 'text',
                        'label' => esc_html__('Home Title', 'jevelin'),
                        'desc'  => esc_html__('Enter main title of home page', 'jevelin'),
                        'value' => 'Home',
                    ),

                    'titlebar-post-title' => array(
                        'type'  => 'text',
                        'label' => esc_html__('Post Title', 'jevelin'),
                        'desc'  => esc_html__('Enter main title of post pages', 'jevelin'),
                        'value' => 'Blog Post',
                    ),

                    'titlebar-blog-woocommerce' => array(
                        'type'  => 'text',
                        'label' => esc_html__('WooCommerce Title', 'jevelin'),
                        'desc'  => esc_html__('Enter main title of WooCommerce pages', 'jevelin'),
                        'value' => 'Shop',
                    ),

                    'titlebar-404-title' => array(
                        'type'  => 'text',
                        'label' => esc_html__('404 Title', 'jevelin'),
                        'desc'  => esc_html__('Enter main title of 404 page', 'jevelin'),
                        'value' => 'Page could not be found',
                    ),



        ),
    ),
    'customizer_social_media' => array(
        'type' => 'box',
        'title' => esc_html__('Social Media', 'jevelin'),
        //'priority' => 'high',
        'options' => array(


                    'social_newtab' => array(
                        'label' => esc_html__( 'Links In New Tab', 'jevelin' ),
                        'desc'  => esc_html__( 'Enable or disable social media link opening in new tab', 'jevelin' ),
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

                    'social_twitter' => array(
                        'type'  => 'text',
                        'value' => '',
                        'label' => esc_html__('Twitter URL', 'jevelin'),
                        'desc'  => esc_html__('Enter your custom link to show the Twitter icon. Leave blank to hide this icon', 'jevelin'),
                    ),

                    'social_facebook' => array(
                        'type'  => 'text',
                        'value' => '',
                        'label' => esc_html__('Facebok URL', 'jevelin'),
                        'desc'  => esc_html__('Enter your custom link to show the Facebook icon. Leave blank to hide this icon', 'jevelin'),
                    ),

                    'social_googleplus' => array(
                        'type'  => 'text',
                        'value' => '',
                        'label' => esc_html__('Google+ URL', 'jevelin'),
                        'desc'  => esc_html__('Enter your custom link to show the Google+ icon. Leave blank to hide this icon', 'jevelin'),
                    ),

                    'social_instagram' => array(
                        'type'  => 'text',
                        'value' => '',
                        'label' => esc_html__('Instagram URL', 'jevelin'),
                        'desc'  => esc_html__('Enter your custom link to show the Instagram icon. Leave blank to hide this icon', 'jevelin'),
                    ),

                    'social_youtube' => array(
                        'type'  => 'text',
                        'value' => '',
                        'label' => esc_html__('Youtube URL', 'jevelin'),
                        'desc'  => esc_html__('Enter your custom link to show the Yotube icon. Leave blank to hide this icon', 'jevelin'),
                    ),

                    'social_pinterest' => array(
                        'type'  => 'text',
                        'value' => '',
                        'label' => esc_html__('Pinterest URL', 'jevelin'),
                        'desc'  => esc_html__('Enter your custom link to show the Pinterest icon. Leave blank to hide this icon', 'jevelin'),
                    ),

                    'social_flickr' => array(
                        'type'  => 'text',
                        'value' => '',
                        'label' => esc_html__('Flickr URL', 'jevelin'),
                        'desc'  => esc_html__('Enter your custom link to show the Flickr icon. Leave blank to hide this icon', 'jevelin'),
                    ),

                    'social_dribbble' => array(
                        'type'  => 'text',
                        'value' => '',
                        'label' => esc_html__('Dribbble URL', 'jevelin'),
                        'desc'  => esc_html__('Enter your custom link to show the Dribbble icon. Leave blank to hide this icon', 'jevelin'),
                    ),

                    'social_linkedIn' => array(
                        'type'  => 'text',
                        'value' => '',
                        'label' => esc_html__('LinkedIn URL', 'jevelin'),
                        'desc'  => esc_html__('Enter your custom link to show the LinkedIn icon. Leave blank to hide this icon', 'jevelin'),
                    ),

                    'social_skype' => array(
                        'type'  => 'text',
                        'value' => '',
                        'label' => esc_html__('Skype Nick', 'jevelin'),
                        'desc'  => esc_html__('Enter your account name to show the Skype icon. Leave blank to hide this icon', 'jevelin'),
                    ),

                    'social_spotify' => array(
                        'type'  => 'text',
                        'value' => '',
                        'label' => esc_html__('Spotify', 'jevelin'),
                        'desc'  => esc_html__('Enter your account name to show the Spotify icon. Leave blank to hide this icon', 'jevelin'),
                    ),

                    'social_soundcloud' => array(
                        'type'  => 'text',
                        'value' => '',
                        'label' => esc_html__('Soundcloud', 'jevelin'),
                        'desc'  => esc_html__('Enter your account name to show the Soundcloud icon. Leave blank to hide this icon', 'jevelin'),
                    ),

                    'social_tumblr' => array(
                        'type'  => 'text',
                        'value' => '',
                        'label' => esc_html__('Tumblr URL', 'jevelin'),
                        'desc'  => esc_html__('Enter your custom link to show the Tumblr icon. Leave blank to hide this icon', 'jevelin'),
                    ),

                    'social_wordpress' => array(
                        'type'  => 'text',
                        'value' => '',
                        'label' => esc_html__('Wordpress URL', 'jevelin'),
                        'desc'  => esc_html__('Enter your custom link to show the Wordpress icon. Leave blank to hide this icon', 'jevelin'),
                    ),

                    'social_custom' => array(
                        'type' => 'addable-popup',
                        'label' => esc_html__('Custom Social Media', 'jevelin'),
                        'desc'  => esc_html__('Add custom icons not included in upper list for other social media links', 'jevelin'),
                        'template' => '{{- link }}',
                        'popup-title' => null,
                        'size' => 'small',
                        'limit' => 10,
                        'popup-options' => array(

                            'icon' => array(
                                'type'  => 'icon',
                                'label' => esc_html__('Icon', 'jevelin'),
                                'desc'  => esc_html__('Choose your media icon', 'jevelin'),
                                'set' => 'jevelin-icons',
                            ),

                            'link' => array(
                                'type'  => 'text',
                                'label' => esc_html__('URL', 'jevelin'),
                                'desc'  => esc_html__('Enter your custom link to show the icon', 'jevelin'),
                            ),

                        ),
                    ),


        ),
    ),
    'customizer_blog' => array(
        'type' => 'box',
        'title' => esc_html__('Blog', 'jevelin'),
        //'priority' => 'high',
        'options' => array(


            'blog_style' => array(
                'type'  => 'radio',
                'label' => esc_html__('Blog Style', 'jevelin'),
                'desc'  => esc_html__('Choose blog style (will change some widget, post and other blog elements style)', 'jevelin'),
                'choices' => array(
                    'style1' => esc_html__( 'Style 1', 'jevelin' ),
                    'style2' => esc_html__( 'Style 2', 'jevelin' ),
                ),
                'value' => 'style1',
                'inline' => false,
            ),

            'pagination' => array(
                'type' => 'switch',
                'label' => esc_html__( 'Pagination', 'jevelin' ),
                'desc' => esc_html__( 'Enable or disable pagination', 'jevelin' ),
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

            'blog-items' => array(
                'type'  => 'slider',
                'value' => 12,
                'properties' => array(
                    'min' => 1,
                    'max' => 30,
                ),
                'label' => esc_html__('Blog Posts Per Page', 'jevelin'),
                'desc'  => esc_html__('Choose how many posts will be disaplayed per page', 'jevelin'),
            ),


            'post_title' => array(
                'type'  => 'html-full',
                'value' => '',
                'label' => false,
                'html'  => '<h3 class="hndle sh-custom-group-divder"><span>'.esc_html__('Post Settings', 'jevelin').'</span></h3>',
            ),

            'post_layout' => array(
                'type'  => 'radio',
                'value' => 'sidebar-right',
                'label' => esc_html__('Post Layout', 'jevelin'),
                'desc'  => esc_html__('Choose post layout', 'jevelin'),
                'choices' => array(
                    'default' => esc_html__( 'Default', 'jevelin' ),
                    'sidebar-left' => esc_html__( 'Sidebar Left', 'jevelin' ),
                    'sidebar-right' => esc_html__( 'Sidebar Right', 'jevelin' ),
                ),
                'inline' => false,
            ),

            'post_overlay' => array(
                'type'  => 'select',
                'value' => 'style1',
                'label' => esc_html__('Post Overlay', 'jevelin'),
                'desc'  => esc_html__('Choose post overlay style', 'jevelin'),
                'choices' => array(
                    'style1' => esc_html__( 'Style 1', 'jevelin' ),
                    'style2' => esc_html__( 'Style 2', 'jevelin' ),
                    'style3' => esc_html__( 'Style 3', 'jevelin' ),
                ),
                'inline' => false,
            ),

            'post_elements' => array(
                'type'  => 'checkboxes',
                'value' => array(
                    'date' => true,
                    'prev_next' => true,
                    'athor_box' => true,
                    'share' => true,
                    'comments' => true,
                ),
                'label' => esc_html__('Post Elements', 'jevelin'),
                'desc'  => esc_html__('Select post elements you want to see in blog', 'jevelin'),
                'choices' => array(
                    'date' => esc_html__('Date', 'jevelin'),
                    'share' => esc_html__('Share', 'jevelin'),
                    'prev_next' => esc_html__('Prev/next links', 'jevelin'),
                    'athor_box' => esc_html__('Author additional information box', 'jevelin'),
                    'comments' => esc_html__('Comments', 'jevelin'),
                ),
                'inline' => false,
            ),

            'post_desc' => array(
                'type'  => 'slider',
                'value' => 45,
                'properties' => array(
                    'min' => 10,
                    'max' => 80,
                ),
                'label' => esc_html__('Description Lenght', 'jevelin'),
                'desc'  => esc_html__('Choose post description preview lenght', 'jevelin'),
            ),


        ),
    ),
   'customizer_portfolio' => array(
        'type' => 'box',
        'title' => esc_html__('Portfolio', 'jevelin'),
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


        ),
    ),
   'customizer_lightbox' => array(
        'type' => 'box',
        'title' => esc_html__('Lightbox', 'jevelin'),
        'options' => array(


                    'lightbox_transition' => array(
                        'type'  => 'radio',
                        'value' => 'elastic',
                        'label' => esc_html__('Transition', 'jevelin'),
                        'desc'  => esc_html__('Choose lightbox transition', 'jevelin'),
                        'choices' => array(
                            'none' => esc_html__( 'None', 'jevelin' ),
                            'elastic' => esc_html__( 'Elastic', 'jevelin' ),
                            'fade' => esc_html__( 'Fade', 'jevelin' ),
                            'fadeInline' => esc_html__( 'Fade Inline', 'jevelin' ),
                        ),
                    ),

                    'lightbox_opacity' => array(
                        'type'  => 'slider',
                        'value' => 88,
                        'properties' => array(
                            'min' => 1,
                            'max' => 100,
                        ),
                        'label' => esc_html__('Background Opacity', 'jevelin'),
                        'desc'  => esc_html__('Choose lightbox background opacity', 'jevelin'),
                    ),


        ),
    ),
   'customizer_woocommerce' => array(
        'type' => 'box',
        'title' => esc_html__('WooCommerce', 'jevelin'),
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

                    'wc_items_additional' => array(
                        'type'  => 'radio',
                        'value' => 'none',
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



        ),
    ),
   'customizer_page_loader' => array(
        'type' => 'box',
        'title' => esc_html__('Page Loader', 'jevelin'),
        'options' => array(


                    'page_loader' => array(
                        'type'  => 'radio',
                        'value' => 'off',
                        'label' => esc_html__('Enable Page Loader', 'jevelin'),
                        'desc'  => esc_html__('Choose page loader status', 'jevelin'),
                        'choices' => array(
                            'off' => esc_html__( 'Off', 'jevelin' ),
                            'on1' => esc_html__( 'On - In every page', 'jevelin' ),
                            'on2' => esc_html__( 'On - Only first load', 'jevelin' ),
                        ),
                    ),

                    'page_loader_style' => array(
                        'type'  => 'radio',
                        'value' => 'cube-folding',
                        'label' => esc_html__('Page Loader Style', 'jevelin'),
                        'desc'  => esc_html__('Choose page loader style', 'jevelin'),
                        'choices' => array(
                            'cube-folding' => esc_html__( 'Cube Folding', 'jevelin' ),
                            'cube-grid' => esc_html__( 'Cube Grid', 'jevelin' ),
                            'spinner' => esc_html__( 'Spinner', 'jevelin' ),
                        ),
                    ),

                    'page_loader_accent_color' => array(
                        'type'  => 'color-picker',
                        'label' => esc_html__('Page Loader Accent Color', 'jevelin'),
                        'desc'  => esc_html__('Select page loader accent color', 'jevelin'),
                    ),

                    'page_loader_background_color' => array(
                        'type'  => 'color-picker',
                        'value' => '#ffffff',
                        'label' => esc_html__('Page Loader Background Color', 'jevelin'),
                        'desc'  => esc_html__('Select page loader background color', 'jevelin'),
                    ),


        ),
    ),
   'customizer_404' => array(
        'type' => 'box',
        'title' => esc_html__('404 page', 'jevelin'),
        'options' => array(



                    '404_status' => array(
                        'type' => 'switch',
                        'label' => esc_html__( 'Enable 404 page', 'jevelin' ),
                        'desc' => esc_html__( 'Enable or disable 404 page', 'jevelin' ),
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

                    '404_title' => array(
                        'type'  => 'text',
                        'value' => 'Oops, This Page Could Not Be Found!',
                        'label' => esc_html__('Title', 'jevelin'),
                        'desc'  => esc_html__('Enter 404 page title', 'jevelin'),
                    ),

                    '404_text' => array(
                        'type'  => 'text',
                        'value' => 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.',
                        'label' => esc_html__('Message', 'jevelin'),
                        'desc'  => esc_html__('Enter 404 page message', 'jevelin'),
                    ),

                    '404_button' => array(
                        'type'  => 'text',
                        'value' => 'Reload',
                        'label' => esc_html__('Reload Button', 'jevelin'),
                        'desc'  => esc_html__('Enter 404 page "Reload" button name', 'jevelin'),
                    ),

                    '404_image' => array(
                        'label' => esc_html__( 'Image', 'jevelin' ),
                        'desc'  => esc_html__( 'Upload a background image for 404 page', 'jevelin' ),
                        'type'  => 'upload'
                    ),

                    '404_background' => array(
                        'type'  => 'color-picker',
                        'value' => '#3f3f3f',
                        'label' => esc_html__('Background Color', 'jevelin'),
                        'desc'  => esc_html__('Select 404 page background color', 'jevelin'),
                    ),


        ),
    ),
   'customizer_notice' => array(
        'type' => 'box',
        'title' => esc_html__('Notice', 'jevelin'),
        'options' => array(


                    'notice_status' => array(
                        'type' => 'switch',
                        'label' => esc_html__( 'Notice', 'jevelin' ),
                        'desc' => esc_html__( 'Enable or disable notice abowe header', 'jevelin' ),
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

                    'notice_text' => array(
                        'type'   => 'wp-editor',
                        'teeny'  => true,
                        'reinit' => true,
                        'size'   => 'large',
                        'label'  => esc_html__( 'Notice Text', 'jevelin' ),
                        'desc'   => esc_html__( 'Enter notice text', 'jevelin' ).'
                            <script>jQuery(document).ready(function ($) { setTimeout(function(){ $("#textarea_dynamic_id-tmce").trigger("click"); }, 1); });</script>',
                        'editor_height' => 110,
                        'value' => 'By using our website, you agree to the use of our cookies.'
                    ),

                    'notice_close' => array(
                        'type'  => 'radio',
                        'value' => 'enable',
                        'label' => esc_html__('Close Button', 'jevelin'),
                        'desc'  => esc_html__('Select if this notice can be closed', 'jevelin'),
                        'choices' => array(
                            'disable' => esc_html__( 'Disable', 'jevelin' ),
                            'enable' => esc_html__( 'Enable (remember close action)', 'jevelin' ),
                            'enable2' => esc_html__( 'Enable (do not remember close action)', 'jevelin' ),
                        ),
                    ),

                    'notice_more_url' => array(
                        'type'  => 'text',
                        'value' => '',
                        'label' => esc_html__('Learn More URL', 'jevelin'),
                        'desc'  => esc_html__('Enter learn more URL', 'jevelin'),
                    ),


        ),
    ),

);

}
