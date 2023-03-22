<?php


get_header(); ?>

<div id="main-content" class="main-content">

    <div id="primary" class="content-area">
        <div id="content" class="site-content" role="main">
            <?php
            // Start the Loop.
            while (have_posts()) : the_post();
                $post_id = get_the_ID();

                $postmetas = get_post_meta($post_id, '', true);
                $data = $postmetas;
                $rcn_settings = get_option('rcn_settings');

                // api base url
                $apiBaseUrl = isset($rcn_settings['rcn_application_widget_url']) ? $rcn_settings['rcn_application_widget_url'] : 'https://roteck.recruitnowcockpit.nl/jobsite';

                // application form id
                $applicationFormId = isset($rcn_settings['rcn_application_form_id']) ? $rcn_settings['rcn_application_form_id'] : 'ApplicationForms-1-A';

                // Thank you page 
                $thankyou = get_permalink($rcn_settings['rcn_thank_you_page_application_form']);
                // Error page
                $error = get_permalink($rcn_settings['rcn_error_page_application_form']);

                $btn_text = isset($rcn_settings['rcn_application_form_button_text']) ? $rcn_settings['rcn_application_form_button_text'] : 'Apply Now';
            ?>
                <div class="recruit-single-grid">
                    <div class="job-board-application-form">
                        <jobboard-application-form title-prefix="" form-id="<?php echo $applicationFormId; ?>" vacancy-id="<?php echo $data['recruit_now_vacancies_id'][0]; ?>" api-base-url="<?php echo $apiBaseUrl; ?>" success="window.location.href = '/<?php echo $thankyou; ?>'" fail="window.location.href = '/<?php echo $error; ?>'" apply-btn-text="<?php echo $btn_text; ?>" utm-tags="utm_source=facebook&utm_medium=social" tracking-fields="customfields1=waarde1&customfields2=waarde2" referrer="https://url.vanherkomst.nl">
                        </jobboard-application-form>
                    </div>
                    <div class="vacancy-content">
                        <table border="1" cellpadding="8" cellspacing="0">
                            <tr>
                                <td><?php esc_html_e('Title', 'recruitnow'); ?> </td>
                                <td><?php echo wp_kses_post(get_the_title()); ?></td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Id', 'recruitnow'); ?> </td>
                                <td><?php echo wp_kses_post($data['recruit_now_vacancies_id'][0]); ?></td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('RemoteId', 'recruitnow'); ?> </td>
                                <td><?php echo wp_kses_post($data['recruit_now_remote_id'][0]); ?></td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('ReferenceNumber', 'recruitnow'); ?> </td>
                                <td><?php echo wp_kses_post($data['recruit_now_reference_number'][0]); ?></td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('CreatedAt', 'recruitnow'); ?></td>
                                <td><?php echo wp_kses_post(get_the_date()); ?></td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('PublicationDate', 'recruitnow'); ?></td>
                                <td><?php echo get_the_date('Y-m-d'); ?></td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('ExpirationDate', 'recruitnow'); ?></td>
                                <td><?php echo wp_kses_post($data['recruit_now_expiration_date'][0]); ?></td>
                            </tr>
                        </table>
                        <table border="1" cellpadding="8" cellspacing="0">
                            <tr>
                                <th colspan="2">
                                    <?php esc_html_e('Descriptions', 'recruitnow'); ?>
                                </th>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Summary', 'recruitnow'); ?></td>
                                <td><?php echo wp_kses_post($data['recruit_now_summary'][0]); ?></td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('FunctionDescription', 'recruitnow'); ?></td>
                                <td><?php echo wp_kses_post($data['recruit_now_function_description'][0]); ?></td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('ClientDescription', 'recruitnow'); ?></td>
                                <td><?php echo wp_kses_post($data['recruit_now_client_description'][0]); ?></td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('RequirementsDescription', 'recruitnow'); ?></td>
                                <td><?php echo wp_kses_post($data['recruit_now_requirements_description'][0]); ?></td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('OfferDescription', 'recruitnow'); ?></td>
                                <td><?php echo wp_kses_post($data['recruit_now_offer_description'][0]); ?></td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('AdditionalDescription', 'recruitnow'); ?></td>
                                <td><?php echo wp_kses_post($data['recruit_now_additional_description'][0]); ?></td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('ApplicationProcedureDescription', 'recruitnow'); ?></td>
                                <td><?php echo wp_kses_post($data['recruit_now_application_procedure_description'][0]); ?></td>
                            </tr>
                        </table>
                        <table border="1" cellpadding="8" cellspacing="0">
                            <tr>
                                <th colspan="2">
                                    <?php esc_html_e('Facets', 'recruitnow'); ?>
                                </th>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Regions', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    $regions = unserialize($data['recruit_now_regions'][0]);
                                    if (!empty($regions)) :
                                        foreach ($regions as $region) :
                                    ?>
                                            <li>
                                                <b>
                                                    <?php echo __("Id: ", 'recruitnow') ?>
                                                </b>
                                                <?php echo $region['Id']; ?>
                                            </li>
                                            <li>
                                                <b>
                                                    <?php echo __("Name: ", 'recruitnow') ?>
                                                </b>
                                                <?php echo $region['Name']; ?>
                                            </li>
                                            <li>
                                                <b>
                                                    <?php echo __("RemoteId: ", 'recruitnow') ?>
                                                </b>
                                                <?php echo $region['RemoteId']; ?>
                                            </li>
                                        <?php
                                        endforeach;
                                    else :
                                        ?>
                                        <?php echo __('Not Available', 'recruitnow') ?>
                                    <?php
                                    endif;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('FunctionTypes', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    $functionTypes = unserialize($data['recruit_now_function_types'][0]);

                                    if (!empty($functionTypes)) :
                                        foreach ($functionTypes as $functionType) :
                                    ?>
                                            <li>
                                                <b>
                                                    <?php echo __("Id: ", 'recruitnow') ?>
                                                </b>
                                                <?php echo $functionType['Id']; ?>
                                            </li>
                                            <li>
                                                <b>
                                                    <?php echo __("Name: ", 'recruitnow') ?>
                                                </b>
                                                <?php echo $functionType['Name']; ?>
                                            </li>
                                            <li>
                                                <b>
                                                    <?php echo __("RemoteId: ", 'recruitnow') ?>
                                                </b>
                                                <?php echo $functionType['RemoteId']; ?>
                                            </li>
                                        <?php
                                        endforeach;
                                    else :
                                        ?>
                                        <?php echo __('Not Available', 'recruitnow') ?>
                                    <?php
                                    endif;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('ContractTypes', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    $contractTypes = unserialize($data['recruit_now_contract_types'][0]);
                                    if (!empty($contractTypes)) :
                                        foreach ($contractTypes as $contractType) :
                                    ?>
                                            <li>
                                                <b>
                                                    <?php echo __("Id: ", 'recruitnow') ?>
                                                </b>
                                                <?php echo $contractType['Id']; ?>
                                            </li>
                                            <li>
                                                <b>
                                                    <?php echo __("Name: ", 'recruitnow') ?>
                                                </b>
                                                <?php echo $contractType['Name']; ?>
                                            </li>
                                            <li>
                                                <b>
                                                    <?php echo __("RemoteId: ", 'recruitnow') ?>
                                                </b>
                                                <?php echo $contractType['RemoteId']; ?>
                                            </li>
                                        <?php
                                        endforeach;
                                    else :
                                        ?>
                                        <?php echo __('Not Available', 'recruitnow') ?>
                                    <?php
                                    endif;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('ExperienceLevels', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    $experienceLevels = unserialize($data['recruit_now_experience_levels'][0]);
                                    if (!empty($experienceLevels)) :
                                        foreach ($experienceLevels as $experienceLevel) :
                                    ?>
                                            <li>
                                                <b>
                                                    <?php echo __("Id: ", 'recruitnow') ?>
                                                </b>
                                                <?php echo $experienceLevel['Id']; ?>
                                            </li>
                                            <li>
                                                <b>
                                                    <?php echo __("Name: ", 'recruitnow') ?>
                                                </b>
                                                <?php echo $experienceLevel['Name']; ?>
                                            </li>
                                            <li>
                                                <b>
                                                    <?php echo __("RemoteId: ", 'recruitnow') ?>
                                                </b>
                                                <?php echo $experienceLevel['RemoteId']; ?>
                                            </li>
                                        <?php
                                        endforeach;
                                    else :
                                        ?>
                                        <?php echo __('Not Available', 'recruitnow') ?>
                                    <?php
                                    endif;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('EducationLevels', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    $educationLevels = unserialize($data['recruit_now_experience_levels'][0]);
                                    if (!empty($educationLevels)) :
                                        foreach ($educationLevels as $educationLevel) :
                                    ?>
                                            <li>
                                                <b>
                                                    <?php echo __("Id: ", 'recruitnow') ?>
                                                </b>
                                                <?php echo $educationLevel['Id']; ?>
                                            </li>
                                            <li>
                                                <b>
                                                    <?php echo __("Name: ", 'recruitnow') ?>
                                                </b>
                                                <?php echo $educationLevel['Name']; ?>
                                            </li>
                                            <li>
                                                <b>
                                                    <?php echo __("RemoteId: ", 'recruitnow') ?>
                                                </b>
                                                <?php echo $educationLevel['RemoteId']; ?>
                                            </li>
                                        <?php
                                        endforeach;
                                    else :
                                        ?>
                                        <?php echo __('Not Available', 'recruitnow') ?>
                                    <?php
                                    endif;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Categories', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    $categories = unserialize($data['recruit_now_categories'][0]);
                                    if (!empty($categories)) :
                                        foreach ($categories as $category) :
                                    ?>
                                            <li>
                                                <b>
                                                    <?php echo __("Id: ", 'recruitnow') ?>
                                                </b>
                                                <?php echo $category['Id']; ?>
                                            </li>
                                            <li>
                                                <b>
                                                    <?php echo __("Name: ", 'recruitnow') ?>
                                                </b>
                                                <?php echo $category['Name']; ?>
                                            </li>
                                            <li>
                                                <b>
                                                    <?php echo __("RemoteId: ", 'recruitnow') ?>
                                                </b>
                                                <?php echo $category['RemoteId']; ?>
                                            </li>
                                        <?php
                                        endforeach;
                                    else :
                                        ?>
                                        <?php echo __('Not Available', 'recruitnow') ?>
                                    <?php
                                    endif;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('HoursPerWeek', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    $hoursPerWeek = unserialize($data['recruit_now_hours_per_week'][0]);
                                    if (!empty($hoursPerWeek)) :
                                        foreach ($hoursPerWeek as $hourPerWeek) :
                                    ?>
                                            <li>
                                                <b>
                                                    <?php echo __("Id: ", 'recruitnow') ?>
                                                </b>
                                                <?php echo $hourPerWeek['Id']; ?>
                                            </li>
                                            <li>
                                                <b>
                                                    <?php echo __("Name: ", 'recruitnow') ?>
                                                </b>
                                                <?php echo $hourPerWeek['Name']; ?>
                                            </li>
                                            <li>
                                                <b>
                                                    <?php echo __("RemoteId: ", 'recruitnow') ?>
                                                </b>
                                                <?php echo $hourPerWeek['RemoteId']; ?>
                                            </li>
                                        <?php
                                        endforeach;
                                    else :
                                        ?>
                                        <?php echo __('Not Available', 'recruitnow') ?>
                                    <?php
                                    endif;
                                    ?>
                                </td>
                            </tr>
                        </table>
                        <table border="1" cellpadding="8" cellspacing="0">
                            <tr>
                                <th colspan="2">
                                    <?php esc_html_e('Application', 'recruitnow'); ?>
                                </th>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('MaxAllowedApplications', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_max_allowed_applications'][0]) ? $data['recruit_now_max_allowed_applications'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('RemainingApplications', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_remaining_applications'][0]) ? $data['recruit_now_remaining_applications'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('CurriculumVitaeRequired', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo $data['recruit_now_curriculum_vitae_required'][0] === true ? 'true' : 'false';
                                    ?>
                                </td>
                            </tr>
                        </table>
                        <table border="1" cellpadding="8" cellspacing="0">
                            <tr>
                                <th colspan="2">
                                    <?php esc_html_e('Employment', 'recruitnow'); ?>
                                </th>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Hours Per Week Min', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_hours_perweek_min'][0]) ? $data['recruit_now_hours_perweek_min'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Hours Per Week Max', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_hours_per_week_max'][0]) ? $data['recruit_now_hours_per_week_max'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Shift Service', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo $data['recruit_now_shift_service'][0] === true ? 'Yes' : 'No';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Travel Distance', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_travel_distance'][0]) ? $data['recruit_now_travel_distance'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                        </table>
                        <table border="1" cellpadding="8" cellspacing="0">
                            <tr>
                                <th colspan="2">
                                    <?php esc_html_e('Work Location', 'recruitnow'); ?>
                                </th>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Street', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_street'][0]) ? $data['recruit_now_street'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('House number', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_house_number'][0]) ? $data['recruit_now_house_number'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('House number Suffix', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_house_nmber_suffix'][0]) ? $data['recruit_now_house_nmber_suffix'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Zipcode', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_zip_code'][0]) ? $data['recruit_now_zip_code'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('City', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_city'][0]) ? $data['recruit_now_city'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Country', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_country'][0]) ? $data['recruit_now_country'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Region', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_region'][0]) ? $data['recruit_now_region'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Latitude', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_latitude'][0]) ? $data['recruit_now_latitude'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Longitude', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_longitude'][0]) ? $data['recruit_now_longitude'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                        </table>
                        <table border="1" cellpadding="8" cellspacing="0">
                            <tr>
                                <th colspan="2">
                                    <?php esc_html_e('Salary', 'recruitnow'); ?>
                                </th>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Salary Min', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_salary_min'][0]) ? $data['recruit_now_salary_min'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Salary Max', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_salary_max'][0]) ? $data['recruit_now_salary_max'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Description', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_salary_description'][0]) ? $data['recruit_now_salary_description'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                        </table>
                        <table border="1" cellpadding="8" cellspacing="0">
                            <tr>
                                <th colspan="2">
                                    <?php esc_html_e('Recruiter', 'recruitnow'); ?>
                                </th>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Id', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_recruiter_id'][0]) ? $data['recruit_now_recruiter_id'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Remote Id', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_recruiter_remote_id'][0]) ? $data['recruit_now_recruiter_remote_id'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('FirstName', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_recruiter_first_name'][0]) ? $data['recruit_now_recruiter_first_name'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('MiddleName', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_recruiter_middle_name'][0]) ? $data['recruit_now_recruiter_middle_name'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('LastName', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_recruiter_last_name'][0]) ? $data['recruit_now_recruiter_last_name'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('EmailAddress', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_recruiter_email_address'][0]) ? $data['recruit_now_recruiter_email_address'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('PhoneNumber', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_recruiter_phone_number'][0]) ? $data['recruit_now_recruiter_phone_number'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('MobilePhoneNumber', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_recruiter_mobile_phone_number'][0]) ? $data['recruit_now_recruiter_mobile_phone_number'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                        </table>
                        <table border="1" cellpadding="8" cellspacing="0">
                            <tr>
                                <th colspan="2">
                                    <?php esc_html_e('Office', 'recruitnow'); ?>
                                </th>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Id', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_office_id'][0]) ? $data['recruit_now_office_id'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Remote Id', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_office_remote_id'][0]) ? $data['recruit_now_office_remote_id'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Name', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_office_name'][0]) ? $data['recruit_now_office_name'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Summary', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_office_summary'][0]) ? $data['recruit_now_office_summary'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Description', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_office_description'][0]) ? $data['recruit_now_office_description'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('EmailAddress', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_office_email_address'][0]) ? $data['recruit_now_office_email_address'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Phone Number', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_office_phone_number'][0]) ? $data['recruit_now_office_phone_number'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Mobile Phone Number', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_office_mobile_phone_number'][0]) ? $data['recruit_now_office_mobile_phone_number'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                        </table>
                        <table border="1" cellpadding="8" cellspacing="0">
                            <tr>
                                <th colspan="2">
                                    <?php esc_html_e('Office Address', 'recruitnow'); ?>
                                </th>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Street', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_office_address_street'][0]) ? $data['recruit_now_office_address_street'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('House number', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_office_address_house_number'][0]) ? $data['recruit_now_office_address_house_number'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('House number Suffix', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_office_address_house_number_suffix'][0]) ? $data['recruit_now_office_address_house_number_suffix'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Zipcode', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_office_address_zip_code'][0]) ? $data['recruit_now_office_address_zip_code'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('City', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_office_address_city'][0]) ? $data['recruit_now_office_address_city'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Country', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_office_address_country'][0]) ? $data['recruit_now_office_address_country'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Region', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_office_address_region'][0]) ? $data['recruit_now_office_address_region'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Latitude', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_office_address_latitude'][0]) ? $data['recruit_now_office_address_latitude'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Longitude', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_office_address_longitude'][0]) ? $data['recruit_now_office_address_longitude'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                        </table>
                        <table border="1" cellpadding="8" cellspacing="0">
                            <tr>
                                <th colspan="2">
                                    <?php esc_html_e('Employer', 'recruitnow'); ?>
                                </th>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Id', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_employer_id'][0]) ? $data['recruit_now_employer_id'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Remote Id', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_employer_remote_id'][0]) ? $data['recruit_now_employer_remote_id'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Email Address', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_employer_email_address'][0]) ? $data['recruit_now_employer_email_address'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Phone Number', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_employer_phone_number'][0]) ? $data['recruit_now_employer_phone_number'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Mobile Phone Number', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_employer_mobile_phone_number'][0]) ? $data['recruit_now_employer_mobile_phone_number'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                        </table>
                        <table border="1" cellpadding="8" cellspacing="0">
                            <tr>
                                <th colspan="2">
                                    <?php esc_html_e('Employer Address', 'recruitnow'); ?>
                                </th>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Street', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_employer_address_street'][0]) ? $data['recruit_now_employer_address_street'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('House number', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_employer_address_house_number'][0]) ? $data['recruit_now_employer_address_house_number'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('House number Suffix', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_employer_address_house_number_suffix'][0]) ? $data['recruit_now_employer_address_house_number_suffix'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Zipcode', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_employer_address_zip_code'][0]) ? $data['recruit_now_employer_address_zip_code'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('City', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_employer_address_city'][0]) ? $data['recruit_now_employer_address_city'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Country', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_employer_address_country'][0]) ? $data['recruit_now_employer_address_country'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Region', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_employer_address_region'][0]) ? $data['recruit_now_employer_address_region'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Latitude', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_employer_address_latitude'][0]) ? $data['recruit_now_employer_address_latitude'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php esc_html_e('Longitude', 'recruitnow'); ?></td>
                                <td>
                                    <?php
                                    echo isset($data['recruit_now_employer_address_longitude'][0]) ? $data['recruit_now_employer_address_longitude'][0] : __('Not Available',);
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            <?php
            endwhile;
            ?>
        </div><!-- #content -->
    </div><!-- #primary -->
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
