<?php

if (!function_exists('minimal_grid_home_full_grid_cat')) :
    /**
     * Homepage Full width grid.
     *
     * @since 1.0.0
     */
    function minimal_grid_home_full_grid_cat()
    {
        $enable_footer_recommend_cat = minimal_grid_get_option('enable_footer_recommend_cat', true);
        if ($enable_footer_recommend_cat):

            $full_width_grid_cat = minimal_grid_get_option('full_width_grid_cat', true);
            if (!empty($full_width_grid_cat)):

                $no_of_full_width_cat_posts = minimal_grid_get_option('no_of_full_width_cat_posts', true);
                $enable_full_grid_meta_info = minimal_grid_get_option('enable_full_grid_meta_info', true);

                $post_args = array(
                    'post_type' => 'post',
                    'posts_per_page' => $no_of_full_width_cat_posts,
                    'post_status' => 'publish',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field' => 'term_id',
                            'terms' => $full_width_grid_cat,
                        ),
                    ),
                );
                $posts = new WP_Query($post_args);
                if ($posts->have_posts()):
                    ?>
                    <section class="section-block section-bg section-recommended">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="section-head">
                                        <h2 class="section-title">
                                            <a href="<?php echo esc_url(get_category_link($full_width_grid_cat)); ?>">
                                                <?php echo esc_html(minimal_grid_get_option('footer_recommend_cat_title')); ?>
                                            </a>
                                        </h2>
                                    </div>
                                </div>
                                <div class="home-full-grid-cat-section">
                                    <?php
                                    while ($posts->have_posts()): $posts->the_post();
                                        if (has_post_thumbnail()):
                                            ?>
                                            <article class="col-md-3 col-sm-6">
                                                <div class="entry-content">
                                                    <div class="post-thumb">
                                                        <a href="<?php the_permalink(); ?>">
                                                            <?php the_post_thumbnail('minimal-grid-medium-img') ?>
                                                        </a>
                                                    </div>
                                                    <div class="post-detail">
                                                        <h2 class="entry-title entry-title-1">
                                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                        </h2>
                                                        <?php if($enable_full_grid_meta_info):?>
                                                            <div class="featured-meta">
                                                                <span class="entry-date">
                                                                    <?php echo esc_html(get_the_date()); ?>
                                                                </span>
                                                                <span><?php _e('/', 'minimal-grid')?></span>
                                                                <span class="post-author">
                                                                    <a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) )); ?>">
                                                                        <?php the_author(); ?>
                                                                    </a>
                                                                </span>
                                                            </div>
                                                        <?php endif;?>
                                                    </div>
                                                </div>
                                            </article>
                                            <?php
                                        endif;
                                    endwhile;
                                    wp_reset_postdata();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </section>
                    <?php
                endif;
            endif;
        endif;
    }
endif;
add_action('minimal_grid_home_footer_section', 'minimal_grid_home_full_grid_cat', 10);