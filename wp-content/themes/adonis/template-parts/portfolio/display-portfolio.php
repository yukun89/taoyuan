<?php
/**
 * The template for displaying portfolio items
 *
 * @package Adonis
 */
?>

<?php
$enable = get_theme_mod( 'adonis_portfolio_option', 'disabled' );

if ( ! adonis_check_section( $enable ) ) {
	// Bail if portfolio section is disabled.
	return;
}

$type = 'jetpack-portfolio';

	$title     = get_option( 'jetpack_portfolio_title', esc_html__( 'Projects', 'adonis' ) );
	$sub_title = get_option( 'jetpack_portfolio_content' );

$layout = 'layout-four';

$classes[] = esc_attr( $layout );
$classes[] = esc_attr( $type );
$classes[] = 'section';

?>

<div id="portfolio-section" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="wrapper">
		<?php if ( '' != $title || $sub_title ) : ?>
			<div class="section-heading-wrapper portfolio-section-headline">
				<?php if ( '' != $title ) : ?>
					<div class="section-title-wrapper">	
						<h2 class="section-title"><?php echo wp_kses_post( $title ); ?></h2>
					</div><!-- .section-title-wrapper -->	
				<?php endif; ?>

				<?php if ( $sub_title ) : ?>
					<div class="taxonomy-description-wrapper">
						<p class="section-subtitle"><?php echo wp_kses_post( $sub_title ); ?></p>
					</div><!-- .taxonomy-description-wrapper -->	
				<?php endif; ?>
			</div><!-- .section-heading-wrapper -->
		<?php endif; ?>

		<div class="section-content-wrapper portfolio-content-wrapper <?php echo esc_attr( $layout ); ?>">
			<?php
				get_template_part( 'template-parts/portfolio/post-types', 'portfolio' );
			?>
		</div><!-- .section-content-wrap -->

		<?php
			$target = get_theme_mod( 'adonis_portfolio_target' ) ? '_blank': '_self';
			$link   = get_theme_mod( 'adonis_portfolio_link', '#' );
			$text   = get_theme_mod( 'adonis_portfolio_text', esc_html__( 'View More', 'adonis' ) );

			if ( $text ) :
		?>
			<p class="view-more">
				<a class="button" target="<?php echo $target; ?>" href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $text ); ?></a>
			</p>
		<?php endif; ?>
	</div><!-- .wrapper -->
</div><!-- #portfolio-section -->
