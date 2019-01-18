<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Minimal_Grid
 */

get_header(); ?>
<section class="error-404">
	<div class="page-content">
		<h2><?php esc_html_e( '404 not found. Maybe try a search?', 'minimal-grid' ); ?></h2>
		<?php get_search_form(); ?>
	</div>
</section>
<?php
get_footer();
