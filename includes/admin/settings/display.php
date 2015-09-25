<?php
/**
 * Settings page
 *
 * @package     Beacon\Admin\Settings\Display
 * @since       1.0.0
 */


// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Render the settings page
 *
 * @since       1.0.0
 * @global      array $beacon_options The Beacon options
 * @return      void
 */
function beacon_render_settings_page() {
	global $beacon_options;

	$active_tab = isset( $_GET['tab'] ) && array_key_exists( $_GET['tab'], beacon_get_settings_tabs() ) ? $_GET['tab'] : 'general';

	ob_start();
	?>
	<div class="wrap">
		<h2 class="nav-tab-wrapper">
			<?php
			foreach( beacon_get_settings_tabs() as $tab_id => $tab_name ) {
				$tab_url = add_query_arg( array(
					'settings-updated'  => false,
					'tab'               => $tab_id
				) );

				$active = $active_tab == $tab_id ? ' nav-tab-active' : '';

				echo '<a href="' . esc_url( $tab_url ) . '" title="' . esc_attr( $tab_name )  . '" class="nav-tab' . $active . '">' . esc_html( $tab_name ) . '</a>';
			}
			?>
		</h2>
		<div id="tab_container">
			<form method="post" action="options.php">
				<table class="form-table">
					<?php
					settings_fields( 'beacon_settings' );
					do_settings_fields( 'beacon_settings_' . $active_tab, 'beacon_settings_' . $active_tab );
					?>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
	</div>
	<?php
	echo ob_get_clean();
}