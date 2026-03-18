<?php
/**
 * Admin Include — Core class and DB install
 *
 * @package WP_Popup_Builder
 */

if ( ! defined( 'ABSPATH' ) ) exit;

ob_start();

include_once WPPB_PATH . 'inc/popup-init.php';

// -------------------------------------------------------------------------
// Main plugin class
// -------------------------------------------------------------------------

class wppb {

	// -----------------------------------------------------------------------
	// Properties
	// -----------------------------------------------------------------------

	/** @var wppb|null Singleton instance */
	private static $instance;

	// -----------------------------------------------------------------------
	// Boot
	// -----------------------------------------------------------------------

	private function __construct() {
		add_action( 'admin_menu',             array( $this, 'admin_menu' ) );
		add_action( 'admin_enqueue_scripts',  array( $this, 'enqueue_admin_script' ) );
		add_action( 'wp_enqueue_scripts',     array( $this, 'enqueue_front_script' ) );
	}

	/**
	 * Return (or create) the singleton instance.
	 *
	 * @return wppb
	 */
	public static function get() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	// -----------------------------------------------------------------------
	// Admin menu
	// -----------------------------------------------------------------------

	public function admin_menu() {
		add_submenu_page(
			'themehunk-plugins',
			__( 'Wp Popup Builder', 'wppb' ),
			__( 'Wp Popup Builder', 'wppb' ),
			'manage_options',
			'wppb',
			array( $this, 'display_addons' ),
			51
		);
	}

	public function display_addons() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.', 'wppb' ) );
		}

		$wp_builder_obj = new wp_popup_builder_init();

		if ( isset( $_GET['custom-popup'] ) ) {
			include_once WPPB_PATH . 'inc/popup.php';
		} else {
			include_once WPPB_PATH . 'inc/popups-page.php';
		}
	}

	// -----------------------------------------------------------------------
	// Asset enqueuing
	// -----------------------------------------------------------------------

	/**
	 * Admin-side scripts and styles (only on the plugin page).
	 *
	 * @param string $hook Current admin page hook.
	 */
	public function enqueue_admin_script( $hook ) {
		if ( ! isset( $_GET['page'] ) || $_GET['page'] !== 'wppb' ) {
			return;
		}

		// Color picker
		wp_enqueue_style(
			'color-pickr',
			WPPB_URL . 'js/color/nano.min.css',
			array(),
			'1.0.0'
		);
		wp_enqueue_script(
			'color-pickr',
			WPPB_URL . 'js/color/pickr.es5.min.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);

		// Plugin styles
		wp_enqueue_style( 'wppb',       WPPB_URL . 'css/style.css',        array(), '1.0.0' );
		wp_enqueue_style( 'wppb-style', WPPB_URL . 'css/popup-style.css',  array(), '1.0.0' );
		wp_enqueue_style( 'wppb-rl',    WPPB_URL . 'css/rl_i_editor.css',  array(), '1.0.0' );

		// Media uploader
		wp_enqueue_media();

		// Plugin script + AJAX data
		wp_enqueue_script(
			'wppb-js',
			WPPB_URL . 'js/script.js',
			array( 'jquery', 'jquery-ui-draggable', 'wp-util', 'updates' ),
			'1.0.0',
			true
		);
		wp_localize_script( 'wppb-js', 'wppb_ajax_backend', array(
			'wppb_ajax_url' => admin_url( 'admin-ajax.php' ),
			'wppb_nonce'    => wp_create_nonce( '_wppb_nonce' ),
		) );
	}

	/**
	 * Front-end scripts and styles.
	 */
	public function enqueue_front_script() {
		wp_enqueue_style(
			'wppb-front',
			WPPB_URL . 'css/fstyle.css',
			array(),
			'1.0.0'
		);
		wp_enqueue_script(
			'wppb-front-js',
			WPPB_URL . 'js/fscript.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);
		wp_enqueue_style( 'dashicons' );
	}

	// -----------------------------------------------------------------------
	// Helpers
	// -----------------------------------------------------------------------

	/**
	 * Return the list of admin class files to load.
	 *
	 * @return string[]
	 */
	public static function load_file() {
		return array( 'db', 'ajax' );
	}
}

// -------------------------------------------------------------------------
// Database install
// -------------------------------------------------------------------------

if ( ! function_exists( 'wppb_install' ) ) {

	function wppb_install() {
		global $wpdb;

		$table           = $wpdb->prefix . 'wppb';
		$charset_collate = $wpdb->get_charset_collate();

		if ( $wpdb->get_var( "SHOW TABLES LIKE '$table'" ) !== $table ) {
			$sql = "CREATE TABLE IF NOT EXISTS $table (
				BID        INT(11)      PRIMARY KEY AUTO_INCREMENT,
				addon_name VARCHAR(100) NOT NULL,
				setting    LONGTEXT     NOT NULL,
				boption    TEXT         NOT NULL,
				is_active  BOOLEAN      DEFAULT '1'
			) $charset_collate;";

			$wpdb->query( $sql );
		}
	}

	add_action( 'admin_init', 'wppb_install' );
}

ob_end_clean();
