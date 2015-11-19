<?php

/**
 * Returns the theme ID (post ID).
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return int
 */
function thds_get_theme_id( $theme_id = 0 ) {

	return $theme_id ? absint( $theme_id ) : get_the_ID();
}

/* ====== Conditionals ====== */

/**
 * Checks if the post is a theme.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return bool
 */
function thds_is_theme( $theme_id = 0 ) {
	$theme_id = thds_get_theme_id( $theme_id );

	return apply_filters( 'thds_is_theme', thds_get_theme_post_type() === get_post_type( $theme_id ), $theme_id );
}

/**
 * Conditional check to see if a theme is sticky.
 *
 * @since  1.0.0
 * @access public
 * @param  int    $theme_id
 * @return bool
 */
function thds_is_theme_sticky( $theme_id = 0 ) {
	$theme_id = thds_get_theme_id( $theme_id );

	return apply_filters( 'thds_is_theme_sticky', in_array( $theme_id, thds_get_sticky_themes() ), $theme_id );
}

/**
 * Checks if viewing a single theme.
 *
 * @since  1.0.0
 * @access public
 * @param  mixed  $post
 * @return bool
 */
function thds_is_single_theme( $post = '' ) {

	$is_single = is_singular( thds_get_theme_post_type() );

	if ( $is_single && $post )
		$is_single = is_single( $post );

	return apply_filters( 'thds_is_single_theme', $is_single, $post );
}

/**
 * Checks if viewing the theme archive.
 *
 * @since  1.0.0
 * @access public
 * @return bool
 */
function thds_is_theme_archive() {

	return apply_filters( 'thds_is_theme_archive', is_post_type_archive( thds_get_theme_post_type() ) && ! thds_is_author() );
}

/**
 * Conditional check to see if a theme is a parent theme.
 *
 * @since  1.0.0
 * @access public
 * @param  int    $theme_id
 * @return bool
 */
function thds_is_parent_theme( $theme_id = 0 ) {

	$theme_id  = thds_get_theme_id( $theme_id );
	$parent_id = $theme_id ? get_post_field( 'post_parent', $theme_id ) : 0;

	return apply_filters( 'thds_is_parent_theme', 0 === absint( $parent_id ), $theme_id );
}

/**
 * Conditional check to see if a theme is a child theme.
 *
 * @since  1.0.0
 * @access public
 * @param  int    $theme_id
 * @return bool
 */
function thds_is_child_theme( $theme_id = 0 ) {

	$theme_id  = thds_get_theme_id( $theme_id );
	$parent_id = $theme_id ? get_post_field( 'post_parent', $theme_id ) : 0;

	return apply_filters( 'thds_is_child_theme', absint( $parent_id ) > 0, $theme_id );
}

/* ====== Wrapper Functions ====== */

/**
 * Displays the theme URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_theme_url( $theme_id = 0 ) {
	echo thds_get_theme_url( $theme_id );
}

/**
 * Returns the theme URL.  Wrapper function for `get_permalink()`.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_theme_url( $theme_id = 0 ) {
	$theme_id  = thds_get_theme_id( $theme_id );
	$theme_url = $theme_id ? get_permalink( $theme_id ) : '';

	return apply_filters( 'thds_get_theme_url', $theme_url, $theme_id );
}

/**
 * Displays the theme title.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_theme_title( $theme_id = 0 ) {
	echo thds_get_theme_title( $theme_id );
}

/**
 * Returns the theme title.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_theme_title( $theme_id = 0 ) {
	$theme_id = thds_get_theme_id( $theme_id );
	$title    = $theme_id ? get_post_field( 'post_title', $theme_id ) : '';

	return apply_filters( 'thds_get_theme_title', $title, $theme_id );
}

/**
 * Displays the theme content.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_theme_content( $theme_id = 0 ) {
	echo thds_get_theme_content( $theme_id );
}

/**
 * Returns the theme content.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $forum_id
 * @return string
 */
function thds_get_theme_content( $theme_id = 0 ) {
	$theme_id = thds_get_theme_id( $theme_id );
	$content  = $theme_id ? get_post_field( 'post_content', $theme_id, 'raw' ) : '';

	return apply_filters( 'thds_get_theme_content', $content, $theme_id );
}

/**
 * Displays the theme excerpt.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_theme_excerpt( $theme_id = 0 ) {
	echo thds_get_theme_excerpt( $theme_id );
}

/**
 * Returns the theme excerpt.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $forum_id
 * @return string
 */
function thds_get_theme_excerpt( $theme_id = 0 ) {
	$theme_id = thds_get_theme_id( $theme_id );
	$excerpt  = $theme_id ? get_post_field( 'post_excerpt', $theme_id, 'raw' ) : '';

	return apply_filters( 'thds_get_theme_excerpt', $excerpt, $theme_id );
}

/**
 * Displays the theme author ID.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_theme_author_id( $theme_id = 0 ) {
	echo thds_get_theme_author_id( $theme_id );
}

/**
 * Returns the theme autor ID.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return int
 */
function thds_get_theme_author_id( $theme_id = 0 ) {
	$theme_id  = thds_get_theme_id( $theme_id );
	$author_id = $theme_id ? get_post_field( 'post_author', $theme_id ) : 0;

	return apply_filters( 'thds_get_theme_author_id', absint( $author_id ), $theme_id );
}

/**
 * Displays the theme author.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_theme_author( $theme_id = 0 ) {
	echo thds_get_theme_author( $theme_id );
}

/**
 * Returns the theme author.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_theme_author( $theme_id = 0 ) {
	$theme_id     = thds_get_theme_id( $theme_id );
	$author_id    = thds_get_theme_author_id( $theme_id );
	$theme_author = $author_id ? get_the_author_meta( 'display_name', $author_id ) : '';

	return apply_filters( 'thds_get_theme_author', $theme_author, $theme_id );
}

/**
 * Displays the theme author URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_theme_author_url( $theme_id = 0 ) {
	echo thds_get_theme_author_url( $theme_id );
}

/**
 * Returns the theme author URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_theme_author_url( $theme_id = 0 ) {
	$theme_id   = thds_get_theme_id( $theme_id );
	$author_id  = thds_get_theme_author_id( $theme_id );
	$author_url = $author_id ? thds_get_author_url( $author_id ) : '';

	return apply_filters( 'thds_get_theme_author_url', $author_url, $theme_id );
}

/**
 * Displays the theme author link.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_theme_author_link( $theme_id = 0 ) {
	echo thds_get_theme_author_link( $theme_id );
}

/**
 * Returns the theme author link.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_theme_author_link( $theme_id = 0 ) {
	$theme_id     = thds_get_theme_id( $theme_id );
	$theme_author = thds_get_theme_author( $theme_id );
	$author_url   = thds_get_theme_author_url( $theme_id );
	$author_link  = $author_url ? sprintf( '<a class="thds-theme-author-link" href="%s">%s</a>', $author_url, $theme_author ) : '';

	return apply_filters( 'thds_get_theme_author_link', $author_link, $theme_id );
}

/* ====== Meta ====== */

/**
 * Prints the theme version number.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_theme_version( $theme_id = 0 ) {

	echo thds_get_theme_version( $theme_id );
}

/**
 * Returns the theme version number.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_get_theme_version( $theme_id = 0 ) {

	$theme_id = thds_get_theme_id( $theme_id );

	return apply_filters( 'thds_get_theme_version', thds_get_theme_meta( $theme_id, 'version' ), $theme_id );
}

/**
 * Prints the theme download URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void.
 */
function thds_theme_download_url( $theme_id = 0 ) {

	echo esc_url( thds_get_theme_download_url( $theme_id ) );
}

/**
 * Returns the theme download URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_theme_download_url( $theme_id = 0 ) {

	$theme_id = thds_get_theme_id( $theme_id );

	return apply_filters( 'thds_get_theme_download_url', thds_get_theme_meta( $theme_id, 'download_url' ), $theme_id );
}

/**
 * Prints the theme demo URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_theme_demo_url( $theme_id = 0 ) {

	echo esc_url( thds_get_theme_demo_url( $theme_id ) );
}

/**
 * Returns the theme demo URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_theme_demo_url( $theme_id = 0 ) {

	$theme_id = thds_get_theme_id( $theme_id );

	return apply_filters( 'thds_get_theme_demo_url', thds_get_theme_meta( $theme_id, 'demo_url' ), $theme_id );
}

/**
 * Prints the theme repository URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_theme_repo_url( $theme_id = 0 ) {

	echo esc_url( thds_get_theme_repo_url( $theme_id ) );
}

/**
 * Returns the theme repository URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_theme_repo_url( $theme_id = 0 ) {

	$theme_id = thds_get_theme_id( $theme_id );

	return apply_filters( 'thds_get_theme_repo_url', thds_get_theme_meta( $theme_id, 'repo_url' ), $theme_id );
}

/**
 * Prints the theme purchasae URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_theme_purchase_url( $theme_id = 0 ) {

	echo esc_url( thds_get_theme_purchase_url( $theme_id ) );
}

/**
 * Returns the theme purchase URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_theme_purchase_url( $theme_id = 0 ) {

	$theme_id = thds_get_theme_id( $theme_id );

	return apply_filters( 'thds_get_theme_purchase_url', thds_get_theme_meta( $theme_id, 'purchase_url' ), $theme_id );
}

/**
 * Prints the theme support URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_theme_support_url( $theme_id = 0 ) {

	echo esc_url( thds_get_theme_support_url( $theme_id ) );
}

/**
 * Returns the theme support URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_theme_support_url( $theme_id = 0 ) {

	$theme_id = thds_get_theme_id( $theme_id );

	return apply_filters( 'thds_get_theme_support_url', thds_get_theme_meta( $theme_id, 'support_url' ), $theme_id );
}

/**
 * Prints the theme translation URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_theme_translate_url( $theme_id = 0 ) {

	echo esc_url( thds_get_theme_translate_url( $theme_id ) );
}

/**
 * Returns the theme translation URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_theme_translate_url( $theme_id = 0 ) {

	$theme_id = thds_get_theme_id( $theme_id );

	return apply_filters( 'thds_get_theme_translate_url', thds_get_theme_meta( $theme_id, 'translate_url' ), $theme_id );
}

/**
 * Prints the theme documentation URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_theme_docs_url( $theme_id = 0 ) {

	echo esc_url( thds_get_theme_docs_url( $theme_id ) );
}

/**
 * Returns the theme documentation URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_theme_docs_url( $theme_id = 0 ) {

	$theme_id = thds_get_theme_id( $theme_id );

	return apply_filters( 'thds_get_theme_docs_url', thds_get_theme_meta( $theme_id, 'docs_url' ), $theme_id );
}

/**
 * Prints the theme WordPress.org slug.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_theme_wporg_slug( $theme_id = 0 ) {

	echo thds_get_theme_wporg_slug( $theme_id );
}

/**
 * Returns the theme WordPress.org slug.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return string
 */
function thds_get_theme_wporg_slug( $theme_id = 0 ) {

	$theme_id = thds_get_theme_id( $theme_id );

	return apply_filters( 'thds_get_theme_wporg_slug', thds_get_theme_meta( $theme_id, 'wporg_slug' ), $theme_id );
}

/**
 * Prints the theme download count.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_theme_download_count( $theme_id = 0 ) {

	echo number_format_i8n( absint( thds_get_theme_download_count( $theme_id ) ) );
}

/**
 * Returns the theme download count.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return int
 */
function thds_get_theme_download_count( $theme_id = 0 ) {

	$theme_id = thds_get_theme_id( $theme_id );

	return apply_filters( 'thds_get_theme_download_count', absint( thds_get_theme_meta( $theme_id, 'download_count' ) ), $theme_id );
}

/**
 * Prints the theme rating.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_theme_rating( $theme_id = 0 ) {

	echo thds_get_theme_rating( $theme_id );
}

/**
 * Returns the theme rating.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return float
 */
function thds_get_theme_rating( $theme_id = 0 ) {

	$theme_id = thds_get_theme_id( $theme_id );

	return apply_filters( 'thds_get_theme_rating', floatval( thds_get_theme_meta( $theme_id, 'rating' ) ), $theme_id );
}

/**
 * Prints the theme rating count.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_theme_rating_count( $theme_id = 0 ) {

	echo number_format_i18n( thds_get_theme_rating_count( $theme_id ) );
}

/**
 * Returns the theme rating count.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return int
 */
function thds_get_theme_rating_count( $theme_id = 0 ) {

	$theme_id = thds_get_theme_id( $theme_id );

	return apply_filters( 'thds_get_theme_rating_count', absint( thds_get_theme_meta( $theme_id, 'rating_count' ) ), $theme_id );
}
