<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Minimal_Grid
 */

get_header();

global $post;
$wrapper_start = $wrapper_end = '';
if (is_front_page()):
    if( $post->post_content != '') {
        $wrapper_start = '<section class="section-block section-static-enable"><div class="container">';
        $wrapper_end   = '</div></section>';
    }
endif;

?>
<?php echo $wrapper_start; ?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php
        while (have_posts()) : the_post();

            get_template_part('template-parts/content', 'page');

            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;

        endwhile; // End of the loop.
        ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
$page_layout = minimal_grid_get_page_layout();
if ('no-sidebar' != $page_layout) {
    get_sidebar();
}

echo $wrapper_end;
get_footer();
