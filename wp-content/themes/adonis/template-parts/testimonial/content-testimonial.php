<?php
/**
 * The template used for displaying testimonial on front page
 *
 * @package Adonis
 */
?>

<?php
$class = has_post_thumbnail() ? 'has-post-thumbnail' : 'no-post-thumbnail';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
	<div class="hentry-inner">
		<div class="entry-container">
			<?php
			$show_content = get_theme_mod( 'adonis_testimonial_show', 'full-content' );

			if ( 'excerpt' === $show_content  ) : ?>
			<div class="entry-content">
				<?php the_excerpt(); ?>
			</div>
			<?php elseif ( 'full-content' === $show_content ) : ?>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
			<?php endif; ?>

			<?php $position = get_post_meta( get_the_id(), 'ect_testimonial_position', true ); ?>
		</div><!-- .entry-container -->

		<div class="hentry-inner-wrap">
			<div class="hentry-inner-header-wrap">
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="testimonial-thumbnail post-thumbnail">
						<a href="">
							<?php the_post_thumbnail( 'adonis-testimonial' ); ?>
						</a>
					</div>
				<?php endif; ?>

				<?php if ( get_theme_mod( 'adonis_testimonial_enable_title', 1 ) || $position ) : ?>
					<header class="entry-header">
						<?php
						if ( get_theme_mod( 'adonis_testimonial_enable_title', 1 ) ) {
							the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
						}
						?>

						<?php if ( $position ) : ?>
							<p class="entry-meta"><span class="position"><?php echo esc_html( $position ); ?></span></p>
						<?php endif; ?>
					</header>
				<?php endif;?>
			</div><!-- .hentry-inner-header-wrap -->
		</div><!-- .hentry-inner-wrap -->
	</div><!-- .hentry-inner -->
</article>
