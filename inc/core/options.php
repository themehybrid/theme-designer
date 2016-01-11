<?php
/**
 * Functions for handling plugin options.
 *
 * @package    ThemeDesigner
 * @subpackage Core
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015, Justin Tadlock
 * @link       http://themehybrid.com/plugins/theme-designer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Returns the menu title.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function thds_get_menu_title() {
	return apply_filters( 'thds_get_menu_title', thds_get_setting( 'menu_title' ) );
}

/**
 * Returns the archive title.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function thds_get_archive_title() {
	return apply_filters( 'thds_get_archive_title', thds_get_setting( 'archive_title' ) );
}

/**
 * Returns the archive description.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function thds_get_archive_description() {
	return apply_filters( 'thds_get_archive_description', thds_get_setting( 'archive_description' ) );
}

/**
 * Returns the rewrite base. Used for the theme archive and as a prefix for taxonomy,
 * author, and any other slugs.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function thds_get_rewrite_base() {
	return apply_filters( 'thds_get_rewrite_base', thds_get_setting( 'rewrite_base' ) );
}

/**
 * Returns the theme rewrite base. Used for single themes.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function thds_get_theme_rewrite_base() {
	return apply_filters( 'thds_get_theme_rewrite_base', thds_get_setting( 'theme_rewrite_base' ) );
}

/**
 * Returns the subject rewrite base. Used for subject archives.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function thds_get_subject_rewrite_base() {
	return apply_filters( 'thds_get_subject_rewrite_base', thds_get_setting( 'subject_rewrite_base' ) );
}

/**
 * Returns the feature rewrite base. Used for feature archives.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function thds_get_feature_rewrite_base() {
	return apply_filters( 'thds_get_feature_rewrite_base', thds_get_setting( 'feature_rewrite_base' ) );
}

/**
 * Returns the author rewrite base. Used for author archives.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function thds_get_author_rewrite_base() {
	return apply_filters( 'thds_get_author_rewrite_base', thds_get_setting( 'author_rewrite_base' ) );
}

/**
 * Checks if we're integrating with WordPress.org.
 *
 * @since  1.0.0
 * @access public
 * @return bool
 */
function thds_use_wporg_api() {
	return apply_filters( 'thds_use_wporg_api', thds_get_setting( 'wporg_integration' ) );
}

/**
 * Returns the transient expiration time for WordPress.org theme integration.  The setting is
 * saved as days.  We multiply that by the `DAY_IN_SECONDS` constant.  The final value will
 * be days in seconds.
 *
 * @since  1.0.0
 * @access public
 * @return int
 */
function thds_get_wporg_transient_expiration() {

	return apply_filters( 'thds_get_wporg_transient_expiration', absint( thds_get_setting( 'wporg_transient' ) ) * DAY_IN_SECONDS );
}

/**
 * Returns the number of themes to show per page.
 *
 * @since  1.0.0
 * @access public
 * @return int
 */
function thds_get_themes_per_page() {

	return apply_filters( 'thds_get_themes_per_page', intval( thds_get_setting( 'themes_per_page' ) ) );
}

/**
 * Returns the field to order themes by.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function thds_get_themes_orderby() {

	return apply_filters( 'thds_get_themes_orderby', thds_get_setting( 'themes_orderby' ) );
}

/**
 * Returns the themes order.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function thds_get_themes_order() {

	return apply_filters( 'thds_get_themes_order', thds_get_setting( 'themes_order' ) );
}

/**
 * Returns the default subject term ID.
 *
 * @since  1.0.0
 * @access public
 * @return int
 */
function thds_get_default_subject() {
	return apply_filters( 'thds_get_default_subject', 0 );
}

/**
 * Returns the default feature term ID.
 *
 * @since  1.0.0
 * @access public
 * @return int
 */
function thds_get_default_feature() {
	return apply_filters( 'thds_get_default_feature', 0 );
}

/**
 * Returns a plugin setting.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $setting
 * @return mixed
 */
function thds_get_setting( $setting ) {

	$defaults = thds_get_default_settings();
	$settings = wp_parse_args( get_option( 'thds_settings', $defaults ), $defaults );

	return isset( $settings[ $setting ] ) ? $settings[ $setting ] : false;
}

/**
 * Returns the default settings for the plugin.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function thds_get_default_settings() {

	$settings = array(
		'menu_title'                 => __( 'Theme Designer', 'theme-designer' ),
		'archive_title'              => __( 'Themes', 'theme-designer' ),
		'archive_description'        => '',
		'rewrite_base'               => 'themes',
		'theme_rewrite_base'         => '',
		'subject_rewrite_base'       => 'subjects',
		'feature_rewrite_base'       => 'features',
		'author_rewrite_base'        => 'authors',
		'wporg_integration'          => true,
		'wporg_transient'            => 3, // days
		'themes_per_page'            => 10,
		'themes_orderby'             => 'date',
		'themes_order'               => 'DESC',
	);

	return $settings;
}
