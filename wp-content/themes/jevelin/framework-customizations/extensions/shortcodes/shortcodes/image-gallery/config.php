<?php if (!defined('FW')) die('Forbidden');

$cfg = array(
	'page_builder' => array(
		'title'       => esc_html__( 'Image Gallery', 'jevelin' ),
		'description' => esc_html__( 'Add a Image Gallery', 'jevelin' ),
		'tab'         => esc_html__( 'Content Elements', 'jevelin' ),
		'popup_size'  => 'medium',
		'icon' => 'ti-gallery',
        'title_template' => '
        	<b>{{- title }}</b>
        	<div class="sh-builder-item-desc">

                {{ if( typeof o.columns != "undefined" && o.columns ) { }}
                    {{- o.columns.replace(/[^\d.-]/g, "") }} columns
                {{ } }}

        	</div>',
	)
);
