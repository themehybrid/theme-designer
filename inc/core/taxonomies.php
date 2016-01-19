<?php
/**
 * Handles registering custom taxonomies and related filters.
 *
 * @package    ThemeDesigner
 * @subpackage Core
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/theme-designer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Register taxonomies on the 'init' hook.
add_action( 'init', 'thds_register_taxonomies', 9 );

# Filter the term updated messages.
add_filter( 'term_updated_messages', 'thds_term_updated_messages', 5 );

/**
 * Returns the name of the subject taxonomy.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function thds_get_subject_taxonomy() {

	return apply_filters( 'thds_get_subject_taxonomy', 'theme_subject' );
}

/**
 * Returns the name of the feature taxonomy.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function thds_get_feature_taxonomy() {

	return apply_filters( 'thds_get_feature_taxonomy', 'theme_feature' );
}

/**
 * Returns the capabilities for the subject taxonomy.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function thds_get_subject_capabilities() {

	$caps = array(
		'manage_terms' => 'manage_theme_subjects',
		'edit_terms'   => 'manage_theme_subjects',
		'delete_terms' => 'manage_theme_subjects',
		'assign_terms' => 'edit_theme_projects'
	);

	return apply_filters( 'thds_get_subject_capabilities', $caps );
}

/**
 * Returns the capabilities for the feature taxonomy.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function thds_get_feature_capabilities() {

	$caps = array(
		'manage_terms' => 'manage_theme_features',
		'edit_terms'   => 'manage_theme_features',
		'delete_terms' => 'manage_theme_features',
		'assign_terms' => 'edit_theme_projects',
	);

	return apply_filters( 'thds_get_feature_capabilities', $caps );
}

/**
 * Returns the labels for the subject taxonomy.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function thds_get_subject_labels() {

	$labels = array(
		'name'                       => __( 'Subjects',                           'theme-designer' ),
		'singular_name'              => __( 'Subject',                             'theme-designer' ),
		'menu_name'                  => __( 'Subjects',                           'theme-designer' ),
		'name_admin_bar'             => __( 'Subject',                             'theme-designer' ),
		'search_items'               => __( 'Search Subjects',                    'theme-designer' ),
		'popular_items'              => __( 'Popular Subjects',                   'theme-designer' ),
		'all_items'                  => __( 'All Subjects',                       'theme-designer' ),
		'edit_item'                  => __( 'Edit Subject',                        'theme-designer' ),
		'view_item'                  => __( 'View Subject',                        'theme-designer' ),
		'update_item'                => __( 'Update Subject',                      'theme-designer' ),
		'add_new_item'               => __( 'Add New Subject',                     'theme-designer' ),
		'new_item_name'              => __( 'New Subject Name',                    'theme-designer' ),
		'not_found'                  => __( 'No subjects found.',                 'theme-designer' ),
		'no_terms'                   => __( 'No subjects',                        'theme-designer' ),
		'pagination'                 => __( 'Subjects list navigation',           'theme-designer' ),
		'list'                       => __( 'Subjects list',                      'theme-designer' ),

		// Hierarchical only.
		'select_name'                => __( 'Select Subject',                      'theme-designer' ),
		'parent_item'                => __( 'Parent Subject',                      'theme-designer' ),
		'parent_item_colon'          => __( 'Parent Subject:',                     'theme-designer' ),
	);

	return apply_filters( 'thds_get_subject_labels', $labels );
}

/**
 * Returns the labels for the feature taxonomy.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function thds_get_feature_labels() {

	$labels = array(
		'name'                       => __( 'Features',                           'theme-designer' ),
		'singular_name'              => __( 'Feature',                            'theme-designer' ),
		'menu_name'                  => __( 'Features',                           'theme-designer' ),
		'name_admin_bar'             => __( 'Feature',                            'theme-designer' ),
		'search_items'               => __( 'Search Features',                    'theme-designer' ),
		'popular_items'              => __( 'Popular Features',                   'theme-designer' ),
		'all_items'                  => __( 'All Features',                       'theme-designer' ),
		'edit_item'                  => __( 'Edit Feature',                       'theme-designer' ),
		'view_item'                  => __( 'View Feature',                       'theme-designer' ),
		'update_item'                => __( 'Update Feature',                     'theme-designer' ),
		'add_new_item'               => __( 'Add New Feature',                    'theme-designer' ),
		'new_item_name'              => __( 'New Feature Name',                   'theme-designer' ),
		'not_found'                  => __( 'No features found.',                 'theme-designer' ),
		'no_terms'                   => __( 'No features',                        'theme-designer' ),
		'pagination'                 => __( 'Features list navigation',           'theme-designer' ),
		'list'                       => __( 'Features list',                      'theme-designer' ),

		// Non-hierarchical only.
		'separate_items_with_commas' => __( 'Separate features with commas',      'theme-designer' ),
		'add_or_remove_items'        => __( 'Add or remove features',             'theme-designer' ),
		'choose_from_most_used'      => __( 'Choose from the most used features', 'theme-designer' ),
	);

	return apply_filters( 'thds_get_feature_labels', $labels );
}

/**
 * Register taxonomies for the plugin.
 *
 * @since  0.1.0
 * @access public
 * @return void.
 */
function thds_register_taxonomies() {

	// Set up the arguments for the subject taxonomy.
	$subject_args = array(
		'public'            => true,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'show_admin_column' => true,
		'hierarchical'      => true,
		'query_var'         => thds_get_subject_taxonomy(),
		'capabilities'      => thds_get_subject_capabilities(),
		'labels'            => thds_get_subject_labels(),

		// The rewrite handles the URL structure.
		'rewrite' => array(
			'slug'         => thds_get_subject_rewrite_slug(),
			'with_front'   => false,
			'hierarchical' => false,
			'ep_mask'      => EP_NONE
		),
	);

	// Set up the arguments for the feature taxonomy.
	$feature_args = array(
		'public'            => true,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'show_admin_column' => false,
		'hierarchical'      => false,
		'query_var'         => thds_get_feature_taxonomy(),
		'capabilities'      => thds_get_feature_capabilities(),
		'labels'            => thds_get_feature_labels(),

		// The rewrite handles the URL structure.
		'rewrite' => array(
			'slug'         => thds_get_feature_rewrite_slug(),
			'with_front'   => false,
			'hierarchical' => false,
			'ep_mask'      => EP_NONE
		),
	);

	// Register the taxonomies.
	register_taxonomy( thds_get_subject_taxonomy(), thds_get_theme_post_type(), apply_filters( 'thds_subject_taxonomy_args', $subject_args ) );
	register_taxonomy( thds_get_feature_taxonomy(), thds_get_theme_post_type(), apply_filters( 'thds_feature_taxonomy_args', $feature_args ) );
}

/**
 * Filters the term updated messages in the admin.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $messages
 * @return array
 */
function thds_term_updated_messages( $messages ) {

	$subject_taxonomy = thds_get_subject_taxonomy();
	$feature_taxonomy = thds_get_feature_taxonomy();

	// Add the subject messages.
	$messages[ $subject_taxonomy ] = array(
		0 => '',
		1 => __( 'Subject added.',       'theme-designer' ),
		2 => __( 'Subject deleted.',     'theme-designer' ),
		3 => __( 'Subject updated.',     'theme-designer' ),
		4 => __( 'Subject not added.',   'theme-designer' ),
		5 => __( 'Subject not updated.', 'theme-designer' ),
		6 => __( 'Subjects deleted.',    'theme-designer' ),
	);

	// Add the feature messages.
	$messages[ $feature_taxonomy ] = array(
		0 => '',
		1 => __( 'Feature added.',       'theme-designer' ),
		2 => __( 'Feature deleted.',     'theme-designer' ),
		3 => __( 'Feature updated.',     'theme-designer' ),
		4 => __( 'Feature not added.',   'theme-designer' ),
		5 => __( 'Feature not updated.', 'theme-designer' ),
		6 => __( 'Features deleted.',    'theme-designer' ),
	);

	return $messages;
}
