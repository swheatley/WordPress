<?php if ( ! defined( 'FW' ) ) {
    die( 'Forbidden' );
}

$options = array(

    'page_settings' => array(
        'title'   => esc_html__( 'Page Settings', 'jevelin' ),
        'type'    => 'box',
        'options' => array(
            'general_tab' => array(
                'title'   => esc_html__( 'General', 'jevelin' ),
                'type'    => 'tab',
                'options' => array(

                    'style' => array(
                        'label' => esc_html__('Portfolio Layout', 'jevelin'),
                        'desc'  => esc_html__('Choose portfolio layout', 'jevelin'),
                        'type'  => 'radio',
                        'value' => 'default',
                        'choices' => array(
                            'default' => esc_html__('Default', 'jevelin'),
                            'slider' => esc_html__('Gallery Slider', 'jevelin'),
                            'video-slider' => esc_html__('Video Slider', 'jevelin'),
                            'iframe-slider' => esc_html__('Iframe Slider', 'jevelin'),
                        )
                    ),

                    'video' => array(
                        'type'  => 'text',
                        'value' => '',
                        'label' => esc_html__('Video URL', 'jevelin'),
                        'desc'  => wp_kses( __( 'Enter video URL from WordPress <a target="_blank" href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F">supported video sites</a>. Only for video slider layout', 'jevelin' ), jevelin_allowed_html() ),
                    ),

                    'iframe' => array(
                        'type'  => 'text',
                        'value' => '',
                        'label' => esc_html__('Iframe URL', 'jevelin'),
                        'desc'  => wp_kses( __( 'Enter iframe URL. Only for iframe slider layout', 'jevelin' ), jevelin_allowed_html() ),
                    ),

                    'field_client' => array(
                        'type'  => 'text',
                        'value' => '',
                        'label' => esc_html__('Client', 'jevelin'),
                        'desc'  => esc_html__('Enter your client name', 'jevelin'),
                    ),

                    'field_link' => array(
                        'type'  => 'text',
                        'value' => '',
                        'label' => esc_html__('URL', 'jevelin'),
                        'desc'  => esc_html__('Enter your URL', 'jevelin'),
                    ),

                    'info'  => array(
                        'label' => esc_html__('Custom Fields', 'jevelin'),
                        'desc'  => esc_html__('Add some custom fields', 'jevelin'),
                        'type'  => 'addable-box',
                        'box-options' => array(
                            'title' => array( 'type' => 'text' ),
                            'description' => array( 'type' => 'textarea' ),
                            'icon' => array( 'type' => 'icon', 'set' => 'jevelin-icons', ),
                        ),
                        'template' => '{{- title }}',
                        'add-button-text' => esc_html__('Add', 'jevelin'),
                        'sortable' => true,
                    ),

                    'custom_url' => array(
                        'type'  => 'text',
                        'value' => '',
                        'label' => esc_html__('Custom URL', 'jevelin'),
                        'desc'  => esc_html__('Enter your custom URL where page will be redirected', 'jevelin'),
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
        ),
    ),

);
