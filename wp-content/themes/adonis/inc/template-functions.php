<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Adonis
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function adonis_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of (full-width|box) to blogs.
	if ( 'boxed' === get_theme_mod( 'adonis_layout_type' ) ) {
		$classes[] = 'boxed-layout';
	} else {
		$classes[] = 'fluid-layout';
	}

	// Adds a class of navigation-(default|classic) to blogs.
		$classes[] = 'navigation-classic';

	// Adds a class with respect to layout selected.
	$layout_class = "no-sidebar content-width-layout";

	$layout  = adonis_get_theme_layout();
	$sidebar = adonis_get_sidebar_id();

	if ( 'right-sidebar' === $layout ) {
		if ( '' !== $sidebar ) {
			$layout_class = 'two-columns-layout content-left';
		}
	}

	$enable_header_text = get_theme_mod( 'adonis_header_text', 'homepage' );

	if ( ! adonis_check_section( $enable_header_text ) ) {
		$classes[] = 'header-text-disabled';
	}

	$header_image = adonis_featured_overall_image();

	if ( $header_image || has_custom_logo() || adonis_check_section( $enable_header_text ) ) {
		$classes[] = 'absolute-header';
	} else {
		$classes[] = 'no-absolute-header';
	}

	$classes[] = $layout_class;

	return $classes;
}
add_filter( 'body_class', 'adonis_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function adonis_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'adonis_pingback_header' );

if ( ! function_exists( 'adonis_comments' ) ) :
	/**
	 * Enable/Disable Comments
	 *
	 * @uses comment_form_default_fields filter
	 * @since Adonis 0.1
	 */
	function adonis_comments( $open, $post_id ) {
		$comment_select = get_theme_mod( 'adonis_comment_option', 'use-wordpress-setting' );

	    if( 'disable-completely' === $comment_select ) {
			return false;
		} elseif( 'disable-in-pages' === $comment_select && is_page() ) {
			return false;
		}

	    return $open;
	}
endif; // adonis_comments.
add_filter( 'comments_open', 'adonis_comments', 10, 2 );

if ( ! function_exists( 'adonis_comment_form_fields' ) ) :
	/**
	 * Modify Comment Form Fields
	 *
	 * @uses comment_form_default_fields filter
	 * @since Adonis 0.1
	 */
	function adonis_comment_form_fields( $fields ) {
	    $disable_website = get_theme_mod( 'adonis_website_field' );

	    if ( isset( $fields['url'] ) && $disable_website ) {
			unset( $fields['url'] );
		}

		return $fields;
	}
endif; // adonis_comment_form_fields.
add_filter( 'comment_form_default_fields', 'adonis_comment_form_fields' );

if ( ! function_exists( 'adonis_excerpt_length' ) ) :
	/**
	 * Sets the post excerpt length to n words.
	 *
	 * function tied to the excerpt_length filter hook.
	 * @uses filter excerpt_length
	 *
	 * @since Adonis 1.0
	 */
	function adonis_excerpt_length( $length ) {
		if ( is_admin() ) {
			return $length;
		}

		// Getting data from Customizer Options
		$length	= get_theme_mod( 'adonis_excerpt_length', 30 );

		return absint( $length );
	}
endif; //adonis_excerpt_length
add_filter( 'excerpt_length', 'adonis_excerpt_length', 999 );

if ( ! function_exists( 'adonis_excerpt_more' ) ) :
	/**
	 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a option from customizer
	 *
	 * @return string option from customizer prepended with an ellipsis.
	 */
	function adonis_excerpt_more( $more ) {
		if ( is_admin() ) {
			return $more;
		}

		$more_tag_text = get_theme_mod( 'adonis_excerpt_more_text',  esc_html__( 'Continue reading', 'adonis' ) );

		$link = sprintf( '<a href="%1$s" class="more-link"><span class="more-button">%2$s</span></a>',
			esc_url( get_permalink() ),
			/* translators: %s: Name of current post */
			wp_kses_data( $more_tag_text ). '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>'
			);

		return $link;
	}
endif;
add_filter( 'excerpt_more', 'adonis_excerpt_more' );

if ( ! function_exists( 'adonis_custom_excerpt' ) ) :
	/**
	 * Adds Continue reading link to more tag excerpts.
	 *
	 * function tied to the get_the_excerpt filter hook.
	 *
	 * @since Adonis 1.0
	 */
	function adonis_custom_excerpt( $output ) {
		if ( has_excerpt() && ! is_attachment() ) {
			$more_tag_text = get_theme_mod( 'adonis_excerpt_more_text', esc_html__( 'Continue reading', 'adonis' ) );

			$link = sprintf( '<a href="%1$s" class="more-link"><span class="more-button">%2$s</span></a>',
				esc_url( get_permalink() ),
				/* translators: %s: Name of current post */
				wp_kses_data( $more_tag_text ). '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>'
			);

			$link = ' &hellip; ' . $link;

			$output .= $link;
		}

		return $output;
	}
endif; //adonis_custom_excerpt
add_filter( 'get_the_excerpt', 'adonis_custom_excerpt' );

if ( ! function_exists( 'adonis_more_link' ) ) :
	/**
	 * Replacing Continue reading link to the_content more.
	 *
	 * function tied to the the_content_more_link filter hook.
	 *
	 * @since Adonis 1.0
	 */
	function adonis_more_link( $more_link, $more_link_text ) {
		$more_tag_text = get_theme_mod( 'adonis_excerpt_more_text', esc_html__( 'Continue reading', 'adonis' ) );

		return ' &hellip; ' . str_replace( $more_link_text, wp_kses_data( $more_tag_text ), $more_link );
	}
endif; //adonis_more_link
add_filter( 'the_content_more_link', 'adonis_more_link', 10, 2 );

if ( ! function_exists( 'adonis_comment_form_fields' ) ) :
	/**
	 * Modify Comment Form Fields
	 *
	 * @uses comment_form_default_fields filter
	 * @since Adonis 0.1
	 */
	function adonis_comment_form_fields( $fields ) {
	    $disable_website = get_theme_mod( 'adonis_website_field' );

	    if ( isset( $fields['url'] ) && $disable_website ) {
			unset( $fields['url'] );
		}

		return $fields;
	}
endif; // adonis_comment_form_fields.
add_filter( 'comment_form_default_fields', 'adonis_comment_form_fields' );

/**
 * Adds logo slider and stats bg css
 */
function adonis_sections_bg_css() {
	$css = array();

	$logo_slider_bg = get_theme_mod( 'adonis_logo_slider_bg_image', trailingslashit( esc_url( get_template_directory_uri() ) ) . 'assets/images/clients-section-bg.jpg' );

	if ( $logo_slider_bg ) {
		$css[] = '#clients-section { background-image: url( "' . esc_url( $logo_slider_bg ) . '" ); }';
	}

	$stats_bg = get_theme_mod( 'adonis_stats_bg_image', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/images/numbers-section-bg.jpg' );

	if ( $stats_bg ) {
		$css[] = '#numbers-section { background-image: url( "' . esc_url( $stats_bg ) . '" ); }';
	}

	$css = implode( PHP_EOL, $css );

	wp_add_inline_style( 'adonis-style', $css );
}
add_action( 'wp_enqueue_scripts', 'adonis_sections_bg_css', 11 );

/**
 * Remove first post from blog as it is already show via recent post template
 */
function adonis_alter_home( $query ) {
	if ( $query->is_home() && $query->is_main_query() ) {
		$cats = get_theme_mod( 'adonis_front_page_category' );

		if ( is_array( $cats ) && ! in_array( '0', $cats ) ) {
			$query->query_vars['category__in'] = $cats;
		}

		if ( get_theme_mod( 'adonis_exclude_slider_post' ) ) {
			$quantity = get_theme_mod( 'adonis_slider_number', 4 );

			$post_list	= array();	// list of valid post ids

			for( $i = 1; $i <= $quantity; $i++ ){
				if ( get_theme_mod( 'adonis_slider_post_' . $i ) && get_theme_mod( 'adonis_slider_post_' . $i ) > 0 ) {
					$post_list = array_merge( $post_list, array( get_theme_mod( 'adonis_slider_post_' . $i ) ) );
				}
			}

			if ( ! empty( $post_list ) ) {
	    		$query->query_vars['post__not_in'] = $post_list;
			}
		}
	}
}
add_action( 'pre_get_posts', 'adonis_alter_home' );

/**
 * Function to add Scroll Up icon
 */
function adonis_scrollup() {
	$disable_scrollup = get_theme_mod( 'adonis_disable_scrollup' );

	if ( $disable_scrollup ) {
		return;
	}

	echo '<a href="#masthead" id="scrollup" class="backtotop">' .adonis_get_svg( array( 'icon' => 'angle-down' ) ) . '<span class="screen-reader-text">' . esc_html__( 'Scroll Up', 'adonis' ) . '</span></a>' ;

}
add_action( 'wp_footer', 'adonis_scrollup', 1 );

if ( ! function_exists( 'adonis_content_nav' ) ) :
	/**
	 * Display navigation/pagination when applicable
	 *
	 * @since Adonis 0.1
	 */
	function adonis_content_nav() {
		global $wp_query;

		// Don't print empty markup in archives if there's only one page.
		if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) ) {
			return;
		}

		$pagination_type = get_theme_mod( 'adonis_pagination_type', 'default' );

		if ( ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) || class_exists( 'Catch_Infinite_Scroll' ) ) {
			// Support infinite scroll plugins.
			the_posts_navigation();
		} elseif ( 'numeric' === $pagination_type && function_exists( 'the_posts_pagination' ) ) {
			the_posts_pagination( array(
				'prev_text'          => '<span>' . esc_html__( 'Previous Page', 'adonis' ) . '</span>',
				'next_text'          => '<span>' . esc_html__( 'Next Page', 'adonis' ) . '</span>',
				'screen_reader_text' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'adonis' ) . ' </span>',
			) );
		} else {
			the_posts_navigation();
		}
	}
endif; // adonis_content_nav

/**
 * Check if a section is enabled or not based on the $value parameter
 * @param  string $value Value of the section that is to be checked
 * @return boolean return true if section is enabled otherwise false
 */
function adonis_check_section( $value ) {
	global $wp_query;

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	// Front page displays in Reading Settings
	$page_for_posts = get_option('page_for_posts');

	return ( 'entire-site' == $value  || ( ( is_front_page() || ( is_home() && intval( $page_for_posts ) !== intval( $page_id ) ) ) && 'homepage' == $value ) );
}

/**
 * Return the first image in a post. Works inside a loop.
 * @param [integer] $post_id [Post or page id]
 * @param [string/array] $size Image size. Either a string keyword (thumbnail, medium, large or full) or a 2-item array representing width and height in pixels, e.g. array(32,32).
 * @param [string/array] $attr Query string or array of attributes.
 * @return [string] image html
 *
 * @since Adonis 0.1
 */
function adonis_get_first_image( $postID, $size, $attr ) {
	ob_start();

	ob_end_clean();

	$image 	= '';

	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_post_field('post_content', $postID ) , $matches);

	if( isset( $matches [1] [0] ) ) {
		//Get first image
		$first_img = $matches [1] [0];

		return '<img class="pngfix wp-post-image" src="'. esc_url( $first_img ) .'">';
	}

	return false;
}

function adonis_get_theme_layout() {
	$layout = '';

	if ( is_page_template( 'templates/no-sidebar.php' ) ) {
		$layout = 'no-sidebar';
	}  elseif ( is_page_template( 'templates/right-sidebar.php' ) ) {
		$layout = 'right-sidebar';
	} else {
		$layout = get_theme_mod( 'adonis_default_layout', 'no-sidebar' );

		if ( is_home() || is_archive() ) {
			$layout = get_theme_mod( 'adonis_homepage_archive_layout', 'no-sidebar' );
		}
	}

	return $layout;
}

function adonis_get_sidebar_id() {
	$sidebar = '';

	$layout = adonis_get_theme_layout();

	$sidebaroptions = '';

	if ( 'no-sidebar' === $layout ) {
		return $sidebar;
	}
		global $post, $wp_query;

		// Front page displays in Reading Settings.
		$page_on_front  = get_option( 'page_on_front' );
		$page_for_posts = get_option( 'page_for_posts' );

		// Get Page ID outside Loop.
		$page_id = $wp_query->get_queried_object_id();
		// Blog Page or Front Page setting in Reading Settings.
		if ( $page_id == $page_for_posts || $page_id == $page_on_front ) {
	        $sidebaroptions = get_post_meta( $page_id, 'adonis-sidebar-option', true );
	    } elseif ( is_singular() ) {
	    	if ( is_attachment() ) {
				$parent 		= $post->post_parent;
				$sidebaroptions = get_post_meta( $parent, 'adonis-sidebar-option', true );

			} else {
				$sidebaroptions = get_post_meta( $post->ID, 'adonis-sidebar-option', true );
			}
		}
	if ( is_active_sidebar( 'sidebar-optional-one' ) && 'optional-sidebar-one' === $sidebaroptions ) {
		$sidebar = 'sidebar-optional-one';
	} elseif ( is_active_sidebar( 'sidebar-optional-two' ) && 'optional-sidebar-two' === $sidebaroptions ) {
		$sidebar = 'sidebar-optional-two';
	} elseif ( is_active_sidebar( 'sidebar-optional-three' ) && 'optional-sidebar-three' === $sidebaroptions ) {
		$sidebar = 'sidebar-optional-three';
	} elseif ( is_active_sidebar( 'sidebar-optional-homepage' ) && ( is_front_page() || ( is_home() && $page_id != $page_for_posts ) ) ) {
		$sidebar = 'sidebar-optional-homepage';
	} elseif ( is_active_sidebar( 'sidebar-optional-archive' ) && ( is_archive() || ( is_home() && $page_id != $page_for_posts ) ) ) {
		$sidebar = 'sidebar-optional-archive';
	} elseif ( is_page() && is_active_sidebar( 'sidebar-optional-page' ) ) {
		$sidebar = 'sidebar-optional-page';
	} elseif ( is_single() && is_active_sidebar( 'sidebar-optional-post' ) ) {
		$sidebar = 'sidebar-optional-post';
	} elseif ( is_active_sidebar( 'sidebar-1' ) ) {
		$sidebar = 'sidebar-1'; // Primary Sidebar.
	}

	return $sidebar;
}

/**
 * Display social Menu
 */
function adonis_social_menu() {
	if ( has_nav_menu( 'social-menu' ) ) :
		?>
		<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Social Links Menu', 'adonis' ); ?>">
			<?php
				wp_nav_menu( array(
					'theme_location' => 'social-menu',
					'link_before'    => '<span class="screen-reader-text">',
					'link_after'     => '</span>',
					'depth'          => 1,
				) );
			?>
		</nav><!-- .social-navigation -->
	<?php endif;
}

if ( ! function_exists( 'adonis_truncate_phrase' ) ) :
	/**
	 * Return a phrase shortened in length to a maximum number of characters.
	 *
	 * Result will be truncated at the last white space in the original string. In this function the word separator is a
	 * single space. Other white space characters (like newlines and tabs) are ignored.
	 *
	 * If the first `$max_characters` of the string does not contain a space character, an empty string will be returned.
	 *
	 * @since Adonis 0.1
	 *
	 * @param string $text            A string to be shortened.
	 * @param integer $max_characters The maximum number of characters to return.
	 *
	 * @return string Truncated string
	 */
	function adonis_truncate_phrase( $text, $max_characters ) {

		$text = trim( $text );

		if ( mb_strlen( $text ) > $max_characters ) {
			//* Truncate $text to $max_characters + 1
			$text = mb_substr( $text, 0, $max_characters + 1 );

			//* Truncate to the last space in the truncated string
			$text = trim( mb_substr( $text, 0, mb_strrpos( $text, ' ' ) ) );
		}

		return $text;
	}
endif; //adonis_truncate_phrase

if ( ! function_exists( 'adonis_get_the_content_limit' ) ) :
	/**
	 * Return content stripped down and limited content.
	 *
	 * Strips out tags and shortcodes, limits the output to `$max_char` characters, and appends an ellipsis and more link to the end.
	 *
	 * @since Adonis 0.1
	 *
	 * @param integer $max_characters The maximum number of characters to return.
	 * @param string  $more_link_text Optional. Text of the more link. Default is "(more...)".
	 * @param bool    $stripteaser    Optional. Strip teaser content before the more text. Default is false.
	 *
	 * @return string Limited content.
	 */
	function adonis_get_the_content_limit( $max_characters, $more_link_text = '(more...)', $stripteaser = false ) {

		$content = get_the_content( '', $stripteaser );

		// Strip tags and shortcodes so the content truncation count is done correctly.
		$content = strip_tags( strip_shortcodes( $content ), apply_filters( 'get_the_content_limit_allowedtags', '<script>,<style>' ) );

		// Remove inline styles / .
		$content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );

		// Truncate $content to $max_char
		$content = adonis_truncate_phrase( $content, $max_characters );

		// More link?
		if ( $more_link_text ) {
			$link   = apply_filters( 'get_the_content_more_link', sprintf( '<span class="more-button"><a href="%s" class="more-link">%s</a></span>', esc_url( get_permalink() ), $more_link_text ), $more_link_text );
			$output = sprintf( '<p>%s %s</p>', $content, $link );
		} else {
			$output = sprintf( '<p>%s</p>', $content );
			$link = '';
		}

		return apply_filters( 'adonis_get_the_content_limit', $output, $content, $link, $max_characters );

	}
endif; //adonis_get_the_content_limit

if ( ! function_exists( 'adonis_content_image' ) ) :
	/**
	 * Template for Featured Image in Archive Content
	 *
	 * To override this in a child theme
	 * simply fabulous-fluid your own adonis_content_image(), and that function will be used instead.
	 *
	 * @since Adonis 0.1
	 */
	function adonis_content_image() {
		if ( has_post_thumbnail() && adonis_jetpack_featured_image_display() && is_singular() ) {
			global $post, $wp_query;

			// Get Page ID outside Loop.
			$page_id = $wp_query->get_queried_object_id();

			if ( $post ) {
		 		if ( is_attachment() ) {
					$parent = $post->post_parent;

					$individual_featured_image = get_post_meta( $parent, 'adonisltheme-single-image', true );
				} else {
					$individual_featured_image = get_post_meta( $page_id, 'adonisltheme-single-image', true );
				}
			}

			if ( empty( $individual_featured_image ) ) {
				$individual_featured_image = 'default';
			}

			if ( 'disable' === $individual_featured_image ) {
				echo '<!-- Page/Post Single Image Disabled or No Image set in Post Thumbnail -->';
				return false;
			} else {
				$class = array();

				$image_size = 'post-thumbnail';

				if ( 'default' !== $individual_featured_image ) {
					$image_size = $individual_featured_image;
					$class[]    = 'from-metabox';
				}

				$class[] = $individual_featured_image;
				?>
				<div class="post-thumbnail <?php echo esc_attr( implode( ' ', $class ) ); ?>">
					<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( $image_size ); ?>
					</a>
				</div>
		   	<?php
			}
		} // End if().
	}
endif; // adonis_content_image.

if ( ! function_exists( 'adonis_enable_homepage_posts' ) ) :
    /**
     * Determine Homepage Content disabled or not
     * @return boolean
     */
    function adonis_enable_homepage_posts() {
       if ( ! ( get_theme_mod( 'adonis_disable_homepage_posts' ) && is_front_page() ) ) {
            return true;
        }
        return false;
    }
endif; // adonis_enable_homepage_posts.

if ( ! function_exists( 'adonis_get_featured_posts' ) ) :
	/**
	 * Featured content Posts
	 */
	function adonis_get_featured_posts() {

		$number = get_theme_mod( 'adonis_featured_content_number', 6 );

		$post_list    = array();

		$args = array(
			'posts_per_page'      => $number,
			'post_type'           => 'post',
			'ignore_sticky_posts' => 1, // ignore sticky posts.
		);

		// Get valid number of posts.
			$args['post_type'] = 'featured-content';

			for ( $i = 1; $i <= $number; $i++ ) {
				$post_id = '';

					$post_id = get_theme_mod( 'adonis_featured_content_cpt_' . $i );

				if ( $post_id && '' !== $post_id ) {
					$post_list = array_merge( $post_list, array( $post_id ) );
				}
			}

			$args['post__in'] = $post_list;
			$args['orderby']  = 'post__in';

		$featured_posts = get_posts( $args );

		return $featured_posts;
	}
endif; // adonis_get_featured_posts.
