<?php
/**
 * Add Portfolio Settings in Customizer
 *
 * @package Adonis
 */

/**
 * Add portfolio options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function adonis_portfolio_options( $wp_customize ) {
    // Add note to Jetpack Portfolio Section
    adonis_register_option( $wp_customize, array(
            'name'              => 'adonis_jetpack_portfolio_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Adonis_Note_Control',
            'label'             => sprintf( esc_html__( 'For Portfolio Options for this theme, go %1$shere%2$s', 'adonis' ),
                 '<a href="javascript:wp.customize.section( \'adonis_portfolio\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'jetpack_portfolio',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	$wp_customize->add_section( 'adonis_portfolio', array(
            'panel'    => 'adonis_theme_options',
            'title'    => esc_html__( 'Portfolio', 'adonis' ),
        )
    );

    adonis_register_option( $wp_customize, array(
            'name'              => 'adonis_portfolio_note_1',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Adonis_Note_Control',
            'active_callback'   => 'adonis_is_ect_portfolio_inactive',
            'label'             => sprintf( esc_html__( 'For Portfolio, install %1$sEssential Content Types%2$s Plugin with Portfolio Content Type Enabled', 'adonis' ),
                '<a target="_blank" href="https://wordpress.org/plugins/essential-content-types/">',
                '</a>'
            ),
            'section'           => 'adonis_portfolio',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_portfolio_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'adonis_sanitize_select',
            'active_callback'   => 'adonis_is_ect_portfolio_active',
			'choices'           => adonis_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'adonis' ),
			'section'           => 'adonis_portfolio',
			'type'              => 'select',
		)
	);

    adonis_register_option( $wp_customize, array(
            'name'              => 'adonis_portfolio_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Adonis_Note_Control',
            'active_callback'   => 'adonis_is_portfolio_active',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'adonis' ),
                 '<a href="javascript:wp.customize.control( \'jetpack_portfolio_title\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'adonis_portfolio',
            'type'              => 'description',
        )
    );

    adonis_register_option( $wp_customize, array(
            'name'              => 'adonis_portfolio_number',
            'default'           => 8,
            'sanitize_callback' => 'adonis_sanitize_number_range',
            'active_callback'   => 'adonis_is_portfolio_active',
            'label'             => esc_html__( 'No of items', 'adonis' ),
            'section'           => 'adonis_portfolio',
            'type'              => 'number',
            'input_attrs'       => array(
                'style'             => 'width: 100px;',
                'min'               => 0,
            ),
        )
    );

    $number = get_theme_mod( 'adonis_portfolio_number', 8 );

    for ( $i = 1; $i <= $number ; $i++ ) {
        //for CPT
        adonis_register_option( $wp_customize, array(
                'name'              => 'adonis_portfolio_cpt_' . $i,
                'sanitize_callback' => 'adonis_sanitize_post',
                'active_callback'   => 'adonis_is_portfolio_active',
                'label'             => esc_html__( 'Portfolio', 'adonis' ) . ' ' . $i ,
                'section'           => 'adonis_portfolio',
                'type'              => 'select',
                'choices'           => adonis_generate_post_array( 'jetpack-portfolio' ),
            )
        );
    } // End for().

    adonis_register_option( $wp_customize, array(
            'name'              => 'adonis_portfolio_text',
            'default'           => esc_html__( 'View More', 'adonis' ),
            'sanitize_callback' => 'sanitize_text_field',
            'active_callback'   => 'adonis_is_portfolio_active',
            'label'             => esc_html__( 'Button Text', 'adonis' ),
            'section'           => 'adonis_portfolio',
            'type'              => 'text',
        )
    );

    adonis_register_option( $wp_customize, array(
            'name'              => 'adonis_portfolio_link',
            'sanitize_callback' => 'esc_url_raw',
            'active_callback'   => 'adonis_is_portfolio_active',
            'label'             => esc_html__( 'Button Link', 'adonis' ),
            'section'           => 'adonis_portfolio',
        )
    );

    adonis_register_option( $wp_customize, array(
            'name'              => 'adonis_portfolio_target',
            'sanitize_callback' => 'adonis_sanitize_checkbox',
            'active_callback'   => 'adonis_is_portfolio_active',
            'label'             => esc_html__( 'Check to Open Link in New Window/Tab', 'adonis' ),
            'section'           => 'adonis_portfolio',
            'type'              => 'checkbox',
        )
    );
}
add_action( 'customize_register', 'adonis_portfolio_options' );

/**
 * Active Callback Functions
 */
if ( ! function_exists( 'adonis_is_portfolio_active' ) ) :
    /**
    * Return true if portfolio is active
    *
    * @since Adonis 0.1
    */
    function adonis_is_portfolio_active( $control ) {
        $enable = $control->manager->get_setting( 'adonis_portfolio_option' )->value();

        //return true only if previwed page on customizer matches the type of content option selected
        return ( adonis_is_ect_portfolio_active ($control) && adonis_check_section( $enable ) );
    }
endif;

if ( ! function_exists( 'adonis_is_ect_portfolio_inactive' ) ) :
    /**
    *
    * @since Adonis 0.1
    */
    function adonis_is_ect_portfolio_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Jetpack_Portfolio' ) || class_exists( 'Essential_Content_Pro_Jetpack_Portfolio' ) );
    }
endif;

if ( ! function_exists( 'adonis_is_ect_portfolio_active' ) ) :
    /**
    *
    * @since Adonis 0.1
    */
    function adonis_is_ect_portfolio_active( $control ) {
        return ( class_exists( 'Essential_Content_Jetpack_Portfolio' ) || class_exists( 'Essential_Content_Pro_Jetpack_Portfolio' ) );
    }
endif;
