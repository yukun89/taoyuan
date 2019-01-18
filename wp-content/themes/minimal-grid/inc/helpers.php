<?php
/* Display Breadcrumbs */
if ( ! function_exists( 'minimal_grid_get_breadcrumb' ) ) :

    /**
     * Simple breadcrumb.
     *
     * @since 1.0.0
     */
    function minimal_grid_get_breadcrumb() {

        if ( ! function_exists( 'breadcrumb_trail' ) ) {

            require_once get_template_directory() . '/assets/lib/breadcrumbs/breadcrumbs.php';
        }

        $breadcrumb_args = array(
            'container'   => 'div',
            'show_browse' => false,
        );
        breadcrumb_trail( $breadcrumb_args );

    }

endif;

/* Change default excerpt length */
if ( ! function_exists( 'minimal_grid_excerpt_length' ) ) :

    /**
     * Change excerpt Length.
     *
     * @since 1.0.0
     */
    function minimal_grid_excerpt_length($excerpt_length) {
        $excerpt_length = minimal_grid_get_option('excerpt_length',true);
        return absint($excerpt_length);
    }

endif;
add_filter( 'excerpt_length', 'minimal_grid_excerpt_length', 999 );

/* Get Page layout */
if ( ! function_exists( 'minimal_grid_get_page_layout' ) ) :

    /**
     * Get Page Layout based on the post meta or customizer value
     *
     * @since 1.0.0
     *
     * @return string Page Layout.
     */
    function minimal_grid_get_page_layout() {
        global $post;

        $page_layout = minimal_grid_get_option('home_page_layout',true);

        /*Fetch for homepage*/
        if( is_front_page() && is_home()){
            return $page_layout;
        }elseif ( is_front_page() ) {
            return $page_layout;
        }elseif ( is_home() ) {
            $page_layout_meta = get_post_meta( get_option( 'page_for_posts' ), 'minimal_grid_page_layout', true );
            if(!empty($page_layout_meta)){
                return $page_layout_meta;
            }else{
                return $page_layout;
            }
        } elseif (is_archive()) {
            /*Fetch from customizer*/
                $page_layout = minimal_grid_get_option('global_layout',true);
        }elseif (is_search()) {
            /*Fetch from customizer*/
                $page_layout = minimal_grid_get_option('global_layout',true);
        }
        /**/

        /*Fetch from Post Meta*/
        if ( $post && is_singular() ) {
            $page_layout = get_post_meta( $post->ID, 'minimal_grid_page_layout', true );
        }
        return $page_layout;
    }

endif;

/* Get Image Option */
if ( ! function_exists( 'minimal_grid_get_image_option' ) ) :

    /**
     * Get Image Option on the post meta or customizer value
     *
     * @since 1.0.0
     *
     * @return string Image Option.
     */
    function minimal_grid_get_image_option() {
        global $post;

        if ( $post && is_singular() ) {
            /*Fetch from Post Meta*/
            $image_option = get_post_meta( $post->ID, 'minimal_grid_single_image', true );
            /*Fetch from customizer*/
            if( empty($image_option) ){
                if( is_single() ){
                    $image_option = minimal_grid_get_option('single_post_image',true);
                }
                if( is_page() ){
                    $image_option = minimal_grid_get_option('single_page_image',true);
                }
            }
        }else{
            /*Fetch from customizer for archive*/
            $image_option = minimal_grid_get_option('archive_image',true);
        }

        return $image_option;
    }

endif;

/* Get Archive Description Option */
if ( ! function_exists( 'minimal_grid_get_archive_desc_option' ) ) :

    /**
     * Get Archive pages description option
     *
     * @since 1.0.0
     *
     * @return boolean Enabled/Disabled
     */
    function minimal_grid_get_archive_desc_option() {
        return minimal_grid_get_option('show_desc_archive_pages', true);
    }

endif;

/* Get Archive Meta Info Option */
if ( ! function_exists( 'minimal_grid_get_archive_meta_option' ) ) :

    /**
     * Get Archive pages meta info option
     *
     * @since 1.0.0
     *
     * @return boolean Enabled/Disabled
     */
    function minimal_grid_get_archive_meta_option() {
        return minimal_grid_get_option('show_meta_archive_pages', true);
    }

endif;

/* Quote Content */
if ( ! function_exists( 'minimal_grid_quote_content' ) ) :
    /**
     * Check for <blockquote> elements
     *
     * @since 1.0.0
     *
     * @return string Content
     */
    function minimal_grid_quote_content( $content ) {

        /* Check if we're displaying a 'quote' post. */
        if ( has_post_format( 'quote' ) ) {

            /* Match any <blockquote> elements. */
            preg_match( '/<blockquote.*?>/', $content, $matches );

            /* If no <blockquote> elements were found, wrap the entire content in one. */
            if ( empty( $matches ) )
                $content = "<blockquote>{$content}</blockquote>";
        }

        return $content;
    }
endif;
add_filter( 'the_content', 'minimal_grid_quote_content' );


if ( ! function_exists( 'minimal_grid_get_all_image_sizes' ) ) :
    /**
     * Returns all image sizes available.
     *
     * @since 1.0.0
     *
     * @param bool $for_choice True/False to construct the output as key and value choice
     * @return array Image Size Array.
     */
    function minimal_grid_get_all_image_sizes( $for_choice = false ) {

        global $_wp_additional_image_sizes;

        $sizes = array();

        if( true == $for_choice ){
            $sizes['no-image'] = __( 'No Image', 'minimal-grid' );
        }

        foreach ( get_intermediate_image_sizes() as $_size ) {
            if ( in_array( $_size, array('thumbnail', 'medium', 'large') ) ) {

                $width = get_option( "{$_size}_size_w" );
                $height = get_option( "{$_size}_size_h" );

                if( true == $for_choice ){
                    $sizes[$_size] = ucfirst($_size) . ' (' . $width . 'x' . $height . ')';
                }else{
                    $sizes[ $_size ]['width']  = $width;
                    $sizes[ $_size ]['height'] = $height;
                    $sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
                }
            } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

                $width = $_wp_additional_image_sizes[ $_size ]['width'];
                $height = $_wp_additional_image_sizes[ $_size ]['height'];

                if( true == $for_choice ){
                    $sizes[$_size] = ucfirst($_size) . ' (' . $width . 'x' . $height . ')';
                }else{
                    $sizes[ $_size ] = array(
                        'width'  => $width,
                        'height' => $height,
                        'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
                    );
                }
            }
        }

        if( true == $for_choice ){
            $sizes['full'] = __( 'Full Image', 'minimal-grid' );
        }

        return $sizes;
    }
endif;