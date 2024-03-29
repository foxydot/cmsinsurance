<?php
/**
 * Genesis Sample.
 *
 * This file adds functions to the Genesis Sample Theme.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Developer Tools.
include_once( get_stylesheet_directory() . '/lib/inc/devel.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/inc/theme-defaults.php' );


// Add the helper functions.
include_once( get_stylesheet_directory() . '/lib/inc/helper-functions.php' );
include_once( get_stylesheet_directory() . '/lib/inc/media.php' );
include_once( get_stylesheet_directory() . '/lib/inc/msd-functions.php' ); //should this go to plugin?
include_once( get_stylesheet_directory() . '/lib/inc/genesis_blog_grid.php' );
include_once( get_stylesheet_directory() . '/lib/inc/genesis-menu-extras.php' );


// Enqueue stuff.
include_once( get_stylesheet_directory() . '/lib/inc/register-scripts.php' );

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
    'header',
    'nav',
    'subnav',
    'site-inner',
    'footer',
    'footer-widgets',
) );

remove_theme_support('custom-header');

//add_action( 'admin_menu', 'adjust_the_wp_menu', 999 );
function adjust_the_wp_menu() {
    if(!current_user_can('install_themes')) {
        add_submenu_page('themes.php', 'Menus', 'Menus', 'edit_theme_options', 'nav-menus.php', '', '', 30);
        remove_submenu_page( 'themes.php', 'customize.php' );
    }
}


/***Tools Plugin**/
//instantiate sub packages
if(class_exists('MSDLab_Theme_Tweaks')){
    $options = array();
    $ttweaks = new MSDLab_Theme_Tweaks($options);
}
if(class_exists('MSDLab_Genesis_Bootstrap')){
    $options = array(
        'sidebar' => array(
            'xs' => 12,
            'sm' => 12,
            'md' => 3,
            'lg' => 3
        ),
        'sidebar_alt' => array(
            'xs' => 12,
            'sm' => 12,
            'md' => 3,
            'lg' => 3
        ),
    );
    $bootstrappin = new MSDLab_Genesis_Bootstrap($options);
}
if(class_exists('MSDLab_Genesis_Tweaks')){
    $options = array(
        'preheader' => 'genesis_header'
    );
    $gtweaks = new MSDLab_Genesis_Tweaks($options);
}


/*** HEADER ***/
add_action('wp_head','msdlab_maybe_wrap_inner');
add_filter( 'genesis_search_text', 'msdlab_search_text' ); //customizes the serach bar placeholder
add_filter('genesis_search_button_text', 'msdlab_search_button'); //customize the search form to add fontawesome search button.
//add_filter('genesis_search_form', 'msdlab_sliding_search_form');

/**
 * Move secodary nav into pre-header
 */
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'msdlab_pre_header', 'genesis_do_subnav' );

remove_action('genesis_header','genesis_do_header' );
add_action('genesis_header','msdlab_do_header' );


add_action('genesis_before_content_sidebar_wrap','msdlab_homepage_sidebar',12);
add_action('genesis_after_content_sidebar_wrap','msdlab_homepage_footer_sidebar',12);
add_action('after_setup_theme','msdlab_add_homepage_sidebar', 4);
/*** NAV ***/
/**
 * Move nav into header
 */
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'msdlab_do_nav' );

/*** SIDEBARS ***/
remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt' );
add_action( 'genesis_after_content', 'genesis_get_sidebar_alt' );
add_filter('widget_text', 'do_shortcode');//shortcodes in widgets

/*** CONTENT ***/
add_filter('genesis_breadcrumb_args', 'msdlab_breadcrumb_args'); //customize the breadcrumb output
remove_action('genesis_before_loop', 'genesis_do_breadcrumbs'); //move the breadcrumbs
add_filter( 'genesis_post_info', 'msdlab_post_info_filter' );
//add_action('template_redirect','msdlab_maybe_move_title');

//remove_action('genesis_entry_header','genesis_do_post_title'); //move the title out of the content area
//add_action('msdlab_title_area','msdlab_do_section_title');
add_action('genesis_header', 'genesis_do_breadcrumbs', 11); //to outside of the loop area
//add_action('genesis_after_header','msdlab_do_title_area');

add_action('genesis_before_entry','msdlab_post_image');//add the image above the entry

add_filter( 'excerpt_length', 'msdlab_excerpt_length', 999 );
add_filter('excerpt_more', 'msdlab_read_more_link');
add_filter( 'the_content_more_link', 'msdlab_read_more_link' );

remove_action( 'genesis_entry_header', 'genesis_post_info', 12 ); //remove the info (date, posted by,etc.)
remove_action( 'genesis_entry_footer', 'genesis_post_meta'); //remove the meta (filed under, tags, etc.)

//add_filter( 'genesis_next_link_text', 'msdlab_older_link_text', 20);
//add_filter( 'genesis_prev_link_text', 'msdlab_newer_link_text', 20);

remove_action( 'genesis_after_endwhile', 'genesis_prev_next_post_nav' );
add_action( 'genesis_after_endwhile', 'msdlab_prev_next_post_nav' );


/*** FOOTER ***/
add_theme_support( 'genesis-footer-widgets', 1 ); //adds automatic footer widgets

//add the menu
//add_action('genesis_footer','msdlab_do_footer_menu', 10);

//add_action('genesis_before_footer','msdlab_do_footer_widget', 1);

remove_action('genesis_footer','genesis_do_footer'); //replace the footer
add_action('genesis_footer','msdlab_do_social_footer');//with a msdsocial support one

/*** SITEMAP ***/
add_action('after_404','msdlab_sitemap');

/*** MEDIA ***/

/* Display a custom favicon */
add_filter( 'genesis_pre_load_favicon', 'msdlab_favicon_filter' );
function msdlab_favicon_filter( $favicon_url ) {
    return get_stylesheet_directory_uri().'/lib/images/favicon.png';
}

/*** ORIG ***/

// Add support for after entry widget.
//add_theme_support( 'genesis-after-entry-widget-area' );

// Modify size of the Gravatar in the author box.
add_filter( 'genesis_author_box_gravatar_size', 'genesis_msdlab_child_author_box_gravatar' );
function genesis_msdlab_child_author_box_gravatar( $size ) {
	return 90;
}

// Modify size of the Gravatar in the entry comments.
add_filter( 'genesis_comment_list_args', 'genesis_msdlab_child_comments_gravatar' );
function genesis_msdlab_child_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;

	return $args;

}

function msdlab_homepage_sidebar(){
    if(is_front_page()) {
        print '<div class="homepage-widget-area container"><div class="row">';
        dynamic_sidebar('homepage');
        print '</div></div>';
    }
}


function msdlab_homepage_footer_sidebar(){
    if(is_front_page()) {
        print '<div class="homepage-footer-widget-area container"><div class="row">';
        dynamic_sidebar('homepage_ftr');
        print '</div></div>';
    }
}

function msdlab_add_homepage_sidebar(){
  genesis_register_sidebar(array(
      'name' => 'Homepage Header',
      'description' => 'Widget above content on homepage',
      'id' => 'homepage'
  ));
  genesis_register_sidebar(array(
      'name' => 'Homepage Footer',
      'description' => 'Widget below content on homepage',
      'id' => 'homepage_ftr'
  ));
}
