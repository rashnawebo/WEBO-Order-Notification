<?php
    $notification_setting = get_option('notification_setting');
    $notification = $notification_setting ? json_decode($notification_setting) : null;

    $num_of_days = is_null($notification) ? null : $notification->num_of_days;
    $cookie_expiry = is_null($notification) ? null : $notification->cookie_expiry ;
?>

<div class="won-form-wrap">
<?php if ( filter_input( INPUT_GET, 'status' ) == 'success' ) : ?>
        <p style="color: green;">Setting saved successfully.</p>
    <?php elseif ( filter_input( INPUT_GET, 'status' ) == 'error' ) : ?>
        <p style="color: red;">Error saving data.</p>
    <?php elseif ( filter_input( INPUT_GET, 'status' ) == 'validation_error' ) : ?>
        <p style="color: red;">Please enter number only.</p>
    <?php endif; ?>

 <h2>Order Notification Settings</h2>

    <form method="POST" action="<?php echo esc_attr(admin_url('admin-post.php')) ?>">
    	<div class="won-form-group">
        	<label for="fname">Number of Days:</label><br>
        	<input type="number" id="num_of_days" name="num_of_days" required="required" value="<?php echo $num_of_days ?>" class="won-form-input" placeholder="Number of days"><br>
        </div>

        <div class="won-form-group">
        	<label for="cookie_expiry">Cookie Expiry Time:</label><br>
        	<input type="number" id="cookie_expiry" name="cookie_expiry" value="<?php echo is_null($cookie_expiry) ?  '5' : $cookie_expiry; ?>" class="won-form-input" placeholder="Cookie expiry time in minutes"><br><br>
        </div>

        <input type="hidden" name="action" value="won_save_notification_setting">
        <input type="submit" value="Submit" class="button button-primary">
    </form>
</div>