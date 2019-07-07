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
		$old = get_option( WPPB_PRODUCT_ABBREVIATION . '_version', '0.0.0' );
		if ( WPPB_VERSION !== $old ) {
			if ( '0.0.0' === $old ) {
				$this->install();
				$message = sprintf( __( '%1$s has been correctly installed.', 'wp-plugin-boilerplate' ), WPPB_PRODUCT_NAME );
			} else {
				$this->update( $old );
				$message = sprintf( __( '%1$s has been correctly updated from version %2$s to version %3$s.', 'wp-plugin-boilerplate' ), WPPB_PRODUCT_NAME, $old, WPPB_VERSION );
			}
			Nag::add( 'update', 'info', $message );
			update_option( WPPB_PRODUCT_ABBREVIATION . '_version', WPPB_VERSION );
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
		return ( $this->is_updatable() && get_option( WPPB_PRODUCT_ABBREVIATION . '_auto_update' ) );
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
		$_attributes = shortcode_atts(
			array(
				'style' => 'html',
				'mode'  => 'clean',
			),
			$attributes
		);
		$style       = $_attributes['style'];
		$mode        = $_attributes['mode'];
		$error       = __( 'Sorry, unable to find or read changelog file.', 'wp-plugin-boilerplate' );
		$result      = esc_html( $error );
		$changelog   = WPPB_PLUGIN_DIR . 'CHANGELOG.md';
		if ( file_exists( $changelog ) ) {
			try {
				// phpcs:ignore
				$content = file_get_contents( $changelog );
				if ( $content ) {
					switch ( $style ) {
						case 'html':
							$result = $this->html_changelog( $content, ( 'clean' === $mode ) );
							break;
						default:
							$result = esc_html( $content );
					}
				}
			} catch ( Exception $e ) {
				$result = esc_html( $error );
			}
		}
		return $result;
	}

	/**
	 * Format a changelog in html.
	 *
	 * @param   string  $content  The raw changelog in markdown.
	 * @param   boolean $clean    Optional. Should the output be cleaned?.
	 * @return  string  The converted changelog, ready to print.
	 * @since   1.0.0
	 */
	private function html_changelog( $content, $clean = false ) {
		$markdown = new \Parsedown();
		$result   = $markdown->text( $content );
		if ( $clean ) {
			$result = preg_replace( '/<h1>.*<\/h1>/iU', '', $result );
		}
		return $result;
	}
}
