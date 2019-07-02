<?php
/**
 * Hosting environment handling.
 *
 * @package System
 * @author Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since 1.0.0
 */

namespace WPPluginBoilerplate\System;

/**
 * The class responsible to manage and detect hosting environment.
 *
 * @package System
 * @author Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since 1.0.0
 */
class Hosting {

	/**
	 * Initializes the class and set its properties.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
	}

	/**
	 * Check if the server config allows shell_exec().
	 *
	 * @return  bool    True if shell_exec() can be used, false otherwise.
	 * @since 1.0.0
	 */
	private static function is_shell_enabled() {
		if ( function_exists( 'shell_exec' ) && ! in_array( 'shell_exec', array_map( 'trim', explode( ', ', ini_get( 'disable_functions' ) ) ), true ) && (int) strtolower( ini_get( 'safe_mode' ) ) !== 1 ) {
			$return = shell_exec( 'cat /proc/cpuinfo' );
			if ( ! empty( $return ) ) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	/**
	 * Get CPU count of the server.
	 *
	 * @return  int|bool    The count of CPUs, false if it's not countable.
	 * @since 1.0.0
	 */
	public static function count_server_cpu() {
		$cpu_count = get_transient( WPPB_PRODUCT_ABBREVIATION . '_cpu_count' );
		if ( false === $cpu_count ) {
			if ( self::is_shell_enabled() ) {
				$cpu_count = shell_exec( 'cat /proc/cpuinfo |grep "physical id" | sort | uniq | wc -l' );
				set_transient( WPPB_PRODUCT_ABBREVIATION . '_cpu_count', $cpu_count, HOUR_IN_SECONDS );
			} else {
				return false;
			}
		}
		return (int) $cpu_count;
	}

	/**
	 * Get core count of the server.
	 *
	 * @return  int|bool    The count of cores, false if it's not countable.
	 * @since 1.0.0
	 */
	public static function count_server_core() {
		$core_count = get_transient( WPPB_PRODUCT_ABBREVIATION . '_core_count' );
		if ( false === $core_count ) {
			if ( self::is_shell_enabled() ) {
				$core_count = shell_exec( "echo \"$((`cat /proc/cpuinfo | grep cores | grep -o '[0-9]' | uniq` * `cat /proc/cpuinfo |grep 'physical id' | sort | uniq | wc -l`))\"" );
				set_transient( WPPB_PRODUCT_ABBREVIATION . '_core_count', $core_count, HOUR_IN_SECONDS );
			} else {
				return false;
			}
		}
		return $core_count;
	}

}
