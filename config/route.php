<?php
// nobeds-channel-manager/config/route.php

// Settings page
$extension_route['nobeds_settings'] = 'Nobeds_controller/index';

// Manual sync (triggered by button)
$extension_route['nobeds_manual_sync'] = 'Nobeds_controller/manual_sync';

// Cron endpoint (for automatic sync)
$extension_route['nobeds_cron_pull_bookings'] = 'Nobeds_cron/pull_bookings';
