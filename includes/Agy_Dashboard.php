<?php
/**
 * Class Agy_Dashboard
 * All major methods for plugin
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

        public function agy_modal_template() { ?>
            <div style="<?= $this->template_styling('', '', '', 'z_index') ?>" id="agy-my-modal" class="agy-modal">
                <div style="<?= $this->template_styling('', '', 'background_color') ?>" class="agy-modal-content">
                    <div class="agy-headline">
                        <p style="<?= $this->template_styling('headline_font_size', 'headline_color') ?>">
					        <?php echo $this->options_check('headline') ?>
                        </p>
                        <div class="agy-separator-horizontal-line"></div>
                    </div>
                    <div class="agy-subtitle">
                        <p style="<?= $this->template_styling('subtitle_font_size', 'subtitle_color') ?>">
					        <?php echo $this->options_check('subtitle') ?>
                        </p>
                    </div>
                    <div class="agy-description">
                        <p style="<?= $this->template_styling('message_font_size', 'message_color') ?>">
					        <?php echo $this->options_check('message') ?>
                        </p>
                    </div>
                    <div class="agy-enter-btn">
                        <button style="<?= $this->template_styling('btn_font_size', 'btn_font_color', 'btn_background_color') ?>" type="button">
					        <?php echo $this->options_check('enter_btn') ?>
                        </button>
                    </div>
                    <div class="agy-separator">
                        <p style="<?= $this->template_styling('separator_font_size', 'separator_color') ?>">
					        <?php echo $this->options_check('separator_text') ?>
                        </p>
                    </div>
                    <div class="agy-exit-btn">
                        <a href="<?php echo $this->options_check('exit_url') ?>">
                            <button style="<?= $this->template_styling('exit_btn_font_size', 'exit_btn_font_color', 'exit_btn_background_color') ?>" type="button"><?php echo $this->options_check('exit_btn') ?></button>
                        </a>
                    </div>
                    <div class="agy-footer">
                        <p style="<?= $this->template_styling('slogan_font_size', 'slogan_color') ?>">
					        <?php echo $this->options_check('slogan') ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php }

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
                <div class="agy-tab-header-wrapper">
                    <div class="agy-tab-header-wrapper-left">
                        <a href="https://mlab-studio.com" target="_blank">
                            <img class="agy-logo" src="<?php echo plugins_url( '../admin/assets/img/agy-logo.png', __FILE__ ) ?>">
                        </a>
                    </div>
                    <div class="agy-tab-header-wrapper-right">
                        <a href="#" target="_blank" class="agy-right-header-side" target="_blank"><?php _e('Upgrade to PRO', 'agy') ?></a>
                        <a href="#" target="_blank" class="agy-right-header-side" target="_blank"><?php _e('Documentation', 'agy') ?></a>
                        <a href="#" target="_blank" class="agy-right-header-side" target="_blank"><?php _e('Give us 5 stars', 'agy') ?></a>
                        <a href="#" target="_blank" class="agy-right-header-side" target="_blank"><?php _e('FAQ', 'agy') ?></a>
                    </div>
                </div>
            </div>
            <div class="agy-tab">
                <button id="default-open" class="agy-tablinks" onclick="openTab(event, 'agy-tab1')"><?php _e('General', 'agy') ?></button>
                <button class="agy-tablinks" onclick="openTab(event, 'agy-tab2')"><?php _e('Text', 'agy') ?></button>
                <button class="agy-tablinks" onclick="openTab(event, 'agy-tab3')"><?php _e('Design', 'agy') ?></button>
                <button class="agy-tablinks agy-wc-pro" onclick="openTab(event, 'agy-tab4')"><?php _e('WooCommerce', 'agy') ?><span class="agy-pro-content">pro</span></button>
            </div>
            <?php
        }

		public function agy_dashboard_page() {
			?>
			<style>div#wpwrap{background:rgba(183, 50, 37, .1)!important}</style>
			<div id="agy-wrap" class="wrap">
                <?php $this->agy_header_tabs(); ?>
				<form action="options.php" method="post">

                    <?php
                    wp_nonce_field('agy-dashboard-save','agy-dashboard-save-nonce'); // CHECK THIS AT THE END
					settings_fields( 'agy_settings_fields' );
					?>

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
                    if (isset($_POST['agy-save-changes-btn'])) {
                        if(!wp_verify_nonce('agy-dashboard-save-nonce', 'agy-dashboard-save')) {
                            wp_die(__('This is a secure WordPress plugin. Go and take a coffee.'));
                        }
                    }
                    ?>

                    <?php
					submit_button(
						__('Save Changes', 'agy'),
						'',
						'agy-save-changes-btn',
						true,
						array('id'=>'agy-save-changes-btn')
					);
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

		    // Adding sections
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
				__('WooCommerce', 'agy'),
				array($this, 'agy_settings_section_tab4_callback'),
				'agy_settings_section_tab4'
			);

		    // General page fields
			add_settings_field(
				'agy_section_id_enabled_disabled',
				__('Enable / Disable', 'agy'),
				array($this, 'agy_section_id_enabled_disabled'),
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

			add_settings_field(
				'agy_section_id_exit_url',
				__('Exit URL', 'agy'),
				array($this, 'agy_section_id_exit_url'),
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
				'agy_section_id_subtitle',
				__('Subtitle', 'agy'),
				array($this, 'agy_section_id_subtitle'),
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
				'agy_section_id_headline_font_size',
				__('Headline Font size ( in px )', 'agy'),
				array($this, 'agy_section_id_headline_font_size'),
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
				'agy_section_id_separator_font_size',
				__('Separator Font size ( in px )', 'agy'),
				array($this, 'agy_section_id_separator_font_size'),
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
				'agy_section_id_subtitle_font_size',
				__('Subtitle Font size ( in px )', 'agy'),
				array($this, 'agy_section_id_subtitle_font_size'),
				'agy_settings_section_tab3',
				'agy_section_id'
			);

			add_settings_field(
				'agy_section_id_message_color',
				__('Message Color', 'agy'),
				array($this, 'agy_section_id_message_color'),
				'agy_settings_section_tab3',
				'agy_section_id'
			);

			add_settings_field(
				'agy_section_id_message_font_size',
				__('Message Font size ( in px )', 'agy'),
				array($this, 'agy_section_id_message_font_size'),
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
				'agy_section_id_slogan_font_size',
				__('Slogan Font size ( in px )', 'agy'),
				array($this, 'agy_section_id_slogan_font_size'),
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
				'agy_section_id_btn_font_size',
				__('Enter Button font size ( in px )', 'agy'),
				array($this, 'agy_section_id_btn_font_size'),
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
				'agy_section_id_exit_btn_font_size',
				__('Exit Button font size ( in px )', 'agy'),
				array($this, 'agy_section_id_exit_btn_font_size'),
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
			_e('Coming soon.', 'agy');
		}

		public function options_check($id): string {
			$options = get_option('agy_settings_fields');
			return (!empty($options[$id]) ? $options[$id] : '');
		}

		public function option_check_radio_btn($id): string {
			$options = get_option('agy_settings_fields');
			return isset($options[$id]) ? checked(1, $options[$id], false) : '';
		}

		public function template_styling($option_font_size = '', $option_color = '', $option_background_color = '', $option_z_index = ''): string {
			return 'font-size: '.$this->options_check($option_font_size).'px; color: '.$this->options_check($option_color).'; background: '.$this->options_check($option_background_color).'; z-index: '.$this->options_check($option_z_index).';';
		}

		// General page fields
		public function agy_section_id_enabled_disabled() {
			echo '<label class="agy-switch" for="agy-enabled-disabled"><input type="checkbox" id="agy-enabled-disabled" 
                class="agy-switch-input" name="agy_settings_fields[enabled_disabled]" 
                value="1" '.$this->option_check_radio_btn('enabled_disabled').'>
                <span class="agy-slider agy-round"></span></label>';
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
			    <small class="agy-field-desc">'.__('Turn off the cookie for testing purpose. While the Debug mode is on, "Show for unregistered users only" field will not be usable. Don\'t forget to turn it off when you finish.', 'agy').'</small>';
		}

		public function agy_section_id_exit_url() {
			echo '<input type="url" id="agy-exit-url" 
                class="agy-settings-field" name="agy_settings_fields[exit_url]" 
                placeholder="https://domain.com" value="'.esc_attr__(sanitize_text_field($this->options_check('exit_url'))).'">
                <small class="agy-field-desc">'.__('The redirect URL if the exit button was clicked', 'agy').'</small>';
		}

		// Text page fields
		public function agy_section_id_headline() {
			echo '<input type="text" id="agy-headline" 
                class="agy-settings-field" name="agy_settings_fields[headline]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('headline'))).'"
                placeholder="'.__('This is a headline', 'agy').'">';
		}

		public function agy_section_id_subtitle() {
			echo '<input type="text" id="agy-subtitle" 
                class="agy-settings-field" name="agy_settings_fields[subtitle]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('subtitle'))).'"
                placeholder="'.__('This is a subtitle', 'agy').'">';
		}

		public function agy_section_id_message() {
			echo '<textarea class="agy-settings-field" name="agy_settings_fields[message]" placeholder="'.__('This is a message', 'agy').'" 
                id="agy-message" rows="7">'.esc_attr__(sanitize_text_field($this->options_check('message'))).'</textarea>';
		}

		public function agy_section_id_enter_btn() {
			echo '<input type="text" id="agy-enter-btn" 
                class="agy-settings-field" name="agy_settings_fields[enter_btn]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('enter_btn'))).'"
                placeholder="'.__('I am older, enter', 'agy').'">';
		}

		public function agy_section_id_exit_btn() {
			echo '<input type="text" id="agy-exit-btn" 
                class="agy-settings-field" name="agy_settings_fields[exit_btn]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('exit_btn'))).'"
                placeholder="'.__('I am not older, exit', 'agy').'">';
		}

		public function agy_section_id_separator_text() {
			echo '<input type="text" id="agy-separator-text" 
                class="agy-settings-field" name="agy_settings_fields[separator_text]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('separator_text'))).'"
                 placeholder="'.__('This is a separator text', 'agy').'">';
		}

		public function agy_section_id_slogan() {
			echo '<textarea class="agy-settings-field" name="agy_settings_fields[slogan]" placeholder="'.__('This is a slogan', 'agy').'"
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
                value="'.esc_attr__(sanitize_text_field($this->options_check('z_index'))).'"
                placeholder="1">';
		}

		public function agy_section_id_box_width() {
			echo '<input type="text" id="agy-box-width" 
                class="agy-settings-field" name="agy_settings_fields[box_width]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('box_width'))).'"
                placeholder="400px">
                <small class="agy-field-desc">'.__('Width of the popup container', 'agy').'</small>';
		}

		public function agy_section_id_headline_color() {
			echo '<input type="color" id="agy-headline-color" 
                class="agy-settings-color" name="agy_settings_fields[headline_color]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('headline_color'))).'">';
		}

		public function agy_section_id_headline_font_size() {
			echo '<input type="number" id="agy-headline-font-size" 
                class="agy-settings-field" name="agy_settings_fields[headline_font_size]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('headline_font_size'))).'"
                placeholder="16">';
		}

		public function agy_section_id_separator_color() {
			echo '<input type="color" id="agy-separator-color" 
                class="agy-settings-color" name="agy_settings_fields[separator_color]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('separator_color'))).'">';
		}

		public function agy_section_id_separator_font_size() {
			echo '<input type="number" id="agy-separator-font-size" 
                class="agy-settings-field" name="agy_settings_fields[separator_font_size]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('separator_font_size'))).'"
                placeholder="16">';
		}

		public function agy_section_id_subtitle_color() {
			echo '<input type="color" id="agy-subtitle-color" 
                class="agy-settings-color" name="agy_settings_fields[subtitle_color]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('subtitle_color'))).'">';
		}

		public function agy_section_id_subtitle_font_size() {
			echo '<input type="number" id="agy-subtitle-font-size" 
                class="agy-settings-field" name="agy_settings_fields[subtitle_font_size]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('subtitle_font_size'))).'"
                placeholder="16">';
		}

		public function agy_section_id_message_color() {
			echo '<input type="color" id="agy-message-color" 
                class="agy-settings-color" name="agy_settings_fields[message_color]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('message_color'))).'">';
		}

		public function agy_section_id_message_font_size() {
			echo '<input type="number" id="agy-message-font-size" 
                class="agy-settings-field" name="agy_settings_fields[message_font_size]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('message_font_size'))).'"
                placeholder="16">';
		}

		public function agy_section_id_slogan_color() {
			echo '<input type="color" id="agy-slogan-color" 
                class="agy-settings-color" name="agy_settings_fields[slogan_color]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('slogan_color'))).'">';
		}

		public function agy_section_id_slogan_font_size() {
			echo '<input type="number" id="agy-slogan-font-size" 
                class="agy-settings-field" name="agy_settings_fields[slogan_font_size]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('slogan_font_size'))).'"
                placeholder="16">';
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

		public function agy_section_id_btn_font_size() {
			echo '<input type="number" id="agy-btn-font-size" 
                class="agy-settings-field" name="agy_settings_fields[btn_font_size]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('btn_font_size'))).'"
                placeholder="16">';
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

		public function agy_section_id_exit_btn_font_size() {
			echo '<input type="number" id="agy-exit_btn_font_size" 
                class="agy-settings-field" name="agy_settings_fields[exit_btn_font_size]" 
                value="'.esc_attr__(sanitize_text_field($this->options_check('exit_btn_font_size'))).'"
                placeholder="16">';
		}
	}
	new Agy_Dashboard();
}