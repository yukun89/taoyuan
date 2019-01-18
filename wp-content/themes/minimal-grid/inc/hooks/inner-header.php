<?php
if (!function_exists('minimal_grid_display_inner_header')) :
    /**
     * Inner Pages Header.
     *
     * @since 1.0.0
     */
    function minimal_grid_display_inner_header()
    {
        if(is_singular()){
            ?>
            <header class="inner-banner">

                            <div class="primary-font thememattic-breadcrumb">
                                <?php
                                /**
                                 * Hook - minimal_grid_display_breadcrumb.
                                 *
                                 * @hooked minimal_grid_breadcrumb_content - 10
                                 */
                                do_action('minimal_grid_display_breadcrumb');
                                ?>
                            </div>


                            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                            <?php if (!is_page()) { ?>
                                <div class="entry-header">
                                    <div class="entry-meta">
                                        <?php minimal_grid_posted_on(); ?>
                                    </div>
                                </div>
                            <?php } ?>

            </header>
            <?php
            }else{
            ?>
            <header class="inner-banner">

                            <div class="thememattic-breadcrumb">
                                <?php
                                /**
                                 * Hook - minimal_grid_display_breadcrumb.
                                 *
                                 * @hooked minimal_grid_breadcrumb_content - 10
                                 */
                                do_action('minimal_grid_display_breadcrumb');
                                ?>
                            </div>

                            <?php if (is_404()) { ?>
                                <h1 class="entry-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'minimal-grid'); ?></h1>
                            <?php } elseif (is_archive()) {
                                the_archive_title('<h1 class="entry-title">', '</h1>');
                                the_archive_description('<div class="taxonomy-description">', '</div>');
                            } elseif (is_search()) { ?>
                                <h1 class="entry-title"><?php printf(esc_html__('Search Results for: %s', 'minimal-grid'), '<span>' . get_search_query() . '</span>'); ?></h1>
                            <?php } else { ?>
                                <h1 class="entry-title"></h1>
                            <?php }
                            ?>

            </header>
            <?php
        }
    }
endif;
add_action('minimal_grid_inner_header', 'minimal_grid_display_inner_header');