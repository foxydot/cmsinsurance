<?php
add_filter( 'wp_nav_menu_items', 'custom_menu_extras', 10, 2 );
/**
* Filter menu items, appending a a search icon at the end.
*
* @param string   $menu HTML string of list items.
* @param stdClass $args Menu arguments.
*
* @return string Amended HTML string of list items.
*/
function custom_menu_extras( $menu, $args ) {

if ( 'primary' !== $args->theme_location ) {
return $menu;
}

$menu .= '<li class="menu-item search">' . get_search_form( false ) . '</li>';

return $menu;

}

//add_filter( 'genesis_markup_search-form-submit_open', 'custom_search_form_submit' );
/**
* Change Search Form submit button markup.
*
* @return string Modified HTML for search forms' submit button.
*/
function custom_search_form_submit() {

$search_button_text = apply_filters( 'genesis_search_button_text', esc_attr__( 'Search', 'genesis' ) );

$searchicon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="search-icon"><path d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg>';

return sprintf( '<button type="submit" class="search-form-submit" aria-label="Search">%s<span class="screen-reader-text">%s</span></button>', $searchicon, $search_button_text );

}