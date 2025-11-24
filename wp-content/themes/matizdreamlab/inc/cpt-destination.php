<?php
/**
 * cpt-destination.php
 *
 * Registers the 'destination' custom post type and related taxonomies
 * for the Matizdreamlab child theme.
 *
 * Save to: wp-content/themes/your-child-theme/inc/cpt-destination.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Destination CPT
 */
function matizdreamlab_register_destination_cpt() {

    $labels = array(
        'name'                  => __( 'Destinations', 'matizdreamlab' ),
        'singular_name'         => __( 'Destination', 'matizdreamlab' ),
        'menu_name'             => __( 'Destinations', 'matizdreamlab' ),
        'name_admin_bar'        => __( 'Destination', 'matizdreamlab' ),
        'add_new'               => __( 'Add New', 'matizdreamlab' ),
        'add_new_item'          => __( 'Add New Destination', 'matizdreamlab' ),
        'new_item'              => __( 'New Destination', 'matizdreamlab' ),
        'edit_item'             => __( 'Edit Destination', 'matizdreamlab' ),
        'view_item'             => __( 'View Destination', 'matizdreamlab' ),
        'all_items'             => __( 'All Destinations', 'matizdreamlab' ),
        'search_items'          => __( 'Search Destinations', 'matizdreamlab' ),
        'parent_item_colon'     => __( 'Parent Destinations:', 'matizdreamlab' ),
        'not_found'             => __( 'No destinations found.', 'matizdreamlab' ),
        'not_found_in_trash'    => __( 'No destinations found in Trash.', 'matizdreamlab' )
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_icon'             => 'dashicons-palmtree',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'destinations' ),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 5,
        'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'revisions' ),
        'show_in_rest'          => true, // enable Gutenberg & REST API
    );

    register_post_type( 'destination', $args );
}
add_action( 'init', 'matizdreamlab_register_destination_cpt' );


/**
 * Register Country taxonomy (hierarchical) — acts like categories for destinations
 */
function matizdreamlab_register_country_taxonomy() {

    $labels = array(
        'name'              => __( 'Countries', 'matizdreamlab' ),
        'singular_name'     => __( 'Country', 'matizdreamlab' ),
        'search_items'      => __( 'Search Countries', 'matizdreamlab' ),
        'all_items'         => __( 'All Countries', 'matizdreamlab' ),
        'parent_item'       => __( 'Parent Country', 'matizdreamlab' ),
        'parent_item_colon' => __( 'Parent Country:', 'matizdreamlab' ),
        'edit_item'         => __( 'Edit Country', 'matizdreamlab' ),
        'update_item'       => __( 'Update Country', 'matizdreamlab' ),
        'add_new_item'      => __( 'Add New Country', 'matizdreamlab' ),
        'new_item_name'     => __( 'New Country Name', 'matizdreamlab' ),
        'menu_name'         => __( 'Country', 'matizdreamlab' ),
    );

    $args = array(
        'hierarchical'      => true, // like categories
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'country' ),
        'show_in_rest'      => true, // enable REST
    );

    register_taxonomy( 'country', array( 'destination' ), $args );
}
add_action( 'init', 'matizdreamlab_register_country_taxonomy' );


/**
 * Register Destination Tag taxonomy (non-hierarchical) — acts like tags for destinations
 */
function matizdreamlab_register_destination_tag_taxonomy() {

    $labels = array(
        'name'                       => __( 'Destination Tags', 'matizdreamlab' ),
        'singular_name'              => __( 'Destination Tag', 'matizdreamlab' ),
        'search_items'               => __( 'Search Tags', 'matizdreamlab' ),
        'popular_items'              => __( 'Popular Tags', 'matizdreamlab' ),
        'all_items'                  => __( 'All Tags', 'matizdreamlab' ),
        'edit_item'                  => __( 'Edit Tag', 'matizdreamlab' ),
        'update_item'                => __( 'Update Tag', 'matizdreamlab' ),
        'add_new_item'               => __( 'Add New Tag', 'matizdreamlab' ),
        'new_item_name'              => __( 'New Tag Name', 'matizdreamlab' ),
        'separate_items_with_commas' => __( 'Separate tags with commas', 'matizdreamlab' ),
        'add_or_remove_items'        => __( 'Add or remove tags', 'matizdreamlab' ),
        'choose_from_most_used'      => __( 'Choose from the most used tags', 'matizdreamlab' ),
        'not_found'                  => __( 'No tags found.', 'matizdreamlab' ),
        'menu_name'                  => __( 'Tags', 'matizdreamlab' ),
    );

    $args = array(
        'hierarchical'          => false, // like tags
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => false,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'destination-tag' ),
        'show_in_rest'          => true,
    );

    register_taxonomy( 'destination_tag', 'destination', $args );
}
add_action( 'init', 'matizdreamlab_register_destination_tag_taxonomy' );


/**
 * Optional: Add some example country terms on theme activation (only if none exist)
 * You can remove or adapt the default list to your needs.
 */
function matizdreamlab_seed_default_countries() {
    // Only run when there are no country terms
    if ( ! term_exists( 'Italy', 'country' ) && ! term_exists( 'Japan', 'country' ) ) {
        $default_countries = array( 'Italy', 'Japan', 'New Zealand', 'France', 'Australia', 'Mexico', 'Thailand', 'Norway', 'Canada' );
        foreach ( $default_countries as $country ) {
            if ( ! term_exists( $country, 'country' ) ) {
                wp_insert_term( $country, 'country' );
            }
        }
    }
}
add_action( 'after_setup_theme', 'matizdreamlab_seed_default_countries' );
