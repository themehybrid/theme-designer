<?php

/**
 * Conditional tag to check if viewing a subject archive.
 *
 * @since  1.0.0
 * @access public
 * @param  mixed  $term
 * @return bool
 */
function thds_is_subject( $term = '' ) {

	return apply_filters( 'thds_is_subject', is_tax( thds_get_subject_taxonomy(), $term ) );
}
