<?php
/**
 * Debug variables.
 *
 * @since  2.2.0
 *
 * @param  mixed $variable Object or Array for debug.
 *
 * @return string          Human-readable information.
 */
function odin_debug( $variable ) {
	echo '<pre>' . print_r( $variable, true ) . '</pre>';
	exit;
}
