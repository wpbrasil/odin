<?php
/**
 * Get term meta fields
 *
 * Usage:
 * <?php echo odin_get_term_meta( $term_id, $field );?>
 *
 * @since  2.2.7
 *
 * @param  int    $term_id      Term ID
 * @param  string $field        Field slug
 *
 * @return string               Field value
 */
function odin_get_term_meta( $term_id, $field ) {
	// First try to get value in the new Term Meta WP API.
	if ( $value = get_term_meta( $term_id, $field, true ) ) {
		return $value;
	}

	// After, try to get in the old way (option API).
	$option_name = sprintf( 'odin_term_meta_%s_%s', $term_id, $field );
	$value       = get_option( $name );

	// Upgrade to new update_term_meta().
	if ( false !== $value ) {
		update_term_meta( $term_id, $field, $value );
		delete_option( $option_name );
	}

	return $value;
}
