<?php
/**
 * Feature template tags.
 *
 * @package    ThemeDesigner
 * @subpackage Template
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/theme-designer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Conditional tag to check if viewing a feature archive.
 *
 * @since  1.0.0
 * @access public
 * @param  mixed  $term
 * @return bool
 */
function thds_is_feature( $term = '' ) {

	return apply_filters( 'thds_is_feature', is_tax( thds_get_feature_taxonomy(), $term ) );
}

