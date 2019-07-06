<?php
/**
 * Users handling
 *
 * Handles all user operations and detection.
 *
 * @package System
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */

namespace WPPluginBoilerplate\System;

/**
 * Define the user functionality.
 *
 * Handles all user operations and detection.
 *
 * @package System
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */
class User {

	/**
	 * Initializes the class and set its properties.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
	}

	/**
	 * Get the current user id.
	 *
	 * @return null|integer The user id if detected, null otherwise.
	 * @since  3.0.8
	 */
	public static function get_current_user_id() {
		$user_id = null;
		global $current_user;
		if ( ! empty( $current_user ) ) {
			if ( $current_user instanceof WP_User ) {
				$user_id = $current_user->ID;
			}
			if ( is_object( $current_user ) && isset( $current_user->ID ) ) {
				$user_id = $current_user->ID;
			}
		}
		return $user_id;
	}

}
