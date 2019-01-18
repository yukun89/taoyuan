<?php
/**
 * The template for displaying the Slider
 *
 * @package Adonis
 */

if ( ! function_exists( 'adonis_featured_slider' ) ) :
	/**
	 * Add slider.
	 *
	 * @uses action hook adonis_before_content.
	 *
	 * @since Adonis 0.1
	 */
	function adonis_featured_slider() {
		$enable_slider = get_theme_mod( 'adonis_slider_option', 'disabled' );

		if ( adonis_check_section( $enable_slider ) ) {
			$type       = get_theme_mod( 'adonis_slider_type', 'category' );
			$transition_effect = get_theme_mod( 'adonis_slider_transition_effect', 'fade' );
			$transition_length = get_theme_mod( 'adonis_slider_transition_length', 1 );
			$transition_delay  = get_theme_mod( 'adonis_slider_transition_delay', 4 );
			$image_loader      = get_theme_mod( 'adonis_slider_image_loader', true );

			$output = '
				<div id="feature-slider-section" class="section">
					<div class="wrapper">
						<div class="cycle-slideshow"
							data-cycle-log="false"
							data-cycle-pause-on-hover="true"
							data-cycle-swipe="true"
							data-cycle-auto-height=container
							data-cycle-fx="' . esc_attr( $transition_effect ) . '"
							data-cycle-speed="' . esc_attr( $transition_length * 1000 ) . '"
							data-cycle-timeout="' . esc_attr( $transition_delay * 1000 ) . '"
							data-cycle-loader=false
							data-cycle-slides="> article"
							>

							<!-- prev/next links -->
							<button class="cycle-prev" aria-label="Previous"><span class="screen-reader-text">' . esc_html__( 'Previous Slide', 'adonis' ) . '</span>' . adonis_get_svg( array( 'icon' => 'angle-down' ) ) . '</button>
							<button class="cycle-next" aria-label="Next"><span class="screen-reader-text">' . esc_html__( 'Next Slide', 'adonis' ) . '</span>' . adonis_get_svg( array( 'icon' => 'angle-down' ) ) . '</button>


							<!-- empty element for pager links -->
							<div class="cycle-pager"></div>';
			$output .= adonis_post_page_category_slider();
			$output .= '
						</div><!-- .cycle-slideshow -->
					</div><!-- .wrapper -->
				</div><!-- #feature-slider -->';

			echo $output;
		} // End if().
	}
	endif;
add_action( 'adonis_slider', 'adonis_featured_slider', 10 );


if ( ! function_exists( 'adonis_post_page_category_slider' ) ) :
	/**
	 * This function to display featured posts/page/category slider
	 *
	 * @param $options: adonis_theme_options from customizer
	 *
	 * @since Adonis 1.0
	 */
	function adonis_post_page_category_slider() {
		$quantity     = get_theme_mod( 'adonis_slider_number', 4 );
		$no_of_post   = 0; // for number of posts
		$post_list    = array();// list of valid post/page ids
		//$type         = get_theme_mod( 'adonis_slider_type', 'category' );
		$show_content = get_theme_mod( 'adonis_slider_content_show', 'hide-content' );
		//$show_meta    = get_theme_mod( 'adonis_slider_meta_show', 'show-meta' );
		$output       = '';

		$args = array(
			'post_type'           => 'any',
			'orderby'             => 'post__in',
			'ignore_sticky_posts' => 1, // ignore sticky posts
		);

			for ( $i = 1; $i <= $quantity; $i++ ) {
				$post_id = '';

					$post_id = get_theme_mod( 'adonis_slider_page_' . $i );

				if ( $post_id && '' !== $post_id ) {
					$post_list = array_merge( $post_list, array( $post_id ) );

					$no_of_post++;
				}
			}

			$args['post__in'] = $post_list;

		if ( ! $no_of_post ) {
			return;
		}

		$args['posts_per_page'] = $no_of_post;

		$loop = new WP_Query( $args );

		while ( $loop->have_posts() ) :
			$loop->the_post();

			$title_attribute = the_title_attribute( 'echo=0' );

			if ( 0 === $loop->current_post ) {
				$classes = 'post post-' . esc_attr( get_the_ID() ) . ' hentry slides displayblock';
			} else {
				$classes = 'post post-' . esc_attr( get_the_ID() ) . ' hentry slides displaynone';
			}

			// Default value if there is no featurd image or first image.
			$image_url =  trailingslashit( esc_url( get_template_directory_uri() ) ) . 'assets/images/no-thumb-1920x954.jpg';

			if ( has_post_thumbnail() ) {
				$image_url = get_the_post_thumbnail_url( get_the_ID(), 'adonis-slider' );
			} else {
				// Get the first image in page, returns false if there is no image.
				$first_image_url = adonis_get_first_image( get_the_ID(), 'adonis-slider', '', true );

				// Set value of image as first image if there is an image present in the page.
				if ( $first_image_url ) {
					$image_url = $first_image_url;
				}
			}

			$output .= '
			<article class="' . $classes . '">';
				$output .= '
				<div class="slider-image-wrapper">
					<a href="' . esc_url( get_permalink() ) . '" title="' . $title_attribute . '">
							<img src="' . esc_url( $image_url ) . '" class="wp-post-image" alt="' . $title_attribute . '">
						</a>
				</div><!-- .slider-image-wrapper -->

				<div class="slider-content-wrapper">
					<div class="entry-container">
						<header class="entry-header">';
							$output .= '<h2 class="entry-title">
								<a title="' . $title_attribute . '" href="' . esc_url( get_permalink() ) . '">' . the_title( '<span>','</span>', false ) . '</a>
							</h2>';
							$output .='
						</header>
							';

			if ( 'excerpt' === $show_content ) {
				$excerpt = get_the_excerpt();

				$output .= '<div class="entry-summary"><p>' . $excerpt . '</p></div><!-- .entry-summary -->';
			} elseif ( 'full-content' === $show_content ) {
				$content = apply_filters( 'the_content', get_the_content() );
				$content = str_replace( ']]>', ']]&gt;', $content );
				$output .= '<div class="entry-content">' . wp_kses_post( $content ) . '</div><!-- .entry-content -->';
			}

						$output .= '
					</div><!-- .entry-container -->
				</div><!-- .slider-content-wrapper -->
			</article><!-- .slides -->';
		endwhile;

		wp_reset_postdata();

		return $output;
	}
endif; // adonis_post_page_category_slider.


if ( ! function_exists( 'adonis_image_slider' ) ) :
	/**
	 * This function to display featured posts slider
	 *
	 * @get the data value from theme options
	 * @displays on the index
	 *
	 * @usage Featured Image, Title and Excerpt of Post
	 *
	 */
	function adonis_image_slider() {
		$quantity = get_theme_mod( 'adonis_slider_number', 4 );

		$output = '';

		for ( $i = 1; $i <= $quantity; $i++ ) {
			$image = get_theme_mod( 'adonis_slider_image_' . $i );

			// Check Image Not Empty to add in the slides.
			if ( $image ) {
				$imagetitle = get_theme_mod( 'adonis_featured_title_' . $i ) ? get_theme_mod( 'adonis_featured_title_' . $i ) : 'Featured Image-' . $i;

				$title  = '';
				$link   = get_theme_mod( 'adonis_featured_link_' . $i );
				$target = get_theme_mod( 'adonis_featured_target_' . $i ) ? '_blank' : '_self';

				$title = '<header class="entry-header"><h2 class="entry-title"><span>' . esc_html( $imagetitle ) . '</span></h2></header>';

				if ( $link ) {
					$title = '<header class="entry-header"><h2 class="entry-title"><a title="' . esc_attr( $imagetitle ) . '" href="' . esc_url( $link ) . '" target="' . $target . '"><span>' . esc_html( $imagetitle ) . '</span></a></h2></header>';
				}

				$content = get_theme_mod( 'adonis_featured_content_' . $i ) ? '<div class="entry-summary"><p>' . get_theme_mod( 'adonis_featured_content_' . $i ) . '</p></div><!-- .entry-summary -->' : '';

				$contentopening = '';
				$contentclosing = '';

				// Content Opening and Closing.
				if ( ! empty( $title ) || ! empty( $content ) ) {
					$contentopening = '<div class="slider-content-wrapper"><div class="entry-container">';
					$contentclosing = '</div><!-- .entry-container --></div><!-- .slider-content-wrapper -->';
				}

				// Adding in Classes for Display block and none.
				if ( 1 === $i ) {
					$classes = 'displayblock';
				} else {
					$classes = 'displaynone';
				}

				$output .= '
				<article class="image-slides hentry slider-image images-' . esc_attr( $i ) . ' slides  ' . $classes . '">
					<div class="slider-image-wrapper">
						<a href="' . esc_url( $link ) . '" title="' . esc_attr( $imagetitle ) . '">
							<img src="' . esc_url( $image ) . '" class="wp-post-image" alt="' . esc_attr( $imagetitle ) . '">
						</a>
					</div>
					' . $contentopening . $title . $content . $contentclosing . '
				</article><!-- .slides --> ';
			} // End if().
		} // End for().
		return $output;
	}
endif; // adonis_image_slider.
