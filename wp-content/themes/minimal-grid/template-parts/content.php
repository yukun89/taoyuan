<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Minimal_Grid
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if (is_single()) {
        $archive_div_class = "single-post";
    } else {
        $archive_div_class = "tm-archive-wrapper";
    } ?>
    <div class="<?php echo esc_attr($archive_div_class); ?>">
    <?php
    $image_option = minimal_grid_get_image_option();
    if (is_singular()) {
        if ( 'no-image' != $image_option ){
            if (has_post_thumbnail()) { ?>
                <div class="thememattic-featured-image post-thumb">
                    <?php echo (get_the_post_thumbnail(get_the_ID(), $image_option)); ?> 
                <?php $pic_caption = get_the_post_thumbnail_caption(); 
                if ($pic_caption) { ?>
                    <div class="img-copyright-info">
                        <p><?php echo esc_html($pic_caption); ?></p>
                    </div>
                <?php
                } ?>
                </div>
            <?php }
        }
        $raw_content = get_the_content();
        $final_content = apply_filters('the_content', $raw_content);

        /*Get first word of content*/
        $first_word = substr($raw_content, 0, 1);
        /*only allow alphabets*/
        if (preg_match("/[A-Za-z]+/", $first_word) != TRUE) {
            $first_word = '';
        }


        echo '<div class="entry-content" data-initials="' . esc_attr($first_word) . '">';
        /*Excerpt*/
        global $post;
        if (!empty($post->post_excerpt)) {
            echo '<div class="prime-excerpt">' . esc_html($post->post_excerpt) . '</div>';
        }
        /**/
        echo $final_content;
        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'minimal-grid'),
            'after' => '</div>',
        ));
        echo '</div>';
    } else {

        echo '<div class="entry-content">';
        if ( 'no-image' != $image_option ){
            if (has_post_thumbnail()) {
                echo '<div class="post-thumb">' . get_the_post_thumbnail(get_the_ID(), $image_option) . '<div class="grid-item-overlay">
                <a href="' . esc_url(get_permalink()) . '"><span></span></a></div></div>';
            }
        }
        if (!is_singular()): ?>
            <header class="entry-header">
                <?php if( true == minimal_grid_get_archive_meta_option() ){
                    minimal_grid_entry_category();
                } ?>
                <!-- posted coment -->
                <?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>'); ?>
            </header>
            <?php if( true == minimal_grid_get_archive_meta_option() ){
                minimal_grid_posted_date_only();
                minimal_grid_posted_comment();
            } ?>
        <?php endif;
        if( true == minimal_grid_get_archive_desc_option() ){
            the_excerpt();
        }
        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'minimal-grid'),
            'after' => '</div>',
        ));
        echo '</div>';
    }
    ?>
    <?php
    if (is_single()) { ?>
        <footer class="entry-footer">
            <div class="entry-meta">
                <?php minimal_grid_entry_footer(); ?>
            </div>
        </footer><!-- .entry-footer -->
    <?php } ?>
    </div>
</article>