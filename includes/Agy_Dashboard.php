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
				add_action('admin_notices', array($this, 'agy_show_error_notice'));
				add_action('admin_init', array($this, 'agy_register_settings'));
			}
		}

		public function agy_show_error_notice() {
		    settings_errors();
        }

		public function agy_dashboard() {
			add_submenu_page(
				'tools.php',
				__('Agy Verification', 'agy'),
				__('Agy Verification', 'agy'),
				'manage_options',
				'agy-dashboard',
				array($this, 'agy_dashboard_page')
			);
		}
		
		protected function agy_header_tabs() {
		    ?>
            <div class="agy-tab">
                <button id="default-open" class="agy-tablinks" onclick="openTab(event, 'agy-tab1')"><?php _e('General', 'agy') ?></button>
                <button class="agy-tablinks" onclick="openTab(event, 'agy-tab2')"><?php _e('Text', 'agy') ?></button>
                <button class="agy-tablinks" onclick="openTab(event, 'agy-tab3')"><?php _e('Design', 'agy') ?></button>
                <button class="agy-tablinks" onclick="openTab(event, 'agy-tab4')"><?php _e('Docs', 'agy') ?></button>
            </div>
            <?php
        }

        protected function agy_templates() {
		    ?>
            <div id="agy-tab1" class="agy-tabcontent">
                <h3 style="color: #004e7c"><?php _e('General', 'agy') ?></h3>
                <!-- Instantiate a new class for Settings API -->
            </div>

            <div id="agy-tab2" class="agy-tabcontent">
                <h3 style="color: #004e7c"><?php _e('Text', 'agy') ?></h3>
                <!-- Instantiate a new class for Settings API -->
            </div>

            <div id="agy-tab3" class="agy-tabcontent">
                <h3 style="color: #004e7c"><?php _e('Design', 'agy') ?></h3>
                <!-- Instantiate a new class for Settings API -->
            </div>
            <div id="agy-tab4" class="agy-tabcontent">
                <h3 style="color: #004e7c"><?php _e('Docs', 'agy') ?></h3>
                <!-- Instantiate a new class for Settings API -->
            </div>
            <?php
        }

		public function agy_dashboard_page() {
			?>
			<style>div#wpwrap{background:#dce1e3!important}</style>
			<div id="agy-wrap" class="wrap">
                <?php $this->agy_header_tabs(); ?>
                <?php $this->agy_templates(); ?>
				<form action="options.php" method="post">

					<?php
					settings_fields( 'agy_settings_fields' );
					do_settings_sections( 'agy_settings_section' );

					submit_button(
						__('Save Changes', 'agy'),
						'',
						'agy-save-changes-btn',
						true,
						array('id'=>'agy-save-changes-btn')
					);
//					wp_nonce_field('agy-dashboard-save','agy-dashboard-save-nonce');
					?>

				</form>
			</div>
		    <?php
		}

		public function agy_register_settings() {
		    register_setting(
                'agy_settings_fields',
                'agy_settings_fields',
                'agy_sanitize_callback'
            );

		    add_settings_section(
                'agy_section_id',
                'Agy General',
                array($this, 'agy_settings_section_callback'),
                'agy_settings_section'
            );

		    // This is an example field
		    add_settings_field(
                'agy_section_id_test',
                'Test',
                array($this, 'test'),
                'agy_settings_section',
                'agy_section_id'
            );
		}

		// This is an example field
		public function test()
		{
			$options = get_option( 'agy_settings_fields' );
			$is_options_empty = ( ! empty( $options[ 'test' ] ) ? $options[ 'test' ] : '' );

			echo '
                <textarea id="agy_section_id_test" name="agy_settings_fields[test]" 
                placeholder="Test" rows="10" cols="100">' .
			     esc_attr( sanitize_text_field( $is_options_empty ) )
			     . '</textarea>';
		}

		public function agy_settings_section_callback() {
		    return 'Settings section callback text';
		}
	}
	new Agy_Dashboard();
}