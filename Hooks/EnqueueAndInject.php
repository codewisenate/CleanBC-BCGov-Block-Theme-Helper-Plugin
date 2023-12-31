<?php

namespace Bcgov\Plugin\CleanBC\Hooks;

/**
 * Sets up Javascript variable handoff from WordPress to theme.
 *
 * @since 1.0.1
 *
 * @package Bcgov\Plugin\CleanBC
 */
class EnqueueAndInject
{

	/**
	 * Enqueue scripts and styles for public website.
	 *
	 * @since 1.0.1
	 *
	 * @return void
	 */
	public function bcgov_plugin_enqueue_scripts(): void {
		$plugin_dir = plugin_dir_path(__DIR__);
		$assets_dir = $plugin_dir . 'dist/assets/';

		// Load public CSS and JS files
		$public_css_files = glob($assets_dir . 'public*.css');
		$public_js_files = glob($assets_dir . 'public*.js');

		// Enqueue public CSS files
		foreach ($public_css_files as $file) {
			$file_url = plugins_url(str_replace($plugin_dir, '', $file), __DIR__);
			wp_enqueue_style('custom-public-' . basename($file, '.css'), $file_url);
		}

		// Enqueue public JS files
		foreach ($public_js_files as $file) {
			$file_url = plugins_url(str_replace($plugin_dir, '', $file), __DIR__);
			wp_enqueue_script('custom-public-' . basename($file, '.js'), $file_url, [], false, true);
		}
	}

	/**
	 * Enqueue scripts and styles for admin.
	 *
	 * @since 1.0.1
	 *
	 * @return void
	 */
	public function bcgov_plugin_enqueue_admin_scripts(): void {
		$plugin_dir = plugin_dir_path(__DIR__);
		$assets_dir = $plugin_dir . 'dist/assets/';

		$admin_css_files = glob($assets_dir . 'admin*.css');
		$admin_js_files = glob($assets_dir . 'admin*.js');

		// Load admin CSS and JS files
		foreach ($admin_css_files as $file) {
			$file_url = plugins_url(str_replace($plugin_dir, '', $file), __DIR__);
			wp_enqueue_style('custom-admin-' . basename($file, '.css'), $file_url);
		}

		foreach ($admin_js_files as $file) {
			$file_url = plugins_url(str_replace($plugin_dir, '', $file), __DIR__);
			wp_enqueue_script('custom-admin-' . basename($file, '.js'), $file_url, [], false, true);
		}
	}


	/**
	 * Load the Override theme.json and update the provided theme.json object.
	 * 
	 * Retrieves the contents of the 'theme.json' file contains configuration settings for the current theme.
	 * 
	 * @return object The updated theme.json object.
	 */
	public function filter_theme_json_theme_plugin($theme_json) {

		$plugin_theme_json_path = trailingslashit(plugin_dir_path(__FILE__)) . '../theme/theme.json';

		$plugin_theme_json = json_decode(file_get_contents($plugin_theme_json_path), true);

		return $theme_json->update_with($plugin_theme_json);
	}
}
