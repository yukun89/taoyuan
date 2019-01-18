<?php
/**
 * Displays primary navigation
 *
 * @package Adonis
 */

?>
<div id="site-header-menu" class="site-header-menu">
	<div id="primary-menu-wrapper" class="menu-wrapper">
		<div class="menu-toggle-wrapper">
			<button id="primary-menu-toggle"  class="menu-toggle" aria-controls="top-menu" aria-expanded="false"><?php echo adonis_get_svg( array( 'icon' => 'bars' ) ); echo adonis_get_svg( array( 'icon' => 'close' ) ); ?><span class="menu-label"><?php echo esc_html_e( 'Menu', 'adonis' ); ?></span></button>
		</div><!-- .menu-toggle-wrapper -->

		<div class="menu-inside-wrapper">
			<?php if ( has_nav_menu( 'menu-1' ) ) : ?>
				<nav id="site-navigation" class="main-navigation custom-primary-menu" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'adonis' ); ?>">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'menu-1',
							'menu_class'     => 'primary-menu',
						 ) );
					?>
				</nav><!-- .main-navigation -->
			<?php else : ?>
				<nav id="site-navigation" class="main-navigation default-page-menu" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'adonis' ); ?>">
					<?php wp_page_menu(
						array(
							'menu_class' => 'primary-menu-container',
							'before'     => '<ul id="menu-primary-items" class="primary-menu">',
							'after'      => '</ul>'
						)
					); ?>
				</nav><!-- .main-navigation -->
			<?php endif; ?>

			<div class="mobile-social-search">
				<div class="search-container">
					<?php get_search_form(); ?>
				</div>

				<?php get_template_part('template-parts/navigation/navigation', 'social'); ?>
			</div><!-- .mobile-social-search -->
		</div><!-- .menu-inside-wrapper -->
	</div><!-- .menu-wrapper -->

	<div id="social-search-wrapper" class="menu-wrapper">
		<?php get_template_part('template-parts/navigation/navigation', 'social'); ?>
		<div class="menu-toggle-wrapper">
			<button id="social-search-toggle" class="menu-toggle"><?php echo adonis_get_svg( array( 'icon' => 'search' ) ); echo adonis_get_svg( array( 'icon' => 'close' ) ); ?><span class="screen-reader-text"><?php esc_html_e( 'Search', 'adonis' ); ?></span></button>
		</div><!-- .menu-toggle-wrapper -->

		<div class="menu-inside-wrapper">
			<div class="search-container">
				<?php get_search_form(); ?>
			</div>

			<?php get_template_part('template-parts/navigation/navigation', 'social'); ?>
		</div><!-- .menu-inside-wrapper -->
	</div><!-- .menu-wrapper -->
</div><!-- .site-header-menu -->
