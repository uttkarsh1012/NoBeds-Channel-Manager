<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nobeds_client
{
    protected $ci;
    protected $api_base_url;
    protected $api_key;
    protected $property_id;

    public function __construct()
    {
        $this->ci =& get_instance();

        // Load settings model
        $this->ci->load->model('Nobeds_settings_model');
        $settings = $this->ci->Nobeds_settings_model->get_settings();

        $this->api_base_url = rtrim($settings['api_base_url'], '/');
        $this->api_key      = $settings['api_key'];
        $this->property_id  = $settings['property_id'];
    }

    /**
     * Generic HTTP request to NoBeds API
     *
     * Adjust headers/body according to NoBeds Swagger auth requirements.
     */
    public function request($method, $endpoint, $query = array(), $body = null)
    {
        if (empty($this->api_key)) {
            throw new Exception('NoBeds API key is not configured.');
        }

        $url = $this->api_base_url . '/' . ltrim($endpoint, '/');

        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }

        $ch = curl_init($url);

        $headers = array(
            'Content-Type: application/json',
            // TODO: adjust if NoBeds uses different auth:
            // Example if they use header-based API key:
            // 'X-API-Key: ' . $this->api_key,
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $method = strtoupper($method);

        if ($method === 'POST' || $method === 'PUT' || $method === 'PATCH') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            if (!is_null($body)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
            }
        } elseif ($method !== 'GET') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        }

        $responseBody = curl_exec($ch);
        $httpCode     = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($responseBody === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new Exception('cURL error: ' . $error);
        }

        curl_close($ch);

        $decoded = json_decode($responseBody, true);

        return array(
            'status_code' => $httpCode,
            'body'        => $decoded,
            'raw'         => $responseBody,
        );
    }

    /**
     * Example: get reservations from NoBeds
     * You must look in the Swagger UI which endpoint to use and how.
     */
    public function get_reservations($fromDate, $toDate)
    {
        // Example endpoint – REPLACE with real one from https://api.nobeds.com/swagger/index.html
        $endpoint = '/api/Reservations';

        $query = array(
            'propertyId' => $this->property_id,
            'from'       => $fromDate,
            'to'         => $toDate,
            // plus whatever filters Swagger shows
        );

        return $this->request('GET', $endpoint, $query);
    }
}
