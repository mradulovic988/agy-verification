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
		    settings_errors(); // CHECK THIS
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
            <div class="agy-tab-header">
                <a href="https://mlab-studio.com" target="_blank">
                    <!-- CHANGE THE IMAGE POSITION INSIDE THE PLUGIN!!! -->
                    <img class="agy-logo" src="http://localhost/age-verification/wp-content/uploads/2020/12/agy-logo.png" alt="Agy Verification logo">
                </a>
            </div>
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

					<?php settings_fields( 'agy_settings_fields' ); ?>

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
                __('Agy General', 'agy'),
                array($this, 'agy_settings_section_callback'),
                'agy_settings_section_tab1'
            );

			add_settings_section(
				'agy_section_id',
				__('Text', 'agy'),
				array($this, 'agy_settings_section_tab2_callback'),
				'agy_settings_section_tab2'
			);

			add_settings_section(
				'agy_section_id',
				__('Design', 'agy'),
				array($this, 'agy_settings_section_tab3_callback'),
				'agy_settings_section_tab3'
			);

			add_settings_section(
				'agy_section_id',
				__('Docs', 'agy'),
				array($this, 'agy_settings_section_tab4_callback'),
				'agy_settings_section_tab4'
			);

		    // General page fields
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

			add_settings_field(
				'agy_section_id_unregister_user',
				__('Show for unregistered users only', 'agy'),
				array($this, 'agy_section_id_unregister_user'),
				'agy_settings_section_tab1',
				'agy_section_id'
			);

			add_settings_field(
				'agy_section_id_debug_mode',
				__('Activate Debug mode', 'agy'),
				array($this, 'agy_section_id_debug_mode'),
				'agy_settings_section_tab1',
				'agy_section_id'
			);

			// Texts page fields
			add_settings_field(
				'agy_section_id_headline',
				__('Headline', 'agy'),
				array($this, 'agy_section_id_headline'),
				'agy_settings_section_tab2',
				'agy_section_id'
			);

			add_settings_field(
				'agy_section_id_message',
				__('Message', 'agy'),
				array($this, 'agy_section_id_message'),
				'agy_settings_section_tab2',
				'agy_section_id'
			);

			add_settings_field(
				'agy_section_id_enter_btn',
				__('Enter Button Label', 'agy'),
				array($this, 'agy_section_id_enter_btn'),
				'agy_settings_section_tab2',
				'agy_section_id'
			);

			add_settings_field(
				'agy_section_id_exit_btn',
				__('Exit Button Label', 'agy'),
				array($this, 'agy_section_id_exit_btn'),
				'agy_settings_section_tab2',
				'agy_section_id'
			);

			add_settings_field(
				'agy_section_id_separator_text',
				__('Separator Text', 'agy'),
				array($this, 'agy_section_id_separator_text'),
				'agy_settings_section_tab2',
				'agy_section_id'
			);

			add_settings_field(
				'agy_section_id_subtitle',
				__('Subtitle', 'agy'),
				array($this, 'agy_section_id_subtitle'),
				'agy_settings_section_tab2',
				'agy_section_id'
			);

			add_settings_field(
				'agy_section_id_slogan',
				__('Slogan', 'agy'),
				array($this, 'agy_section_id_slogan'),
				'agy_settings_section_tab2',
				'agy_section_id'
			);

			// Design page fields
			add_settings_field(
				'agy_section_id_background_color',
				__('Background color', 'agy'),
				array($this, 'agy_section_id_background_color'),
				'agy_settings_section_tab3',
				'agy_section_id'
			);

			add_settings_field(
				'agy_section_id_z_index',
				__('Z-Index ( Overlay )', 'agy'),
				array($this, 'agy_section_id_z_index'),
				'agy_settings_section_tab3',
				'agy_section_id'
			);

			add_settings_field(
				'agy_section_id_box_width',
				__('Content Box width ( in px )', 'agy'),
				array($this, 'agy_section_id_box_width'),
				'agy_settings_section_tab3',
				'agy_section_id'
			);

			add_settings_field(
				'agy_section_id_headline_color',
				__('Headline Color', 'agy'),
				array($this, 'agy_section_id_headline_color'),
				'agy_settings_section_tab3',
				'agy_section_id'
			);

			add_settings_field(
				'agy_section_id_instruction_color',
				__('Instruction Color', 'agy'),
				array($this, 'agy_section_id_instruction_color'),
				'agy_settings_section_tab3',
				'agy_section_id'
			);

			add_settings_field(
				'agy_section_id_separator_color',
				__('Separator Color', 'agy'),
				array($this, 'agy_section_id_separator_color'),
				'agy_settings_section_tab3',
				'agy_section_id'
			);

			add_settings_field(
				'agy_section_id_subtitle_color',
				__('Subtitle Color', 'agy'),
				array($this, 'agy_section_id_subtitle_color'),
				'agy_settings_section_tab3',
				'agy_section_id'
			);

			add_settings_field(
				'agy_section_id_slogan_color',
				__('Slogan Color', 'agy'),
				array($this, 'agy_section_id_slogan_color'),
				'agy_settings_section_tab3',
				'agy_section_id'
			);

			add_settings_field(
				'agy_section_id_btn_background_color',
				__('Enter Button background color', 'agy'),
				array($this, 'agy_section_id_btn_background_color'),
				'agy_settings_section_tab3',
				'agy_section_id'
			);

			add_settings_field(
				'agy_section_id_btn_font_color',
				__('Enter Button font color', 'agy'),
				array($this, 'agy_section_id_btn_font_color'),
				'agy_settings_section_tab3',
				'agy_section_id'
			);

			add_settings_field(
				'agy_section_id_exit_btn_background_color',
				__('Exit Button background color', 'agy'),
				array($this, 'agy_section_id_exit_btn_background_color'),
				'agy_settings_section_tab3',
				'agy_section_id'
			);

			add_settings_field(
				'agy_section_id_exit_btn_font_color',
				__('Exit Button font color', 'agy'),
				array($this, 'agy_section_id_exit_btn_font_color'),
				'agy_settings_section_tab3',
				'agy_section_id'
			);

			add_settings_field(
				'agy_section_id_blur_effect',
				__('Use blur effect', 'agy'),
				array($this, 'agy_section_id_blur_effect'),
				'agy_settings_section_tab3',
				'agy_section_id'
			);

			add_settings_field(
				'agy_section_id_blur_effect_container',
				__('Blur effect container', 'agy'),
				array($this, 'agy_section_id_blur_effect_container'),
				'agy_settings_section_tab3',
				'agy_section_id'
			);

			add_settings_field(
				'agy_section_id_blur_effect_strength',
				__('Blur effect strength', 'agy'),
				array($this, 'agy_section_id_blur_effect_strength'),
				'agy_settings_section_tab3',
				'agy_section_id'
			);
		}

		public function agy_settings_section_callback() {
		    // CHANGE DESCRIPTION LATER
			_e('Donec sollicitudin molestie malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim.', 'agy');
		}

        public function agy_settings_section_tab2_callback() {
		    // CHANGE DESCRIPTION LATER
			_e('Donec sollicitudin molestie malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim.', 'agy');
		}

        public function agy_settings_section_tab3_callback() {
		    // CHANGE DESCRIPTION LATER
			_e('Donec sollicitudin molestie malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim.', 'agy');
		}

		public function agy_settings_section_tab4_callback() {
			// CHANGE DESCRIPTION LATER
			_e('Donec sollicitudin molestie malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim.', 'agy');
		}

		protected function options_check($id): string {
			$options = get_option('agy_settings_fields');
			return (!empty($options[$id]) ? $options[$id] : '');
		}

		protected function option_check_radio_btn($id): string {
			$options = get_option('agy_settings_fields');
			return isset($options[$id]) ? checked(1, $options[$id], false) : '';
		}

		// General page fields
		public function agy_section_id_age() {
			echo '<input type="number" id="agy-age" 
                class="agy-settings-field" name="agy_settings_fields[age]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('age'))).'">';
		}

        public function agy_section_id_exit_url() {
			echo '<input type="url" id="agy-exit-url" 
                class="agy-settings-field" name="agy_settings_fields[exit_url]" 
                placeholder="https://domain.com" value="'.esc_attr__(sanitize_text_field($this->options_check('exit_url'))).'">
                <small class="agy-field-desc">'.__('The redirect URL if the exit button was clicked', 'agy').'</small>';
		}

		public function agy_section_id_cookie_lifetime() {
			echo '<input type="number" id="agy-cookie-lifetime" 
                class="agy-settings-field" name="agy_settings_fields[cookie_lifetime]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('cookie_lifetime'))).'">';
		}

		public function agy_section_id_unregister_user() {
            echo '<label class="agy-switch" for="agy-unregister-user"><input type="checkbox" id="agy-unregister-user" 
                class="agy-switch-input" name="agy_settings_fields[unregister_user]" 
                value="1" '.$this->option_check_radio_btn('unregister_user').'>
                <span class="agy-slider agy-round"></span></label>';
		}

		public function agy_section_id_debug_mode() {
            echo '<label class="agy-switch" for="agy-debug-mode"><input type="checkbox" id="agy-debug-mode" 
                class="agy-switch-input" name="agy_settings_fields[debug_mode]" 
                value="1" '.$this->option_check_radio_btn('debug_mode').'>
			    <span class="agy-slider agy-round"></span></label>
			    <small class="agy-field-desc">'.__('Turn off the cookie for testing purpose', 'agy').'</small>';
		}

		// Text page fields
		public function agy_section_id_headline() {
			echo '<input type="text" id="agy-headline" 
                class="agy-settings-field" name="agy_settings_fields[headline]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('headline'))).'">';
		}

		public function agy_section_id_message() {
			echo '<textarea class="agy-settings-field" name="agy_settings_fields[message]" 
                id="agy-message" rows="7">'.esc_attr__(sanitize_text_field($this->options_check('message'))).'</textarea>';
		}

		public function agy_section_id_enter_btn() {
			echo '<input type="text" id="agy-enter-btn" 
                class="agy-settings-field" name="agy_settings_fields[enter_btn]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('enter_btn'))).'">';
		}

		public function agy_section_id_exit_btn() {
			echo '<input type="text" id="agy-exit-btn" 
                class="agy-settings-field" name="agy_settings_fields[exit_btn]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('exit_btn'))).'">';
		}

		public function agy_section_id_separator_text() {
			echo '<input type="text" id="agy-separator-text" 
                class="agy-settings-field" name="agy_settings_fields[separator_text]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('separator_text'))).'">';
		}

		public function agy_section_id_subtitle() {
			echo '<input type="text" id="agy-subtitle" 
                class="agy-settings-field" name="agy_settings_fields[subtitle]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('subtitle'))).'">';
		}

		public function agy_section_id_slogan() {
			echo '<textarea class="agy-settings-field" name="agy_settings_fields[slogan]" 
                id="agy-slogan" rows="7">'.esc_attr__(sanitize_text_field($this->options_check('slogan'))).'</textarea>';
		}

		// Design page fields
		public function agy_section_id_background_color() {
			echo '<input type="color" id="agy-background-color" 
                class="agy-settings-color" name="agy_settings_fields[background_color]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('background_color'))).'">';
		}

		public function agy_section_id_z_index() {
			echo '<input type="number" id="agy-z-index" 
                class="agy-settings-field" name="agy_settings_fields[z_index]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('z_index'))).'">';
		}

		public function agy_section_id_box_width() {
			echo '<input type="text" id="agy-box-width" 
                class="agy-settings-field" name="agy_settings_fields[box_width]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('box_width'))).'">';
		}

		public function agy_section_id_headline_color() {
			echo '<input type="color" id="agy-headline-color" 
                class="agy-settings-color" name="agy_settings_fields[headline_color]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('headline_color'))).'">';
		}

		public function agy_section_id_instruction_color() {
			echo '<input type="color" id="agy-instruction-color" 
                class="agy-settings-color" name="agy_settings_fields[instruction_color]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('instruction_color'))).'">';
		}

		public function agy_section_id_separator_color() {
			echo '<input type="color" id="agy-separator-color" 
                class="agy-settings-color" name="agy_settings_fields[separator_color]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('separator_color'))).'">';
		}

		public function agy_section_id_subtitle_color() {
			echo '<input type="color" id="agy-subtitle-color" 
                class="agy-settings-color" name="agy_settings_fields[subtitle_color]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('subtitle_color'))).'">';
		}

		public function agy_section_id_slogan_color() {
			echo '<input type="color" id="agy-slogan-color" 
                class="agy-settings-color" name="agy_settings_fields[slogan_color]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('slogan_color'))).'">';
		}

		public function agy_section_id_btn_background_color() {
			echo '<input type="color" id="agy-btn-background-color" 
                class="agy-settings-color" name="agy_settings_fields[btn_background_color]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('btn_background_color'))).'">';
		}

		public function agy_section_id_btn_font_color() {
			echo '<input type="color" id="agy-btn-font-color" 
                class="agy-settings-color" name="agy_settings_fields[btn_font_color]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('btn_font_color'))).'">';
		}

		public function agy_section_id_exit_btn_background_color() {
			echo '<input type="color" id="agy-exit-btn-background-color" 
                class="agy-settings-color" name="agy_settings_fields[exit_btn_background_color]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('exit_btn_background_color'))).'">';
		}

		public function agy_section_id_exit_btn_font_color() {
			echo '<input type="color" id="agy-exit-btn-font-color" 
                class="agy-settings-color" name="agy_settings_fields[exit_btn_font_color]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('exit_btn_font_color'))).'">';
		}

		public function agy_section_id_blur_effect() {
			echo '<label class="agy-switch" for="agy-blur-effect"><input type="checkbox" id="agy-blur-effect" 
                class="agy-switch-input" name="agy_settings_fields[blur_effect]" 
                value="1" '.$this->option_check_radio_btn('blur_effect').'>
                <span class="agy-slider agy-round"></span></label>';
		}

		public function agy_section_id_blur_effect_container() {
			echo '<input type="text" id="agy-blur-effect-container" 
                class="agy-settings-field" name="agy_settings_fields[blur_effect_container]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('blur_effect_container'))).'">';
		}

		public function agy_section_id_blur_effect_strength() {
			echo '<input type="number" id="agy-blur-effect-strength" 
                class="agy-settings-field" name="agy_settings_fields[blur_effect_strength]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('blur_effect_strength'))).'">';
		}
	}
	new Agy_Dashboard();
}