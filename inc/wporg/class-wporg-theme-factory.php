<?php
/**
 * WordPress.org theme integration theme factory class.
 *
 * @package    ThemeDesigner
 * @subpackage WPORG
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/theme-designer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * WPorg Theme Factory class.
 *
 * @since  1.0.0
 * @access public
 */
class THDS_WPORG_Theme_Factory {

	/**
	 * Array of theme objects.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    array
	 */
	public $themes = array();

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Register a new theme object
	 *
	 * @see    THDS_WPORG_Theme::__construct()
	 * @since  1.0.0
	 * @access public
	 * @param  int     $theme_id
	 * @return void
	 */
	public function register( $theme_id ) {

		if ( ! $this->exists( $theme_id ) ) {

			$theme = new THDS_WPORG_Theme( $theme_id );

			$this->themes[ $theme_id ] = $theme;
		}
	}

	/**
	 * Unregisters a theme object.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  int     $theme_id
	 * @return void
	 */
	public function unregister( $theme_id ) {

		if ( $this->exists( $theme_id ) )
			unset( $this->themes[ $theme_id ] );
	}

	/**
	 * Checks if a theme exists.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  int     $theme_id
	 * @return bool
	 */
	public function exists( $theme_id ) {

		return isset( $this->themes[ $theme_id ] );
	}

	/**
	 * Gets a theme object.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  int     $theme_id
	 * @return object|bool
	 */
	public function get( $theme_id ) {

		return $this->exists( $theme_id ) ? $this->themes[ $theme_id ] : false;
	}

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) )
			$instance = new self;

		return $instance;
	}
}
