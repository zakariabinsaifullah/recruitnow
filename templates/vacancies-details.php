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
                            </tr>
                        </table>
                        <table border="1" cellpadding="8" cellspacing="0">
                            <tr>
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
                            </tr>
                        </table>
                        <table border="1" cellpadding="8" cellspacing="0">
                            <tr>
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
                            </tr>
                        </table>
                        <table border="1" cellpadding="8" cellspacing="0">
                            <tr>
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
