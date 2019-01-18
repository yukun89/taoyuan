<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Adonis
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="singular-content-wrap">
				<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content/content', 'single' );

					//the_post_navigation();

                    the_post_navigation( array(
                    	'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'adonis' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'adonis' ) . '</span> <span class="nav-title"><span class="nav-title-icon-wrapper">' . adonis_get_svg( array( 'icon' => 'arrow-left' ) ) . '</span>%title</span>',
                    	'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'adonis' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'adonis' ) . '</span> <span class="nav-title">%title<span class="nav-title-icon-wrapper">' . adonis_get_svg( array( 'icon' => 'arrow-right' ) ) . '</span></span>',
                    ) );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>
			</div><!-- .singular-content-wrap -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
