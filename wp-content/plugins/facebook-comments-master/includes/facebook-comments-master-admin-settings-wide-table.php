<?php
if(!class_exists('WP_List_Table')){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class facebook_comments_master_admin_settings_wide_table extends WP_List_Table {
	/**
	 * Display the rows of records in the table
	 * @return string, echo the markup of the rows
	 */
	function display() {
?>
<table class="widefat fixed" cellspacing="0">
	<thead>
		<tr>
			<th id="columnname" class="manage-column column-columnname" scope="col"><legend><h3><img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; height:16px; vertical-align:middle;" /><?php _e('&nbsp;Instructions', 'facebook_comments_master'); ?></h3></legend></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<th class="manage-column column-columnname" scope="col"></th>
		</tr>
	</tfoot>

	<tbody>
		<tr class="alternate">
			<td class="column-columnname">
<p>This is the central place to easily set your Facebook Application ID number and Facebook User ID number for moderation purposes. You can also override the default Facebook Language. <b>These Settings apply to all shortcodes and widgets across your wordpress website</b>.</p>
<p>If you don't know how to create a facebook application, get in touch with us via <a href="http://wordpress.techgasp.com/support/" target="_blank"><b>support ticket</b></a>.</p>
</td>
		</tr>
	</tbody>
</table>
<?php
		}
}