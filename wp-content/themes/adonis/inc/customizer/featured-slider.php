<?php
/**
 * Featured Slider Options
 *
 * @package Adonis
 */

/**
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function adonis_slider_options( $wp_customize ) {
	$wp_customize->add_section( 'adonis_featured_slider', array(
			'panel' => 'adonis_theme_options',
			'title' => esc_html__( 'Featured Slider', 'adonis' ),
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_slider_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'adonis_sanitize_select',
			'choices'           => adonis_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'adonis' ),
			'section'           => 'adonis_featured_slider',
			'type'              => 'select',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_slider_transition_effect',
			'default'           => 'fade',
			'sanitize_callback' => 'adonis_sanitize_select',
			'active_callback'   => 'adonis_is_slider_active',
			'choices'           => adonis_slider_transition_effects(),
			'label'             => esc_html__( 'Transition Effect', 'adonis' ),
			'section'           => 'adonis_featured_slider',
			'type'              => 'select',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_slider_transition_delay',
			'default'           => '4',
			'sanitize_callback' => 'absint',
			'active_callback'   => 'adonis_is_slider_active',
			'description'       => esc_html__( 'seconds(s)', 'adonis' ),
			'input_attrs'       => array(
				'style' => 'width: 40px;',
			),
			'label'             => esc_html__( 'Transition Delay', 'adonis' ),
			'section'           => 'adonis_featured_slider',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_slider_transition_length',
			'default'           => '1',
			'sanitize_callback' => 'absint',

			'active_callback'   => 'adonis_is_slider_active',
			'description'       => esc_html__( 'seconds(s)', 'adonis' ),
			'input_attrs'       => array(
				'style' => 'width: 100px;',
			),
			'label'             => esc_html__( 'Transition Length', 'adonis' ),
			'section'           => 'adonis_featured_slider',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_slider_image_loader',
			'default'           => 'false',
			'sanitize_callback' => 'adonis_sanitize_select',
			'active_callback'   => 'adonis_is_slider_active',
			'choices'           => adonis_slider_image_loader(),
			'label'             => esc_html__( 'Image Loader', 'adonis' ),
			'section'           => 'adonis_featured_slider',
			'type'              => 'select',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_slider_number',
			'default'           => '4',
			'sanitize_callback' => 'adonis_sanitize_number_range',

			'active_callback'   => 'adonis_is_slider_active',
			'description'       => esc_html__( 'Save and refresh the page if No of items is changed', 'adonis' ),
			'input_attrs'       => array(
				'style' => 'width: 45px;',
				'min'   => 0,
				'step'  => 1,
			),
			'label'             => esc_html__( 'No of Items', 'adonis' ),
			'section'           => 'adonis_featured_slider',
			'type'              => 'number',
			'transport'         => 'postMessage',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_slider_content_show',
			'default'           => 'hide-content',
			'sanitize_callback' => 'adonis_sanitize_select',
			'active_callback'   => 'adonis_is_slider_active',
			'choices'           => adonis_content_show(),
			'label'             => esc_html__( 'Display Content', 'adonis' ),
			'section'           => 'adonis_featured_slider',
			'type'              => 'select',
		)
	);

	$slider_number = get_theme_mod( 'adonis_slider_number', 4 );

	for ( $i = 1; $i <= $slider_number ; $i++ ) {
		// Page Sliders
		adonis_register_option( $wp_customize, array(
				'name'              =>'adonis_slider_page_' . $i,
				'sanitize_callback' => 'adonis_sanitize_post',
				'active_callback'   => 'adonis_is_slider_active',
				'label'             => esc_html__( 'Page', 'adonis' ) . ' # ' . $i,
				'section'           => 'adonis_featured_slider',
				'type'              => 'dropdown-pages',
			)
		);
	} // End for().
}
add_action( 'customize_register', 'adonis_slider_options' );


/**
 * Returns an array of feature slider transition effects
 *
 * @since Adonis 0.1
 */
function adonis_slider_transition_effects() {
	$options = array(
		'fade'       => esc_html__( 'Fade', 'adonis' ),
		'fadeout'    => esc_html__( 'Fade Out', 'adonis' ),
		'none'       => esc_html__( 'None', 'adonis' ),
		'scrollHorz' => esc_html__( 'Scroll Horizontal', 'adonis' ),
		'scrollVert' => esc_html__( 'Scroll Vertical', 'adonis' ),
		'flipHorz'   => esc_html__( 'Flip Horizontal', 'adonis' ),
		'flipVert'   => esc_html__( 'Flip Vertical', 'adonis' ),
		'tileSlide'  => esc_html__( 'Tile Slide', 'adonis' ),
		'tileBlind'  => esc_html__( 'Tile Blind', 'adonis' ),
		'shuffle'    => esc_html__( 'Shuffle', 'adonis' ),
	);

	return apply_filters( 'adonis_slider_transition_effects', $options );
}


/**
 * Returns an array of featured slider image loader options
 *
 * @since Adonis 0.1
 */
function adonis_slider_image_loader() {
	$options = array(
		'true'  => esc_html__( 'True', 'adonis' ),
		'wait'  => esc_html__( 'Wait', 'adonis' ),
		'false' => esc_html__( 'False', 'adonis' ),
	);

	return apply_filters( 'adonis_slider_image_loader', $options );
}


/**
 * Returns an array of featured content show registered
 *
 * @since Adonis 0.1
 */
function adonis_content_show() {
	$options = array(
		'excerpt'      => esc_html__( 'Show Excerpt', 'adonis' ),
		'full-content' => esc_html__( 'Full Content', 'adonis' ),
		'hide-content' => esc_html__( 'Hide Content', 'adonis' ),
	);
	return apply_filters( 'adonis_content_show', $options );
}

/** Active Callback Functions */

if( ! function_exists( 'adonis_is_slider_active' ) ) :
	/**
	* Return true if slider is active
	*
	* @since Adonis 0.1
	*/
	function adonis_is_slider_active( $control ) {
		$enable = $control->manager->get_setting( 'adonis_slider_option' )->value();

		return ( adonis_check_section( $enable ) );
	}
endif;