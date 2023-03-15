<?php

/**
 * Plugin Name: Recruit Now
 * Plugin URI: https://www.maatwerkonline.nl/
 * Description: Connect your Recruit Now Cockpit with WordPress.
 * Version: 1.0.0
 * Author: Maatwerk Online
 * Author URI: https://www.maatwerkonline.nl/
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: recruitnow
 * Domain Path: /languages
 */

// Stop Direct Access 
if (!defined('ABSPATH')) {
	exit;
}

// Include admin settings
require_once(plugin_dir_path(__FILE__) . 'admin/admin.php');
require_once(plugin_dir_path(__FILE__) . 'Api/CustomMetaBox.php');
require_once(plugin_dir_path(__FILE__) . 'Api/DataFeed.php');
require_once(plugin_dir_path(__FILE__) . 'Api/ShortCode.php');

/**
 * Blocks Final Class
 */
final class RCN_BLOCKS_CLASS {

	public $rcn_settings;

	public function __construct() {
		$this->rcn_settings = get_option('rcn_settings');

		// define constants
		$this->rcn_define_constants();

		// block initialization
		add_action('init', [$this, 'rcn_blocks_init']);

		// blocks category
		if (version_compare($GLOBALS['wp_version'], '5.7', '<')) {
			add_filter('block_categories', [$this, 'rcn_register_block_category'], 10, 2);
		} else {
			add_filter('block_categories_all', [$this, 'rcn_register_block_category'], 10, 2);
		}

		// enqueue block assets
		add_action('enqueue_block_assets', [$this, 'rcn_external_libraries']);

		// admin enqueue scripts
		add_action('admin_enqueue_scripts', [$this, 'rcn_admin_enqueue_scripts']);
		add_action('wp_ajax_rcn_feed_refresh', 'rcn_feed_refresh');
	}

	/**
	 * Initialize the plugin
	 */

	public static function init() {
		static $instance = false;
		if (!$instance) {
			$instance = new self();
		}
		return $instance;
	}

	/**
	 * Define the plugin constants
	 */

	private function rcn_define_constants() {
		define('RCN_VERSION', '1.0.0');
		define('RCN_URL', plugin_dir_url(__FILE__));
		define('RCN_INC_URL', RCN_URL . 'includes/');
	}

	/**
	 * Blocks Registration 
	 */

	public function rcn_register_block($name, $options = array()) {
		register_block_type(__DIR__ . '/build/blocks/' . $name, $options);
	}

	/**
	 * Blocks Initialization
	 */

	public function rcn_blocks_init() {
		// Job Board Application Form
		$this->rcn_register_block('jobboard-application-form', [
			'render_callback' => [$this, 'rcn_render_jobboard_application_form'],
		]);

		// Open Application Form
		$this->rcn_register_block('open-application-form', [
			'render_callback' => [$this, 'rcn_render_open_application_form'],
		]);

		// CV Generator
		// $this->rcn_register_block('cv-generator', [
		// 	'render_callback' => [$this, 'rcn_render_cv_generator'],
		// ]);
	}

	/**
	 * Render Job Board Application Form
	 */
	public function rcn_render_jobboard_application_form($attributes, $content) {
		// useBlockProps
		$blockProps = get_block_wrapper_attributes();
		$btnText = isset($attributes['btnText']) ? $attributes['btnText'] : 'Apply';
		$titlePrefix = isset($attributes['titlePrefix']) ? $attributes['titlePrefix'] : '';

		// api base url
		$apiBaseUrl = isset($this->rcn_settings['rcn_application_widget_url']) ? $this->rcn_settings['rcn_application_widget_url'] : 'https://roteck.recruitnowcockpit.nl/jobsite';

		// application form id
		$applicationFormId = isset($this->rcn_settings['rcn_application_form_id']) ? $this->rcn_settings['rcn_application_form_id'] : 'ApplicationForms-1-A';

		// Thank you page 
		$thankyou = get_permalink($this->rcn_settings['rcn_thank_you_page_application_form']);
		// Error page
		$error = get_permalink($this->rcn_settings['rcn_error_page_application_form']);

		$markup = <<<HTML
		<div {$blockProps}>
			<jobboard-application-form
				title-prefix="{$titlePrefix}"
				form-id="{$applicationFormId}"
				vacancy-id="{$attributes['vacancyId']}"
				api-base-url="{$apiBaseUrl}"
				success="window.location.href = '/{$thankyou}'"
				fail="window.location.href = '/{$error}'"
				apply-btn-text="{$btnText}"
				utm-tags="utm_source=facebook&utm_medium=social"
				tracking-fields="customfields1=waarde1&customfields2=waarde2"
				referrer="https://url.vanherkomst.nl">
			</jobboard-application-form>
		</div>
	HTML;

		return $markup;
	}

	/**
	 * Render Open Application Form
	 */
	public function rcn_render_open_application_form($attributes, $content) {
		// useBlockProps
		$blockProps = get_block_wrapper_attributes();

		// Success page 
		$successpage = get_permalink($this->rcn_settings['rcn_thank_you_page_open_application']);
		// Fail page
		$failpage = get_permalink($this->rcn_settings['rcn_error_page_open_application']);

		// api base url
		$apiBaseUrl = isset($this->rcn_settings['rcn_open_application_url']) ? $this->rcn_settings['rcn_open_application_url'] : 'https://roteck.recruitnowcockpit.nl';

		// enrollment form id
		$enrollmentFormId = isset($this->rcn_settings['rcn_enrollment_form_id']) ? $this->rcn_settings['rcn_enrollment_form_id'] : 'CandidateEnrollmentForms-1-A';

		$markup = <<<HTML
		<div {$blockProps}>
			<recruitnow-open-enrollment-widget
				api-base-url="{$apiBaseUrl}"
				open-enrollment-form-id="{$enrollmentFormId}"
				utm-tags="utm_source=facebook&utm_medium=social"
				submit-success="location.href = '/{$successpage}';"
				submit-fail="location.href = '/{$failpage}';">
			</recruitnow-open-enrollment-widget>
		</div>
	HTML;

		return $markup;
	}

	/**
	 * CV Generator
	 */
	// public function rcn_render_cv_generator($attributes, $content) {
	// 	// useBlockProps
	// 	$blockProps = get_block_wrapper_attributes();

	// 	// redirectUrl
	// 	$redirectUrl = get_permalink($this->rcn_settings['rcn_success_page_cv_generator']);

	// 	// isCandidateEnrollment
	// 	$isCandidateEnrollment = $attributes['isCandidateEnrollment'] ? "true" : "false";

	// 	$markup = <<<HTML
	// 	<div {$blockProps}>
	// 		<recruitnow-cv-generator
	// 			apiUrl="https://cvgen-sbe-daaf.recruitnow.nl/"
	// 			redirectUrl="{$redirectUrl}"
	// 			isCandidateEnrollment="{$isCandidateEnrollment}"
	// 		>
	// 		</recruitnow-cv-generator>
	// 	</div>
	// HTML;

	// 	return $markup;
	// }

	/**
	 * Register Block Category
	 */

	public function rcn_register_block_category($categories, $post) {
		return array_merge(
			array(
				array(
					'slug'  => 'rcn-blocks',
					'title' => __('Recruit Now Blocks', 'recruitnow'),
				),
			),
			$categories,
		);
	}

	/**
	 * Enqueue Block Assets
	 */

	public function rcn_external_libraries() {

		/**
		 * Job Board Application Form Widget
		 */
		// JS
		wp_enqueue_script('rcn-application-widget', 'https://roteck.recruitnowcockpit.nl/jobsite/scripts/jobboard-application-form-v2.js', array(), RCN_VERSION, true);

		/**
		 * Open Application Form Widget
		 */
		// CSS
		wp_enqueue_style('rcn-open-application-widget-style', 'https://roteck.recruitnowcockpit.nl/widgets/enrollment/recruitnow-open-enrollment-stylesheet.css', array(), RCN_VERSION);

		// JS
		wp_enqueue_script('rcn-open-application-widget', 'https://roteck.recruitnowcockpit.nl/widgets/enrollment/recruitnow-open-enrollment-widget.js', array(), RCN_VERSION, true);

		/**
		 * CV Generator
		 */
		// CSS
		// wp_enqueue_style('rcn-cv-generator-widget-fontawesome-style', 'https://use.fontawesome.com/releases/v5.0.13/css/all.css', array(), RCN_VERSION);
		// wp_enqueue_style('rcn-cv-generator-widget-style', 'https://cvgen-sbe-daaf.recruitnow.nl/styles.css', array(), RCN_VERSION);

		// // JS
		// wp_enqueue_script('rcn-cv-generator-widget-script', 'https://cvgen-sbe-daaf.recruitnow.nl/cv-generator.js', array(), RCN_VERSION, true);

		// vacancy style
		wp_enqueue_style('rcn-vacancy-style', plugin_dir_url(__FILE__) . 'includes/css/vacancy.css', array(), RCN_VERSION, 'all');
	}

	/**
	 * Admin Enqueue Scripts
	 */
	public function rcn_admin_enqueue_scripts($screen) {
		if ('toplevel_page_recruit_now' === $screen || 'recruit-now_page_recruit_now_vacancies' === $screen) {

			wp_enqueue_style('rcn-admin-styles', plugin_dir_url(__FILE__) . 'admin/css/admin.css', array(), '1.0.0', 'all');
		}

		if (isset($_GET['page']) && ('recruit_now' == $_GET['page'])) {
			wp_enqueue_script('rcn-sweetalert', 'https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js', 'jquery', '11.7.3', true);
			wp_enqueue_script('rcn-admin', plugin_dir_url(__FILE__) . 'admin/js/admin.js', ['jquery', 'rcn-sweetalert'], RCN_VERSION, true);
			wp_localize_script(
				'rcn-admin',
				'rcn_admin_config',
				array(
					'ajaxurl'        => admin_url('admin-ajax.php'),
					'language' 		 => substr(get_locale(), 0, 2),
					'data_refresh' => [
						'title' => esc_html_x('New Data Loaded', 'recruit-now'),
						'msg' => esc_html_x('Data sync successfully.', 'recruit-now'),
						'must_admin' => esc_html_x('Only Admin Can Refresh Data.', 'recruit-now'),
					],
					'unknownerror'   => esc_html_x('Unknown error, make sure access is correct!', 'User Login and Register', 'recruit-now'),
				)
			);
		}




		// // Application Form Widget
		// wp_enqueue_script( 'rcn-application-widget', $this->rcn_settings['rcn_application_widget_url'] . '/scripts/jobboard-application-form-v2.js', array(), RCN_VERSION, true );
	}
}

/**
 * Kickoff
 */

RCN_BLOCKS_CLASS::init();
