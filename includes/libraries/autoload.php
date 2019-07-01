<?php
/**
 * Libraries autoload for WordPress plugin boilerplate.
 *
 * @package Libraries
 * @author Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since 1.0.0
 */

spl_autoload_register(
	function( $class ) {
		$classname = $class;
		$filepath = WPPB_INCLUDES_DIR . 'libraries/';
		// Filter namespaces here.
	}
);
