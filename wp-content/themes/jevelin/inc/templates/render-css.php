<?php
ob_start("jevelin_compress");
if( defined('FW') ) :

/*-----------------------------------------------------------------------------------*/
/* Define Variables
/*-----------------------------------------------------------------------------------*/

$body = jevelin_font_option('styling_body');
$body_color = jevelin_option_value('styling_body','color');
$body_line_height = jevelin_option_value('styling_body','line-height');
$body_background = jevelin_option('styling_body_background');

$accent_color =  jevelin_option('accent_color');
$accent_hover_color = jevelin_option('accent_hover_color');
$link_color = jevelin_option('link_color');
$link_hover_color = jevelin_option('link_hover_color');

$headings = jevelin_font_option('styling_headings');
$heading_color = jevelin_option_value('styling_headings','color');
$heading_font = jevelin_option_value('styling_headings','family');
$heading1 = jevelin_option('styling_h1');
$heading2 = jevelin_option('styling_h2');
$heading3 = jevelin_option('styling_h3');
$heading4 = jevelin_option('styling_h4');
$heading5 = jevelin_option('styling_h5');
$heading6 = jevelin_option('styling_h6');

$header_width = jevelin_option('header_width');
$header_uppercase = jevelin_option('header_uppercase');
$header_background_color = jevelin_option('header_background_color');
$header_background_image = jevelin_option_image('header_background_image');
$header_text_color = jevelin_option('header_text_color');
$header_border_color = jevelin_option('header_border_color');
$topbar_background_color = jevelin_option('header_top_background_color');
$topbar_color = jevelin_option('header_top_color');

$header_nav_font = jevelin_option('header_nav_font');
$header_nav_size = jevelin_option('header_nav_size');
$header_nav_color = jevelin_option('header_nav_color');
$header_nav_hover_color = jevelin_option('header_nav_hover_color');
$header_nav_active_color = jevelin_option('header_nav_active_color');
$header_nav_active_background_color = jevelin_option('header_nav_active_background_color');
$header_height = jevelin_logo_height() + 30;
if( $header_height < 70 ) :
	$header_height = 70;
endif;

$menu_background_color = jevelin_option('menu_background_color');
$menu_link_border_color = jevelin_option('menu_link_border_color');
$menu_link_color = jevelin_option('menu_link_color');
$menu_link_hover_color = jevelin_option('menu_link_hover_color');
$menu_link_border_color = jevelin_option('menu_link_border_color');

$sidebar_headings = jevelin_font_option('sidebar_headings');
$sidebar_border_color = jevelin_option('sidebar_border_color');

$footer_width = jevelin_option('footer_width');
$footer_background_image = jevelin_option_image('footer_background_image');
$footer_background_color = jevelin_option('footer_background_color');
$footer_text_color = jevelin_option('footer_text_color');
$footer_icon_color = jevelin_option('footer_icon_color');
$footer_headings = jevelin_font_option('footer_headings');
$footer_border_color = jevelin_option('footer_border_color');
$footer_link_color = jevelin_option('footer_link_color');
$footer_hover_color = jevelin_option('footer_hover_color');
$footer_columns =  jevelin_option('footer_columns');

$copyright_background_color = jevelin_option('copyright_background_color');
$copyright_text_color = jevelin_option('copyright_text_color');
$copyright_link_color = jevelin_option('copyright_link_color');
$copyright_hover_color = jevelin_option('copyright_hover_color');
$copyright_border_color = jevelin_option('copyright_border_color');

$post_overlay = jevelin_option('post_overlay');
$wc_columns = jevelin_option('wc_columns');
$additional_font1 = jevelin_option_value('additional_font1','family');
$popover_color = ( jevelin_option('popover_color') ) ? jevelin_option('popover_color') : jevelin_option('accent_color');
$popover_font = jevelin_option('popover_font');

$white_borders = jevelin_option('white_borders', false);
$white_borders_only_on_pages = jevelin_option('white_borders_only_on_pages', false);
$header_layout = jevelin_option('header_layout', 1);
$topbar_status = jevelin_option('header_layout', 1);
$page_layout_val = jevelin_option('page_layout');
$page_layout = ( isset( $page_layout_val['page_layout'] ) ) ? esc_attr($page_layout_val['page_layout']) : 'line';
$page_layout_atts = jevelin_get_picker( $page_layout_val );
$crispy_images = jevelin_option('crispy_images', false);
$back_to_top_rounded = jevelin_option('back_to_top_rounded', true);
$rtl_support = jevelin_option('rtl_support', false);
?>

	/* Elements CSS */

<?php
/*-----------------------------------------------------------------------------------*/
/* Body
/*-----------------------------------------------------------------------------------*/
?>

	.sh-tabs-filter li a,
	.woocommerce .woocommerce-tabs li:not(.active) a,
	.woocommerce .product .posted_in a,
	.woocommerce .product .tagged_as a,
	.woocommerce .product .woocommerce-review-link,
	.woocommerce-checkout #payment div.payment_box,
	.sh-default-color a,
	.sh-default-color,
	.post-meta-two a,
	#sidebar a,
	.logged-in-as a ,
	.post-meta-author a,
	.sh-social-share-networks .jssocials-share i,
	.sh-header-left-side .sh-header-copyrights-text a,
	.wpcf7-form-control-wrap .simpleselect {
		color: <?php echo esc_attr( $body_color ); ?>!important;
	}

	.woocommerce nav.woocommerce-pagination ul.page-numbers a {
		color: <?php echo esc_attr( $body_color ); ?>;
	}

	html body,
	html .menu-item a {
		<?php echo wp_kses_post( $body ); ?>
		<?php if( $body_background != '#ffffff' ) : ?>
			background-color: <?php echo esc_attr( $body_background ); ?>;
		<?php endif; ?>
	}

	<?php if( $body_line_height > 0 ) : ?>
		body p {
			line-height: <?php echo esc_attr( $body_line_height ); ?>px;
		}
	<?php endif; ?>


<?php
/*-----------------------------------------------------------------------------------*/
/* Accent colors
/*-----------------------------------------------------------------------------------*/
?>

	.woocommerce ul.products li.product a h3:hover,
	.woocommerce ul.products li.product ins,
	.post-title h2:hover,
	.sh-team:hover .sh-team-role,
	.sh-team-style4 .sh-team-role,
	.sh-team-style4 .sh-team-icon:hover i,
	.sh-header-search-submit,
	.woocommerce .woocommerce-tabs li.active a,
	.woocommerce .required,
	.sh-recent-products .woocommerce .star-rating span::before,
	.woocommerce .woocomerce-styling .star-rating span::before,
	.woocommerce div.product p.price,
	.woocomerce-styling li.product .amount,
	.post-format-icon,
	.sh-accent-color,
	.sh-blog-tag-item:hover h6,
	ul.page-numbers a:hover,
	.sh-portfolio-single-info-item i,
	.sh-filter-item.active,
	.sh-filter-item:hover,
	.sh-nav .sh-nav-cart li.menu-item-cart .mini_cart_item .amount,
	.sh-pricing-button-style3,
	#sidebar a:not(.sh-social-widgets-item):hover,
	.logged-in-as a:hover,
	.woocommerce table.shop_table.cart a:hover,
	.wrap-forms sup:before,
	.sh-comment-date a:hover,
	.reply a.comment-edit-link,
	.comment-respond #cancel-comment-reply-link,
	.sh-portfolio-title:hover,
	.sh-portfolio-single-related-mini h5:hover {
		color: <?php echo esc_attr( $accent_color ); ?>!important;
	}

	.woocommerce p.stars.selected a:not(.active),
	.woocommerce p.stars.selected a.active,
	.sh-dropcaps-full-square,
	.sh-dropcaps-full-square-border {
		background-color: <?php echo esc_attr( $accent_color ); ?>;
	}

	.contact-form input[type="submit"],
	.sh-back-to-top:hover,
	.sh-dropcaps-full-square-tale,
	.sh-404-button,
	.woocommerce .wc-forward,
	.woocommerce .checkout-button,
	.woocommerce div.product form.cart button,
	.woocommerce .button:not(.add_to_cart_button),
	.sh-blog-tag-item,
	.sh-comments .submit,
	.sh-sidebar-search-active .search-field,
	.sh-nav .sh-nav-cart .buttons a.checkout,
	ul.page-numbers .current,
	ul.page-numbers .current:hover,
	.post-background,
	.post-item .post-category .post-category-list,
	.cart-icon span,
	.comment-input-required,
	.widget_tag_cloud a:hover,
	.widget_product_tag_cloud a:hover,
	.woocommerce #respond input#submit,
	.sh-portfolio-overlay1-bar,
	.sh-pricing-button-style4,
	.sh-pricing-button-style11,
	.sh-revslider-button2,
	.sh-portfolio-default2 .sh-portfolio-title,
	.sh-recent-posts-widgets-count,
	.sh-filter-item.active:after,
	.blog-style-largedate .post-comments,
	.sh-video-player-image-play,
	.woocommerce .woocommerce-tabs li a:after,
	.sh-image-gallery .slick-dots li.slick-active button,
	.sh-recent-posts-carousel .slick-dots li.slick-active button,
	.sh-recent-products-carousel .slick-dots li.slick-active button,
	.sh-settings-container-bar .sh-progress-status-value,
	.post-password-form input[type="submit"],
	.wpcf7-form .wpcf7-submit,
	.sh-portfolio-filter-style3 .sh-filter-item.active .sh-filter-item-content,
	.sh-portfolio-filter-style4 .sh-filter-item:hover .sh-filter-item-content,
	.sh-woocommerce-categories-count,
	.sh-woocommerce-products-style2 .woocommerce ul.products li.product .add_to_cart_button:hover,
	.woocomerce-styling.sh-woocommerce-products-style2 ul.products li.product .add_to_cart_button:hover,
	.sh-icon-group-style2 .sh-icon-group-item:hover,
	.sh-text-background {
		background-color: <?php echo esc_attr( $accent_color ); ?>!important;
	}

	::selection {
		background-color: <?php echo esc_attr( $accent_color ); ?>!important;
		color: #fff;
	}
	::-moz-selection {
		background-color: <?php echo esc_attr( $accent_color ); ?>!important;
		color: #fff;
	}

	.woocommerce .woocommerce-tabs li.active a,
	.sh-header-8 .sh-nav > .current-menu-item a {
		border-bottom-color: <?php echo esc_attr( $accent_color ); ?>!important;
	}

	#header-quote,
	.sh-dropcaps-full-square-tale:after,
	.sh-blog-tag-item:after,
	.widget_tag_cloud a:hover:after,
	.widget_product_tag_cloud a:hover:after {
		border-left-color: <?php echo esc_attr( $accent_color ); ?>!important;
	}

	.cart-icon .cart-icon-triangle-color {
		border-right-color: <?php echo esc_attr( $accent_color ); ?>!important;
	}

	.sh-back-to-top:hover,
	.widget_price_filter .ui-slider .ui-slider-handle,
	.sh-sidebar-search-active .search-field:hover,
	.sh-sidebar-search-active .search-field:focus {
		border-color: <?php echo esc_attr( $accent_color ); ?>!important;
	}

	.post-item .post-category .arrow-right {
		border-left-color: <?php echo esc_attr( $accent_color ); ?>;
	}

	<?php if($accent_hover_color) : ?>
		.woocommerce .wc-forward:hover,
		.woocommerce .button:not(.add_to_cart_button):hover,
		.woocommerce .checkout-button:hover,
		.woocommerce #respond input#submit:hover,
		.contact-form input[type="submit"]:hover,
		.wpcf7-form .wpcf7-submit:hover,
		.sh-video-player-image-play:hover,
		.sh-404-button:hover,
		.post-password-form input[type="submit"],
		.sh-pricing-button-style11:hover,
		.sh-revslider-button2.spacing-animation:hover {
			background-color: <?php echo esc_attr( $accent_hover_color ); ?>!important;
		}
	<?php endif; ?>

	.sh-mini-overlay-container,
	.sh-portfolio-overlay-info-box,
	.sh-portfolio-overlay-bottom .sh-portfolio-icon,
	.sh-portfolio-overlay-bottom .sh-portfolio-text,
	.sh-portfolio-overlay2-bar,
	.sh-portfolio-overlay2-data,
	.sh-portfolio-overlay3-data {
		background-color: <?php echo esc_attr( jevelin_hex2rgba( $accent_color, 0.75 ) ); ?>!important;
	}

	.widget_price_filter .ui-slider .ui-slider-range {
		background-color: <?php echo esc_attr( jevelin_hex2rgba( $accent_color, 0.50 ) ); ?>!important;
	}

	.sh-team-social-overlay2 .sh-team-image:hover .sh-team-overlay2,
	.sh-overlay-style1,
	.sh-portfolio-overlay4 {
		background-color: <?php echo esc_attr( jevelin_hex2rgba( $accent_color, 0.80 ) ); ?>!important;
	}


<?php
/*-----------------------------------------------------------------------------------*/
/* Links
/*-----------------------------------------------------------------------------------*/
?>

	<?php if( $link_color ) : ?>
		a {
			color: <?php echo esc_attr( $link_color ); ?>;
		}
	<?php endif; ?>

	<?php if( $link_hover_color ) : ?>
		a:hover,
		a:focus,
		.post-meta-two a:hover  {
			color: <?php echo esc_attr( $link_hover_color ); ?>;
		}
	<?php endif; ?>


<?php
/*-----------------------------------------------------------------------------------*/
/* Headings
/*-----------------------------------------------------------------------------------*/
?>

	body h1,
	body h2,
	body h3,
	body h4,
	body h5,
	body h6 {
		<?php echo wp_kses_post( $headings ); ?>
	}

	.sh-heading-font,
	.masonry2 .post-meta-one,
	.masonry2 .post-meta-two,
	.sh-countdown > div > span,
	.sh-woocommerce-products-style2 ul.products li.product .price,
	.sh-blog-style2 .widget_product_tag_cloud a,
	.sh-blog-style2 .widget_tag_cloud a,
	.sh-blog-style2 .sh-recent-posts-widgets-item-content .post-meta-categories,
	.sh-blog-style2 .post-meta-categories,
	.sh-blog-style2 .post-item-single .post-meta-data,
	.rev_slider .sh-rev-blog .sh-revslider-button2,
	.sh-portfolio-filter-style4 .sh-filter span {
		font-family: <?php echo esc_attr( $heading_font ); ?>;
	}

	<?php if( $heading1 ) : ?>
		h1 {
			font-size: <?php echo esc_attr( $heading1 ); ?>px;
		}
	<?php endif; ?>

	<?php if( $heading2 ) : ?>
		h2 {
			font-size: <?php echo esc_attr( $heading2 ); ?>px;
		}
	<?php endif; ?>

	<?php if( $heading3 ) : ?>
		h3 {
			font-size: <?php echo esc_attr( $heading3 ); ?>px;
		}
	<?php endif; ?>

	<?php if( $heading4 ) : ?>
		h4 {
			font-size: <?php echo esc_attr( $heading4 ); ?>px;
		}
	<?php endif; ?>

	<?php if( $heading5 ) : ?>
		h5 {
			font-size: <?php echo esc_attr( $heading5 ); ?>px;
		}
	<?php endif; ?>

	<?php if( $heading6 ) : ?>
		h6 {
			font-size: <?php echo esc_attr( $heading6 ); ?>px;
		}
	<?php endif; ?>

	.sh-progress-style1 .sh-progress-title,
	.sh-progress-style1 .sh-progress-value2,
	.sh-progress-style4 .sh-progress-title,
	.sh-progress-style4 .sh-progress-value2,
	.sh-progress-style5 .sh-progress-title,
	.widget_price_filter .price_slider_wrapper .price_label span,
	.product_list_widget a span,
	.woocommerce .product .woo-meta-title,
	.woocommerce .product .price ins,
	.woocommerce .product .price .amount,
	.woocommerce-checkout #payment ul.payment_methods li,
	table th,
	.woocommerce-checkout-review-order-table .order-total span,
	.sh-comment-form label,
	.sh-piechart-percentage,
	.woocommerce table.shop_table a.remove:hover:before,
	.woocommerce .woocommerce-tabs .commentlist .comment-text .meta strong,
	.sh-pricing-amount,
	.sh-pricing-icon,
	.sh-countdown > div > span,
	.blog-single .post-title h1:hover,
	.blog-single .post-title h2:hover,
	.post-meta-author a:hover,
	.post-meta-categories a:hover,
	.post-meta-categories span:hover,
	.woocommerce table.shop_table.cart a,
	.wrap-forms label,
	.wpcf7-form p,
	.post-password-form label,
	.product_list_widget ins,
	.product_list_widget .amount,
	.sh-social-share-networks .jssocials-share:hover i,
	.sh-page-links p,
	.woocommerce ul.products li.product .add_to_cart_button:hover {
		color: <?php echo esc_attr( $heading_color ); ?>!important;
	}


<?php
/*-----------------------------------------------------------------------------------*/
/* Header
/*-----------------------------------------------------------------------------------*/
?>

	<?php if( $header_background_color ) : ?>
		.sh-header,
		.sh-header-top,
		.sh-header-mobile,
		.sh-header-left-side {
			background-color: <?php echo esc_attr( $header_background_color ); ?>;
		}
	<?php endif; ?>

	<?php if( $topbar_background_color ) : ?>
		.primary-desktop .sh-header-top {
			background-color: <?php echo esc_attr( $topbar_background_color ); ?>!important;
		}
	<?php endif; ?>

	<?php if( $topbar_color ) : ?>
		.primary-desktop .header-contacts-details,
		.primary-desktop .header-social-media a {
			color: <?php echo esc_attr( $topbar_color ); ?>;
		}
	<?php endif; ?>

	<?php if( $header_background_image ) : ?>
		.sh-header,
		.sh-header-mobile-navigation,
		.sh-header-left-side {
			background-image: url(<?php echo esc_url( $header_background_image ); ?>);
			background-size: cover;
			background-position: 50% 50%;
		}
	<?php endif; ?>

	<?php if( $header_uppercase == true ) : ?>
		.sh-header .sh-nav > li.menu-item > a,
		.sh-header-left-side .sh-nav > li.menu-item > a,
		.sh-nav-mobile li a {
			text-transform: uppercase;
		}
	<?php endif; ?>

	<?php if( $header_text_color ) : ?>
		.sh-header-left-1 .header-bottom,
		.sh-header-left-1 .header-social-media i,
		.sh-header-left-1 .sh-side-button-search i,
		.sh-header-left-1 .sh-side-button-cart .sh-nav-cart i,
		.sh-header-left-side .header-bottom,
		.sh-header-left-2 .header-social-media i {
			color: <?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>

	<?php if( $header_nav_color ) : ?>
		.sh-header-search-close i,
		.sh-header .sh-nav > li.menu-item > a,
		.sh-header .sh-nav > li.menu-item > a > i,
		.sh-header-mobile-navigation li.menu-item > a > i,
		.sh-header-left-side li.menu-item > a,
		.sh-header-left-2 .sh-side-button-search, .sh-header-left-2 .sh-side-button-cart,
		.sh-header-left-2 .sh-side-button-cart .sh-nav-cart i,
		.sh-header-left-2 .sh-nav li.menu-item > a.fa:before {
			color: <?php echo esc_attr( $header_nav_color ); ?>;
		}

		.sh-header .c-hamburger span,
		.sh-header .c-hamburger span:before,
		.sh-header .c-hamburger span:after,
		.sh-header-mobile-navigation .c-hamburger span,
		.sh-header-mobile-navigation .c-hamburger span:before,
		.sh-header-mobile-navigation .c-hamburger span:after {
			background-color: <?php echo esc_attr( $header_nav_color ); ?>;
		}

		.sh-header .sh-nav-login #header-login > span {
			border-color: <?php echo esc_attr( $header_nav_color ); ?>;
		}
	<?php endif; ?>


	<?php if( $header_nav_font ) : ?>
		<?php if( $header_nav_font == 'additional1' || $header_nav_font == 'additional2' || $header_nav_font == 'heading' ) : ?>
			.sh-nav > li.menu-item > a {

				<?php if( $header_nav_font == 'additional1' ) : ?>
					font-family: '<?php echo jevelin_option_value('additional_font1','family'); ?>'!important;
				<?php elseif($header_nav_font == 'additional2' ) : ?>
					font-family: '<?php echo jevelin_option_value('additional_font2','family'); ?>'!important;
				<?php elseif( $header_nav_font == 'heading' ) : ?>
					font-family: '<?php echo jevelin_option_value('styling_headings','family'); ?>'!important;
				<?php endif; ?>

			}
		<?php endif; ?>
	<?php endif; ?>


	<?php if( $header_nav_size ) : ?>
		.sh-nav > li.menu-item > a,
		.sh-nav-mobile li a {
			font-size: <?php echo esc_attr( jevelin_addpx($header_nav_size) ); ?>;
		}
	<?php endif; ?>


	<?php if( $header_nav_hover_color ) : ?>
		.sh-header .sh-nav > li.menu-item:hover:not(.sh-nav-social) > a,
		.sh-header .sh-nav > li.menu-item:hover:not(.sh-nav-social) > a > i,
		.sh-header .sh-nav > li.sh-nav-social > a:hover > i,
		.sh-header-mobile-navigation li > a:hover > i,
		.sh-header-left-side li.menu-item > a:hover {
			color: <?php echo esc_attr( $header_nav_hover_color ); ?>;
		}
	<?php endif; ?>

	<?php if( $header_nav_active_color ) : ?>
		.sh-header .sh-nav > .current_page_item > a,
		.sh-header .sh-nav > .current-menu-ancestor > a,
		.sh-header-left-side .sh-nav > .current_page_item > a {
			color: <?php echo esc_attr( $header_nav_active_color ); ?>!important;
		}
	<?php endif; ?>

	<?php if( $header_nav_active_background_color ) : ?>
		.sh-header .sh-nav > .current_page_item,
		.sh-header-left-2 .sh-nav > li.current-menu-item {
			background-color: <?php echo esc_attr( $header_nav_active_background_color ); ?>!important;
		}
	<?php endif; ?>

	<?php if( $header_height ) : ?>
		.header-logo img {
			height: <?php echo esc_attr( jevelin_logo_height() ); ?>;
			max-height: 250px;
		}

		.sh-header-mobile-navigation .header-logo img {
			height: <?php echo esc_attr( jevelin_logo_height( 'responsive' ) ); ?>;
			max-height: 250px;
		}

		.sh-sticky-header-active .header-logo img {
			height: <?php echo esc_attr( jevelin_logo_height( 'sticky' ) ); ?>;
		}

		.sh-header-6 .sh-nav > .menu-item:not(.sh-nav-social),
		.sh-header-6 .sh-nav > .sh-nav-social a {
			height: <?php echo esc_attr( $header_height ); ?>px;
			width: <?php echo esc_attr( $header_height ); ?>px;
		}

		.sh-header-5 .sh-nav > .menu-item {
			height: <?php echo esc_attr( $header_height ); ?>px!important;
			max-height: <?php echo esc_attr( $header_height ); ?>px!important;
		}

		.sh-header-5 .sh-nav > .menu-item > a,
		.sh-header-6 .sh-nav > .menu-item > a {
			line-height: <?php echo esc_attr( $header_height ); ?>px!important;
			max-height: <?php echo esc_attr( $header_height ); ?>px!important;
			height: <?php echo esc_attr( $header_height ); ?>px!important;
		}

		.sh-header-5 .sh-nav > .current_page_item {
			margin-top: <?php echo (( esc_attr( $header_height ) -40)/2); ?>px!important;
			margin-bottom: <?php echo (( esc_attr( $header_height ) -40)/2); ?>px!important;
		}
	<?php endif; ?>

	<?php if( $header_border_color ) : ?>
		.sh-header,
		.sh-header-top-3,
		.sh-header-top-4,
		.sh-header-left-side .sh-header-search .line-test,
		.sh-header-left-2 .sh-nav > li > a,
		.sh-header-left-2 .sh-side-buttons .sh-table-cell, {
			border-bottom: 1px solid <?php echo esc_attr( $header_border_color ); ?>;
		}

		.sh-header-top-3 .header-contacts-item span,
		.sh-header-top-3 .header-social-media a,
		.sh-header-5 .sh-nav-login,
		.sh-header-5 .sh-nav-cart,
		.sh-header-5 .sh-nav-search,
		.sh-header-5 .sh-nav-social,
		.sh-header-5 .sh-nav-social a:not(:first-child),
		.sh-header-6 .sh-nav > .menu-item:not(.sh-nav-social),
		.sh-header-6 .sh-nav > .sh-nav-social a,
		.sh-header-6 .header-logo,
		.sh-header-left-1 .header-social-media a {
			border-left: 1px solid <?php echo esc_attr( $header_border_color ); ?>;
		}

		.sh-header-top-3 .container,
		.sh-header-5 .sh-nav > .menu-item:last-child,
		.sh-header-6 .sh-nav > .menu-item:last-child,
		.sh-header-6 .header-logo,
		.sh-header-left-side,
		.sh-header-left-1 .sh-side-button-search,
		.sh-header-left-2 .sh-side-button-search {
			border-right: 1px solid <?php echo esc_attr( $header_border_color ); ?>;
		}

		.sh-header-left-1 .header-social-media,
		.sh-header-left-1 .sh-side-buttons .sh-table-cell,
		.sh-header-left-2 .sh-side-buttons .sh-table-cell {
			border-top: 1px solid <?php echo esc_attr( $header_border_color ); ?>;
		}
	<?php endif; ?>

	<?php if( $header_width == 'full' ) : ?>
		.sh-header:not(.sh-header-6) .container,
		.sh-header-top:not(.sh-header-top-6) .container {
			width: 90%!important;
			max-width: 90%!important;
		}

		.sh-header-6 .container,
		.sh-header-top-6 .container {
			width: 100%!important;
			max-width: 100%!important;
		}
	<?php endif; ?>


<?php
/*-----------------------------------------------------------------------------------*/
/* Menu
/*-----------------------------------------------------------------------------------*/
?>

 	<?php if( $menu_background_color ) : ?>
		.sh-header-right-side,
		.sh-header-mobile-dropdown,
		.header-mobile-social-media a,
		.sh-header .sh-nav > li.menu-item ul,
		.sh-header-left-side .sh-nav > li.menu-item ul,
		.sh-header-mobile-dropdown {
			background-color: <?php echo esc_attr( $menu_background_color ); ?>!important;
		}
	<?php endif; ?>

 	<?php if( $menu_link_border_color ) : ?>
		.sh-nav-mobile li:after,
		.sh-nav-mobile ul:before {
			background-color: <?php echo esc_attr( $menu_link_border_color ); ?>!important;
		}
	<?php endif; ?>

 	<?php if( $menu_link_color ) : ?>
		.header-mobile-social-media a i,
		.sh-nav-mobile li a,
		.sh-header .sh-nav > li.menu-item ul a,
		.sh-header-left-side .sh-nav > li.menu-item ul a {
			color: <?php echo esc_attr( $menu_link_color ); ?>!important;
		}
	<?php endif; ?>

	.sh-nav-mobile .current_page_item > a,
	.sh-nav-mobile > li a:hover,
	.sh-header .sh-nav ul,
	.sh-header .sh-nav > li.menu-item:not(.menu-item-cart) ul a:hover,
	.sh-header .sh-nav ul.mega-menu-row li.mega-menu-col > a,
	.sh-header-left-side .sh-nav ul,
	.sh-header-left-side .sh-nav > li.menu-item:not(.menu-item-cart) ul a:hover,
	.sh-header-left-side .sh-nav ul.mega-menu-row li.mega-menu-col > a,
	.sh-header .woocommerce a.remove:hover:before,
	.sh-header-left-side .woocommerce a.remove:hover:before {
		color: <?php echo esc_attr( $menu_link_hover_color ); ?>!important;
	}

	.header-mobile-social-media,
	.header-mobile-social-media a,
	.sh-nav > li.menu-item:not(.menu-item-cart) ul a:hover {
		border-color: <?php echo esc_attr( $menu_link_border_color ); ?>!important;
	}

	.sh-nav > li.menu-item:not(.menu-item-cart) ul a:hover,
	.sh-nav-cart .menu-item-cart .total {
		border-bottom: 1px solid <?php echo esc_attr( $menu_link_border_color ); ?>!important;
	}

	.sh-nav-cart .menu-item-cart .total {
		border-top: 1px solid <?php echo esc_attr( $menu_link_border_color ); ?>!important;
	}

	.sh-nav .mega-menu-row > li.menu-item,
	.sh-nav-cart .menu-item-cart .widget_shopping_cart_content p.buttons a:first-child {
		border-right: 1px solid <?php echo esc_attr( $menu_link_border_color ); ?>!important;
	}


<?php
/*-----------------------------------------------------------------------------------*/
/* Sidebar
/*-----------------------------------------------------------------------------------*/
?>

	#sidebar .widget-item .widget-title {
		<?php echo wp_kses_post( $sidebar_headings ); ?>
	}

	<?php if( $sidebar_border_color ) : ?>
		#sidebar .widget-item li {
			border-color: <?php echo esc_attr( $sidebar_border_color ); ?>!important;
		}
	<?php endif; ?>


<?php
/*-----------------------------------------------------------------------------------*/
/* Footer
/*-----------------------------------------------------------------------------------*/
?>

	<?php if( $footer_width == 'full' ) : ?>
		@media (min-width: 1000px) {
			.sh-footer .container {
				width: 90%!important;
				max-width: 90%!important;
			}
		}
	<?php endif; ?>

	.sh-footer {
		<?php if( $footer_background_image ) : ?>
			background-image: url(<?php echo esc_url ($footer_background_image ); ?>);
		<?php endif; ?>
		background-size: cover;
		background-position: 50% 50%;
	}

	.sh-footer .sh-footer-widgets {
		background-color: <?php echo esc_attr( $footer_background_color ); ?>;
		color: <?php echo esc_attr( $footer_text_color ); ?>;
	}

	.sh-footer .sh-footer-widgets .sh-recent-posts-widgets-item-meta a {
		color: <?php echo esc_attr( $footer_text_color ); ?>;
	}

	.sh-footer .sh-footer-widgets i:not(.icon-link),
	.sh-footer .sh-footer-widgets .widget_recent_entries li:before {
		color: <?php echo esc_attr( $footer_icon_color ); ?>!important;
	}

	.sh-footer .sh-footer-widgets h3 {
		<?php echo wp_kses_post( $footer_headings ); ?>
	}

	.sh-footer .sh-footer-widgets ul li,
	.sh-footer .sh-footer-widgets ul li,
	.sh-footer .sh-recent-posts-widgets .sh-recent-posts-widgets-item {
		border-color: <?php echo esc_attr( $footer_border_color ); ?>;
	}

	.sh-footer .sh-footer-widgets a,
	.sh-footer .sh-footer-widgets li a,
	.sh-footer .sh-footer-widgets h6 {
		color: <?php echo esc_attr( $footer_link_color ); ?>;
	}

	.sh-footer .sh-footer-widgets .product-title,
	.sh-footer .sh-footer-widgets .woocommerce-Price-amount {
		color: <?php echo esc_attr( $footer_link_color ); ?>!important;
	}

	.sh-footer .sh-footer-widgets a:hover,
	.sh-footer .sh-footer-widgets li a:hover,
	.sh-footer .sh-footer-widgets h6:hover {
		color: <?php echo esc_attr( $footer_hover_color ); ?>;
	}

	.sh-footer-columns > .widget-item {
		<?php if( $footer_columns == 1 ) : ?>
			width: 100%!important;
		<?php elseif( $footer_columns == 2 ) : ?>
			width: 50%!important;
		<?php elseif( $footer_columns == 4 ) : ?>
			width: 25%!important;
		<?php elseif( $footer_columns == 5 ) : ?>
			width: 20%!important;
		<?php endif; ?>
	}

	.sh-footer .sh-copyrights {
		background-color: <?php echo esc_attr( $copyright_background_color ); ?>;
		color: <?php echo esc_attr( $copyright_text_color ); ?>;
	}

	.sh-footer .sh-copyrights a {
		color: <?php echo esc_attr( $copyright_link_color ); ?>;
	}

	.sh-footer .sh-copyrights a:hover {
		color: <?php echo esc_attr( $copyright_hover_color ); ?>!important;
	}

	.sh-footer .sh-copyrights-social a {
		border-left: 1px solid <?php echo esc_attr( $copyright_border_color ); ?>;
	}

	.sh-footer .sh-copyrights-social a:last-child {
		border-right: 1px solid <?php echo esc_attr( $copyright_border_color ); ?>;
	}

	@media (max-width: 850px) {
		.sh-footer .sh-copyrights-social a {
			border: 1px solid <?php echo esc_attr( $copyright_border_color ); ?>;
		}
	}


<?php
/*-----------------------------------------------------------------------------------*/
/* WooCommerce
/*-----------------------------------------------------------------------------------*/
?>

	.woocommerce .woocomerce-styling ul.products li {
		<?php if( $wc_columns == 3 ) : ?>
			width: 33.3%;
		<?php elseif( $wc_columns == 2 ) : ?>
			width: 50%;
		<?php else : ?>;
			width: 25%;
		<?php endif; ?>
	}


	<?php if( $popover_font == 'additional1' || $popover_font == 'additional2' || $popover_font == 'body' ) : ?>
		.sh-popover-mini {

			<?php if( $popover_font == 'additional1' ) : ?>
				font-family: '<?php echo esc_attr( jevelin_option_value('additional_font1','family') ); ?>'!important;
			<?php elseif( $popover_font == 'additional2' ) : ?>
				font-family: '<?php echo esc_attr( jevelin_option_value('additional_font2','family') ); ?>'!important;
			<?php elseif( $popover_font == 'body' ) : ?>
				font-family: '<?php echo esc_attr( jevelin_option_value('styling_body','family') ); ?>'!important;
			<?php endif; ?>

		}
	<?php endif; ?>

	.sh-popover-mini:not(.sh-popover-mini-dark) {
		background-color: <?php echo esc_attr( $popover_color ); ?>;
	}

	.sh-popover-mini:not(.sh-popover-mini-dark):before {
		border-color: transparent transparent <?php echo esc_attr( $popover_color ); ?> <?php echo esc_attr( $popover_color ); ?>!important;
	}


<?php
/*-----------------------------------------------------------------------------------*/
/* Post Overlay
/*-----------------------------------------------------------------------------------*/
?>

	<?php if( $post_overlay == 'style2' ) : ?>
		.post-container .sh-overlay-style1 .sh-overlay-item:first-child {
			width: 100%;
			cursor: pointer;
		}

		.post-container .sh-overlay-style1 .sh-overlay-item:first-child .sh-overlay-item-container {
			left: 50%;
			right: auto;
			transform: translateX(-40px) translateY(-30px);
		}

		.post-container .sh-overlay-style1 .sh-overlay-item:last-child {
			display: none;
		}
	<?php elseif( $post_overlay == 'style3' ) : ?>
		.post-container .sh-overlay-style1 .sh-overlay-item:first-child {
			width: 100%;
			border: none;
			opacity: 0;
			cursor: pointer;
		}

		.post-container .sh-overlay-style1 .sh-overlay-item:last-child {
			display: none;
		}
	<?php endif; ?>


<?php
/*-----------------------------------------------------------------------------------*/
/* Page Layout
/*-----------------------------------------------------------------------------------*/
?>

	<?php if( $page_layout == 'boxed' && $header_layout != 'left-1' && $header_layout != 'left-2' ) : ?>
		body {
			background-color: <?php echo esc_attr( $page_layout_atts['background_color'] ); ?>!important;
		}

		#page-container {
			position: relative;
			max-width: 1200px!important;
			margin: 0 auto;
			/*background-color: <?php echo esc_attr( $body_background ); ?>;*/

			<?php if( $page_layout_atts['border_style'] == 'shadow' ) : ?>
				box-shadow: 0px 6px 30px rgba(0,0,0,0.1);
			<?php elseif( $page_layout_atts['border_style'] == 'line' ) : ?>
				border-left: 1px solid rgba(0,0,0,0.07);
				border-right: 1px solid rgba(0,0,0,0.07);
				border-bottom: 1px solid rgba(0,0,0,0.07);
			<?php endif; ?>
		}

		#page-container .container {
			width: 100%!important;
			min-width: 100%!important;
			max-width: 100%!important;
			padding-left: 45px!important;
			padding-right: 45px!important;
		}

		.sh-sticky-header-active {
			max-width: 1200px!important;
			margin: 0 auto;
		}
	<?php endif; ?>


<?php
/*-----------------------------------------------------------------------------------*/
/* Titlebar
/*-----------------------------------------------------------------------------------*/
?>

	<?php if( $topbar_status == false ) : ?>
		.sh-header-top {
			display: none!important;
		}
	<?php endif; ?>

	<?php if( jevelin_option_image( 'titlebar-background' ) ) : ?>
		.sh-titlebar {
			background-image: url(<?php echo esc_url( jevelin_option_image( 'titlebar-background' ) ); ?>);
		}
	<?php endif; ?>

	<?php if( jevelin_option( 'titlebar-background-color' ) ) : ?>
		.sh-titlebar {
			background-color: <?php echo esc_attr( jevelin_option( 'titlebar-background-color') ); ?>;
		}
	<?php endif; ?>

	<?php if( jevelin_option( 'titlebar-title-color' ) ) : ?>
		.sh-titlebar .titlebar-title h1 {
			color: <?php echo esc_attr( jevelin_option( 'titlebar-title-color') ); ?>;
		}
	<?php endif; ?>

	<?php if( jevelin_option( 'titlebar-breadcrumbs-color' ) ) : ?>
		.sh-titlebar .title-level a,
		.sh-titlebar .title-level span {
			color: <?php echo esc_attr( jevelin_option( 'titlebar-breadcrumbs-color') ); ?>!important;
		}
	<?php endif; ?>


<?php
/*-----------------------------------------------------------------------------------*/
/* Crispy Images
/*-----------------------------------------------------------------------------------*/
?>

	<?php if( $crispy_images == true ) : ?>
		img,
		.sh-column,
		.sh-section {
			-webkit-backface-visibility: hidden;
		}
	<?php endif; ?>



<?php
/*-----------------------------------------------------------------------------------*/
/* RTL Support
/*-----------------------------------------------------------------------------------*/
?>

	<?php if( $rtl_support == true ) : ?>
		body {
			text-align: right;
		}

		.sh-portfolio-widget-item {
			float: right;
		}

		.widget_product_categories li .count, .widget_categories li .count,
		.sh-comments-required-notice {
			float: left;
		}

		.widget_search .search-field {
			text-align: right;
		}

		.widget_search .search-submit {
			right: auto;
			left: 5px;
		}

		.sh-recent-posts-widgets-item-thumb {
			right: 0;
			left: auto;
		}

		.sh-recent-posts-widgets-item-content {
			padding-left: 0px;
			padding-right: 80px;
		}

		.sh-titlebar .titlebar-title,
		.sh-portfolio-overlay-style-overlay4 .sh-portfolio-content-container > div:first-child,
		.sh-blog-single-meta > div:first-child,
		.post-meta-one,
		.post-meta-comments > span,
		.sh-event-container > div:first-child {
			float: right!important;
		}

		.sh-titlebar .title-level,
		.sh-social-share-networks,
		.sh-portfolio-overlay-style-overlay4 .sh-portfolio-content-container > div:last-child,
		.sh-blog-single-meta > div:last-child,
		.post-meta-comments > a,
		.sh-event-container > div:last-child {
			float: left!important;
		}

		.simpleselect .placeholder:after {
			right: auto;
			left: 20px;
		}

		.blog-single .sh-page-switcher {
			margin-left: 0;
		}

		.sh-blog-social div {
			max-width: 600px;
		}

		.sh-contacts-widget-item {
			padding-left: 0px;
			padding-right: 40px!important;
		}

		.sh-contacts-widget-item i {
			right: 0!important;
			left: auto;
		}

		.sh-event-container .sh-event-title {
		    border-left-width: 0px;
		    border-right-width: 3px;
		    border-right-style: solid;
		    padding-right: 10px;
		}

		.sh-testimonials-item-container {
			text-align: right!important;
		}

		.sh-testimonials-style5 .sh-testimonials-table-icon {
			text-align: left;
		}

		.sh-header-left-side .sh-nav > li.menu-item > a {
			text-align: center;
		}

		/*.sh-header-left-side .sh-nav > li.menu-item > a {
			text-align: right;
			padding-right: 35px;
		}

		.sh-header-left-side.sh-header-left-2 .sh-nav > li.menu-item > a {
			padding-right: 60px!important;
		}*/

		.sh-tabs-filter li {
			float: right;
			padding-left: 10px;
		}

		.titlebar-title-h1 {
			text-align: right;
		}

		.sh-nav li.menu-item li.menu-item-has-children > a:after {
			float: left;
		}

		.sh-list-icon {
			display: block
		}

		.sh-list-icon i {
			float: right;
			display: block;
			width: 30px;
		}

		.sh-list-item:after,
		.post-content:before,
		.sh-portfolio-content-container:after {
			content: "";
			display: block;
			clear: both;
		}

		.sh-popover-mini {
			right: 0;
			left: auto;
		}

		.post-item h2,
		.post-item .post-content {
			text-align: right;
		}

		input,
		textarea {
			text-align: right;
		}

		.sh-nav {
			float: left;
		}

		.sh-header .sh-nav li.menu-item:first-child {
			padding-left: 0px!important;
		}

		.sh-header:not(.sh-header-7) .header-logo {
			float: right;
		}

		.sh-copyrights-logo {
			padding-right: 0px;
			padding-left: 25px;
		}

		.sh-nav ul.sub-menu li .quantity {
			float: right;
		}

		.sh-nav .sh-nav-cart li.mini_cart_item a {
			text-align: right;
		}

		.sh-nav .sh-nav-cart li.mini_cart_item a.remove {
			left: 0px;
			right: 0px;
			top: 2px;
		}

		.sh-nav-cart .menu-item-cart .attachment-shop_thumbnail {
			margin-left: 30px!important;
		}

		.sh-header-search-submit {
			left: 32px;
			right: 0px;
		}

		.sh-header-search-close {
			left: 0px;
			right: auto;
		}

		.sh-header-search .sh-header-search-input {
			padding-right: 0px;
		}

		.menu-item.sh-nav-search {
			padding: 0!important;
		}

		.sh-header-5 .menu-item.sh-nav-search {
			padding: 0 15px!important;
		}

		.header-social-media {
			text-align: left;
		}

		.header-contacts-item .header-contacts-details:last-child {
			padding-right: 0px;
		}

		.sh-header-top-2 .header-social-media a:first-child {
			padding-left: 0px;
		}

		.sh-header-5 .sh-nav > .menu-item:last-child {
			padding-right: 15px!important;
		}

		.sh-header-7 .container .sh-table-cell:last-child .sh-nav-container {
			float: right;
		}

		.sh-progress-style4 .sh-progress-value2,
		.sh-progress-style5 .sh-progress-value2 {
			text-align: left;
		}

		.sh-counter-style3 .text-left {
			text-align: right;
			border-left-width: 0px;
			border-right-width: 1px;
			border-right-style: solid;
			padding-right: 18px;
		}

		.sh-counter-style3 .text-right {
			text-align: left;
			padding-left: 18px;
		}

		/* WooCommerce */

		.woocommerce .wc_payment_methods input[type=radio] {
			float: right;
		    bottom: -7px;
		    display: inline-block;
		    position: relative;
		    margin-left: 10px!important;
		}

		.woocommerce .wc_payment_methods .payment_method_paypal input[type=radio] {
		    bottom: -13px;
		}

		.woocommerce .wc_payment_methods label {
			float: right;
		}

		.woocommerce .wc_payment_methods p {
			float: right;
			width: 100%;
			text-align: right;
		}

		.woocommerce .wc-proceed-to-checkout .checkout-button {
			float: right!important;
		}

		.woocommerce .calculated_shipping td,
		.woocommerce .calculated_shipping th {
			text-align: right;
		}

		.woocommerce .cart-collaterals .cart_totals {
			width: 40%;
		}

		.woocommerce .woocomerce-styling ul.products li .star-rating {
			float: right;
		}

		.woocommerce .woocomerce-styling ul.products li .price,
		.woocommerce div.product .comment-text:after {
			content: "";
			display: block;
			clear: both;
		}

		.woocommerce div.product .woocommerce-product-rating,
		.woocommerce div.product .comment-text .star-rating {
			float: left;
		}

		.woocommerce .woocomerce-styling div.product .quantity {
			float: right!important;
		}

		.woocommerce .woocomerce-styling div.product .single_add_to_cart_button {
			float: left!important;
		}

		.woocommerce .woocomerce-styling div.product .sh-social-share-button {
			margin-right: 0px;
		}

	<?php endif; ?>


<?php
/*-----------------------------------------------------------------------------------*/
/* Back to top button - rounded
/*-----------------------------------------------------------------------------------*/
?>

	<?php if( $back_to_top_rounded == true ) : ?>
		.sh-back-to-top {
			border-radius: 100px;
		}
	<?php endif; ?>


<?php
/*-----------------------------------------------------------------------------------*/
/* 404 Page
/*-----------------------------------------------------------------------------------*/
?>

	.sh-404 {
		background-image: url(<?php echo esc_url( jevelin_option_image('404_image') ); ?>);
		background-color: <?php echo esc_attr( jevelin_option('404_background') ); ?>;
	}


<?php
/*-----------------------------------------------------------------------------------*/
/* Page Loader
/*-----------------------------------------------------------------------------------*/
$page_loader = 0;
if( jevelin_option('page_loader', 'off') != 'off' ) :
	if( jevelin_option('page_loader') == 'on2' ) :

		if (strpos(wp_get_referer(), esc_url( home_url('/') ) ) !== false) :
			$page_loader = 0;
		else :
			$page_loader = 1;
		endif;

	else :

		$page_loader = 1;

	endif;
endif;
?>

	<?php if( $page_loader == 1 ) : ?>
		body {
			overflow: hidden;
		}

		.sh-page-loader {
			background-color: <?php echo esc_attr( jevelin_option('page_loader_background_color') ); ?>;
		}

		.sk-cube-grid .sk-cube,
		.sk-folding-cube .sk-cube:before,
		.sk-spinner > div,
		.sh-page-loader-style-spinner .object {
			background-color: <?php echo ( jevelin_option('page_loader_accent_color') ) ? esc_attr(jevelin_option('page_loader_accent_color')) : esc_attr(jevelin_option('accent_color')); ?>!important;
		}
	<?php endif; ?>

<?php
/*-----------------------------------------------------------------------------------*/
/* Page - White Borders
/*-----------------------------------------------------------------------------------*/
?>

	<?php if( $white_borders == true ) : ?>
		<?php if( $white_borders_only_on_pages == false || is_page() ) : ?>
			body.admin-bar.page-white-borders .sh-window-line.line-top,
			body.admin-bar.page-white-borders .sh-window-line.line-left,
			body.admin-bar.page-white-borders .sh-window-line.line-right {
				top: 32px;
			}

			body.page-white-borders #page-container {
				padding-top: 20px;
			}

			body.admin-bar.page-white-borders #page-container {
				padding-top: 52px!important;
			}

			body.page-white-borders.page-layout-right-fixed .sh-window-line.line-top {
				top: 0!important;
			}

			body.page-white-borders .sh-sticky-header-active {
				top: 20px!important;
				left: 20px!important;
				right: 20px!important;
				width: auto!important;
			}

			body.admin-bar.page-white-borders .sh-sticky-header-active {
				top: 52px!important;
			}
		<?php endif; ?>
	<?php endif; ?>

<?php else : ?>

	.post-title h2:hover {
		color: #47c9e5;
	}

	.blog-single .post-title h1:hover,
	.blog-single .post-title h2:hover,
	.post-meta-author a:hover,
	.post-meta-categories a:hover,
	.post-meta-categories span:hover,
	.post-password-form label,
	.sh-page-links p {
		color: #3f3f3f!important;
	}

	.sh-tabs-filter li a,
	.woocommerce .woocommerce-tabs li:not(.active) a,
	.woocommerce .product .posted_in a,
	.woocommerce .product .tagged_as a,
	.woocommerce .product .woocommerce-review-link,
	.woocommerce-checkout #payment div.payment_box,
	.sh-default-color a,
	.sh-default-color,
	.post-meta-two a,
	#sidebar a,
	.logged-in-as a ,
	.post-meta-author a,
	.sh-social-share-networks .jssocials-share i {
		color: #8d8d8d!important;
	}

	.sh-popover-mini,
	.woocommerce span.onsale,
	.sh-sidebar-search-active .search-field,
	.post-password-form input[type="submit"] {
		background-color: #47c9e5;
	}

	.post-password-form input[type="submit"]:hover {
		background-color: #21bee2;
	}

	.sh-sidebar-search-active .search-field,
	.sh-sidebar-search-active .search-submit i {
		color: #fff;
	}

	.sh-popover-mini:before,
	.woocommerce span.onsale:before,
	.sh-sidebar-search-active .search-field {
		border-color: #47c9e5!important;
	}

	.woocommerce .product .price .amount {
		color: #505050;
	}

	.woocommerce .woocomerce-styling ul.products li {
		width: 25%;
	}

	.sh-back-to-top {
		border-radius: 100px;
	}

	/* Elements CSS */

<?php endif;
ob_end_flush();
?>
