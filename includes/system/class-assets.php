<?php
/**
 * Plugin assets handling.
 *
 * @package system
 * @author Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since 1.0.0
 */

namespace WPPluginBoilerplate\System;

/**
 * The class responsible to handle assets management.
 *
 * @package system
 * @author Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since 1.0.0
 */
class Assets {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
	}

	/**
	 * Registers (but don't enqueues) a style asset of the plugin.
	 *
	 * Regarding user's option, asset is ready to enqueue from local plugin dir or from CDN (jsDelivr)
	 *
	 * @param string      $handle Name of the stylesheet. Should be unique.
	 * @param string|bool $src    Full path of the stylesheet, or path of the stylesheet relative to the WordPress root directory.
	 *                            If source is set to false, stylesheet is an alias of other stylesheets it depends on.
	 * @param string      $file   The style file name.
	 * @param array       $deps   Optional. An array of registered stylesheet handles this stylesheet depends on. Default empty array.
	 * @param string      $media  Optional. The media for which this stylesheet has been defined.
	 *                            Default 'all'. Accepts media types like 'all', 'print' and 'screen', or media queries like
	 *                            '(orientation: portrait)' and '(max-width: 640px)'.
	 * @return bool Whether the style has been registered. True on success, false on failure.
	 * @since 1.0.0
	 */
	public function register_style( $handle, $src, $file, $deps = array(), $media = 'all' ) {
		if ( (bool) get_option( WPPB_PRODUCT_ABBREVIATION . '_use_cdn' ) && WPPB_CDN_AVAILABLE ) {
			if ( WPPB_ADMIN_URL === $src ) {
				$file = 'https://cdn.jsdelivr.net/wp/' . WPPB_SLUG . '/tags/' . WPPB_VERSION . '/admin/' . $file;
			} else {
				$file = 'https://cdn.jsdelivr.net/wp/' . WPPB_SLUG . '/tags/' . WPPB_VERSION . '/public/' . $file;
			}
			return wp_register_style( $handle, $file, $deps, null, $media );
		} else {
			return wp_register_style( $handle, $src . $file, $deps, WPPB_VERSION, $media );
		}
	}

	/**
	 * Registers (but don't enqueues) a script asset of the plugin.
	 *
	 * Regarding user's option, asset is ready to enqueue from local plugin dir or from CDN (jsDelivr)
	 *
	 * @param string      $handle Name of the script. Should be unique.
	 * @param string|bool $src    Full path of the script, or path of the script relative to the WordPress root directory.
	 *                            If source is set to false, script is an alias of other scripts it depends on.
	 * @param string      $file   The style file name.
	 * @param array       $deps   Optional. An array of registered script handles this script depends on. Default empty array.
	 * @return bool Whether the script has been registered. True on success, false on failure.
	 * @since 1.0.0
	 */
	public function register_script( $handle, $src, $file, $deps = array() ) {
		if ( (bool) get_option( WPPB_PRODUCT_ABBREVIATION . '_use_cdn' ) && WPPB_CDN_AVAILABLE ) {
			if ( WPPB_ADMIN_URL === $src ) {
				$file = 'https://cdn.jsdelivr.net/wp/' . WPPB_SLUG . '/tags/' . WPPB_VERSION . '/admin/' . $file;
			} else {
				$file = 'https://cdn.jsdelivr.net/wp/' . WPPB_SLUG . '/tags/' . WPPB_VERSION . '/public/' . $file;
			}
			return wp_register_script( $handle, $file, $deps, null, (bool) get_option( WPPB_PRODUCT_ABBREVIATION . '_script_in_footer' ) );
		} else {
			return wp_register_script( $handle, $src . $file, $deps, WPPB_VERSION, (bool) get_option( WPPB_PRODUCT_ABBREVIATION . '_script_in_footer' ) );
		}
	}

}
