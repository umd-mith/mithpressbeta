<?php

// AjaxUpload callback //////////////////////////////////////////////

add_action('wp_ajax_ttrust_ajax_post_action', 'ttrust_ajax_callback');

function ttrust_ajax_callback() {
	global $wpdb; // Get access to teh database
		
	$save_type = $_POST['type'];
	//Uploads
	if($save_type == 'upload'){
		
		$clickedID = $_POST['data']; 
		$filename = $_FILES[$clickedID];
    	$filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']); 
		
		$override['test_form'] = false;
		$override['action'] = 'wp_handle_upload';    
		$uploaded_file = wp_handle_upload($filename,$override);
		 
		$upload_tracking[] = $clickedID;	
		update_option($clickedID, $uploaded_file['url'] );		
				
		if(!empty($uploaded_file['error'])) {echo 'Upload Error: ' . $uploaded_file['error']; }	
		else { echo $uploaded_file['url']; } // Is the Response	
	
	}elseif($save_type == 'image_reset'){
		
		$id = $_POST['data']; // Acts as the name
		global $wpdb;
		$query = "DELETE FROM $wpdb->options WHERE option_name LIKE '$id'";
		$wpdb->query($query);
				
	}
	
}
	
?>