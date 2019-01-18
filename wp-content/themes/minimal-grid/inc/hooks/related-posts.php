<?php
if (!function_exists('minimal_grid_related_posts')) :
    /**
     * Related Posts
     *
     * @since 1.0.0
     */
    function minimal_grid_related_posts()
    {
        if(is_singular()){
            $show_related_posts = minimal_grid_get_option('show_related_posts',true);
            if($show_related_posts){
                $related_posts_title = minimal_grid_get_option('related_posts_title',true);
                $category_ids = array();
                $categories = get_the_category(get_the_ID());
                if (!empty($categories)) {
                    foreach ($categories as $category) {
                        $category_ids[] = $category->term_id;
                    }
                }
                if(!empty($category_ids)){
                    $args = array(
                        'posts_per_page' => 3,
                        'category__in' => $category_ids,
                        'post__not_in' => array(get_the_ID()),
                        'order' => 'ASC',
                        'orderby' => 'rand'
                    );
                    $related_posts = new WP_Query($args);
                    if($related_posts->have_posts()):?>
                        <section id="related-articles" class="page-section">
                            <?php if(!empty($related_posts_title)){
                                ?>
                                <header class="related-header">
                                    <h3 class="related-title">
                                        <?php echo esc_html($related_posts_title); ?>
                                    </h3>
                                </header>
                                <?php
                            }?>
                            <div class="entry-content">
                                <div class="row">
                                    <?php while ($related_posts->have_posts()):$related_posts->the_post();?>
                                        <div class="col-sm-4">
                                            <div class="related-articles-wrapper">
                                                <?php if(has_post_thumbnail()){ ?>
                                                    <div class="primary-background border-overlay">
                                                        <a href="<?php the_permalink(); ?>" class="bg-image bg-image-1">
                                                            <?php the_post_thumbnail(get_the_ID(), 'medium'); ?>
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                                <div class="related-article-title">
                                                    <h4 class="primary-font">
                                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                    </h4>
                                                </div><!-- .related-article-title -->
                                            </div>
                                        </div>
                                    <?php endwhile;wp_reset_postdata();?>
                                </div>
                            </div><!-- .entry-content-->
                        </section>
                    <?php endif;
                }
            }
        }
    }
endif;
add_action('minimal_grid_before_single_nav', 'minimal_grid_related_posts', 10 );