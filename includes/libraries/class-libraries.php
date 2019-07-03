<?php
/**
 * Libraries handling
 *
 * Handles all libraries (vendor) operations and versioning.
 *
 * @package System
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */

namespace WPPluginBoilerplate\Libraries;

/**
 * Define the libraries functionality.
 *
 * Handles all libraries (vendor) operations and versioning.
 *
 * @package System
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */
class Libraries {

	/**
	 * The array of PSR-4 libraries used by the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    array    $libraries    The PSR-4 libraries used by the plugin.
	 */
	private static $psr4_libraries;

	/**
	 * The array of mono libraries used by the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    array    $libraries    The mono libraries used by the plugin.
	 */
	private static $mono_libraries;

	/**
	 * Initializes the class and set its properties.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		self::init();
	}

	/**
	 * Defines all needed libraries.
	 *
	 * @since 1.0.0
	 */
	public static function init() {
		self::$psr4_libraries = array();
		// self::$psr4_libraries['parsedown'] = array('name' => 'Parsedown', 'prefix' => '', 'base' => WPPB_VENDOR_DIR . 'parsedown/', 'version' => '1.8.0-beta-7', 'license' => 'mit');.
		self::$mono_libraries              = array();
		self::$mono_libraries['parsedown'] = array(
			'name'    => 'Parsedown',
			'detect'  => 'Parsedown',
			'base'    => WPPB_VENDOR_DIR . 'parsedown/',
			'version' => '1.8.0-beta-7',
			'author'  => sprintf( __( '%s & contributors', 'wp-plugin-boilerplate' ), 'Emanuil Rusev' ),
			'url'     => 'https://parsedown.org',
			'license' => 'mit',
		);
	}

	/**
	 * Get PSR-4 libraries.
	 *
	 * @return  array   The list of defined PSR-4 libraries.
	 * @since 1.0.0
	 */
	public static function get_psr4() {
		return self::$psr4_libraries;
	}

	/**
	 * Get mono libraries.
	 *
	 * @return  array   The list of defined mono libraries.
	 * @since 1.0.0
	 */
	public static function get_mono() {
		return self::$mono_libraries;
	}

	/**
	 * Compare two items based on name field.
	 *
	 * @param  string $a     The first element.
	 * @param  string $b     The second element.
	 * @return  boolean     True if $a>$b, false otherwise.
	 * @since 1.0.0
	 */
	public function reorder_list( $a, $b ) {
		return strcmp( strtolower( $a['name'] ), strtolower( $b['name'] ) );
	}

	/**
	 * Get the full license name.
	 *
	 * @param  string $license     The license id.
	 * @return  string     The full license name.
	 * @since 1.0.0
	 */
	private function license_name( $license ) {
		switch ( $license ) {
			case 'mit':
				$result = esc_html( __( 'MIT license', 'wp-plugin-boilerplate' ) );
				break;
			case 'gpl2':
				$result = esc_html( __( 'GPL-2.0 license', 'wp-plugin-boilerplate' ) );
				break;
			default:
				$result = esc_html( __( 'unknown license', 'wp-plugin-boilerplate' ) );
				break;
		}
		return $result;
	}

	/**
	 * Get the libraries list.
	 *
	 * @param   array $attributes  'style' => 'html'.
	 * @return  string  The output of the shortcode, ready to print.
	 * @since 1.0.0
	 */
	public function sc_get_list( $attributes ) {
		$_attributes = shortcode_atts(
			array(
				'style' => 'html',
			),
			$attributes
		);
		$style       = $_attributes['style'];
		$result      = '';
		$list        = array();
		foreach ( array_merge( self::get_psr4(), self::get_mono() ) as $library ) {
			$item            = array();
			$item['name']    = $library['name'];
			$item['version'] = $library['version'];
			$item['author']  = $library['author'];
			$item['url']     = $library['url'];
			$item['license'] = $this->license_name( $library['license'] );
			$list[]          = $item;
		}
		$item            = array();
		$item['name']    = 'Plugin Boilerplate';
		$item['version'] = '';
		$item['author']  = 'Pierre Lannoy';
		$item['url']     = 'https://github.com/Pierre-Lannoy/wp-plugin-boilerplate';
		$item['license'] = $this->license_name( 'gpl2' );
		$list[]          = $item;
		usort( $list, array( $this, 'reorder_list' ) );
		if ( 'html' === $style ) {
			$items = array();
			foreach ( $list as $library ) {
				/* translators: as in the sentence "Product W version X by author Y (license Z)" */
				$items[] = sprintf( __( '<a href="%1$s">%2$s %3$s</a> by %4$s (%5$s)', 'wp-plugin-boilerplate' ), $library['url'], $library['name'], $library['version'], $library['author'], $library['license'] );
			}
			$result = implode( ', ', $items );
		}
		return $result;
	}

}

Libraries::init();
