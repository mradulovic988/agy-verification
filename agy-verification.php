<?php
/**
 * Agy Verification
 *
 * @package           Agy
 * @author            Marko Radulovic
 * @copyright         2021 Marko Radulovic
 * @license           GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Agy Verification
 * Plugin URI:        https://wordpress.org/plugins/agy-verification
 * Description:       Agy Verification is a powerful solution to add any kind of verification restriction on your website. Easy to setup, optimized for all devices, and modern design option to match your style.
 * Version:           1.2.0
 * Requires at least: 5.6
 * Requires PHP:      7.4
 * Author:            Marko Radulovic
 * Author URI:        https://mlab-studio.com/
 * Text Domain:       agy
 * Domain Path:       /languages
 * License:           GPL v3 or later
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Agy' ) ) {

	/**
	 * Main final class
	 *
	 * @since 1.1.8
	 */
	final class Agy {
		private static ?self $instance = null;

		public function __construct() {
			if ( ! defined( 'AGY_PLUGIN_PATH' ) ) {
				define( 'AGY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
			}

			if ( ! defined( 'AGY_PLUGIN_VERSION' ) ) {
				define( 'AGY_PLUGIN_VERSION', '1.2.0' );
			}

			if ( ! defined( 'AGY_PLUGIN_BASENAME' ) ) {
				define( 'AGY_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			}

			if ( ! defined( 'AGY_MINIMAL_PHP_VERSION' ) ) {
				define( 'AGY_MINIMAL_PHP_VERSION', 7.4 );
			}

			if ( ! defined( 'AGY_MINIMAL_WP_VERSION' ) ) {
				define( 'AGY_MINIMAL_WP_VERSION', 5.6 );
			}

			if ( ! defined( 'AGY_TEXT_DOMAIN' ) ) {
				define( 'AGY_TEXT_DOMAIN', 'agy' );
			}

			register_activation_hook( __FILE__, array( $this, 'agy_minimal_requirements' ) );

			if ( is_admin() ) {
				include AGY_PLUGIN_PATH . '/includes/Agy_Dashboard.php';
				include AGY_PLUGIN_PATH . '/admin/Agy_Admin.php';

				$this->agy_load_plugin_textdomain();
				add_filter( 'plugin_action_links', array( $this, 'agy_settings_link' ), 10, 2 );
				add_filter( 'plugin_row_meta', array( $this, 'agy_set_plugin_meta' ), 10, 2 );

			} else {
				include AGY_PLUGIN_PATH . '/public/Agy_Public.php';
			}
		}

		public function agy_minimal_requirements(): void {
			global $wp_version;

			if ( version_compare( PHP_VERSION, AGY_MINIMAL_PHP_VERSION, '<' ) ) {
				deactivate_plugins( AGY_PLUGIN_BASENAME );

				wp_die( sprintf(
					__( 'Plugin requires at least PHP version %s. You are running version %s. Please upgrade and try again.', AGY_TEXT_DOMAIN ),
					AGY_MINIMAL_PHP_VERSION,
					PHP_VERSION
				) );
			}

			if ( version_compare( $wp_version, AGY_MINIMAL_WP_VERSION, "<" ) ) {
				deactivate_plugins( AGY_PLUGIN_BASENAME );

				wp_die( sprintf(
					__( 'Plugin requires at least WordPress version %s. You are running version %s. Please upgrade and try again.', AGY_TEXT_DOMAIN ),
					AGY_MINIMAL_WP_VERSION,
					$wp_version
				) );
			}
		}

		public function agy_load_plugin_textdomain() {
			load_plugin_textdomain(
				AGY_TEXT_DOMAIN,
				false,
				AGY_PLUGIN_BASENAME . dirname( __FILE__ ) . '/languages'
			);
		}

		// Settings link for the plugin
		public function agy_settings_link( $links, $file ): array {
			$plugin = plugin_basename( __FILE__ );

			if ( $file == $plugin && current_user_can( 'manage_options' ) ) {
				array_unshift(
					$links,
					sprintf( '<a href="%s">' . __( 'Settings', AGY_TEXT_DOMAIN ), 'tools.php?page=agy-dashboard' ) . '</a>'
				);
			}

			return $links;
		}

		// Settings link for the plugin
		public function agy_set_plugin_meta( $links, $file ): array {
			$plugin = plugin_basename( __FILE__ );

			if ( $file == $plugin && current_user_can( 'manage_options' ) ) {
				$links[] = sprintf( '<a target="_blank" href="%s">' . __( 'Docs & FAQs', AGY_TEXT_DOMAIN ) . '</a>', 'https://wordpress.org/support/plugin/agy-verification' );
				$links[] = sprintf( '<a target="_blank" href="%s">' . __( 'GitHub', AGY_TEXT_DOMAIN ) . '</a>', 'https://github.com/mradulovic988/agy-verification' );
			}

			return $links;
		}

		public static function agy_instance(): self {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

	Agy::agy_instance();
}