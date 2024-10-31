<?php
/**
 * Register the Post Type.
 *
 * @package Promote My Extensions
 */

function wpe_plugin_meta_box($post) {
	if (get_option('gs_pmp_use_details') === 'yes') {
		add_meta_box(
			'wpe-plugin-details',
			__('Plugin Details', 'promote-my-plugins'),
			'gs_pmp_extension_details_box',
			'gs_pmp_extension',
			'side',
			'high'
		);
	}
}

function gs_pmp_extension_details_box($post, $args) {
	$meta = get_post_meta( $post->ID, '_plugin_details', true );
	
	$defaults = array(
		'type' => 'plugin',
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

$pluralName = get_option('gs_pmp_plural_label');
$singularName = get_option('gs_pmp_singular_label');

$labels = array(
	'name' => __($pluralName, 'gs-promote-my-extensions'),
	'singular_name' => __($singularName, 'gs-promote-my-extensions'),
	'add_new' => sprintf(__('Add New %1$s', 'gs-promote-my-extensions'), $singularName)
);

$args = array(
	'labels' => $labels,
	'public' => true,
	'hierarchical' => false,
	'has_archive' => true,
	'capability_type' => 'page',
	'supports' => array('title', 'editor', 'author', 'page-attributes'),
	'register_meta_box_cb' => 'wpe_plugin_meta_box',
	'rewrite' => array('slug'=>get_option('gs_pmp_index_slug')),
	'menu_icon' => 'dashicons-admin-plugins'
);

if (get_option('gs_pmp_use_excerpt') === 'yes') array_push($args['supports'], 'excerpt');
if (get_option('gs_pmp_use_thumbnails') === 'yes') array_push($args['supports'], 'thumbnail');
if (get_option('gs_pmp_use_custom_fields') === 'yes') array_push($args['supports'], 'custom-fields');
if (get_option('gs_pmp_use_comments') === 'yes') array_push($args['supports'], 'comments');
if (get_option('gs_pmp_use_trackbacks') === 'yes') array_push($args['supports'], 'trackbacks');
if (get_option('gs_pmp_use_revisions') === 'yes') array_push($args['supports'], 'revisions');

register_post_type('gs_pmp_extension', $args);

if (get_option('gs_pmp_use_taxonomies') === 'yes') {
	// Register the Category Taxonomy
	$catLabels = array(
		'name' => __('Plugin Categories', 'gs-promote-my-extensions'),
		'singular_name' => __('Plugin Category', 'gs-promote-my-extensions'),
		
	);
	
	$catArgs = array(
		'labels' => $catLabels,
		'public' => true,
		'hierarchical' => true,
		'show_admin_column' => true,
		'rewrite' => array('slug' => 'extensioncat')
	);
	register_taxonomy('gs_pmp_category', 'gs_pmp_extension', $catArgs);
}

// Set up filters
add_filter( 'the_content', 'wpeplugin_content_filter', 1 );

// Display details ONLY on plugin pages that are not children of a plugin.
function wpeplugin_content_filter( $content ) {
	$details = '';

	if (get_post_type() === 'gs_pmp_extension' && is_single() && get_option('gs_pmp_use_details') === 'yes' ) {
		$meta = get_post_meta( get_the_id(), '_plugin_details', true );
		ob_start();
		include(plugin_dir_path(dirname(__FILE__)) . 'includes/plugin-details-display.php');
		$details = ob_get_contents();
		ob_end_clean();
	}

	return $content . $details;
}
