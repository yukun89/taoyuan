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
    	<div class="entry-content">
    		<?php
            $image_option = minimal_grid_get_image_option();
            if(is_singular()){
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
                the_content( sprintf(
                    wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                        __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'minimal-grid' ),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    get_the_title()
                ) );
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'minimal-grid' ),
                    'after'  => '</div>',
                ) );
            }else{
                if ( 'no-image' != $image_option ) {
                    if (has_post_thumbnail()) {
                        $image_url = get_the_post_thumbnail_url(get_the_ID(), $image_option);
                        ?>
                        <div class="post-thumb bg-image bg-quote" style="background-image: url(&quot;<?php echo esc_url($image_url);?>&quot;);">
                            <?php the_post_thumbnail(get_the_ID(), $image_option); ?>
                        </div>
                        <?php
                    }else{
                        echo '<div class="post-thumb bg-quote"></div>';
                    }
                }else{
                    echo '<div class="post-thumb bg-quote"></div>';
                }
                the_content( sprintf(
                    wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                        __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'minimal-grid' ),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    get_the_title()
                ) );
                echo '<h2 class="entry-title quote-entry-title">'.esc_html(get_the_title()).'</h2>';
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'minimal-grid' ),
                    'after'  => '</div>',
                ) );
            }
    		?>
    	</div><!-- .entry-content -->
    </div>
</article>