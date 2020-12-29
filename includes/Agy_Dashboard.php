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

		public function agy_dashboard_page() {
			?>
			<style>div#wpwrap{background:#dce1e3!important}</style>
			<div id="agy-wrap" class="wrap">
                <?php $this->agy_header_tabs(); ?>
				<form action="options.php" method="post">

					<?php
					settings_fields( 'agy_settings_fields' ); ?>

                    <div id="agy-tab1" class="agy-tabcontent">
                        <?php do_settings_sections( 'agy_settings_section_tab1' ); ?>
                    </div>

                    <div id="agy-tab2" class="agy-tabcontent">
						<?php do_settings_sections( 'agy_settings_section_tab2' ); ?>
                    </div>

                    <div id="agy-tab3" class="agy-tabcontent">
						<?php do_settings_sections( 'agy_settings_section_tab3' ); ?>
                    </div>

                    <div id="agy-tab4" class="agy-tabcontent">
						<?php do_settings_sections( 'agy_settings_section_tab4' ); ?>
                    </div>

                    <?php
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
                'agy_settings_section_tab1'
            );

		    add_settings_field(
                'agy_section_id_age',
                __('Minimum Age', 'agy'),
                array($this, 'agy_section_id_age'),
                'agy_settings_section_tab1',
                'agy_section_id'
            );

		    add_settings_field(
                'agy_section_id_exit_url',
                __('Exit URL', 'agy'),
                array($this, 'agy_section_id_exit_url'),
                'agy_settings_section_tab1',
                'agy_section_id'
            );

			add_settings_field(
				'agy_section_id_cookie_lifetime',
				__('Cookie Lifetime ( in days )', 'agy'),
				array($this, 'agy_section_id_cookie_lifetime'),
				'agy_settings_section_tab1',
				'agy_section_id'
			);
		}

		public function agy_section_id_age() {
			$options = get_option( 'agy_settings_fields' );
			$is_options_empty = ( ! empty( $options[ 'age' ] ) ? $options[ 'age' ] : '' );

			echo '
                <input type="number" id="agy-age" 
                class="agy-settings-field" name="agy_settings_fields[age]" 
                value="'.esc_attr__(sanitize_text_field($is_options_empty)).'">';
		}

        public function agy_section_id_exit_url() {
			$options = get_option( 'agy_settings_fields' );
			$is_options_empty = ( ! empty( $options[ 'exit_url' ] ) ? $options[ 'exit_url' ] : '' );

			echo '
                <input type="url" id="agy-exit-url" 
                class="agy-settings-field" name="agy_settings_fields[exit_url]" 
                placeholder="https://domain.com" value="'.esc_attr__(sanitize_text_field($is_options_empty)).'">';
		}

		public function agy_section_id_cookie_lifetime() {
			$options = get_option( 'agy_settings_fields' );
			$is_options_empty = ( ! empty( $options[ 'cookie_lifetime' ] ) ? $options[ 'cookie_lifetime' ] : '' );

			echo '
                <input type="number" id="agy-cookie-lifetime" 
                class="agy-settings-field" name="agy_settings_fields[cookie_lifetime]" 
                value="'.esc_attr__(sanitize_text_field($is_options_empty)).'">';
		}

		public function agy_settings_section_callback() {
		    return 'Settings section callback text';
		}
	}
	new Agy_Dashboard();
}