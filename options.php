<div class="wrap">
<h2>OP Google Analytics</h2>

<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>
<?php settings_fields('opgoogleanalytics'); ?>

<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('Web Property ID', 'opgoogleanalytics'); ?>:</th>
<td><input type="text" name="opga_web_property_id" value="<?php echo get_option('opga_web_property_id'); ?>" /></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Site Speed Sample Rate (in percent)', 'opgoogleanalytics'); ?>:</th>
<td><input type="text" name="opga_site_speed_sample_rate" value="<?php echo get_option('opga_site_speed_sample_rate'); ?>" /></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Bounce Timeout (in seconds, disabled when 0)', 'opgoogleanalytics'); ?>:</th>
<td><input type="text" name="opga_bounce_timeout" value="<?php echo get_option('opga_bounce_timeout'); ?>" /></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('User Track Times (comma seperated, in seconds)', 'opgoogleanalytics'); ?>:</th>
<td><input type="text" name="opga_user_track_times" value="<?php echo get_option('opga_user_track_times'); ?>" /></td>
</tr>

<tr valign="top">
<th scape="row"><?php _e('Code Position', 'opgoogleanalytics'); ?>:</th>
<td>
  <select name="opga_code_position">
    <option value="wp_head" <?php if (get_option('opga_code_position') == 'wp_head') echo "selected=selected" ?>>Head</option>
    <option value="wp_footer"  <?php if (get_option('opga_code_position') == 'wp_footer') echo "selected=selected" ?>>Footer</option>
  </select>
</td>
</tr>

<tr valign="top">
<th scape="row"><?php _e('Anonymize IP', 'opgoogleanalytics'); ?>:</th>
<td>
  <select name="opga_anonymize_ip">
    <option value="yes" <?php if (get_option('opga_anonymize_ip') == 'yes') echo "selected=selected" ?>><?php _e('Yes'); ?></option>
    <option value="no"  <?php if (get_option('opga_anonymize_ip') == 'no') echo "selected=selected" ?>><?php _e('No'); ?></option>
  </select>
</td>
</tr>

<tr valign="top">
<th scape="row"><?php _e('Asynchronous Tracking', 'opgoogleanalytics'); ?>:</th>
<td>
  <select name="opga_asynchronous_tracking">
    <option value="yes" <?php if (get_option('opga_asynchronous_tracking') == 'yes') echo "selected=selected" ?>><?php _e('Yes'); ?></option>
    <option value="no"  <?php if (get_option('opga_asynchronous_tracking') == 'no') echo "selected=selected" ?>><?php _e('No'); ?></option>
  </select>
</td>
</tr>

<tr valign="top">
<th scape="row"><?php _e('Track logged in User', 'opgoogleanalytics'); ?>:</th>
<td>
  <select name="opga_track_logged_in_user">
    <option value="yes" <?php if (get_option('opga_track_logged_in_user') == 'yes') echo "selected=selected" ?>><?php _e('Yes'); ?></option>
    <option value="no"  <?php if (get_option('opga_track_logged_in_user') == 'no') echo "selected=selected" ?>><?php _e('No'); ?></option>
  </select>
</td>
</tr>

<tr valign="top">
<th scape="row"><?php _e('Track clicked Links', 'opgoogleanalytics'); ?>:</th>
<td>
  <select name="opga_track_links">
    <option value="yes" <?php if (get_option('opga_track_links') == 'yes') echo "selected=selected" ?>><?php _e('Yes'); ?></option>
    <option value="no"  <?php if (get_option('opga_track_links') == 'no') echo "selected=selected" ?>><?php _e('No'); ?></option>
  </select>
</td>
</tr>

</table>

<input type="hidden" name="action" value="update" />

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

</form>
</div>