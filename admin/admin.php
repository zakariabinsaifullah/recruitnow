<?php

/**
 * @package Recruit Now
 * @package Recruit Now Settings Page
 */


/**
 * Register Admin Menu
 */

add_action('admin_menu', 'rcn_add_admin_menu');
function rcn_add_admin_menu() {
    add_menu_page(__('Recruit Now', 'recruitnow'), __('Recruit Now', 'recruitnow'), 'manage_options', 'recruit_now', 'rcn_options_page', 'dashicons-screenoptions');
}

/**
 * @package Recruit Now
 * Register Settings
 */

add_action('admin_init', 'rcn_settings_init');
function rcn_settings_init() {

    // Register Settings
    register_setting('rcn_page', 'rcn_settings');

    /**
     * Section: Open Application API URL
     */
    add_settings_section(
        'rcn_open_application_section',
        __('Open Application Form', 'recruitnow'),
        'rcn_open_application_section_callback',
        'rcn_page'
    );

    //  API Base URL
    add_settings_field(
        'rcn_open_application_url',
        __('API Base URL', 'recruitnow'),
        'rcn_open_application_url_render',
        'rcn_page',
        'rcn_open_application_section'
    );

    // Enrollment Form ID
    add_settings_field(
        'rcn_enrollment_form_id',
        __('Enrollment Form ID', 'recruitnow'),
        'rcn_enrollment_form_id_render',
        'rcn_page',
        'rcn_open_application_section'
    );


    // Thank you page (Open Application)
    add_settings_field(
        'rcn_thank_you_page_open_application',
        __('Thank You Page', 'recruitnow'),
        'rcn_thank_you_page_open_application_render',
        'rcn_page',
        'rcn_open_application_section'
    );

    // Error page (Open Application)
    add_settings_field(
        'rcn_error_page_open_application',
        __('Error Page', 'recruitnow'),
        'rcn_error_page_open_application_render',
        'rcn_page',
        'rcn_open_application_section'
    );

    /**
     * Section: Jobboard Application Widget
     */
    add_settings_section(
        'rcn_application_widget_section',
        __('Jobboard Application Form Widget', 'recruitnow'),
        'rcn_application_widget_section_callback',
        'rcn_page'
    );

    // API Base URL 
    add_settings_field(
        'rcn_application_widget_url',
        __('API Base URL', 'recruitnow'),
        'rcn_application_widget_url_render',
        'rcn_page',
        'rcn_application_widget_section'
    );

    // Application Form ID 
    add_settings_field(
        'rcn_application_form_id',
        __('Application Form ID', 'recruitnow'),
        'rcn_application_form_id_render',
        'rcn_page',
        'rcn_application_widget_section'
    );

    // Thank you page (Application Form)
    add_settings_field(
        'rcn_thank_you_page_application_form',
        __('Thank You Page', 'recruitnow'),
        'rcn_thank_you_page_application_form_render',
        'rcn_page',
        'rcn_application_widget_section'
    );

    // Error page (Application Form)
    add_settings_field(
        'rcn_error_page_application_form',
        __('Error Page', 'recruitnow'),
        'rcn_error_page_application_form_render',
        'rcn_page',
        'rcn_application_widget_section'
    );

    // Form Button Text
    add_settings_field(
        'rcn_application_form_button_text',
        __('Form Button Text', 'recruitnow'),
        'rcn_application_form_button_text_render',
        'rcn_page',
        'rcn_application_widget_section'
    );
    /**
     * Section: Data feed
     */
    add_settings_section(
        'rcn_data_feed_section',
        __('Data Feed', 'recruitnow'),
        'rcn_data_feed_section_callback',
        'rcn_page'
    );

    // Data feed website
    add_settings_field(
        'rcn_data_feed_website',
        __('Data feed website', 'recruitnow'),
        'rcn_data_feed_website_render',
        'rcn_page',
        'rcn_data_feed_section'
    );

    // Data Cache
    add_settings_field(
        'rcn_data_cache',
        __('Data Cache Time (Hours)', 'recruitnow'),
        'rcn_data_cache_render',
        'rcn_page',
        'rcn_data_feed_section'
    );

    /**
     * Section: CV Generator
     */
    add_settings_section(
        'rcn_cv_generator_section',
        __('CV Generator', 'recruitnow'),
        'rcn_cv_generator_section_callback',
        'rcn_page'
    );

    // CV Generator success page
    add_settings_field(
        'rcn_success_page_cv_generator',
        __('Success Page', 'recruitnow'),
        'rcn_success_page_cv_generator_render',
        'rcn_page',
        'rcn_cv_generator_section'
    );
}

/**
 * @package Recruit Now
 * Open Application API URL
 */
function rcn_open_application_url_render() {
    $options = get_option('rcn_settings');
    $rcn_open_application_url = isset($options['rcn_open_application_url']) ? $options['rcn_open_application_url'] : 'https://roteck.recruitnowcockpit.nl';
?>
    <input class="rcn_input" type='text' name='rcn_settings[rcn_open_application_url]' value='<?php echo esc_attr($rcn_open_application_url); ?>' />
<?php
}

/**
 * @package Recruit Now
 * Enrollment Form ID
 */
function rcn_enrollment_form_id_render() {
    $options = get_option('rcn_settings');
    $rcn_enrollment_form_id = isset($options['rcn_enrollment_form_id']) ? $options['rcn_enrollment_form_id'] : 'CandidateEnrollmentForms-1-A';
?>
    <input class="rcn_input" type='text' name='rcn_settings[rcn_enrollment_form_id]' value='<?php echo esc_attr($rcn_enrollment_form_id); ?>' />
<?php
}

/**
 * @package Recruit Now
 * Application Widget API URL
 */
function rcn_application_widget_url_render() {
    $options = get_option('rcn_settings');
    $rcn_application_widget_url = isset($options['rcn_application_widget_url']) ? $options['rcn_application_widget_url'] : 'https://roteck.recruitnowcockpit.nl/jobsite';
?>
    <input class="rcn_input" type='text' name='rcn_settings[rcn_application_widget_url]' value='<?php echo esc_attr($rcn_application_widget_url); ?>'>
<?php
}

/**
 * @package Recruit Now
 * Application Form ID
 */
function rcn_application_form_id_render() {
    $options = get_option('rcn_settings');
    $rcn_application_form_id = isset($options['rcn_application_form_id']) ? $options['rcn_application_form_id'] : 'ApplicationForms-1-A';
?>
    <input class="rcn_input" type='text' name='rcn_settings[rcn_application_form_id]' value='<?php echo esc_attr($rcn_application_form_id); ?>'>
<?php
}

/**
 * @package Recruit Now
 * Application Form Button Text
 */
function rcn_application_form_button_text_render() {
    $options = get_option('rcn_settings');
    $rcn_application_form_button_text = isset($options['rcn_application_form_button_text']) ? $options['rcn_application_form_button_text'] : 'Apply now';
?>
    <input class="rcn_input" type='text' name='rcn_settings[rcn_application_form_button_text]' value='<?php echo esc_attr($rcn_application_form_button_text); ?>'>
<?php
}

/**
 * @package Recruit Now
 * Data feed website
 */
function rcn_data_feed_website_render() {
    $options = get_option('rcn_settings');
    $rcn_data_feed_website = isset($options['rcn_data_feed_website']) ? $options['rcn_data_feed_website'] : 'https://roteck.recruitnowcockpit.nl/jobsite/api/vacancies/feed/website?type=json';
?>
    <input class="rcn_input" type='text' name='rcn_settings[rcn_data_feed_website]' value='<?php echo esc_attr($rcn_data_feed_website); ?>'>
<?php
}
/**
 * @package Recruit Now
 * Showcase Page ID
 */
function rcn_data_cache_render() {
    $options = get_option('rcn_settings');
    $rcn_data_cache = isset($options['rcn_data_cache']) ? $options['rcn_data_cache'] : 3;
?>
    <input class="rcn_input" min="1" type='number' name='rcn_settings[rcn_data_cache]' value='<?php echo esc_attr($rcn_data_cache); ?>' placeholder="3">
    <button class="button button-primary" type="button" id="rcn-refresh-data">
        <span class="dashicons dashicons-image-rotate"></span>
        <?php esc_html_e('Refresh Now', 'recruitnow') ?>
    </button>
<?php
}

/**
 * @package Recruit Now
 * Thank you page (Application Form)
 */
function rcn_thank_you_page_application_form_render() {
    $options = get_option('rcn_settings');
    $rcn_thank_you_page_application_form = isset($options['rcn_thank_you_page_application_form']) ? $options['rcn_thank_you_page_application_form'] : '';
?>
    <select name='rcn_settings[rcn_thank_you_page_application_form]'>
        <?php
        $pages = get_pages();
        foreach ($pages as $page) {
            $option = '<option value="' . $page->ID . '" ' . selected($rcn_thank_you_page_application_form, $page->ID, false) . '>';
            $option .= $page->post_title;
            $option .= '</option>';
            echo $option;
        }
        ?>
    </select>
<?php
}

/**
 * @package Recruit Now
 * Error page (Application Form)
 */
function rcn_error_page_application_form_render() {
    $options = get_option('rcn_settings');
    $rcn_error_page_application_form = isset($options['rcn_error_page_application_form']) ? $options['rcn_error_page_application_form'] : '';
?>
    <select name='rcn_settings[rcn_error_page_application_form]'>
        <?php
        $pages = get_pages();
        foreach ($pages as $page) {
            $option = '<option value="' . $page->ID . '" ' . selected($rcn_error_page_application_form, $page->ID, false) . '>';
            $option .= $page->post_title;
            $option .= '</option>';
            echo $option;
        }
        ?>
    </select>
<?php
}

/**
 * @package Recruit Now
 * Thank you page (Open Application Form)
 */
function rcn_thank_you_page_open_application_render() {
    $options = get_option('rcn_settings');
    $rcn_thank_you_page_open_application = isset($options['rcn_thank_you_page_open_application']) ? $options['rcn_thank_you_page_open_application'] : '';
?>
    <select name='rcn_settings[rcn_thank_you_page_open_application]'>
        <?php
        $pages = get_pages();
        foreach ($pages as $page) {
            $option = '<option value="' . $page->ID . '" ' . selected($rcn_thank_you_page_open_application, $page->ID, false) . '>';
            $option .= $page->post_title;
            $option .= '</option>';
            echo $option;
        }
        ?>
    </select>
<?php
}

/**
 * @package Recruit Now
 * Error page (Open Application Form)
 */
function rcn_error_page_open_application_render() {
    $options = get_option('rcn_settings');
    $rcn_error_page_open_application = isset($options['rcn_error_page_open_application']) ? $options['rcn_error_page_open_application'] : '';
?>
    <select name='rcn_settings[rcn_error_page_open_application]'>
        <?php
        $pages = get_pages();
        foreach ($pages as $page) {
            $option = '<option value="' . $page->ID . '" ' . selected($rcn_error_page_open_application, $page->ID, false) . '>';
            $option .= $page->post_title;
            $option .= '</option>';
            echo $option;
        }
        ?>
    </select>
<?php
}

/**
 * @package Recruit Now
 * Success Page ( CV Generator Form )
 */
function rcn_success_page_cv_generator_render() {
    $options = get_option('rcn_settings');
    $rcn_success_page_cv_generator = isset($options['rcn_success_page_cv_generator']) ? $options['rcn_success_page_cv_generator'] : '';
?>
    <select name='rcn_settings[rcn_success_page_cv_generator]'>
        <?php
        $pages = get_pages();
        foreach ($pages as $page) {
            $option = '<option value="' . $page->ID . '" ' . selected($rcn_success_page_cv_generator, $page->ID, false) . '>';
            $option .= $page->post_title;
            $option .= '</option>';
            echo $option;
        }
        ?>
    </select>
<?php
}

/**
 * @package RecruitNow
 * Section Description Callback
 * Section: Open Application Form
 */
function rcn_open_application_section_callback() {
?>
    <p class="setting-info">
        <i><?php _e('Following settings are related to register application form.', 'recruitnow'); ?></i>
    </p>
<?php
}

/**
 * @package RecruitNow
 * Section Description Callback
 * Section: Application Widget
 */
function rcn_application_widget_section_callback() {
?>
    <p class="setting-info">
        <i><?php _e('Following settings are related to jobboard application form widget.', 'recruitnow'); ?></i>
    </p>
<?php
}

/**
 * @package RecruitNow
 * Section Description Callback
 * Section: Data Feed
 */
function rcn_data_feed_section_callback() {
?>
    <p class="setting-info">
        <i><?php _e('following settings are related to the Data Feed website', 'recruitnow'); ?></i>
    </p>
<?php
}

/**
 * @package RecruitNow
 * Section Description Callback
 * Section: CV Generator
 */
function rcn_cv_generator_section_callback() {
?>
    <p class="setting-info">
        <i><?php _e('following settings are related to CV generator', 'recruitnow'); ?></i>
    </p>
<?php
}

/**
 * Top level menu: Recruit Now
 * Admin Page Callback
 */
function rcn_options_page() {
?>
    <div class="plugin-head">
        <h2 class="plugin-title"><?php _e('Recruit Now', 'recruitnow'); ?></h2>
        <p class="plugin-description"><?php _e('Recruit Now is a plugin that is related to Connect your Recruit Now Cockpit with WordPress.', 'recruitnow'); ?></p>
    </div>
    <div class="plugin-body">
        <form action='options.php' method='post'>
            <?php
            settings_fields('rcn_page');
            do_settings_sections('rcn_page');
            submit_button();
            ?>
        </form>
    </div>
<?php
}
