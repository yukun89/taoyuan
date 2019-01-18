<?php
/**
 * Contact Info options
 *
 * @package Adonis
 */

/**
 * Add contact options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function adonis_contact_options( $wp_customize ) {
    $wp_customize->add_section( 'adonis_contact', array(
			'title' => esc_html__( 'Contact Info', 'adonis' ),
			'panel' => 'adonis_theme_options',
		)
	);

	// Add color scheme setting and control.
	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_contact_option',
			'default'           => 'disabled',
			'sanitize_callback' => 'adonis_sanitize_select',
			'choices'           => adonis_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'adonis' ),
			'section'           => 'adonis_contact',
			'type'              => 'select',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_contact_title',
			'default'           => esc_html__( 'Contact', 'adonis' ),
			'sanitize_callback' => 'wp_kses_data',
			'active_callback'   => 'adonis_is_contact_active',
			'label'             => esc_html__( 'Title', 'adonis' ),
			'section'           => 'adonis_contact',
			'type'              => 'text',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_contact_description',
			'default'           => wp_kses_data( __( 'For further details about my services, availability and inquiry, please fell free to contact me with the information below', 'adonis' ) ),
			'sanitize_callback' => 'wp_kses_data',
			'active_callback'   => 'adonis_is_contact_active',
			'label'             => esc_html__( 'Description', 'adonis' ),
			'section'           => 'adonis_contact',
			'type'              => 'textarea',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_contact_phone_title',
			'default'           => esc_html__( 'Phone', 'adonis' ),
			'sanitize_callback' => 'sanitize_text_field',
			'active_callback'   => 'adonis_is_contact_active',
			'label'             => esc_html__( 'Phone Title', 'adonis' ),
			'section'           => 'adonis_contact',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_contact_phone',
			'default'           => '123-456-7890',
			'sanitize_callback' => 'sanitize_text_field',
			'active_callback'   => 'adonis_is_contact_active',
			'label'             => esc_html__( 'Phone', 'adonis' ),
			'section'           => 'adonis_contact',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_contact_email_title',
			'default'           => esc_html__( 'Email', 'adonis' ),
			'sanitize_callback' => 'sanitize_text_field',
			'active_callback'   => 'adonis_is_contact_active',
			'label'             => esc_html__( 'Email Title', 'adonis' ),
			'section'           => 'adonis_contact',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_contact_email',
			'default'           => 'someone@somewhere.com',
			'sanitize_callback' => 'sanitize_email',
			'active_callback'   => 'adonis_is_contact_active',
			'label'             => esc_html__( 'Email', 'adonis' ),
			'section'           => 'adonis_contact',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_contact_address_title',
			'default'           => esc_html__( 'Address', 'adonis' ),
			'sanitize_callback' => 'sanitize_text_field',
			'active_callback'   => 'adonis_is_contact_active',
			'label'             => esc_html__( 'Address Title', 'adonis' ),
			'section'           => 'adonis_contact',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_contact_address',
			'default'           => '1842 Skinner Hollow Road, Marshalls Creek, Oklahoma',
			'sanitize_callback' => 'wp_kses_post',
			'active_callback'   => 'adonis_is_contact_active',
			'label'             => esc_html__( 'Address', 'adonis' ),
			'section'           => 'adonis_contact',
			'type'              => 'textarea',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_contact_page',
			'sanitize_callback' => 'adonis_sanitize_post',
			'active_callback'   => 'adonis_is_contact_active',
			'label'             => esc_html__( 'Page', 'adonis' ),
			'section'           => 'adonis_contact',
			'type'              => 'dropdown-pages',
		)
	);
}
add_action( 'customize_register', 'adonis_contact_options', 10 );

/** Active Callback Functions **/
if ( ! function_exists( 'adonis_is_contact_active' ) ) :
	/**
	* Return true if contact is active
	*
	* @since Adonis 0.1
	*/
	function adonis_is_contact_active( $control ) {
		$enable = $control->manager->get_setting( 'adonis_contact_option' )->value();

		//return true only if previewed page on customizer matches the type of content option selected
		return ( adonis_check_section( $enable ) );
	}
endif;
