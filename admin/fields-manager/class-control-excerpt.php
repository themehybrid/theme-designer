<?php
/**
 * Excerpt control class for the fields manager.
 *
 * @package    FieldsManager
 * @subpackage Admin
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/custom-content-portfolio
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Excerpt control class.
 *
 * @since  1.0.0
 * @access public
 */
class THDS_Fields_Control_Excerpt extends THDS_Fields_Control {

	public function get_value( $post_id ) {
		return get_post( $post_id )->post_excerpt;
	}
}
