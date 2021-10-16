<?php
include AGY_PLUGIN_PATH . '/includes/Agy_Dashboard.php';
include AGY_PLUGIN_PATH . '/public/Agy_Public.php';
$agy_dashboard = new Agy_Dashboard();
$agy_public    = new Agy_Public();

// If "Activate Debug mode" field is activate than show always template
if ( $agy_dashboard->agy_options_check( 'debug_mode' ) == 1 ) {
	$agy_dashboard->agy_modal_template();
}

// If the cookie exist
if ( ! isset( $_COOKIE['agy_verification'] ) ) {

	// If "Show for unregistered users only" field is checked show the template only for unregistered users
	if ( $agy_dashboard->agy_options_check( 'unregister_user' ) == 1 && ! is_user_logged_in() ) {
		$agy_dashboard->agy_modal_template();
	}

	// If "Show for unregistered users only" field is NOT checked show the template for every visitor
	if ( $agy_dashboard->agy_options_check( 'unregister_user' ) == 0 ) {
		$agy_dashboard->agy_modal_template();
	}

	// If the page restriction fields is match with the visiting page
	if ( $agy_dashboard->agy_options_check( 'enabled_disabled' ) != 0 && ! empty( $agy_dashboard->agy_options_check( 'exclude_pages' ) ) ) {
		add_action( 'wp_head', array( $agy_public, 'agy_check_restriction_pages' ) );
	}
}