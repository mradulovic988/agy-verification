<?php
/**
 * WooCommerce related functionalities
 *
 * @class Agy_Wc
 * @package Agy_Wc
 * @version 1.0.0
 * @since 1.0.2
 * @author Marko Radulovic
 */

if ( ! class_exists( 'Agy_Wc' ) ) {
	class Agy_Wc {

		// Check if WooCommerce is active
		public function agy_if_woocommerce_exists(): bool {
			if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
				return true;
			} else {
				return false;
			}
		}
	}
}
