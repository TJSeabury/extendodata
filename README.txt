=== Extendo Data ===
Contributors: Tyler Seabury
Tags: rest api, site health, endpoint 
Requires at least: 5.0 
Tested up to: 5.8 
Stable tag: 1.0.0 
License: GPLv2 or later 
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==

This plugin adds a REST API endpoint that returns the Site Health data as JSON. 
The endpoint is accessible at /wp-json/custom/v1/site-health.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/extendodata` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.

== Usage ==

To access the custom REST API endpoint, make a GET request to the URL /wp-json/custom/v1/site-health. The endpoint requires authentication, so you must be logged in as a user with the `edit_posts` capability or higher to access it.

The endpoint returns the Site Health data as a JSON object with the following properties:

- `status`: A string indicating the overall status of the site health check.
- `tests`: An object containing the results of each individual test that was run.

== Frequently Asked Questions ==

Q: What version of WordPress is this plugin compatible with? A: This plugin requires WordPress 5.0 or higher.

Q: Does this plugin work with multisite installations? A: Yes, this plugin should work with multisite installations.

== Changelog ==

= 1.0.0 =

- Initial release.

== Upgrade Notice ==

= 1.0.0 = Initial release.
