<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Minimal_Grid
 */
?>
    <!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <?php wp_head(); ?>
    </head>
<body <?php body_class('extended-menu'); ?>>

<?php
$enable_preloader = minimal_grid_get_option('enable_preloader', true);
$style = 'style="display:none"';
if ($enable_preloader) {
    $style = '';
}
?>
    <div class="preloader" <?php echo $style; ?>>
        <div class="loader-wrapper">
            <div id="loader"></div>
        </div>
    </div>


    <aside id="thememattic-aside" class="aside-panel">
        <div class="menu-mobile">
            <div class="trigger-nav">
                <div class="trigger-icon nav-toogle menu-mobile-toogle">
                    <a class="trigger-icon" href="#">
                        <span class="icon-bar top"></span>
                        <span class="icon-bar middle"></span>
                        <span class="icon-bar bottom"></span>
                    </a>
                </div>
            </div>
            <div class="trigger-nav-right">
                <ul class="nav-right-options">
                    <li>
                        <span class="icon-search">
                            <i class="thememattic-icon ion-ios-search"></i>
                        </span>
                    </li>
                    <li>
                        <a class="site-logo site-logo-mobile" href="<?php echo esc_url(get_home_url()); ?>">
                            <i class="thememattic-icon ion-ios-home-outline"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="aside-menu">
            <div class="nav-panel">
                <div class="trigger-nav">
                    <div class="trigger-icon trigger-icon-wraper nav-toogle nav-panel-toogle">
                        <a class="trigger-icon" href="#">
                            <span class="icon-bar top"></span>
                            <span class="icon-bar middle"></span>
                            <span class="icon-bar bottom"></span>
                        </a>
                    </div>
                </div>
                <div class="asidepanel-icon">
                    <div class="asidepanel-icon__item">
                        <div class="contact-icons">
                            <a class="" href="<?php echo esc_url(get_home_url()); ?>">
                                <i class="thememattic-icon ion-ios-home-outline"></i>
                            </a>
                        </div>
                    </div>
                    <div class="asidepanel-icon__item">
                        <div class="contact-icons">
                        <span class="icon-search">
                            <i class="thememattic-icon ion-ios-search"></i>
                        </span>
                        </div>
                    </div>
                    <div class="asidepanel-icon__item">
                        <div class="contact-icons">
                            <?php $email_address_sidebar = minimal_grid_get_option('email_address_sidebar', true);?>
                            <a href="mailto:<?php echo esc_attr($email_address_sidebar); ?>" target="_blank">
                            <span class="thememattic-icon ion-ios-email-outline"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="menu-panel">
                <div class="menu-panel-wrapper">
                    <div class="site-branding">
                        <?php
                        the_custom_logo();
                        if (is_front_page() && is_home()) : ?>
                            <h1 class="site-title">
                                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
                            </h1>
                        <?php else : ?>
                            <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                                     rel="home"><?php bloginfo('name'); ?></a></p>
                        <?php
                        endif;

                        $description = get_bloginfo('description', 'display');
                        if ($description || is_customize_preview()) : ?>
                            <p class="site-description secondary-font">
                                <?php echo $description; ?>
                            </p>
                        <?php
                        endif;
                        ?>
                    </div>
                    <div class="thememattic-navigation">
                        <nav id="site-navigation" class="main-navigation">
                            <span class="toggle-menu" aria-controls="primary-menu" aria-expanded="false">
                                 <span class="screen-reader-text">
                                    <?php esc_html_e('Primary Menu', 'minimal-grid'); ?>
                                </span>
                                <i class="ham"></i>
                            </span>
                            <?php
                            if (has_nav_menu('menu-1')) {
                                wp_nav_menu(array(
                                    'theme_location' => 'menu-1',
                                    'menu_id' => 'primary-menu',
                                    'container' => 'div',
                                    'container_class' => 'menu-wrapper',
                                    'depth' => 3,
                                ));
                            } else {
                                wp_nav_menu(array(
                                    'menu_id' => 'primary-menu',
                                    'container' => 'div',
                                    'container_class' => 'menu-wrapper',
                                    'depth' => 3,
                                ));
                            } ?>
                        </nav><!-- #site-navigation -->
                        <?php if (has_nav_menu('social-nav')) { ?>
                            <div class="header-social-icon hidden-xs">
                                <div class="social-icons">
                                    <?php
                                    wp_nav_menu(
                                        array('theme_location' => 'social-nav',
                                            'link_before' => '<span>',
                                            'link_after' => '</span>',
                                            'menu_id' => 'social-menu',
                                            'fallback_cb' => false,
                                            'menu_class' => false
                                        )); ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <?php $enable_header_images = minimal_grid_get_option('enable_header_overlay', false);
                if ($enable_header_images == false) {
                } else { ?>
                    <div class="header-image-overlay"></div>
                <?php }
                ?>
            </div>
        </div>
    </aside>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'minimal-grid'); ?></a>
    <div class="popup-search">
        <div class="table-align">
            <div class="table-align-cell">
                <?php get_search_form(); ?>
            </div>
        </div>
        <div class="close-popup"></div>
    </div>


    <div id="content" class="site-content">
        <?php
        if ( !is_front_page()) {
             /**
             * Hook - minimal_grid_inner_header.
             *
             * @hooked minimal_grid_display_inner_header -  10
             */
            do_action('minimal_grid_inner_header');
        } ?>

        <div class="content-inner-wrapper">