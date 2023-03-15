<?php


/**
 * Data Feed
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
        // echo '<pre>';
        // print_r($fetch_data);
        // echo '</pre>';

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

// kick-off the data feed
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
            // print_r($element);

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

            update_post_meta($post_id, $prefix . 'vacancies_id', $element['Id']);
            update_post_meta($post_id, $prefix . 'remote_id', $element['RemoteId']);
            update_post_meta($post_id, $prefix . 'reference_number', $element['ReferenceNumber']);
            update_post_meta($post_id, $prefix . 'created_at', $element['CreatedAt']);
            update_post_meta($post_id, $prefix . 'expiration_date', $element['ExpirationDate']);
            update_post_meta($post_id, $prefix . 'summary', $element['Descriptions']['Summary']);
            update_post_meta($post_id, $prefix . 'function_description', $element['Descriptions']['FunctionDescription']);
            update_post_meta($post_id, $prefix . 'client_description', $element['Descriptions']['ClientDescription']);
            update_post_meta($post_id, $prefix . 'requirements_description', $element['Descriptions']['RequirementsDescription']);
            update_post_meta($post_id, $prefix . 'offer_description', $element['Descriptions']['OfferDescription']);
            update_post_meta($post_id, $prefix . 'additional_description', $element['Descriptions']['AdditionalDescription']);
            update_post_meta($post_id, $prefix . 'application_procedure_description', $element['Descriptions']['ApplicationProcedureDescription']);
            update_post_meta($post_id, $prefix . 'regions', $element['Facets']['Regions']['Name']);
            update_post_meta($post_id, $prefix . 'function_types', $element['Facets']['FunctionTypes']['Name']);
            update_post_meta($post_id, $prefix . 'contract_types', $element['Facets']['ContractTypes']['Name']);
            update_post_meta($post_id, $prefix . 'experience_levels', $element['Facets']['ExperienceLevels']['Name']);
            update_post_meta($post_id, $prefix . 'categories', $element['Facets']['Categories']['Name']);
            update_post_meta($post_id, $prefix . 'hours_per_week', $element['Facets']['HoursPerWeek']['Name']);
            update_post_meta($post_id, $prefix . 'max_allowed_applications', $element['Application']['MaxAllowedApplications']);
            update_post_meta($post_id, $prefix . 'remaining_applications', $element['Application']['RemainingApplications']);
            update_post_meta($post_id, $prefix . 'curriculum_vitae_required', $element['Application']['CurriculumVitaeRequired']);
            update_post_meta($post_id, $prefix . 'hours_perweek_min', $element['Employment']['HoursPerWeekMin']);
            update_post_meta($post_id, $prefix . 'hours_per_week_max', $element['Employment']['HoursPerWeekMax']);
            update_post_meta($post_id, $prefix . 'shift_service', $element['Facets']['ShiftServices']);
            update_post_meta($post_id, $prefix . 'travel_distance', $element['Employment']['TravelDistance']);
            update_post_meta($post_id, $prefix . 'street', $element['WorkLocation']['Street']);
            update_post_meta($post_id, $prefix . 'house_number', $element['WorkLocation']['Housenumber']);
            update_post_meta($post_id, $prefix . 'house_nmber_suffix', $element['WorkLocation']['HousenumberSuffix']);
            update_post_meta($post_id, $prefix . 'zip_code', $element['WorkLocation']['Zipcode']);
            update_post_meta($post_id, $prefix . 'city', $element['WorkLocation']['City']);
            update_post_meta($post_id, $prefix . 'country', $element['WorkLocation']['Country']);
            update_post_meta($post_id, $prefix . 'region', $element['WorkLocation']['Region']);
            update_post_meta($post_id, $prefix . 'latitude', $element['WorkLocation']['Latitude']);
            update_post_meta($post_id, $prefix . 'longitude', $element['WorkLocation']['Longitude']);
            update_post_meta($post_id, $prefix . 'salary_min', $element['Salary']['SalaryMin']);
            update_post_meta($post_id, $prefix . 'salary_max', $element['Salary']['SalaryMax']);
            update_post_meta($post_id, $prefix . 'salary_description', $element['Salary']['Description']);
            update_post_meta($post_id, $prefix . 'recruiter_id', $element['Recruiter']['Id']);
            update_post_meta($post_id, $prefix . 'recruiter_remote_id', $element['Recruiter']['RemoteId']);
            update_post_meta($post_id, $prefix . 'recruiter_first_name', $element['Recruiter']['FirstName']);
            update_post_meta($post_id, $prefix . 'recruiter_middle_name', $element['Recruiter']['MiddleName']);
            update_post_meta($post_id, $prefix . 'recruiter_last_name', $element['Recruiter']['LastName']);
            update_post_meta($post_id, $prefix . 'recruiter_email_address', $element['Recruiter']['EmailAddress']);
            update_post_meta($post_id, $prefix . 'recruiter_phone_number', $element['Recruiter']['PhoneNumber']);
            update_post_meta($post_id, $prefix . 'recruiter_mobile_phone_number', $element['Recruiter']['MobilePhoneNumber']);
            update_post_meta($post_id, $prefix . 'office_id', $element['Office']['Id']);
            update_post_meta($post_id, $prefix . 'office_remote_id', $element['Office']['RemoteId']);
            update_post_meta($post_id, $prefix . 'office_name', $element['Office']['Name']);
            update_post_meta($post_id, $prefix . 'office_summary', $element['Office']['Summary']);
            update_post_meta($post_id, $prefix . 'office_description', $element['Office']['Description']);
            update_post_meta($post_id, $prefix . 'office_email_address', $element['Office']['EmailAddress']);
            update_post_meta($post_id, $prefix . 'office_phone_number', $element['Office']['PhoneNumber']);
            update_post_meta($post_id, $prefix . 'office_mobile_phone_number', $element['Office']['MobilePhoneNumber']);
            update_post_meta($post_id, $prefix . 'office_address_street', $element['Office']['Address']['Street']);
            update_post_meta($post_id, $prefix . 'office_address_house_number', $element['Office']['Address']['Housenumber']);
            update_post_meta($post_id, $prefix . 'office_address_house_number_suffix', $element['Office']['Address']['HousenumberSuffix']);
            update_post_meta($post_id, $prefix . 'office_address_zip_code', $element['Office']['Address']['Zipcode']);
            update_post_meta($post_id, $prefix . 'office_address_city', $element['Office']['Address']['City']);
            update_post_meta($post_id, $prefix . 'office_address_country', $element['Office']['Address']['Country']);
            update_post_meta($post_id, $prefix . 'office_address_region', $element['Office']['Address']['Region']);
            update_post_meta($post_id, $prefix . 'office_address_latitude', $element['Office']['Address']['Latitude']);
            update_post_meta($post_id, $prefix . 'office_address_longitude', $element['Office']['Address']['Longitude']);
            update_post_meta($post_id, $prefix . 'employer_id', $element['Employer']['Id']);
            update_post_meta($post_id, $prefix . 'employer_remote_id', $element['Employer']['RemoteId']);
            update_post_meta($post_id, $prefix . 'employer_email_address', $element['Employer']['EmailAddress']);
            update_post_meta($post_id, $prefix . 'employer_phone_number', $element['Employer']['PhoneNumber']);
            update_post_meta($post_id, $prefix . 'employer_mobile_phone_number', $element['Employer']['MobilePhoneNumber']);
            update_post_meta($post_id, $prefix . 'employer_address_street', $element['Employer']['Address']['Street']);
            update_post_meta($post_id, $prefix . 'employer_address_house_number', $element['Employer']['Address']['Housenumber']);
            update_post_meta($post_id, $prefix . 'employer_address_house_number_suffix', $element['Employer']['Address']['HousenumberSuffix']);
            update_post_meta($post_id, $prefix . 'employer_address_zip_code', $element['Employer']['Address']['Zipcode']);
            update_post_meta($post_id, $prefix . 'employer_address_city', $element['Employer']['Address']['City']);
            update_post_meta($post_id, $prefix . 'employer_address_country', $element['Address']['Country']);
            update_post_meta($post_id, $prefix . 'employer_address_region', $element['Address']['Region']);
            update_post_meta($post_id, $prefix . 'employer_address_latitude', $element['Address']['Latitude']);
            update_post_meta($post_id, $prefix . 'employer_address_longitude', $element['Address']['Longitude']);
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



/**
 * Below Backup Data for Testing
 */

// $rcn_feed_data = rcn_feed_output();

// if ('api_end_point_missing' !== $rcn_feed_data && false !== $rcn_feed_data) {
// 	// var_dump($rcn_feed_data);
// 	foreach ($rcn_feed_data as $element) {
// 		// print_r($element);
// 		// format publication date to Y-m-d
// 		echo date('Y-m-d', strtotime($element['PublicationDate']));
// 		// print_r($element['PublicationDate']);
// 		// print_r($element['Id']);
// 		// print_r($element['Title']);
// 	}
// }
