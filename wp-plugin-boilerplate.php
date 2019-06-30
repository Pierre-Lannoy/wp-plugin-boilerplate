<?php
/**
 * Main plugin file.
 *
 * @package Bootstrap
 * @author Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since 1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress plugin boilerplate
 * Plugin URI:        -
 * Description:       -
 * Version:           1.0.0
 * Author:            Pierre Lannoy
 * Author URI:        https://pierre.lannoy.fr
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-plugin-boilerplate
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once __DIR__ . '/init.php';
require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/includes/system/class-environment.php';

/**
 * The code that runs during plugin activation.
 *
 * @since 1.0.0
 */
function wppb_activate() {
	//WPPluginBoilerplate\System\Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 *
 * @since 1.0.0
 */
function wppb_deactivate() {
	//WPPluginBoilerplate\System\Deactivator::deactivate();
}

/**
 * The code that runs during plugin uninstallation.
 *
 * @since 1.0.0
 */
function wppb_uninstall() {
	//WPPluginBoilerplate\System\Uninstaller::uninstall();
}

/**
 * Begins execution of the plugin.
 *
 * @since 1.0.0
 */
function wppb_run() {
	WPPluginBoilerplate\System\Environment::init();
	$plugin = new WPPluginBoilerplate\System\Core();
	$plugin->run();
}

register_activation_hook( __FILE__, 'wppb_activate' );
register_deactivation_hook( __FILE__, 'wppb_deactivate' );
register_uninstall_hook( __FILE__, 'wppb_uninstall' );
wppb_run();
