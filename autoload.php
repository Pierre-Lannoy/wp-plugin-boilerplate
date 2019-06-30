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
		$classname = $class;
		$filepath  = __DIR__;
		if ( strpos( 'WPPluginBoilerplate\\', $classname ) === 0 ) {
			while ( strpos( '\\', $classname ) !== false ) {
				$classname = substr( $classname, 0, strpos( '\\', $classname ) );
			}
			$filename = str_replace( '_', '-', strtolower( $classname ) );
			if ( strpos( 'WPPluginBoilerplate\System\\', $classname ) === 0 ) {
				$filepath = WPPB_INCLUDES_DIR . 'system/';
			}
			if ( strpos( 'WPPluginBoilerplate\Plugin\\', $classname ) === 0 ) {
				$filepath = WPPB_INCLUDES_DIR . 'plugin/';
			}

			if ( strpos( '-public', $classname ) !== false ) {
				$filepath = WPPB_PUBLIC_DIR;
			}
			if ( strpos( '-admin', $classname ) !== false ) {
				$filepath = WPPB_ADMIN_DIR;
			}
			$file = $filepath . 'class-' . $filename . '.php';
			if ( file_exists( $file ) ) {
				require_once $file;
			}
		}
	}
);
