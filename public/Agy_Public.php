<?php
/**
 * Class Agy_Public
 *
 * @class Agy_Public
 * @package Agy_Public
 * @version 1.0.0
 * @author Marko Radulovic
 */

if (!class_exists('Agy_Public')) {
	class Agy_Public {
		public function __construct() {
			if(!is_admin()) {
				add_action('wp_enqueue_scripts', array($this, 'agy_enqueue_public_styles'));
				add_action('wp_head', array($this, 'agy_template'));
			}
		}

		public function agy_enqueue_public_styles() {
			wp_enqueue_style('agy_public_css', plugins_url('/assets/css/agy_public_style.css', __FILE__ ));
			wp_enqueue_script( 'agy_public_js', plugins_url( '/assets/js/agy_public_script.js' , __FILE__ ), array(), '1.0.0', true );
		}

		public function agy_template() {
			include_once AGY_PLUGIN_PATH . '/public/template-parts/agy_template_basic.php';
		}
	}
	new Agy_Public();
}