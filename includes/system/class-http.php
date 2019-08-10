<?php
/**
 * HTTP handling
 *
 * Handles all HTTP operations and detection.
 *
 * @package System
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */

namespace WPPluginBoilerplate\System;

/**
 * Define the HTTP functionality.
 *
 * Handles all HTTP operations and detection.
 *
 * @package System
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */
class Http {

	/**
	 * The list of available verbs.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    array    $verbs    Maintains the verbs list.
	 */
	public static $verbs = [ 'get', 'head', 'post', 'put', 'delete', 'connect', 'options', 'trace', 'patch', 'unknown' ];

	/**
	 * The list of HTTP codes meaning success.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    array    $http_success_codes    Maintains the success codes list.
	 */
	public static $http_success_codes = [ 200, 201, 202, 203, 204, 205, 206, 207, 300, 301, 302, 303, 304, 305, 306, 307, 308 ];


}
