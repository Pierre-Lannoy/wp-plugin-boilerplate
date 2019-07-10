<?php
/**
 * Options handling
 *
 * Handles all options operations for the plugin.
 *
 * @package System
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */

namespace WPPluginBoilerplate\System;

/**
 * Define the options functionality.
 *
 * Handles all options operations for the plugin.
 *
 * @package System
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */
class Option {

	/**
	 * The list of defaults options.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    array    $defaults    The $defaults list.
	 */
	private static $defaults = [];

	/**
	 * Set the defaults options.
	 *
	 * @since 1.0.0
	 */
	public static function init() {
		self::$defaults['use_cdn']          = false;
		self::$defaults['script_in_footer'] = false;
		self::$defaults['auto_update']      = true;
		self::$defaults['display_nag']      = true;
		self::$defaults['nags']             = [];
		self::$defaults['version']          = '0.0.0';
	}

	/**
	 * Get an option value.
	 *
	 * @param   string  $option     Option name. Expected to not be SQL-escaped.
	 * @param   boolean $default    Optional. The default value if option doesn't exists.
	 *                              This default value is used only if $option is not present
	 *                              in the $defaults array.
	 * @return  mixed   The value of the option.
	 * @since 1.0.0
	 */
	public static function get( $option, $default = null ) {
		if ( array_key_exists( $option, self::$defaults ) ) {
			$default = self::$defaults[ $option ];
		}
		return get_option( WPPB_PRODUCT_ABBREVIATION . '_' . $option, $default );
	}

	/**
	 * Set an option value.
	 *
	 * @param string      $option   Option name. Expected to not be SQL-escaped.
	 * @param mixed       $value    Option value. Must be serializable if non-scalar. Expected to not be SQL-escaped.
	 * @param string|bool $autoload Optional. Whether to load the option when WordPress starts up. For existing options,
	 *                              `$autoload` can only be updated using `update_option()` if `$value` is also changed.
	 *                              Accepts 'yes'|true to enable or 'no'|false to disable. For non-existent options,
	 *                              the default value is 'yes'. Default null.
	 * @return boolean  False if value was not updated and true if value was updated.
	 * @since 1.0.0
	 */
	public static function set( $option, $value, $autoload = null ) {
		return update_option( WPPB_PRODUCT_ABBREVIATION . '_' . $option, $value, $autoload );
	}

	/**
	 * Delete all options.
	 *
	 * @return integer Number of deleted items.
	 * @since 1.0.0
	 */
	public static function delete_all() {
		global $wpdb;
		$result = 0;
		// phpcs:ignore
		$delete = $wpdb->get_col( "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE '" . WPPB_PRODUCT_ABBREVIATION . '_%' . "';" );
		foreach ( $delete as $option ) {
			if ( delete_option( $option ) ) {
				++$result;
			}
		}
		return $result;
	}

	/**
	 * Initializes the class and set its properties.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
	}
}

Option::init();
