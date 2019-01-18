<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Adonis
 */

?>
			</div><!-- .wrapper -->
		</div><!-- #content -->

		<?php  get_template_part( 'template-parts/contact-info/display', 'contact-info' ) ?>

		<?php get_template_part( 'template-parts/footer/widget', 'instagram' ); ?>

		<footer id="colophon" class="site-footer">
			<?php get_template_part( 'template-parts/footer/footer', 'widgets' ); ?>

			<div id="site-generator">
				<div class="wrapper">
					<div class="site-social">
						<?php get_template_part('template-parts/navigation/navigation', 'social'); ?>
					</div><!-- .site-social -->

					<?php get_template_part('template-parts/footer/site', 'info'); ?>
				</div><!-- .wrapper -->
			</div><!-- #site-generator -->
		</footer><!-- #colophon -->
	 </div><!-- .below-site-header -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
