<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$documentation_link = 'https://support.shufflehound.com/documentation/jevelin/?source=theme&version=2';
$theme = wp_get_theme();
$options = array(
	'documentation' => array(
		'title'   => esc_html__( 'Theme Documentation', 'jevelin' ),
		'type'    => 'tab',
		'options' => array(
			'info-box' => array(
				'title'   => esc_html__( 'Theme Documentation', 'jevelin' ),
				'type'    => 'box',
				'options' => array(

					'theme_documentation' => array(
					    'type'  => 'html-full',
					    'value' => false,
					    'label' => false,
					    'html'  => '
							<iframe class="jevelin-live-documentation" src="'.esc_url( $documentation_link ).'" frameborder="0"></iframe>',
					)

				)
			),
		)
	)
);
