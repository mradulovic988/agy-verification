<?php
/**
 * Main class for all communication between front-end and as well with the back-end
 *
 * @class Agy_Dashboard
 * @package Agy_Dashboard
 * @version 1.0.0
 * @author Marko Radulovic
 */

if ( ! class_exists( 'Agy_Dashboard' ) ) {

	class Agy_Dashboard {
		public function __construct() {
			if ( is_admin() ) {
				add_action( 'admin_menu', array( $this, 'agy_dashboard' ) );
				add_action( 'admin_notices', array( $this, 'agy_show_error_notice' ) );
				add_action( 'admin_init', array( $this, 'agy_register_settings' ) );
			}
		}

		public function agy_show_error_notice() {
			settings_errors(); // CHECK THIS
		}

		// Front-end modal template
		public function agy_modal_template() { ?>
            <div style="<?= $this->agy_template_styling( '', '', '', 'z_index' ) ?>" id="agy-my-modal" class="agy-modal">
                <div style="<?= $this->agy_template_styling( '', '', 'background_color', '', 'box_width' ) ?>"
                     class="agy-modal-content">
                    <div class="agy-headline">
                        <p style="<?= $this->agy_template_styling( 'headline_font_size', 'headline_color' ) ?>">
							<?php echo $this->agy_options_check( 'headline' ) ?>
                        </p>
                        <div class="agy-separator-horizontal-line"></div>
                    </div>
                    <div class="agy-subtitle">
                        <p style="<?= $this->agy_template_styling( 'subtitle_font_size', 'subtitle_color' ) ?>">
							<?php echo $this->agy_options_check( 'subtitle' ) ?>
                        </p>
                    </div>
                    <div class="agy-description">
                        <p style="<?= $this->agy_template_styling( 'message_font_size', 'message_color' ) ?>">
							<?php echo $this->agy_options_check( 'message' ) ?>
                        </p>
                    </div>
                    <div class="agy-enter-btn">
                        <button
                            style="<?= $this->agy_template_styling( 'btn_font_size', 'btn_font_color', 'btn_background_color', '', '', 'btn_border_style', 'btn_border_color' ) ?>"
                            type="button">
							<?php echo $this->agy_options_check( 'enter_btn' ) ?>
                        </button>
                    </div>
                    <div class="agy-separator">
                        <p style="<?= $this->agy_template_styling( 'separator_font_size', 'separator_color' ) ?>">
							<?php echo $this->agy_options_check( 'separator_text' ) ?>
                        </p>
                    </div>
                    <div class="agy-exit-btn">
                        <a href="<?php echo $this->agy_options_check( 'exit_url' ) ?>">
                            <button
                                style="<?= $this->agy_template_styling( 'exit_btn_font_size', 'exit_btn_font_color', 'exit_btn_background_color', '', '', 'exit_btn_border_style', 'exit_btn_border_color' ) ?>"
                                type="button"><?php echo $this->agy_options_check( 'exit_btn' ) ?></button>
                        </a>
                    </div>
                    <div class="agy-footer">
                        <p style="<?= $this->agy_template_styling( 'slogan_font_size', 'slogan_color' ) ?>">
							<?php echo $this->agy_options_check( 'slogan' ) ?>
                        </p>
                    </div>
                </div>
            </div>
			<?php
		}

		/**
		 * Validate and sanitize links
		 *
		 * @param string $header_text Text between the a href
		 * @param string $header_url URL for a href
		 * @param string $header_target Param for target in a href
		 * @param string $header_class Class for a href
		 *
		 * @return string
		 */
		protected function agy_header_links( string $header_text, string $header_url, $header_target = '', $header_class = '' ): string {
			return sprintf(
				wp_kses(
					__( '<a href="%s" target="%s" class="%s">' . $header_text . '</a>', 'agy' ),
					array(
						'a' => array(
							'href'   => array(),
							'target' => array(),
							'class'  => array()
						),
					)
				),

				esc_url( $header_url ),
				__( $header_target, 'agy' ),
				__( $header_class, 'agy' )
			);
		}

		/**
		 * Front-end modal template conditional styling
		 *
		 * @param string $option_font_size Font size declaration
		 * @param string $option_color Color declaration
		 * @param string $option_background_color Background color declaration
		 * @param string $option_z_index Z Index declaration
		 * @param string $option_width Width declaration
		 * @param string $option_border_style Border declaration
		 * @param string $option_border_color Border color declaration
		 *
		 * @return string
		 */
		public function agy_template_styling(
			$option_font_size = '',
			$option_color = '',
			$option_background_color = '',
			$option_z_index = '',
			$option_width = '',
			$option_border_style = '',
			$option_border_color = ''
		): string {
			return 'font-size: ' . $this->agy_options_check( $option_font_size ) . 'px; color: ' . $this->agy_options_check( $option_color ) . '; background: ' . $this->agy_options_check( $option_background_color ) . '; z-index: ' . $this->agy_options_check( $option_z_index ) . '; width: ' . $this->agy_options_check( $option_width ) . '%; border: ' . $this->agy_options_check( $option_border_style ) . ' ' . $this->agy_options_check( $option_border_color ) . ';';
		}

		// Header menu for admin template
		protected function agy_header_tabs() {
			?>
            <div class="agy-tab-header">
                <div class="agy-tab-header-wrapper">
                    <div class="agy-tab-header-wrapper-left">

						<?php
						// Logo
						echo sprintf(
							wp_kses(
								__( '<a href="%s" target="%s"><img src="%s" class="%s"></a>', 'agy' ),
								array(
									'a'   => array(
										'href'   => array(),
										'target' => array()
									),
									'img' => array(
										'src'   => array(),
										'class' => array()
									)
								)
							),

							esc_url( 'https://mlab-studio.com' ),
							__( '_blank', 'agy' ),
							plugins_url( '../admin/assets/img/agy-logo.png', __FILE__ ),
							__( 'agy-logo', 'agy' )
						);
						?>
                    </div>
                    <div class="agy-tab-header-wrapper-right">
						<?php
						echo $this->agy_header_links( 'Give us 5 stars', 'https://wordpress.org/support/plugin/agy-verification/reviews/?filter=5#new-post', '_blank', 'agy-right-header-side' );

						echo $this->agy_header_links( 'Support', 'https://wordpress.org/support/plugin/agy-verification', '_blank', 'agy-right-header-side' );
						?>
                    </div>
                </div>
            </div>
            <div class="agy-tab">
                <button id="default-open" class="agy-tablinks"
                        onclick="openTab(event, 'agy-tab1')"><?php _e( 'General', 'agy' ) ?></button>
                <button class="agy-tablinks" onclick="openTab(event, 'agy-tab2')"><?php _e( 'Text', 'agy' ) ?></button>
                <button class="agy-tablinks"
                        onclick="openTab(event, 'agy-tab3')"><?php _e( 'Design', 'agy' ) ?></button>
            </div>
			<?php
		}

		// Adding submenu page
		public function agy_dashboard() {
			add_submenu_page( 'tools.php', __( 'Agy Verification', 'agy' ), __( 'Agy Verification', 'agy' ), 'manage_options', 'agy-dashboard', array(
				$this,
				'agy_dashboard_page'
			) );
		}

		// Main form on admin part
		public function agy_dashboard_page() {
			?>
            <style>div#wpwrap {background: rgba(183, 50, 37, .1) !important;}</style>
            <div id="agy-wrap" class="wrap">
				<?php $this->agy_header_tabs(); ?>
                <form action="options.php" method="post">

					<?php
					wp_nonce_field( 'agy_dashboard_save', 'agy_form_save_name' ); // CHECK THIS AT THE END
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

					<?php
					submit_button(
						__( 'Save Changes', 'agy' ),
						'',
						'agy_save_changes_btn',
						true,
						array( 'id' => 'agy-save-changes-btn' )
					);
					?>

                </form>

				<?php
				if ( ! isset( $_POST['agy_form_save_name'] ) ||
				     ! wp_verify_nonce( $_POST['agy_form_save_name'], 'agy_dashboard_save' ) ) {
					return;
				}
				?>
            </div>
			<?php
		}

		public function agy_settings_section_callback() {
			// CHANGE DESCRIPTION LATER
			_e( 'Donec sollicitudin molestie malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim.', 'agy' );
		}

		public function agy_settings_section_tab2_callback() {
			// CHANGE DESCRIPTION LATER
			_e( 'Donec sollicitudin molestie malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim.', 'agy' );
		}

		public function agy_settings_section_tab3_callback() {
			// CHANGE DESCRIPTION LATER
			_e( 'Donec sollicitudin molestie malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim.', 'agy' );
		}

		// Settings API
		public function agy_register_settings() {
			register_setting( 'agy_settings_fields', 'agy_settings_fields', 'agy_sanitize_callback' );

			// Adding sections
			add_settings_section( 'agy_section_id', __( 'General', 'agy' ), array(
				$this,
				'agy_settings_section_callback'
			), 'agy_settings_section_tab1' );

			add_settings_section( 'agy_section_id', __( 'Text', 'agy' ), array(
				$this,
				'agy_settings_section_tab2_callback'
			), 'agy_settings_section_tab2' );

			add_settings_section( 'agy_section_id', __( 'Design', 'agy' ), array(
				$this,
				'agy_settings_section_tab3_callback'
			), 'agy_settings_section_tab3' );

			// General page fields
			add_settings_field( 'agy_section_id_enabled_disabled', __( 'Enable / Disable', 'agy' ), array(
				$this,
				'agy_section_id_enabled_disabled'
			), 'agy_settings_section_tab1', 'agy_section_id' );

			add_settings_field( 'agy_section_id_unregister_user', __( 'Show for unregistered users only', 'agy' ), array(
				$this,
				'agy_section_id_unregister_user'
			), 'agy_settings_section_tab1', 'agy_section_id' );

			add_settings_field( 'agy_section_id_debug_mode', __( 'Activate Debug mode', 'agy' ), array(
				$this,
				'agy_section_id_debug_mode'
			), 'agy_settings_section_tab1', 'agy_section_id' );

			add_settings_field( 'agy_section_id_exit_url', __( 'Exit URL', 'agy' ), array(
				$this,
				'agy_section_id_exit_url'
			), 'agy_settings_section_tab1', 'agy_section_id' );

			// Texts page fields
			add_settings_field( 'agy_section_id_headline', __( 'Headline', 'agy' ), array(
				$this,
				'agy_section_id_headline'
			), 'agy_settings_section_tab2', 'agy_section_id' );

			add_settings_field( 'agy_section_id_subtitle', __( 'Subtitle', 'agy' ), array(
				$this,
				'agy_section_id_subtitle'
			), 'agy_settings_section_tab2', 'agy_section_id' );

			add_settings_field( 'agy_section_id_message', __( 'Message', 'agy' ), array(
				$this,
				'agy_section_id_message'
			), 'agy_settings_section_tab2', 'agy_section_id' );

			add_settings_field( 'agy_section_id_enter_btn', __( 'Enter Button Label', 'agy' ), array(
				$this,
				'agy_section_id_enter_btn'
			), 'agy_settings_section_tab2', 'agy_section_id' );

			add_settings_field( 'agy_section_id_exit_btn', __( 'Exit Button Label', 'agy' ), array(
				$this,
				'agy_section_id_exit_btn'
			), 'agy_settings_section_tab2', 'agy_section_id' );

			add_settings_field( 'agy_section_id_separator_text', __( 'Separator Text', 'agy' ), array(
				$this,
				'agy_section_id_separator_text'
			), 'agy_settings_section_tab2', 'agy_section_id' );

			add_settings_field( 'agy_section_id_slogan', __( 'Slogan', 'agy' ), array(
				$this,
				'agy_section_id_slogan'
			), 'agy_settings_section_tab2', 'agy_section_id' );

			// Design page fields
			add_settings_field( 'agy_section_id_background_color', __( 'Background color', 'agy' ), array(
				$this,
				'agy_section_id_background_color'
			), 'agy_settings_section_tab3', 'agy_section_id' );

			add_settings_field( 'agy_section_id_z_index', __( 'Z-Index ( Overlay )', 'agy' ), array(
				$this,
				'agy_section_id_z_index'
			), 'agy_settings_section_tab3', 'agy_section_id' );

			add_settings_field( 'agy_section_id_box_width', __( 'Content Box width ( in px )', 'agy' ), array(
				$this,
				'agy_section_id_box_width'
			), 'agy_settings_section_tab3', 'agy_section_id' );

			add_settings_field( 'agy_section_id_headline_color', __( 'Headline Color', 'agy' ), array(
				$this,
				'agy_section_id_headline_color'
			), 'agy_settings_section_tab3', 'agy_section_id' );

			add_settings_field( 'agy_section_id_headline_font_size', __( 'Headline Font size ( in px )', 'agy' ), array(
				$this,
				'agy_section_id_headline_font_size'
			), 'agy_settings_section_tab3', 'agy_section_id' );

			add_settings_field( 'agy_section_id_subtitle_color', __( 'Subtitle Color', 'agy' ), array(
				$this,
				'agy_section_id_subtitle_color'
			), 'agy_settings_section_tab3', 'agy_section_id' );

			add_settings_field( 'agy_section_id_subtitle_font_size', __( 'Subtitle Font size ( in px )', 'agy' ), array(
				$this,
				'agy_section_id_subtitle_font_size'
			), 'agy_settings_section_tab3', 'agy_section_id' );

			add_settings_field( 'agy_section_id_message_color', __( 'Message Color', 'agy' ), array(
				$this,
				'agy_section_id_message_color'
			), 'agy_settings_section_tab3', 'agy_section_id' );

			add_settings_field( 'agy_section_id_message_font_size', __( 'Message Font size ( in px )', 'agy' ), array(
				$this,
				'agy_section_id_message_font_size'
			), 'agy_settings_section_tab3', 'agy_section_id' );

			add_settings_field( 'agy_section_id_btn_background_color', __( 'Enter Button background color', 'agy' ), array(
				$this,
				'agy_section_id_btn_background_color'
			), 'agy_settings_section_tab3', 'agy_section_id' );

			add_settings_field( 'agy_section_id_btn_font_color', __( 'Enter Button font color', 'agy' ), array(
				$this,
				'agy_section_id_btn_font_color'
			), 'agy_settings_section_tab3', 'agy_section_id' );

			add_settings_field( 'agy_section_id_btn_border_style', __( 'Enter Button border style', 'agy' ), array(
				$this,
				'agy_section_id_btn_border_style'
			), 'agy_settings_section_tab3', 'agy_section_id' );

			add_settings_field( 'agy_section_id_btn_border_color', __( 'Enter Button border color', 'agy' ), array(
				$this,
				'agy_section_id_btn_border_color'
			), 'agy_settings_section_tab3', 'agy_section_id' );

			add_settings_field( 'agy_section_id_btn_font_size', __( 'Enter Button font size ( in px )', 'agy' ), array(
				$this,
				'agy_section_id_btn_font_size'
			), 'agy_settings_section_tab3', 'agy_section_id' );

			add_settings_field( 'agy_section_id_exit_btn_background_color', __( 'Exit Button background color', 'agy' ), array(
				$this,
				'agy_section_id_exit_btn_background_color'
			), 'agy_settings_section_tab3', 'agy_section_id' );

			add_settings_field( 'agy_section_id_exit_btn_font_color', __( 'Exit Button font color', 'agy' ), array(
				$this,
				'agy_section_id_exit_btn_font_color'
			), 'agy_settings_section_tab3', 'agy_section_id' );

			add_settings_field( 'agy_section_id_exit_btn_border_style', __( 'Exit Button border style', 'agy' ), array(
				$this,
				'agy_section_id_exit_btn_border_style'
			), 'agy_settings_section_tab3', 'agy_section_id' );

			add_settings_field( 'agy_section_id_exit_btn_border_color', __( 'Exit Button border color', 'agy' ), array(
				$this,
				'agy_section_id_exit_btn_border_color'
			), 'agy_settings_section_tab3', 'agy_section_id' );

			add_settings_field( 'agy_section_id_exit_btn_font_size', __( 'Exit Button font size ( in px )', 'agy' ), array(
				$this,
				'agy_section_id_exit_btn_font_size'
			), 'agy_settings_section_tab3', 'agy_section_id' );

			add_settings_field( 'agy_section_id_separator_color', __( 'Separator Color', 'agy' ), array(
				$this,
				'agy_section_id_separator_color'
			), 'agy_settings_section_tab3', 'agy_section_id' );

			add_settings_field( 'agy_section_id_separator_font_size', __( 'Separator Font size ( in px )', 'agy' ), array(
				$this,
				'agy_section_id_separator_font_size'
			), 'agy_settings_section_tab3', 'agy_section_id' );

			add_settings_field( 'agy_section_id_slogan_color', __( 'Slogan Color', 'agy' ), array(
				$this,
				'agy_section_id_slogan_color'
			), 'agy_settings_section_tab3', 'agy_section_id' );

			add_settings_field( 'agy_section_id_slogan_font_size', __( 'Slogan Font size ( in px )', 'agy' ), array(
				$this,
				'agy_section_id_slogan_font_size'
			), 'agy_settings_section_tab3', 'agy_section_id' );
		}

		/**
		 * Getting option
		 *
		 * @param string $id Checking option value
		 *
		 * @return string
		 */
		public function agy_options_check( string $id ): string {
			$options = get_option( 'agy_settings_fields' );

			return ( ! empty( $options[ $id ] ) ? $options[ $id ] : '' );
		}

		/**
		 * Getting option for radio buttons only
		 *
		 * @param string $id Checking option value for radio button only
		 *
		 * @return string
		 */
		public function agy_option_check_radio_btn( string $id ): string {
			$options = get_option( 'agy_settings_fields' );

			return isset( $options[ $id ] ) ? checked( 1, $options[ $id ], false ) : '';
		}

		/**
		 * Conditional check for input field in Settings API
		 *
		 * @param string $type Input field type attribute
		 * @param string $id Input field ID attribute
		 * @param string $class Input field class attribute
		 * @param string $name Input field name attribute
		 * @param string $value Input field value attribute
		 * @param string $placeholder Input field placeholder attribute
		 * @param string $description Input field description
		 * @param string $min Input field min attribute
		 * @param string $max Input field max attribute
		 */
		protected function agy_settings_fields( string $type, string $id, string $class, string $name, string $value, $placeholder = '', $description = '', $min = '', $max = '' ) {
			switch ( $type ) {
				case 'text':
					echo '<input type="text" id="' . $id . '" class="' . $class . '" name="agy_settings_fields[' . $name . ']" value="' . $value . '" placeholder="' . __( $placeholder, 'agy' ) . '"><small class="agy-field-desc">' . __( $description, 'agy' ) . '</small>';
					break;
				case 'number':
					echo '<input type="number" id="' . $id . '" class="' . $class . '" name="agy_settings_fields[' . $name . ']" value="' . $value . '" placeholder="' . __( $placeholder, 'agy' ) . '" min="' . $min . '" max="' . $max . '"><small class="agy-field-desc">' . __( $description, 'agy' ) . '</small>';
					break;
				case 'checkbox':
					echo '<label class="agy-switch" for="' . $id . '"><input type="checkbox" id="' . $id . '" class="' . $class . '" name="agy_settings_fields[' . $name . ']" value="1" ' . $value . '><span class="agy-slider agy-round"></span></label><small class="agy-field-desc">' . $description . '</small>';
					break;
				case 'url':
					echo '<input type="url" id="' . $id . '" class="' . $class . '" name="agy_settings_fields[' . $name . ']" value="' . $value . '"placeholder="' . __( $placeholder, 'agy' ) . '"><small class="agy-field-desc">' . __( $description, 'agy' ) . '</small>';
					break;
				case 'color':
					echo '<input type="color" id="' . $id . '" class="' . $class . '" name="agy_settings_fields[' . $name . ']" value="' . $value . '">';
					break;
				case 'textarea':
					echo '<textarea class="' . $class . '" name="agy_settings_fields[' . $name . ']" placeholder="' . __( $placeholder, 'agy' ) . '" id="' . $id . '" rows="7">' . $value . '</textarea>';
					break;
			}
		}

		// General page Settings API fields
		public function agy_section_id_enabled_disabled() {
			$this->agy_settings_fields( 'checkbox', 'agy-enabled-disabled', 'agy-switch-input', 'enabled_disabled', $this->agy_option_check_radio_btn( 'enabled_disabled' ) );
		}

		public function agy_section_id_unregister_user() {
			$this->agy_settings_fields( 'checkbox', 'agy-unregister-user', 'agy-switch-input', 'unregister_user', $this->agy_option_check_radio_btn( 'unregister_user' ) );
		}

		public function agy_section_id_debug_mode() {
			$this->agy_settings_fields( 'checkbox', 'agy-debug-mode', 'agy-switch-input', 'debug_mode', $this->agy_option_check_radio_btn( 'debug_mode' ), '', 'Turn off the cookie for testing purpose. While the Debug mode is on, "Show for unregistered users only" field will not be usable. Don\'t forget to turn it off when you finish.' );
		}

		public function agy_section_id_exit_url() {
			$this->agy_settings_fields( 'url', 'agy-exit-url', 'agy-settings-field', 'exit_url', esc_attr__( sanitize_text_field( $this->agy_options_check( 'exit_url' ) ) ), 'https://domain.com', 'The redirect URL if the exit button was clicked' );
		}

		// Text page Settings API fields
		public function agy_section_id_headline() {
			$this->agy_settings_fields( 'text', 'agy-headline', 'agy-settings-field', 'headline', esc_attr__( sanitize_text_field( $this->agy_options_check( 'headline' ) ) ), 'This is a headline' );
		}

		public function agy_section_id_subtitle() {
			$this->agy_settings_fields( 'text', 'agy-subtitle', 'agy-settings-field', 'subtitle', esc_attr__( sanitize_text_field( $this->agy_options_check( 'subtitle' ) ) ), 'This is a subtitle' );
		}

		public function agy_section_id_message() {
			$this->agy_settings_fields( 'textarea', 'agy-message', 'agy-settings-field', 'message', esc_attr__( sanitize_text_field( $this->agy_options_check( 'message' ) ) ) );
		}

		public function agy_section_id_enter_btn() {
			$this->agy_settings_fields( 'text', 'agy-enter-btn', 'agy-settings-field', 'enter_btn', esc_attr__( sanitize_text_field( $this->agy_options_check( 'enter_btn' ) ) ), 'I am older, enter' );
		}

		public function agy_section_id_exit_btn() {
			$this->agy_settings_fields( 'text', 'agy-exit-btn', 'agy-settings-field', 'exit_btn', esc_attr__( sanitize_text_field( $this->agy_options_check( 'exit_btn' ) ) ), 'I am not older, exit' );
		}

		public function agy_section_id_separator_text() {
			$this->agy_settings_fields( 'text', 'agy-separator-text', 'agy-settings-field', 'separator_text', esc_attr__( sanitize_text_field( $this->agy_options_check( 'separator_text' ) ) ), 'This is a separator text' );
		}

		public function agy_section_id_slogan() {
			$this->agy_settings_fields( 'textarea', 'agy-slogan', 'agy-settings-field', 'slogan', esc_attr__( sanitize_text_field( $this->agy_options_check( 'slogan' ) ) ), 'This is a slogan' );
		}

		// Design page Settings API fields
		public function agy_section_id_background_color() {
			$this->agy_settings_fields( 'color', 'agy-background-color', 'agy-settings-color', 'background_color', esc_attr__( sanitize_text_field( $this->agy_options_check( 'background_color' ) ) ) );
		}

		public function agy_section_id_z_index() {
			$this->agy_settings_fields( 'number', 'agy-z-index', 'agy-settings-field', 'z_index', esc_attr__( sanitize_text_field( $this->agy_options_check( 'z_index' ) ) ), '1' );
		}

		public function agy_section_id_box_width() {
			$this->agy_settings_fields( 'number', 'agy-box-width', 'agy-settings-field', 'box_width', esc_attr__( sanitize_text_field( $this->agy_options_check( 'box_width' ) ) ), '50', 'Width ( in % ) of the popup container. From 30% to the 100%', '30', '50' );
		}

		public function agy_section_id_headline_color() {
			$this->agy_settings_fields( 'color', 'agy-headline-color', 'agy-settings-color', 'headline_color', esc_attr__( sanitize_text_field( $this->agy_options_check( 'headline_color' ) ) ) );
		}

		public function agy_section_id_headline_font_size() {
			$this->agy_settings_fields( 'number', 'agy-headline-font-size', 'agy-settings-field', 'headline_font_size', esc_attr__( sanitize_text_field( $this->agy_options_check( 'headline_font_size' ) ) ), '16' );
		}

		public function agy_section_id_subtitle_color() {
			$this->agy_settings_fields( 'color', 'agy-subtitle-color', 'agy-settings-color', 'subtitle_color', esc_attr__( sanitize_text_field( $this->agy_options_check( 'subtitle_color' ) ) ) );
		}

		public function agy_section_id_subtitle_font_size() {
			$this->agy_settings_fields( 'number', 'agy-subtitle-font-size', 'agy-settings-field', 'subtitle_font_size', esc_attr__( sanitize_text_field( $this->agy_options_check( 'subtitle_font_size' ) ) ), '16' );
		}

		public function agy_section_id_message_color() {
			$this->agy_settings_fields( 'color', 'agy-message-color', 'agy-settings-color', 'message_color', esc_attr__( sanitize_text_field( $this->agy_options_check( 'message_color' ) ) ) );
		}

		public function agy_section_id_message_font_size() {
			$this->agy_settings_fields( 'number', 'agy-message-font-size', 'agy-settings-field', 'message_font_size', esc_attr__( sanitize_text_field( $this->agy_options_check( 'message_font_size' ) ) ), '16' );
		}

		public function agy_section_id_btn_background_color() {
			$this->agy_settings_fields( 'color', 'agy-btn-background-color', 'agy-settings-color', 'btn_background_color', esc_attr__( sanitize_text_field( $this->agy_options_check( 'btn_background_color' ) ) ) );
		}

		public function agy_section_id_btn_font_color() {
			$this->agy_settings_fields( 'color', 'agy-btn-font-color', 'agy-settings-color', 'btn_font_color', esc_attr__( sanitize_text_field( $this->agy_options_check( 'btn_font_color' ) ) ) );
		}

		public function agy_section_id_btn_border_style() {
			$this->agy_settings_fields( 'text', 'agy-btn-border-style', 'agy-settings-color', 'btn_border_style', esc_attr__( sanitize_text_field( $this->agy_options_check( 'btn_border_style' ) ) ), '2px outset', 'CSS property' );
		}

		public function agy_section_id_btn_border_color() {
			$this->agy_settings_fields( 'color', 'agy-btn-border-color', 'agy-settings-color', 'btn_border_color', esc_attr__( sanitize_text_field( $this->agy_options_check( 'btn_border_color' ) ) ) );
		}

		public function agy_section_id_btn_font_size() {
			$this->agy_settings_fields( 'number', 'agy-btn-font-size', 'agy-settings-field', 'btn_font_size', esc_attr__( sanitize_text_field( $this->agy_options_check( 'btn_font_size' ) ) ), '16' );
		}

		public function agy_section_id_exit_btn_background_color() {
			$this->agy_settings_fields( 'color', 'agy-exit-btn-background-color', 'agy-settings-color', 'exit_btn_background_color', esc_attr__( sanitize_text_field( $this->agy_options_check( 'exit_btn_background_color' ) ) ) );
		}

		public function agy_section_id_exit_btn_font_color() {
			$this->agy_settings_fields( 'color', 'agy-exit-btn-font-color', 'agy-settings-color', 'exit_btn_font_color', esc_attr__( sanitize_text_field( $this->agy_options_check( 'exit_btn_font_color' ) ) ) );
		}

		public function agy_section_id_exit_btn_border_style() {
			$this->agy_settings_fields( 'text', 'agy-exit-btn-border-style', 'agy-settings-color', 'exit_btn_border_style', esc_attr__( sanitize_text_field( $this->agy_options_check( 'exit_btn_border_style' ) ) ), '1px solid', 'CSS property' );
		}

		public function agy_section_id_exit_btn_border_color() {
			$this->agy_settings_fields( 'color', 'agy-exit-btn-border-color', 'agy-settings-color', 'exit_btn_border_color', esc_attr__( sanitize_text_field( $this->agy_options_check( 'exit_btn_border_color' ) ) ) );
		}

		public function agy_section_id_exit_btn_font_size() {
			$this->agy_settings_fields( 'number', 'agy-exit_btn_font_size', 'agy-settings-field', 'exit_btn_font_size', esc_attr__( sanitize_text_field( $this->agy_options_check( 'exit_btn_font_size' ) ) ), '16' );
		}

		public function agy_section_id_separator_color() {
			$this->agy_settings_fields( 'color', 'agy-separator-color', 'agy-settings-color', 'separator_color', esc_attr__( sanitize_text_field( $this->agy_options_check( 'separator_color' ) ) ) );
		}

		public function agy_section_id_separator_font_size() {
			$this->agy_settings_fields( 'number', 'agy-separator-font-size', 'agy-settings-field', 'separator_font_size', esc_attr__( sanitize_text_field( $this->agy_options_check( 'separator_font_size' ) ) ), '16' );
		}

		public function agy_section_id_slogan_color() {
			$this->agy_settings_fields( 'color', 'agy-slogan-color', 'agy-settings-color', 'slogan_color', esc_attr__( sanitize_text_field( $this->agy_options_check( 'slogan_color' ) ) ) );
		}

		public function agy_section_id_slogan_font_size() {
			$this->agy_settings_fields( 'number', 'agy-slogan-font-size', 'agy-settings-field', 'slogan_font_size', esc_attr__( sanitize_text_field( $this->agy_options_check( 'slogan_font_size' ) ) ), '16' );
		}
	}

	new Agy_Dashboard();
}