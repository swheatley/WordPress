<?php
if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * Helper functions
 */


 /* Performance Menu */
 if ( ! function_exists( 'jevelin_is_performance' ) ) :
 	function jevelin_is_performance() {
        if( ( function_exists( 'fw_get_db_customizer_option' ) && fw_get_db_customizer_option('performance') == true ) ||
        ( function_exists( 'fw_get_db_settings_option' ) && fw_get_db_settings_option('performance') == true ) ) :
            return true;
        else :
            return false;
        endif;
 	}
 endif;


 /**
  * Render template
  */
if ( ! function_exists( 'jevelin_link_it' ) ) :
    function jevelin_link_it($text) {
        $text = preg_replace("/(^|[\n ])([\w]*?)([\w]*?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\" target=\"_blank\" >$3</a>", $text);
        $text = preg_replace("/(^|[\n ])([\w]*?)((www)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http://$3\" target=\"_blank\" >$3</a>", $text);
        $text = preg_replace("/(^|[\n ])([\w]*?)((ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"ftp://$3\" >$3</a>", $text);
        $text = preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"mailto:$2@$3\">$2@$3</a>", $text);
        return ( $text );
    }
endif;


/**
 * Render template
 */
if ( ! is_admin() ) {
    function jevelin_render_css() {
        //if( ( is_customize_preview() || ( is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX ) || defined( 'DOING_CRON' ) ) ) :

            ob_start();
            get_template_part( 'inc/templates/render-css' );
            $css = ob_get_clean();
            return $css;

        /*else :

            if( ( function_exists( 'fw_get_db_customizer_option' ) && fw_get_db_customizer_option('performance') == true ) ||
            ( function_exists( 'fw_get_db_settings_option' ) && fw_get_db_settings_option('performance') == true ) ) :

                $cache_css = get_transient( 'jevelin_css' );
                if( $cache_css ) :
                    return $cache_css;
                else :

                    ob_start();
                    get_template_part( 'inc/templates/render-css' );
                    $css = ob_get_clean();

                    set_transient( 'jevelin_css', $css, 12 * HOUR_IN_SECONDS );
                    return $css;

                endif;

            else :

                ob_start();
                get_template_part( 'inc/templates/render-css' );
                $css = ob_get_clean();
                return $css;

            endif;
        endif;*/

        /*ob_start();
        get_template_part( 'inc/templates/render-css' );
        $css = ob_get_clean();
        return $css;*/
    }
}


/**
 * Get page ID
 */
if ( ! function_exists( 'jevelin_page_id' ) ) :
function jevelin_page_id() {

    if( function_exists( 'is_shop' ) && is_shop() == true ) {
        $post_id = get_option( 'woocommerce_shop_page_id' );
    } else if( is_search() || is_archive() || is_404() ) {
        $post_id = false;
    } else if (in_the_loop()) {
        $post_id = get_the_ID();
    } else {
        global $wp_query;
        $post_id = $wp_query->get_queried_object_id();
    }

    return $post_id;

}
endif;


/* Load image ratio */
if ( ! function_exists( 'jevelin_image_ratio' ) ) :
	function jevelin_image_ratio( $id = '', $size = '', $ratio = '') {
        $load_ratio = '';
        if( $ratio == '') :
            $load_ratio = ' sh-ratio-container-square';
        endif;

        return '
        <div class="sh-ratio">
            <div class="sh-ratio-container'.$load_ratio.'">
                <div class="sh-ratio-content" style="background-image: url('.jevelin_get_small_thumb( get_post_thumbnail_id( $id ), $size ).');"></div>
            </div>
        </div>';
	}
endif;

/**
 * Get theme options
 */

if ( ! function_exists( 'jevelin_option' ) ) :
    if ( is_customize_preview() ) {

    	function jevelin_option( $id = NULL, $default = NULL) {

            if( function_exists('fw_get_db_settings_option') ) :

                global $wp_customize;
                $customizer_option = fw_get_db_customizer_option($id);
                return fw_get_db_customizer_option($id);


            elseif( !empty( $default ) ) :
                return $default;
            else :
                return false;
            endif;

    	}

    } else {

        function jevelin_option( $id = NULL, $default = NULL) {

            if( function_exists('fw_get_db_settings_option') ) :

                if( in_array( $id, array( 'accent_color', 'accent_hover_color', 'header_nav_active_color', 'footer_hover_color') ) ) :

                    if( $id == 'accent_color' && jevelin_post_option( jevelin_page_id(), 'accent_color' ) ) :
                        return jevelin_post_option( jevelin_page_id(), 'accent_color' );
                    elseif( $id == 'accent_hover_color' && jevelin_post_option( jevelin_page_id(), 'accent_hover_color' ) ) :
                        return jevelin_post_option( jevelin_page_id(), 'accent_hover_color' );
                    elseif( $id == 'header_nav_active_color' && jevelin_post_option( jevelin_page_id(), 'header_nav_active_color' ) ) :
                        return jevelin_post_option( jevelin_page_id(), 'header_nav_active_color' );
                    elseif( $id == 'footer_hover_color' && jevelin_post_option( jevelin_page_id(), 'footer_hover_color' ) ) :
                        return jevelin_post_option( jevelin_page_id(), 'footer_hover_color' );
                    else :
                        return fw_get_db_settings_option($id);
                    endif;

                else :
                    return fw_get_db_settings_option($id);
                endif;

            elseif( !empty( $default ) ) :
                return $default;
            else :
                return false;
            endif;

        }

    }
endif;


/**
 * Get theme options value
 */
if ( ! function_exists( 'jevelin_option_value' ) ) :
    function jevelin_option_value( $id = NULL, $key = NULL ) {

        if( $id && $key && function_exists('fw_get_db_settings_option') ) :
            $val = jevelin_option( $id );
            if( isset( $val[$key] ) ) :
                return esc_attr( $val[$key] );
            endif;
        else :
            return false;
        endif;

    }
endif;


/**
 * Get theme options image
 */
if ( ! function_exists( 'jevelin_option_image' ) ) :
    function jevelin_option_image( $id = NULL ) {

        if( function_exists('fw_get_db_settings_option') ) :
            $url = fw_get_db_settings_option( $id );
            if( isset( $url['url'] ) ) :
                return esc_url( $url['url'] );
            endif;
        else :
            return false;
        endif;

    }
endif;


/**
 * Get theme options thumbnail
 */
if ( ! function_exists( 'jevelin_get_thumb' ) ) :
    function jevelin_get_thumb( $id, $size = 'large' ) {
        if( isset( $id ) && $id > 0) :

            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($id), $size );
            if( isset($thumb['0']) && $thumb['0'] ) :
                return esc_url( $thumb['0'] );
            endif;

        else :
            return false;
        endif;
    }
endif;


/**
 * Get theme options thumbnail
 */
if ( ! function_exists( 'jevelin_get_small_thumb' ) ) :
    function jevelin_get_small_thumb( $id, $size = 'post-thumbnail' ) {
        if( isset( $id ) && $id > 0) :

            $thumb = wp_get_attachment_image_src( $id, $size );
            if( isset($thumb['0']) && $thumb['0'] ) :
                return esc_url( $thumb['0'] );
            endif;

        else :
            return false;
        endif;
    }
endif;


/**
 * Get post options
 */
if ( ! function_exists( 'jevelin_post_option' ) ) :
    function jevelin_post_option( $id = NULL, $name = NULL, $default = NULL) {

        if( function_exists('fw_get_db_post_option') && $id > 0 && $name ) :
            return fw_get_db_post_option( $id, $name, $default );
        elseif( !empty( $default ) ) :
            return $default;
        else :
            return false;
        endif;

    }
endif;


/**
 * Get option image
 */
if ( ! function_exists( 'jevelin_get_image' ) ) :
    function jevelin_get_image( $id = NULL ) {

        if( isset( $id['url'] ) ) :
            return esc_url( $id['url'] );
        elseif( isset( $id[0] ) ) :
            return esc_url( $id[0] );
        else :
            return false;
        endif;

    }
endif;


/**
 * Get option image alt
 */
if ( ! function_exists( 'jevelin_get_image_alt' ) ) :
    function jevelin_get_image_alt( $id = NULL ) {
        if( is_object( $id ) || is_array( $id ) ) :

            if( isset( $id['attachment_id'] ) ) :
                $post = get_post( $id['attachment_id'] );
                if( is_object( $post ) ) :
                    if( $post->post_excerpt ) :
                        return $post->post_excerpt;
                    else :
                        return $post->post_title;
                    endif;
                endif;
            else :
                return false;
            endif;

        elseif( $id > 0 ) :

            $post = get_post( $id );
            if( is_object( $post ) ) :
                if( $post->post_excerpt ) :
                    return $post->post_excerpt;
                else :
                    return $post->post_title;
                endif;
            endif;

        endif;

    }
endif;


/**
 * Get option image size
 */
if ( ! function_exists( 'jevelin_get_image_size' ) ) :
    function jevelin_get_image_size( $id, $size = 'large' ) {
        if( isset( $id['attachment_id'] ) && $id['attachment_id'] ) :

            $url = $id['attachment_id'];
            $thumb = wp_get_attachment_image_src( $url, $size );

            if( isset($thumb['0']) && $thumb['0'] ) :
                return esc_url( $thumb['0'] );
            else :
                return $id['url'];
            endif;

        else :
            return false;
        endif;
    }
endif;


/**
 * Get picker value
 */
if ( ! function_exists( 'jevelin_get_picker_value' ) ) :
    function jevelin_get_picker_value( $atts = NULL, $var = NULL ) {

        if( isset($atts[key($atts)]) ) :
            return $atts[key($atts)];
        else :
            return $var;
        endif;

    }
endif;


/**
 * Get picker
 */
if ( ! function_exists( 'jevelin_get_picker' ) ) :
    function jevelin_get_picker( $atts = NULL ) {

        if( is_array($atts) && $atts != NULL ) :
            $key = key($atts);
            if( isset($atts[$atts[$key]]) ) :
                return $atts[$atts[key($atts)]];
            else :
                return false;
            endif;
        endif;
    }
endif;


/**
 * Get font option
 */
if ( ! function_exists( 'jevelin_font_option' ) ) :
    function jevelin_font_option( $id ) {
        $option = jevelin_option( $id );
        $o = '';

        if( isset($option['family']) && $option['family'] ) :
            $o.= 'font-family: "'.$option['family'].'"; ';
        endif;

        if( isset($option['color']) && $option['color'] ) :
            $o.= 'color: '.$option['color'].'; ';
        endif;

        if( isset($option['letter-spacing']) && $option['letter-spacing'] ) :
            $o.= 'letter-spacing: '.$option['letter-spacing'].'px; ';
        endif;

        if( isset($option['variation']) && $option['variation'] && $option['variation'] != '100' ) :
            if( $option['variation'] == 'regular' ) :
                $o.= 'font-weight: 400; ';
            else :
                $o.= 'font-weight: '.$option['variation'].'; ';
            endif;
        /*elseif( isset($option['weight']) && $option['weight'] ) :
            $o.= 'font-weight: '.$option['weight'].'; ';*/
        endif;

        if( isset($option['size']) && $option['size'] ) :
            $o.= 'font-size: '.$option['size'].'px; ';
        endif;

        if( isset($option['line-height']) && $option['line-height'] ) :
            $o.= 'line-height: '.$option['line-height'].'px; ';
        endif;

        return $o;

    }
endif;


/**
 * Get font
 */
if ( ! function_exists( 'jevelin_get_font' ) ) :
    function jevelin_get_font( $option ) {
        $o = '';

        if( isset($option['family']) && $option['family'] ) :
            $o.= 'font-family: "'.$option['family'].'"; ';
        endif;

        if( isset($option['color']) && $option['color'] ) :
            $o.= 'color: '.$option['color'].'; ';
        endif;

        if( isset($option['letter-spacing']) && $option['letter-spacing'] ) :
            $o.= 'letter-spacing: '.$option['letter-spacing'].'px; ';
        endif;

        if( isset($option['variation']) && $option['variation'] && $option['variation'] != '100' ) :
            if( $option['variation'] == 'regular' ) :
                $o.= 'font-weight: 400; ';
            else :
                $o.= 'font-weight: '.$option['variation'].'; ';
            endif;
        /*elseif( isset($option['weight']) && $option['weight'] ) :
            $o.= 'font-weight: '.$option['weight'].'; ';*/
        endif;

        if( isset($option['size']) && $option['size'] ) :
            $o.= 'font-size: '.$option['size'].'px; ';
        endif;

        if( isset($option['line-height']) && $option['line-height'] ) :
            $o.= 'line-height: '.$option['line-height'].'px; ';
        endif;

        return $o;

    }
endif;


/**
 * Minify output
 */
if ( ! function_exists( 'jevelin_compress' ) ) :
	function jevelin_compress($buf){
        return preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$buf));
	}
endif;


/**
 * Count sidebar items
 */
if ( ! function_exists( 'jevelin_count_sidebar' ) ) :
	function jevelin_count_sidebar( $sidebar_id ) {
	    $the_sidebars  = wp_get_sidebars_widgets();

	    if( isset( $the_sidebars [$sidebar_id] ) && count( $the_sidebars[$sidebar_id] > 0 ) ) :
	        return count( $the_sidebars[$sidebar_id] );
	    endif;
	}
endif;


/**
 * Remove tags
 */
if ( ! function_exists( 'jevelin_remove_tag' ) ) :
	function jevelin_remove_tag( $excerpt ) {
        $o = str_replace( array("<p>", "</p>"), "", $excerpt );
        echo wp_kses( $o );
	}
endif;


/**
 * Remove p tags
 */
if ( ! function_exists( 'jevelin_remove_p' ) ) :
	function jevelin_remove_p( $text ) {
        $text = preg_replace('/\<[\/]{0,1}p[^\>]*\>/i', '', $text);
        return $text;
	}
endif;


/**
 * Replace p with span
 */
if ( ! function_exists( 'jevelin_replace_p' ) ) :
    function jevelin_replace_p( $text ) {
        $text = str_replace( '<p', '<span', $text );
        $text = str_replace( '</p','</span',$text);
        return $text;
    }
endif;


/**
 * Get header layout
 */
if ( ! function_exists( 'jevelin_header_layout' ) ) :
    function jevelin_header_layout() {
        $header_layout1 = esc_attr( jevelin_post_option( jevelin_page_id(), 'header_layout', '1' ) );
        $header_layout2 = esc_attr( jevelin_option( 'header_layout', '1' ) );

        if( !is_search() && !is_singular('product') && !is_archive() && !is_home() && !is_404() ) :
            return ( isset($header_layout1) && $header_layout1 && $header_layout1 != 'default' ) ? $header_layout1 : ( ( isset($header_layout2) && $header_layout2 ) ? $header_layout2 : '1' );
        else :
            return $header_layout2;
        endif;

    }
endif;


/**
 * Get header style
 */
if ( ! function_exists( 'jevelin_header_style' ) ) :
    function jevelin_header_style() {
        $header_style_val = jevelin_post_option( jevelin_page_id(), 'header_style' );
        return ( isset( $header_style_val['header_style'] ) && !is_search() ) ? esc_attr($header_style_val['header_style']) : 'default';
    }
endif;


/**
 * Get desktop header style
 */
if ( ! function_exists( 'jevelin_header_desktop_style' ) ) :
    function jevelin_header_desktop_style() {
        $get_header_style = jevelin_header_style();
        if( $get_header_style == 'light' || $get_header_style == 'light_mobile_off' ) :
            return ' primary-desktop-light';
        elseif( $get_header_style == 'light light_noborder' ) :
            return ' primary-desktop-light primary-desktop-light-noborder';
        else :
            return '';
        endif;
    }
endif;


/**
 * Get mobile header style
 */
if ( ! function_exists( 'jevelin_header_mobile_style' ) ) :
    function jevelin_header_mobile_style() {
        $get_header_style = jevelin_header_style();
        if( $get_header_style == 'light' ) :
            return ' primary-mobile-light';
        elseif( $get_header_style == 'light light_noborder' ) :
            return ' primary-mobile-light primary-mobile-light-noborder';
        else :
            return '';
        endif;
    }
endif;


/**
 * Determine if left header needs to be included
 */
if ( ! function_exists( 'jevelin_header_page_container' ) ) :
    function jevelin_header_page_container() {
        $get_header_layout = jevelin_header_layout();

        if( jevelin_post_option( jevelin_page_id(), 'header', 'on' ) != 'off' ) :
            if( $get_header_layout == 'left-1' || $get_header_layout == 'left-2' ) :
                return 'sh-header-in-side';
            endif;
        endif;
    }
endif;


/**
 * Determine if right header needs to be included
 */
if ( ! function_exists( 'jevelin_header_right' ) ) :
    function jevelin_header_right() {
        $get_header_layout = jevelin_header_layout();
        if( jevelin_post_option( jevelin_page_id(), 'header', 'on' ) != 'off' ) :
            if( $get_header_layout == 6 || $get_header_layout == 7 || $get_header_layout == 9 ) :
                return true;
            endif;
        endif;
    }
endif;



/**
 * Get header classes
 */
if ( ! function_exists( 'jevelin_header_classes' ) ) :
	function jevelin_header_classes( $id, $side = NULL, $id2 = '' ) {
	    $o = '';

	    if( jevelin_option( 'header_nav_uppercase' ) == true ) :
	        $o.= ' sh-nav-uppercase';
	    endif;

	    if( jevelin_option( 'header_sticky',true ) == true ) :
	        $o.= ' sh-sticky-header';
	    endif;

        if( jevelin_option( 'header_icons', 'large' ) == 'small' ) :
	        $o.= ' sh-header-small-icons';
	    endif;

	    if( $side == 1 ) :
	        echo 'sh-header-side sh-header-'.$id.$o;
	    else :
            if( $id2 > 0 ) {
                echo 'sh-header sh-header-'.$id.' sh-header-'.$id2.$o;
            } else {
                echo 'sh-header sh-header-'.$id.$o;
            }
	    endif;

	}
endif;


/**
 * Get footer status
 */
if ( ! function_exists( 'jevelin_footer_enabled' ) ) :
    function jevelin_footer_enabled() {
        if( defined('FW') ) :
            $footer1 = jevelin_post_option( jevelin_page_id(), 'footer_widgets', 'on' );
            $footer2 = jevelin_option( 'footer_widgets', 'on' );
            $footer3 = jevelin_count_sidebar('footer_widgets');

            return ( $footer3 > 0 ? ( ( isset($footer1) && ( $footer1 == 'on' || $footer1 == 'off' )) ? $footer1 : ( (isset($footer2) && $footer2 ) ? $footer2 : false) ) : false );
        else :
            return 'off';
        endif;
    }
endif;


/**
 * Get footer copyrights status
 */
if ( ! function_exists( 'jevelin_copyrights_enabled' ) ) :
    function jevelin_copyrights_enabled() {
        if( defined('FW') ) :
            $copyright1 = jevelin_post_option( jevelin_page_id(), 'copyright_bar', 'on' );
            $copyright2 = jevelin_option( 'copyright_bar', 'on' );

            return ( isset($copyright1) && ( $copyright1 == 'on' || $copyright1 == 'off' )) ? $copyright1 : ( ( isset($copyright2) && $copyright2 ) ? $copyright2 : false );
        else :
            return 'on';
        endif;
    }
endif;


/**
 * Set excerpt more
 */
if ( ! function_exists( 'jevelin_new_excerpt_more' ) ) :
	function jevelin_new_excerpt_more( $more ) {
        return '...';
	}
	add_filter( 'excerpt_more', 'jevelin_new_excerpt_more' );
endif;


/**
 * Set excerpt lenght
 */
if ( ! function_exists( 'jevelin_new_excerpt_length' ) ) :
	function jevelin_new_excerpt_length($length) {
	    return jevelin_option( 'post_desc', 45 );
	}
    add_filter('excerpt_length', 'jevelin_new_excerpt_length', 9999 );
endif;


/**
 * Show navigation not assigned
 */
if ( ! function_exists( 'jevelin_asign_menu' ) ) :
	function jevelin_asign_menu() {
	    if( current_user_can( 'manage_options' ) ) : ?>
	    <div class="sh-nav-container">
	        <ul class="sh-nav">
	            <li class="menu-item">
	                <a href="<?php echo admin_url('nav-menus.php?action=edit'); ?>">
	                    <?php esc_html_e('Click here to asign menu','jevelin'); ?>
	                </a>
	            </li>
	        </ul>
	    </div>
    <?php else : ?>
        <div class="sh-nav-container">
            <ul class="sh-nav">
                <li class="menu-item">
                    <a href="<?php echo admin_url('nav-menus.php?action=edit'); ?>">
                        <?php esc_html_e('Asign menu','jevelin'); ?>
                    </a>
                </li>
            </ul>
        </div>
	<?php endif;
	}
endif;


/**
 * Get the widget
 */
if( !function_exists('jevelin_get_the_widget') ) {
    function jevelin_get_the_widget( $widget, $instance = '', $args = '' ){
        ob_start();
        the_widget($widget, $instance, $args);
        return ob_get_clean();
    }
}


/**
 * Add pixels if needed
 */
if ( !function_exists( 'jevelin_addpx' ) ) :
    function jevelin_addpx( $number ) {
        $number = $number;
        if( is_numeric($number) ) :
            return $number.'px';
        else :
            return $number;
        endif;
    }
endif;


/**
 * Show pagination
 */
if ( !function_exists( 'jevelin_pagination' ) ) {
    function jevelin_pagination( $wp_query = NULL, $new = 1 ) {
        if( !defined('FW') || jevelin_option('pagination') != 'off' ) :

            $prev_arrow = esc_html__( 'Previous', 'jevelin' );
            $next_arrow = esc_html__( 'Next', 'jevelin' );

            if( !$wp_query ) :
                global $wp_query;
            endif;
            $total = $wp_query->max_num_pages;
            $big = 999999999; // need an unlikely integer
            if( $total > 1 )  {
                 if( !$current_page = get_query_var('paged') )
                     $current_page = 1;
                 if( get_option('permalink_structure') ) {
                     $format = 'page/%#%/';
                 } else {
                     $format = '&paged=%#%';
                 }

                if( is_front_page() ) {
                    if( get_query_var('page') ) :
 					    $page = get_query_var('page');
                    else :
                        $page = get_query_var('paged');
                    endif;
 				} else {
 					$page = get_query_var('paged');
 				}

                if( $new ) :
                    echo '<div class="sh-pagination sh-default-color">';
                    echo paginate_links(array(
                        'base'          => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format'        => $format,
                        'current'       => max( 1, $page ),
                        'total'         => $total,
                        'mid_size'      => 3,
                        'type'          => 'list',
                        'prev_text'     => $prev_arrow,
                        'next_text'     => $next_arrow,
                     ) );
                    echo '</div>';
                else :
                    wp_link_pages( array() );
                endif;
            }

        endif;
    }
}


/**
 * Show page links
 */
if ( !function_exists( 'jevelin_page_links' ) ) :
    function jevelin_page_links() {
        echo '<div class="sh-page-links">';
        wp_link_pages();
        echo '</div>';
    }
endif;


/**
 * Woocommerce - change default pagination
 */
if( !function_exists('jevelin_woocommerce_pagination') ) :
    remove_action('woocommerce_pagination', 'jevelin_woocommerce_pagination', 10);
    function jevelin_woocommerce_pagination() {
        jevelin_pagination();
    }
    add_action( 'woocommerce_pagination', 'jevelin_woocommerce_pagination', 10);
endif;


/**
 * Woocommerce - excerpt
 */
if( !function_exists('jevelin_woocommerce_product_excerpt') ) {
    function jevelin_woocommerce_product_excerpt() {
        if ( is_home() ) {
            echo '<span class="excerpt">';
            the_excerpt();
            echo '</span>';
        }
    }
    add_action( 'woocommerce_after_shop_loop_item_title', 'jevelin_woocommerce_product_excerpt', 35, 2);
}


/**
 * Woocommerce - if related page
 */
if( !function_exists('jevelin_is_realy_woocommerce_page') ) :
    function jevelin_is_realy_woocommerce_page () {
        if( function_exists ( "is_woocommerce" ) && is_woocommerce()){
            return true;
        }
        $woocommerce_keys = array(
            "woocommerce_shop_page_id" ,
            "woocommerce_terms_page_id" ,
            "woocommerce_cart_page_id" ,
            "woocommerce_checkout_page_id" ,
            "woocommerce_pay_page_id" ,
            "woocommerce_thanks_page_id" ,
            "woocommerce_myaccount_page_id" ,
            "woocommerce_edit_address_page_id" ,
            "woocommerce_view_order_page_id" ,
            "woocommerce_change_password_page_id" ,
            "woocommerce_logout_page_id" ,
            "woocommerce_lost_password_page_id"
        );

        foreach ( $woocommerce_keys as $wc_page_id ) {
            if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
                    return true ;
            }
        }
        return false;
    }
endif;


/**
 * Woocommerce - shop columns
 */
if( !function_exists('jevelin_wc_loop_shop_columns') ) :
    function jevelin_wc_loop_shop_columns() {

        if( jevelin_option('wc_columns') ) :
            return jevelin_option('wc_columns');
        else :
            return 4;
        endif;
    }
endif;


/**
 * Woocommerce - remove related products
 */
if( !function_exists('jevelin_wc_remove_related_products') ) :
    function jevelin_wc_remove_related_products( $args ) {
        return array();
    }
endif;


/**
 * Woocommerce - settings
 */



/**
 * WooCommerce - add Second Image on Hover
 * Source: https://github.com/jameskoster/woocommerce-product-image-flipper/blob/master/image-flipper.php
 */
if( !function_exists('Jevelin_WC_Image_Hover') ) :

    class Jevelin_WC_Image_Hover {

        public function __construct() {
            //add_action( 'wp_enqueue_scripts', array( $this, 'pif_scripts' ) );                                                        // Enqueue the styles
            add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'jevelin_woocommerce_template_loop_second_product_thumbnail' ), 11 );
            add_filter( 'post_class', array( $this, 'jevelin_product_has_gallery' ) );
        }

        // Add pif-has-gallery class to products that have a gallery
        function jevelin_product_has_gallery( $classes ) {
            global $product;
            $post_type = get_post_type( get_the_ID() );
            if ( ! is_admin() ) {
                if ( $post_type == 'product' ) {
                    $attachment_ids = $product->get_gallery_image_ids();
                    if ( $attachment_ids ) {
                        $classes[] = 'pif-has-gallery';
                    }
                }
            }
            return $classes;
        }

        // Display the second thumbnails
        function jevelin_woocommerce_template_loop_second_product_thumbnail() {
            global $product, $woocommerce;

            $attachment_ids = $product->get_gallery_image_ids();

            if ( $attachment_ids ) {
                $secondary_image_id = $attachment_ids['0'];
                echo '<div class="secondary-image-container">'.wp_get_attachment_image( $secondary_image_id, 'shop_catalog', '', $attr = array( 'class' => 'secondary-image attachment-shop-catalog' ) ).'</div>';
            }
        }

    }

    $jevelin_wc_image_hover = new Jevelin_WC_Image_Hover();
endif;


/**
 * WooCommerce - Change paypal icon
 */
if( !function_exists('jevelin_wc_paypal') ) :
    function jevelin_wc_paypal($iconUrl) {
        return get_template_directory_uri() . '/img/paypal_icon.png';
    }
    add_filter('woocommerce_paypal_icon', 'jevelin_wc_paypal');
endif;


/**
 * WooCommerce - Update
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'jevelin_header_wc_header_add_to_cart_fragment' );
function jevelin_header_wc_header_add_to_cart_fragment( $fragments ) {
    ob_start();
    ?>

    <div class="sh-header-cart-count cart-icon sh-group">
        <span><?php echo WC()->cart->cart_contents_count; ?></span>
    </div>

    <?php
    $fragments['div.sh-header-cart-count'] = ob_get_clean();
    return $fragments;
}


/**
 * Override toolbar margin
 */
if ( ! function_exists( 'jevelin_override_toolbar_margin' ) ) :
    add_action( 'wp_head', 'jevelin_override_toolbar_margin', 11 );
    function jevelin_override_toolbar_margin() {
        if ( is_admin_bar_showing() ) { ?>
            <style type="text/css" media="screen">
                html { margin-top: 0px !important; }
                #page-container { padding-top: 32px !important; }
                @media (max-width: 782px) {
                    #page-container { padding-top:46px !important; }
                }
            </style>
        <?php }
    }
endif;


/**
 * Popover
 */
if ( ! function_exists( 'jevelin_popover' ) ) :
    function jevelin_popover( $type ) {

        if( isset( $type ) && $type && $type != 'none' ) :
            if( $type == 'hot' ) :
                $val = esc_html__( 'Hot', 'jevelin' );
            else :
                $val = esc_html__( 'New', 'jevelin' );
            endif;

            echo '<span class="sh-popover-mini">'.$val.'</span>';
        endif;

    }
endif;


/**
 * Popover
 */
if ( ! function_exists( 'jevelin_sticky_post' ) ) :
    function jevelin_sticky_post() {
        if( is_sticky() ) :
            echo '<i class="post-sticky icon-pin"></i>';
        endif;
    }
endif;


/**
 * Popover
 */
if ( ! function_exists( 'jevelin_blog_overlay' ) ) :
    function jevelin_blog_overlay( $image = '', $link = '1', $lightbox = '1', $lightbox_group = '' ) {
        if( !$image ) :
            $image = get_permalink();
        endif;
    ?>

        <div class="sh-overlay-style1">
            <div class="sh-table-full">
                <?php if( $link ) : ?>
                    <a href="<?php echo esc_url( get_permalink() ); ?>" class="sh-overlay-item sh-table-cell">
                        <div class="sh-overlay-item-container">
                            <i class="icon-link"></i>
                        </div>
                    </a>
                <?php endif; ?>

                <?php if( $lightbox ) : ?>
                    <a href="<?php echo esc_url( $image ); ?>" class="sh-overlay-item sh-table-cell" data-rel="lightcase<?php echo esc_attr( $lightbox_group); ?>">
                        <div class="sh-overlay-item-container">
                            <i class="icon-magnifier-add"></i>
                        </div>
                    </a>
                <?php endif; ?>
            </div>
        </div>

    <?php }
endif;


/**
 * Share
 */
if ( ! function_exists( 'jevelin_share' ) ) :
    function jevelin_share( $location = '' ) {

        if( $location == 'portfolio' ) :
            echo '<div class="sh-portfolio-single-share">';
        endif;

            echo '
            <div class="sh-social-share">
                <div class="sh-social-share-button sh-noselect">
                    <i class="icon-share"></i>
                    <span>'.esc_html__( 'Share', 'jevelin' ).'</span>
                </div>
                <div class="sh-social-share-networks"></div>
            </div>';

        if( $location == 'portfolio' ) :
            echo '</div>';
        endif;

    }
endif;


/**
 * Page Switch
 */
if ( ! function_exists( 'jevelin_page_switch' ) ) :
    function jevelin_page_switch( $prev_post = '', $content = '', $next_post = '' ) {

        echo '
        <div class="sh-page-switcher">
            <a href="#" class="sh-page-switcher-button sh-page-switcher-button-next">
                <i class="ti-arrow-left"></i>
            </a>
            <a href="#" class="sh-page-switcher-button sh-page-switcher-button-prev">
                <i class="ti-arrow-right"></i>
            </a>
        </div>';

    }
endif;


/**
 * Export categories
 */
if ( ! function_exists( 'jevelin_show_categories' ) ) :
    function jevelin_show_categories() {
        $i = 0;
        $o = '';


        if( is_single() ) :
            $limit_categories = 9999999;
        else :
            $limit_categories = 6;
        endif;


        $categories = get_the_category();
        if( $categories ) :
            foreach( $categories as $category ) :
                if( $i <= $limit_categories ) :
                    $o.= '<a href="'.get_category_link($category->term_id).'">'.$category->name.'</a>';

                    $i++;
                    if( $i < count($categories) ) :
                        $o.= ', ';
                    endif;
                endif;
            endforeach;
        endif;

        if( $i > $limit_categories ) :
            $o.= '...';
        endif;

        return $o;
    }
endif;


/**
 * Navigation - login
 */
if ( ! function_exists( 'jevelin_nav_wrap_login' ) ) :
    function jevelin_nav_wrap_login() {
        $elements = jevelin_option( 'header_elements' );
        if ( class_exists( 'WooCommerce' ) && isset($elements['woo_account']) && $elements['woo_account'] == true ) :

            if ( !is_user_logged_in() ) :
                $val = esc_html__( 'Login', 'jevelin' );
            else :
                $val = esc_html__( 'My Account', 'jevelin' );
            endif;

            return '
            <li class="menu-item sh-nav-login">
                <a href="'.esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ).'" id="header-login">
                    <span>'.$val.'</span>
                </a>
            </li>';
        endif;
    }
endif;


/**
 * Navigation - search
 */
if ( ! function_exists( 'jevelin_nav_wrap_search' ) ) :
    function jevelin_nav_wrap_search() {

        $elements = jevelin_option( 'header_elements' );
        if( isset($elements['search']) && $elements['search'] == true ) :
            return '
            <li class="menu-item sh-nav-search sh-nav-special">
                <a href="#"><i class="icon icon-magnifier"></i></a>
            </li>';
        endif;

    }
endif;


/**
 * Navigation - language switcher
 */
if ( ! function_exists( 'jevelin_nav_wrap_lang' ) ) :
    function jevelin_nav_wrap_lang() {
        $elements = jevelin_option( 'header_elements' );
        return '';
    }
endif;

/**
 * Navigation - social
 */
if ( ! function_exists( 'jevelin_nav_wrap_social' ) ) :
    function jevelin_nav_wrap_social() {

        $elements = jevelin_option( 'header_elements' );
        if( isset($elements['social']) && $elements['social'] == true ) :
            return '
            <li class="menu-item sh-nav-social sh-nav-special">
                '.jevelin_social_media().'
            </li>';
        endif;

    }
endif;


/**
 * Navigation - cart
 */
if ( ! function_exists( 'jevelin_nav_wrap_cart' ) ) :
    function jevelin_nav_wrap_cart( $title = NULL ) {
        $elements = jevelin_option( 'header_elements' );
        if ( class_exists( 'WooCommerce' ) && isset($elements['woo_cart']) && $elements['woo_cart'] == true ) {

            if( $title == true ) {
                $title = '<div class="sh-cart-title">'.esc_html__( 'Cart', 'jevelin' ).'</div>';
            }

            $cart = '';
            if ( jevelin_get_the_widget( 'WC_Widget_Cart', 'title= ' ) ) {
                $cart = '
                <ul class="sub-menu">
                    <li class="menu-item menu-item-cart">
                        '.jevelin_get_the_widget( 'WC_Widget_Cart', 'title= ' ).'
                    </li>
                </ul>';
            }

            return '
            <li class="menu-item sh-nav-cart sh-nav-special">
                <a href="'.WC()->cart->get_cart_url().'">
                    <i class="icon-basket"></i>
                    <div class="sh-header-cart-count cart-icon sh-group">

                        <span>'.WC()->cart->cart_contents_count.'</span>

                    </div>
                    '.$title.'
                </a>
                '.$cart.'
            </li>';
        }
    }
endif;


/**
 * Mobile navigation - menu
 */
if ( ! function_exists( 'jevelin_nav_wrap_menu_mobile' ) ) :
    function jevelin_nav_wrap_menu_mobile() {
        return '
        <li class="menu-item sh-nav-dropdown">
            <a href="#">
                <div class="sh-table-full">
                    <div class="sh-table-cell">
                        <span class="c-hamburger c-hamburger--htx">
                            <span>'.esc_html__( 'Toggle menu', 'jevelin' ).'</span>
                        </span>
                    </div>
                </div>
            </a>
        </li>';
    }
endif;


/**
 * Blog - meta one
 */
function jevelin_meta_one() {
    $elements = jevelin_option( 'post_elements' );
?>

    <span class="post-meta-author">
        <?php esc_html_e( 'by', 'jevelin' ); ?>
        <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="bypostauthor">
            <?php echo esc_attr( get_the_author() ); ?>
        </a>
    </span>

    <?php if( !defined('FW') || ( isset($elements['date']) && $elements['date'] == true ) ) : ?>
        <a href="<?php echo esc_url( get_permalink() ); ?>" class="post-meta-date sh-default-color"><?php echo esc_attr( get_the_date() ); ?></a>
    <?php endif; ?>

<?php }


/**
 * Blog - meta two
 */
function jevelin_meta_two( $order = 0, $icon = 'icon-speech' ) {
    $elements = jevelin_option( 'post_elements' );
?>

    <div class="sh-columns post-meta-comments">
        <span class="post-meta-categories">
            <i class="icon-tag"></i>
            <?php echo jevelin_show_categories(); ?>
        </span>

        <?php if( ( !defined('FW') && comments_open() ) || ( isset($elements['comments']) && $elements['comments'] == true && comments_open() ) ) : ?>
            <a href="<?php echo esc_url( get_permalink() ); ?>#comments" class="post-meta-comments">
                <i class="<?php echo esc_attr( $icon ); ?>"></i>
                <?php echo esc_attr( get_comments_number( '0', '1', '%' ) ); ?>
            </a>
        <?php else : ?>
            <div></div>
        <?php endif; ?>
    </div>

<?php }


/**
 * Show social media
 */
if ( ! function_exists( 'jevelin_social_media' ) ) :
    function jevelin_social_media( $location = '' ) {

        if( jevelin_option('social_newtab') == true ) :
            $new_tab = ' target = "_blank" ';
        else :
            $new_tab = '';
        endif;
        $o = '';

        if( jevelin_option('social_twitter') ) :
            $o.= '<a href="'.esc_url( ltrim( jevelin_option('social_twitter') ) ).'" '.$new_tab.' class="social-media-twitter">
                <i class="icon-social-twitter"></i>
            </a>';
        endif;

        if( jevelin_option('social_facebook') ) :
            $o.= '<a href="'.esc_url( ltrim( jevelin_option('social_facebook') ) ).'" '.$new_tab.' class="social-media-facebook">
                <i class="icon-social-facebook"></i>
            </a>';
        endif;

        if( jevelin_option('social_googleplus') ) :
            $o.= '<a href="'.esc_url( ltrim( jevelin_option('social_googleplus') ) ).'" '.$new_tab.' class="social-media-gplus">
                <i class="icon-social-gplus"></i>
            </a>';
        endif;

        if( jevelin_option('social_instagram') ) :
            $o.= '<a href="'.esc_url( ltrim( jevelin_option('social_instagram') ) ).'" '.$new_tab.' class="social-media-instagram">
                <i class="icon-social-instagram"></i>
            </a>';
        endif;

        if( jevelin_option('social_youtube') ) :
            $o.= '<a href="'.esc_url( ltrim( jevelin_option('social_youtube') ) ).'" '.$new_tab.' class="social-media-youtube">
                <i class="icon-social-youtube"></i>
            </a>';
        endif;

        if( jevelin_option('social_pinterest') ) :
            $o.= '<a href="'.esc_url( ltrim( jevelin_option('social_pinterest') ) ).'" '.$new_tab.' class="social-media-pinterest">
                <i class="icon-social-pinterest"></i>
            </a>';
        endif;

        if( jevelin_option('social_tumblr') ) :
            $o.= '<a href="'.esc_url( ltrim( jevelin_option('social_tumblr') ) ).'" '.$new_tab.' class="social-media-tumblr">
                <i class="icon-social-tumblr"></i>
            </a>';
        endif;

        if( jevelin_option('social_dribbble') ) :
            $o.= '<a href="'.esc_url( ltrim( jevelin_option('social_dribbble') ) ).'" '.$new_tab.' class="social-media-dribbble">
                <i class="icon-social-dribbble"></i>
            </a>';
        endif;

        if( jevelin_option('social_linkedIn') ) :
            $o.= '<a href="'.esc_url( ltrim( jevelin_option('social_linkedIn') ) ).'" '.$new_tab.' class="social-media-linkedin">
                <i class="icon-social-linkedin"></i>
            </a>';
        endif;

        if( jevelin_option('social_skype') ) :
            $o.= '<a href="skype:'.esc_attr( ltrim( jevelin_option('social_skype') ) ).'?chat" '.$new_tab.' class="social-media-skype">
                <i class="icon-social-skype"></i>
            </a>';
        endif;

        if( jevelin_option('social_spotify') ) :
            $o.= '<a href="'.esc_url( ltrim( jevelin_option('social_spotify') ) ).'" '.$new_tab.' class="social-media-spotify">
                <i class="icon-social-spotify"></i>
            </a>';
        endif;

        if( jevelin_option('social_soundcloud') ) :
            $o.= '<a href="'.esc_url( ltrim( jevelin_option('social_soundcloud') ) ).'" '.$new_tab.' class="social-media-soundcloud">
                <i class="icon-social-soundcloud"></i>
            </a>';
        endif;

        if( jevelin_option('social_flickr') ) :
            $o.= '<a href="'.esc_url( ltrim( jevelin_option('social_flickr') ) ).'" '.$new_tab.' class="social-media-flickr">
                <i class="ti-flickr"></i>
            </a>';
        endif;

        if( jevelin_option('social_wordpress') ) :
            $o.= '<a href="'.esc_url( ltrim( jevelin_option('social_wordpress') ) ).'" '.$new_tab.' class="social-media-wordpress">
                <i class="ti-wordpress"></i>
            </a>';
        endif;

        foreach( jevelin_option('social_custom') as $social ) :
            $o.= '<a href="'.esc_url( ltrim( $social['link'] ) ).'" '.$new_tab.' class="social-media-wordpress">
                <i class="'.esc_attr( $social['icon'] ).'"></i>
            </a>';
        endforeach;

        if( $location != 'footer' ) :
            $o.= '<div class="sh-clear"></div>';
        endif;

        return $o;
    }

endif;


/**
 * Show search form
 */
if ( !function_exists( 'jevelin_search_form' ) ) {
    function jevelin_search_form( $form ) {

        $form = '
            <form method="get" class="search-form" action="' . esc_url( home_url('/') ) . '">
                <div>
                    <label>
                        <input type="search" class="sh-sidebar-search search-field" placeholder="'.esc_html__( 'Search here...', 'jevelin' ).'" value="" name="s" title="' . esc_html__( 'Search text', 'jevelin' ) . '" required />
                    </label>
                    <button type="submit" class="search-submit">
                        <i class="icon-magnifier"></i>
                    </button>
                </div>
            </form>';
        return $form;
    }
    add_filter( 'get_search_form', 'jevelin_search_form' );
}


/**
 * Get logo height
 */
if ( !function_exists( 'jevelin_logo_height' ) ) {
    function jevelin_logo_height( $type = NULL ) {
        $logo_sizes_val = jevelin_option( 'header_logo_sizes' );
        $logo_sizes_atts = jevelin_get_picker( $logo_sizes_val );

        if( $type == 'responsive' ) :

            if( isset($logo_sizes_atts['responsive_height']) && $logo_sizes_atts['responsive_height'] > 0 ) :
                return intval( $logo_sizes_atts['responsive_height'] ).'px';
            else :
                return 'auto';
            endif;

        elseif( $type == 'sticky' ) :

            if( isset($logo_sizes_atts['sticky_height']) && $logo_sizes_atts['sticky_height'] > 0 ) :
                return intval( $logo_sizes_atts['sticky_height'] ).'px';
            else :
                return 'auto';
            endif;

        else :

            if( isset($logo_sizes_atts['standard_height']) && $logo_sizes_atts['standard_height'] > 0 ) :
                return intval( $logo_sizes_atts['standard_height'] ).'px';
            else :
                return 'auto';
            endif;

        endif;
    }
}


/**
 * Header Logo
 */
if( !function_exists('jevelin_header_logo') ) :
    function jevelin_header_logo() {

        $standard_logo = jevelin_option_image('logo');

        /* Use Jevelin Logo if Logo is not uploaded */
        if( !$standard_logo ) :
            $standard_logo = get_template_directory_uri().'/img/logo.png';
        endif;

        $sticky_logo = ( jevelin_option_image('logo_sticky') ) ? jevelin_option_image('logo_sticky') : $standard_logo;
        $light_logo = ( jevelin_option_image('logo_light') ) ? jevelin_option_image('logo_light') : $standard_logo;

        if( jevelin_logo_height() && jevelin_logo_height() != 'auto' ) :
            $height = ' height="'.str_replace("px", "", jevelin_logo_height() ).'"';
        else :
            $height = '';
        endif;
    ?>
        <div class="header-logo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header-logo-container sh-table-small">
                <div class="sh-table-cell">

                    <img class="sh-standard-logo" src="<?php echo esc_url( $standard_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"<?php echo esc_attr( $height ); ?> />
                    <img class="sh-sticky-logo" src="<?php echo esc_url( $sticky_logo ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>"<?php echo esc_attr( $height ); ?> />
                    <img class="sh-light-logo" src="<?php echo esc_url( $light_logo ); ?>" alt="<?php echo get_bloginfo( 'name' ); ?>"<?php echo esc_attr( $height ); ?> />

                </div>
            </a>
        </div>

    <?php }
endif;


/**
 * Get excerpt
 */
if ( !function_exists( 'jevelin_get_excerpt' ) ) {
    function jevelin_get_excerpt( $count, $string ){

        $excerpt = $string;
        $excerpt = strip_tags($excerpt);
        $excerpt = wp_trim_words($excerpt, $count);

        return $excerpt;

    }
}


/**
 * Get posts count
 */
if ( !function_exists( 'jevelin_count_posts' ) ) :
    function jevelin_count_posts() {

        $post_count = 1;
        $post_ok = false;
        $posts = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => -1, 'fields' => 'ids', 'order' => 'ASC' ) );
        if( $posts->have_posts() ) :
            $current_post = $posts->post_count;
            foreach ( $posts->posts as $id ) :

                if( $id == get_the_ID() ) :
                    $post_ok = true;
                elseif( $post_ok == false ) :
                    $post_count++;
                endif;

            endforeach;
            return '<strong>'.$post_count.'</strong> / '.$posts->post_count.'';
        endif;

    }
endif;


/**
 * Convert color code to rgb or rgba
 */
if ( !function_exists( 'jevelin_hex2rgba' ) ) {
    function jevelin_hex2rgba($color, $opacity = false) {

        $default = 'rgb(0,0,0)';

        //Return default if no color provided
        if(empty($color))
              return $default;

        //Sanitize $color if "#" is provided
            if ($color[0] == '#' ) {
                $color = substr( $color, 1 );
            }

            //Check if color has 6 or 3 characters and get values
            if (strlen($color) == 6) {
                    $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
            } elseif ( strlen( $color ) == 3 ) {
                    $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
            } else {
                    return $default;
            }

            //Convert hexadec to rgb
            $rgb =  array_map('hexdec', $hex);

            //Check if opacity is set(rgba or rgb)
            if($opacity){
                if(abs($opacity) > 1)
                    $opacity = 1.0;
                $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
            } else {
                $output = 'rgb('.implode(",",$rgb).')';
            }

            //Return rgb(a) color string
            return $output;
    }
}


/**
 * Show breadcrumbs tree
 */
if ( !function_exists( 'jevelin_breadcrumbs' ) ) {
    function jevelin_breadcrumbs( $args = array() ) {
        // Do not display on the homepage

        // Set default arguments
        $defaults = array(
            'separator_icon'      => '&gt;',
            'breadcrumbs_id'      => 'breadcrumbs',
            'breadcrumbs_classes' => 'breadcrumb-trail breadcrumbs',
            'home_title'          =>  esc_html__( 'Home', 'jevelin' ),
        );
        // Parse any arguments added
        $args = apply_filters( 'ct_ignite_breadcrumbs_args', wp_parse_args( $args, $defaults ) );
        // Set variable for adding separator markup
        $separator = '<span class="separator"> ' . esc_attr( $args['separator_icon'] ) . ' </span>';
        // Get global post object
        global $post;
        /***** Begin Markup *****/
        // Open the breadcrumbs
        $html = '<div id="' . esc_attr( $args['breadcrumbs_id'] ) . '" class="' . esc_attr( $args['breadcrumbs_classes']) . '">';
        // Add Homepage link & separator (always present)
        $html .= '<span class="item-home"><a class="bread-link bread-home" href="' . esc_url( home_url('/') ) . '" title="' . esc_attr( $args['home_title'] ) . '">' . esc_attr( $args['home_title'] ) . '</a></span>';

        if ( !is_front_page() ) {
            $html .= $separator;
        }
        // Post

        if ( is_front_page() ) {
            //return;
        } elseif ( is_singular( 'post' ) ) {
            // Get post category info
            $category = get_the_category();
            // Get category values
            $category_values = array_values( $category );
            // Get last category post is in
            $last_category = end( $category_values );
            // Get parent categories
            $cat_parents = rtrim( (string)get_category_parents( $last_category->term_id, true, ',' ), ',' );
            // Convert into array
            $cat_parents = explode( ',', $cat_parents );
            // Loop through parent categories and add to breadcrumb trail
            foreach ( $cat_parents as $parent ) {
                $html .= '<span class="item-cat">' . wp_kses( $parent, wp_kses_allowed_html( 'a' ) ) . '</span>';
                $html .= $separator;
            }
            // add name of Post
            $html .= '<span class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</span></span>';
        } // Page
        elseif ( is_singular( 'page' ) ) {
            // if page has a parent page
            if ( $post->post_parent ) {
                // Get all parents
                $parents = get_post_ancestors( $post->ID );
                // Sort parents into the right order
                $parents = array_reverse( $parents );
                // Add each parent to markup
                foreach ( $parents as $parent ) {
                    $html .= '<span class="item-parent item-parent-' . esc_attr( $parent ) . '"><a class="bread-parent bread-parent-' . esc_attr( $parent ) . '" href="' . get_permalink( $parent ) . '" title="' . get_the_title( $parent ) . '">' . get_the_title( $parent ) . '</a></span>';
                    $html .= $separator;
                }
            }
            // Current page
            $html .= '<span class="item-current item-' . $post->ID . '"><span title="' . get_the_title() . '"> ' . get_the_title() . '</span></span>';
        } // Attachment
        elseif ( is_singular( 'attachment' ) ) {
            // Get the parent post ID
            $parent_id = $post->post_parent;
            // Get the parent post title
            $parent_title = get_the_title( $parent_id );
            // Get the parent post permalink
            $parent_permalink = get_permalink( $parent_id );
            // Add markup
            $html .= '<span class="item-parent"><a class="bread-parent" href="' . esc_url( $parent_permalink ) . '" title="' . esc_attr( $parent_title ) . '">' . esc_attr( $parent_title ) . '</a></span>';
            $html .= $separator;
            // Add name of attachment
            $html .= '<span class="item-current item-' . $post->ID . '"><span title="' . get_the_title() . '"> ' . get_the_title() . '</span></span>';
        } // Custom Post Types
        elseif ( is_singular() ) {
            // Get the post type
            $post_type = get_post_type();
            // Get the post object
            $post_type_object = get_post_type_object( $post_type );
            // Get the post type archive
            $post_type_archive = get_post_type_archive_link( $post_type );
            // Add taxonomy link and separator
            $html .= '<span class="item-cat item-custom-post-type-' . esc_attr( $post_type ) . '"><a class="bread-cat bread-custom-post-type-' . esc_attr( $post_type ) . '" href="' . esc_url( $post_type_archive ) . '" title="' . esc_attr( $post_type_object->labels->name ) . '">' . esc_attr( $post_type_object->labels->name ) . '</a></span>';
            $html .= $separator;
            // Add name of Post
            $html .= '<span class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '" title="' . $post->post_title . '">' . $post->post_title . '</span></span>';
        } // Category
        elseif ( is_category() ) {
            // Get category object
            $parent = get_queried_object()->category_parent;
            // If there is a parent category...
            if ( $parent !== 0 ) {
                // Get the parent category object
                $parent_category = get_category( $parent );
                // Get the link to the parent category
                $category_link = get_category_link($parent);
                // Output the markup for the parent category item
                $html .= '<span class="item-parent item-parent-' . esc_attr( $parent_category->slug ) . '"><a class="bread-parent bread-parent-' . esc_attr( $parent_category->slug ) . '" href="' . esc_url( $category_link ) . '" title="' . esc_attr( $parent_category->name ) . '">' . esc_attr( $parent_category->name ) . '</a></span>';
                $html .= $separator;
            }
            // Add category markup
            $html .= '<span class="item-current item-cat"><span class="bread-current bread-cat" title="' . $post->ID . '">' . single_cat_title( '', false ) . '</span></span>';
        } // Tag
        elseif ( is_tag() ) {
            // Add tag markup
            $html .= '<span class="item-current item-tag"><span class="bread-current bread-tag">' . single_tag_title( '', false ) . '</span></span>';
        } // Author
        elseif ( is_author() ) {
            // Add author markup
            $html .= '<span class="item-current item-author"><span class="bread-current bread-author">' . get_queried_object()->display_name . '</span></span>';
        } // Day
        elseif ( is_day() ) {
            // Add day markup
            $html .= '<span class="item-current item-day"><span class="bread-current bread-day">' . get_the_date() . '</span></span>';
        } // Month
        elseif ( is_month() ) {
            // Add month markup
            $html .= '<span class="item-current item-month"><span class="bread-current bread-month">' . get_the_date( 'F Y' ) . '</span></span>';
        } // Year
        elseif ( is_year() ) {
            // Add year markup
            $html .= '<span class="item-current item-year"><span class="bread-current bread-year">' . get_the_date( 'Y' ) . '</span></span>';
        } // Custom Taxonomy
        elseif ( is_archive() ) {
            // get the name of the taxonomy
            $custom_tax_name = get_queried_object()->name;
            // Add markup for taxonomy
            $html .= '<span class="item-current item-archive"><span class="bread-current bread-archive">' . esc_attr($custom_tax_name) . '</span></span>';
        } // Search
        elseif ( is_search() ) {
            // Add search markup
            $html .= '<span class="item-current item-search"><span class="bread-current bread-search">' . sprintf(esc_html__('Search Results for "%s"', 'jevelin'), get_search_query()) . '</span></span>';
        } // 404
        elseif ( is_404() ) {
            // Add 404 markup
            $html .= '<span>' . esc_html__( 'Error 404', 'jevelin' ) . '</span>';
        }
        // Close breadcrumb container
        $html .= '</div>';
        apply_filters( 'ct_ignite_breadcrumbs_filter', $html );
        return wp_kses_post( $html );
    }
}
