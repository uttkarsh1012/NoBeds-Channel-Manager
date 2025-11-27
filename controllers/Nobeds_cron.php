<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This controller is hit by a cron job:
 *   https://your-minical-domain.com/cron/nobeds_cron_pull_bookings
 *
 * You’ll add a server cron that hits that URL every X minutes.
 */
class Nobeds_cron extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Nobeds_settings_model');
        $this->load->library('Nobeds_client');
        // You will also need MiniCal booking helper / model here
    }

    public function pull_bookings()
    {
        $settings = $this->Nobeds_settings_model->get_settings();

        if (empty($settings['enabled'])) {
            log_message('info', 'NoBeds cron: integration disabled, skipping.');
            return;
        }

        // Example: last 24 hours
        $from = date('Y-m-d', strtotime('-1 day'));
        $to   = date('Y-m-d', strtotime('+1 day'));

        try {
            $response = $this->nobeds_client->get_reservations($from, $to);

            if ($response['status_code'] >= 200 && $response['status_code'] < 300) {
                $reservations = $response['body'];

                // TODO: Map each reservation to miniCal bookings.
                // Pseudo-code:
                /*
                foreach ($reservations as $res) {
                    $this->create_or_update_minical_booking($res);
                }
                */

                log_message('info', 'NoBeds cron: pulled ' . count($reservations) . ' reservations.');
            } else {
                log_message('error', 'NoBeds cron: HTTP ' . $response['status_code'] . ' - ' . $response['raw']);
            }

        } catch (Exception $e) {
            log_message('error', 'NoBeds cron: exception - ' . $e->getMessage());
        }
    }

    // You will implement mapping here later
    protected function create_or_update_minical_booking($nobeds_res)
    {
        // 1. Inspect $nobeds_res structure (via manual_sync)
        // 2. Use miniCal booking helper functions to create/update bookings.
        // See docs: Access miniCal data using helpers.
    }
}
