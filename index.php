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


/**
 * Callback function for the custom REST API endpoint.
 * This function will be called when the endpoint is accessed.
 * It will return the Site Health data as JSON.
 */
function get_site_health_report()
{
  $site_health = wp_get_site_health_check();

  // Return the Site Health data as JSON
  return rest_ensure_response($site_health);
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
  register_rest_route('custom/v1', '/site-health', array(
    'methods' => 'GET',
    'callback' => 'get_site_health_report',
    'permission_callback' => function () {
      return current_user_can('edit_posts');
    },
  ));
}

add_action(
  'rest_api_init',
  'custom_site_health_endpoint'
);
