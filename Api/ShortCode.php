<?php

/**
 * ShortCode class
 * To Render Data
 */
class ShortCode {

    protected $rcn_settings;

    function __construct() {
        $this->rcn_settings = get_option('rcn_settings');
        add_shortcode('rcn_job_data', [$this, 'render_rcn_job_data_render']);
    }
    /**
     * Initializes a singleton instance
     * @staticvar boolean $instance
     * @return \RecruitNow
     */
    public static function init() {
        static $instance = false;

        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }
    /**
     * Render Job Data Table
     *
     * @return void
     */
    public function render_rcn_job_data_render() {
        if (isset($_GET['job-title']) || isset($_GET['id'])) {
            $vacancy_id = isset($_GET['id']) ? $_GET['id'] : '';
            $id = sanitize_text_field($vacancy_id);
            $this->job_single_render($id);
            return;
        }
        ob_start();
        $rcn_feed_data = rcn_feed_output();
?>
        <div class="recruit-data-feed">
            <table  border="1" cellpadding="8" cellspacing="0">
                <tr>
                    <td><b>Job Details</b></td>
                    <td><b>-</b></td>
                </tr>
                <?php
                if ('api_end_point_missing' !== $rcn_feed_data && false !== $rcn_feed_data) :
                    foreach ($rcn_feed_data as $data) :
                        // print_r($data);
                        // print_r($data['Id']);
                        // print_r($data['Title']);

                ?>
                        <tr>
                            <td>
                                <table  border="1" cellpadding="8" cellspacing="0">
                                    <tr>
                                        <td><?php esc_html_e('Title', 'recruitnow'); ?> </td>
                                        <td><?php echo wp_kses_post($data['Title']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php esc_html_e('CreatedAt', 'recruitnow'); ?></td>
                                        <td><?php echo wp_kses_post($data['CreatedAt']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php esc_html_e('LastEditedAt', 'recruitnow'); ?></td>
                                        <td><?php echo wp_kses_post($data['LastEditedAt']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php esc_html_e('PublicationDate', 'recruitnow'); ?></td>
                                        <td><?php echo wp_kses_post($data['PublicationDate']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php esc_html_e('ExpirationDate', 'recruitnow'); ?></td>
                                        <td><?php echo wp_kses_post($data['ExpirationDate']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php esc_html_e('Summary', 'recruitnow'); ?></td>
                                        <td><?php echo wp_kses_post($data['Descriptions']['Summary']); ?></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <?php
                                $id = $data['Id'];
                                $url = '?id=' . $id . '&job-title=' . sanitize_title_with_dashes(strtolower($data['Title']));
                                ?>
                                <a href="<?php echo esc_url($url); ?>">
                                    <?php esc_html_e('Read More', 'recruitnow'); ?>
                                </a>
                            </td>
                        </tr>
                <?php
                    endforeach;
                endif;
                ?>
            </table>
        </div>
    <?php
        return ob_get_clean();
    }

    public function job_single_render($id) {
        $rcn_feed_data = rcn_feed_output();
        ob_start();
        $key = array_search($id, array_column($rcn_feed_data, 'Id'));
        $data = $rcn_feed_data[$key];

        // api base url
		$apiBaseUrl = isset($this->rcn_settings['rcn_application_widget_url']) ? $this->rcn_settings['rcn_application_widget_url'] : 'https://roteck.recruitnowcockpit.nl/jobsite';

		// application form id
		$applicationFormId = isset($this->rcn_settings['rcn_application_form_id']) ? $this->rcn_settings['rcn_application_form_id'] : 'ApplicationForms-1-A';

		// Thank you page 
		$thankyou = get_permalink($this->rcn_settings['rcn_thank_you_page_application_form']);
		// Error page
		$error = get_permalink($this->rcn_settings['rcn_error_page_application_form']);

        $btn_text = isset($this->rcn_settings['rcn_application_form_button_text']) ? $this->rcn_settings['rcn_application_form_button_text'] : 'Apply Now';

    ?>
        <div class="recruit-single-grid">
            <div class="job-board-application-form">
                <jobboard-application-form
                    title-prefix=""
                    form-id="<?php echo $applicationFormId; ?>"
                    vacancy-id="<?php echo $data['Id'];?>"
                    api-base-url="<?php echo $apiBaseUrl; ?>"
                    success="window.location.href = '/<?php echo $thankyou; ?>'"
                    fail="window.location.href = '/<?php echo $error; ?>'"
                    apply-btn-text="<?php echo $btn_text; ?>"
                    utm-tags="utm_source=facebook&utm_medium=social"
                    tracking-fields="customfields1=waarde1&customfields2=waarde2"
                    referrer="https://url.vanherkomst.nl">
                </jobboard-application-form>
            </div>
            <div class="vacancy-content">
                <table  border="1" cellpadding="8" cellspacing="0">
                    <tr>
                        <tr>
                            <td><?php esc_html_e('Id', 'recruitnow'); ?> </td>
                            <td><?php echo wp_kses_post($data['Id']); ?></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e('RemoteId', 'recruitnow'); ?> </td>
                            <td><?php echo wp_kses_post($data['RemoteId']); ?></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e('ReferenceNumber', 'recruitnow'); ?> </td>
                            <td><?php echo wp_kses_post($data['ReferenceNumber']); ?></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e('Title', 'recruitnow'); ?> </td>
                            <td><?php echo wp_kses_post($data['Title']); ?></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e('CreatedAt', 'recruitnow'); ?></td>
                            <td><?php echo wp_kses_post($data['CreatedAt']); ?></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e('LastEditedAt', 'recruitnow'); ?></td>
                            <td><?php echo wp_kses_post($data['LastEditedAt']); ?></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e('PublicationDate', 'recruitnow'); ?></td>
                            <td><?php echo wp_kses_post($data['PublicationDate']); ?></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e('ExpirationDate', 'recruitnow'); ?></td>
                            <td><?php echo wp_kses_post($data['ExpirationDate']); ?></td>
                        </tr>
                    </tr>
                </table>
                <table  border="1" cellpadding="8" cellspacing="0">
                    <tr>
                        <tr>
                            <th colspan="2">
                                <?php esc_html_e('Descriptions', 'recruitnow'); ?>
                            </th>
                        </tr>
                        <tr>
                            <td><?php esc_html_e('Summary', 'recruitnow'); ?></td>
                            <td><?php echo wp_kses_post($data['Descriptions']['Summary']); ?></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e('FunctionDescription', 'recruitnow'); ?></td>
                            <td><?php echo wp_kses_post($data['Descriptions']['FunctionDescription']); ?></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e('ClientDescription', 'recruitnow'); ?></td>
                            <td><?php echo wp_kses_post($data['Descriptions']['ClientDescription']); ?></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e('RequirementsDescription', 'recruitnow'); ?></td>
                            <td><?php echo wp_kses_post($data['Descriptions']['RequirementsDescription']); ?></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e('OfferDescription', 'recruitnow'); ?></td>
                            <td><?php echo wp_kses_post($data['Descriptions']['OfferDescription']); ?></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e('AdditionalDescription', 'recruitnow'); ?></td>
                            <td><?php echo wp_kses_post($data['Descriptions']['AdditionalDescription']); ?></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e('ApplicationProcedureDescription', 'recruitnow'); ?></td>
                            <td><?php echo wp_kses_post($data['Descriptions']['ApplicationProcedureDescription']); ?></td>
                        </tr>
                    </tr>
                </table>
                <table  border="1" cellpadding="8" cellspacing="0">
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
                                    $regions = $data['Facets']['Regions'];
                                    if(!empty($regions)):
                                        foreach ($regions as $region):
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
                                    else: 
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
                                    $functionTypes = $data['Facets']['FunctionTypes'];
                                    if(!empty($functionTypes)):
                                        foreach ($functionTypes as $functionType):
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
                                    else: 
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
                                    $contractTypes = $data['Facets']['ContractTypes'];
                                    if(!empty($contractTypes)):
                                        foreach ($contractTypes as $contractType):
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
                                    else: 
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
                                    $experienceLevels = $data['Facets']['ExperienceLevels'];
                                    if(!empty($experienceLevels)):
                                        foreach ($experienceLevels as $experienceLevel):
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
                                    else: 
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
                                    $educationLevels = $data['Facets']['EducationLevels'];
                                    if(!empty($educationLevels)):
                                        foreach ($educationLevels as $educationLevel):
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
                                    else: 
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
                                    $categories = $data['Facets']['Categories'];
                                    if(!empty($categories)):
                                        foreach ($categories as $category):
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
                                    else: 
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
                                    $hoursPerWeek = $data['Facets']['HoursPerWeek'];
                                    if(!empty($hoursPerWeek)):
                                        foreach ($hoursPerWeek as $hourPerWeek):
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
                                    else: 
                                        ?>
                                            <?php echo __('Not Available', 'recruitnow') ?>
                                        <?php
                                    endif;
                                ?>
                            </td>
                        </tr>
                    </tr>
                </table>
                <table  border="1" cellpadding="8" cellspacing="0">
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
                                    echo isset($data['Application']['MaxAllowedApplications']) ? $data['Application']['MaxAllowedApplications'] : __('Not Available', ) ;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e('RemainingApplications', 'recruitnow'); ?></td>
                            <td>
                                <?php 
                                    echo isset($data['Application']['RemainingApplications']) ? $data['Application']['RemainingApplications'] : __('Not Available', ) ;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e('CurriculumVitaeRequired', 'recruitnow'); ?></td>
                            <td>
                                <?php 
                                    echo $data['Application']['CurriculumVitaeRequired'] === true ? 'true' : 'false' ;
                                ?>
                            </td>
                        </tr>
                    </tr>
                </table>
            </div>
        </div>
        
<?php
        echo ob_get_clean();
    }
}

/**
 * 
 * @return \RecruitNow
 */
function recruitnow_shortcode() {
    return ShortCode::init();
}

// kick-off the data feed
recruitnow_shortcode();
