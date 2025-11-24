<?php
/**
 * Matizdreamlab Child Theme – Core Functions
 *
 * Handles:
 * - Parent + child theme styles
 * - Loading custom CPT & taxonomies
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue Parent + Child CSS
 */
add_action( 'wp_enqueue_scripts', 'matizdreamlab_enqueue_parent_child_styles' );
function matizdreamlab_enqueue_parent_child_styles() {

    // Parent theme stylesheet
    wp_enqueue_style(
        'avada-parent-style',
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme( 'Avada' )->get( 'Version' )
    );

    // Child theme stylesheet (use matizdreamlab-style handle)
    wp_enqueue_style(
        'matizdreamlab-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'avada-parent-style' ),
        wp_get_theme()->get( 'Version' )
    );
}

/**
 * Load Custom Post Types & Taxonomies
 * (cpt-destination.php contains all the registration logic)
 */
require_once get_stylesheet_directory() . '/inc/cpt-destination.php';
