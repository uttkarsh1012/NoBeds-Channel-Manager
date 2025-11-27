<!DOCTYPE html>
<html>
<head>
    <title><?php echo $page_title; ?></title>
</head>
<body>

<h2>NoBeds Channel Manager Settings</h2>

<?php if ($this->session->flashdata('success')): ?>
    <div style="color: green;">
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>

<form method="post" action="<?php echo site_url('Nobeds_controller/save_settings'); ?>">

    <p>
        <label>API Base URL</label><br>
        <input type="text" name="api_base_url"
               value="<?php echo htmlspecialchars($settings['api_base_url']); ?>"
               style="width: 400px;">
        <small>Default: https://api.nobeds.com</small>
    </p>

    <p>
        <label>API Key / Token</label><br>
        <input type="text" name="api_key"
               value="<?php echo htmlspecialchars($settings['api_key']); ?>"
               style="width: 400px;">
    </p>

    <p>
        <label>Property ID (NoBeds)</label><br>
        <input type="text" name="property_id"
               value="<?php echo htmlspecialchars($settings['property_id']); ?>"
               style="width: 200px;">
    </p>

    <p>
        <label>
            <input type="checkbox" name="enabled"
                <?php echo !empty($settings['enabled']) ? 'checked' : ''; ?>>
            Enable NoBeds sync
        </label>
    </p>

    <p>
        <button type="submit">Save settings</button>
    </p>
</form>

<hr>

<h3>Manual Test: Pull Today’s Bookings</h3>
<p>
    <a href="<?php echo site_url('nobeds_manual_sync'); ?>" target="_blank">
        Click here to test pulling reservations from NoBeds
    </a>
</p>

</body>
</html>
