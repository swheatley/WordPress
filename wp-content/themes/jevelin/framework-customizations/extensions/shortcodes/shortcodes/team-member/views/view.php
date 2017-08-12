<?php if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }

/* Thumbnails */
if( $atts['image_ratio'] == 'portrait' ) :
	$image_ratio = 'jevelin-portrait';
elseif( $atts['image_ratio'] == 'square' ) :
	$image_ratio = 'jevelin-square';
else :
	$image_ratio = 'post-thumbnail';
endif;


/* Icons */
$icons = array();
$icons_data = '';
/* Facebook */
if( isset($atts['facebook']) && $atts['facebook'] ) :
	$icons[] = array( 'name' => 'social-facebook', 'link' => esc_attr( $atts['facebook'] ) );
endif;
/* Twitter */
if( isset($atts['twitter']) && $atts['twitter'] ) :
	$icons[] = array( 'name' => 'social-twitter', 'link' => esc_attr( $atts['twitter'] ) );
endif;
/* Google Plus */
if( isset($atts['googleplus']) && $atts['googleplus'] ) :
	$icons[] = array( 'name' => 'social-gplus', 'link' => esc_attr( $atts['googleplus'] ) );
endif;
/* Instagram */
if( isset($atts['instagram']) && $atts['instagram'] ) :
	$icons[] = array( 'name' => 'social-instagram', 'link' => esc_attr( $atts['instagram'] ) );
endif;
/* Skype */
if( isset($atts['skype']) && $atts['skype'] ) :
	$icons[] = array( 'name' => 'social-skype', 'link' => esc_attr( $atts['skype'] ) );
endif;
/* Behance */
if( isset($atts['behance']) && $atts['behance'] ) :
	$icons[] = array( 'name' => 'social-behance', 'link' => esc_attr( $atts['behance'] ) );
endif;
/* Linkedin */
if( isset($atts['linkedin']) && $atts['linkedin'] ) :
	$icons[] = array( 'name' => 'social-linkedin', 'link' => esc_attr( $atts['linkedin'] ) );
endif;
/*Tumblr */
if( isset($atts['tumblr']) && $atts['tumblr'] ) :
	$icons[] = array( 'name' => 'social-tumblr', 'link' => esc_attr( $atts['tumblr'] ) );
endif;

if( count( $icons) ) :
	$icons_data.= '<div class="sh-team-icons sh-team-icons-'.esc_attr( $atts['icon_style'] ).'"><div class="sh-team-icons-container">';
	foreach( $icons as $icon ) :
		$icons_data.= '<a href="'.esc_url( $icon['link'] ).'" target="_blank" class="sh-team-icon">
			<div class="sh-team-icon-container">
				<i class="icon-'.esc_attr( $icon['name'] ).'"></i>
			</div>
		</a>';
	endforeach;
	$icons_data.= '</div></div>';

	$image_position = 'sh-team-image-position';
else :
	$image_position = '';
endif;
?>

<div class="sh-team sh-team-<?php echo esc_attr( $atts['layout'] ); ?> sh-team-social-<?php echo esc_attr( $atts['icon_style'] ); ?>" id="team-<?php echo esc_attr( $atts['id'] ); ?>">
	<?php if( $atts['layout'] == 'style3' ) : ?>

		<div class="sh-team-image-container">
			<div class="sh-team-image">
				<a href="<?php echo jevelin_get_small_thumb( $atts['image']['attachment_id'], 'large' ); ?>" class="<?php echo esc_attr( $image_position ); ?>" rel="lightbox">
					<img src="<?php echo jevelin_get_small_thumb( $atts['image']['attachment_id'], $image_ratio ); ?>" alt="" />
				</a>

				<?php if( $atts['icon_style'] == 'overlay' ) : ?>
					<div class="sh-team-overlay">
						<?php echo wp_kses( $icons_data, jevelin_allowed_html_icons() ); ?>
					</div>
				<?php elseif( $atts['icon_style'] == 'overlay2' ) : ?>
					<div class="sh-team-overlay2">
						<?php echo wp_kses( $icons_data, jevelin_allowed_html_icons() ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="sh-team-aside">
			<div class="sh-team-role">
				<?php echo esc_attr( $atts['role'] ); ?>
			</div>
			<div class="sh-team-name">
				<h3><?php echo esc_attr( $atts['name'] ); ?></h3>
			</div>
			<div class="sh-team-description">
				<?php echo wp_kses_post( $atts['description'] ); ?>
			</div>
			<?php /* Social icons */ echo ( $atts['icon_style'] == 'standard' ) ? $icons_data : ''; ?>
		</div>

	<?php elseif( $atts['layout'] == 'style2' ) : ?>

		<div class="sh-team-top">
			<div class="sh-team-name">
				<h3><?php echo esc_attr( $atts['name'] ); ?></h3>
			</div>
			<div class="sh-team-role">
				<?php echo esc_attr( $atts['role']); ?>
			</div>
		</div>

		<div class="sh-team-image">
			<a href="<?php echo jevelin_get_small_thumb( $atts['image']['attachment_id'], 'large' ); ?>" class="<?php echo esc_attr( $image_position ); ?>" rel="lightbox">
				<img src="<?php echo jevelin_get_small_thumb( $atts['image']['attachment_id'], $image_ratio ); ?>" alt="" />
			</a>

			<?php if( $atts['icon_style'] == 'overlay' ) : ?>
				<div class="sh-team-overlay">
					<?php echo wp_kses( $icons_data, jevelin_allowed_html_icons() ); ?>
				</div>
			<?php elseif( $atts['icon_style'] == 'overlay2' ) : ?>
				<div class="sh-team-overlay2">
					<?php echo wp_kses( $icons_data, jevelin_allowed_html_icons() ); ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="sh-team-aside">
			<div class="sh-team-description">
				<?php echo wp_kses_post( $atts['description'] ); ?>
			</div>
			<?php /* Social icons */ echo ( $atts['icon_style'] == 'standard' ) ? $icons_data : ''; ?>
		</div>

	<?php else : ?>

		<div class="sh-team-image">
			<a href="<?php echo jevelin_get_small_thumb( $atts['image']['attachment_id'], 'large' ); ?>" class="<?php echo esc_attr( $image_position ); ?>" rel="lightbox">
				<img src="<?php echo jevelin_get_small_thumb( $atts['image']['attachment_id'], $image_ratio ); ?>" alt="" />
			</a>

			<?php if( $atts['icon_style'] == 'overlay' ) : ?>
				<div class="sh-team-overlay">
					<?php echo wp_kses( $icons_data, jevelin_allowed_html_icons() ); ?>
				</div>
			<?php elseif( $atts['icon_style'] == 'overlay2' ) : ?>
				<div class="sh-team-overlay2">
					<?php echo wp_kses( $icons_data, jevelin_allowed_html_icons() ); ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="sh-team-aside">
			<div class="sh-team-name">
				<h3><?php echo esc_attr( $atts['name'] ); ?></h3>
			</div>
			<div class="sh-team-role">
				<?php echo esc_attr( $atts['role'] ); ?>
			</div>

			<div class="sh-team-description">
				<?php echo wp_kses_post( $atts['description'] ); ?>
			</div>

			<?php /* Social icons */ echo ( $atts['icon_style'] == 'standard' ) ? $icons_data : ''; ?>
		</div>

	<?php endif; ?>
</div>