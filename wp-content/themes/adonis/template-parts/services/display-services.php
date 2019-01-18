<?php
/**
 * The template for displaying featured content
 *
 * @package Adonis
 */
?>

<?php
$enable_content = get_theme_mod( 'adonis_service_option', 'disabled' );

if ( ! adonis_check_section( $enable_content ) ) {
	// Bail if featured content is disabled.
	return;
}

$title     = get_option( 'ect_service_title', esc_html__( 'Services ', 'adonis' ) );
$sub_title = get_option( 'ect_service_content' );

$layout = 'layout-two';
$classes[] = esc_attr( $layout );
$classes[] = 'section';
?>

<div id="services-section" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="wrapper">
		<?php if ( '' !== $title || $sub_title ) : ?>
			<div class="section-heading-wrapper services-section-headline">
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

		<div class="section-content-wrapper services-content-wrapper <?php echo esc_attr( $layout ); ?>">
			<?php
					get_template_part( 'template-parts/services/post-types', 'services' );
			?>
		</div><!-- .section-content-wrap -->
	</div><!-- .wrapper -->
</div><!-- #services-section -->
