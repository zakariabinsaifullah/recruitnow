<?php

/**
 * Data Feed
 * Fetch Data from Server
 * Insert Data to Database
 */

class RcnDataFeed {

    protected $API_END_POINT = false;


    public function __construct() {

        if ($this->get_api()) {
            $api_end_point = $this->get_api();
            $this->API_END_POINT = $api_end_point;
        } else {
            return;
        }

        /**
         * Store Fetch Data from Server & Cache
         * Will detect data from Cache
         * If Cache not exists then Fetch from Live Server
         */
        $this->fetch_remote_data();

        $this->rcn_feed_output();
    }

    /**
     * Get Data Feed API
     *
     * @return void
     */
    protected function get_api() {
        $fetch_option = get_option('rcn_settings', false);
        /**
         * Confrim Settings Init
         */
        if (!$fetch_option) {
            return false;
        }

        /**
         * Confrim API init & Feed API Not empty
         */
        if (!isset($fetch_option['rcn_data_feed_website']) || empty($fetch_option['rcn_data_feed_website'])) {
            return false;
        }

        /**
         * Finally return API End Point
         */

        return $fetch_option['rcn_data_feed_website'];
    }
    /**
     * Get Cache Time
     *
     * @return void
     */
    public function get_cache_time() {
        $fetch_option = get_option('rcn_settings', false);
        /**
         * Confrim Settings Init
         */
        if (!$fetch_option) {
            return false;
        }

        /**
         * Confrim API init & Feed API Not empty
         */
        if (!isset($fetch_option['rcn_data_cache']) || empty($fetch_option['rcn_data_cache'])) {
            return false;
        }

        /**
         * Finally return API End Point
         */

        return $fetch_option['rcn_data_cache'];
    }

    /**
     * Fetch Remote Data
     */

    public function fetch_remote_data($refresh = false) {
        $id = 'rcn_fetch_' . current_datetime()->format('Y_m_d');
        $transient_key = $id . '_showcase_data';
        $response_body = get_transient($transient_key);

        if (false == $response_body || true === $refresh) {
            $api_url = $this->API_END_POINT;
            if (empty($api_url)) {
                return 'api_end_point_missing.';
            }
            $response = wp_remote_request($api_url, []);
            /**
             * Access Body of JSON & Decode to Array
             */
            $response_body = wp_remote_retrieve_body($response);
            $cache_time = $this->get_cache_time() ? $this->get_cache_time() : 3;
            set_transient($transient_key, $response_body, apply_filters('recruit-now/rcn_fetch_data/cached-time', HOUR_IN_SECONDS * $cache_time));
        }

        $elements_data = json_decode($response_body, true);
        if (empty($elements_data)) {
            return false;
        }

        return $elements_data;
    }

    /**
     * Fetch Data & Make Ready for Output Handler
     */

    public function rcn_feed_output() {
        $data = $this->fetch_remote_data();
        return $data;
        wp_die();
    }

    /**
     * Refresh data on Admin Request
     */

    public function rcn_feed_refresh($refresh = false) {
        $data = $this->fetch_remote_data($refresh);
        return $data;
        wp_die();
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
}


/**
 * 
 * @return \RecruitNow
 */
function recruitnow_api_data_feed() {
    return RcnDataFeed::init();
}

/**
 * kick-off the data feed
 */
recruitnow_api_data_feed();

/**
 * Globally acceess RCN Remote Data Obj
 */

function rcn_feed_output() {
    $feed_obj  = new RcnDataFeed();
    return $feed_obj->rcn_feed_output();
}

/**
 * Insert Post to Database
 */


function rcn_add_custom_post() {
    $rcn_feed_data = rcn_feed_output();
    $prefix = 'recruit_now_';

    if ('api_end_point_missing' !== $rcn_feed_data && false !== $rcn_feed_data) {
        foreach ($rcn_feed_data as $element) {

            $post = array(
                'post_title'     => $element['Title'],
                'post_status'    => 'publish',
                'post_author'    => get_current_user_id(),
                'post_type'      => 'vacancies',
                'post_date'      => date('Y-m-d H:M:S', strtotime($element['PublicationDate'])),
                'post_modified ' => date('Y-m-d H:M:S', strtotime($element['LastEditedAt'])),
            );

            /**
             * Insert Post if not exists
             */

            $findPostByTitle = $element['Title'];
            $post_id = '';
            if (post_exists($findPostByTitle)) {
                //post exists!
                // echo 'exists' . $post_id;
                $post_id = post_exists($findPostByTitle);
            } else {
                //post does not exist
                // echo 'not exists';
                $post_id = wp_insert_post($post);
            }

            /**
             * General Informations
             */
            update_post_meta($post_id, $prefix . 'vacancies_id', isset($element['Id']) ? $element['Id'] : '');
            update_post_meta($post_id, $prefix . 'remote_id', isset($element['RemoteId']) ? $element['RemoteId'] : '');
            update_post_meta($post_id, $prefix . 'reference_number', isset($element['ReferenceNumber']) ? $element['ReferenceNumber'] : '');
            update_post_meta($post_id, $prefix . 'created_at', isset($element['CreatedAt']) ? $element['CreatedAt'] : '');
            update_post_meta($post_id, $prefix . 'expiration_date', isset($element['ExpirationDate']) ? $element['ExpirationDate'] : '');
            /**
             * Descriptions
             */
            update_post_meta($post_id, $prefix . 'summary', isset($element['Descriptions']['Summary']) ? $element['Descriptions']['Summary'] : '');
            update_post_meta($post_id, $prefix . 'function_description', isset($element['Descriptions']['FunctionDescription']) ? $element['Descriptions']['FunctionDescription'] : '');
            update_post_meta($post_id, $prefix . 'client_description', isset($element['Descriptions']['ClientDescription']) ? $element['Descriptions']['ClientDescription'] : '');
            update_post_meta($post_id, $prefix . 'requirements_description', isset($element['Descriptions']['RequirementsDescription']) ? $element['Descriptions']['RequirementsDescription'] : '');
            update_post_meta($post_id, $prefix . 'offer_description', isset($element['Descriptions']['OfferDescription']) ? $element['Descriptions']['OfferDescription'] : '');
            update_post_meta($post_id, $prefix . 'additional_description', isset($element['Descriptions']['AdditionalDescription']) ? $element['Descriptions']['AdditionalDescription'] : '');
            update_post_meta($post_id, $prefix . 'application_procedure_description', isset($element['Descriptions']['ApplicationProcedureDescription']) ? $element['Descriptions']['ApplicationProcedureDescription'] : '');
            /**
             * Facets
             */
            update_post_meta($post_id, $prefix . 'regions', isset($element['Facets']['Regions']) ? $element['Facets']['Regions'] : '');
            update_post_meta($post_id, $prefix . 'function_types', isset($element['Facets']['FunctionTypes']) ? $element['Facets']['FunctionTypes'] : '');
            update_post_meta($post_id, $prefix . 'contract_types', isset($element['Facets']['ContractTypes']) ? $element['Facets']['ContractTypes'] : '');
            update_post_meta($post_id, $prefix . 'experience_levels', isset($element['Facets']['ExperienceLevels']) ? $element['Facets']['ExperienceLevels'] : '');
            update_post_meta($post_id, $prefix . 'categories', isset($element['Facets']['Categories']) ? $element['Facets']['Categories'] : '');
            /**
             * need check because data not showing
             */
            update_post_meta($post_id, $prefix . 'hours_per_week', isset($element['Facets']['HoursPerWeek']['Name']) ? $element['Facets']['HoursPerWeek']['Name'] : '');
            /**
             * Application
             */
            update_post_meta($post_id, $prefix . 'max_allowed_applications', isset($element['Application']['MaxAllowedApplications']) ? $element['Application']['MaxAllowedApplications'] : '');
            update_post_meta($post_id, $prefix . 'remaining_applications', isset($element['Application']['RemainingApplications']) ? $element['Application']['RemainingApplications'] : '');
            update_post_meta($post_id, $prefix . 'curriculum_vitae_required', isset($element['Application']['CurriculumVitaeRequired']) ? $element['Application']['CurriculumVitaeRequired'] : '');
            /**
             * Employment
             */
            update_post_meta($post_id, $prefix . 'hours_perweek_min', isset($element['Employment']['HoursPerWeekMin']) ? $element['Employment']['HoursPerWeekMin'] : '');
            update_post_meta($post_id, $prefix . 'hours_per_week_max', isset($element['Employment']['HoursPerWeekMax']) ? $element['Employment']['HoursPerWeekMax'] : '');
            update_post_meta($post_id, $prefix . 'shift_service', isset($element['Facets']['ShiftServices']) ? $element['Facets']['ShiftServices'] : '');
            update_post_meta($post_id, $prefix . 'travel_distance', isset($element['Employment']['TravelDistance']) ? $element['Employment']['TravelDistance'] : '');
            /**
             * Work Location
             */
            update_post_meta($post_id, $prefix . 'street', isset($element['WorkLocation']['Street']) ? $element['WorkLocation']['Street'] : '');
            update_post_meta($post_id, $prefix . 'house_number', isset($element['WorkLocation']['Housenumber']) ? $element['WorkLocation']['Housenumber'] : '');
            update_post_meta($post_id, $prefix . 'house_nmber_suffix', isset($element['WorkLocation']['HousenumberSuffix']) ? $element['WorkLocation']['HousenumberSuffix'] : '');
            update_post_meta($post_id, $prefix . 'zip_code', isset($element['WorkLocation']['Zipcode']) ? $element['WorkLocation']['Zipcode'] : '');
            update_post_meta($post_id, $prefix . 'city', isset($element['WorkLocation']['City']) ? $element['WorkLocation']['City'] : '');
            update_post_meta($post_id, $prefix . 'country', isset($element['WorkLocation']['Country']) ? $element['WorkLocation']['Country'] : '');
            update_post_meta($post_id, $prefix . 'region', isset($element['WorkLocation']['Region']) ? $element['WorkLocation']['Region'] : '');
            update_post_meta($post_id, $prefix . 'latitude', isset($element['WorkLocation']['Latitude']) ? $element['WorkLocation']['Latitude'] : '');
            update_post_meta($post_id, $prefix . 'longitude', isset($element['WorkLocation']['Longitude']) ? $element['WorkLocation']['Longitude'] : '');
            /**
             * Salary
             */
            update_post_meta($post_id, $prefix . 'salary_min', isset($element['Salary']['SalaryMin']) ? $element['Salary']['SalaryMin'] : '');
            update_post_meta($post_id, $prefix . 'salary_max', isset($element['Salary']['SalaryMax']) ? $element['Salary']['SalaryMax'] : '');
            update_post_meta($post_id, $prefix . 'salary_description', isset($element['Salary']['Description']) ? $element['Salary']['Description'] : '');
            /**
             * Recruiter
             */
            update_post_meta($post_id, $prefix . 'recruiter_id', isset($element['Recruiter']['Id']) ? $element['Recruiter']['Id'] : '');
            update_post_meta($post_id, $prefix . 'recruiter_remote_id', isset($element['Recruiter']['RemoteId']) ? $element['Recruiter']['RemoteId'] : '');
            update_post_meta($post_id, $prefix . 'recruiter_first_name', isset($element['Recruiter']['FirstName']) ? $element['Recruiter']['FirstName'] : '');
            update_post_meta($post_id, $prefix . 'recruiter_middle_name', isset($element['Recruiter']['MiddleName']) ? $element['Recruiter']['MiddleName'] : '');
            update_post_meta($post_id, $prefix . 'recruiter_last_name', isset($element['Recruiter']['LastName']) ? $element['Recruiter']['LastName'] : '');
            update_post_meta($post_id, $prefix . 'recruiter_email_address', isset($element['Recruiter']['EmailAddress']) ? $element['Recruiter']['EmailAddress'] : '');
            update_post_meta($post_id, $prefix . 'recruiter_phone_number', isset($element['Recruiter']['PhoneNumber']) ? $element['Recruiter']['PhoneNumber'] : '');
            update_post_meta($post_id, $prefix . 'recruiter_mobile_phone_number', isset($element['Recruiter']['MobilePhoneNumber']) ? $element['Recruiter']['MobilePhoneNumber'] : '');
            /**
             * Office
             */
            update_post_meta($post_id, $prefix . 'office_id', isset($element['Office']['Id']) ? $element['Office']['Id'] : '');
            update_post_meta($post_id, $prefix . 'office_remote_id', isset($element['Office']['RemoteId']) ? $element['Office']['RemoteId'] : '');
            update_post_meta($post_id, $prefix . 'office_name', isset($element['Office']['Name']) ? $element['Office']['Name'] : '');
            update_post_meta($post_id, $prefix . 'office_summary', isset($element['Office']['Summary']) ? $element['Office']['Summary'] : '');
            update_post_meta($post_id, $prefix . 'office_description', isset($element['Office']['Description']) ? $element['Office']['Description'] : '');
            update_post_meta($post_id, $prefix . 'office_email_address', isset($element['Office']['EmailAddress']) ? $element['Office']['EmailAddress'] : '');
            update_post_meta($post_id, $prefix . 'office_phone_number', isset($element['Office']['PhoneNumber']) ? $element['Office']['PhoneNumber'] : '');
            update_post_meta($post_id, $prefix . 'office_mobile_phone_number', isset($element['Office']['MobilePhoneNumber']) ? $element['Office']['MobilePhoneNumber'] : '');
            /**
             * Office Address
             */
            update_post_meta($post_id, $prefix . 'office_address_street', isset($element['Office']['Address']['Street']) ? $element['Office']['Address']['Street'] : '');
            update_post_meta($post_id, $prefix . 'office_address_house_number', isset($element['Office']['Address']['Housenumber']) ? $element['Office']['Address']['Housenumber'] : '');
            update_post_meta($post_id, $prefix . 'office_address_house_number_suffix', isset($element['Office']['Address']['HousenumberSuffix']) ? $element['Office']['Address']['HousenumberSuffix'] : '');
            update_post_meta($post_id, $prefix . 'office_address_zip_code', isset($element['Office']['Address']['Zipcode']) ? $element['Office']['Address']['Zipcode'] : '');
            update_post_meta($post_id, $prefix . 'office_address_city', isset($element['Office']['Address']['City']) ? $element['Office']['Address']['City'] : '');
            update_post_meta($post_id, $prefix . 'office_address_country', isset($element['Office']['Address']['Country']) ? $element['Office']['Address']['Country'] : '');
            update_post_meta($post_id, $prefix . 'office_address_region', isset($element['Office']['Address']['Region']) ? $element['Office']['Address']['Region'] : '');
            update_post_meta($post_id, $prefix . 'office_address_latitude', isset($element['Office']['Address']['Latitude']) ? $element['Office']['Address']['Latitude'] : '');
            update_post_meta($post_id, $prefix . 'office_address_longitude', isset($element['Office']['Address']['Longitude']) ? $element['Office']['Address']['Longitude'] : '');
            /**
             * Employer
             */
            update_post_meta($post_id, $prefix . 'employer_id', isset($element['Employer']['Id']) ? $element['Employer']['Id'] : '');
            update_post_meta($post_id, $prefix . 'employer_remote_id', isset($element['Employer']['RemoteId']) ? $element['Employer']['RemoteId'] : '');
            update_post_meta($post_id, $prefix . 'employer_email_address', isset($element['Employer']['EmailAddress']) ? $element['Employer']['EmailAddress'] : '');
            update_post_meta($post_id, $prefix . 'employer_phone_number', isset($element['Employer']['PhoneNumber']) ? $element['Employer']['PhoneNumber'] : '');
            update_post_meta($post_id, $prefix . 'employer_mobile_phone_number', isset($element['Employer']['MobilePhoneNumber']) ? $element['Employer']['MobilePhoneNumber'] : '');
            /**
             * Employer Address
             */
            update_post_meta($post_id, $prefix . 'employer_address_street', isset($element['Employer']['Address']['Street']) ? $element['Employer']['Address']['Street'] : '');
            update_post_meta($post_id, $prefix . 'employer_address_house_number', isset($element['Employer']['Address']['Housenumber']) ? $element['Employer']['Address']['Housenumber'] : '');
            update_post_meta($post_id, $prefix . 'employer_address_house_number_suffix', isset($element['Employer']['Address']['HousenumberSuffix']) ?  $element['Employer']['Address']['HousenumberSuffix'] : '');
            update_post_meta($post_id, $prefix . 'employer_address_zip_code', isset($element['Employer']['Address']['Zipcode']) ? $element['Employer']['Address']['Zipcode'] : '');
            update_post_meta($post_id, $prefix . 'employer_address_city', isset($element['Employer']['Address']['City']) ? $element['Employer']['Address']['City'] : '');
            update_post_meta($post_id, $prefix . 'employer_address_country', isset($element['Address']['Country']) ? $element['Address']['Country'] : '');
            update_post_meta($post_id, $prefix . 'employer_address_region', isset($element['Address']['Region']) ? $element['Address']['Region'] : '');
            update_post_meta($post_id, $prefix . 'employer_address_latitude', isset($element['Address']['Latitude']) ? $element['Address']['Latitude'] : '');
            update_post_meta($post_id, $prefix . 'employer_address_longitude', isset($element['Address']['Longitude']) ? $element['Address']['Longitude'] : '');
        }
    }
}


/**
 * Acceess RCN Remote Data Refresh
 * Accessible only for Admin
 * Access By Ajax Call 
 */

function rcn_feed_refresh() {
    if (!is_admin()) {
        echo wp_json_encode('must_admin');
        wp_die();
    }
    $feed_obj  = new RcnDataFeed();
    if (empty($feed_obj->rcn_feed_refresh(true))) {
        echo wp_json_encode('error');
        wp_die();
    }

    rcn_add_custom_post();
    // add_action('init', 'rcn_add_custom_post', 99);

    echo wp_json_encode('success');
    wp_die();
}
