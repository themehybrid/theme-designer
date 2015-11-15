<?php

# Register meta on the 'init' hook.
add_action( 'init', 'thds_register_meta' );

/**
 * Registers custom metadata for the plugin.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function thds_register_meta() {

	// URLs.
	register_meta( 'post', 'download_url',  'esc_url_raw', '__return_false' );
	register_meta( 'post', 'demo_url',      'esc_url_raw', '__return_false' );
	register_meta( 'post', 'repo_url',      'esc_url_raw', '__return_false' );
	register_meta( 'post', 'purchase_url',  'esc_url_raw', '__return_false' );
	register_meta( 'post', 'support_url',   'esc_url_raw', '__return_false' );
	register_meta( 'post', 'docs_url',      'esc_url_raw', '__return_false' );
	register_meta( 'post', 'translate_url', 'esc_url_raw', '__return_false' );

	// Child themes.
	register_meta( 'post', 'parent_theme_id',    'absint', '__return_false' ); // back-compat - use post_parent
	register_meta( 'post', 'sample_child_theme', 'absint', '__return_false' );

	// Other data.
	register_meta( 'post', 'wporg_slug',      'sanitize_title_with_dashes', '__return_false' );
	//register_meta( 'post', 'github_slug',     'strip_tags',                 '__return_false' );
	register_meta( 'post', 'version',         'wp_filter_no_html_kses',                     '__return_false' );
	register_meta( 'post', 'download_count',  'absint',                     '__return_false' );
	//register_meta( 'post', 'edd_download_id', 'absint',                     '__return_false' );
}

/**
 * Returns theme metadata.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @param  string  $meta_key
 * @return mixed
 */
function thds_get_theme_meta( $post_id, $meta_key ) {

	return get_post_meta( $post_id, $meta_key, true );
}

/**
 * Adds/updates theme metadata.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @param  string  $meta_key
 * @param  mixed   $meta_value
 * @return bool
 */
function thds_set_theme_meta( $post_id, $meta_key, $meta_value ) {

	return update_post_meta( $post_id, $meta_key, $meta_value );
}

/**
 * Deletes theme metadata.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @param  string  $meta_key
 * @return mixed
 */
function thds_delete_theme_meta( $post_id, $meta_key ) {

	return delete_post_meta( $post_id, $meta_key );
}
