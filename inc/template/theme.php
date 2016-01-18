<?php
/**
 * Theme template tags.
 *
 * @package    ThemeDesigner
 * @subpackage Template
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015, Justin Tadlock
 * @link       http://themehybrid.com/plugins/theme-designer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

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
	$parent_id = $theme_id ? thds_get_parent_theme_id( $theme_id ) : 0;

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
	$parent_id = $theme_id ? thds_get_parent_theme_id( $theme_id ) : 0;

	return apply_filters( 'thds_is_child_theme', absint( $parent_id ) > 0, $theme_id );
}

/**
 * Conditional check to see if a theme is hosted on GitHub (requires a repo URL).
 *
 * @since  1.0.0
 * @access public
 * @param  int    $theme_id
 * @return bool
 */
function thds_is_theme_on_github( $theme_id = 0 ) {

	$theme_id  = thds_get_theme_id( $theme_id );
	$repo_url  = thds_get_theme_repo_url( $theme_id );

	return $repo_url && false !== strpos( $repo_url, 'github.com' );
}

/**
 * Conditional check to see if a theme is hosted on BitBucket (requires a repo URL).
 *
 * @since  1.0.0
 * @access public
 * @param  int    $theme_id
 * @return bool
 */
function thds_is_theme_on_bitbucket( $theme_id = 0 ) {

	$theme_id  = thds_get_theme_id( $theme_id );
	$repo_url  = thds_get_theme_repo_url( $theme_id );

	return $repo_url && false !== strpos( $repo_url, 'bitbucket.com' );
}

/* ====== Wrapper Functions ====== */

/**
 * Prints the theme archive URL.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function thds_theme_archive_url() {

	echo esc_url( thds_get_theme_archive_url() );
}

/**
 * Returns the theme archive URL.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function thds_get_theme_archive_url() {

	return apply_filters( 'thds_get_theme_archive_url', get_post_type_archive_link( thds_get_theme_post_type() ) );
}

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

/* ====== Parent Theme ====== */

/**
 * Returns the parent theme ID.
 *
 * @since  1.0.0
 * @access public
 * @param  int    $theme_id
 * @return int
 */
function thds_get_parent_theme_id( $theme_id = 0 ) {
	$theme_id  = thds_get_theme_id( $theme_id );
	$parent_id = $theme_id ? get_post_field( 'post_parent', $theme_id ) : 0;

	return apply_filters( 'thds_get_parent_theme_id', $parent_id, $theme_id );
}

/**
 * Returns the parent theme `WP_POST` object if there's a parent. Else, returns `false`.
 *
 * @since  1.0.0
 * @access public
 * @param  int    $theme_id
 * @return object|false
 */
function thds_get_parent_theme( $theme_id = 0 ) {
	$theme_id  = thds_get_theme_id( $theme_id );
	$parent_id = thds_get_parent_theme_id( $theme_id );
	$parent    = 0 < $parent_id ? get_post( $theme_id ) : false;

	return apply_filters( 'thds_get_parent_theme_id', $parent, $theme_id );
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
 * Prints the theme download link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function thds_theme_download_link( $args = array() ) {

	echo thds_get_theme_download_link( $args );
}

/**
 * Returns the theme download link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function thds_get_theme_download_link( $args = array() ) {

	$defaults = array(
		'theme_id' => thds_get_theme_id(),
		'text'     => __( 'Download', 'theme-designer' )
	);

	$args = wp_parse_args( $args, $defaults );

	$url = thds_get_theme_download_url( $args['theme_id'] );

	$link = $url ? sprintf( '<a class="thds-theme-download-link" href="%s">%s</a>', esc_url( $url ), $args['text'] ) : '';

	return apply_filters( 'thds_get_theme_download_link', $link, $args );
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
 * Prints the theme demo link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function thds_theme_demo_link( $args = array() ) {

	echo thds_get_theme_demo_link( $args );
}

/**
 * Returns the theme demo link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function thds_get_theme_demo_link( $args = array() ) {

	$defaults = array(
		'theme_id' => thds_get_theme_id(),
		'text'     => __( 'Demo', 'theme-designer' )
	);

	$args = wp_parse_args( $args, $defaults );

	$url = thds_get_theme_demo_url( $args['theme_id'] );

	$link = $url ? sprintf( '<a class="thds-theme-demo-link" href="%s">%s</a>', esc_url( $url ), $args['text'] ) : '';

	return apply_filters( 'thds_get_theme_demo_link', $link, $args );
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
 * Prints the theme repo link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function thds_theme_repo_link( $args = array() ) {

	echo thds_get_theme_repo_link( $args );
}

/**
 * Returns the theme repo link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function thds_get_theme_repo_link( $args = array() ) {

	$defaults = array(
		'theme_id' => thds_get_theme_id(),
		'text'     => __( 'Repository', 'theme-designer' )
	);

	$args = wp_parse_args( $args, $defaults );

	$url = thds_get_theme_repo_url( $args['theme_id'] );

	$link = $url ? sprintf( '<a class="thds-theme-repo-link" href="%s">%s</a>', esc_url( $url ), $args['text'] ) : '';

	return apply_filters( 'thds_get_theme_repo_link', $link, $args );
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
 * Prints the theme purchase link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function thds_theme_purchase_link( $args = array() ) {

	echo thds_get_theme_purchase_link( $args );
}

/**
 * Returns the theme purchase link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function thds_get_theme_purchase_link( $args = array() ) {

	$defaults = array(
		'theme_id' => thds_get_theme_id(),
		'text'     => __( 'Purchase', 'theme-designer' )
	);

	$args = wp_parse_args( $args, $defaults );

	$url = thds_get_theme_purchase_url( $args['theme_id'] );

	$link = $url ? sprintf( '<a class="thds-theme-purchase-link" href="%s">%s</a>', esc_url( $url ), $args['text'] ) : '';

	return apply_filters( 'thds_get_theme_purchase_link', $link, $args );
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
 * Prints the theme support link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function thds_theme_support_link( $args = array() ) {

	echo thds_get_theme_support_link( $args );
}

/**
 * Returns the theme support link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function thds_get_theme_support_link( $args = array() ) {

	$defaults = array(
		'theme_id' => thds_get_theme_id(),
		'text'     => __( 'Support', 'theme-designer' )
	);

	$args = wp_parse_args( $args, $defaults );

	$url = thds_get_theme_support_url( $args['theme_id'] );

	$link = $url ? sprintf( '<a class="thds-theme-support-link" href="%s">%s</a>', esc_url( $url ), $args['text'] ) : '';

	return apply_filters( 'thds_get_theme_support_link', $link, $args );
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
 * Prints the theme translate link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function thds_theme_translate_link( $args = array() ) {

	echo thds_get_theme_translate_link( $args );
}

/**
 * Returns the theme translate link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function thds_get_theme_translate_link( $args = array() ) {

	$defaults = array(
		'theme_id' => thds_get_theme_id(),
		'text'     => __( 'Translations', 'theme-designer' )
	);

	$args = wp_parse_args( $args, $defaults );

	$url = thds_get_theme_translate_url( $args['theme_id'] );

	$link = $url ? sprintf( '<a class="thds-theme-translate-link" href="%s">%s</a>', esc_url( $url ), $args['text'] ) : '';

	return apply_filters( 'thds_get_theme_translate_link', $link, $args );
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
 * Prints the theme docs link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function thds_theme_docs_link( $args = array() ) {

	echo thds_get_theme_docs_link( $args );
}

/**
 * Returns the theme docs link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function thds_get_theme_docs_link( $args = array() ) {

	$defaults = array(
		'theme_id' => thds_get_theme_id(),
		'text'     => __( 'Documentation', 'theme-designer' )
	);

	$args = wp_parse_args( $args, $defaults );

	$url = thds_get_theme_docs_url( $args['theme_id'] );

	$link = $url ? sprintf( '<a class="thds-theme-docs-link" href="%s">%s</a>', esc_url( $url ), $args['text'] ) : '';

	return apply_filters( 'thds_get_theme_docs_link', $link, $args );
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

	echo number_format_i18n( absint( thds_get_theme_download_count( $theme_id ) ) );
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
 * Prints the theme install count.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return void
 */
function thds_theme_install_count( $theme_id = 0 ) {

	// Translators: Approximate count. The %s is a number.  The + means "more than."
	echo sprintf( __( '%s+', 'theme-designer' ), number_format_i18n( absint( thds_get_theme_install_count( $theme_id ) ) ) );
}

/**
 * Returns the theme install count.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $theme_id
 * @return int
 */
function thds_get_theme_install_count( $theme_id = 0 ) {

	$theme_id = thds_get_theme_id( $theme_id );

	return apply_filters( 'thds_get_theme_install_count', absint( thds_get_theme_meta( $theme_id, 'install_count' ) ), $theme_id );
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
