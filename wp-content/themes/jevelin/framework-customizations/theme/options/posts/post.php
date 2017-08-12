<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(

    'page_settings' => array(
        'title'   => esc_html__( 'Page Settings', 'jevelin' ),
        'type'    => 'box',
        'priority' => 'high',
        'options' => array(
            'general_tab' => array(
                'title'   => esc_html__( 'General', 'jevelin' ),
                'type'    => 'tab',
                'options' => array(

                    'post-popover' => array(
                        'label'   => esc_html__('Popover', 'jevelin'),
                        'desc'    => esc_html__('Small informative meesage', 'jevelin'),
                        'type'    => 'radio',
                        'choices' => array(
                            'none' => esc_html__('None', 'jevelin'),
                            'new' => esc_html__('NEW', 'jevelin'),
                            'hot' => esc_html__('HOT', 'jevelin'),
                        ),
                        'value' => 'none'
                    )

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
                                    'value' => '',
                                    'label' => esc_html__('Description', 'jevelin'),
                                    'desc'  => esc_html__('Enter this page description', 'jevelin'),
                                ),

                                'breadcrumbs' => array(
                                    'type' => 'switch',
                                    'label' => esc_html__( 'Breadcrumbs', 'jevelin' ),
                                    'desc' => esc_html__( 'Enable or disable dreadcrumbs', 'jevelin' ),
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

                                'scroll_button' => array(
                                    'type' => 'switch',
                                    'label' => esc_html__( 'Scroll Down Button', 'jevelin' ),
                                    'desc' => esc_html__( 'Enable or disable scroll down button', 'jevelin' ),
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

                ),
            ),
        ),
    ),

    'post-format-0' => array(
        'type'     => 'box',
        'title'    => esc_html__('Image Settings', 'jevelin'),
        'priority' => 'high',
        'options'  => array(

            'hide-image' => array(
                'type' => 'switch',
                'label' => esc_html__( 'Hide Featured Image', 'jevelin' ),
                'desc' => esc_html__( 'Enable this if you want to hide featured image inside the blog post', 'jevelin' ),
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

        )
    ),

    'post-format-gallery' => array(
        'type'     => 'box',
        'title'    => esc_html__('Gallery Settings', 'jevelin'),
        'priority' => 'high',
        'options'  => array(

            'post-gallery' => array(
                'type'  => 'multi-upload',
                'label' => esc_html__( 'Gallery', 'jevelin' ),
                'desc'  => esc_html__( 'Upload images to your gallery', 'jevelin' ),
                'images_only' => true,
            ),

        )
    ),


    'post-format-quote' => array(
        'type'     => 'box',
        'title'    => esc_html__('Quote Settings', 'jevelin'),
        'priority' => 'high',
        'options'  => array(

            'post-quote' => array(
                'type'  => 'textarea',
                'label' => esc_html__( 'Quote', 'jevelin' ),
                'desc'  => esc_html__( 'Enter quote', 'jevelin' ),
            ),

            'post-quote-author' => array(
                'type' => 'text',
                'label' => esc_html__( 'Quote Author', 'jevelin' ),
                'desc' => esc_html__( 'Enter quote author', 'jevelin' ),
            ),

        )
    ),


    'post-format-link' => array(
        'type'     => 'box',
        'title'    => esc_html__('Link Settings', 'jevelin'),
        'priority' => 'high',
        'options'  => array(

            'post-url-title' => array(
                'type' => 'text',
                'label' => esc_html__( 'URL Title', 'jevelin' ),
                'desc' => esc_html__( 'Enter URL title', 'jevelin' ),
            ),

            'post-url' => array(
                'type' => 'text',
                'label' => esc_html__( 'URL', 'jevelin' ),
                'desc' => esc_html__( 'Dont forget to add http://', 'jevelin' ),
            ),

        )
    ),


    'post-format-video' => array(
        'type'     => 'box',
        'title'    => esc_html__('Video Settings', 'jevelin'),
        'priority' => 'high',
        'options'  => array(

            'post-video' => array(
                'type' => 'text',
                'label' => esc_html__( 'Video URL', 'jevelin' ),
                'desc' => esc_html__( 'Enter WordPress supported link', 'jevelin' ),
            ),

        )
    ),


    'post-format-audio' => array(
        'type'     => 'box',
        'title'    => esc_html__('Audio Settings', 'jevelin'),
        'priority' => 'high',
        'options'  => array(

            'post-audio' => array(
                'type' => 'text',
                'label' => esc_html__( 'Audio URL', 'jevelin' ),
                'desc' => esc_html__( 'Enter WordPress supported link', 'jevelin' ),
            ),

        )
    ),

);
