<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Adonis
 */

if ( ! function_exists( 'adonis_featured_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own adonis_featured_image(), and that function will be used instead.
	 *
	 * @since Adonis 0.1
	 */
	function adonis_featured_image() {
		$thumbnail = is_front_page() ? 'adonis-header-inner' : 'adonis-slider';

		if ( is_post_type_archive( 'jetpack-testimonial' ) ) {
			$jetpack_options = get_theme_mod( 'jetpack_testimonials' );

			if ( isset( $jetpack_options['featured-image'] ) && '' !== $jetpack_options['featured-image'] ) {
				$image = wp_get_attachment_image_src( (int) $jetpack_options['featured-image'], $thumbnail );
				return $image[0];
			} else {
				return false;
			}
		} elseif ( is_post_type_archive( 'jetpack-portfolio' ) || is_post_type_archive( 'featured-content' ) || is_post_type_archive( 'ect-service' ) ) {
			$option = '';

			if ( is_post_type_archive( 'jetpack-portfolio' ) ) {
				$option = 'jetpack_portfolio_featured_image';
			} elseif ( is_post_type_archive( 'featured-content' ) ) {
				$option = 'featured_content_featured_image';
			} elseif ( is_post_type_archive( 'ect-service' ) ) {
				$option = 'ect_service_featured_image';
			}

			$featured_image = get_option( $option );

			if ( '' !== $featured_image ) {
				$image = wp_get_attachment_image_src( (int) $featured_image, $thumbnail );
				return $image[0];
			} else {
				return get_header_image();
			}
		} elseif ( is_header_video_active() && has_header_video() ) {
			return get_header_image();
		} else {
			return get_header_image();
		}
	} // adonis_featured_image
endif;

if ( ! function_exists( 'adonis_featured_page_post_image' ) ) :
	/**
	 * Template for Featured Header Image from Post and Page
	 *
	 * To override this in a child theme
	 * simply create your own adonis_featured_imaage_pagepost(), and that function will be used instead.
	 *
	 * @since Adonis 0.1
	 */
	function adonis_featured_page_post_image() {
		$thumbnail = is_front_page() ? 'adonis-header-inner' : 'adonis-slider';

		if ( is_home() && $blog_id = get_option('page_for_posts') ) {
		    return get_the_post_thumbnail_url( $blog_id, $thumbnail );
		} elseif ( ! has_post_thumbnail() ) {
			return adonis_featured_image();
		} elseif ( is_home() && is_front_page() ) {
			return adonis_featured_image();
		}

		return get_the_post_thumbnail_url( get_the_id(), $thumbnail );
	} // adonis_featured_page_post_image
endif;

if ( ! function_exists( 'adonis_featured_overall_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own adonis_featured_pagepost_image(), and that function will be used instead.
	 *
	 * @since Adonis 0.1
	 */
	function adonis_featured_overall_image() {
		global $post, $wp_query;
		$enable = get_theme_mod( 'adonis_header_media_option', 'entire-site-page-post' );

		// Get Page ID outside Loop
		$page_id = absint( $wp_query->get_queried_object_id() );

		$page_for_posts = absint( get_option( 'page_for_posts' ) );

		// Check Enable/Disable header image in Page/Post Meta box
		if ( is_singular() ) {
			//Individual Page/Post Image Setting
			$individual_featured_image = get_post_meta( $post->ID, 'adonis-header-image', true );

			if ( 'disable' === $individual_featured_image || ( 'default' === $individual_featured_image && 'disable' === $enable ) ) {
				return;
			} elseif ( 'enable' == $individual_featured_image && 'disable' === $enable ) {
				return adonis_featured_page_post_image();
			}
		}

		// Check Homepage
		if ( 'homepage' === $enable ) {
			if ( is_front_page() || ( is_home() && $page_for_posts !== $page_id ) ) {
				return adonis_featured_image();
			}
		} elseif ( 'exclude-home' === $enable ) {
			// Check Excluding Homepage
			if ( is_front_page() || ( is_home() && $page_for_posts !== $page_id ) ) {
				return false;
			} else {
				return adonis_featured_image();
			}
		} elseif ( 'exclude-home-page-post' === $enable ) {
			if ( is_front_page() || ( is_home() && $page_for_posts !== $page_id ) ) {
				return false;
			} elseif ( is_singular() ) {
				return adonis_featured_page_post_image();
			} else {
				return adonis_featured_image();
			}
		} elseif ( 'entire-site' === $enable ) {
			// Check Entire Site
			return adonis_featured_image();
		} elseif ( 'entire-site-page-post' === $enable ) {
			// Check Entire Site (Post/Page)
			if ( is_singular() || ( is_home() && $page_for_posts === $page_id ) ) {
				return adonis_featured_page_post_image();
			} else {
				return adonis_featured_image();
			}
		} elseif ( 'pages-posts' === $enable ) {
			// Check Page/Post
			if ( is_singular() ) {
				return adonis_featured_page_post_image();
			}
		}

		return false;
	} // adonis_featured_overall_image
endif;
