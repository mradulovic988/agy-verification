<?php
global $wpdb;
require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

function agy_if_update_available() {
	$plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/agy-verification/agy-verification.php' );

	$plugin_slug = 'agy-verification';
	$plugin_info = plugins_api( 'plugin_information', array(
		'slug'   => $plugin_slug,
		'fields' => array( 'versions' => true ),
	) );
	if ( version_compare( $plugin_data['Version'], $plugin_info->version, '<' ) ) {
		// Update available
		return '<span class="error-message">' . __( 'Update available.', AGY_TEXT_DOMAIN ) . '</span>';
	} else {
		// Up to date
		return '<span>' . __( 'No update available.', AGY_TEXT_DOMAIN ) . '</span>';
	}
}

function agy_if_wp_update_available() {
	$current_version = get_bloginfo( 'version' );
	$latest_version  = get_core_updates()['0']->current;

	if ( version_compare( $current_version, $latest_version, '<' ) ) {
		return '<span class="error-message">' . __( 'Update available', AGY_TEXT_DOMAIN ) . '</span>';
	} else {
		return '<span>' . __( 'No update available', AGY_TEXT_DOMAIN ) . '</span>';
	}
}

function agy_if_debug_log() {
	if ( WP_DEBUG ) {
		return '<span class="error-message">' . __( 'Debug log is turned on. Please disable it.', AGY_TEXT_DOMAIN ) . '</span>';
	} else {
		return '<span>' . __( 'Debug log is turned off', AGY_TEXT_DOMAIN ) . '</span>';
	}
}

function agy_active_plugins( $number = false, $separator = ', ' ) {
	$active_plugins = array();

	foreach ( get_option( 'active_plugins', array() ) as $plugin ) {
		$plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
		if ( isset( $plugin_data['Name'] ) ) {
			$active_plugins[] = $plugin_data['Name'];
		}
	}

	if ( $number ) {
		return count( $active_plugins );
	} else {
		return implode( $separator, $active_plugins );
	}
}

function agy_themes( $number = false ) {
	$themes      = wp_get_themes();
	$theme_names = array_map( function ( $theme ) {
		return $theme->Name;
	}, $themes );

	if ( $number ) {
		echo count( $themes );
	} else {
		echo implode( ', ', $theme_names );
	}
}

function get_latest_plugin_version( $plugin_name ) {
	$args     = array(
		'slug'   => $plugin_name,
		'fields' => array( 'version' ),
	);
	$response = plugins_api( 'plugin_information', $args );

	if ( is_wp_error( $response ) ) {
		return false;
	}

	return $response->version;
}

?>
	<style>
        .agy-status-container {
            width: 60%;
            height: 400px;
            overflow-y: auto;
            overflow-x: hidden;
            text-align: justify;
            border-radius: 5px;
            background-color: #fff;
        }

        .agy-status-container::-webkit-scrollbar {
            width: 3px;
            background-color: transparent;
        }

        .agy-status-container::-webkit-scrollbar-thumb {
            background-color: #e0061a;
            border-radius: 20px;
        }

        button.agy-copy-clipboard {
            margin: 0 0 20px 0!important;
        }
	</style>
	<button type="button" class="button button-small agy-copy-clipboard" onclick="copyToClipboard()">
		<?php _e( 'Copy to clipboard', AGY_TEXT_DOMAIN ) ?>
	</button>

	<div class="agy-copied-message"></div>
	<div class="agy-status-container">
		<div class="agy-status-wrapper">
			<h2><?php _e( 'General', AGY_TEXT_DOMAIN ) ?></h2>
			<table class="agy-status-log">
				<thead>
				<th><?php _e( 'Condition', AGY_TEXT_DOMAIN ) ?></th>
				<th><?php _e( 'Status', AGY_TEXT_DOMAIN ) ?></th>
				<th><?php _e( 'Description', AGY_TEXT_DOMAIN ) ?></th>
				</thead>
				<tbody>
				<tr>
					<td><?php _e( 'Plugin Version', AGY_TEXT_DOMAIN ) ?></td>
					<td><?php echo AGY_PLUGIN_VERSION ?></td>
					<td><?php _e( agy_if_update_available() ) ?></td>
				</tr>
				<tr>
					<td><?php _e( 'WordPress version', AGY_TEXT_DOMAIN ) ?></td>
					<td><?php echo get_bloginfo( 'version' ) ?></td>
					<td><?php _e( agy_if_wp_update_available() ) ?></td>
				</tr>
				<tr>
					<td><?php _e( 'Debug log', AGY_TEXT_DOMAIN ) ?></td>
					<td><?php echo WP_DEBUG ? 'ON' : 'OFF' ?></td>
					<td><?php echo agy_if_debug_log() ?></td>
				</tr>
				<tr>
					<td><?php _e( 'PHP Version', AGY_TEXT_DOMAIN ) ?></td>
					<td><?php echo phpversion() ?></td>
					<td><?php _e( 'Current PHP version is ' . phpversion(), AGY_TEXT_DOMAIN ) ?></td>
				</tr>
				<tr>
					<td><?php _e( 'MySQL Version', AGY_TEXT_DOMAIN ) ?></td>
					<td><?php echo $wpdb->db_version() ?></td>
					<td><?php _e( 'Current MySQL version is ' . $wpdb->db_version(), AGY_TEXT_DOMAIN ) ?></td>
				</tr>
				<tr>
					<td><?php _e( 'Active plugins', AGY_TEXT_DOMAIN ) ?></td>
					<td><?php _e( agy_active_plugins( true ) ) . _e( ' active plugins', AGY_TEXT_DOMAIN ) ?></td>
					<td><?php _e( agy_active_plugins() ) ?></td>
				</tr>
				<tr>
					<td><?php _e( 'Active themes', AGY_TEXT_DOMAIN ) ?></td>
					<td><?php agy_themes( true ) . _e( ' active themes', AGY_TEXT_DOMAIN ) ?></td>
					<td><?php agy_themes() ?></td>
				</tr>
				</tbody>
			</table>
		</div>
		<div class="agy-status-wrapper">
			<h2><?php _e( 'Active plugins', AGY_TEXT_DOMAIN ) ?></h2>
			<table class="agy-status-log">
				<thead>
				<th><?php _e( 'Name', AGY_TEXT_DOMAIN ) ?></th>
				<th><?php _e( 'Version', AGY_TEXT_DOMAIN ) ?></th>
				<th><?php _e( 'Status', AGY_TEXT_DOMAIN ) ?></th>
				</thead>
				<tbody>

				<?php
				$all_plugins    = get_plugins();
				$active_plugins = get_option( 'active_plugins' );

				foreach ( $all_plugins as $plugin_path => $plugin_info ) {
					if ( is_plugin_active( $plugin_path ) ) {
						$plugin_data    = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin_path );
						$latest_version = get_latest_plugin_version( $plugin_data['Name'] );

						echo '<tr>';
						echo '<td>' . $plugin_info['Name'] . '</td>';
						echo '<td>' . $plugin_info['Version'] . '</td>';

						if ( version_compare( $latest_version, $plugin_data['Version'], '>' ) ) {
							echo '<td class="error-message">' . __( 'Update available', AGY_TEXT_DOMAIN ) . '</td>';
						} else {
							echo '<td>' . __( 'No update available', AGY_TEXT_DOMAIN ) . '</td>';
						}

						echo '</tr>';
					}
				}
				?>
				</tbody>
			</table>
		</div>

		<div class="agy-status-wrapper">
			<h2><?php _e( 'Active themes', AGY_TEXT_DOMAIN ) ?></h2>
			<table class="agy-status-log">
				<thead>
				<th><?php _e( 'Name', AGY_TEXT_DOMAIN ) ?></th>
				<th><?php _e( 'Version', AGY_TEXT_DOMAIN ) ?></th>
				<th><?php _e( 'Status', AGY_TEXT_DOMAIN ) ?></th>
				</thead>
				<tbody>

				<?php
				$all_themes    = wp_get_themes();
				$active_themes = get_option( 'stylesheet' );

				foreach ( $all_themes as $theme ) {

					echo '<tr>';
					echo '<td>' . $theme->get( 'Name' ) . '</td>';
					echo '<td>' . $theme->get( 'Version' ) . '</td>';

					$theme_updates = get_theme_updates();
					if ( isset( $theme_updates[ $theme->get_stylesheet() ] ) ) {
						echo '<td class="error-message">Update available</td>';
					} else {
						echo '<td>No update available</td>';
					}

					echo '</tr>';
				}
				?>
				</tbody>
			</table>
		</div>
	</div>
<?php

//$wp_version          = get_bloginfo( 'version' );
//$php_version         = phpversion();
//$mysql_version       = $wpdb->db_version();
//$debug_enabled       = WP_DEBUG ? 'true' : 'false';
//$error_log           = ini_get( 'error_log' );
//$latest_version      = defined( 'AGY_PLUGIN_VERSION' ) ? AGY_PLUGIN_VERSION : '';
//$memory_limit        = ini_get( 'memory_limit' );
//$upload_max_filesize = ini_get( 'upload_max_filesize' );
//$post_max_size       = ini_get( 'post_max_size' );
//$max_execution_time  = ini_get( 'max_execution_time' );
//$max_input_time      = ini_get( 'max_input_time' );
//$output              = '';
//$output              .= '<h2>Site Status</h2>';
//$output              .= '<button type="button" class="button" onclick="copyToClipboard()">Copy to Clipboard</button>';
//$output              .= '<div class="agy-copied-message">';
//$output              .= '<ul>';
//$output              .= '<li>WordPress Version: ' . $wp_version . ' (' . get_core_updates()['0']->response . ')</li>';
//$output              .= '<li>PHP Version: ' . $php_version . '</li>';
//$output              .= '<li>MySQL Version: ' . $mysql_version . '</li>';
//$output              .= '<li>Debug Mode: ' . $debug_enabled . '</li>';
//$output              .= '<li>PHP Error Log: ' . $error_log . '</li>';
//$output              .= '<li>Plugin Version: ' . $latest_version . '</li>';
//$output              .= '<li>PHP Memory Limit: ' . $memory_limit . '</li>';
//$output              .= '<li>Upload File size Limit: ' . $upload_max_filesize . '</li>';
//$output              .= '<li>Post max size Limit: ' . $post_max_size . '</li>';
//$output              .= '<li>Max execution time Limit: ' . $max_execution_time . '</li>';
//$output              .= '<li>Max input time Limit: ' . $max_input_time . '</li>';
//$output              .= '</ul>';
//$output              = '<div id="site-status">' . $output . '</div>';
//echo $output;

?>
	<script>
			function copyToClipboard() {
				var copyText = document.createElement("textarea");
				copyText.value = document.querySelector("#site-status").innerHTML.trim()
					.replace(/<\/li>/g, "\n").replace(/<li>/g, "")
					.replace(/<\/h2>/g, "\n").replace(/<h2>/g, "")
					.replace(/<\/ul>/g, "\n").replace(/<ul>/g, "")
					.replace(/<\/div>/g, "\n").replace(/<div>/g, "")
					.replace(/<\/button>/g, "\n").replace(/<button>/g, "");
				document.body.appendChild(copyText);
				copyText.select();
				document.execCommand("copy");
				document.body.removeChild(copyText);
				var message = document.querySelector("div.agy-copied-message");
				message.innerHTML = "Copied!";
				// document.body.appendChild(message);
				setTimeout(function () {
					message.remove();
				}, 2000);
			}
	</script>
<?php
