<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @package Plugin
 * @author Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since 1.0.0
 */

namespace WPPluginBoilerplate\Plugin;

/**
 * The class responsible for the public-facing functionality of the plugin.
 *
 * @package plugin
 * @author Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since 1.0.0
 */
class Wp_Plugin_Boilerplate_Public {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( WPPB_ASSETS_ID, WPPB_PUBLIC_URL . 'css/wp-plugin-boilerplate.min.css', array(), WPPB_VERSION, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( WPPB_ASSETS_ID, WPPB_PUBLIC_URL . 'js/wp-plugin-boilerplate.min.js', array( 'jquery' ), WPPB_VERSION, false );
	}

}
