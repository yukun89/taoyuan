<?php
/**
 * Theme Options
 *
 * @package Adonis
 */

/**
 * Add theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function adonis_theme_options( $wp_customize ) {
	$wp_customize->add_panel( 'adonis_theme_options', array(
		'title'    => esc_html__( 'Theme Options', 'adonis' ),
		'priority' => 130,
	) );

	// Breadcrumb Option.
	$wp_customize->add_section( 'adonis_breadcrumb_options', array(
			'description' => esc_html__( 'Breadcrumbs are a great way of letting your visitors find out where they are on your site with just a glance.', 'adonis' ),
			'panel'       => 'adonis_theme_options',
			'title'       => esc_html__( 'Breadcrumb', 'adonis' ),
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_breadcrumb_option',
			'default'           => 1,
			'sanitize_callback' => 'adonis_sanitize_checkbox',
			'label'             => esc_html__( 'Check to enable Breadcrumb', 'adonis' ),
			'section'           => 'adonis_breadcrumb_options',
			'type'              => 'checkbox',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_breadcrumb_on_homepage',
			'sanitize_callback' => 'adonis_sanitize_checkbox',
			'label'             => esc_html__( 'Check to enable Breadcrumb on Homepage', 'adonis' ),
			'section'           => 'adonis_breadcrumb_options',
			'type'              => 'checkbox',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_breadcrumb_seperator',
			'default'           => '/',
			'sanitize_callback' => 'wp_kses_data',
			'input_attrs'       => array(
				'style' => 'width: 100px;'
			),
			'label'             => esc_html__( 'Separator between Breadcrumbs', 'adonis' ),
			'section'           => 'adonis_breadcrumb_options',
			'type'              => 'text'
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_reset_typography',
			'sanitize_callback' => 'adonis_sanitize_checkbox',
			'transport'         => 'postMessage',
			'label'             => esc_html__( 'Check to reset fonts', 'adonis' ),
			'section'           => 'adonis_font_family',
			'type'              => 'checkbox',
		)
	);


	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_latest_posts_title',
			'default'           => esc_html__( 'News', 'adonis' ),
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Latest Posts Title', 'adonis' ),
			'section'           => 'adonis_theme_options',
		)
	);

	// Layout Options
	$wp_customize->add_section( 'adonis_layout_options', array(
		'title' => esc_html__( 'Layout Options', 'adonis' ),
		'panel' => 'adonis_theme_options',
		)
	);

	/* Layout Type */
	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_layout_type',
			'default'           => 'fluid',
			'sanitize_callback' => 'adonis_sanitize_select',
			'label'             => esc_html__( 'Site Layout', 'adonis' ),
			'section'           => 'adonis_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'fluid' => esc_html__( 'Fluid', 'adonis' ),
				'boxed' => esc_html__( 'Boxed', 'adonis' ),
			),
		)
	);

	/* Default Layout */
	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_default_layout',
			'default'           => 'no-sidebar',
			'sanitize_callback' => 'adonis_sanitize_select',
			'label'             => esc_html__( 'Default Layout', 'adonis' ),
			'section'           => 'adonis_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'adonis' ),
				'no-sidebar'            => esc_html__( 'No Sidebar', 'adonis' ),
			),
		)
	);

	/* Homepage/Archive Layout */
	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_homepage_archive_layout',
			'default'           => 'no-sidebar',
			'sanitize_callback' => 'adonis_sanitize_select',
			'label'             => esc_html__( 'Homepage/Archive Layout', 'adonis' ),
			'section'           => 'adonis_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'right-sidebar'         => esc_html__( 'Right Sidebar ( Content, Primary Sidebar )', 'adonis' ),
				'no-sidebar'            => esc_html__( 'No Sidebar', 'adonis' ),
			),
		)
	);

	/* Single Page/Post Image Layout */
	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_single_layout',
			'default'           => 'disabled',
			'sanitize_callback' => 'adonis_sanitize_select',
			'label'             => esc_html__( 'Single Page/Post Image Layout', 'adonis' ),
			'section'           => 'adonis_layout_options',
			'type'              => 'radio',
			'choices'           => array(
				'disabled'              => esc_html__( 'Disabled', 'adonis' ),
				'post-thumbnail'        => esc_html__( 'Enable', 'adonis' ),

			),
		)
	);

	// Excerpt Options.
	$wp_customize->add_section( 'adonis_excerpt_options', array(
		'panel'     => 'adonis_theme_options',
		'title'     => esc_html__( 'Excerpt Options', 'adonis' ),
	) );

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_excerpt_length',
			'default'           => '20',
			'sanitize_callback' => 'absint',
			'description' => esc_html__( 'Excerpt length. Default is 30 words', 'adonis' ),
			'input_attrs' => array(
				'min'   => 10,
				'max'   => 200,
				'step'  => 5,
				'style' => 'width: 60px;',
			),
			'label'    => esc_html__( 'Excerpt Length (words)', 'adonis' ),
			'section'  => 'adonis_excerpt_options',
			'type'     => 'number',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_excerpt_more_text',
			'default'           => esc_html__( 'Continue reading...', 'adonis' ),
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Read More Text', 'adonis' ),
			'section'           => 'adonis_excerpt_options',
			'type'              => 'text',
		)
	);

	// Excerpt Options.
	$wp_customize->add_section( 'adonis_search_options', array(
		'panel'     => 'adonis_theme_options',
		'title'     => esc_html__( 'Search Options', 'adonis' ),
	) );

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_search_text',
			'default'           => esc_html__( 'Search', 'adonis' ),
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Search Text', 'adonis' ),
			'section'           => 'adonis_search_options',
			'type'              => 'text',
		)
	);

	// Homepage / Frontpage Options.
	$wp_customize->add_section( 'adonis_homepage_options', array(
		'description' => esc_html__( 'Only posts that belong to the categories selected here will be displayed on the front page', 'adonis' ),
		'panel'       => 'adonis_theme_options',
		'title'       => esc_html__( 'Homepage / Frontpage Options', 'adonis' ),
	) );

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_front_page_category',
			'sanitize_callback' => 'adonis_sanitize_category_list',
			'custom_control'    => 'Adonis_Multi_Categories_Control',
			'label'             => esc_html__( 'Categories', 'adonis' ),
			'section'           => 'adonis_homepage_options',
			'type'              => 'dropdown-categories',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_recent_posts_heading',
			'sanitize_callback' => 'sanitize_text_field',
			'active_callback'   => 'adonis_is_recent_posts_on_static_page_enabled',
			'default'           => esc_html__( 'Recent Posts', 'adonis' ),
			'label'             => esc_html__( 'Recent Posts Heading', 'adonis' ),
			'section'           => 'adonis_homepage_options',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_recent_posts_subheading',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'adonis_is_recent_posts_on_static_page_enabled',
			'label'             => esc_html__( 'Recent Posts Sub Heading', 'adonis' ),
			'section'           => 'adonis_homepage_options',
			'type'              => 'textarea'
		)
	);

	// Pagination Options.
	$pagination_type = get_theme_mod( 'adonis_pagination_type', 'default' );

	$nav_desc = '';

	/**
	* Check if navigation type is Jetpack Infinite Scroll and if it is enabled
	*/
	$nav_desc = sprintf(
		wp_kses(
			__( 'For infinite scrolling, use %1$sCatch Infinite Scroll Plugin%2$s with Infinite Scroll module Enabled.', 'adonis' ),
			array(
				'a' => array(
					'href' => array(),
					'target' => array(),
				),
				'br'=> array()
			)
		),
		'<a target="_blank" href="https://wordpress.org/plugins/catch-infinite-scroll/">',
		'</a>'
	);

	$wp_customize->add_section( 'adonis_pagination_options', array(
		'description' => $nav_desc,
		'panel'       => 'adonis_theme_options',
		'title'       => esc_html__( 'Pagination Options', 'adonis' ),
	) );

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_pagination_type',
			'default'           => 'default',
			'sanitize_callback' => 'adonis_sanitize_select',
			'choices'           => adonis_get_pagination_types(),
			'label'             => esc_html__( 'Pagination type', 'adonis' ),
			'section'           => 'adonis_pagination_options',
			'type'              => 'select',
		)
	);

	// For WooCommerce layout: adonis_woocommerce_layout, check woocommerce-options.php.
	/* Scrollup Options */
	$wp_customize->add_section( 'adonis_scrollup', array(
		'panel'    => 'adonis_theme_options',
		'title'    => esc_html__( 'Scrollup Options', 'adonis' ),
	) );

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_disable_scrollup',
			'sanitize_callback' => 'adonis_sanitize_checkbox',
			'label'             => esc_html__( 'Disable Scroll Up', 'adonis' ),
			'section'           => 'adonis_scrollup',
			'type'              => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'adonis_theme_options' );

if( ! function_exists( 'adonis_is_recent_posts_on_static_page_enabled' ) ) :
	/**
	* Return true if recent posts on static page enabled
	*
	* @since Adonis Pro 1.0
	*/
	function adonis_is_recent_posts_on_static_page_enabled( $control ) {
		$is_home_and_blog = is_home() && is_front_page();
		return ( $is_home_and_blog );
	}
endif;
