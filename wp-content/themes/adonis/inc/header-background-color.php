<?php
/**
 * Customizer functionality
 *
 * @package Adonis
 */

/**
 * Sets up the WordPress core custom header and custom background features.
 *
 * @since Adonis 0.1
 *
 * @see adonis_header_style()
 */
function adonis_custom_header_and_background() {
	/**
	 * Filter the arguments used when adding 'custom-background' support in Persona.
	 *
	 * @since Adonis 0.1
	 *
	 * @param array $args {
	 *     An array of custom-background support arguments.
	 *
	 *     @type string $default-color Default color of the background.
	 * }
	 */
	add_theme_support( 'custom-background', apply_filters( 'adonis_custom_background_args', array(
		'default-color' => '#f2f2f2',
	) ) );

	/**
	 * Filter the arguments used when adding 'custom-header' support in Persona.
	 *
	 * @since Adonis 0.1
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type string $default-text-color Default color of the header text.
	 *     @type int      $width            Width in pixels of the custom header image. Default 1200.
	 *     @type int      $height           Height in pixels of the custom header image. Default 280.
	 *     @type bool     $flex-height      Whether to allow flexible-height header images. Default true.
	 *     @type callable $wp-head-callback Callback function used to style the header image and text
	 *                                      displayed on the blog.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'adonis_custom_header_args', array(
		'default-image'      	 => get_parent_theme_file_uri( '/assets/images/header-image.jpg' ),
		'default-text-color'     => '#ffffff',
		'width'                  => 1920,
		'height'                 => 954,
		'flex-height'            => true,
		'flex-height'            => true,
		'wp-head-callback'       => 'adonis_header_style',
		'video'                  => true,
	) ) );

	register_default_headers( array(
		'default-image' => array(
			'url'           => '%s/assets/images/header-image.jpg',
			'thumbnail_url' => '%s/assets/images/header-image-275x155.jpg',
			'description'   => esc_html__( 'Default Header Image', 'adonis' ),
		),
		'second-image' => array(
			'url'           => '%s/assets/images/header-image-1.jpg',
			'thumbnail_url' => '%s/assets/images/header-image-1-275x155.jpg',
			'description'   => esc_html__( 'Another Header Image', 'adonis' ),
		),
	) );
}
add_action( 'after_setup_theme', 'adonis_custom_header_and_background' );

if ( ! function_exists( 'adonis_header_style' ) ) :
	/**
	 * Styles the header text displayed on the site.
	 *
	 * Create your own adonis_header_style() function to override in a child theme.
	 *
	 * @since Adonis 0.1
	 *
	 * @see adonis_custom_header_and_background().
	 */
	function adonis_header_style() {
		$header_image = adonis_featured_overall_image();

		if ( $header_image ) : ?>
		<style type="text/css" rel="header-image">
			.custom-header:before {
				background-image: url( <?php echo esc_url( $header_image ); ?>);
				background-position: center top;
				background-repeat: no-repeat;
				background-size: cover;
			}
		</style>
		<?php
		endif;

		$enable = get_theme_mod( 'adonis_header_text', 'homepage' );

		$header_text_color = get_header_textcolor();

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
			// Has the text been hidden?
			if ( ! adonis_check_section( $enable ) ) :
		?>
			.site-branding-text {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
			// If the user has set a custom color for the text use that.
			else :
		?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;

/**
 * Customize video play/pause button in the custom header.
 *
 * @param array $settings header video settings.
 */
function adonis_video_controls( $settings ) {
	$settings['l10n']['play'] = '<span class="screen-reader-text">' . esc_html__( 'Play background video', 'adonis' ) . '</span>' . adonis_get_svg( array(
		'icon' => 'play',
	) );
	$settings['l10n']['pause'] = '<span class="screen-reader-text">' . esc_html__( 'Pause background video', 'adonis' ) . '</span>' . adonis_get_svg( array(
		'icon' => 'pause',
	) );
	return $settings;
}
add_filter( 'header_video_settings', 'adonis_video_controls' );
