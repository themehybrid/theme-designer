<?php
/**
 * Handles the registration of custom post types and related filters.
 *
 * @package    ThemeDesigner
 * @subpackage Core
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/theme-designer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Register custom post types on the 'init' hook.
add_action( 'init', 'thds_register_post_types' );

# Filter the "enter title here" text.
add_filter( 'enter_title_here', 'thds_enter_title_here', 10, 2 );

# Filter the bulk and post updated messages.
add_filter( 'bulk_post_updated_messages', 'thds_bulk_post_updated_messages', 5, 2 );
add_filter( 'post_updated_messages',      'thds_post_updated_messages',      5    );

/**
 * Returns the name of the theme post type.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function thds_get_theme_post_type() {

	return apply_filters( 'thds_get_theme_post_type', 'theme' );
}

/**
 * Returns the capabilities for the theme post type.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function thds_get_theme_capabilities() {

	$caps = array(

		// meta caps (don't assign these to roles)
		'edit_post'              => 'edit_theme_project',
		'read_post'              => 'read_theme_project',
		'delete_post'            => 'delete_theme_project',

		// primitive/meta caps
		'create_posts'           => 'create_theme_projects',

		// primitive caps used outside of map_meta_cap()
		'edit_posts'             => 'edit_theme_projects',
		'edit_others_posts'      => 'edit_others_theme_projects',
		'publish_posts'          => 'publish_theme_projects',
		'read_private_posts'     => 'read_private_theme_projects',

		// primitive caps used inside of map_meta_cap()
		'read'                   => 'read',
		'delete_posts'           => 'delete_theme_projects',
		'delete_private_posts'   => 'delete_private_theme_projects',
		'delete_published_posts' => 'delete_published_theme_projects',
		'delete_others_posts'    => 'delete_others_theme_projects',
		'edit_private_posts'     => 'edit_private_theme_projects',
		'edit_published_posts'   => 'edit_published_theme_projects'
	);

	return apply_filters( 'thds_get_theme_capabilities', $caps );
}

/**
 * Returns the labels for the theme post type.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function thds_get_theme_labels() {

	$labels = array(
		'name'                  => __( 'Themes',                   'theme-designer' ),
		'singular_name'         => __( 'Theme',                    'theme-designer' ),
		'menu_name'             => thds_get_menu_title(),
		'name_admin_bar'        => __( 'Theme',                    'theme-designer' ),
		'add_new'               => __( 'New Theme',                'theme-designer' ),
		'add_new_item'          => __( 'Add New Theme',            'theme-designer' ),
		'edit_item'             => __( 'Edit Theme',               'theme-designer' ),
		'new_item'              => __( 'New Theme',                'theme-designer' ),
		'view_item'             => __( 'View Theme',               'theme-designer' ),
		'search_items'          => __( 'Search Themes',            'theme-designer' ),
		'not_found'             => __( 'No themes found',          'theme-designer' ),
		'not_found_in_trash'    => __( 'No themes found in trash', 'theme-designer' ),
		'all_items'             => __( 'Themes',                   'theme-designer' ),
		'featured_image'        => __( 'Screenshot',               'theme-designer' ),
		'set_featured_image'    => __( 'Set screenshot',           'theme-designer' ),
		'remove_featured_image' => __( 'Remove screenshot',        'theme-designer' ),
		'use_featured_image'    => __( 'Use as screenshot',        'theme-designer' ),
		'insert_into_item'      => __( 'Insert into content',      'theme-designer' ),
		'uploaded_to_this_item' => __( 'Uploaded to this theme',   'theme-designer' ),
		'views'                 => __( 'Filter themes list',       'theme-designer' ),
		'pagination'            => __( 'Themes list navigation',   'theme-designer' ),
		'list'                  => __( 'Themes list',              'theme-designer' ),

		// Custom labels b/c WordPress doesn't have anything to handle this.
		'archive_title'         => thds_get_archive_title(),
	);

	return apply_filters( 'thds_get_theme_labels', $labels );
}

/**
 * Registers post types needed by the plugin.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function thds_register_post_types() {

	// Set up the arguments for the theme post type.
	$theme_args = array(
		'description'         => thds_get_archive_description(),
		'public'              => true,
		'publicly_queryable'  => true,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => true,
		'exclude_from_search' => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => null,
		'menu_icon'           => 'dashicons-art',
		'can_export'          => true,
		'delete_with_user'    => false,
		'hierarchical'        => false,
		'has_archive'         => thds_get_rewrite_base(),
		'query_var'           => 'theme_project',
		'capability_type'     => 'theme_project',
		'map_meta_cap'        => true,
		'capabilities'        => thds_get_theme_capabilities(),
		'labels'              => thds_get_theme_labels(),

		// The rewrite handles the URL structure.
		'rewrite' => array(
			'slug'       => thds_get_theme_rewrite_slug(),
			'with_front' => false,
			'pages'      => true,
			'feeds'      => true,
			'ep_mask'    => EP_PERMALINK,
		),

		// What features the post type supports.
		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'author',
			'thumbnail',

			// Theme/Plugin feature support.
			'custom-background', // Custom Background Extended
			'custom-header',     // Custom Header Extended
		)
	);

	// Register the post types.
	register_post_type( thds_get_theme_post_type(), apply_filters( 'thds_theme_post_type_args', $theme_args ) );
}

/**
 * Custom "enter title here" text.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $title
 * @param  object  $post
 * @return string
 */
function thds_enter_title_here( $title, $post ) {

	return thds_get_theme_post_type() === $post->post_type ? esc_html__( 'Enter theme name', 'theme-designer' ) : '';
}

/**
 * Adds custom post updated messages on the edit post screen.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $messages
 * @global object $post
 * @global int    $post_ID
 * @return array
 */
function thds_post_updated_messages( $messages ) {
	global $post, $post_ID;

	$theme_type = thds_get_theme_post_type();

	if ( $theme_type !== $post->post_type )
		return $messages;

	// Get permalink and preview URLs.
	$permalink   = get_permalink( $post_ID );
	$preview_url = get_preview_post_link( $post );

	// Translators: Scheduled theme date format. See http://php.net/date
	$scheduled_date = date_i18n( __( 'M j, Y @ H:i', 'theme-designer' ), strtotime( $post->post_date ) );

	// Set up view links.
	$preview_link   = sprintf( ' <a target="_blank" href="%1$s">%2$s</a>', esc_url( $preview_url ), esc_html__( 'Preview theme', 'theme-designer' ) );
	$scheduled_link = sprintf( ' <a target="_blank" href="%1$s">%2$s</a>', esc_url( $permalink ),   esc_html__( 'Preview theme', 'theme-designer' ) );
	$view_link      = sprintf( ' <a href="%1$s">%2$s</a>',                 esc_url( $permalink ),   esc_html__( 'View theme',    'theme-designer' ) );

	// Post updated messages.
	$messages[ $theme_type ] = array(
		 1 => esc_html__( 'Theme updated.', 'theme-designer' ) . $view_link,
		 4 => esc_html__( 'Theme updated.', 'theme-designer' ),
		 // Translators: %s is the date and time of the revision.
		 5 => isset( $_GET['revision'] ) ? sprintf( esc_html__( 'Theme restored to revision from %s.', 'theme-designer' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		 6 => esc_html__( 'Theme published.', 'theme-designer' ) . $view_link,
		 7 => esc_html__( 'Theme saved.', 'theme-designer' ),
		 8 => esc_html__( 'Theme submitted.', 'theme-designer' ) . $preview_link,
		 9 => sprintf( esc_html__( 'Theme scheduled for: %s.', 'theme-designer' ), "<strong>{$scheduled_date}</strong>" ) . $scheduled_link,
		10 => esc_html__( 'Theme draft updated.', 'theme-designer' ) . $preview_link,
	);

	return $messages;
}

/**
 * Adds custom bulk post updated messages on the manage themes screen.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $messages
 * @param  array  $counts
 * @return array
 */
function thds_bulk_post_updated_messages( $messages, $counts ) {

	$type = thds_get_theme_post_type();

	$messages[ $type ]['updated']   = _n( '%s theme updated.',                             '%s themes updated.',                               $counts['updated'],   'theme-designer' );
	$messages[ $type ]['locked']    = _n( '%s theme not updated, somebody is editing it.', '%s themes not updated, somebody is editing them.', $counts['locked'],    'theme-designer' );
	$messages[ $type ]['deleted']   = _n( '%s theme permanently deleted.',                 '%s themes permanently deleted.',                   $counts['deleted'],   'theme-designer' );
	$messages[ $type ]['trashed']   = _n( '%s theme moved to the Trash.',                  '%s themes moved to the trash.',                    $counts['trashed'],   'theme-designer' );
	$messages[ $type ]['untrashed'] = _n( '%s theme restored from the Trash.',             '%s themes restored from the trash.',               $counts['untrashed'], 'theme-designer' );

	return $messages;
}
