<?php
/**
 * General template tags.
 *
 * @package    ThemeDesigner
 * @subpackage Template
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/theme-designer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Conditional tag to check if viewing any Theme Designer plugin page.
 *
 * @since  1.0.0
 * @access public
 * @param  mixed  $term
 * @return bool
 */
function thds_is_theme_designer() {

	$is_thds = thds_is_theme_archive() || thds_is_single_theme() || thds_is_author() || thds_is_subject() || thds_is_feature();

	return apply_filters( 'thds_is_theme_designer', $is_thds );
}

/**
 * Checks if viewing one of the available archive pages.
 *
 * @since  1.0.0
 * @access public
 * @return bool
 */
function thds_is_archive() {

	return apply_filters( 'thds_is_archive', is_archive() && thds_is_theme_designer() );
}
