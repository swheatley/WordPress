<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

if( class_exists('RevSlider') ) :
	$slider = new RevSlider();
	$arrSliders = $slider->getArrSlidersShort();
endif;

if( !isset($arrSliders) || !count($arrSliders) ) :
	$arrSliders = array(
		'disabled' => 'Disabled'
	);
elseif( class_exists('RevSlider') ) :
	$arrSliders['disabled'] = 'Disabled';
	$arrSliders = array_reverse($arrSliders, true);
endif;

$options = array(
    'page_settings' => array(
        'title'   => esc_html__( 'Page Settings', 'jevelin' ),
        'type'    => 'box',
        'options' => array(
            'general_tab' => array(
                'title'   => esc_html__( 'General', 'jevelin' ),
                'type'    => 'tab',
                'options' => array(

                    'page_layout' => array(
                        'type'  => 'radio',
                        'value' => 'default',
                        'label' => esc_html__( 'Page Layout', 'jevelin' ),
                        'desc'  => esc_html__( 'Choose main page layout', 'jevelin' ),
                        'choices' => array(
                            'default' => esc_html__( 'Default', 'jevelin' ),
                            'full' => esc_html__( 'Full Width', 'jevelin' ),
                            'sidebar-left' => esc_html__( 'Sidebar Left', 'jevelin' ),
                            'sidebar-right' => esc_html__( 'Sidebar Right', 'jevelin' ),
                        ),
                        'inline' => false,
                    ),

                ),
            ),

            'header_tab' => array(
                'title'   => esc_html__( 'Header', 'jevelin' ),
                'type'    => 'tab',
                'options' => array(


                    'header' => array(
                        'type' => 'switch',
                        'label' => esc_html__( 'Header', 'jevelin' ),
                        'desc' => esc_html__( 'Enable or disable header', 'jevelin' ),
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

                    'header_layout' => array(
                        'type'  => 'select',
                        'value' => 'default',
                        'label' => esc_html__('Header Layout', 'jevelin'),
                        'desc'  => esc_html__('Choose main header layout', 'jevelin'),
                        'choices' => array(
                            'default' => esc_html__( 'Default (from theme options)', 'jevelin' ),
                            '1' => esc_html__( 'Header 1', 'jevelin' ),
                            '2' => esc_html__( 'Header 2', 'jevelin' ),
                            '3' => esc_html__( 'Header 3', 'jevelin' ),
                            '4' => esc_html__( 'Header 4', 'jevelin' ),
                            '5' => esc_html__( 'Header 5', 'jevelin' ),
                            '6' => esc_html__( 'Header 6 (side navigation)', 'jevelin' ),
                            '7' => esc_html__( 'Header 7 (side navigation)', 'jevelin' ),
							'8' => esc_html__( 'Header 8', 'jevelin' ),
							'9' => esc_html__( 'Header 9', 'jevelin' ),
                            'left-1' => esc_html__( 'Left Header 1', 'jevelin' ),
                            'left-2' => esc_html__( 'Left Header 2', 'jevelin' ),
                        ),
                    ),

                    /*'header_style' => array(
                        'type'  => 'select',
                        'value' => '1',
                        'label' => esc_html__('Header Style', 'jevelin'),
                        'desc'  => esc_html__('Choose main header style', 'jevelin'),
                        'choices' => array(
                            'default' => esc_html__( 'Default', 'jevelin' ),
                            'light' => esc_html__( 'Light (Header + Titlebar)', 'jevelin' ),
                        ),
                    ),*/

                    'header_style' => array(
                        'type'  => 'multi-picker',
                        'label' => false,
                        'desc'  => false,
                        'value' => array(
                            'header_style' => 'default',
                            'manual' => array(
                                'description' => '',
                                'breadcrumbs' => true,
                                'scroll_button' => true,
                            ),
                        ),
                        'picker' => array(
                            'header_style' => array(
                                'type'  => 'select',
                                'value' => '1',
                                'label' => esc_html__('Style', 'jevelin'),
                                'desc'  => esc_html__('Choose main header and titlebar style', 'jevelin'),
                                'choices' => array(
									'default' => esc_html__( 'Default', 'jevelin' ),
									'bottom_titlebar' => esc_html__( 'Bottom of Titlebar', 'jevelin' ),
                                    'light' => esc_html__( 'Light (Header + Titlebar)', 'jevelin' ),
									'light light_noborder' => esc_html__( 'Light (Header + Titlebar + withoutborder)', 'jevelin' ),
                                    'light_mobile_off' => esc_html__( 'Light (Header + Titlebar) - Mobile Off', 'jevelin' ),
                                ),
                            ),
                        ),
                        'choices' => array(
                            'light' => array(
                                'description' => array(
                                    'type'  => 'text',
                                    'value' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit', 'jevelin'),
                                    'label' => esc_html__('Description', 'jevelin'),
                                    'desc'  => esc_html__('Enter this page description', 'jevelin'),
                                ),

                                'breadcrumbs' => array(
                                    'type' => 'switch',
                                    'label' => esc_html__( 'Breadcrumbs', 'jevelin' ),
                                    'desc' => esc_html__( 'Enable or disable dreadcrumbs', 'jevelin' ),
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

                                'scroll_button' => array(
                                    'type' => 'switch',
                                    'label' => esc_html__( 'Scroll Down Button', 'jevelin' ),
                                    'desc' => esc_html__( 'Enable or disable scroll down button', 'jevelin' ),
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

								'titlebar_text_style' => array(
			                        'type' => 'radio',
			                        'label' => esc_html__( 'Text Style', 'jevelin' ),
			                        'desc' => esc_html__( 'Choose text style', 'jevelin' ),
			                       'choices' => array(
			                            'style1' => esc_html__( 'Style 1', 'jevelin' ),
			                            'style2' => esc_html__( 'Style 2', 'jevelin' ),
			                        ),
			                        'value' => 'style1',
			                        'inline' => false,
			                    ),

                            ),
							'light light_noborder' => array(
                                'description' => array(
                                    'type'  => 'text',
                                    'value' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit', 'jevelin'),
                                    'label' => esc_html__('Description', 'jevelin'),
                                    'desc'  => esc_html__('Enter this page description', 'jevelin'),
                                ),

                                'breadcrumbs' => array(
                                    'type' => 'switch',
                                    'label' => esc_html__( 'Breadcrumbs', 'jevelin' ),
                                    'desc' => esc_html__( 'Enable or disable dreadcrumbs', 'jevelin' ),
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

                                'scroll_button' => array(
                                    'type' => 'switch',
                                    'label' => esc_html__( 'Scroll Down Button', 'jevelin' ),
                                    'desc' => esc_html__( 'Enable or disable scroll down button', 'jevelin' ),
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

								'titlebar_text_style' => array(
			                        'type' => 'radio',
			                        'label' => esc_html__( 'Text Style', 'jevelin' ),
			                        'desc' => esc_html__( 'Choose text style', 'jevelin' ),
			                       'choices' => array(
			                            'style1' => esc_html__( 'Style 1', 'jevelin' ),
			                            'style2' => esc_html__( 'Style 2', 'jevelin' ),
			                        ),
			                        'value' => 'style1',
			                        'inline' => false,
			                    ),

                            ),
                        ),
                    ),

                    'titlebar' => array(
                        'type'  => 'select',
                        'label' => esc_html__('Titlebar', 'jevelin'),
                        'desc'  => esc_html__('Enable or disable titlebar', 'jevelin'),
                        'choices' => array(
                            'default' => esc_html__( 'Default (from theme options)', 'jevelin' ),
                            'on' => esc_html__( 'On', 'jevelin' ),
                            'off' => esc_html__( 'Off', 'jevelin' ),
                        ),
                        'value' => '',
                        'inline' => false,
                    ),

                    'titlebar_background' => array(
                        'label' => esc_html__( 'Titlebar Background Image', 'jevelin' ),
                        'desc'  => esc_html__( 'Upload titlebar background image', 'jevelin' ),
                        'type'  => 'upload'
                    ),

                    'titlebar_background_parallax' => array(
                        'type' => 'select',
                        'label' => esc_html__( 'Titlebar Parallax Background', 'jevelin' ),
                        'desc' => esc_html__( 'Enable or disable parallax background', 'jevelin' ),
                        'choices' => array(
                            'default' => esc_html__( 'Default (from theme options)', 'jevelin' ),
                            'on' => esc_html__( 'On', 'jevelin' ),
                            'off' => esc_html__( 'Off', 'jevelin' ),
                        ),
                        'value' => '',
                        'inline' => false,
                    ),

					'titlebar_revslider' => array(
					    'type'  => 'select',
					    'label' => esc_html__('Titlebar Revolution Slider', 'jevelin'),
					    'desc'  => esc_html__('Replace titlebar content with Revolution Slider', 'jevelin'),
					    'choices' => $arrSliders,
					),


                ),
            ),

            'footer_tab' => array(
                'title'   => esc_html__( 'Footer', 'jevelin' ),
                'type'    => 'tab',
                'options' => array(


                    'footer_widgets' => array(
                        'type' => 'select',
                        'label' => esc_html__( 'Widgets', 'jevelin' ),
                        'desc' => esc_html__( 'Enable or disable footer widgets', 'jevelin' ),
                       'choices' => array(
                            'default' => esc_html__( 'Default (from theme options)', 'jevelin' ),
                            'on' => esc_html__( 'On', 'jevelin' ),
                            'off' => esc_html__( 'Off', 'jevelin' ),
                        ),
                        'value' => '',
                        'inline' => false,
                    ),

                    'copyright_bar' => array(
                        'type' => 'select',
                        'label' => esc_html__( 'Copyrights', 'jevelin' ),
                        'desc' => esc_html__( 'Enable or disable footer copyrights', 'jevelin' ),
                        'choices' => array(
                            'default' => esc_html__( 'Default (from theme options)', 'jevelin' ),
                            'on' => esc_html__( 'On', 'jevelin' ),
                            'off' => esc_html__( 'Off', 'jevelin' ),
                        ),
                        'value' => '',
                        'inline' => false,
                    ),


                ),
            ),

            'blog_tab' => array(
                'title'   => esc_html__( 'Blog', 'jevelin' ),
                'type'    => 'tab',
                'options' => array(


                    'page_blog_notice' => array(
                        'type'  => 'html-full',
                        'value' => '',
                        'label' => false,
                        'html'  => '<i>Use only if page template is set to <b>Blog</b></i>',
                    ),

                    'page-blog-style' => array(
                        'type'  => 'radio',
                        'value' => 'masonry masonry-shadow',
                        'label' => esc_html__( 'Blog Style', 'jevelin' ),
                        'desc'  => esc_html__( 'Choose blog style', 'jevelin' ),
                        'choices' => array(
							'masonry masonry2' => esc_html__( 'Masonry 2.0 Standard', 'jevelin' ),
                            'masonry masonry-shadow' => esc_html__( 'Masonry Shadow', 'jevelin' ),
                            'masonry' => esc_html__( 'Masonry Standard', 'jevelin' ),
                            'grid' => esc_html__( 'Grid', 'jevelin' ),
							'mix masonry2' => esc_html__( 'Mix', 'jevelin' ),
                            'large' => esc_html__( 'Large Images', 'jevelin' ),
                            'medium' => esc_html__( 'Medium Images', 'jevelin' ),
                            'small' => esc_html__( 'Small Images', 'jevelin' ),
                        ),
                        'inline' => false,
                    ),

					'page_blog_categories_tab' => array(
                        'type' => 'radio',
                        'label' => esc_html__( 'Blog Categories Tabs', 'jevelin' ),
                        'desc' => esc_html__( 'Enable or disable blog categories tabs', 'jevelin' ),
                       'choices' => array(
                            'on' => esc_html__( 'On', 'jevelin' ),
                            'off' => esc_html__( 'Off', 'jevelin' ),
                        ),
                        'value' => 'off',
                        'inline' => false,
                    ),

                    'page_blog_category' => array(
                        'type'  => 'multi-select',
                        'label' => esc_html__('Blog Categories', 'jevelin'),
                        'desc'  => esc_html__('Choose which blog categories you want to show', 'jevelin'),
                        'population' => 'taxonomy',
                        'source' => 'category',
                        'prepopulation' => 10,
                        'limit' => 100,
                    ),


                ),
            ),

            'colors_tab' => array(
                'title'   => esc_html__( 'Colors', 'jevelin' ),
                'type'    => 'tab',
                'options' => array(

                    'accent_color' => array(
                        'type'  => 'color-picker',
                        'label' => esc_html__('Accent Color', 'jevelin'),
                        'desc'  => esc_html__('Set custom accent color for this page or leave blank for default', 'jevelin'),
                        'value' => '',
                    ),

                    'accent_hover_color' => array(
                        'type'  => 'rgba-color-picker',
                        'label' => esc_html__('Accent Hover Color', 'jevelin'),
                        'desc'  => esc_html__('Select page accent color on hover or leave blank for default', 'jevelin'),
                        'value' => '',
                    ),

                    'header_nav_active_color' => array(
                        'type'  => 'rgba-color-picker',
                        'label' => esc_html__('Active Navigation Color', 'jevelin'),
                        'desc'  => esc_html__('Select active navigation color or leave blank for default', 'jevelin'),
                        'value' => '',
                    ),

                    'footer_hover_color' => array(
                        'type'  => 'color-picker',
                        'value' => '',
                        'label' => esc_html__('Footer Hover Color', 'jevelin'),
                        'desc'  => esc_html__('Select footer color on hover', 'jevelin'),
                    ),

                ),
            ),
        ),
    ),
);
