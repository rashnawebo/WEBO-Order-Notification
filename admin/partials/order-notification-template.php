
<div class="won-form-wrap">
<?php if ( filter_input( INPUT_GET, 'status' ) == 'success' ) : ?>
        <p style="color: green;">Setting saved successfully.</p>
    <?php elseif ( filter_input( INPUT_GET, 'status' ) == 'error' ) : ?>
        <p style="color: red;">Error saving data.</p>
    <?php endif; ?>
    <form method="POST" action="<?php echo esc_attr(admin_url('admin-post.php')) ?>"">
        <label for="fname">Number of Days:</label><br>
        <input type="number" id="num_of_days" name="num_of_days" value="" class="won-form-input" placeholder="Number of days"><br>

        <label for="cache_expiry">Cache Expiry Time:</label><br>
        <input type="number" id="cache_expiry" name="cache_expiry" value="" class="won-form-input" placeholder="Cache expiry time in minutes"><br><br>
        <input type="hidden" name="action" value="won_save_notification_setting">
        <input type="submit" value="Submit">
    </form>
</div>