<?php
/**
 * The template for displaying featured content
 *
 * @package Adonis
 */
?>

<?php
$enable_content = get_theme_mod( 'adonis_featured_content_option', 'disabled' );

if ( ! adonis_check_section( $enable_content ) ) {
	// Bail if featured content is disabled.
	return;
}
	$featured_posts = adonis_get_featured_posts();

	if ( empty( $featured_posts ) ) {
		return;
	}

	$title     = get_option( 'featured_content_title', esc_html__( 'Contents', 'adonis' ) );
	$sub_title = get_option( 'featured_content_content' );

$layout = 'layout-three';

$classes[] = esc_attr( $layout );
$classes[] = 'section';
?>

<div id="featured-content-section" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="wrapper">
		<?php if ( '' !== $title || $sub_title ) : ?>
			<div class="section-heading-wrapper feaured-content-section-headline">
				<?php if ( '' !== $title ) : ?>
					<div class="section-title-wrapper">
						<h2 class="section-title"><?php echo wp_kses_post( $title ); ?></h2>
					</div><!-- .section-title-wrapper -->
				<?php endif; ?>

				<?php if ( $sub_title ) : ?>
					<div class="taxonomy-description-wrapper">
						<p class="section-subtitle">
							<?php echo wp_kses_post( $sub_title ); ?>
						</p>
					</div><!-- .taxonomy-description-wrapper -->
				<?php endif; ?>
			</div><!-- .section-heading-wrapper -->
		<?php endif; ?>

		<div class="section-content-wrapper featured-content-wrapper <?php echo esc_attr( $layout ); ?>">

			<?php
					foreach ( $featured_posts as $post ) {
						setup_postdata( $post );

						// Include the featured content template.
						get_template_part( 'template-parts/featured-content/content', 'featured' );
					}
					wp_reset_postdata();
			?>

			<?php
				$target = get_theme_mod( 'adonis_featured_content_target' ) ? '_blank': '_self';
				$link   = get_theme_mod( 'adonis_featured_content_link', '#' );
				$text   = get_theme_mod( 'adonis_featured_content_text' );

				if ( $text ) :
			?>

			<?php endif; ?>
		</div><!-- .section-content-wrap -->

		<p class="view-more">
			<a class="button" target="<?php echo $target; ?>" href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $text ); ?></a>
		</p>
	</div><!-- .wrapper -->
</div><!-- #about-section -->
