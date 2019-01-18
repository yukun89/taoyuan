<?php
/**
 * Get customizer values.
 *
 * @package Minimal_Grid
 */

if ( ! function_exists( 'minimal_grid_get_option' ) ) :
    /**
     * Get customizer value by key.
     *
     * @since 1.0.0
     *
     * @param string $key Option key.
     * @return mixed Option value.
     */
    function minimal_grid_get_option($key, $defaults = false) {
        $customizer_values = get_theme_mod( 'theme_options' );
        $key_value = ( isset( $customizer_values[ $key ] ) ) ? $customizer_values[ $key ] : 'unset';
        /*Get the default value only if the value is not saved in database*/
        if( true == $defaults && 'unset' === $key_value ){
            $default_values = minimal_grid_get_default_customizer_values();
            $default_key_value = ( isset( $default_values[ $key ] ) ) ? $default_values[ $key ] : '';
            return $default_key_value;
        }
        /*Clear the value*/
        if( 'unset' === $key_value ){
            $key_value = '';
        }
        return $key_value;
    }
endif;

if ( ! function_exists( 'minimal_grid_get_options' ) ) :
    /**
     * Get all customizer values.
     *
     * @since 1.0.0
     *
     * @return array Customizer Values.
     */
    function minimal_grid_get_options() {
        $default_values = minimal_grid_get_default_customizer_values();
        $customizer_values = get_theme_mod( 'theme_options' );
        /*Create and empty array to merge if no options are saved yet*/
        if(empty($customizer_values)){
            $customizer_values = array();
        }
        /**/
        return array_merge( $default_values, $customizer_values );
    }
endif;

/*Set choices for google fonts*/
global $minimal_grid_google_fonts;
$minimal_grid_google_fonts = array(
    'ABeeZee:400,400italic' => 'ABeeZee',
    'Abel' => 'Abel',
    'Abril+Fatface' => 'Abril Fatface',
    'Aldrich' => 'Aldrich',
    'Alegreya:400,400italic,700,900' => 'Alegreya',
    'Alex+Brush' => 'Alex Brush',
    'Alfa+Slab+One' => 'Alfa Slab One',
    'Amaranth:400,400italic,700' => 'Amaranth',
    'Andada' => 'Andada',
    'Anton' => 'Anton',
    'Archivo+Black' => 'Archivo Black',
    'Archivo+Narrow:400,400italic,700' => 'Archivo Narrow',
    'Arimo:400,400italic,700' => 'Arimo',
    'Arvo:400,400italic,700' => 'Arvo',
    'Asap:400,400italic,700' => 'Asap',
    'Bangers' => 'Bangers',
    'BenchNine:400,700' => 'BenchNine',
    'Bevan' => 'Bevan',
    'Bitter:400,400italic,700' => 'Bitter',
    'Bree+Serif' => 'Bree Serif',
    'Cabin:400,400italic,500,600,700' => 'Cabin',
    'Cabin+Condensed:400,500,600,700' => 'Cabin Condensed',
    'Cantarell:400,400italic,700' => 'Cantarell',
    'Carme' => 'Carme',
    'Cherry+Cream+Soda' => 'Cherry Cream Soda',
    'Cinzel:400,700,900' => 'Cinzel',
    'Comfortaa:400,300,700' => 'Comfortaa',
    'Cookie' => 'Cookie',
    'Covered+By+Your+Grace' => 'Covered By Your Grace',
    'Crete+Round:400,400italic' => 'Crete Round',
    'Crimson+Text:400,400italic,600,700' => 'Crimson Text',
    'Cuprum:400,400italic' => 'Cuprum',
    'Dancing+Script:400,700' => 'Dancing Script',
    'Didact+Gothic' => 'Didact Gothic',
    'Droid+Sans:400,700' => 'Droid Sans',
    'Dosis:400,300,600,800' => 'Dosis',
    'Droid+Serif:400,400italic,700' => 'Droid Serif',
    'Economica:400,700,400italic' => 'Economica',
    'Expletus+Sans:400,400i,700,700i' => 'Expletus Sans',
    'EB+Garamond' => 'EB Garamond',
    'Exo:400,300,400italic,600,800' => 'Exo',
    'Exo+2:400,300,400italic,600,700,900' => 'Exo 2',
    'Fira+Sans:400,500' => 'Fira Sans',
    'Fjalla+One' => 'Fjalla One',
    'Francois+One' => 'Francois One',
    'Fredericka+the+Great' => 'Fredericka the Great',
    'Fredoka+One' => 'Fredoka One',
    'Fugaz+One' => 'Fugaz One',
    'Great+Vibes' => 'Great Vibes',
    'Handlee' => 'Handlee',
    'Hammersmith+One' => 'Hammersmith One',
    'Hind:400,300,600,700' => 'Hind',
    'Inconsolata:400,700' => 'Inconsolata',
    'Indie+Flower' => 'Indie Flower',
    'Istok+Web:400,400italic,700' => 'Istok Web',
    'Josefin+Sans:400,600,700,400italic' => 'Josefin Sans',
    'Josefin+Slab:400,400italic,700,600' => 'Josefin Slab',
    'Jura:400,300,500,600' => 'Jura',
    'Karla:400,400italic,700' => 'Karla',
    'Kaushan+Script' => 'Kaushan Script',
    'Kreon:400,300,700' => 'Kreon',
    'Lateef' => 'Lateef',
    'Lato:400,300,400italic,900,700' => 'Lato',
    'Libre+Baskerville:400,400italic,700' => 'Libre Baskerville',
    'Libre+Franklin:400,600' => 'Libre Franklin',
    'Limelight' => 'Limelight',
    'Lobster' => 'Lobster',
    'Lobster+Two:400,700,700italic' => 'Lobster Two',
    'Lora:400,400italic,700,700italic' => 'Lora',
    'Maven+Pro:400,500,700,900' => 'Maven Pro',
    'Merriweather:400,400italic,300,900,700' => 'Merriweather',
    'Merriweather+Sans:400,400italic,700,800' => 'Merriweather Sans',
    'Monda:400,700' => 'Monda',
    'Montserrat:400,700' => 'Montserrat',
    'Muli:400,300italic,300' => 'Muli',
    'News+Cycle:400,700' => 'News Cycle',
    'Noticia+Text:400,400italic,700' => 'Noticia Text',
    'Noto+Sans:400,400italic,700' => 'Noto Sans',
    'Noto+Serif:400,400italic,700' => 'Noto Serif',
    'Nunito:400,300,700' => 'Nunito',
    'Old+Standard+TT:400,400italic,700' => 'Old Standard TT',
    'Open+Sans:400,400italic,600,700' => 'Open Sans',
    'Open+Sans+Condensed:300,300italic,700' => 'Open Sans Condensed',
    'Oswald:400,300,700' => 'Oswald',
    'Oxygen:400,300,700' => 'Oxygen',
    'Pacifico' => 'Pacifico',
    'Passion+One:400,700,900' => 'Passion One',
    'Pathway+Gothic+One' => 'Pathway Gothic One',
    'Patua+One' => 'Patua One',
    'Poiret+One' => 'Poiret One',
    'Pontano+Sans' => 'Pontano Sans',
    'Poppins:400,400i,700,700i' => 'Poppins',
    'Play:400,700' => 'Play',
    'Playball' => 'Playball',
    'Playfair+Display:400,400i,700,700i' => 'Playfair Display',
    'PT+Sans:400,400italic,700' => 'PT Sans',
    'PT+Sans+Caption:400,700' => 'PT Sans Caption',
    'PT+Sans+Narrow:400,700' => 'PT Sans Narrow',
    'PT+Serif:400,400italic,700' => 'PT Serif',
    'Quattrocento+Sans:400,700,400italic' => 'Quattrocento Sans',
    'Questrial' => 'Questrial',
    'Quicksand:400,700' => 'Quicksand',
    'Raleway:400,300,500,600,700,900' => 'Raleway',
    'Righteous' => 'Righteous',
    'Roboto:300,300i,400,400i,500,700' => 'Roboto',
    'Roboto+Condensed:400,300,400italic,700' => 'Roboto Condensed',
    'Roboto+Slab:400,300,700' => 'Roboto Slab',
    'Rokkitt:400,700' => 'Rokkitt',
    'Ropa+Sans:400,400italic' => 'Ropa Sans',
    'Russo+One' => 'Russo One',
    'Sanchez:400,400italic' => 'Sanchez',
    'Satisfy' => 'Satisfy',
    'Shadows+Into+Light' => 'Shadows Into Light',
    'Sigmar+One' => 'Sigmar One',
    'Signika:400,300,700' => 'Signika',
    'Six+Caps' => 'Six Caps',
    'Slabo+27px' => 'Slabo 27px',
    'Source+Sans+Pro:300,400,400i,700,700i' => 'Source Sans Pro',
    'Source+Serif+Pro:400,700' => 'Source Serif Pro',
    'Squada+One' => 'Squada One',
    'Tangerine:400,700' => 'Tangerine',
    'Tinos:400,400italic,700' => 'Tinos',
    'Titillium+Web:400,300,400italic,700,900' => 'Titillium Web',
    'Ubuntu:400,400italic,500,700' => 'Ubuntu',
    'Ubuntu+Condensed' => 'Ubuntu Condensed',
    'Varela+Round' => 'Varela Round',
    'Vollkorn:400,400italic,700' => 'Vollkorn',
    'Voltaire' => 'Voltaire',
    'Yanone+Kaffeesatz:400,300,700' => 'Yanone Kaffeesatz',
);
