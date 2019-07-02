<?php
/**
 * Plugin cache handling.
 *
 * @package System
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */

namespace WPPluginBoilerplate\System;

/**
 * The class responsible to handle cache management.
 *
 * @package System
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */
class Cache {


	/**
	 * The pool's name, specific to the calling plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string    $pool_name    The pool's name.
	 */
	private static $pool_name = WPPB_SLUG;

	/**
	 * Differentiates cache items by blogs.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    boolean    $blog_aware    Is the item id must contain the blog id?
	 */
	private static $blog_aware = true;

	/**
	 * Differentiates cache items by current locale.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    boolean    $blog_aware    Is the item id must contain the locale id?
	 */
	private static $locale_aware = true;

	/**
	 * Differentiates cache items by current user.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    boolean    $blog_aware    Is the item id must contain the user id?
	 */
	private static $user_aware = true;

	/**
	 * Available TTLs.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    array    $ttls    The TTLs array.
	 */
	private static $ttls;

	/**
	 * Default TTL.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    integer    $default_ttl    The default TTL in seconds.
	 */
	private static $default_ttl = 3600;

	/**
	 * Initializes the class and set its properties.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		self::init();
	}

	/**
	 * Initializes properties.
	 *
	 * @since 1.0.0
	 */
	public static function init() {
		self::$ttls = array(
			'ephemeral' => -1,
			'diagnosis' => 3600,
		);
	}

	/**
	 * Full item name.
	 *
	 * @param  string $item_name Item name. Expected to not be SQL-escaped.
	 * @return string The full item name.
	 * @since  1.0.0
	 */
	private static function full_item_name( $item_name ) {
		$name = self::$pool_name . '_';
		if ( self::$blog_aware ) {
			$name .= (string) get_current_blog_id() . '_';
		}
		if ( self::$locale_aware ) {
			$name .= (string) L10n::get_display_locale() . '_';
		}
		if ( self::$user_aware ) {
			$name .= (string) User::get_current_user_id() . '_';
		}
		$name .= $item_name;
		return substr( trim( $name ), 0, 172 );
	}

	/**
	 * Get the value of a cache item.
	 *
	 * If the item does not exist, does not have a value, or has expired,
	 * then the return value will be false.
	 *
	 * @param  string $item_name Item name. Expected to not be SQL-escaped.
	 * @return mixed Value of item.
	 * @since  1.0.0
	 */
	public static function get( $item_name ) {
		return get_transient( self::full_item_name( $item_name ) );
	}

}
