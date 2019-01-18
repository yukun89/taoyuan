<?php
/**
 * Theme Customizer
 *
 * @package Adonis
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function adonis_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_setting( 'header_image' )->transport     = 'refresh';


	/**
	 * Here, we are removing the default display_header_text option and adding our won option that will cover this option as well
	 */
	$wp_customize->remove_control( 'display_header_text' );

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_header_text',
			'default'           => 'homepage',
			'description'       => esc_html__( 'When disabled/shown only on homepage, Site Title and Tagline will only be removed only from user view for accessibility purpose.', 'adonis' ),
			'sanitize_callback' => 'adonis_sanitize_select',
			'label'             => esc_html__( 'Enable on', 'adonis' ),
			'section'           => 'title_tagline',
			'type'              => 'select',
			'choices'           => adonis_section_visibility_options(),
			'priority'          => 1,
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_header_content_alignment',
			'default'           => 'align-center',
			'sanitize_callback' => 'adonis_sanitize_select',
			'active_callback'   => 'adonis_header_text_enabled',
			'label'             => esc_html__( 'Content Alignment', 'adonis' ),
			'section'           => 'title_tagline',
			'type'              => 'radio',
			'choices'           => array(
				'align-center' => esc_html__( 'Center Align', 'adonis' ),
				'align-left'   => esc_html__( 'Left Align', 'adonis' ),
				'align-right'  => esc_html__( 'Right Align', 'adonis' ),
			),
			'priority'          => 2,
		)
	);

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector' => '.site-title a',
			'container_inclusive' => false,
			'render_callback' => 'adonis_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector' => '.site-description',
			'container_inclusive' => false,
			'render_callback' => 'adonis_customize_partial_blogdescription',
		) );
	}

	// Reset all settings to default.
	$wp_customize->add_section( 'adonis_reset_all', array(
		'description'   => esc_html__( 'Caution: Reset all settings to default. Refresh the page after save to view full effects.', 'adonis' ),
		'title'         => esc_html__( 'Reset all settings', 'adonis' ),
		'priority'      => 998,
	) );

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_reset_all_settings',
			'sanitize_callback' => 'adonis_sanitize_checkbox',
			'label'             => esc_html__( 'Check to reset all settings to default', 'adonis' ),
			'section'           => 'adonis_reset_all',
			'transport'         => 'postMessage',
			'type'              => 'checkbox',
		)
	);
	// Reset all settings to default end.

	// Important Links.
	$wp_customize->add_section( 'adonis_important_links', array(
		'priority'      => 999,
		'title'         => esc_html__( 'Important Links', 'adonis' ),
	) );

	// Has dummy Sanitizaition function as it contains no value to be sanitized.
	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_important_links',
			'sanitize_callback' => 'sanitize_text_field',
			'custom_control'    => 'Adonis_Important_Links_Control',
			'label'             => esc_html__( 'Important Links', 'adonis' ),
			'section'           => 'adonis_important_links',
			'type'              => 'adonis_important_links',
		)
	);
	// Important Links End.
}
add_action( 'customize_register', 'adonis_customize_register' );

/** Active Callback Functions **/
if ( ! function_exists( 'adonis_header_text_enabled' ) ) :
	/**
	* Return true if header text is enabled
	*
	* @since Adonis 0.1
	*/
	function adonis_header_text_enabled( $control ) {
		$enable = $control->manager->get_setting( 'adonis_header_text' )->value();

		//return true only if previewed page on customizer matches the type of content option selected
		return ( adonis_check_section( $enable ) );
	}
endif;


/**
 * Render the site title for the selective refresh partial.
 *
 * @since Adonis 0.1
 * @see adonis_customize_register()
 *
 * @return void
 */
function adonis_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since Adonis 0.1
 * @see adonis_customize_register()
 *
 * @return void
 */
function adonis_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function adonis_customize_preview_js() {
	wp_enqueue_script( 'adonis-customize-preview', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/js/customize-preview.min.js', array( 'customize-preview' ), '20180103', true );
}
add_action( 'customize_preview_init', 'adonis_customize_preview_js' );

/**
 * Include Custom Controls
 */
require get_parent_theme_file_path( 'inc/customizer/custom-controls.php' );

/**
 * Include Header Media Options
 */
require get_parent_theme_file_path( 'inc/customizer/header-media.php' );

/**
 * Include Theme Options
 */
require get_parent_theme_file_path( 'inc/customizer/theme-options.php' );

/**
 * Include Hero Content
 */
require get_parent_theme_file_path( 'inc/customizer/hero-content.php' );

/**
 * Include Featured Slider
 */
require get_parent_theme_file_path( 'inc/customizer/featured-slider.php' );

/**
 * Include Featured Content
 */
require get_parent_theme_file_path( 'inc/customizer/featured-content.php' );

/**
 * Include Services
 */
require get_parent_theme_file_path( 'inc/customizer/services.php' );

/**
 * Include Testimonial
 */
require get_parent_theme_file_path( 'inc/customizer/testimonial.php' );

/**
 * Include Portfolio
 */
require get_parent_theme_file_path( 'inc/customizer/portfolio.php' );

/**
 * Include Logo Slider
 */
require get_parent_theme_file_path( 'inc/customizer/logo-slider.php' );

/**
 * Include Stats
 */
require get_parent_theme_file_path( 'inc/customizer/stats.php' );

/**
 * Include Contact Info
 */
require get_parent_theme_file_path( 'inc/customizer/contact-info.php' );

/**
 * Include Customizer Helper Functions
 */
require get_parent_theme_file_path( 'inc/customizer/helpers.php' );

/**
 * Include Sanitization functions
 */
require get_parent_theme_file_path( 'inc/customizer/sanitize-functions.php' );

/**
 * Include Upgrade Button
 */
require get_parent_theme_file_path( 'inc/customizer/upgrade-button/class-customize.php' );
