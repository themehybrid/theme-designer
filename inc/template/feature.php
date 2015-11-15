<?php

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

