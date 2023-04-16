<?php
/**
 * Class Agy_Admin
 *
 * @class Agy_Admin
 * @package Agy_Admin
 * @version 1.0.0
 * @author Marko Radulovic
 */

if ( ! class_exists( 'Agy_Admin' ) ) {
	class Agy_Admin {
		public function __construct() {
			if ( is_admin() ) {
				add_action( 'admin_enqueue_scripts', array( $this, 'agy_enqueue_admin_styles' ) );
			}
		}

		public function agy_enqueue_admin_styles() {
			wp_enqueue_style( 'agy_admin_css', plugins_url( '/assets/css/agy_admin_style.css', __FILE__ ) );
			wp_enqueue_script( 'agy_admin_js', plugins_url( '/assets/js/agy_admin_script.js', __FILE__ ), array(), '1.0.0', true );
			wp_enqueue_script( 'agy_copy_js', plugins_url( '/assets/js/agy_copy.js', __FILE__ ), array(), '1.0.0', true );

			wp_enqueue_script( 'agy_admin_ajax', plugins_url( '/assets/js/agy_admin_ajax.js', __FILE__ ), array( 'jquery' ), null, true );
			wp_localize_script( 'agy_admin_ajax', 'agy_admin_ajax',
				array(
					'ajax_ajaxurl'        => admin_url( 'options.php' ),
					'ajax_publisher_name' => wp_create_nonce( 'ajax_publisher_save' ),
				)
			);
		}
	}

	new Agy_Admin();
}