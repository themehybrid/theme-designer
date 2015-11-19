<?php

# Template hierarchy.
add_filter( 'template_include', 'thds_template_include', 5 );

# Filter prior to getting posts from the DB.
add_action( 'pre_get_posts', 'thds_pre_get_posts' );

# Redirect non-authors.
add_action( 'template_redirect', 'thds_template_redirect', 5 );

# Filter the document title.
add_filter( 'document_title_parts', 'thds_document_title_parts', 5 );

# Filter the post type archive title.
add_filter( 'post_type_archive_title', 'thds_post_type_archive_title', 5, 2 );

# Filter the archive title and description.
add_filter( 'get_the_archive_title',       'thds_get_the_archive_title',       5 );
add_filter( 'get_the_archive_description', 'thds_get_the_archive_description', 5 );

# Filter the post type permalink.
add_filter( 'post_type_link', 'thds_post_type_link', 10, 2 );

# Filter the post author link.
add_filter( 'author_link', 'thds_author_link_filter', 10, 3 );

# Filter the post class.
add_filter( 'post_class', 'thds_post_class', 10, 3 );

# Force taxonomy term selection.
add_action( 'save_post', 'thds_force_term_selection' );

# Theme content filters.
add_filter( 'thds_get_theme_content', array( $GLOBALS['wp_embed'], 'run_shortcode' ), 5 );
add_filter( 'thds_get_theme_content', array( $GLOBALS['wp_embed'], 'autoembed'     ), 5 );
add_filter( 'thds_get_theme_content', 'wptexturize',                                  5 );
add_filter( 'thds_get_theme_content', 'convert_smilies',                              5 );
add_filter( 'thds_get_theme_content', 'convert_chars',                                5 );
add_filter( 'thds_get_theme_content', 'wpautop',                                      5 );
add_filter( 'thds_get_theme_content', 'shortcode_unautop',                            5 );
add_filter( 'thds_get_theme_content', 'do_shortcode',                                 5 );
add_filter( 'thds_get_theme_content', 'wp_make_content_images_responsive',            5 );

# Theme excerpt filters.
add_filter( 'thds_get_theme_excerpt', 'wptexturize',       5 );
add_filter( 'thds_get_theme_excerpt', 'convert_smilies',   5 );
add_filter( 'thds_get_theme_excerpt', 'convert_chars',     5 );
add_filter( 'thds_get_theme_excerpt', 'wpautop',           5 );
add_filter( 'thds_get_theme_excerpt', 'shortcode_unautop', 5 );
add_filter( 'thds_get_theme_content', 'do_shortcode',      5 );

/**
 * Basic top-level template hierarchy. I generally prefer to leave this functionality up to
 * themes.  This is just a foundation to build upon if needed.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $template
 * @return string
 */
function thds_template_include( $template ) {

	// Bail if not a theme page.
	if ( ! thds_is_theme_designer() )
		return $template;

	$templates = array();

	// Author archive.
	if ( thds_is_author() ) {
		$templates[] = 'theme-author.php';

	// Subject archive.
	} else if ( thds_is_subject() ) {
		$templates[] = 'theme-subject.php';

	// Feature archive.
	} else if ( thds_is_feature() ) {
		$templates[] = 'theme-feature.php';

	// Single theme.
	} else if ( thds_is_single_theme() ) {

		$post_template = get_post_meta( get_queried_object_id(), '_wp_theme_template', true );

		if ( '' === $post_template )
			$post_template = get_post_meta( get_queried_object_id(), 'template', true );

		if ( $post_template )
			$templates[] = $post_template;

		$templates[] = 'theme-single.php';
	}

	// Fallback template for all archive-type pages.
	if ( thds_is_archive() )
		$templates[] = 'theme-archive.php';

	// Fallback template.
	$templates[] = 'theme-designer.php';

	// Check if we have a template.
	$has_template = locate_template( apply_filters( 'thds_template_hierarchy', $templates ) );

	// Return the template.
	return $has_template ? $has_template : $template;
}

/**
 * Filter on `pre_get_posts` to alter the main query on theme pages.
 *
 * @since  1.0.0
 * @access public
 * @param  object  $query
 * @return void
 */
function thds_pre_get_posts( $query ) {

	if ( ! is_admin() && $query->is_main_query() && thds_is_archive() ) {

		// Back-compat with TH system.
		if ( get_option( 'th_sample_child_themes' ) )
			$query->set( 'post__not_in', get_option( 'th_sample_child_themes' ) );

		// Set the themes per page.
		$query->set( 'posts_per_page', thds_get_themes_per_page() );
		$query->set( 'orderby',        thds_get_themes_orderby()  );
		$query->set( 'order',          thds_get_themes_order()    );
	}
}

/**
 * Redirects author requests for users who have not published any themes to the
 * theme archive page.
 *
 * @since  1.0.0
 * @access public
 * @global object  $wp_the_query
 * @return void
 */
function thds_template_redirect() {
	global $wp_the_query;

	if ( thds_is_author() && 0 >= $wp_the_query->post_count ) {
		wp_redirect( esc_url_raw( thds_get_theme_archive_url() ) );
		exit();
	}
}

/**
 * Filter on `document_title_parts` (WP 4.4.0).
 *
 * @since  1.0.0
 * @access public
 * @param  array  $title
 * @return array
 */
function thds_document_title_parts( $title ) {

	if ( thds_is_author() )
		$title['title'] = thds_get_single_author_title();

	return $title;
}

/**
 * Filter on 'post_type_archive_title' to allow for the use of the 'archive_title' label that isn't supported
 * by WordPress.  That's okay since we can roll our own labels.
 *
 * @since  0.1.0
 * @access public
 * @param  string  $title
 * @param  string  $post_type
 * @return string
 */
function thds_post_type_archive_title( $title, $post_type ) {

	$theme_type = thds_get_theme_post_type();

	return $theme_type === $post_type ? get_post_type_object( $theme_type )->labels->archive_title : $title;
}

/**
 * Filters the archive title. Note that we need this additional filter because core WP does
 * things like add "Archives:" in front of the archive title.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $title
 * @return string
 */
function thds_get_the_archive_title( $title ) {

	if ( thds_is_author() )
		$title = thds_get_single_author_title();

	else if ( thds_is_theme_archive() )
		$title = post_type_archive_title( '', false );

	return $title;
}

/**
 * Filters the archive description.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $desc
 * @return string
 */
function thds_get_the_archive_description( $desc ) {

	if ( thds_is_author() )
		$desc = get_the_author_meta( 'description', get_query_var( 'author' ) );

	else if ( thds_is_theme_archive() && ! $desc )
		$desc = thds_get_archive_description();

	return $desc;
}

/**
 * Filter on `post_type_link` to make sure that single portfolio themes have the correct
 * permalink.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $post_link
 * @param  object  $post
 * @return string
 */
function thds_post_type_link( $post_link, $post ) {

	// Bail if this isn't a portfolio theme.
	if ( thds_get_theme_post_type() !== $post->post_type )
		return $post_link;

	$subject_taxonomy = thds_get_subject_taxonomy();

	$author = $subject = '';

	// Check for the subject.
	if ( false !== strpos( $post_link, "%{$subject_taxonomy}%" ) ) {

		// Get the terms.
		$terms = get_the_terms( $post, $subject_taxonomy );

		// Check that terms were returned.
		if ( $terms ) {

			usort( $terms, '_usort_terms_by_ID' );

			$subject = $terms[0]->slug;
		}
	}

	// Check for the author.
	if ( false !== strpos( $post_link, '%author%' ) ) {

		$authordata = get_userdata( $post->post_author );
		$author     = $authordata->user_nicename;
	}

	$rewrite_tags = array(
		"%{$subject_taxonomy}%",
		'%author%'
	);

	$map_tags = array(
		$subject,
		$author
	);

	return str_replace( $rewrite_tags, $map_tags, $post_link );
}

/**
 * Filter on `author_link` to change the URL when viewing a portfolio theme. The new link
 * should point to the portfolio author archive.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $url
 * @param  int     $author_id
 * @param  string  $nicename
 * @return string
 */
function thds_author_link_filter( $url, $author_id, $nicename ) {

	return thds_is_theme() ? thds_get_author_url( $author_id ) : $url;
}

/**
 * Filter the post class.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $classes
 * @param  string $class
 * @param  int    $post_id
 * @return array
 */
function thds_post_class( $classes, $class, $post_id ) {

	if ( thds_is_theme( $post_id ) && thds_is_theme_archive() && thds_is_theme_sticky( $post_id ) && ! is_paged() )
		$classes[] = 'sticky';

	return $classes;
}

/**
 * If a theme has `%portfolio_subject%` or `%portfolio_feature%` in its permalink structure,
 * it must have a term set for the taxonomy.  This function is a callback on `save_post`
 * that checks if a term is set.  If not, it forces the first term of the taxonomy to be
 * the selected term.
 *
 * @since  1.0.0
 * @access public
 * @param  int    $post_id
 * @return void
 */
function thds_force_term_selection( $post_id ) {

	if ( thds_is_theme( $post_id ) ) {

		$theme_base  = thds_get_theme_rewrite_base();
		$subject_tax = thds_get_subject_taxonomy();

		if ( false !== strpos( $theme_base, "%{$subject_tax}%" ) )
			thds_set_term_if_none( $post_id, $subject_tax, thds_get_default_subject() );
	}
}

/**
 * Checks if a post has a term of the given taxonomy.  If not, set it with the first
 * term available from the taxonomy.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @param  string  $taxonomy
 * @param  int     $default
 * @return void
 */
function thds_set_term_if_none( $post_id, $taxonomy, $default = 0 ) {

	// Get the current post terms.
	$terms = wp_get_post_terms( $post_id, $taxonomy );

	// If no terms are set, let's roll.
	if ( ! $terms ) {

		$new_term = false;

		// Get the default term if set.
		if ( $default )
			$new_term = get_term( $default, $taxonomy );

		// If no default term or if there's an error, get the first term.
		if ( ! $new_term || is_wp_error( $new_term ) ) {
			$available = get_terms( $taxonomy, array( 'number' => 1 ) );

			// Get the first term.
			$new_term = $available ? array_shift( $available ) : false;
		}

		// Only run if there are taxonomy terms.
		if ( $new_term ) {
			$tax_object = get_taxonomy( $taxonomy );

			// Use the ID for hierarchical taxonomies. Use the slug for non-hierarchical.
			$slug_or_id = $tax_object->hierarchical ? $new_term->term_id : $new_term->slug;

			// Set the new post term.
			wp_set_post_terms( $post_id, $slug_or_id, $taxonomy, true );
		}
	}
}
