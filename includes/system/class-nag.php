<?php
/**
 * Nag handling
 *
 * Handles all nag operations.
 * Please, use these features with respect for users.
 * Don't hijack the admin dashboard!
 *
 * @package System
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */

namespace WPPluginBoilerplate\System;

/**
 * Define the nag functionality.
 *
 * Handles all nag operations. Note this nag feature respects the
 * DISABLE_NAG_NOTICES unofficial standard.
 *
 * @package System
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */
class Nag {

	/**
	 * Initializes the class and set its properties.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
	}

	/**
	 * Show a notice.
	 *
	 * @since 1.0.0
	 */
	public function admin_notice_update_done() {
		//$s = sprintf(__('%s has been updated.', 'live-weather-station'), LWS_PLUGIN_NAME) ;
		//$s .= ' '. sprintf(__('Your site now uses version %s.', 'live-weather-station'), LWS_VERSION) ;
		$s = '';
		$n = wp_nonce_field( 'wppb-nag-nonce', 'wppbnagnonce', false );
		print('<div id="whatsnew" class="notice notice-info is-dismissible">' . $n . '<p>' . $s . '</p></div>');
	}

	/**
	 * Ajax handler for updating whether to display the NAG notice.
	 *
	 * @since 1.0.0
	 */
	public static function hide_lws_whatsnew_callback() {
		if (check_ajax_referer('wppb-nag-nonce', 'wppbnagnonce')) {
			delete_option(WPPB_PRODUCT_ABBREVIATION . '_display_nag');
		}
		wp_die(1);
	}
}
