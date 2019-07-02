<?php
/**
 * Localization handling
 *
 * Handles all localization operations and detection.
 *
 * @package System
 * @author Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since 1.0.0
 */

namespace WPPluginBoilerplate\System;

/**
 * Define the localization functionality.
 *
 * Handles all localization operations and detection.
 *
 * @package System
 * @author Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since 1.0.0
 */
class L10n {

	/**
	 * Initializes the class and set its properties.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
	}

	/**
	 * Get the proper user locale.
	 *
	 * @param int|WP_User $user_id User's ID or a WP_User object. Defaults to current user.
	 * @return string The locale of the user.
	 * @since 3.0.8
	 */
	public static function get_display_locale($user_id = 0) {
		global $current_user;
		if (!empty($current_user) && 0 === $user_id) {
			if ($current_user instanceof WP_User) {
				$user_id = $current_user->ID;
			}
			if (is_object($current_user) && isset($current_user->ID)) {
				$user_id = $current_user->ID;
			}
		}

		/*
		* @fixme how to manage ajax calls made from frontend?
		*/
		if (function_exists('get_user_locale')) {
			return get_user_locale($user_id);
		}
		else {
			return get_locale();
		}
	}

}