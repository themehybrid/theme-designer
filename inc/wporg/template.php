<?php
/**
 * WordPress.org theme integration template tags.
 *
 * @package    ThemeDesigner
 * @subpackage WPORG
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/theme-designer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Conditional check to see if the theme is a WordPress.org theme.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_is_wporg_theme( $theme_id = 0 ) {

	$theme_id = thds_get_theme_id( $theme_id );
	$theme    = thds_get_wporg_theme( $theme_id );

	return apply_filters( 'thds_is_wporg_theme', is_object( $theme ), $theme_id );
}

/**
 * Prints the theme SVN repo URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_wporg_theme_svn_url( $theme_id = 0 ) {

	echo esc_url( thds_get_wporg_theme_svn_url( $theme_id ) );
}

/**
 * Returns the theme SVN repo URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_wporg_theme_svn_url( $theme_id = 0 ) {

	$theme_id = thds_get_theme_id( $theme_id );
	$slug     = thds_get_theme_wporg_slug( $theme_id );
	$url      = $slug ? "https://themes.svn.wordpress.org/{$slug}" : '';

	return apply_filters( 'thds_get_wporg_theme_svn_url', $url, $theme_id );
}

/**
 * Prints the theme translate URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_wporg_theme_translate_url( $theme_id = 0 ) {

	echo esc_url( thds_get_wporg_theme_translate_url( $theme_id ) );
}

/**
 * Returns the theme translate URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_wporg_theme_translate_url( $theme_id = 0 ) {

	$theme_id = thds_get_theme_id( $theme_id );
	$slug     = thds_get_theme_wporg_slug( $theme_id );
	$url      = $slug ? "https://translate.wordpress.org/projects/wp-themes/{$slug}" : '';

	return apply_filters( 'thds_get_wporg_theme_translate_url', $url, $theme_id );
}

/**
 * Prints the theme support URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_wporg_theme_support_url( $theme_id = 0 ) {

	echo esc_url( thds_get_wporg_theme_support_url( $theme_id ) );
}

/**
 * Returns the theme support URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_wporg_theme_support_url( $theme_id = 0 ) {

	$theme_id = thds_get_theme_id( $theme_id );
	$slug     = thds_get_theme_wporg_slug( $theme_id );
	$url      = $slug ? "https://wordpress.org/support/theme/{$slug}" : '';

	return apply_filters( 'thds_get_wporg_theme_support_url', $url, $theme_id );
}

/**
 * Prints the theme reviews URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_wporg_theme_reviews_url( $theme_id = 0 ) {

	echo esc_url( thds_get_wporg_theme_reviews_url( $theme_id ) );
}

/**
 * Returns the theme reviews URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_wporg_theme_reviews_url( $theme_id = 0 ) {

	$theme_id = thds_get_theme_id( $theme_id );
	$slug     = thds_get_theme_wporg_slug( $theme_id );
	$url      = $slug ? "https://wordpress.org/support/view/theme-reviews/{$slug}" : '';

	return apply_filters( 'thds_get_wporg_theme_reviews_url', $url, $theme_id );
}

/**
 * Prints the URL for the theme's tickets on the Themes Trac.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_wporg_theme_tickets_url( $theme_id = 0 ) {

	echo esc_url( thds_get_wporg_theme_tickets_url( $theme_id ) );
}

/**
 * Gets the URL for the theme's tickets on the Themes Trac.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_wporg_theme_tickets_url( $theme_id = 0 ) {

	$theme_id = thds_get_theme_id( $theme_id );
	$slug     = thds_get_theme_wporg_slug( $theme_id );
	$url      = $slug ? "https://themes.trac.wordpress.org/query?keywords=theme-{$slug}" : '';

	return apply_filters( 'thds_get_wporg_tickets_url', $url, $theme_id );
}

/**
 * Returns a property from the WordPress.org theme object.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @param  string  $property
 * @return mixed
 */
function thds_get_wporg_theme_property( $theme_id = 0, $property ) {

	$theme_id = thds_get_theme_id( $theme_id );

	$theme_object = thds_get_wporg_theme( $theme_id );

	$data = isset( $theme_object->$property ) ? $theme_object->$property : '';

	return apply_filters( "thds_get_wporg_theme_{$property}", $data, $theme_id );
}

/**
 * Prints the theme name.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_wporg_theme_name( $theme_id = 0 ) {

	echo esc_html( thds_get_wporg_theme_name( $theme_id ) );
}

/**
 * Returns the theme name.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_wporg_theme_name( $theme_id = 0 ) {

	return thds_get_wporg_theme_property( $theme_id, 'name' );
}

/**
 * Prints the theme version.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_wporg_theme_version( $theme_id = 0 ) {

	echo esc_html( thds_get_wporg_theme_version( $theme_id ) );
}

/**
 * Returns the theme version.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_wporg_theme_version( $theme_id = 0 ) {

	return thds_get_wporg_theme_property( $theme_id, 'version' );
}

/**
 * Prints the theme preview URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_wporg_theme_preview_url( $theme_id = 0 ) {

	echo esc_url( thds_get_wporg_theme_preview_url( $theme_id ) );
}

/**
 * Returns the theme preview URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_wporg_theme_preview_url( $theme_id = 0 ) {

	return thds_get_wporg_theme_property( $theme_id, 'preview_url' );
}

/**
 * Prints the theme author (WordPress.org username).
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_wporg_theme_author( $theme_id = 0 ) {

	echo esc_html( thds_get_wporg_theme_author( $theme_id ) );
}

/**
 * Returns the theme author's WordPress.org username.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_wporg_theme_author( $theme_id = 0 ) {

	return thds_get_wporg_theme_property( $theme_id, 'author' );
}

/**
 * Prints the theme author's themes URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_wporg_theme_author_themes_url( $theme_id = 0 ) {

	echo esc_url( thds_get_wporg_theme_author_themes_url( $theme_id ) );
}

/**
 * Returns the theme author's themes URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_wporg_theme_author_themes_url( $theme_id = 0 ) {

	$author = thds_get_wporg_theme_author( $theme_id );

	return $author ? "https://wordpress.org/themes/author/{$author}" : '';
}

/**
 * Prints the theme author's profile URL
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_wporg_theme_author_profile_url( $theme_id = 0 ) {

	echo esc_url( thds_get_wporg_theme_author_profile_url( $theme_id ) );
}

/**
 * Returns the theme author's WordPress.org profile URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_wporg_theme_author_profile_url( $theme_id = 0 ) {

	$author = thds_get_wporg_theme_author( $theme_id );

	return $author ? "https://profiles.wordpress.org/{$author}" : '';
}

/**
 * Prints the theme screenshot URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_wporg_theme_screenshot_url( $theme_id = 0 ) {

	echo esc_html( thds_get_wporg_theme_screenshot_url( $theme_id ) );
}

/**
 * Returns the theme screenshot URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_wporg_theme_screenshot_url( $theme_id = 0 ) {

	return thds_get_wporg_theme_property( $theme_id, 'screenshot_url' );
}

/**
 * Prints the theme rating.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_wporg_theme_rating( $theme_id = 0 ) {

	echo absint( thds_get_wporg_theme_rating( $theme_id ) );
}

/**
 * Returns the theme rating.  This is the total ratings count.  To get the
 * actual rating, divide by 5.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return int
 */
function thds_get_wporg_theme_rating( $theme_id = 0 ) {

	return thds_get_wporg_theme_property( $theme_id, 'rating' );
}

/**
 * Prints the number of theme ratings.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_wporg_theme_num_ratings( $theme_id = 0 ) {

	echo esc_html( thds_get_wporg_theme_num_ratings( $theme_id ) );
}

/**
 * Returns the number of ratings a theme has.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return int
 */
function thds_get_wporg_theme_num_ratings( $theme_id = 0 ) {

	return thds_get_wporg_theme_property( $theme_id, 'num_ratings' );
}

/**
 * Prints the theme download count.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_wporg_theme_downloaded( $theme_id = 0 ) {

	echo number_format_i18n( thds_get_wporg_theme_downloaded( $theme_id ) );
}

/**
 * Returns the theme download count.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return int
 */
function thds_get_wporg_theme_downloaded( $theme_id = 0 ) {

	return thds_get_wporg_theme_property( $theme_id, 'downloaded' );
}

/**
 * Prints the theme install count.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_wporg_theme_active_installs( $theme_id = 0 ) {

	echo number_format_i18n( thds_get_wporg_theme_active_installs( $theme_id ) );
}

/**
 * Returns the theme install count.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return int
 */
function thds_get_wporg_theme_active_installs( $theme_id = 0 ) {

	return thds_get_wporg_theme_property( $theme_id, 'active_installs' );
}

/**
 * Prints the theme's last updated date.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_wporg_theme_last_updated( $theme_id = 0 ) {

	echo mysql2date( get_option( 'date_format' ), thds_get_wporg_theme_last_updated( $theme_id ), true );
}

/**
 * Returns the theme last updated date in the form of `YYYY-MM-DD`.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_wporg_theme_last_updated( $theme_id = 0 ) {

	return thds_get_wporg_theme_property( $theme_id, 'last_updated' );
}

/**
 * Prints the theme WordPress.org page URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_wporg_theme_homepage( $theme_id = 0 ) {

	echo esc_url( thds_get_wporg_theme_homepage( $theme_id ) );
}

/**
 * Returns the theme WordPress.org page URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_wporg_theme_homepage( $theme_id = 0 ) {

	return thds_get_wporg_theme_property( $theme_id, 'homepage' );
}

/**
 * Returns an array of sections.  Currently, this is only the `description` (key)
 * section with a value of the theme's description set in `style.css`.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return array
 */
function thds_get_wporg_theme_sections( $theme_id = 0 ) {

	return thds_get_wporg_theme_property( $theme_id, 'sections' );
}

/**
 * Prints the theme ZIP file URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_wporg_theme_download_link( $theme_id = 0 ) {

	echo esc_url( thds_get_wporg_theme_download_link( $theme_id ) );
}

/**
 * Returns the theme ZIP file URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_wporg_theme_download_link( $theme_id = 0 ) {

	return thds_get_wporg_theme_property( $theme_id, 'download_link' );
}

/**
 * Returns an array of theme tags in the form of tag (key) and human-readable name (value)
 * (e.g., `array( 'custom-background' => 'Custom Background' )`).
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return array
 */
function thds_get_wporg_theme_tags( $theme_id = 0 ) {

	return thds_get_wporg_theme_property( $theme_id, 'tags' );
}
