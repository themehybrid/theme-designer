<?php
/**
 * Registers custom shortcodes.
 *
 * @package    ThemeDesigner
 * @subpackage Core
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/theme-designer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Register shortcodes.
add_action( 'init', 'thds_register_shortcodes' );

/**
 * Register shortcodes for the plugin.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function thds_register_shortcodes() {

	// Theme shortcodes.
	add_shortcode( 'thds_theme_title',          'thds_theme_title_shortcode'          );
	add_shortcode( 'thds_theme_author',         'thds_theme_author_shortcode'         );
	add_shortcode( 'thds_theme_author_link',    'thds_theme_author_link_shortcode'    );
	add_shortcode( 'thds_theme_version',        'thds_theme_version_shortcode'        );
	add_shortcode( 'thds_theme_download_link',  'thds_theme_download_link_shortcode'  );
	add_shortcode( 'thds_theme_demo_link',      'thds_theme_demo_link_shortcode'      );
	add_shortcode( 'thds_theme_repo_link',      'thds_theme_repo_link_shortcode'      );
	add_shortcode( 'thds_theme_purchase_link',  'thds_theme_purchase_link_shortcode'  );
	add_shortcode( 'thds_theme_support_link',   'thds_theme_support_link_shortcode'   );
	add_shortcode( 'thds_theme_translate_link', 'thds_theme_translate_link_shortcode' );
	add_shortcode( 'thds_theme_docs_link',      'thds_theme_docs_link_shortcode'      );
}

/**
 * Callback function for the `[thds_theme_title]` shortcode.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $attr
 * @param  string $content
 * @param  string $shortcode
 * @return string
 */
function thds_theme_title_shortcode( $attr = array(), $content = null, $shortcode = '' ) {

	$attr = shortcode_atts( array( 'theme_id' => thds_get_theme_id() ), $attr, $shortcode );

	return get_the_title( $attr['theme_id'] );
}

/**
 * Callback function for the `[thds_theme_author]` shortcode.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $attr
 * @param  string $content
 * @param  string $shortcode
 * @return string
 */
function thds_theme_author_shortcode( $attr = array(), $content = null, $shortcode = '' ) {

	$attr = shortcode_atts( array( 'theme_id' => thds_get_theme_id() ), $attr, $shortcode );

	return thds_get_theme_author( $attr['theme_id'] );
}

/**
 * Callback function for the `[thds_theme_author_link]` shortcode.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $attr
 * @param  string $content
 * @param  string $shortcode
 * @return string
 */
function thds_theme_author_link_shortcode( $attr = array(), $content = null, $shortcode = '' ) {

	$attr = shortcode_atts( array( 'theme_id' => thds_get_theme_id() ), $attr, $shortcode );

	return thds_get_theme_author_link( $attr['theme_id'] );
}

/**
 * Callback function for the `[thds_theme_version]` shortcode.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $attr
 * @param  string $content
 * @param  string $shortcode
 * @return string
 */
function thds_theme_version_shortcode( $attr = array(), $content = null, $shortcode = '' ) {

	$attr = shortcode_atts( array( 'theme_id' => thds_get_theme_id() ), $attr, $shortcode );

	return thds_get_theme_version( $attr['theme_id'] );
}

/**
 * Callback function for the `[thds_theme_download_link]` shortcode.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $attr
 * @param  string $content
 * @param  string $shortcode
 * @return string
 */
function thds_theme_download_link_shortcode( $attr = array(), $content = null, $shortcode = '' ) {

	$attr = shortcode_atts(
		array( 'theme_id' => thds_get_theme_id(), 'text' => __( 'Download', 'theme-designer' ) ),
		$attr, $shortcode
	);

	return thds_get_theme_download_link( $attr );
}

/**
 * Callback function for the `[thds_theme_demo_link]` shortcode.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $attr
 * @param  string $content
 * @param  string $shortcode
 * @return string
 */
function thds_theme_demo_link_shortcode( $attr = array(), $content = null, $shortcode = '' ) {

	$attr = shortcode_atts(
		array( 'theme_id' => thds_get_theme_id(), 'text' => __( 'Demo', 'theme-designer' ) ),
		$attr, $shortcode
	);

	return thds_get_theme_demo_link( $attr );
}

/**
 * Callback function for the `[thds_theme_repo_link]` shortcode.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $attr
 * @param  string $content
 * @param  string $shortcode
 * @return string
 */
function thds_theme_repo_link_shortcode( $attr = array(), $content = null, $shortcode = '' ) {

	$attr = shortcode_atts(
		array( 'theme_id' => thds_get_theme_id(), 'text' => __( 'Repository', 'theme-designer' ) ),
		$attr, $shortcode
	);

	return thds_get_theme_repo_link( $attr );
}

/**
 * Callback function for the `[thds_theme_purchase_link]` shortcode.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $attr
 * @param  string $content
 * @param  string $shortcode
 * @return string
 */
function thds_theme_purchase_link_shortcode( $attr = array(), $content = null, $shortcode = '' ) {

	$attr = shortcode_atts(
		array( 'theme_id' => thds_get_theme_id(), 'text' => __( 'Purchase', 'theme-designer' ) ),
		$attr, $shortcode
	);

	return thds_get_theme_purchase_link( $attr );
}

/**
 * Callback function for the `[thds_theme_support_link]` shortcode.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $attr
 * @param  string $content
 * @param  string $shortcode
 * @return string
 */
function thds_theme_support_link_shortcode( $attr = array(), $content = null, $shortcode = '' ) {

	$attr = shortcode_atts(
		array( 'theme_id' => thds_get_theme_id(), 'text' => __( 'Support', 'theme-designer' ) ),
		$attr, $shortcode
	);

	return thds_get_theme_support_link( $attr );
}

/**
 * Callback function for the `[thds_theme_translate_link]` shortcode.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $attr
 * @param  string $content
 * @param  string $shortcode
 * @return string
 */
function thds_theme_translate_link_shortcode( $attr = array(), $content = null, $shortcode = '' ) {

	$attr = shortcode_atts(
		array( 'theme_id' => thds_get_theme_id(), 'text' => __( 'Translations', 'theme-designer' ) ),
		$attr, $shortcode
	);

	return thds_get_theme_translate_link( $attr );
}

/**
 * Callback function for the `[thds_theme_docs_link]` shortcode.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $attr
 * @param  string $content
 * @param  string $shortcode
 * @return string
 */
function thds_theme_docs_link_shortcode( $attr = array(), $content = null, $shortcode = '' ) {

	$attr = shortcode_atts(
		array( 'theme_id' => thds_get_theme_id(), 'text' => __( 'Docs', 'theme-designer' ) ),
		$attr, $shortcode
	);

	return thds_get_theme_docs_link( $attr );
}
