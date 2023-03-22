<?php

/**
 * Important class
 * Generate Custom Post Type
 * Generate Custom Meta Boxes
 */

class Custom_Meta_Box {
    private $screen = array(
        'vacancies'
    );

    public $prefix = 'recruit_now_';

    private $meta_fields = [
        [
            'type' => 'heading',
            'label' => 'General Informations',
        ],
        [
            'type'  => 'text',
            'label' => 'ID',
            'id'    => 'vacancies_id',
        ],
        [
            'type'  => 'text',
            'label' => 'Remote Id',
            'id'    => 'remote_id',
        ],
        [
            'type'  => 'text',
            'label' => 'Reference Number',
            'id'    => 'reference_number',
        ],
        [
            'type'  => 'datetime',
            'label' => 'Created At',
            'id'    => 'created_at',
        ],
        [
            'type'  => 'datetime',
            'label' => 'Expiration Date',
            'id'    => 'expiration_date',
        ],
        [
            'type' => 'heading',
            'label' => 'Descriptions',
        ],
        [
            'type'  => 'textarea',
            'label' => 'Summary',
            'id'    => 'summary',
        ],
        [
            'type'  => 'textarea',
            'label' => 'Function Description',
            'id'    => 'function_description',
        ],
        [
            'type'  => 'textarea',
            'label' => 'Client Description',
            'id'    => 'client_description',
        ],
        [
            'type'  => 'textarea',
            'label' => 'Requirements Description',
            'id'    => 'requirements_description',
        ],
        [
            'type'  => 'textarea',
            'label' => 'Offer Description',
            'id'    => 'offer_description',
        ],
        [
            'type'  => 'textarea',
            'label' => 'Additional Description',
            'id'    => 'additional_description',
        ],
        [
            'type'  => 'textarea',
            'label' => 'Application Procedure Description',
            'id'    => 'application_procedure_description',
        ],
        [
            'type' => 'heading',
            'label' => 'Facets',
        ],
        [
            'type'  => 'list',
            'label' => 'Regions',
            'id'    => 'regions',
        ],
        [
            'type'  => 'list',
            'label' => 'Function Types',
            'id'    => 'function_types',
        ],
        [
            'type'  => 'list',
            'label' => 'Contract Types',
            'id'    => 'contract_types',
        ],
        [
            'type'  => 'list',
            'label' => 'Experience Levels',
            'id'    => 'experience_levels',
        ],
        [
            'type'  => 'list',
            'label' => 'Categories',
            'id'    => 'categories',
        ],
        /**
         * need check because data not showing
         */
        [
            'type'  => 'text',
            'label' => 'Hours Per Week',
            'id'    => 'hours_per_week',
        ],
        [
            'type' => 'heading',
            'label' => 'Application',
        ],
        [
            'type'  => 'number',
            'label' => 'Max Allowed Applications',
            'id'    => 'max_allowed_applications',
        ],
        [
            'type'  => 'number',
            'label' => 'Remaining Applications',
            'id'    => 'remaining_applications',
        ],
        [
            'type'  => 'checkbox',
            'label' => 'Curriculum Vitae Required',
            'id'    => 'curriculum_vitae_required',
        ],
        [
            'type' => 'heading',
            'label' => 'Employment',
        ],
        [
            'type'  => 'number',
            'label' => 'Hours PerWeek Min',
            'id'    => 'hours_perweek_min',
        ],
        [
            'type'  => 'number',
            'label' => 'Hours Per Week Max',
            'id'    => 'hours_per_week_max',
        ],
        [
            'type'  => 'checkbox',
            'label' => 'Shift Service',
            'id'    => 'shift_service',
        ],
        [
            'type'  => 'number',
            'label' => 'Travel Distance',
            'id'    => 'travel_distance',
        ],
        [
            'type' => 'heading',
            'label' => 'Work Location',
        ],
        [
            'type'  => 'text',
            'label' => 'Street',
            'id'    => 'street',
        ],
        [
            'type'  => 'number',
            'label' => 'House Number',
            'id'    => 'house_number',
        ],
        [
            'type'  => 'text',
            'label' => 'House Nmber Suffix',
            'id'    => 'house_nmber_suffix',
        ],
        [
            'type'  => 'text',
            'label' => 'Zip Code',
            'id'    => 'zip_code',
        ],
        [
            'type'  => 'text',
            'label' => 'City',
            'id'    => 'city',
        ],
        [
            'type'  => 'text',
            'label' => 'Country',
            'id'    => 'country',
        ],
        [
            'type'  => 'text',
            'label' => 'Region',
            'id'    => 'region',
        ],
        [
            'type'  => 'number',
            'label' => 'Latitude',
            'id'    => 'latitude',
        ],
        [
            'type'  => 'number',
            'label' => 'Longitude',
            'id'    => 'longitude',
        ],
        [
            'type' => 'heading',
            'label' => 'Salary',
        ],
        [
            'type'  => 'number',
            'label' => 'Min',
            'id'    => 'salary_min',
        ],
        [
            'type'  => 'number',
            'label' => 'Max',
            'id'    => 'salary_max',
        ],
        [
            'type'  => 'textarea',
            'label' => 'Description',
            'id'    => 'salary_description',
        ],
        [
            'type' => 'heading',
            'label' => 'Recruiter',
        ],
        [
            'type'  => 'text',
            'label' => 'Id',
            'id'    => 'recruiter_id',
        ],
        [
            'type'  => 'text',
            'label' => 'Remote Id',
            'id'    => 'recruiter_remote_id',
        ],
        [
            'type'  => 'text',
            'label' => 'First Name',
            'id'    => 'recruiter_first_name',
        ],
        [
            'type'  => 'text',
            'label' => 'Middle Name',
            'id'    => 'recruiter_middle_name',
        ],
        [
            'type'  => 'text',
            'label' => 'Last Name',
            'id'    => 'recruiter_last_name',
        ],
        [
            'type'  => 'text',
            'label' => 'Email Address',
            'id'    => 'recruiter_email_address',
        ],
        [
            'type'  => 'text',
            'label' => 'Phone Number',
            'id'    => 'recruiter_phone_number',
        ],
        [
            'type'  => 'text',
            'label' => 'Mobile Phone Number',
            'id'    => 'recruiter_mobile_phone_number',
        ],
        [
            'type' => 'heading',
            'label' => 'Office',
        ],
        [
            'type'  => 'text',
            'label' => 'Id',
            'id'    => 'office_id',
        ],
        [
            'type'  => 'text',
            'label' => 'Remote Id',
            'id'    => 'office_remote_id',
        ],
        [
            'type'  => 'text',
            'label' => 'Name',
            'id'    => 'office_name',
        ],
        [
            'type'  => 'text',
            'label' => 'Summary',
            'id'    => 'office_summary',
        ],
        [
            'type'  => 'text',
            'label' => 'Description',
            'id'    => 'office_description',
        ],
        [
            'type'  => 'text',
            'label' => 'Email Address',
            'id'    => 'office_email_address',
        ],
        [
            'type'  => 'text',
            'label' => 'Phone Number',
            'id'    => 'office_phone_number',
        ],
        [
            'type'  => 'text',
            'label' => 'Mobile Phone Number',
            'id'    => 'office_mobile_phone_number',
        ],
        [
            'type' => 'heading',
            'label' => 'Office Address',
        ],
        [
            'type'  => 'text',
            'label' => 'Street',
            'id'    => 'office_address_street',
        ],
        [
            'type'  => 'text',
            'label' => 'House Number',
            'id'    => 'office_address_house_number',
        ],
        [
            'type'  => 'text',
            'label' => 'House Number Suffix',
            'id'    => 'office_address_house_number_suffix',
        ],
        [
            'type'  => 'text',
            'label' => 'Zipcode',
            'id'    => 'office_address_zip_code',
        ],
        [
            'type'  => 'text',
            'label' => 'City',
            'id'    => 'office_address_city',
        ],
        [
            'type'  => 'text',
            'label' => 'Country',
            'id'    => 'office_address_country',
        ],
        [
            'type'  => 'text',
            'label' => 'Region',
            'id'    => 'office_address_region',
        ],
        [
            'type'  => 'text',
            'label' => 'Latitude',
            'id'    => 'office_address_latitude',
        ],
        [
            'type'  => 'text',
            'label' => 'Longitude',
            'id'    => 'office_address_longitude',
        ],
        [
            'type' => 'heading',
            'label' => 'Employer',
        ],
        [
            'type'  => 'text',
            'label' => 'ID',
            'id'    => 'employer_id',
        ],
        [
            'type'  => 'text',
            'label' => 'Remote Id',
            'id'    => 'employer_remote_id',
        ],
        [
            'type'  => 'text',
            'label' => 'Email Address',
            'id'    => 'employer_email_address',
        ],
        [
            'type'  => 'text',
            'label' => 'Phone Number',
            'id'    => 'employer_phone_number',
        ],
        [
            'type'  => 'text',
            'label' => 'Mobile Phone Number',
            'id'    => 'employer_mobile_phone_number',
        ],
        [
            'type' => 'heading',
            'label' => 'Employer Address',
        ],
        [
            'type'  => 'text',
            'label' => 'Street',
            'id'    => 'employer_address_street',
        ],
        [
            'type'  => 'text',
            'label' => 'House Number',
            'id'    => 'employer_address_house_number',
        ],
        [
            'type'  => 'text',
            'label' => 'House Number Suffix',
            'id'    => 'employer_address_house_number_suffix',
        ],
        [
            'type'  => 'text',
            'label' => 'Zip Code',
            'id'    => 'employer_address_zip_code',
        ],
        [
            'type'  => 'text',
            'label' => 'City',
            'id'    => 'employer_address_city',
        ],
        [
            'type'  => 'text',
            'label' => 'Country',
            'id'    => 'employer_address_country',
        ],
        [
            'type'  => 'text',
            'label' => 'Region',
            'id'    => 'employer_address_region',
        ],
        [
            'type'  => 'text',
            'label' => 'Latitude',
            'id'    => 'employer_address_latitude',
        ],
        [
            'type'  => 'text',
            'label' => 'Latitude',
            'id'    => 'employer_address_longitude',
        ],
    ];

    public function __construct() {
        // custom post type
        add_action('init', [$this, 'rcn_custom_post_type']);
        add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        add_action('save_post', [$this, 'save_fields']);
    }

    public function rcn_custom_post_type() {
        $labels = array(
            'name'               => 'Vacancies',
            'singular_name'      => 'Vacancy',
            'add_new'            => 'Add New Vacancy',
            'add_new_item'       => 'Add New Vacancy',
            'edit_item'          => 'Edit Vacancy',
            'new_item'           => 'New Vacancy',
            'all_items'          => 'All Vacancies',
            'view_item'          => 'View Vacancy',
            'search_items'       => 'Search Vacancies',
            'not_found'          => 'No Vacancies found',
            'not_found_in_trash' => 'No Vacancies found in Trash',
            'parent_item_colon'  => '',
            'menu_name'          => 'Vacancies'
        );
        $args = array(
            'labels'                => $labels,
            'description'           => 'Holds our Vacancies and Vacancy specific data',
            'public'                => true,
            'menu_position'         => 5,
            'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
            'has_archive'           => true,
            'rewrite'               => array('slug' => 'vacancies'),
            'show_in_rest'          => true,
            'rest_base'             => 'vacancies',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
            'menu_icon'             => 'dashicons-category',
        );
        register_post_type('vacancies', $args);
    }

    public function add_meta_boxes() {
        foreach ($this->screen as $single_screen) {
            add_meta_box(
                'new',
                __('Vacancies Data', 'recruit-now'),
                array($this, 'meta_box_callback'),
                $single_screen,
                'normal',
                'default'
            );
        }
    }

    public function meta_box_callback($post) {
        wp_nonce_field('rnc_v_data', 'rcn_v_nonce');
        $this->field_generator($post);
    }
    public function field_generator($post) {
        $output = '';
        foreach ($this->meta_fields as $meta_field) {
            $meta_id = isset($meta_field['id']) ? $meta_field['id'] : '';
            $meta_type = isset($meta_field['type']) ? $meta_field['type'] : '';
            $label = '<label for="' . $this->prefix . $meta_id . '">' . $meta_field['label'] . '</label>';
            $meta_value = get_post_meta($post->ID, $this->prefix . $meta_id, true);

            if (empty($meta_value)) {
                if (isset($meta_field['default'])) {
                    $meta_value = $meta_field['default'];
                }
            }
            switch ($meta_field['type']) {
                case 'checkbox':
                    $input = sprintf(
                        '<input %s id=" %s" name="%s" type="checkbox" value="1">',
                        $meta_value === '1' ? 'checked' : '',
                        $this->prefix . $meta_id,
                        $this->prefix . $meta_id
                    );
                    break;

                case 'textarea':
                    $input = sprintf(
                        '<textarea style="%s" id="%s" name="%s" rows="5">%s</textarea>',
                        'width: 100%',
                        $this->prefix . $meta_id,
                        $this->prefix . $meta_id,
                        $meta_value
                    );
                    break;

                case 'heading':
                    $input = sprintf(
                        '<h3 class="fields-heading">%s</h3>',
                        $meta_field['label']
                    );
                    break;

                case 'list':
                    $input = $this->format_list($meta_value);
                    break;

                default:
                    $input = sprintf(
                        '<input %s id="%s" name="%s" type="%s" value="%s">',
                        $meta_field['type'] !== 'color' ? 'style="width: 100%"' : '',
                        $this->prefix . $meta_id,
                        $this->prefix . $meta_id,
                        $meta_field['type'],
                        $meta_value
                    );
            }
            $output .= $this->format_rows($label, $input, $meta_type);
        }
        echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
    }

    public function format_rows($label, $input, $meta_type) {
        if ($meta_type == 'heading') {
            return '<tr><td colspan="2">' . $input . '</td></tr>';
        } else {
            return '<tr><th>' . $label . '</th><td>' . $input . '</td></tr>';
        }
    }

    public function format_list($meta_value) {
        if (empty($meta_value)) {
            return 'Empty Data';
        }
        $html = '<ul>';
        foreach ($meta_value as $value) {
            $html .= '<li>' . $value['Name'] . '</li>';
        }
        $html .= '</ul>';
        return $html;
    }

    public function save_fields($post_id) {
        if (!isset($_POST['rcn_v_nonce']))
            return $post_id;
        $nonce = $_POST['rcn_v_nonce'];
        if (!wp_verify_nonce($nonce, 'rnc_v_data'))
            return $post_id;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;
        foreach ($this->meta_fields as $meta_field) {
            if (isset($_POST[$this->prefix . $meta_field['id']])) {
                switch ($meta_field['type']) {
                    case 'email':
                        $_POST[$this->prefix . $meta_field['id']] = sanitize_email($_POST[$this->prefix . $meta_field['id']]);
                        break;
                    case 'text':
                        $_POST[$this->prefix . $meta_field['id']] = sanitize_text_field($_POST[$this->prefix . $meta_field['id']]);
                        break;
                    case 'textarea':
                        $_POST[$this->prefix . $meta_field['id']] = sanitize_text_field($_POST[$this->prefix . $meta_field['id']]);
                        break;
                    case 'number':
                        $_POST[$this->prefix . $meta_field['id']] = sanitize_text_field($_POST[$this->prefix . $meta_field['id']]);
                        break;
                    case 'list':
                        $_POST[$this->prefix . $meta_field['id']] = rest_sanitize_array($_POST[$this->prefix . $meta_field['id']]);
                        break;
                    default:
                        $_POST[$this->prefix . $meta_field['id']] = sanitize_text_field($_POST[$this->prefix . $meta_field['id']]);
                        break;
                }
                update_post_meta($post_id, $this->prefix . $meta_field['id'], $_POST[$this->prefix . $meta_field['id']]);
            } else if ($meta_field['type'] === 'checkbox') {
                update_post_meta($post_id, $this->prefix . $meta_field['id'], '0');
            }
        }
    }
}

if (class_exists('Custom_Meta_box')) {
    new Custom_Meta_box;
};
