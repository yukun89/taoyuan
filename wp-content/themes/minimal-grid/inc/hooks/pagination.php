<?php 

if ( ! function_exists( 'minimal_grid_display_posts_navigation' ) ) :

	/**
	 * Display Pagination.
	 *
	 * @since 1.0.0
	 */
	function minimal_grid_display_posts_navigation() {

        $pagination_type = minimal_grid_get_option( 'pagination_type', true );
        switch ( $pagination_type ) {

            case 'default':
                the_posts_navigation();
                break;

            case 'numeric':
                the_posts_pagination();
                break;

            case 'infinite_scroll_load':
                minimal_grid_ajax_pagination('scroll');
                break;

            case 'button_click_load':
                minimal_grid_ajax_pagination('click');
                break;

            default:
                break;
        }
		return;
	}

endif;

add_action( 'minimal_grid_posts_navigation', 'minimal_grid_display_posts_navigation' );
