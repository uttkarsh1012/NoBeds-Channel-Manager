<?php
// nobeds-channel-manager/config/config.php

$config = array(
    "name"        => "NoBeds Channel Manager",
    "description" => "Sync bookings between miniCal and OTAs (Booking.com, Expedia, etc.) via NoBeds API.",
    "is_default_active" => 0,              // Extension will be inactive until you enable it in UI
    "version"     => "0.1.0",
    "logo"        => "",                   // later you can add /extensions/nobeds-channel-manager/image/logo.png
    "view_link"   => "nobeds_settings",    // where the "view" icon goes
    "setting_link"=> "nobeds_settings",    // where the "settings" icon goes
    "categories"  => array("channel_manager"),
    "marketplace_product_link" => ""
);
