<?php
/**
 * WordPress.org theme integration theme object class.
 *
 * @package    ThemeDesigner
 * @subpackage WPORG
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/theme-designer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Creates new WPorg theme objects.
 *
 * @since  1.0.0
 * @access public
 */
class THDS_WPORG_Theme {

	/**
	 * Arguments for creating the theme object.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    array
	 */
	protected $args = array();

	/* ====== Magic Methods ====== */

	/**
	 * Magic method for getting theme object properties.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $property
	 * @return mixed
	 */
	public function __get( $property ) {

		return isset( $this->$property ) ? $this->args[ $property ] : null;
	}

	/**
	 * Magic method for setting theme object properties.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $property
	 * @param  mixed   $value
	 * @return void
	 */
	public function __set( $property, $value ) {

		if ( isset( $this->$property ) )
			$this->args[ $property ] = $value;
	}

	/**
	 * Magic method for checking if a theme property is set.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $property
	 * @return bool
	 */
	public function __isset( $property ) {

		return isset( $this->args[ $property ] );
	}

	/**
	 * Don't allow properties to be unset.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $property
	 * @return void
	 */
	public function __unset( $property ) {}

	/**
	 * Magic method to use in case someone tries to output the theme object as a string.
	 * We'll just return the theme name.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function __toString() {
		return $this->name;
	}

	/**
	 * Register a new theme object
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $slug
	 * @return void
	 */
	public function __construct( $theme_id ) {

		// Get the theme's WordPress.org slug.
		$slug = thds_get_theme_wporg_slug( $theme_id );

		// Bail if there's no slug.
		if ( ! $slug )
			return;

		// Get the transient based on the theme slug.
		$api = get_transient( "thds_wporg_{$slug}" );

		// If there's no transient, we need to get the data from the WP Themes API.
		if ( ! $api ) {

			// If `themes_api()` isn't available, load the file that holds the function
			if ( ! function_exists( 'themes_api' ) && file_exists( trailingslashit( ABSPATH ) . 'wp-admin/includes/theme.php' ) )
				require_once( trailingslashit( ABSPATH ) . 'wp-admin/includes/theme.php' );

			// Make sure the function exists.
			if ( function_exists( 'themes_api' ) ) {

				$fields = array(
					'description'     => true,
					'sections'        => true,
					'rating'          => true,
					'ratings'         => false,
					'downloaded'      => true,
					'downloadlink'    => true,
					'last_updated'    => true,
					'homepage'        => true,
					'tags'            => true,
					'template'        => true,
					'parent'          => true,
					'versions'        => false,
					'screenshot_url'  => true,
					'active_installs' => true
				);

				// @link https://codex.wordpress.org/WordPress.org_API#Theme_Information
				$fields = apply_filters( 'thds_wporg_themes_api_fields', $fields, $theme_id, $slug );

				// Get the theme info from WordPress.org.
				$api = themes_api( 'theme_information', array( 'slug' => $slug, 'fields' => $fields ) );

				// If no error, let's roll.
				if ( ! is_wp_error( $api ) ) {

					// If this is an array, let's make it an object.
					if ( is_array( $api ) )
						$api = (object) $api;

					// Only proceed if we have an object.
					if ( is_object( $api ) ) {

						// Set the transient with the new data.
						set_transient( "thds_wporg_{$slug}", $api, thds_get_wporg_transient_expiration() );

						// Back up download count as post meta.
						if ( isset( $api->downloaded ) )
							thds_set_theme_meta( $theme_id, 'download_count', absint( $api->downloaded ) );

						// Back up install count as post meta.
						if ( isset( $api->active_installs ) )
							thds_set_theme_meta( $theme_id, 'install_count', absint( $api->active_installs ) );

						// Back up ratings as post meta.
						if ( isset( $api->rating ) && isset( $api->num_ratings ) ) {

							$rating = round( ( absint( $api->rating ) / 100 ) * 5, 2 );

							thds_set_theme_meta( $theme_id, 'rating', $rating );
							thds_set_theme_meta( $theme_id, 'rating_count', absint( $api->num_ratings ) );
						}
					}
				}
			}
		}

		// If we have data, let's assign its keys to our theme object properties.
		if ( $api && is_object( $api ) && ! is_wp_error( $api ) ) {

			foreach ( $api as $key => $value )
				$this->args[ $key ] = $value;
		}
	}
}
