<?php
/**
 * Sticky "themes" feature.  Works like sticky posts but for the theme archive.
 *
 * @package    ThemeDesigner
 * @subpackage Core
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/theme-designer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Add sticky posts to the front of the line.
add_filter( 'the_posts', 'thds_posts_sticky_filter', 10, 2 );

/**
 * Adds a theme to the list of sticky themes.
 *
 * @since  1.0.0
 * @access public
 * @param  int    $theme_id
 * @return bool
 */
function thds_add_sticky_theme( $theme_id ) {
	$theme_id = thds_get_theme_id( $theme_id );

	if ( ! thds_is_theme_sticky( $theme_id ) )
		return update_option( 'thds_sticky_themes', array_unique( array_merge( thds_get_sticky_themes(), array( $theme_id ) ) ) );

	return false;
}

/**
 * Removes a theme from the list of sticky themes.
 *
 * @since  1.0.0
 * @access public
 * @param  int    $theme_id
 * @return bool
 */
function thds_remove_sticky_theme( $theme_id ) {
	$theme_id = thds_get_theme_id( $theme_id );

	if ( thds_is_theme_sticky( $theme_id ) ) {
		$stickies = thds_get_sticky_themes();
		$key      = array_search( $theme_id, $stickies );

		if ( isset( $stickies[ $key ] ) ) {
			unset( $stickies[ $key ] );
			return update_option( 'thds_sticky_themes', array_unique( $stickies ) );
		}
	}

	return false;
}

/**
 * Returns an array of sticky themes.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function thds_get_sticky_themes() {
	return apply_filters( 'thds_get_sticky_themes', get_option( 'thds_sticky_themes', array() ) );
}

/**
 * Filter on `the_posts` for the theme archive. Moves sticky posts to the top of
 * the theme archive list.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $posts
 * @param  object $query
 * @return array
 */
function thds_posts_sticky_filter( $posts, $query ) {

	// Allow devs to filter when to show sticky themes.
	$show_stickies = apply_filters( 'thds_show_stickies', $query->is_main_query() && ! is_admin() && thds_is_theme_archive() && ! is_paged() );

	// If we should show stickies, let's get them.
	if ( $show_stickies ) {

		remove_filter( 'the_posts', 'thds_posts_sticky_filter' );

		$posts = thds_add_stickies( $posts, thds_get_sticky_themes() );
	}

	return $posts;
}

/**
 * Adds sticky posts to the front of the line with any given set of posts and stickies.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $posts         Array of post objects.
 * @param  array  $sticky_posts  Array of post IDs.
 * @return array
 */
function thds_add_stickies( $posts, $sticky_posts ) {

	// Only do this if on the first page and we indeed have stickies.
	if ( ! empty( $sticky_posts ) ) {

		$num_posts     = count( $posts );
		$sticky_offset = 0;

		// Loop over posts and relocate stickies to the front.
		for ( $i = 0; $i < $num_posts; $i++ ) {

			if ( in_array( $posts[ $i ]->ID, $sticky_posts ) ) {

				$sticky_post = $posts[ $i ];

				// Remove sticky from current position.
				array_splice( $posts, $i, 1);

				// Move to front, after other stickies.
				array_splice( $posts, $sticky_offset, 0, array( $sticky_post ) );

				// Increment the sticky offset. The next sticky will be placed at this offset.
				$sticky_offset++;

				// Remove post from sticky posts array.
				$offset = array_search( $sticky_post->ID, $sticky_posts );

				unset( $sticky_posts[ $offset ] );
			}
		}

		// Fetch sticky posts that weren't in the query results.
		if ( ! empty( $sticky_posts ) ) {

			$args = array(
					'post__in'    => $sticky_posts,
					'post_type'   => thds_get_theme_post_type(),
					'post_status' => 'publish',
					'nopaging'    => true
			);

			$stickies = get_posts( $args );

			foreach ( $stickies as $sticky_post ) {
				array_splice( $posts, $sticky_offset, 0, array( $sticky_post ) );
				$sticky_offset++;
			}
		}
	}

	return $posts;
}
