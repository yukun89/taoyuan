<?php
/**
 * Implement posts metabox.
 *
 * @package Minimal Grid
 */

if ( ! function_exists( 'minimal_grid_add_theme_meta_box' ) ) :

	/**
	 * Add the Meta Box
	 *
	 * @since 1.0.0
	 */
	function minimal_grid_add_theme_meta_box() {

		$post_types = array( 'post', 'page' );

		foreach ( $post_types as $post_type ) {
			add_meta_box(
				'minimal-grid-custom-box',
                sprintf( esc_html__( '%1s Settings', 'minimal-grid' ), ucwords($post_type) ),
				'minimal_grid_custom_box_html',
                $post_type
			);
		}

	}

endif;
add_action( 'add_meta_boxes', 'minimal_grid_add_theme_meta_box' );

if ( ! function_exists( 'minimal_grid_custom_box_html' ) ) :

	/**
	 * Render theme settings meta box.
	 *
	 * @since 1.0.0
	 */
	function minimal_grid_custom_box_html( $post ) {

        wp_nonce_field( basename( __FILE__ ), 'minimal_grid_meta_box_nonce' );

        /*Get image sizes*/
        $image_sizes = minimal_grid_get_all_image_sizes(true);

        $page_layout = get_post_meta($post->ID,'minimal_grid_page_layout',true);
        $image_settings = get_post_meta($post->ID,'minimal_grid_single_image',true);
        ?>
        <div id="minimal-grid-settings-metabox-container" class='inside'>
            <h3><label for="page-layout"><?php echo __( 'Page Layout', 'minimal-grid' ); ?></label></h3>
            <p>
                <select name="minimal_grid_page_layout" id="page-layout">
                    <option value=""><?php _e( '&mdash; Select &mdash;', 'minimal-grid' )?></option>
                    <option value="left-sidebar" <?php selected('left-sidebar',$page_layout);?>>
                        <?php _e( 'Primary Sidebar - Content', 'minimal-grid' )?>
                    </option>
                    <option value="right-sidebar" <?php selected('right-sidebar',$page_layout);?>>
                        <?php _e( 'Content - Primary Sidebar', 'minimal-grid' )?>
                    </option>
                    <option value="no-sidebar" <?php selected('no-sidebar',$page_layout);?>>
                        <?php _e( 'No Sidebar', 'minimal-grid' )?>
                    </option>
                </select>
            </p>
            <hr/>
            <h3><label for="image-settings"><?php echo __( 'Featured Image on Detail Page', 'minimal-grid' ); ?></label></h3>
            <p>
                <select name="minimal_grid_single_image" id="image-settings">
                    <option value=""><?php _e( '&mdash; Select &mdash;', 'minimal-grid' )?></option>
                    <?php
                    if(!empty($image_sizes)){
                        foreach ($image_sizes as $key => $val){
                            ?>
                            <option value="<?php echo esc_attr($key);?>" <?php selected($key, $image_settings);?>>
                                <?php echo esc_html($val); ?>
                            </option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </p>
            <hr/>
        </div>
        <?php
	}

endif;


if ( ! function_exists( 'minimal_grid_save_postdata' ) ) :

	/**
	 * Save posts meta box value.
	 *
	 * @since 1.0.0
	 *
	 * @param int  $post_id Post ID.
	 */
	function minimal_grid_save_postdata( $post_id ) {

		// Verify nonce.
		if ( ! isset( $_POST['minimal_grid_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['minimal_grid_meta_box_nonce'], basename( __FILE__ ) ) ) {
			  return; }

		// Bail if auto save or revision.
		if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post_id ) ) || is_int( wp_is_post_autosave( $post_id ) ) ) {
			return;
		}

		// Check the post being saved == the $post_id to prevent triggering this call for other save_post events.
		if ( empty( $_POST['post_ID'] ) || $_POST['post_ID'] != $post_id ) {
			return;
		}

        /*Get image sizes*/
        $image_sizes = minimal_grid_get_all_image_sizes(true);

		// Check permission.
		if ( 'page' === $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return; }
		} else if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

        if ( isset( $_POST['minimal_grid_page_layout'] )){
            $valid_layout_values = array(
                'left-sidebar',
                'right-sidebar',
                'no-sidebar',
            );
            $layout_value = sanitize_text_field( $_POST['minimal_grid_page_layout'] );
            if( in_array( $layout_value, $valid_layout_values ) ) {
                update_post_meta($post_id, 'minimal_grid_page_layout', $layout_value);
            }else{
                delete_post_meta($post_id,'minimal_grid_page_layout');
            }
        }

        if ( isset( $_POST['minimal_grid_single_image'] )){

            $image_value = sanitize_text_field( $_POST['minimal_grid_single_image'] );
            if( array_key_exists( $image_value, $image_sizes ) ) {
                update_post_meta($post_id, 'minimal_grid_single_image', $image_value);
            }else{
                delete_post_meta($post_id,'minimal_grid_single_image');
            }
        }
	}

endif;
add_action( 'save_post', 'minimal_grid_save_postdata' );