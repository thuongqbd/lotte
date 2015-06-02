<?php
function facebook_comments_master_load_system_wide() {
	if (get_option('facebook_comments_master_system_wide_app') == "true" ){
		$facebook_comments_master_system_wide_app_create = '<meta property="fb:app_id" content="'.get_option('facebook_comments_master_system_wide_app_id').'"/>';
	}
	else{
		$facebook_comments_master_system_wide_app_create = false;
	}
	if (get_option('facebook_comments_master_system_wide_user') == "true" ){
		$facebook_comments_master_system_wide_user_create = '<meta property="fb:admins" content="'.get_option('facebook_comments_master_system_wide_user_id').'"/>';
	}
	else{
		$facebook_comments_master_system_wide_user_create = false;
	}

echo $facebook_comments_master_system_wide_app_create.$facebook_comments_master_system_wide_user_create;
}
add_action( 'wp_head', 'facebook_comments_master_load_system_wide' );
add_action( 'admin_head', 'facebook_comments_master_load_system_wide' );