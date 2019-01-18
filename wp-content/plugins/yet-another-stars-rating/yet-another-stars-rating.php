<?php

/**
 * Plugin Name: Yet Another Stars Rating
 * Plugin URI: http://wordpress.org/plugins/yet-another-stars-rating/
 * Description: Yasr - Yet Another Stars Rating is a powerful way to add SEO-friendly user-generated reviews and testimonials to your website posts, pages and CPT, without affecting its speed.
 * Version: 1.8.5
 * Author: Dario Curvino
 * Author URI: https://yetanotherstarsrating.com/
 * Text Domain: yet-another-stars-rating
 * Domain Path: languages
 * License: GPL2
 *
 * @fs_premium_only /yasr_pro/
 *
 */
/*

Copyright 2015 Dario Curvino (email : d.curvino@tiscali.it)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>
*/
if ( !defined( 'ABSPATH' ) ) {
    exit( 'You\'re not allowed to see this page' );
}
// Exit if accessed directly
//Auto disable yasr free when yasr pro is activated

if ( !function_exists( 'yasr_fs' ) ) {
    // Create a helper function for easy SDK access.
    function yasr_fs()
    {
        global  $yasr_fs ;
        
        if ( !isset( $yasr_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            try {
                $yasr_fs = fs_dynamic_init( array(
                    'id'             => '256',
                    'slug'           => 'yet-another-stars-rating',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_907af437fd2bd1f123a3b228785a1',
                    'is_premium'     => false,
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'trial'          => array(
                    'days'               => 14,
                    'is_require_payment' => false,
                ),
                    'menu'           => array(
                    'slug'    => 'yasr_settings_page',
                    'contact' => false,
                    'support' => false,
                ),
                    'is_live'        => true,
                ) );
            } catch ( Freemius_Exception $e ) {
            }
        }
        
        return $yasr_fs;
    }
    
    // Init Freemius.
    yasr_fs();
    // Signal that SDK was initiated.
    do_action( 'yasr_fs_loaded' );
    define( 'YASR_VERSION_NUM', '1.8.5' );
    //Plugin relative path
    define( "YASR_ABSOLUTE_PATH", dirname( __FILE__ ) );
    //Plugin RELATIVE PATH without slashes (just the directory's name)
    define( "YASR_RELATIVE_PATH", dirname( plugin_basename( __FILE__ ) ) );
    //Plugin language directory: here I've to use relative path
    //because load_plugin_textdomain wants relative and not absolute path
    define( "YASR_LANG_DIR", YASR_RELATIVE_PATH . '/languages/' );
    //Js directory absolute
    define( "YASR_JS_DIR", plugins_url() . '/' . YASR_RELATIVE_PATH . '/js/' );
    //CSS directory absolute
    define( "YASR_CSS_DIR", plugins_url() . '/' . YASR_RELATIVE_PATH . '/css/' );
    //IMG directory absolute
    define( "YASR_IMG_DIR", plugins_url() . '/' . YASR_RELATIVE_PATH . '/img/' );
    /****** Getting options ******/
    //Get general options
    $yasr_stored_options = get_option( 'yasr_general_options' );
    global  $yasr_stored_options ;
    define( "YASR_AUTO_INSERT_ENABLED", $yasr_stored_options['auto_insert_enabled'] );
    
    if ( YASR_AUTO_INSERT_ENABLED == 1 ) {
        define( "YASR_AUTO_INSERT_WHAT", $yasr_stored_options['auto_insert_what'] );
        define( "YASR_AUTO_INSERT_WHERE", $yasr_stored_options['auto_insert_where'] );
        define( "YASR_AUTO_INSERT_SIZE", $yasr_stored_options['auto_insert_size'] );
        define( "YASR_AUTO_INSERT_EXCLUDE_PAGES", $yasr_stored_options['auto_insert_exclude_pages'] );
        define( "YASR_AUTO_INSERT_CUSTOM_POST_ONLY", $yasr_stored_options['auto_insert_custom_post_only'] );
    } else {
        define( "YASR_AUTO_INSERT_WHAT", null );
        define( "YASR_AUTO_INSERT_WHERE", null );
        define( "YASR_AUTO_INSERT_SIZE", null );
        define( "YASR_AUTO_INSERT_EXCLUDE_PAGES", null );
        define( "YASR_AUTO_INSERT_CUSTOM_POST_ONLY", null );
    }
    
    define( "YASR_SHOW_OVERALL_IN_LOOP", $yasr_stored_options['show_overall_in_loop'] );
    define( "YASR_SHOW_VISITOR_VOTES_IN_LOOP", $yasr_stored_options['show_visitor_votes_in_loop'] );
    define( "YASR_TEXT_BEFORE_STARS", $yasr_stored_options['text_before_stars'] );
    
    if ( YASR_TEXT_BEFORE_STARS == 1 ) {
        define( "YASR_TEXT_BEFORE_OVERALL", $yasr_stored_options['text_before_overall'] );
        define( "YASR_TEXT_BEFORE_VISITOR_RATING", $yasr_stored_options['text_before_visitor_rating'] );
        define( "YASR_TEXT_AFTER_VISITOR_RATING", $yasr_stored_options['text_after_visitor_rating'] );
        define( "YASR_CUSTOM_TEXT_USER_VOTED", $yasr_stored_options['custom_text_user_voted'] );
    }
    
    define( "YASR_VISITORS_STATS", $yasr_stored_options['visitors_stats'] );
    define( "YASR_ALLOWED_USER", $yasr_stored_options['allowed_user'] );
    define( "YASR_ENABLE_IP", $yasr_stored_options['enable_ip'] );
    define( "YASR_SNIPPET", $yasr_stored_options['snippet'] );
    define( "YASR_ITEMTYPE", $yasr_stored_options['snippet_itemtype'] );
    
    if ( isset( $yasr_stored_options['blogposting_organization_name'] ) ) {
        define( "YASR_BLOGPOSTING_ORGANIZATION_NAME", $yasr_stored_options['blogposting_organization_name'] );
    } else {
        define( "YASR_BLOGPOSTING_ORGANIZATION_NAME", '' );
    }
    
    if ( isset( $yasr_stored_options['blogposting_organization_logo'] ) ) {
        if ( filter_var( $yasr_stored_options['blogposting_organization_logo'], FILTER_VALIDATE_URL ) !== false ) {
            define( "YASR_BLOGPOSTING_ORGANIZATION_LOGO", $yasr_stored_options['blogposting_organization_logo'] );
        }
    }
    define( "YASR_METABOX_OVERALL_RATING", $yasr_stored_options['metabox_overall_rating'] );
    //Get stored style options
    $style_options = get_option( 'yasr_style_options' );
    global  $style_options ;
    
    if ( $style_options ) {
        
        if ( isset( $style_options['textarea'] ) ) {
            define( "YASR_CUSTOM_CSS_RULES", $style_options['textarea'] );
        } else {
            define( "YASR_CUSTOM_CSS_RULES", null );
        }
        
        
        if ( isset( $style_options['scheme_color_multiset'] ) ) {
            define( "YASR_SCHEME_COLOR", $style_options['scheme_color_multiset'] );
        } else {
            define( "YASR_SCHEME_COLOR", null );
        }
        
        
        if ( isset( $style_options['stars_set_free'] ) ) {
            define( "YASR_STARS_SET", $style_options['stars_set_free'] );
        } else {
            define( "YASR_STARS_SET", null );
        }
    
    } else {
        define( "YASR_CUSTOM_CSS_RULES", null );
        define( "YASR_SCHEME_COLOR", null );
        define( "YASR_STARS_SET", null );
    }
    
    //Multi set options
    $multi_set_options = get_option( 'yasr_multiset_options' );
    if ( $multi_set_options ) {
        
        if ( isset( $multi_set_options['show_average'] ) ) {
            define( "YASR_MULTI_SHOW_AVERAGE", $multi_set_options['show_average'] );
        } else {
            define( "YASR_MULTI_SHOW_AVERAGE", 'yes' );
        }
    
    }
    /****** End Getting options ******/
    // Include function file
    require YASR_ABSOLUTE_PATH . '/lib/yasr-functions.php';
    require YASR_ABSOLUTE_PATH . '/lib/yasr-db-functions.php';
    require YASR_ABSOLUTE_PATH . '/lib/yasr-ajax-functions.php';
    require YASR_ABSOLUTE_PATH . '/lib/yasr-shortcode-functions.php';
    require YASR_ABSOLUTE_PATH . '/lib/yasr-widgets.php';
    
    if ( is_admin() ) {
        require YASR_ABSOLUTE_PATH . '/lib/yasr-admin-actions.php';
        require YASR_ABSOLUTE_PATH . '/lib/settings/yasr-settings-functions.php';
        require YASR_ABSOLUTE_PATH . '/lib/class-wp-list-table.php';
    }
    
    global  $wpdb ;
    define( "YASR_VOTES_TABLE", $wpdb->prefix . 'yasr_votes' );
    //Used in background
    define( "YASR_MULTI_SET_NAME_TABLE", $wpdb->prefix . 'yasr_multi_set' );
    define( "YASR_MULTI_SET_FIELDS_TABLE", $wpdb->prefix . 'yasr_multi_set_fields' );
    define( "YASR_MULTI_SET_VALUES_TABLE", $wpdb->prefix . 'yasr_multi_values' );
    define( "YASR_LOG_TABLE", $wpdb->prefix . 'yasr_log' );
    define( "YASR_LOADER_IMAGE", YASR_IMG_DIR . "/loader.gif" );
    $yasr_version_installed = get_option( 'yasr-version' );
    global  $yasr_version_installed ;
    //Run this only on plugin activation (doesn't work on update)
    register_activation_hook( __FILE__, 'yasr_on_activation' );
    function yasr_on_activation()
    {
        global  $yasr_version_installed ;
        //If this is a fresh new installation
        if ( !$yasr_version_installed ) {
            yasr_install();
        }
    }
    
    /****** backward compatibility functions ******/
    add_action( 'plugins_loaded', 'yasr_update_version' );
    function yasr_update_version()
    {
        //do only in admin
        
        if ( is_admin() ) {
            global  $wpdb ;
            global  $yasr_version_installed ;
            global  $yasr_stored_options ;
            if ( $yasr_version_installed && $yasr_version_installed < '1.7.3' ) {
                $wpdb->query( "ALTER TABLE " . YASR_MULTI_SET_FIELDS_TABLE . " CHANGE field_name field_name varchar(40) \n\t\t\t\tCOLLATE 'utf8_unicode_ci' NOT NULL AFTER parent_set_id;" );
            }
            
            if ( $yasr_version_installed && $yasr_version_installed < '1.6.5' ) {
                $yasr_stored_options['disable_jquery'] = 'no';
                update_option( 'yasr_general_options', $yasr_stored_options );
            }
            
            
            if ( $yasr_version_installed && $yasr_version_installed < '1.6.1' ) {
                $yasr_stored_options['enable_ip'] = 'no';
                update_option( 'yasr_general_options', $yasr_stored_options );
            }
            
            /****** End backward compatibility functions ******/
            if ( $yasr_version_installed != YASR_VERSION_NUM ) {
                update_option( 'yasr-version', YASR_VERSION_NUM );
            }
        }
    
    }
    
    //this add a link under the plugin name, must be in the main plugin file
    add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'yasr_add_links_below_plugin_name' );
    function yasr_add_links_below_plugin_name( $links )
    {
        $settings_link = '<a href="' . admin_url( 'options-general.php?page=yasr_settings_page' ) . '">General Settings</a>';
        //array_unshit adds to the begin of array
        array_unshift( $links, $settings_link );
        return $links;
    }
    
    //this add a link under the plugin description
    add_filter(
        'plugin_row_meta',
        'yasr_plugin_row_meta',
        10,
        5
    );
    function yasr_plugin_row_meta( $links, $file )
    {
        $plugin = plugin_basename( __FILE__ );
        //Show buy yasr pro only if this is free plan
        
        if ( yasr_fs()->is_free_plan() ) {
            // create link
            if ( $file == $plugin ) {
                $links[] = '<a href="https://yetanotherstarsrating.com/">' . __( 'Buy Yasr Pro', 'yet-another-stars-rating' ) . '</a>';
            }
        } else {
            // create link
            if ( $file == $plugin ) {
                $links[] = __( 'Thank you for using Yasr Pro', 'yet-another-stars-rating' );
            }
        }
        
        return $links;
    }
    
    //End function
    //this is for user who use extensions
    //remove on Gen 2019
    define( 'YASR_EDD_SL_STORE_URL', 'http://yetanotherstarsrating.com' );
}
