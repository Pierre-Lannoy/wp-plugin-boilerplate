<?php
/**
 * Autoload for WordPress plugin boilerplate.
 *
 * @package Bootstrap
 * @author Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since 1.0.0
 */

spl_autoload_register(
	function( $class ) {
		$file = '';
		if ( file_exists( $file ) ) {
			require_once $file;
		}
	}
);
