<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Minimal_Grid
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function minimal_grid_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

    $site_layout = minimal_grid_get_option('site_layout',true);

	if( 'fullwidth' == $site_layout){
        $classes[] = 'thememattic-full-layout';
    }
    if( 'boxed' == $site_layout ){
        $classes[] = 'thememattic-boxed-layout';
    }

    $page_layout = minimal_grid_get_page_layout();
    $classes[] = esc_attr($page_layout);

	return $classes;
}
add_filter( 'body_class', 'minimal_grid_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function minimal_grid_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'minimal_grid_pingback_header' );