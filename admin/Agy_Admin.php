<?php
/**
 * Class Agy_Admin
 *
 * @class Agy_Admin
 * @package Agy_Admin
 * @version 1.0.0
 * @author Marko Radulovic
 */

if(!class_exists('Agy_Admin')) {
	class Agy_Admin {
		public function __construct() {
			if(is_admin()) {
				add_action('admin_enqueue_scripts', array( $this, 'agy_enqueue_admin_styles'));
			}
		}

		public function agy_enqueue_admin_styles() {
			wp_enqueue_style('agy_admin_css', plugins_url('/assets/css/agy_admin_style.css', __FILE__ ));
		}
	}
	new Agy_Admin();
}