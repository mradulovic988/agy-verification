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
 * Version:           1.0.1
 * Requires at least: 4.6
 * Requires PHP:      7.2
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

	class Agy {
		public function __construct() {
			if ( ! defined( 'AGY_PLUGIN_PATH' ) ) {
				define( 'AGY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
			}

			if ( ! defined( 'AGY_PLUGIN_BASENAME' ) ) {
				define( 'AGY_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			}

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

		public function agy_load_plugin_textdomain() {
			load_plugin_textdomain(
				'agy',
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
					sprintf( '<a href="%s">' . __( 'Settings', 'agy' ), 'tools.php?page=agy-dashboard' ) . '</a>'
				);
			}

			return $links;
		}

		// Settings link for the plugin
		public function agy_set_plugin_meta( $links, $file ): array {
			$plugin = plugin_basename( __FILE__ );

			if ( $file == $plugin && current_user_can( 'manage_options' ) ) {
				array_push(
					$links,
					sprintf( '<a target="_blank" href="%s">' . __( 'Docs & FAQs', 'agy' ) . '</a>', 'https://wordpress.org/support/plugin/agy-verification' )
				);

				array_push(
					$links,
					sprintf( '<a target="_blank" href="%s">' . __( 'GitHub', 'agy' ) . '</a>', 'https://github.com/mradulovic988/agy-verification' )
				);
			}

			return $links;
		}
	}

	new Agy();
}