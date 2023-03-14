<?php

add_filter('rwmb_meta_boxes', 'your_prefix_register_meta_boxes');

function your_prefix_register_meta_boxes($meta_boxes) {
    $prefix = 'recruit_now_';

    $meta_boxes[] = [
        'title'   => esc_html__('Vacancies Field Group', 'recruit-now'),
        'id'      => 'untitled',
        'context' => 'normal',
        'fields'  => [
            [
                'type' => 'heading',
                'name' => esc_html__('JSON Field', 'recruit-now'),
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Vacancies ID', 'recruit-now'),
                'id'   => $prefix . 'vacancies_id',
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Remote Id', 'recruit-now'),
                'id'   => $prefix . 'remote_id',
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Reference Number', 'recruit-now'),
                'id'   => $prefix . 'reference_number',
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Title', 'recruit-now'),
                'id'   => $prefix . 'title',
            ],
            [
                'type' => 'datetime',
                'name' => esc_html__('Created At', 'recruit-now'),
                'id'   => $prefix . 'created_at',
            ],
            [
                'type' => 'date',
                'name' => esc_html__('Last Edited At', 'recruit-now'),
                'id'   => $prefix . 'last_edited_at',
            ],
            [
                'type' => 'date',
                'name' => esc_html__('Publication Date', 'recruit-now'),
                'id'   => $prefix . 'publication_date',
            ],
            [
                'type' => 'date',
                'name' => esc_html__('Expiration Date', 'recruit-now'),
                'id'   => $prefix . 'expiration_date',
            ],
            [
                'type' => 'heading',
                'name' => esc_html__('Descriptions', 'recruit-now'),
            ],
            [
                'type' => 'textarea',
                'name' => esc_html__('Summary', 'recruit-now'),
                'id'   => $prefix . 'summary',
            ],
            [
                'type' => 'textarea',
                'name' => esc_html__('Function Description', 'recruit-now'),
                'id'   => $prefix . 'function_description',
            ],
            [
                'type' => 'textarea',
                'name' => esc_html__('Client Description', 'recruit-now'),
                'id'   => $prefix . 'client_description',
            ],
            [
                'type' => 'textarea',
                'name' => esc_html__('Requirements Description', 'recruit-now'),
                'id'   => $prefix . 'requirements_description',
            ],
            [
                'type' => 'textarea',
                'name' => esc_html__('Offer Description', 'recruit-now'),
                'id'   => $prefix . 'offer_description',
            ],
            [
                'type' => 'textarea',
                'name' => esc_html__('Additional Description', 'recruit-now'),
                'id'   => $prefix . 'additional_description',
            ],
            [
                'type' => 'textarea',
                'name' => esc_html__('Application Procedure Description', 'recruit-now'),
                'id'   => $prefix . 'application_procedure_description',
            ],
            [
                'type' => 'heading',
                'name' => esc_html__('Facets', 'recruit-now'),
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Regions', 'recruit-now'),
                'id'   => $prefix . 'regions',
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Function Types', 'recruit-now'),
                'id'   => $prefix . 'function_types',
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Contract Types', 'recruit-now'),
                'id'   => $prefix . 'contract_types',
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Experience Levels', 'recruit-now'),
                'id'   => $prefix . 'experience_levels',
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Categories', 'recruit-now'),
                'id'   => $prefix . 'categories',
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Hours Per Week', 'recruit-now'),
                'id'   => $prefix . 'hours_per_week',
            ],
            [
                'type' => 'heading',
                'name' => esc_html__('Application', 'recruit-now'),
            ],
            [
                'type' => 'number',
                'name' => esc_html__('Max Allowed Applications', 'recruit-now'),
                'id'   => $prefix . 'max_allowed_applications',
            ],
            [
                'type' => 'number',
                'name' => esc_html__('Remaining Applications', 'recruit-now'),
                'id'   => $prefix . 'remaining_applications',
            ],
            [
                'type' => 'checkbox',
                'name' => esc_html__('Curriculum Vitae Required', 'recruit-now'),
                'id'   => $prefix . 'curriculum_vitae_required',
            ],
            [
                'type' => 'heading',
                'name' => esc_html__('Employment', 'recruit-now'),
            ],
            [
                'type' => 'number',
                'name' => esc_html__('Hours PerWeek Min', 'recruit-now'),
                'id'   => $prefix . 'hours_perweek_min',
            ],
            [
                'type' => 'number',
                'name' => esc_html__('Hours Per Week Max', 'recruit-now'),
                'id'   => $prefix . 'hours_per_week_max',
            ],
            [
                'type' => 'checkbox',
                'name' => esc_html__('Shift Service', 'recruit-now'),
                'id'   => $prefix . 'shift_service',
            ],
            [
                'type' => 'number',
                'name' => esc_html__('Travel Distance', 'recruit-now'),
                'id'   => $prefix . 'travel_distance',
            ],
            [
                'type' => 'heading',
                'name' => esc_html__('Work Location', 'recruit-now'),
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Street', 'recruit-now'),
                'id'   => $prefix . 'street',
            ],
            [
                'type' => 'number',
                'name' => esc_html__('House Number', 'recruit-now'),
                'id'   => $prefix . 'house_number',
            ],
            [
                'type' => 'text',
                'name' => esc_html__('House Nmber Suffix', 'recruit-now'),
                'id'   => $prefix . 'house_nmber_suffix',
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Zip Code', 'recruit-now'),
                'id'   => $prefix . 'zip_code',
            ],
            [
                'type' => 'text',
                'name' => esc_html__('City', 'recruit-now'),
                'id'   => $prefix . 'city',
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Country', 'recruit-now'),
                'id'   => $prefix . 'country',
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Region', 'recruit-now'),
                'id'   => $prefix . 'region',
            ],
            [
                'type' => 'number',
                'name' => esc_html__('Latitude', 'recruit-now'),
                'id'   => $prefix . 'latitude',
            ],
            [
                'type' => 'number',
                'name' => esc_html__('Longitude', 'recruit-now'),
                'id'   => $prefix . 'longitude',
            ],
            [
                'type' => 'heading',
                'name' => esc_html__('Salary', 'recruit-now'),
            ],
            [
                'type' => 'number',
                'name' => esc_html__('Salary Min', 'recruit-now'),
                'id'   => $prefix . 'salary_min',
            ],
            [
                'type' => 'number',
                'name' => esc_html__('Salary Max', 'recruit-now'),
                'id'   => $prefix . 'salary_max',
            ],
            [
                'type' => 'textarea',
                'name' => esc_html__('Description', 'recruit-now'),
                'id'   => $prefix . 'salary_description',
            ],
            [
                'type' => 'heading',
                'name' => esc_html__('Recruiter', 'recruit-now'),
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Id', 'recruit-now'),
                'id'   => $prefix . 'recruiter_id',
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Remote Id', 'recruit-now'),
                'id'   => $prefix . 'recruiter_remote_id',
            ],
            [
                'type' => 'text',
                'name' => esc_html__('First Name', 'recruit-now'),
                'id'   => $prefix . 'recruiter_first_name',
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Middle Name', 'recruit-now'),
                'id'   => $prefix . 'recruiter_middle_name',
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Email Address', 'recruit-now'),
                'id'   => $prefix . 'recruiter_email_address',
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Phone Number', 'recruit-now'),
                'id'   => $prefix . 'recruiter_phone_number',
            ],
            [
                'type' => 'text',
                'name' => esc_html__('Mobile Phone Number', 'recruit-now'),
                'id'   => $prefix . 'recruiter_mobile_phone_number',
            ],
        ],
    ];

    return $meta_boxes;
}
