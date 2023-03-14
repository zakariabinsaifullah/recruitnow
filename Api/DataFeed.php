<?php


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
 * Acceess RCN Remote Data Refresh
 * 
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

    echo wp_json_encode('success');
    wp_die();
}
