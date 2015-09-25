<?php
/**
 * Plugin Name:     Beacon
 * Plugin URI:      https://section214.com/products/beacon
 * Description:     Integrate Beacon from Help Scout into your WordPress site
 * Version:         1.0.0
 * Author:          Daniel J Griffiths
 * Author URI:      https://section214.com
 * Text Domain:     beacon
 *
 * @package         Beacon
 * @author          Daniel J Griffiths <dgriffiths@section214.com>
 */


// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( ! class_exists( 'Beacon' ) ) {


	/**
	 * Main Beacon class
	 *
	 * @since       1.0.0
	 */
	class Beacon {


		/**
		 * @var         Beacon $instance The one true Beacon
		 * @since       1.0.0
		 */
		private static $instance;


		/**
		 * Get active instance
		 *
		 * @access      public
		 * @since       1.0.0
		 * @return      self::$instance The one true Beacon
		 */
		public static function instance() {
			if( ! self::$instance ) {
				self::$instance = new Beacon();
				self::$instance->setup_constants();
				self::$instance->load_textdomain();
				self::$instance->includes();
				self::$instance->hooks();
			}

			return self::$instance;
		}


		/**
		 * Setup plugin constants
		 *
		 * @access      public
		 * @since       1.0.0
		 * @return      void
		 */
		public function setup_constants() {
			// Plugin version
			define( 'BEACON_FOR_HELPSCOUT_VER', '1.0.0' );

			// Plugin path
			define( 'BEACON_FOR_HELPSCOUT_DIR', plugin_dir_path( __FILE__ ) );

			// Plugin URL
			define( 'BEACON_FOR_HELPSCOUT_URL', plugin_dir_url( __FILE__ ) );
		}


		/**
		 * Include necessary files
		 *
		 * @access      private
		 * @since       1.0.0
		 * @global		array $beacon_options The Beacon options array
		 * @return      void
		 */
		private function includes() {
			global $beacon_options;

            require_once BEACON_FOR_HELPSCOUT_DIR . 'includes/admin/settings/register.php';
            $beacon_options = beacon_get_settings();

            require_once BEACON_FOR_HELPSCOUT_DIR . 'includes/scripts.php';
            require_once BEACON_FOR_HELPSCOUT_DIR . 'includes/functions.php';

            if( is_admin() ) {
            	require_once BEACON_FOR_HELPSCOUT_DIR . 'includes/admin/actions.php';
                require_once BEACON_FOR_HELPSCOUT_DIR . 'includes/admin/pages.php';
                require_once BEACON_FOR_HELPSCOUT_DIR . 'includes/admin/settings/display.php';
            }
		}


		/**
		 * Run action and filter hooks
		 *
		 * @access      private
		 * @since       1.0.0
		 * @return      void
		 */
		private function hooks() {

		}


		/**
		 * Internationalization
		 *
		 * @access      public
		 * @since       1.0.0
		 * @return      void
		 */
		public function load_textdomain() {
			// Set filter for language directory
			$lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
			$lang_dir = apply_filters( 'beacon_language_directory', $lang_dir );

			// Traditional WordPress plugin locale filter
			$locale = apply_filters( 'plugin_locale', get_locale(), '' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'beacon-for-helpscout', $locale );

			// Setup paths to current locale file
			$mofile_local   = $lang_dir . $mofile;
			$mofile_global  = WP_LANG_DIR . '/beacon/' . $mofile;

			if( file_exists( $mofile_global ) ) {
				// Look in global /wp-content/languages/beacon/ folder
				load_textdomain( 'beacon-for-helpscout', $mofile_global );
			} elseif( file_exists( $mofile_local ) ) {
				// Look in local /wp-content/plugins/beacon/languages/ folder
				load_textdomain( 'beacon-for-helpscout', $mofile_local );
			} else {
				// Load the default language files
				load_plugin_textdomain( 'beacon-for-helpscout', false, $lang_dir );
			}
		}
	}
}


/**
 * The main function responsible for returning the one true Beacon
 * instance to functions everywhere
 *
 * @since       1.0.0
 * @return      Beacon The one true Beacon
 */
function beacon() {
	return Beacon::instance();
}
add_action( 'plugins_loaded', 'beacon-for-helpscout' );
