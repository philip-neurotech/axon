<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Put your custom code here.
function disable_json_api () {

  // Filters for WP-API version 1.x
  add_filter('json_enabled', '__return_false');
  add_filter('json_jsonp_enabled', '__return_false');

  // Filters for WP-API version 2.x
  add_filter('rest_enabled', '__return_false');
  add_filter('rest_jsonp_enabled', '__return_false');

}
add_action( 'init', 'disable_json_api' );
remove_action( 'init', 'rest_api_init' );  // turns off everything
remove_action( 'parse_request', 'rest_api_loaded' ); // silently turns off output of user info"