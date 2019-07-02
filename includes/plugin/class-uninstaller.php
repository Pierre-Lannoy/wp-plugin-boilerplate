<?php
/**
 * Plugin deletion handling.
 *
 * @package Plugin
 * @author Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since 1.0.0
 */

namespace WPPluginBoilerplate\Plugin;

/**
 * Fired during plugin deletion.
 *
 * This class defines all code necessary to run during the plugin's deletion.
 *
 * @package Plugin
 * @author Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since 1.0.0
 */
class Uninstaller {

	/**
	 * Delete the plugin.
	 *
	 * @since 1.0.0
	 */
	public static function uninstall() {
		// Remove options.
		// Delete cache?
	}

}
