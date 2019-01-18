<?php
/**
 * The template for displaying featured content
 *
 * @package Personal_Trainer
 */
?>

<?php
$enable = get_theme_mod( 'adonis_contact_option', 'disabled' );

if ( ! adonis_check_section( $enable ) ) {
	// Bail if featured content is disabled.
	return;
}

$title       = get_theme_mod( 'adonis_contact_title', esc_html__( 'Contact', 'adonis' ) );
$description = get_theme_mod( 'adonis_contact_description', wp_kses_data( __( 'For further details about my services, availability and inquiry, please fell free to contact me with the information below', 'adonis' ) ) );
?>

<div id="contact-section" class="section">
	<div class="wrapper">
		<?php if ( $title || $description ) : ?>
		<div class="section-heading-wrapper contact-section-headline">
			<?php if (  $title ) : ?>
				<div class="section-title-wrapper">
					<h2 class="section-title"><?php echo wp_kses_data( $title ); ?></h2>
				</div><!-- .section-title-wrapper -->
			<?php endif; ?>

			<?php if ( $description ) : ?>
				<div class="taxonomy-description-wrapper">
					<p class="section-description"><?php echo wp_kses_post( $description ); ?></p>
				</div><!-- .taxonomy-description-wrapper -->	
			<?php endif; ?>
		</div><!-- .section-heading-wrapper -->
		<?php endif; ?>

		<div class="section-content-wrapper contact-content-wrapper">
			<article class="post hentry">
				<div class="entry-container">
					<?php
						$content = '';

							$post_object = get_post( get_theme_mod( 'adonis_contact_page' ) );

							$content = $post_object->post_content;
					?>

					<div class="entry-content">
						<?php if ( $content ) : ?>
						<div class="contact-form-login">
							<?php  echo do_shortcode( $content ); ?>
						</div>
						<?php endif; ?>

						<?php
							$phone_title = get_theme_mod( 'adonis_contact_phone_title', esc_html__( 'Phone', 'adonis' ) );
							$phone       = get_theme_mod( 'adonis_contact_phone', '123-456-7890' );

							$email_title = get_theme_mod( 'adonis_contact_email_title', esc_html__( 'Email', 'adonis' ) );
							$email       = get_theme_mod( 'adonis_contact_email', 'someone@somewhere.com' );

							$address_title = get_theme_mod( 'adonis_contact_address_title', esc_html__( 'Address', 'adonis' ) );
							$address       = get_theme_mod( 'adonis_contact_address', '1842 Skinner Hollow Road, Marshalls Creek, Oklahoma' );

							if ( $phone_title || $phone || $email_title || $email || $address_title || $address ) :
						?>
						<div class="contact-details">
							<?php if ( $phone_title || $phone ) : ?>
							<div class="contact-item">
								<?php echo ' <div class="contact-icon svg-phone" aria-label="Icon Phone">' . adonis_get_svg( array( 'icon' => 'phone' ) ) . '</div>' ?>
								<p><?php
									echo $phone_title ? esc_html( $phone_title ) . '<br>' : '';
									echo '<a target="_blank" rel="nofollow" title="'. esc_attr( $phone_title ) . '" href="tel:' . preg_replace( '/\s+/', '', esc_attr( $phone ) ) . '">' . esc_attr( $phone ) . '</a>';
									?></p>
							</div><!-- #contact-item -->
							<?php endif; ?>

							<?php if ( $email_title || $email ) : ?>
							<div class="contact-item">
								<?php echo ' <div class="contact-icon svg-envelope" aria-label="Icon Envelope">' . adonis_get_svg( array( 'icon' => 'envelope' ) ) . '</div>' ?>
								<p><?php
									echo $email_title ? esc_html( $email_title ) . '<br>' : '';
									echo '<a target="_blank" rel="nofollow" title="'. esc_attr( $email_title ) . '" href="mailto:'. esc_attr( antispambot( $email ) ) .'">' . esc_html( antispambot( $email ) ) . '</a>';
									?></p>
							</div><!-- #contact-item -->
							<?php endif; ?>

							<?php if ( $address_title || $address ) : ?>
							<div class="contact-item">
								<?php echo ' <div class="contact-icon svg-map-marker" aria-label="Icon Marker">' . adonis_get_svg( array( 'icon' => 'map-marker' ) ) . '</div>' ?>
								<p><?php
									echo $address_title ? esc_html( $address_title ) . '<br>' : '';
									echo wp_kses_post( $address );
								?></p>
							</div><!-- #contact-item -->
							<?php endif; ?>
						</div><!-- .contact-details -->
						<?php endif; ?>
					</div><!-- .entry-content -->
				</div><!-- .entry-container -->
			</article> <!-- article -->
		</div><!-- .section-content-wrap -->
	</div><!-- .wrapper -->
</div> <!-- #contact-section -->