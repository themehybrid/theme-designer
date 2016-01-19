<?php
/**
 * WordPress.org theme integration functions and filters.
 *
 * @package    ThemeDesigner
 * @subpackage WPORG
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/theme-designer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# WPORG API usage.
add_action( 'wp_loaded', 'thds_use_wporg_api_filters', 0 );

/**
 * Checks if we're using the WordPress.org Themes API.  If so, run filters over
 * getter function hooks.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function thds_use_wporg_api_filters() {

	if ( ! thds_use_wporg_api() )
		return;

	add_filter( 'thds_get_theme_version',        'thds_wporg_theme_version_filter',        5, 2 );
	add_filter( 'thds_get_theme_download_url',   'thds_wporg_theme_download_url_filter',   5, 2 );
	add_filter( 'thds_get_theme_demo_url',       'thds_wporg_theme_demo_url_filter',       5, 2 );
	add_filter( 'thds_get_theme_repo_url',       'thds_wporg_theme_repo_url_filter',       5, 2 );
	add_filter( 'thds_get_theme_support_url',    'thds_wporg_theme_support_url_filter',    5, 2 );
	add_filter( 'thds_get_theme_translate_url',  'thds_wporg_theme_translate_url_filter',  5, 2 );
	add_filter( 'thds_get_theme_download_count', 'thds_wporg_theme_download_count_filter', 5, 2 );
	add_filter( 'thds_get_theme_install_count',  'thds_wporg_theme_install_count_filter',  5, 2 );
	add_filter( 'thds_get_theme_rating',         'thds_wporg_theme_rating_filter',         5, 2 );
	add_filter( 'thds_get_theme_rating_count',   'thds_wporg_theme_rating_count_filter',   5, 2 );
}

/**
 * Returns the `THDS_WPORG_Theme_Factory` instance.
 *
 * @since  1.0.0
 * @access public
 * @return object
 */
function thds_wporg_theme_factory() {

	return THDS_WPORG_Theme_Factory::get_instance();
}

/**
 * Returns a `THDS_WPORG_Theme` object.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return object
 */
function thds_get_wporg_theme( $theme_id ) {

	if ( ! thds_wporg_theme_exists( $theme_id ) )
		thds_register_wporg_theme( $theme_id );

	return thds_wporg_theme_factory()->get( $theme_id );
}

/**
 * Registers a `THDS_WPORG_Theme` object.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_register_wporg_theme( $theme_id ) {

	thds_wporg_theme_factory()->register( $theme_id );
}

/**
 * Unregisters a `THDS_WPORG_Theme` object.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_unregister_wporg_theme( $theme_id ) {

	thds_wporg_theme_factory()->unregister( $theme_id );
}

/**
 * Checks if a `THDS_WPORG_Theme` object exists.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return bool
 */
function thds_wporg_theme_exists( $theme_id ) {

	return thds_wporg_theme_factory()->exists( $theme_id);
}

/**
 * Filters the theme version.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $version
 * @param  int     $theme_id
 * @return string
 */
function thds_wporg_theme_version_filter( $version, $theme_id ) {

	return ! $version ? thds_get_wporg_theme_version( $theme_id ) : $version;
}

/**
 * Filters the theme download URL.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $url
 * @param  int     $theme_id
 * @return string
 */
function thds_wporg_theme_download_url_filter( $url, $theme_id ) {

	return ! $url ? thds_get_wporg_theme_download_link( $theme_id ) : $url;
}

/**
 * Filters the theme demo URL.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $url
 * @param  int     $theme_id
 * @return string
 */
function thds_wporg_theme_demo_url_filter( $url, $theme_id ) {

	return ! $url ? thds_get_wporg_theme_preview_url( $theme_id ) : $url;
}

/**
 * Filters the theme repository URL.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $url
 * @param  int     $theme_id
 * @return string
 */
function thds_wporg_theme_repo_url_filter( $url, $theme_id ) {

	return ! $url ? thds_get_wporg_theme_svn_url( $theme_id ) : $url;
}

/**
 * Filters the theme translate URL.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $url
 * @param  int     $theme_id
 * @return string
 */
function thds_wporg_theme_translate_url_filter( $url, $theme_id ) {

	return ! $url ? thds_get_wporg_theme_translate_url( $theme_id ) : $url;
}

/**
 * Filters the theme support URL.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $url
 * @param  int     $theme_id
 * @return string
 */
function thds_wporg_theme_support_url_filter( $url, $theme_id ) {

	return ! $url ? thds_get_wporg_theme_support_url( $theme_id ) : $url;
}

/**
 * Filters the theme download count.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $count
 * @param  int     $theme_id
 * @return string
 */
function thds_wporg_theme_download_count_filter( $count, $theme_id ) {

	return '' === $count ? thds_get_wporg_theme_downloaded( $theme_id ) : $count;
}

/**
 * Filters the theme install count.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $count
 * @param  int     $theme_id
 * @return string
 */
function thds_wporg_theme_install_count_filter( $count, $theme_id ) {

	return '' === $count ? thds_get_wporg_theme_active_installs( $theme_id ) : $count;
}

/**
 * Filters the theme rating.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $rating
 * @param  int     $theme_id
 * @return string
 */
function thds_wporg_theme_rating_filter( $rating, $theme_id ) {

	if ( '' === $rating ) {

		$wporg_rating = thds_get_wporg_theme_rating( $theme_id );

		if ( $wporg_rating )
			$rating = round( ( absint( $wporg_rating ) / 100 ) * 5, 2 );
	}

	return $rating;
}

/**
 * Filters the theme rating count.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $url
 * @param  int     $theme_id
 * @return string
 */
function thds_wporg_theme_rating_count_filter( $count, $theme_id ) {

	return '' === $count ? thds_get_wporg_theme_num_ratings( $theme_id ) : $count;
}
