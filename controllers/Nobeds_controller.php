<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nobeds_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Load dependencies
        $this->load->model('Nobeds_settings_model');
        $this->load->library('Nobeds_client');

        // Optionally load helpers, language etc.
        // $this->lang->load('nobeds', 'english');
    }

    // /extensions/nobeds_settings  (through route)
    public function index()
    {
        $data['settings'] = $this->Nobeds_settings_model->get_settings();
        $data['page_title'] = 'NoBeds Channel Manager Settings';

        $this->load->view('nobeds_settings', $data);
    }

    // POST from the settings form
    public function save_settings()
    {
        $post = $this->input->post();

        $data = array(
            'api_base_url' => isset($post['api_base_url']) ? trim($post['api_base_url']) : '',
            'api_key'      => isset($post['api_key']) ? trim($post['api_key']) : '',
            'property_id'  => isset($post['property_id']) ? trim($post['property_id']) : '',
            'enabled'      => isset($post['enabled']) ? 1 : 0,
        );

        $this->Nobeds_settings_model->save_settings($data);

        // You can use flashdata + redirect
        $this->session->set_flashdata('success', 'NoBeds settings saved.');
        redirect('nobeds_settings');
    }

    // Manual pull (for testing)
    public function manual_sync()
    {
        try {
            $today = date('Y-m-d');
            $tomorrow = date('Y-m-d', strtotime('+1 day'));

            $response = $this->nobeds_client->get_reservations($today, $tomorrow);

            // TODO: Convert reservations into miniCal bookings (Step 7)
            // For now just dump result:
            echo "<pre>";
            print_r($response);
            echo "</pre>";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
