<?php
/**
 * Plugin updates handling.
 *
 * @package Plugin
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */

namespace WPPluginBoilerplate\Plugin;

use WPPluginBoilerplate\System\Nag;
use WPPluginBoilerplate\System\Option;
use WPPluginBoilerplate\System\Role;
use WPPluginBoilerplate\System\Logger;
use WPPluginBoilerplate\System\Environment;
use Exception;
use WPPluginBoilerplate\System\Markdown;

/**
 * Plugin updates handling.
 *
 * This class defines all code necessary to handle the plugin's updates.
 *
 * @package Plugin
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */
class Updater {

	/**
	 * Initializes the class, set its properties and performs
	 * post-update processes if needed.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$old = Option::network_get( 'version' );
		if ( TRAFFIC_VERSION !== $old ) {
			if ( '0.0.0' === $old ) {
				$this->install();
				// phpcs:ignore
				$message = sprintf( esc_html__( '%1$s has been correctly installed.', 'wp-plugin-boilerplate' ), WPPB_PRODUCT_NAME );
			} else {
				$this->update( $old );
				// phpcs:ignore
				$message  = sprintf( esc_html__( '%1$s has been correctly updated from version %2$s to version %3$s.', 'wp-plugin-boilerplate' ), WPPB_PRODUCT_NAME, $old, WPPB_VERSION );
				Logger::notice( $message );
				// phpcs:ignore
				$message .= ' ' . sprintf( __( 'See <a href="%s">what\'s new</a>.', 'wp-plugin-boilerplate' ), admin_url( 'options-general.php?page=wp-plugin-boilerplate-settings&tab=about' ) );
			}
			Nag::add( 'update', 'info', $message );
			Option::network_set( 'version', TRAFFIC_VERSION );
		}
	}

	/**
	 * Performs post-installation processes.
	 *
	 * @since 1.0.0
	 */
	private function install() {

	}

	/**
	 * Performs post-update processes.
	 *
	 * @param   string $from   The version from which the plugin is updated.
	 * @since 1.0.0
	 */
	private function update( $from ) {

	}

	/**
	 * Is the WP update system enabled for plugins?
	 *
	 * @return  boolean  True if nothing blocks updates, false otherwise.
	 * @since 1.0.0
	 */
	public function is_updatable() {
		$filter = false === has_filter( 'auto_update_plugin', '__return_false' );
		if ( defined( 'AUTOMATIC_UPDATER_DISABLED' ) ) {
			$main = ! AUTOMATIC_UPDATER_DISABLED;
		} else {
			$main = true;
		}
		return $main && $filter;
	}

	/**
	 * Is the plugin auto-update enabled?
	 *
	 * @return  boolean  True if plugin is auto-updatable, false otherwise.
	 * @since 1.0.0
	 */
	public function is_autoupdatable() {
		return ( $this->is_updatable() && Option::site_get( 'auto_update' ) );
	}

	/**
	 * Choose if the plugin must be auto-updated or not.
	 * Concerned hook: auto_update_plugin.
	 *
	 * @param   boolean $update The default answer.
	 * @param   object  $item   The detail of the item (to update or not).
	 * @return  boolean  True if plugin must be auto-updated, false otherwise.
	 * @since 1.0.0
	 */
	public function auto_update_plugin( $update, $item ) {
		if ( ( WPPB_SLUG === $item->slug ) && $this->is_autoupdatable() ) {
			return true;
		} else {
			return $update;
		}
	}

	/**
	 * Get the changelog.
	 *
	 * @param   array $attributes  'style' => 'markdown', 'html'.
	 *                             'mode'  => 'raw', 'clean'.
	 * @return  string  The output of the shortcode, ready to print.
	 * @since 1.0.0
	 */
	public function sc_get_changelog( $attributes ) {
		$md = new Markdown();
		return $md->get_shortcode(  'CHANGELOG.md', $attributes  );
	}
}
