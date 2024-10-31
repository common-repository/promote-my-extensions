<?php
/**
 * Code to save information from the meta boxes.
 *
 * @package Promote My Extensions
 */


function gs_pmp_save_post($post_id, $post) {
	// Add nonce for security and authentication.
	$nonce_name   = isset( $_POST['gs_pmp_box_nonce'] ) ? $_POST['gs_pmp_box_nonce'] : '';
	$nonce_action = 'gs_pmp_box';
	// Check if nonce is valid.
	if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
		return;
	}
	
	// Check if user has permissions to save data.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	
	// Check if not an autosave.
	if ( wp_is_post_autosave( $post_id ) ) {
		return;
	}

	// Check if not a revision.
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}
	
	// Now we can save the data!
	$metaName = false;
	$fieldNames = array();
	$dataArray = array();
	
	if ($_POST['post_type'] == 'gs_pmp_extension') {
		$metaName = "_plugin_details";
		$fieldNames = array('type', 'downloads','documentation','faq','support','reviews', 'donate');
	} 
	
	if ($metaName != false) {
		foreach ($fieldNames as $fieldName) {
			$data = sanitize_text_field($_POST[$fieldName]);
			$dataArray[$fieldName] = $data;
		}
		
		// Update the meta.
		if (count($dataArray) > 0) {
			update_post_meta($post_id, $metaName, $dataArray);
		} else {
			delete_post_meta($post_id, $metaName);
		}
	}
}
