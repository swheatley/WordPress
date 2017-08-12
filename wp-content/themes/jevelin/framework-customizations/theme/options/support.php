<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$documentation_link = 'https://support.shufflehound.com';
$theme = wp_get_theme();
$options = array(
	'support' => array(
		'title'   => esc_html__( 'Theme Support', 'jevelin' ),
		'type'    => 'tab',
		'options' => array(
			'info-box' => array(
				'title'   => esc_html__( 'Theme Support', 'jevelin' ),
				'type'    => 'box',
				'options' => array(

					'theme_support' => array(
					    'type'  => 'html-full',
					    'value' => false,
					    'label' => false,
					    'html'  => '
							<iframe class="jevelin-live-support" src="'.esc_url( $documentation_link ).'" frameborder="0"></iframe>',
					)

				)
			),
		)
	)
);
