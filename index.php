<?php

/**
 * Plugin Name: Extendo Data
 * Description: Extends the REST API endpoint for the Site Health data.
 * Version: 1.0.0
 * Author: Tyler Seabury
 * Author URI: https://tylerseabury.com
 * License: GPL2+
 */

declare(strict_types=1);

// Exit if accessed directly.
if (!defined('ABSPATH')) {
  die();
}

if (!function_exists('get_core_updates')) {
  require_once ABSPATH . 'wp-admin/includes/update.php';
}
if (!function_exists('got_url_rewrite')) {
  require_once ABSPATH . 'wp-admin/includes/misc.php';
}
if (!class_exists('WP_Debug_Data')) {
  require_once ABSPATH . 'wp-admin/includes/class-wp-debug-data.php';
}
if (!class_exists('WP_Site_Health')) {
  require_once ABSPATH . 'wp-admin/includes/class-wp-site-health.php';
}


/**
 * Callback function for the custom REST API endpoint.
 * This function will be called when the endpoint is accessed.
 * It will return the Site Health data as JSON.
 */
function get_site_health_report()
{
  $health_check_site_status = WP_Site_Health::get_instance();

  WP_Debug_Data::check_for_updates();

  // Remove all filters registered to  the 'debug_information' hook
  remove_all_filters('debug_information');

  $info = WP_Debug_Data::debug_data();

  $sizes = WP_Debug_Data::get_sizes();

  $info['wp-paths-sizes']['fields']['wordpress_size'] = $sizes['wordpress_size'];
  $info['wp-paths-sizes']['fields']['uploads_size'] = $sizes['uploads_size'];
  $info['wp-paths-sizes']['fields']['themes_size'] = $sizes['themes_size'];
  $info['wp-paths-sizes']['fields']['plugins_size'] = $sizes['plugins_size'];
  $info['wp-paths-sizes']['fields']['database_size'] = $sizes['database_size'];
  $info['wp-paths-sizes']['fields']['total_size'] = $sizes['total_size'];

  // Return the Site Health data as JSON
  return rest_ensure_response($info);
}


/**
 * Register the custom REST API endpoint.
 * This is a GET endpoint, so it will be accessible at /wp-json/custom/v1/site-health
 * The callback function is get_site_health_report
 * @see https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/
 * @see https://developer.wordpress.org/rest-api/extending-the-rest-api/routes-and-endpoints/
 * 
 */
function custom_site_health_endpoint()
{
  register_rest_route('extendodata/v1', '/site-health', array(
    'methods' => 'GET',
    'callback' => 'get_site_health_report',
    //'permission_callback' => '__return_true',
    'permission_callback' => function () {
      return current_user_can('edit_posts');
    },
  ));
}

add_action(
  'rest_api_init',
  'custom_site_health_endpoint'
);
