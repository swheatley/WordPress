<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(

	'id' => array( 'type' => 'unique' ),

	'limit' => array(
	    'type'  => 'slider',
	    'value' => 6,
	    'properties' => array(
	        'min' => 1,
	        'max' => 41,
	    ),
	    'label' => esc_html__('Limit posts', 'jevelin'),
	    'desc'  => esc_html__('Choose post limit. Choose 41 posts to select unlimited posts', 'jevelin'),
	),

	'style' => array(
		'type'    => 'radio',
		'label'   => esc_html__('Style', 'jevelin'),
		'desc'  => esc_html__( 'Choose main style for recent posts', 'jevelin' ),
		'value'	  => 'masonry',
		'choices' => array(
			'masonry masonry2' => esc_html__( 'Masonry 2.0 Standard', 'jevelin' ),
			'masonry masonry-shadow' => esc_html__( 'Masonry Shadow', 'jevelin' ),
			'masonry' => esc_html__('Masonry Standard', 'jevelin'),
			'grid' => esc_html__('Grid', 'jevelin'),
			'largedate' => esc_html__('Date only', 'jevelin'),
			'largeimage' => esc_html__('Image only', 'jevelin'),
			'minimalistic' => esc_html__('Minimalistic', 'jevelin'),
		)
	),

	'columns' => array(
		'type'    => 'radio',
		'label'   => esc_html__('Columns', 'jevelin'),
		'desc'  => esc_html__( 'Choose columns count', 'jevelin' ),
		'value'	  => '3',
		'choices' => array(
			'3' => esc_html__( '3 columns', 'jevelin' ),
			'5' => esc_html__( '5 columns', 'jevelin' ),
		)
	),


	'carousel' => array(
		'type' => 'switch',
		'label' => esc_html__( 'Carousel', 'jevelin' ),
		'desc' => esc_html__( 'Enable or disable carousel', 'jevelin' ),
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

    'categories' => array(
        'type'  => 'multi-select',
        'label' => esc_html__('Blog Categories', 'jevelin'),
        'desc'  => esc_html__('Choose which blog categories you want to show', 'jevelin'),
        'population' => 'taxonomy',
        'source' => 'category',
        'prepopulation' => 10,
        'limit' => 100,
    ),

	'tags' => array(
        'type'  => 'multi-select',
        'label' => esc_html__('Blog Tags', 'jevelin'),
        'desc'  => esc_html__('Choose which blog tags you want to show', 'jevelin'),
        'population' => 'taxonomy',
        'source' => 'post_tag',
        'prepopulation' => 10,
        'limit' => 100,
    ),

	'order_by' => array(
		'type'    => 'radio',
		'label'   => esc_html__('Order By', 'jevelin'),
		'desc'  => esc_html__( 'Choose product order by', 'jevelin' ),
		'value'	  => 'date',
		'choices' => array(
			'date' => esc_html__('Date', 'jevelin'),
			'name' => esc_html__('Name', 'jevelin'),
			'author' => esc_html__('Author', 'jevelin'),
			'rand' => esc_html__('Random', 'jevelin'),
			'comment_count' => esc_html__('Comment Count', 'jevelin'),
		)
	),

	'order' => array(
		'type'    => 'radio',
		'label'   => esc_html__('Order', 'jevelin'),
		'desc'  => esc_html__( 'Choose product order', 'jevelin' ),
		'value'	  => 'desc',
		'choices' => array(
			'asc' => esc_html__('Ascending', 'jevelin'),
			'desc' => esc_html__('Descending', 'jevelin'),
		)
	),

);
