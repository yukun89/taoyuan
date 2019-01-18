<?php
/**
 * The template used for displaying hero content
 *
 * @package Adonis
 */

$enable_section = get_theme_mod( 'adonis_hero_content_visibility', 'disabled' );

if ( ! adonis_check_section( $enable_section ) ) {
	// Bail if hero content is not enabled
	return;
}
get_template_part( 'template-parts/hero-content/post-type', 'hero' );
