<?php
/**
 * Header Media Options
 *
 * @package Adonis
 */

/**
 * Add Header Media options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function adonis_header_media_options( $wp_customize ) {
	$wp_customize->get_section( 'header_image' )->description = esc_html__( 'If you add video, it will only show up on Homepage/FrontPage. Other Pages will use Header/Post/Page Image depending on your selection of option. Header Image will be used as a fallback while the video loads ', 'adonis' );

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_header_media_option',
			'default'           => 'entire-site-page-post',
			'sanitize_callback' => 'adonis_sanitize_select',
			'choices'           => array(
				'homepage'               => esc_html__( 'Homepage / Frontpage', 'adonis' ),
				'exclude-home'           => esc_html__( 'Excluding Homepage', 'adonis' ),
				'exclude-home-page-post' => esc_html__( 'Excluding Homepage, Page/Post Featured Image', 'adonis' ),
				'entire-site'            => esc_html__( 'Entire Site', 'adonis' ),
				'entire-site-page-post'  => esc_html__( 'Entire Site, Page/Post Featured Image', 'adonis' ),
				'pages-posts'            => esc_html__( 'Pages and Posts', 'adonis' ),
				'disable'                => esc_html__( 'Disabled', 'adonis' ),
			),
			'label'             => esc_html__( 'Enable on', 'adonis' ),
			'section'           => 'header_image',
			'type'              => 'select',
			'priority'          => 1,
		)
	);
}
add_action( 'customize_register', 'adonis_header_media_options' );
