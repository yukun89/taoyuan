<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Adonis
 */

get_header();

$enable_homepage_posts = adonis_enable_homepage_posts();

if ( $enable_homepage_posts ) : ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class=" archive-post-wrapper">
		        <?php
				$title       = get_theme_mod( 'adonis_recent_posts_heading', esc_html__( 'Recent Posts', 'adonis' ) );
				$description = get_theme_mod( 'adonis_recent_posts_subheading' );

				// Condition if is blog page but not front page, i.e. Blog page selected
				if ( is_home() && ! is_front_page() ) {
					$title = single_post_title( '', false );

					$page_for_posts_id  = get_option( 'page_for_posts' );
					$page_for_posts_obj = get_post( $page_for_posts_id );
					$description = apply_filters( 'the_content', $page_for_posts_obj->post_content );
				}

				if ( $title || $description ) : ?>

				<div class="section-heading-wrapper">
					<?php if ( $title ) : ?>
						<div class="section-title-wrapper">
							<?php
							/**
							 * h1 for blog page, h2 for other pages, mainly front page
							 */
							if ( is_home() && ! is_front_page() ) : ?>
							<h1 class="section-title"><?php echo esc_html( $title ); ?></h1>
							<?php else: ?>
							<h2 class="section-title"><?php echo esc_html( $title ); ?></h2>
							<?php endif; ?>
						</div><!-- .section-title-wrapper -->
					<?php endif; ?>

					<?php if (  $description ) : ?>
						<div class="taxonomy-description-wrapper">
							<p class="section-subtitle">
								<?php echo wp_kses_post( $description ); ?>
							</p>
						</div><!-- .taxonomy-description-wrapper -->
					<?php endif; ?>
				</div><!-- .section-heading-wrap -->
				<?php endif; ?>

	    		<div class="section-content-wrapper">
	    			<div id="infinite-post-wrap" class="archive-post-wrap layout-four">
	            		<?php
						if ( have_posts() ) :

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
	    	</div><!-- .section -->
		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
<?php endif; // $enable_homepage_posts
get_footer();
