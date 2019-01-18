<?php
/**
 * Add Testimonial Settings in Customizer
 *
 * @package Adonis
*/

/**
 * Add testimonial options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function adonis_testimonial_options( $wp_customize ) {
    // Add note to Jetpack Testimonial Section
    adonis_register_option( $wp_customize, array(
            'name'              => 'adonis_jetpack_testimonial_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Adonis_Note_Control',
            'label'             => sprintf( esc_html__( 'For Testimonial Options for this theme, go %1$shere%2$s', 'adonis' ),
                '<a href="javascript:wp.customize.section( \'adonis_testimonials\' ).focus();">',
                 '</a>'
            ),
           'section'            => 'jetpack_testimonials',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    $wp_customize->add_section( 'adonis_testimonials', array(
            'panel'    => 'adonis_theme_options',
            'title'    => esc_html__( 'Testimonials', 'adonis' ),
        )
    );

    adonis_register_option( $wp_customize, array(
            'name'              => 'adonis_testimonial_note_1',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Adonis_Note_Control',
            'active_callback'   => 'adonis_is_ect_testimonial_inactive',
            'label'             => sprintf( esc_html__( 'For Testimonial, install %1$sEssential Content Types%2$s Plugin with Testimonial Content Type Enabled', 'adonis' ),
                '<a target="_blank" href="https://wordpress.org/plugins/essential-content-types/">',
                '</a>'
            ),
            'section'           => 'adonis_testimonials',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    adonis_register_option( $wp_customize, array(
            'name'              => 'adonis_testimonial_option',
            'default'           => 'disabled',
            'active_callback'   => 'adonis_is_ect_testimonial_active',
            'sanitize_callback' => 'adonis_sanitize_select',
            'choices'           => adonis_section_visibility_options(),
            'label'             => esc_html__( 'Enable on', 'adonis' ),
            'section'           => 'adonis_testimonials',
            'type'              => 'select',
            'priority'          => 1,
        )
    );

    adonis_register_option( $wp_customize, array(
            'name'              => 'adonis_testimonial_slider',
            'default'           => 1,
            'sanitize_callback' => 'adonis_sanitize_checkbox',
            'active_callback'   => 'adonis_is_testimonial_active',
            'label'             => esc_html__( 'Check to Enable Slider', 'adonis' ),
            'section'           => 'adonis_testimonials',
            'type'              => 'checkbox',
        )
    );

    adonis_register_option( $wp_customize, array(
            'name'              => 'adonis_testimonial_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Adonis_Note_Control',
            'active_callback'   => 'adonis_is_testimonial_active',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'adonis' ),
                '<a href="javascript:wp.customize.section( \'jetpack_testimonials\' ).focus();">',
                '</a>'
            ),
            'section'           => 'adonis_testimonials',
            'type'              => 'description',
        )
    );


    adonis_register_option( $wp_customize, array(
            'name'              => 'adonis_testimonial_number',
            'default'           => '3',
            'sanitize_callback' => 'adonis_sanitize_number_range',
            'active_callback'   => 'adonis_is_testimonial_active',
            'label'             => esc_html__( 'No of items', 'adonis' ),
            'section'           => 'adonis_testimonials',
            'type'              => 'number',
            'input_attrs'       => array(
                'style'             => 'width: 100px;',
                'min'               => 0,
            ),
        )
    );

    $number = get_theme_mod( 'adonis_testimonial_number', 3 );

    for ( $i = 1; $i <= $number ; $i++ ) {

        //for CPT
        adonis_register_option( $wp_customize, array(
                'name'              => 'adonis_testimonial_cpt_' . $i,
                'sanitize_callback' => 'adonis_sanitize_post',
                'active_callback'   => 'adonis_is_testimonial_active',
                'label'             => esc_html__( 'Testimonial', 'adonis' ) . ' ' . $i ,
                'section'           => 'adonis_testimonials',
                'type'              => 'select',
                'choices'           => adonis_generate_post_array( 'jetpack-testimonial' ),
            )
        );
    } // End for().
}
add_action( 'customize_register', 'adonis_testimonial_options' );

/**
 * Active Callback Functions
 */
if ( ! function_exists( 'adonis_is_testimonial_active' ) ) :
    /**
    * Return true if portfolio is active
    *
    * @since Adonis 0.1
    */
    function adonis_is_testimonial_active( $control ) {
        $enable = $control->manager->get_setting( 'adonis_testimonial_option' )->value();

        //return true only if previwed page on customizer matches the type of content option selected
        return ( adonis_is_ect_testimonial_active ($control) && adonis_check_section( $enable ) );
    }
endif;

if ( ! function_exists( 'adonis_is_ect_testimonial_inactive' ) ) :
    /**
    *
    * @since Adonis 0.1
    */
    function adonis_is_ect_testimonial_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Jetpack_Testimonial' ) || class_exists( 'Essential_Content_Pro_Jetpack_Testimonial' ) );
    }
endif;

if ( ! function_exists( 'adonis_is_ect_testimonial_active' ) ) :
    /**
    *
    * @since Adonis 0.1
    */
    function adonis_is_ect_testimonial_active( $control ) {
        return ( class_exists( 'Essential_Content_Jetpack_Testimonial' ) || class_exists( 'Essential_Content_Pro_Jetpack_Testimonial' ) );
    }
endif;