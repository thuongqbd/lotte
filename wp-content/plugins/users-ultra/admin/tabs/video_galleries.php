<?php
global $xoouserultra;
$xoouserultra->add_front_end_styles();
$module = "videos";
$page_id = "";
$video_gal_id = "";

if (isset($_GET["module"])) {
	$module = $_GET["module"];
}
if (isset($_GET["video_gal_id"])) {
	$video_gal_id = $_GET["video_gal_id"];
}
if (isset($_GET["page_id"])) {
	$page_id = $_GET["page_id"];
}
$current_user = $xoouserultra->userpanel->get_user_info();
?>

 <?php
//videos
if ($module == "videos") {
?>
	<div class="commons-panel xoousersultra-shadow-borers usersultra-dahsboard-cont" >
		<div class="commons-panel-heading">
			<h2> <?php _e('My Video Galleries', 'xoousers'); ?> / </h2>
		</div>
		<div class="commons-panel-content">
			<p><?php _e('Here you can manage your galleries and videos.', 'xoousers'); ?></p>
			<a  id="add_video_gallery"  href="#"> <?php _e('Add Gallery', 'xoousers'); ?></a>
			<div class="video-gallery-list">
				<div class="add-new-video-gallery white_content" id="new_video_gallery_div">
					<p>
						<?php _e('Name', 'xoousers'); ?>
						<br />
						<input type="hidden" name="xoouserultra_current_video_gal"  id="xoouserultra_current_video_gal" />
						<input type="text" class="xoouserultra-input" name="new_video_gallery_name" id="new_video_gallery_name" value=""> 
						<?php _e('User', 'xoousers'); ?>
						<br />
						<?php wp_dropdown_users(array('id' => 'name','name'=>'new_video_user_id','id'=>'new_video_user_id','class'=>'xoouserultra-input','selected'=>get_current_user_id())); ?>
						<br />
						<?php _e('Description', 'xoousers'); ?>
						<br />
						<textarea class="xoouserultra-input" name="new_video_gallery_desc" id="new_video_gallery_desc" ></textarea>
					</p>

					<div class="usersultra-btn-options-bar">
						<a class="buttonize" href="#" id="close_add_video_gallery"><?php _e('Cancel', 'xoousers'); ?></a>
						<a class="buttonize green"  href="#" id="new_video_gallery_add"><?php _e('Submit', 'xoousers'); ?></a>

					</div>
				</div>
				<ul id="usersultra-video-gallerylist">
					<?php _e('loading video galleries ...', 'xoousers'); ?>
				</ul>
			</div>
			
		</div>                    
	</div>

	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			var data = query_string();
			data.action = "reload_video_galleries";
			data.page_id = "page_id_val";
			data.admin = 1;
			var page_id_val = $('#page_id').val();
			$.post(ajaxurl, data, function (response) {
				$("#usersultra-video-gallerylist").html(response);
			});
		});
		var gallery_delete_confirmation_message = '<?php echo _e('Delete this gallery?', 'xoousers') ?>';
	</script>       

<?php } ?>
<?php
//videos-files
if ($module == "videos-files") {
	//get selected gallery
	$current_video_vgal = $xoouserultra->videogallery->get_video_gallery($video_gal_id);
	$user_name = $xoouserultra->userpanel->get_display_name($current_video_vgal->gallery_user_id )
	?>	
	<div class="commons-panel xoousersultra-shadow-borers usersultra-dahsboard-cont" >
		<div class="commons-panel-heading">
			<h2> User: <?php echo $user_name ?> | Gallery: <?php echo $current_video_vgal->gallery_name ?> </h2>
			<a href="#" id="back-link" style="display: inline-block; position: absolute; right: 20px; top: 15px;">Back</a>
		</div>
		<div class="commons-panel-content">
			<a  id="add_new_video"  href="#"> <?php _e('Add Video', 'xoousers'); ?></a>
			<div class="add-new-video white_content" id="new_video_div">
				<p>
					<?php _e('Name', 'xoousers'); ?>
					<br />
					<input type="text" class="xoouserultra-input" name="new_video_name" id="new_video_name" value=""> 
				</p>
				<p>
					<?php _e('Video ID', 'xoousers'); ?>
					<br />
					<input type="text" class="xoouserultra-input" name="new_video_unique_vid" id="new_video_unique_vid" value=""> 
				</p
				<p>
					<?php _e('Description', 'xoousers'); ?>
					<br />
					<textarea name="new_video_desc" id="new_video_desc" class="xoouserultra-input"></textarea>
				</p>
				<div id="uploadContainer" style="margin-top: 10px;">
					<?php $xoouserultra->videogallery->post_media_display($video_gal_id, null, 'new_video_div'); ?> 
				</div>

				<input type="hidden" name="video_gal_id" id="new_video_gal_id" value="<?php echo $video_gal_id ?>"> 
				<input type="hidden" name="video_image" id="new_video_image" value=""> 
				<input type="hidden" name="video_thumb" id="new_video_thumb" value="">
				<div class="usersultra-btn-options-bar">
					<a class="buttonize" href="#" id="close_add_video"><?php _e('Cancel', 'xoousers'); ?></a>
					<a class="buttonize green"  href="#" id="new_video_add_confirm"><?php _e('Submit', 'xoousers'); ?></a>
				</div>
			</div>			
			<div class="video-list">     							                                     
				<ul id="usersultra-videolist" class="usersultra-video-private">
					<?php _e('please wait, loading videos ...', 'xoousers'); ?>
				</ul>
			</div>
		</div>                           
	</div>

	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			$.post(ajaxurl, {
				action: 'reload_videos', 'video_gal_id': '<?php echo $video_gal_id ?>'
			}, function (response) {
				$("#usersultra-videolist").html(response);
			});
		});
		var video_delete_confirmation_message = '<?php echo _e('Delete this video?', 'xoousers') ?>';
		var video_empy_field_name = '<?php echo _e('Please input a name', 'xoousers') ?>';
		var video_empy_field_id = '<?php echo _e('Please input video ID', 'xoousers') ?>';
	</script>  
<?php } ?>
	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			$('#back-link').attr('href',$('.userultra-admin .nav-tab-wrapper a.nav-tab-active').attr('href'));
		});
	</script>