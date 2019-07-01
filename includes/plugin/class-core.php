<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @package Plugin
 * @author Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since 1.0.0
 */

namespace WPPluginBoilerplate\Plugin;

use WPPluginBoilerplate\System\Loader;
use WPPluginBoilerplate\System\I18n;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * @package Plugin
 * @author Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since 1.0.0
 */
class Core {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->loader = new Loader();
		$this->set_locale();
		$this->define_global_hooks();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Adr_Sync_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function set_locale() {
		$plugin_i18n = new I18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the features of the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function define_global_hooks() {
		/*
		if (! wp_next_scheduled(ADRS_CRON_NAME) ) {
			wp_schedule_event(time(), get_option('adr_frequency', 'daily'), ADRS_CRON_NAME);
		}
		$plugin_cpt = new Adr_Sync_Cpt($this->get_adr_sync(), $this->get_version());
		$this->loader->add_action('init', $plugin_cpt, 'register_adr_post_type');
		$this->loader->add_action('wp_insert_post_data', $plugin_cpt, 'default_comments_on');
		$job = new Adr_Sync_Job($this->get_adr_sync(), $this->get_version());
		$this->loader->add_action(ADRS_CRON_NAME, $job, 'silent_synchronization');*/
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function define_admin_hooks() {
		/*
		$plugin_admin = new Adr_Sync_Admin($this->get_adr_sync(), $this->get_version());
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
		$this->loader->add_action('admin_menu', $plugin_admin, 'init_admin_menus');
		$this->loader->add_action('admin_init', $plugin_admin, 'init_settings_sections');
		$this->loader->add_action('dashboard_glance_items', $plugin_admin, 'add_wp_glance_items');*/
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function define_public_hooks() {
		/*
		$plugin_public = new Adr_Sync_Public($this->get_adr_sync(), $this->get_version());
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
		add_shortcode('adr-sync', array( $plugin_public, 'synchronize' ));*/

		$this->loader->add_action('wp_head', 'WPPluginBoilerplate\System\Assets', 'prefetch');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since 1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since  1.0.0
	 * @return Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

}
