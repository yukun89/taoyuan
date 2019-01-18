<?php
/**
 * The template used for displaying projects on index view
 *
 * @package Adonis
 */
?>

<article id="portfolio-post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<a title="<?php  the_title_attribute(); ?>" href="<?php the_permalink(); ?>">
		<div class="porfolio-section-thumbnail post-thumbnail">
			<?php
				// Output the featured image.
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'adonis-portfolio' );
				} else {
					echo '<img src="' .  trailingslashit( esc_url( get_template_directory_uri() ) ) . 'assets/images/no-thumb-640x480.jpg"/>';
				}
			?>
		</div><!-- .portfolio-content-image -->

		<div class="entry-container caption">
			<header class="entry-header vcenter">
				<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
			</header>
		</div><!-- .entry-container -->
	</a>
</article>
