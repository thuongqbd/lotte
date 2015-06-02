<?php
if(!class_exists('WP_List_Table')){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class facebook_comments_master_admin_settings_wide_table_options extends WP_List_Table {
	/**
	 * Display the rows of records in the table
	 * @return string, echo the markup of the rows
	 */
	function display() {
if ( $_POST) {
if ( isset($_POST['facebook_comments_master_system_wide_app']) )
update_option('facebook_comments_master_system_wide_app', $_POST['facebook_comments_master_system_wide_app'] );
else
update_option('facebook_comments_master_system_wide_app', 'false' );

if ( isset($_POST['facebook_comments_master_system_wide_app_id']) )
update_option('facebook_comments_master_system_wide_app_id', $_POST['facebook_comments_master_system_wide_app_id'] );
else
update_option('facebook_comments_master_system_wide_app_id', '' );

if ( isset($_POST['facebook_comments_master_system_wide_user']) )
update_option('facebook_comments_master_system_wide_user', $_POST['facebook_comments_master_system_wide_user'] );
else
update_option('facebook_comments_master_system_wide_user', 'false' );

if ( isset($_POST['facebook_comments_master_system_wide_user_id']) )
update_option('facebook_comments_master_system_wide_user_id', $_POST['facebook_comments_master_system_wide_user_id'] );
else
update_option('facebook_comments_master_system_wide_user_id', '' );

if ( isset($_POST['facebook_comments_master_system_wide_lang']) )
update_option('facebook_comments_master_system_wide_lang', $_POST['facebook_comments_master_system_wide_lang'] );
else
update_option('facebook_comments_master_system_wide_lang', 'false' );

if ( isset($_POST['facebook_comments_master_system_wide_lang_set']) )
update_option('facebook_comments_master_system_wide_lang_set', $_POST['facebook_comments_master_system_wide_lang_set'] );
else
update_option('facebook_comments_master_system_wide_lang_set', '' );

?>
<div id="message" class="updated fade">
<p><strong><?php _e('Settings Saved!', 'facebook_comments_master'); ?></strong></p>
</div>
<?php
}
?>
<form method="post" width='1'>
<fieldset class="options">

<table class="widefat fixed" cellspacing="0">
	<thead>
		<tr>
			<th id="cb" class="manage-column column-cb check-column" scope="col" style="vertical-align:middle"><input type="checkbox"></th>
			<th id="columnname" class="manage-column column-columnname" scope="col" width="250"><legend><h3><img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; height:16px; vertical-align:middle;" /><?php _e('&nbsp;System Wide Settings', 'facebook_comments_master'); ?></h3></legend></th>
			<th id="columnname" class="manage-column column-columnname" scope="col"></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<th class="manage-column column-cb check-column" scope="col"></th>
			<th class="manage-column column-columnname" scope="col"></th>
			<th class="manage-column column-columnname" scope="col"></th>
		</tr>
	</tfoot>

	<tbody>
		<tr class="alternate">
			<th class="check-column" scope="row">
<input name="facebook_comments_master_system_wide_app" id="facebook_comments_master_system_wide_app" value="true" type="checkbox" <?php echo get_option('facebook_comments_master_system_wide_app') == 'true' ? 'checked="checked"':''; ?> />
			</th>
			<td class="column-columnname">
<label for="facebook_comments_master_system_wide_app"><b><?php _e('Activate Facebook Application ID', 'facebook_comments_master'); ?></b></label>
			</td>
			<td class="column-columnname" style="vertical-align:middle"><a href="https://developers.facebook.com/apps" target="_blank">Get App ID Number</a></td>
		</tr>
		<tr class="alternate">
			<th class="check-column" scope="row"></th>
			<td class="column-columnname">
<label for="facebook_comments_master_system_wide_app_id"><?php _e('insert Facebook Application ID Number:', 'facebook_comments_master'); ?></label>
			</td>
			<td class="column-columnname" style="vertical-align:middle">
<input id="facebook_comments_master_system_wide_app_id" name="facebook_comments_master_system_wide_app_id" type="text" size="22" value="<?php echo get_option('facebook_comments_master_system_wide_app_id'); ?>">
			</td>
		</tr>
		<tr>
			<th class="check-column" scope="row">
<input name="facebook_comments_master_system_wide_user" id="facebook_comments_master_system_wide_user" value="true" type="checkbox" <?php echo get_option('facebook_comments_master_system_wide_user') == 'true' ? 'checked="checked"':''; ?> />
			</th>
			<td class="column-columnname">
<label for="facebook_comments_master_system_wide_user"><b><?php _e('Activate Facebook User ID', 'facebook_comments_master'); ?></b></label>
			</td>
			<td class="column-columnname" style="vertical-align:middle"><a href="http://graph.facebook.com/WRITE.YOUR.FACEBOOK.USERNAME.HERE" target="_blank">Get User ID Number</a></td>
		</tr>
		<tr>
			<th class="check-column" scope="row"></th>
			<td class="column-columnname">
<label for="facebook_comments_master_system_wide_user_id"><?php _e('insert Facebook User ID Number:', 'facebook_comments_master'); ?></label>
			</td>
			<td class="column-columnname" style="vertical-align:middle">
<input id="facebook_comments_master_system_wide_user_id" name="facebook_comments_master_system_wide_user_id" type="text" size="22" value="<?php echo get_option('facebook_comments_master_system_wide_user_id'); ?>">
			</td>
		</tr>
		
		
		<tr class="alternate">
			<th class="check-column" scope="row">
<input name="facebook_comments_master_system_wide_lang" id="facebook_comments_master_system_wide_lang" value="true" type="checkbox" <?php echo get_option('facebook_comments_master_system_wide_lang') == 'true' ? 'checked="checked"':''; ?> />
			</th>
			<td class="column-columnname">
<label for="facebook_comments_master_system_wide_lang"><b><?php _e('Activate Language Override', 'facebook_comments_master'); ?></b></label>
			</td>
			<td class="column-columnname" style="vertical-align:middle">Leave Blank or Empty for defaul English and do not Activate. Override by inserting your Country Language. Example fr_FR or es_ES or pt_PT.</td>
		</tr>
		<tr class="alternate">
			<th class="check-column" scope="row"></th>
			<td class="column-columnname">
<label for="facebook_comments_master_system_wide_lang_set"><?php _e('insert Facebook Language Code:', 'facebook_comments_master'); ?></label>
			</td>
			<td class="column-columnname" style="vertical-align:middle">
<input id="facebook_comments_master_system_wide_lang_set" name="facebook_comments_master_system_wide_lang_set" type="text" size="22" value="<?php echo get_option('facebook_comments_master_system_wide_lang_set'); ?>">
			</td>
		</tr>
		
		
		
		
		
		<tr>
			<th class="check-column" scope="row"></th>
			<td class="column-columnname" width="250">
<a href="https://developers.facebook.com/tools/comments" target="_blank"><b>Moderate All Comments</b></a>
			</td>
			<td class="column-columnname">
<p>Click Moderate All Comments to view comments across all your wordpress pages. Comments can also be moderated individually in each wordpress page.</p>
			</td>
		</tr>
	</tbody>
</table>
<p class="submit"><input class='button-primary' type='submit' name='update' value='<?php _e("Save Settings", 'facebook_comments_master'); ?>' id='submitbutton' /></p>
</fieldset>
</form>
<?php
	}
//CLASS ENDS
}