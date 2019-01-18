<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Adonis
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-thumbnail archive-thumbnail">
		<?php adonis_archive_image(); ?>

		<?php
		if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php adonis_posted_on(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</div><!-- .post-thumbnail -->

	<div class="entry-container">
		<header class="entry-header">
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif; ?>
		</header><!-- .entry-container -->

		<div class="entry-content">
			<?php
			$archive_layout = get_theme_mod( 'adonis_content_layout', 'excerpt-image-left' );

			if ( 'full-content-image-top' === $archive_layout || 'full-content' === $archive_layout ) {
				/* translators: %s: Name of current post. Only visible to screen readers */
				the_content( sprintf(
					wp_kses(

						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'adonis' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				) );

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'adonis' ),
					'after'  => '</div>',
				) );
			} else {
				the_excerpt();
			}
			?>
		</div><!-- .entry-content -->

		
	</div><!-- .entry-container -->
</article><!-- #post-<?php //the_ID(); ?> -->


