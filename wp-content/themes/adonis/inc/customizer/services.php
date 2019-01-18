<?php
/**
 * Services options
 *
 * @package Adonis
 */

/**
 * Add Services options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function adonis_service_options( $wp_customize ) {
	adonis_register_option( $wp_customize, array(
            'name'              => 'adonis_service_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Adonis_Note_Control',
            'label'             => sprintf( esc_html__( 'For all Services Options for this Theme, go %1$shere%2$s', 'adonis' ),
                '<a href="javascript:wp.customize.section( \'adonis_services\' ).focus();">',
                 '</a>'
            ),
           'section'            => 'services',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    $wp_customize->add_section( 'adonis_services', array(
			'title' => esc_html__( 'Services', 'adonis' ),
			'panel' => 'adonis_theme_options',
		)
	);

    adonis_register_option( $wp_customize, array(
            'name'              => 'adonis_service_note_1',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Adonis_Note_Control',
            'active_callback'   => 'adonis_is_ect_service_inactive',
            'label'             => sprintf( esc_html__( 'For Services, install %1$sEssential Content Types%2$s Plugin with Services Content Type Enabled', 'adonis' ),
                '<a target="_blank" href="https://wordpress.org/plugins/essential-content-types/">',
                '</a>'
            ),
            'section'           => 'adonis_services',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

	// Add color scheme setting and control.
	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_service_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'adonis_sanitize_select',
			'active_callback'   => 'adonis_is_ect_service_active',
			'choices'           => adonis_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'adonis' ),
			'section'           => 'adonis_services',
			'type'              => 'select',
		)
	);



	//$type['ect-service'] = esc_html__( 'Custom Post Type', 'adonis' );

	adonis_register_option( $wp_customize, array(
            'name'              => 'adonis_services_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Adonis_Note_Control',
            'active_callback'   => 'adonis_is_services_active',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
			'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'adonis' ),
                 '<a href="javascript:wp.customize.control( \'ect_service_title\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'adonis_services',
            'type'              => 'description',
        )
    );

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_service_number',
			'default'           => 6,
			'sanitize_callback' => 'adonis_sanitize_number_range',
			'active_callback'   => 'adonis_is_services_active',
			'description'       => esc_html__( 'Save and refresh the page if No. of Items is changed', 'adonis' ),
			'input_attrs'       => array(
				'style' => 'width: 100px;',
				'min'   => 0,
			),
			'label'             => esc_html__( 'No of Items', 'adonis' ),
			'section'           => 'adonis_services',
			'type'              => 'number',
			'transport'         => 'postMessage',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_service_show',
			'default'           => 'excerpt',
			'sanitize_callback' => 'adonis_sanitize_select',
			'active_callback'   => 'adonis_is_services_active',
			'choices'           => adonis_content_show(),
			'label'             => esc_html__( 'Display Content', 'adonis' ),
			'section'           => 'adonis_services',
			'type'              => 'select',
		)
	);


	$number = get_theme_mod( 'adonis_service_number', 6 );


	for ( $i = 1; $i <= $number ; $i++ ) {

		adonis_register_option( $wp_customize, array(
				'name'              => 'adonis_service_cpt_' . $i,
				'sanitize_callback' => 'adonis_sanitize_post',
				'active_callback'   => 'adonis_is_services_active',
				'label'             => esc_html__( 'Services', 'adonis' ) . ' ' . $i ,
				'section'           => 'adonis_services',
				'type'              => 'select',
                'choices'           => adonis_generate_post_array( 'ect-service' ),
			)
		);
	} // End for().
}
add_action( 'customize_register', 'adonis_service_options', 10 );

/** Active Callback Functions **/
if ( ! function_exists( 'adonis_is_services_active' ) ) :
	/**
	* Return true if featured content is active
	*
	* @since Adonis 0.1
	*/
	function adonis_is_services_active( $control ) {
		$enable = $control->manager->get_setting( 'adonis_service_option' )->value();

		return ( adonis_is_ect_service_active( $control ) &&  adonis_check_section( $enable ) );
	}
endif;

if ( ! function_exists( 'adonis_is_ect_service_inactive' ) ) :
    /**
    * Return true if service is active
    *
    * @since Adonis 0.1
    */
    function adonis_is_ect_service_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Service' ) || class_exists( 'Essential_Content_Pro_Service' ) );
    }
endif;

if ( ! function_exists( 'adonis_is_ect_service_active' ) ) :
    /**
    * Return true if service is active
    *
    * @since Adonis 0.1
    */
    function adonis_is_ect_service_active( $control ) {
        return ( class_exists( 'Essential_Content_Service' ) || class_exists( 'Essential_Content_Pro_Service' ) );
    }
endif;
