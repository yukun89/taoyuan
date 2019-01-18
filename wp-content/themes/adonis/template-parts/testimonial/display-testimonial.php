<?php
/**
 * The template for displaying testimonial items
 *
 * @package Adonis
 */
?>

<?php
$enable = get_theme_mod( 'adonis_testimonial_option', 'disabled' );

if ( ! adonis_check_section( $enable ) ) {
	// Bail if featured content is disabled
	return;
}

$type = 'jetpack-testimonial';

	// Get Jetpack options for testimonial.
	$jetpack_defaults = array(
		'page-title' => esc_html__( 'Testimonials', 'adonis' ),
	);

	// Get Jetpack options for testimonial.
	$jetpack_options = get_theme_mod( 'jetpack_testimonials', $jetpack_defaults );

	$headline    = isset( $jetpack_options['page-title'] ) ? $jetpack_options['page-title'] : esc_html__( 'Testimonials', 'adonis' );
	$subheadline = isset( $jetpack_options['page-content'] ) ? $jetpack_options['page-content'] : '';

$layouts = 1;
$classes[] = 'section testimonial-section';

$classes[] = 'layout-one';

if ( ! $headline && ! $subheadline ) {
	$classes[] = 'no-headline';
}

?>

<div id="testimonial-section" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="wrapper">
		<?php if ( $headline || $subheadline ) : ?>
			<div class="section-heading-wrapper testimonial-section-headline">
				<?php if ( $headline ) : ?>
					<div class="section-title-wrapper">	
						<h2 class="section-title"><?php echo wp_kses_post( $headline ); ?></h2>
					</div><!-- .section-title-wrapper -->	
				<?php endif; ?>

				<?php if ( $subheadline ) : ?>
					<div class="taxonomy-description-wrapper">
						<p class="section-subtitle"><?php echo wp_kses_post( $subheadline ); ?></p>
					</div><!-- .taxonomy-description-wrapper -->	
				<?php endif; ?>
			</div><!-- .section-heading-wrapper -->
		<?php endif; ?>

		<div class="section-content-wrapper testimonial-content-wrapper">
			<?php $slider_select = get_theme_mod( 'adonis_testimonial_slider', 1 );

			if ( $slider_select ) : ?>
			<div class="controller">
				<!-- prev link -->
				<button id="testimonial-slider-prev" class="cycle-prev" aria-label="<?php esc_attr_e( 'Previous', 'adonis' ); ?>"><?php echo adonis_get_svg( array( 'icon' => 'angle-down' ) ); ?><span class="screen-reader-text"><?php esc_html_e( 'Previous Slide', 'adonis' ); ?></span></button>

				<!-- empty element for pager links -->
				<div id="testimonial-slider-pager" class="cycle-pager"></div>

				<!-- next link -->
				<button id="testimonial-slider-next" class="cycle-next" aria-label="<?php esc_attr_e( 'Next', 'adonis' ); ?>"><span class="screen-reader-text"><?php esc_html_e( 'Next Slide', 'adonis' ); ?></span><?php echo adonis_get_svg( array( 'icon' => 'angle-down' ) ); ?></button>
			</div><!-- #controller-->
			
			<div class="cycle-slideshow"
				data-cycle-log="false"
				data-cycle-pause-on-hover="true"
				data-cycle-swipe="true"
				data-cycle-auto-height=container
				data-cycle-loader=false
				data-cycle-slides=".testimonial_slider_wrap"
				data-cycle-prev= .cycle-prev
				data-cycle-next= .cycle-next
				data-cycle-pager="#testimonial-slider-pager"
				data-cycle-prev="#testimonial-slider-prev"
				data-cycle-next="#testimonial-slider-next"
				data-cycle-slides="> .post-slide"
				>

				<div class="testimonial_slider_wrap">
			<?php endif; ?>

			<?php
				get_template_part( 'template-parts/testimonial/post-types', 'testimonial' );
			?>

			<?php if ( $slider_select ) : ?>
				</div><!-- .testimonial_slider_wrap -->
			</div><!-- .cycle-slideshow -->
			<?php endif; ?>
		</div><!-- .section-content-wrap -->
	</div><!-- .wrapper -->
</div><!-- .testimonial-section -->
