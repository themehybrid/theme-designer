<?php
/**
 * Author template tags.
 *
 * @package    ThemeDesigner
 * @subpackage Template
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/theme-designer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Conditional tag to check if viewing a project author archive.
 *
 * @since  1.0.0
 * @access public
 * @param  mixed  $author
 * @return bool
 */
function thds_is_author( $author = '' ) {

	return apply_filters( 'thds_is_author', is_post_type_archive( thds_get_theme_post_type() ) && is_author( $author ) );
}

/**
 * Print the author archive title.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function thds_single_author_title() {
	echo thds_get_single_author_title();
}

/**
 * Retrieve the author archive title.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function thds_get_single_author_title() {

	return apply_filters( 'thds_get_single_author_title', get_the_author_meta( 'display_name', absint( get_query_var( 'author' ) ) ) );
}

/**
 * Returns the author archive URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $user_id
 * @global object  $wp_rewrite
 * @global object  $authordata
 * @return string
 */
function thds_get_author_url( $user_id = 0 ) {
	global $wp_rewrite, $authordata;

	$url = '';

	// If no user ID, see if there's some author data we can get it from.
	if ( ! $user_id && is_object( $authordata ) )
		$user_id = $authordata->ID;

	// If we have a user ID, build the URL.
	if ( $user_id ) {

		// Get the author's nicename.
		$nicename = get_the_author_meta( 'user_nicename', $user_id );

		// Pretty permalinks.
		if ( $wp_rewrite->using_permalinks() )
			$url = home_url( user_trailingslashit( trailingslashit( thds_get_author_rewrite_slug() ) . $nicename ) );

		// Ugly permalinks.
		else
			$url = add_query_arg( array( 'post_type' => thds_get_theme_post_type(), 'author_name' => $nicename ), home_url( '/' ) );
	}

	return apply_filters( 'thds_get_author_url', $url, $user_id );
}
