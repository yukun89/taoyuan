<?php

/* Theme Widget sidebars. */
require get_template_directory() . '/inc/widgets/widget-sidebars.php';

/* Theme Widgets*/
require get_template_directory() . '/inc/widgets/tab-posts.php';
require get_template_directory() . '/inc/widgets/author-info.php';
require get_template_directory() . '/inc/widgets/social-menu.php';

/* Register site widgets */
if ( ! function_exists( 'minimal_grid_widgets' ) ) :
    /**
     * Load widgets.
     *
     * @since 1.0
     */
    function minimal_grid_widgets() {
        register_widget( 'Minimal_Grid_Tab_Posts' );
        register_widget( 'Minimal_Grid_Social_Menu' );
        //register_widget( 'Minimal_Grid_Video_Slider' );
        register_widget( 'Minimal_Grid_Author_Info' );
    }
endif;
add_action( 'widgets_init', 'minimal_grid_widgets' );

/* Outputs necessary javascript template to be used in widgets */
if ( ! function_exists( 'minimal_grid_print_widgets_template' ) ) :
    /**
     * Prints Javascript template.
     *
     * @since 1.0
     */
    function minimal_grid_print_widgets_template() {
        ?>
        <!--For Youtube Video Slider Widget -->
        <script type="text/html" id="tmpl-me-youtube-urls">
            <div class="field-group">
                <input class="me-widefat" type="text" name="{{data.name}}" value="" />
                <span class="me-remove-youtube-url">
                    <span class="dashicons dashicons-no-alt"></span>
                </span>
            </div>
        </script>
        <?php
    }
endif;
//add_action( 'admin_footer-widgets.php', 'minimal_grid_print_widgets_template');