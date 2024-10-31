<?php
/**
 * Plugin Name
 *
 * @package           Promote_My_Extensions
 * @author            Shane Lambert
 * @copyright         2022 GrandSlambert
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Promote My Extensions
 * Plugin URI:        https://grandslambert.com/plugins/promote-my-extensions
 * Description:       This plugin creates a custom post type to allow you to provide information about the plugins you have developed.
 * Version:           0.4.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            GrandSlambert
 * Author URI:        https://grandslambert.com
 * Text Domain:       gs-promote-my-extensions
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Load the initializatin Scripts.
require_once 'admin/init.php';

// Add admin stylesheets.
function wpeplugin_admin_styles() {
	wp_register_style( 
		'wpe-promote-my-plugin-admin', 
		plugin_dir_url(__FILE__) . 'css/wp-admin.css',
		false,
		filemtime(plugin_dir_path(__FILE__) . 'css/wp-admin.css')
	);
	
	wp_enqueue_style( 'wpe-promote-my-plugin-admin' );
	
	wp_enqueue_script(
				'wpe-qm-admin.js',
		plugins_url('js/admin.js', __FILE__),
		array(),
		filemtime(plugin_dir_path(__FILE__)),
	);
}
	add_action('admin_enqueue_scripts', 'wpeplugin_admin_styles');
	
function Promote_My_Extensions_activation() {
	global $wpdb;
	
	/* Update from version 0.2 to 0.3+. */
	if ( !post_type_exists('gs_pmp_extension')) {
		/* Update the extension post type */
		$updated = $wpdb->update($wpdb->prefix . 'posts',
			array('post_type' => 'gs_pmp_extension'),
			array('post_type' => 'wpe_plugin')
		);
		
		/* Update the documentation post type. */
		$updated = $wpdb->update($wpdb->prefix . 'posts', 
			array('post_type' => 'gs_pmp_documentation'), 
			array('post_type' => 'wpe_plugindoc')
		);
		
		/* Also update the category taxonomy. */
		$updated = $wpdb->update($wpdb->prefix . 'term_taxonomy', 
			array('taxonomy' => 'gs_pmp_category'), 
			array('taxonomy' => 'wpe_plugin_cat')
		);
	}
	
	// Check if any default options are missing
	$options = array(
		'gs_pmp_plural_label' => __('My Extensions', 'gs-promote-my-extensions'),
		'gs_pmp_singular_label' => __('My Extension', 'gs-promote-my-extensions'),
		'gs_pmp_index_slug' => 'extensions',
		'gs_pmp_use_excerpt' => 'yes',
		'gs_pmp_use_thumbnails' => 'yes',
		'gs_pmp_use_custom_fields' => 'yes',
		'gs_pmp_use_comments' => 'yes',
		'gs_pmp_use_trackbacks' => 'yes',
		'gs_pmp_use_revisions' => 'yes',
		'gs_pmp_use_taxonomies' => 'yes',
		'gs_pmp_use_documentation' => 'yes',
		'gs_pmp_use_details' => 'yes',
		'gs_pmp_use_download' => 'yes',
		'gs_pmp_use_faq' => 'yes',
		'gs_pmp_use_support' => 'yes',
		'gs_pmp_use_reviews' => 'yes',
		'gs_pmp_use_donate' => 'yes',
		'gs_pmp_display_order' => 'post_title'
	);
	
	foreach ($options as $key => $value) {
		if (!get_option($key)) {
			add_option($key, esc_attr($value));
		}
	}
	
	flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'Promote_My_Extensions_activation');

function wpeplugin_plugin_action_links($links, $file)
{
	static $this_plugin;
	
	if (!$this_plugin) {
		$this_plugin = plugin_basename(__FILE__);
	}
		
	if ($file == $this_plugin) {
		$settings_link = '<a href="' . admin_url('edit.php?post_type=gs_pmp_extension&page=promote_my_extensions') . '">' . __('Settings', 'gs-promote-my-extensions') . '</a>';
		array_unshift($links, $settings_link);
	}
	
	return $links;
}
add_filter('plugin_action_links', 'wpeplugin_plugin_action_links', 10, 2);
