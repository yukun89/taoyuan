<?php
/**
 * Display Breadcrumb
 *
 * @package Adonis
 */
?>

<?php

if ( ! get_theme_mod( 'adonis_breadcrumb_option', 1 ) ) {
	// Bail if breadcrumb is disabled.
	return;
}
	adonis_breadcrumb();

