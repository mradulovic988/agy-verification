<?php
/**
 * Class Agy_Dashboard
 *
 * @class Agy_Dashboard
 * @package Agy_Dashboard
 * @version 1.0.0
 * @author Marko Radulovic
 */

if (!class_exists('Agy_Dashboard')) {

	class Agy_Dashboard {
		public function __construct() {
			if (is_admin()){
				add_action('admin_menu', array($this, 'agy_dashboard'));
				add_action( 'admin_notices', array( $this, 'agy_show_error_notice' ) );
			}
		}

		public function agy_show_error_notice() {
		    settings_errors();
        }

		public function agy_dashboard() {
			add_submenu_page(
				'tools.php',
				__('Agy', 'agy'),
				__('Agy', 'agy'),
				'manage_options',
				'agy-dashboard',
				array($this, 'agy_dashboard_page')
			);
		}

		public function agy_dashboard_page() {
			?>
			<style>div#wpwrap{background:#E1F2F7!important}</style>
			<div class="wrap">
				<form action="" method="post">

					<?php
					settings_fields( '' );
					do_settings_sections( '' );

					submit_button(
						__('Save Changes', 'agy'),
						'primary',
						'agy-save-changes-btn',
						true,
						array('id'=>'agy-save-changes-btn')
					);
					?>

				</form>
			</div>
		<?php
		}
	}
	new Agy_Dashboard();
}