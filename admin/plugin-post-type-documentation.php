<?php
/**
 * Register the Post Documentation Type.
 *
 * @package Promote My Extensions
 */

function wpe_documentation_meta_box($post) {
	add_meta_box(
		'wpe-documentation-details',
		__('Documentation Details', 'gs-promote-my-extensions'),
		'wpe_documentation_details_box',
		'wpe_documentation',
		'side',
		'high'
	);
}
	
function wpe_documentation_details_box($post, $args) {
	$meta = get_post_meta( $post->ID, '_plugin_details', true );
	
	$defaults = array(
		'downloads' => '',
		'documentation' => '',
		'faq' => '',
		'support' => '',
		'reviews' => '',
		'donate' => ''
	);

	$details = wp_parse_args($meta, $defaults);

	include(plugin_dir_path(dirname(__FILE__)) . 'includes/plugin-details-admin.php');
}

/**
 * Labels for the Plugin Documentation Post Type.
 */
$labels = array(
	'name' => __('Plugin Documentation', 'gs-promote-my-extensions'),
	'singular_name' => __('Plugin Documentation', 'gs-promote-my-extensions'),
	'add_new' => __('New Documentation', 'gs-promote-my-extensions'),
	'add_new_item' => __('New Documentation', 'gs-promote-my-extensions'),
	'edit_item' => __('Edit Documentation', 'gs-promote-my-extensions'),
	'new_item' => __('New Documentation', 'gs-promote-my-extensions'),
	'view_item' => __('View Documentation', 'gs-promote-my-extensions'),
	'view_items' => __('View Documentation', 'gs-promote-my-extensions'),
	'search_items' => __('Search Documentation', 'gs-promote-my-extensions'),
	'not_found' => __('No Documentation Found', 'gs-promote-my-extensions'),
	'not_found_in_trash' => __('No Documentation Found in Trash', 'gs-promote-my-extensions'),
	'parent_item_colon' => __('Documentation', 'gs-promote-my-extensions'),
	'all_items' => __('Documentation', 'gs-promote-my-extensions'),
	'archives' => __('Documentation Archives', 'gs-promote-my-extensions'),
	'attributes' => __('Documentation Attributes', 'gs-promote-my-extensions'),
	'insert_into_item' => __('Insert into Documentation', 'gs-promote-my-extensions'),
	'featured_image' => __('Cover Photo', 'gs-promote-my-extensions'),
	'set_featured_image' => __('Set Cover Photo', 'gs-promote-my-extensions'),
	'remove_featured_image' => __('Remove Cover Photo', 'gs-promote-my-extensions'),
	'use_featured_image' => __('Use Cover Photo', 'gs-promote-my-extensions'),
	'item_scheduled' => __('Documentation Scheduled', 'gs-promote-my-extensions'),
	'item_updated' => __('Documentation Updated', 'gs-promote-my-extensions')
);

/**
 * Arguments for the Documentation Post Type
 */
$args = array(
	'labels' => $labels,
	'public' => true,
	'hierarchical' => true,
	'has_archive' => true,
	'capability_type' => 'page',
	'show_in_menu' => 'edit.php?post_type=gs_pmp_extension',
	'supports' => array('title', 'editor', 'author', 'page-attributes'),
	//'register_meta_box_cb' => 'wpe_documentation_meta_box',
	'rewrite' => array('slug'=>'documentation'),
	'menu_icon' => 'dashicons-book'
);
if (get_option('gs_pmp_use_excerpt') === 'yes') array_push($args['supports'], 'excerpt');
if (get_option('gs_pmp_use_thumbnails') === 'yes') array_push($args['supports'], 'thumbnail');
if (get_option('gs_pmp_use_custom_fields') === 'yes') array_push($args['supports'], 'custom-fields');
if (get_option('gs_pmp_use_comments') === 'yes') array_push($args['supports'], 'comments');
if (get_option('gs_pmp_use_trackbacks') === 'yes') array_push($args['supports'], 'trackbacks');
if (get_option('gs_pmp_use_revisions') === 'yes') array_push($args['supports'], 'revisions');

register_post_type('gs_pmp_documentation', $args);

add_action('admin_menu', 'wpeplugin_add_documentation_submenus');
function wpeplugin_add_documentation_submenus() {
	add_submenu_page(
		'edit.php?post_type=gs_pmp_extension', 
		__('New Documentation', 'gs-promote-my-extensions'),
		__('New Documentation', 'gs-promote-my-extensions'),
		'manage_options', 
		'post-new.php?post_type=gs_pmp_documentation'
	);
	
	if (get_option('gs_pmp_use_taxonomies') === 'yes') {
		add_submenu_page(
			'edit.php?post_type=gs_pmp_extension',
			__('Documentation Categories', 'gs-promote-my-extensions'),
			__('Documentation Categories', 'gs-promote-my-extensions'),
			'manage_options',
			'edit-tags.php?taxonomy=gs_pmp_documentation_cat&post_type=gs_pmp_documentation'
		);
	}
};

if (get_option('gs_pmp_use_taxonomies') === 'yes') {
	// Register the Category Taxonomy
	$catLabels = array(
		'name' => __('Documentation Categories', 'gs-promote-my-extensions'),
		'singular_name' => __('Documentation Category', 'gs-promote-my-extensions'),
		
	);
	
	$catArgs = array(
		'labels' => $catLabels,
		'public' => true,
		'hierarchical' => true,
		'show_admin_column' => true,
		'rewrite' => array('slug' => 'documentationcat')
	);
	register_taxonomy('gs_pmp_documentation_cat', 'gs_pmp_documentation', $catArgs);
}

// Set up filters
//add_filter( 'the_content', 'wpeplugin_content_filter', 1 );

// Display details ONLY on plugin pages that are not children of a plugin.
function wpeplugin_documentation_content_filter( $content ) {
	$details = '';

	if (get_post_type() === 'gs_pmp_extension' && is_single()  ) {
		$meta = get_post_meta( get_the_id(), '_plugin_details', true );
		ob_start();
		include(plugin_dir_path(dirname(__FILE__)) . 'includes/plugin-details-display.php');
		$details = ob_get_contents();
		ob_end_clean();
	}

	return $content . $details;
}
