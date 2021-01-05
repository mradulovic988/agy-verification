<?php
include AGY_PLUGIN_PATH . '/includes/Agy_Dashboard.php';
$agy_dashboard = new Agy_Dashboard();

// If "Activate Debug mode" field is activate than show always template
if ( $agy_dashboard->agy_options_check( 'debug_mode' ) == 1 ) {
	$agy_dashboard->agy_modal_template();
}

if ( ! isset( $_COOKIE['agy_verification'] ) ) {

	// If "Show for unregistered users only" field is checked show the template only for unregistered users
	if ( $agy_dashboard->agy_options_check( 'unregister_user' ) == 1 && ! is_user_logged_in() ) {
		$agy_dashboard->agy_modal_template();
	}

	// If "Show for unregistered users only" field is NOT checked show the template for every visitor
	if ( $agy_dashboard->agy_options_check( 'unregister_user' ) == 0 ) {
		$agy_dashboard->agy_modal_template();
	}
}