<?php
/*
Plugin Name: OP Google Analytics
Plugin URI: https://github.com/wp-quan-google-analytics
Description: Enables <a href="http://www.google.com/analytics/">Google Analytics</a> on all pages.
Version: 1.0.2
Author: Sebastian@Oppstett
Author URI: http://www.oppstett.com/
*/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// default values

// plugin version
$opga_plugin_current_version = '0.1'; 
// plugin update URL
$opga_plugin_remote_path = 'http://www.oppstett.net/wp-plugin-updates/opgoogleanalytics/update.php';

// Analytics ID
$default_opga_web_property_id = 'UA-0000000-0';
// sample rate, 0-100
$default_opga_site_speed_sample_rate = '100';
// anonymize IP yes/no
$default_opga_anonymize_ip = 'yes';
// custom bounce timeout, 0 = disabled
$default_opga_bounce_timeout = '0';
// user track times, comma seperated values in seconds
$default_opga_user_track_times = '0,10,20,30,60';
// asynchronous tracking yes/no
$default_opga_asynchronous_tracking = 'yes';
// track logged in user yes/no
$default_opga_track_logged_in_user = 'no';
// track links yes/no
$default_opga_track_links = 'yes';
// google analytics code position, wp_head or wp_footer
$default_opga_code_position = 'wp_head';

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// define some WordPress variables

// if (!defined('WP_CONTENT_URL')) { define('WP_CONTENT_URL', get_option('siteurl') . '/wp-content'); };
// if (!defined('WP_CONTENT_DIR')) { define('WP_CONTENT_DIR', ABSPATH . 'wp-content'); };
// if (!defined('WP_PLUGIN_URL')) { define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins'); };
// if (!defined('WP_PLUGIN_DIR')) { define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins'); };

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// localization

function localize_opgoogleanalytics() {
  load_plugin_textdomain( 'opgoogleanalytics' );
}

add_action( 'init', 'localize_opgoogleanalytics' );

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// sorts numbers in string with comma seperated numbers and filters duplicates and non-numerical values

function sorted_unique_comma_seperated_numbers($string) {
  $array = explode(",",$string);
  foreach ($array as $key => $value) {
    $value = trim($value);
    if (!is_numeric($value)) {
      unset($array[$key]);
    } else {
      $array[$key] = abs($value);
      if (strlen($array[$key]) == 0) {
        $array[$key] = "0";
      }
    }
  }
  $array = array_unique($array);
  asort($array);
  $string = implode(",",$array);
  return $string;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// setting plugin variables

function activate_opgoogleanalytics_settings($default_opga_web_property_id, $default_opga_site_speed_sample_rate, $default_opga_anonymize_ip, $default_opga_bounce_timeout, $default_opga_user_track_times, $default_opga_asynchronous_tracking, $default_opga_track_logged_in_user, $default_opga_track_links, $default_opga_code_position) {

  add_option('opga_web_property_id', $default_opga_web_property_id);
  $opga_web_property_id = trim(get_option('opga_web_property_id'));
  if (strlen($opga_web_property_id) == 0) {
    update_option('opga_web_property_id',$default_opga_web_property_id);
  };

  add_option('opga_site_speed_sample_rate', $default_opga_site_speed_sample_rate);
  $opga_site_speed_sample_rate = abs(trim(get_option('opga_site_speed_sample_rate')));
  if (strlen($opga_site_speed_sample_rate) == 0 || !is_numeric($opga_site_speed_sample_rate) || $opga_site_speed_sample_rate > 100) {
    update_option('opga_site_speed_sample_rate',$default_opga_site_speed_sample_rate);
  } else {
    update_option('opga_site_speed_sample_rate',$opga_site_speed_sample_rate);
  };

  add_option('opga_anonymize_ip', $default_opga_anonymize_ip);
  $opga_anonymize_ip = get_option('opga_anonymize_ip');
  if (strlen($opga_anonymize_ip) == 0) {
    update_option('opga_anonymize_ip',$default_opga_anonymize_ip);
  };

  add_option('opga_bounce_timeout', $default_opga_bounce_timeout);
  $opga_bounce_timeout = abs(trim(get_option('opga_bounce_timeout')));
  if (strlen($opga_bounce_timeout) == 0 || !is_numeric($opga_bounce_timeout)) {
    update_option('opga_bounce_timeout',$default_opga_bounce_timeout);
  } else {
    update_option('opga_bounce_timeout',$opga_bounce_timeout);
  
  };

  add_option('opga_user_track_times', $default_opga_user_track_times);
  $opga_user_track_times = get_option('opga_user_track_times');
  if (strlen($opga_user_track_times) > 0) {
    $opga_user_track_times = sorted_unique_comma_seperated_numbers($opga_user_track_times);
    if (strlen($opga_user_track_times) > 0) {
      update_option('opga_user_track_times',$opga_user_track_times);
    } else {
      update_option('opga_user_track_times',$default_opga_user_track_times);
    }
  };

  add_option('opga_asynchronous_tracking', $default_opga_asynchronous_tracking);
  $opga_asynchronous_tracking = get_option('opga_asynchronous_tracking');
  if (strlen($opga_asynchronous_tracking) == 0) {
    update_option('opga_asynchronous_tracking',$default_opga_asynchronous_tracking);
  };

  add_option('opga_track_logged_in_user', $default_opga_track_logged_in_user);
  $opga_track_logged_in_user = get_option('opga_track_logged_in_user');
  if (strlen($opga_track_logged_in_user) == 0) {
    update_option('opga_track_logged_in_user',$default_opga_track_logged_in_user);
  };

  add_option('opga_track_links', $default_opga_track_links);
  $opga_track_links = get_option('opga_track_links');
  if (strlen($opga_track_links) == 0) {
    update_option('opga_track_links',$default_opga_track_links);
  };

  add_option('opga_code_position', $default_opga_code_position);
  $opga_code_position = get_option('opga_code_position');
  if (strlen($opga_code_position) == 0) {
    update_option('opga_code_position',$default_opga_code_position);
  };
}

activate_opgoogleanalytics_settings($default_opga_web_property_id, $default_opga_site_speed_sample_rate, $default_opga_anonymize_ip, $default_opga_bounce_timeout, $default_opga_user_track_times, $default_opga_asynchronous_tracking, $default_opga_track_logged_in_user, $default_opga_track_links, $default_opga_code_position);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// delete plugin variables on plugin delete

function uninstall_opgoogleanalytics() {
  delete_option('opga_web_property_id');
  delete_option('opga_site_speed_sample_rate');
  delete_option('opga_anonymize_ip');
  delete_option('opga_bounce_timeout');
  delete_option('opga_user_track_times');
  delete_option('opga_asynchronous_tracking');
  delete_option('opga_track_logged_in_user');
  delete_option('opga_track_links');
  delete_option('opga_code_position');
}

register_uninstall_hook(__FILE__, 'uninstall_opgoogleanalytics');

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// register plugin settings and add options page

function options_page_opgoogleanalytics() {
  include(__DIR__ . '/options.php');
}

function admin_init_opgoogleanalytics() {
  register_setting('opgoogleanalytics', 'opga_web_property_id');
  register_setting('opgoogleanalytics', 'opga_site_speed_sample_rate');
  register_setting('opgoogleanalytics', 'opga_anonymize_ip');
  register_setting('opgoogleanalytics', 'opga_bounce_timeout');
  register_setting('opgoogleanalytics', 'opga_user_track_times');
  register_setting('opgoogleanalytics', 'opga_asynchronous_tracking');
  register_setting('opgoogleanalytics', 'opga_track_logged_in_user');
  register_setting('opgoogleanalytics', 'opga_track_links');
  register_setting('opgoogleanalytics', 'opga_code_position');
}

function admin_menu_opgoogleanalytics() {
  add_options_page('OP Google Analytics', 'OP Google Analytics', 'manage_options', 'opgoogleanalytics', 'options_page_opgoogleanalytics');
}

if (is_admin()) {
  add_action('admin_init', 'admin_init_opgoogleanalytics');
  add_action('admin_menu', 'admin_menu_opgoogleanalytics');
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// asynchronous Google Analytics

function asynchronous_opgoogleanalytics($opga_web_property_id,$opga_site_speed_sample_rate,$opga_bounce_timeout,$opga_user_track_times,$opga_anonymize_ip) {
// add google analytics js code to page
?>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo $opga_web_property_id ?>']);
  _gaq.push(['_setSiteSpeedSampleRate', <?php echo $opga_site_speed_sample_rate ?>]);
<?php

// add anonymize IP option
if ($opga_anonymize_ip) {
?>
  _gaq.push(['_gat._anonymizeIp']);
<?php
}

// add bounce timeout
if ($opga_bounce_timeout > 0) {
?>
  setTimeout("_gaq.push(['_trackEvent', 'bounce_timeout', '" + location.href + "', '<?php echo $opga_bounce_timeout ?>_seconds'])", <?php echo $opga_bounce_timeout*1000 ?>);
<?php
}

// add user time track events
if (strlen($opga_user_track_times) > 0) {
  $track_times = explode(",", $opga_user_track_times);
  foreach ($track_times as $track_time) {
?>
  setTimeout("_gaq.push(['_trackEvent', 'time_track', '" + location.href + "', '<?php echo $track_time ?>_seconds', 0, true])", <?php echo $track_time*1000 ?>);
<?php
  }
}

// add rest of asynchronous analytics js code
?>
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<?php
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// synchronous Google Analytics

function synchronous_opgoogleanalytics($opga_web_property_id,$opga_site_speed_sample_rate,$opga_bounce_timeout,$opga_user_track_times,$opga_anonymize_ip) {
// add google analytics js code to page
?>
<script type="text/javascript">
  var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
  document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
  try {
    var pageTracker = _gat._getTracker("<?php echo $opga_web_property_id ?>");
    pageTracker._setSiteSpeedSampleRate(<?php echo $opga_site_speed_sample_rate ?>);
<?php

// add anonymize IP option
if ($opga_anonymize_ip) {
?>
    _gat._anonymizeIp();
<?php
}

// add bounce timeout
if ($opga_bounce_timeout > 0) {
?>
    setTimeout("pageTracker._trackEvent('bounce_timeout', '" + location.href + "', '<?php echo $opga_bounce_timeout ?>_seconds')", <?php echo $opga_bounce_timeout*1000 ?>);
<?php
}

// add user time track events
if (strlen($opga_user_track_times) > 0) {
  $track_times = explode(",", $opga_user_track_times);
  foreach ($track_times as $track_time) {
?>
    setTimeout("pageTracker._trackEvent('time_track', '" + location.href + "', '<?php echo $track_time ?>_seconds', 0, true)", <?php echo $track_time*1000 ?>);
<?php
  }
}

// add rest of synchronous analytics js code
?>
    pageTracker._trackPageview();
  } catch(err) {}
</script>
<?php
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// link tracking

function add_track_event($opga_asynchronous_tracking) {
// adds link tracking function
?>
<script type="text/javascript">
  function link_track(e) {
    var e = window.e || e;
    if (e.target.tagName !== 'A') {
      return;
    }
<?php

  if ($opga_asynchronous_tracking) {

// add asynchronous tracking code
?>
    if (e.target.hostname == location.hostname) {
      _gaq.push(['_trackEvent', 'internal', location.href, e.target.href]);
    } else {
      _gaq.push(['_trackEvent', 'outbound', location.href, e.target.href]);
    }
  }

<?php

// add synchronous tracking code
  } else {
?>
    if (e.target.hostname == location.hostname) {
      pageTracker._trackEvent('internal', location.href, e.target.href);
    } else {
      pageTracker._trackEvent('outbound', location.href, e.target.href);
    }
  }

<?php
  }

// attach tracking function to browser click events
?>
  if (document.addEventListener) {
    document.addEventListener('click', link_track, false);
  } else {
    document.attachEvent('onclick', link_track);
  }
</script>
<?php
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// google analytics main function

function opgoogleanalytics() {
  $opga_web_property_id = get_option('opga_web_property_id');
  $opga_site_speed_sample_rate = get_option('opga_site_speed_sample_rate');
  $opga_bounce_timeout = get_option('opga_bounce_timeout');
  $opga_user_track_times = get_option('opga_user_track_times');
  $opga_asynchronous_tracking = (get_option('opga_asynchronous_tracking') == 'yes');
  $opga_track_logged_in_user = (get_option('opga_track_logged_in_user') == 'yes');
  $opga_anonymize_ip = (get_option('opga_anonymize_ip') == 'yes');
  $opga_track_links = (get_option('opga_track_links') == 'yes');

  if (!is_user_logged_in() || $opga_track_logged_in_user) { 
    if ($opga_asynchronous_tracking) {
      asynchronous_opgoogleanalytics($opga_web_property_id,$opga_site_speed_sample_rate,$opga_bounce_timeout,$opga_user_track_times,$opga_anonymize_ip);
    } else {
      synchronous_opgoogleanalytics($opga_web_property_id,$opga_site_speed_sample_rate,$opga_bounce_timeout,$opga_user_track_times,$opga_anonymize_ip);
    }
    
    if ($opga_track_links) {
      add_track_event($opga_asynchronous_tracking);
    }
  }
}

if (!is_admin()) {
  add_action(get_option('opga_code_position'), 'opgoogleanalytics');
}

?>