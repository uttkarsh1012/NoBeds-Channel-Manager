<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nobeds_settings_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_settings()
    {
        // get_option() is provided by miniCal
        $settings = array(
            'api_base_url'   => get_option('nobeds_api_base_url', 'https://api.nobeds.com'),
            'api_key'        => get_option('nobeds_api_key', ''),
            'property_id'    => get_option('nobeds_property_id', ''),
            'enabled'        => get_option('nobeds_enabled', false),
        );

        return $settings;
    }

    public function save_settings($data)
    {
        // Expect: api_base_url, api_key, property_id, enabled (0/1)
        update_option('nobeds_api_base_url', $data['api_base_url']);
        update_option('nobeds_api_key', $data['api_key']);
        update_option('nobeds_property_id', $data['property_id']);
        update_option('nobeds_enabled', !empty($data['enabled']) ? 1 : 0);

        return true;
    }
}
