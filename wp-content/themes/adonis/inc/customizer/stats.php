<?php
/**
 * Stats options
 *
 * @package Adonis
 */

/**
 * Add stats options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function adonis_stats_options( $wp_customize ) {
	$wp_customize->add_section( 'adonis_stats', array(
			'title' => esc_html__( 'Stats', 'adonis' ),
			'panel' => 'adonis_theme_options',
		)
	);

	// Add color scheme setting and control.
	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_stats_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'adonis_sanitize_select',
			'choices'           => adonis_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'adonis' ),
			'section'           => 'adonis_stats',
			'type'              => 'select',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_stats_bg_image',
			'default'           => trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/images/numbers-section-bg.jpg',
			'sanitize_callback' => 'esc_url_raw',
			'active_callback'   => 'adonis_is_stats_active',
			'custom_control'    => 'WP_Customize_Image_Control',
			'label'             => esc_html__( 'Background Image', 'adonis' ),
			'section'           => 'adonis_stats',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_stats_title',
			'default'           => esc_html__( 'Stats', 'adonis' ),
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'adonis_is_stats_active',
			'label'             => esc_html__( 'Title', 'adonis' ),
			'section'           => 'adonis_stats',
			'type'              => 'text',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_stats_sub_title',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'adonis_is_stats_active',
			'label'             => esc_html__( 'Sub Title', 'adonis' ),
			'section'           => 'adonis_stats',
			'type'              => 'textarea',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_stats_number',
			'default'           => 4,
			'sanitize_callback' => 'adonis_sanitize_number_range',
			'active_callback'   => 'adonis_is_stats_active',
			'description'       => esc_html__( 'Save and refresh the page if No of items is changed', 'adonis' ),
			'input_attrs'       => array(
				'style' => 'width: 100px;',
				'min'   => 0,
			),
			'label'             => esc_html__( 'No of Items', 'adonis' ),
			'section'           => 'adonis_stats',
			'type'              => 'number',
			'transport'         => 'postMessage',
		)
	);

	$number = get_theme_mod( 'adonis_stats_number', 4 );

	for ( $i = 1; $i <= $number ; $i++ ) {
	
		adonis_register_option( $wp_customize, array(
				'name'              => 'adonis_stats_page_' . $i,
				'sanitize_callback' => 'adonis_sanitize_post',
				'active_callback'   => 'adonis_is_stats_active',
				'label'             => esc_html__( 'Page', 'adonis' ) . ' ' . $i ,
				'section'           => 'adonis_stats',
				'type'              => 'dropdown-pages',
			)
		);
	} // End for().
}
add_action( 'customize_register', 'adonis_stats_options', 10 );

/** Active Callback Functions **/
if( ! function_exists( 'adonis_is_stats_active' ) ) :
	/**
	* Return true if stat is active
	*
	* @since Adonis 0.1
	*/
	function adonis_is_stats_active( $control ) {
		$enable = $control->manager->get_setting( 'adonis_stats_option' )->value();

		return ( adonis_check_section( $enable ) );
	}
endif;
