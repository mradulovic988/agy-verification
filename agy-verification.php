<?php
/**
 * Agy Verification
 *
 * @package           AgyVerification
 * @author            Marko Radulovic
 * @copyright         2020 M Lab Studio
 * @license           GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Agy Verification
 * Plugin URI:        https://sr.wordpress.org/plugins/agy-verification
 * Description:       Agy is a powerful solution to add age verification on your website. Easy to setup, optimized for all devices, and modern design option to match your style.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Marko Radulovic
 * Author URI:        https://mlab-studio.com/
 * Text Domain:       agy
 * Domain Path:       /languages
 * License:           GPL v3 or later
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('Agy')) {

	class Agy {
		public function __construct() {
			if (!defined('AGY_PLUGIN_PATH')) {
				define('AGY_PLUGIN_PATH', plugin_dir_path(__FILE__));
			}

			if (!defined('AGY_PLUGIN_BASENAME')) {
				define('AGY_PLUGIN_BASENAME', plugin_basename(__FILE__));
			}

			if (is_admin()) {
				 include AGY_PLUGIN_PATH . '/includes/Agy_Dashboard.php';
				 include AGY_PLUGIN_PATH . '/admin/Agy_Admin.php';

				$this->agy_load_plugin_textdomain();

			} else {
				// include AGY_PLUGIN_PATH . '/public/Wp_Banner_Public.php';
			}
		}

		public function agy_load_plugin_textdomain() {
			load_plugin_textdomain(
				'agy',
				false,
				AGY_PLUGIN_BASENAME . dirname(__FILE__) . '/languages'
			);
		}
	}

	new Agy();
}