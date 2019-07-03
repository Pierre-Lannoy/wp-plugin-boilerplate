<?php
/**
 * Libraries autoload for WordPress plugin boilerplate.
 *
 * @package Libraries
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */

spl_autoload_register(
	function ( $class ) {
		$classname = $class;
		$filepath  = '';
		$filename  = '';
		if ( 'Parsedown' === $classname ) {
			$filename = 'Parsedown.php';
			$filepath = WPPB_VENDOR_DIR . 'parsedown/';
		}
		if ( '' !== $filename && '' !== $filepath ) {
			$file = $filepath . $filename;
			if ( file_exists( $file ) ) {
				include_once $file;
			}
		}
	}
);
