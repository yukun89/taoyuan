<?php
/**
 * Featured Content options
 *
 * @package Adonis
 */

/**
 * Add featured content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function adonis_featured_content_options( $wp_customize ) {
	// Add note to ECT Featured Content Section
    adonis_register_option( $wp_customize, array(
            'name'              => 'adonis_featured_content_jetpack_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Adonis_Note_Control',
            'active_callback'   => 'adonis_is_ect_featured_content_inactive',
            /* translators: 1: <a>/link tag start, 2: </a>/link tag close. */
           'label'             => sprintf( esc_html__( 'For Featured Content, install %1$sEssential Content Types%2$s Plugin with Featured Content Type Enabled', 'adonis' ),
                '<a target="_blank" href="https://wordpress.org/plugins/essential-content-types/">',
                '</a>'
            ),
           'section'            => 'adonis_featured_content',
            'type'              => 'description',
            'priority'          => 1,
        )
    );

    $wp_customize->add_section( 'adonis_featured_content', array(
			'title' => esc_html__( 'Featured Content', 'adonis' ),
			'panel' => 'adonis_theme_options',
		)
	);

	// Add color scheme setting and control.
	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_featured_content_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'adonis_sanitize_select',
			'active_callback'   => 'adonis_is_ect_featured_content_active',
			'choices'           => adonis_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'adonis' ),
			'section'           => 'adonis_featured_content',
			'type'              => 'select',
		)
	);

	 adonis_register_option( $wp_customize, array(
            'name'              => 'adonis_featured_content_cpt_note',
            'sanitize_callback' => 'sanitize_text_field',
            'custom_control'    => 'Adonis_Note_Control',
            'active_callback'   => 'adonis_is_featured_content_active',
            'label'             => sprintf( esc_html__( 'For CPT heading and sub-heading, go %1$shere%2$s', 'adonis' ),
                 '<a href="javascript:wp.customize.control( \'featured_content_title\' ).focus();">',
                 '</a>'
            ),
            'section'           => 'adonis_featured_content',
            'type'              => 'description',
        )
    );

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_featured_content_number',
			'default'           => 6,
			'sanitize_callback' => 'adonis_sanitize_number_range',
			'active_callback'   => 'adonis_is_featured_content_active',
			'description'       => esc_html__( 'Save and refresh the page if No of items is changed', 'adonis' ),
			'input_attrs'       => array(
				'style' => 'width: 100px;',
				'min'   => 0,
			),
			'label'             => esc_html__( 'No of Items', 'adonis' ),
			'section'           => 'adonis_featured_content',
			'type'              => 'number',
			'transport'         => 'postMessage',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_featured_content_show',
			'default'           => 'excerpt',
			'sanitize_callback' => 'adonis_sanitize_select',
			'active_callback'   => 'adonis_is_featured_content_active',
			'choices'           => adonis_content_show(),
			'label'             => esc_html__( 'Display Content', 'adonis' ),
			'section'           => 'adonis_featured_content',
			'type'              => 'select',
		)
	);

	$number = get_theme_mod( 'adonis_featured_content_number', 6 );

	//loop for featured post content
	for ( $i = 1; $i <= $number ; $i++ ) {

		adonis_register_option( $wp_customize, array(
				'name'              => 'adonis_featured_content_cpt_' . $i,
				'sanitize_callback' => 'adonis_sanitize_post',
				'active_callback'   => 'adonis_is_featured_content_active',
				'label'             => esc_html__( 'Featured Content', 'adonis' ) . ' ' . $i ,
				'section'           => 'adonis_featured_content',
				'type'              => 'select',
                'choices'           => adonis_generate_post_array( 'featured-content' ),
			)
		);
	} // End for().

	adonis_register_option( $wp_customize, array(
            'name'              => 'adonis_featured_content_text',
            'default'           => esc_html__( 'View More', 'adonis' ),
            'sanitize_callback' => 'sanitize_text_field',
            'active_callback'   => 'adonis_is_featured_content_active',
            'label'             => esc_html__( 'Button Text', 'adonis' ),
            'section'           => 'adonis_featured_content',
            'type'              => 'text',
        )
    );

    adonis_register_option( $wp_customize, array(
            'name'              => 'adonis_featured_content_link',
            'sanitize_callback' => 'esc_url_raw',
            'active_callback'   => 'adonis_is_featured_content_active',
            'label'             => esc_html__( 'Button Link', 'adonis' ),
            'section'           => 'adonis_featured_content',
        )
    );

    adonis_register_option( $wp_customize, array(
            'name'              => 'adonis_featured_content_target',
            'sanitize_callback' => 'adonis_sanitize_checkbox',
            'active_callback'   => 'adonis_is_featured_content_active',
            'label'             => esc_html__( 'Check to Open Link in New Window/Tab', 'adonis' ),
            'section'           => 'adonis_featured_content',
            'type'              => 'checkbox',
        )
    );
}
add_action( 'customize_register', 'adonis_featured_content_options', 10 );

/** Active Callback Functions **/
if ( ! function_exists( 'adonis_is_featured_content_active' ) ) :
	/**
	* Return true if featured content is active
	*
	* @since Adonis 0.1
	*/
	function adonis_is_featured_content_active( $control ) {
		$enable = $control->manager->get_setting( 'adonis_featured_content_option' )->value();

		//return true only if previewed page on customizer matches the type of content option selected
		return ( adonis_check_section( $enable ) );
	}
endif;


if ( ! function_exists( 'adonis_is_ect_featured_content_inactive' ) ) :
    /**
    * Return true if featured_content is active
    *
    * @since Adonis 0.1
    */
    function adonis_is_ect_featured_content_inactive( $control ) {
        return ! ( class_exists( 'Essential_Content_Featured_Content' ) || class_exists( 'Essential_Content_Pro_Featured_Content' ) );
    }
endif;
if ( ! function_exists( 'adonis_is_ect_featured_content_active' ) ) :
    /**
    * Return true if featured_content is active
    *
    * @since Adonis 0.1
    */
    function adonis_is_ect_featured_content_active( $control ) {
        return ( class_exists( 'Essential_Content_Featured_Content' ) || class_exists( 'Essential_Content_Pro_Featured_Content' ) );
    }
endif;
