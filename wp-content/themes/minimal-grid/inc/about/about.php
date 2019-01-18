<?php
/**
 * About setup
 *
 * @package Minimal_Grid
 */

if ( ! function_exists( 'minimal_grid_about_setup' ) ) :

	/**
	 * About setup.
	 *
	 * @since 1.0.0
	 */
	function minimal_grid_about_setup() {

		$config = array(

			// Welcome content.
			'welcome_content' => sprintf( esc_html__( '%1$s is now installed and ready to use. We want to make sure you have the best experience using the theme and that is why we gathered here all the necessary information for you. Thanks for using our theme!', 'minimal-grid' ), 'Minimal Grid Pro' ),

			// Tabs.
			'tabs' => array(
				'getting-started' => esc_html__( 'Getting Started', 'minimal-grid' ),
				'useful-plugins'  => esc_html__( 'Useful Plugins', 'minimal-grid' ),
				),

			// Quick links.
			'quick_links' => array(
                'theme_url' => array(
                    'text' => esc_html__( 'Theme Details', 'minimal-grid' ),
                    'url'  => 'https://thememattic.com/theme/minimal-grid',
                ),
                'demo_url' => array(
                    'text' => esc_html__( 'View Demo', 'minimal-grid' ),
                    'url'  => 'https://demo.thememattic.com/minimal-grid',
                ),
                'documentation_url' => array(
                    'text'   => esc_html__( 'View Documentation', 'minimal-grid' ),
                    'url'    => 'https://docs.thememattic.com/minimal-grid',
                    'button' => 'primary',
                ),
            ),

			// Getting started.
			'getting_started' => array(
				'one' => array(
					'title'       => esc_html__( 'Theme Documentation', 'minimal-grid' ),
					'icon'        => 'dashicons dashicons-format-aside',
					'description' => esc_html__( 'Please check our full documentation for detailed information on how to setup and customize the theme.', 'minimal-grid' ),
					'button_text' => esc_html__( 'View Documentation', 'minimal-grid' ),
					'button_url'  => 'https://thememattic.com/theme/minimal-grid',
					'button_type' => 'link',
					'is_new_tab'  => true,
					),
				'two' => array(
					'title'       => esc_html__( 'Static Front Page', 'minimal-grid' ),
					'icon'        => 'dashicons dashicons-admin-generic',
					'description' => esc_html__( 'To achieve custom home page other than blog listing, you need to create and set static front page.', 'minimal-grid' ),
					'button_text' => esc_html__( 'Static Front Page', 'minimal-grid' ),
					'button_url'  => admin_url( 'customize.php?autofocus[section]=static_front_page' ),
					'button_type' => 'primary',
					),
				'three' => array(
					'title'       => esc_html__( 'Theme Options', 'minimal-grid' ),
					'icon'        => 'dashicons dashicons-admin-customizer',
					'description' => esc_html__( 'Theme uses Customizer API for theme options. Using the Customizer you can easily customize different aspects of the theme.', 'minimal-grid' ),
					'button_text' => esc_html__( 'Customize', 'minimal-grid' ),
					'button_url'  => wp_customize_url(),
					'button_type' => 'primary',
					),
				'four' => array(
					'title'       => esc_html__( 'Demo Content', 'minimal-grid' ),
					'icon'        => 'dashicons dashicons-layout',
					'description' => sprintf( esc_html__( 'To import sample demo content, %1$s plugin should be installed and activated. After plugin is activated, visit Import Demo Data menu under Appearance.', 'minimal-grid' ), esc_html__( 'One Click Demo Import', 'minimal-grid' ) ),
					),
				'five' => array(
					'title'       => esc_html__( 'Theme Preview', 'minimal-grid' ),
					'icon'        => 'dashicons dashicons-welcome-view-site',
					'description' => esc_html__( 'You can check out the theme demos for reference to find out what you can achieve using the theme and how it can be customized.', 'minimal-grid' ),
					'button_text' => esc_html__( 'View Demo', 'minimal-grid' ),
					'button_url'  => 'https://demo.thememattic.com/minimal-grid',
					'button_type' => 'link',
					'is_new_tab'  => true,
					),
                'six' => array(
                    'title'       => esc_html__( 'Contact Support', 'minimal-grid' ),
                    'icon'        => 'dashicons dashicons-sos',
                    'description' => esc_html__( 'Got theme support question or found bug or got some feedbacks? Best place to ask your query is the dedicated Support forum for the theme.', 'minimal-grid' ),
                    'button_text' => esc_html__( 'Contact Support', 'minimal-grid' ),
                    'button_url'  => 'https://thememattic.com/support/',
                    'button_type' => 'link',
                    'is_new_tab'  => true,
                ),
				),

			// Useful plugins.
			'useful_plugins' => array(
				'description' => esc_html__( 'Theme supports some helpful WordPress plugins to enhance your site. But, please enable only those plugins which you need in your site. For example, enable WooCommerce only if you are using e-commerce.', 'minimal-grid' ),
				),

			);

		Minimal_Grid_About::init( $config );
	}

endif;

add_action( 'after_setup_theme', 'minimal_grid_about_setup' );
