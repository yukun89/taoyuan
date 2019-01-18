<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Adonis
 */

get_header(); ?>
	<section id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="archive-post-wrapper">
				<?php
				if ( have_posts() ) : ?>

					<div class="section-heading-wrapper">
						<header class="page-header">
							<h1 class="page-title"><?php
								/* translators: %s: search query. */
								printf( esc_html__( 'Search Results for: %s', 'adonis' ), '<span>' . get_search_query() . '</span>' );
							?></h1>
						</header><!-- .page-header -->
					</div>

					<div class="section-content-wrapper">
	    				<div class="archive-post-wrap layout-four">
						<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'template-parts/content/content', 'search' );

						endwhile;

						adonis_content_nav();

					else :

						get_template_part( 'template-parts/content/content', 'none' );

					endif; ?>
						</div><!-- .archive-post-wrapp -->
					</div><!-- .section-content-wrap -->
			</div><!-- .archive-post-wrapper -->
		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
