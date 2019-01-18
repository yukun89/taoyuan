<?php
/**
 * Hero Content Options
 *
 * @package Adonis
 */

/**
 * Add hero content options to theme options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function adonis_hero_content_options( $wp_customize ) {
	$wp_customize->add_section( 'adonis_hero_content_options', array(
			'title' => esc_html__( 'Hero Content', 'adonis' ),
			'panel' => 'adonis_theme_options',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_hero_content_visibility',
			'default'           => 'disabled',
			'sanitize_callback' => 'adonis_sanitize_select',
			'choices'           => adonis_section_visibility_options(),
			'label'             => esc_html__( 'Enable on', 'adonis' ),
			'section'           => 'adonis_hero_content_options',
			'type'              => 'select',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_hero_content',
			'default'           => '0',
			'sanitize_callback' => 'adonis_sanitize_post',
			'active_callback'   => 'adonis_is_hero_content_active',
			'label'             => esc_html__( 'Page', 'adonis' ),
			'section'           => 'adonis_hero_content_options',
			'type'              => 'dropdown-pages',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_disable_hero_content_title',
			'sanitize_callback' => 'adonis_sanitize_checkbox',
			'active_callback'   => 'adonis_is_hero_content_active',
			'label'             => esc_html__( 'Check to disable title', 'adonis' ),
			'section'           => 'adonis_hero_content_options',
			'type'              => 'checkbox',
		)
	);

	adonis_register_option( $wp_customize, array(
			'name'              => 'adonis_hero_content_show',
			'default'           => 'excerpt',
			'sanitize_callback' => 'adonis_sanitize_select',
			'active_callback'   => 'adonis_is_hero_content_active',
			'choices'           => adonis_content_show(),
			'label'             => esc_html__( 'Display Content', 'adonis' ),
			'section'           => 'adonis_hero_content_options',
			'type'              => 'select',
		)
	);
}
add_action( 'customize_register', 'adonis_hero_content_options' );

/** Active Callback Functions **/
if ( ! function_exists( 'adonis_is_hero_content_active' ) ) :
	/**
	* Return true if hero content is active
	*
	* @since Adonis 0.1
	*/
	function adonis_is_hero_content_active( $control ) {
		$enable = $control->manager->get_setting( 'adonis_hero_content_visibility' )->value();

		return ( adonis_check_section( $enable ) );
	}
endif;