<?php
/**
 * Initialize the plugin.
 *
 * @package Promote My Extensions
 */

require 'save-meta.php';

// Initialize the plugin.
function gs_pmp__admin_init() {
	// Create the plugin post type.
	include('plugin-post-type.php');
	
	if (get_option('gs_pmp_use_documentation') === 'yes') {
		include('plugin-post-type-documentation.php');
	}
	
	// Save Meta Boxes
	if (get_option('gs_pmp_use_details') === 'yes') {
		add_action( 'save_post', 'gs_pmp_save_post', 10, 2 );
	}
	
	require_once 'plugin-options-page.php';
	$cpOptionsPage = new Promote_My_Extensions_Options_Page();
	
	add_action('update_option_gs_pmp_index_slug', 'gs_pmp__on_update_slug', 10, 2);
}

function gs_pmp__on_update_slug($old, $new) {
	delete_option( 'rewrite_rules' );
	flush_rewrite_rules(true);
}

add_action( 'init', 'gs_pmp__admin_init');

register_activation_hook( __FILE__, 'gs_pmp__rewrite_flush' );

function gs_pmp__rewrite_flush() {
	gs_pmp__admin_init();
	flush_rewrite_rules();
}

function wpeplugin_pre_get_posts($query) {
	if (array_key_exists('post_type', $query->query_vars) && $query->query_vars['post_type'] == 'gs_pmp_extension' && is_archive() &&!is_admin() ) {
		$query->set('orderby', get_option('gs_pmp_display_order'));
		$query->set('order', get_option('gs_pmp_display_asc'));
	}
	
}

add_action( 'pre_get_posts', 'wpeplugin_pre_get_posts' );

