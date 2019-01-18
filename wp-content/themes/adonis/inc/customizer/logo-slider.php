<?php
/**
 * Logo Slider Options
 *
 * @package Adonis
 */

/**
 * Add Logo Slider options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function adonis_logo_slider_options( $wp_customize ) {
	$wp_customize->add_section( 'adonis_logo_slider', array(
			'title' => esc_html__( 'Logo Slider', 'adonis' ),
			'panel' => 'adonis_theme_options',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_logo_slider_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'adonis_sanitize_select',
			'choices'           => adonis_section_visibility_options(),
			'label'             => esc_html__( 'Enable Logo Slider on', 'adonis' ),
			'section'           => 'adonis_logo_slider',
			'type'              => 'select',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_logo_slider_bg_image',
			'default'           => trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/images/clients-section-bg.jpg',
			'sanitize_callback' => 'esc_url_raw',
			'active_callback'   => 'adonis_is_logo_slider_active',
			'custom_control'    => 'WP_Customize_Image_Control',
			'label'             => esc_html__( 'Background Image', 'adonis' ),
			'section'           => 'adonis_logo_slider',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_logo_slider_title',
			'default'           => esc_html__( 'Logo Slider', 'adonis' ),
			'sanitize_callback' => 'sanitize_text_field',
			'active_callback'   => 'adonis_is_logo_slider_active',
			'label'             => esc_html__( 'Title', 'adonis' ),
			'section'           => 'adonis_logo_slider',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_logo_slider_sub_title',
			'sanitize_callback' => 'sanitize_text_field',
			'active_callback'   => 'adonis_is_logo_slider_active',
			'label'             => esc_html__( 'Sub Title', 'adonis' ),
			'section'           => 'adonis_logo_slider',
			'type'              => 'textarea',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_logo_slider_number',
			'default'           => 4,
			'sanitize_callback' => 'adonis_sanitize_number_range',
			'active_callback'   => 'adonis_is_logo_slider_active',
			'description'       => esc_html__( 'Save and refresh the page if No. of Items is changed', 'adonis' ),
			'input_attrs'       => array(
				'style' => 'width: 45px;',
				'min'   => 0,
			),
			'label'             => esc_html__( 'No of Items', 'adonis' ),
			'section'           => 'adonis_logo_slider',
			'type'              => 'number',
		)
	);


	//loop for featured post sliders
	for ( $i=1; $i <= get_theme_mod( 'adonis_logo_slider_number', 4 ); $i++ ) {

		//page content
		adonis_register_option( $wp_customize, array(
				'name'              => 'adonis_logo_slider_page_'. $i,
				'sanitize_callback' => 'adonis_sanitize_post',
				'active_callback'   => 'adonis_is_logo_slider_active',
				'label'             => esc_html__( 'Page', 'adonis' ) . ' ' . $i ,
				'section'           => 'adonis_logo_slider',
				'type'              => 'dropdown-pages',
			)
		);
	}
}
add_action( 'customize_register', 'adonis_logo_slider_options', 10 );

/** Active Callback Functions **/
if ( ! function_exists( 'adonis_is_logo_slider_active' ) ) :
	/**
	* Return true if logo_slider is active
	*
	* @since Adonis 1.0
	*/
	function adonis_is_logo_slider_active( $control ) {
		$enable = $control->manager->get_setting( 'adonis_logo_slider_option' )->value();

		return ( adonis_check_section( $enable ) );
	}
endif;
