<?php
/**
 * Handles custom rewrite rules.
 *
 * @package    ThemeDesigner
 * @subpackage Core
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/theme-designer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Add custom rewrite rules.
add_action( 'init', 'thds_rewrite_rules', 5 );

/**
 * Adds custom rewrite rules for the plugin.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function thds_rewrite_rules() {

	$theme_type  = thds_get_theme_post_type();
	$author_slug = thds_get_author_rewrite_slug();

	// Where to place the rewrite rules.  If no rewrite base, put them at the bottom.
	$after = thds_get_author_rewrite_base() ? 'top' : 'bottom';

	add_rewrite_rule( $author_slug . '/([^/]+)/page/?([0-9]{1,})/?$', 'index.php?post_type=' . $theme_type . '&author_name=$matches[1]&paged=$matches[2]', $after );
	add_rewrite_rule( $author_slug . '/([^/]+)/?$',                   'index.php?post_type=' . $theme_type . '&author_name=$matches[1]',                   $after );
}

/**
 * Returns the theme rewrite slug used for single themes.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function thds_get_theme_rewrite_slug() {
	$rewrite_base = thds_get_rewrite_base();
	$theme_base   = thds_get_theme_rewrite_base();

	$slug = $theme_base ? trailingslashit( $rewrite_base ) . $theme_base : $rewrite_base;

	return apply_filters( 'thds_get_theme_rewrite_slug', $slug );
}

/**
 * Returns the subject rewrite slug used for subject archives.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function thds_get_subject_rewrite_slug() {
	$rewrite_base = thds_get_rewrite_base();
	$subject_base = thds_get_subject_rewrite_base();

	$slug = $subject_base ? trailingslashit( $rewrite_base ) . $subject_base : $rewrite_base;

	return apply_filters( 'thds_get_subject_rewrite_slug', $slug );
}

/**
 * Returns the feature rewrite slug used for feature archives.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function thds_get_feature_rewrite_slug() {
	$rewrite_base = thds_get_rewrite_base();
	$feature_base = thds_get_feature_rewrite_base();

	$slug = $feature_base ? trailingslashit( $rewrite_base ) . $feature_base : $rewrite_base;

	return apply_filters( 'thds_get_feature_rewrite_slug', $slug );
}

/**
 * Returns the author rewrite slug used for author archives.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function thds_get_author_rewrite_slug() {
	$rewrite_base = thds_get_rewrite_base();
	$author_base  = thds_get_author_rewrite_base();

	$slug = $author_base ? trailingslashit( $rewrite_base ) . $author_base : $rewrite_base;

	return apply_filters( 'thds_get_author_rewrite_slug', $slug );
}
