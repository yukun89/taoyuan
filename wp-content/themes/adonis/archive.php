<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Adonis
 */

get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="archive-post-wrapper">
				<div class="archive-heading-wrapper">
					<?php
					if ( have_posts() ) : ?>

						<header class="page-header">
							<?php
								the_archive_title( '<h1 class="page-title">', '</h1>' );
								the_archive_description( '<div class="taxonomy-description-wrapper">', '</div>' );
							?>
						</header><!-- .page-header -->
				</div><!-- .archive-heading-wrapper -->

				<div class="section-content-wrapper">
	    			<div class="archive-post-wrap layout-four">
						<?php
							/* Start the Loop */
							while ( have_posts() ) : the_post();

								/*
								 * Include the Post-Format-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
								 */
								get_template_part( 'template-parts/content/content', get_post_format() );

							endwhile;

							adonis_content_nav();

							else :

							get_template_part( 'template-parts/content/content', 'none' );

						endif; ?>
					</div><!-- .archive-post-wrap -->
				</div><!-- .section-content-wrap -->
			</div><!-- .archive-post-wrapper -->
		</main><!-- #main -->
	</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>

