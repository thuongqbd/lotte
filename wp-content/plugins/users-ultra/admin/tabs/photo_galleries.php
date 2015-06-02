<?php
global $xoouserultra;
$xoouserultra->add_front_end_styles();
$module = "photos";
$page_id = "";
$gal_id = "";

if (isset($_GET["module"])) {
	$module = $_GET["module"];
}
if (isset($_GET["gal_id"])) {
	$gal_id = $_GET["gal_id"];
}
if (isset($_GET["page_id"])) {
	$page_id = $_GET["page_id"];
}
$current_user = $xoouserultra->userpanel->get_user_info();
?>

<?php
//my photos
if ($module == "photos") {
?>
	<div class="commons-panel xoousersultra-shadow-borers usersultra-dahsboard-cont" >
		<div class="commons-panel-heading">
			<h2> <?php _e('My Galleries', 'xoousers'); ?> / </h2>
		</div>
		<div class="commons-panel-content">
			<p><?php _e('Here you can manage your galleries and photos.', 'xoousers'); ?></p>
			<a  id="add_gallery"  href="#"> <?php _e('Add Gallery', 'xoousers'); ?></a>
			<div class="gallery-list">
				<div class="add-new-gallery white_content" id="new_gallery_div">
					<p>
						<?php _e('Name', 'xoousers'); ?>
						<br />
						<input type="text" class="xoouserultra-input" name="new_gallery_name" id="new_gallery_name" value=""> 
						<?php if($xoouserultra->is_admin):?>
							<?php _e('User', 'xoousers'); ?>
							<br />
							<?php wp_dropdown_users(array('id' => 'name','name'=>'new_gallery_user_id','id'=>'new_gallery_user_id','class'=>'xoouserultra-input','selected'=>get_current_user_id())); ?>
							<br />
						<?php endif;?>								
						<?php _e('Description', 'xoousers'); ?>
						<br />
						<textarea class="xoouserultra-input" name="new_gallery_desc" id="new_gallery_desc" ></textarea>
					</p>
					<div class="usersultra-btn-options-bar">
						<a class="buttonize" href="#" id="close_add_gallery"><?php _e('Cancel', 'xoousers'); ?></a>
						<a class="buttonize green"  href="#" id="new_gallery_add"><?php _e('Submit', 'xoousers'); ?></a>
					</div>
				</div>
				<ul id="usersultra-gallerylist">
					<?php _e('loading ...', 'xoousers'); ?>
				</ul>
			</div>
		</div>                    
	</div>
	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			var data = query_string();
			data.action = "reload_galleries";
			data.page_id = "page_id_val";
			var page_id_val = $('#page_id').val();
			$.post(ajaxurl,data, function (response) {
				$("#usersultra-gallerylist").html(response);
			});
		});
		var gallery_delete_confirmation_message = '<?php echo _e('Delete this gallery?', 'xoousers') ?>';
	</script>
<?php } ?>
<?php
//my photos
if ($module == "photos-files") {
	//get selected gallery
	$current_gal = $xoouserultra->photogallery->get_gallery($gal_id);
	$user_name = $xoouserultra->userpanel->get_display_name($current_gal->gallery_user_id );
	?>
	<div class="commons-panel xoousersultra-shadow-borers usersultra-dahsboard-cont" >
		<div class="commons-panel-heading">
			<h2> User: <?php echo $user_name ?> | Gallery: <?php echo $current_gal->gallery_name ?> </h2>
			<a href="#" id="back-link" style="display: inline-block; position: absolute; right: 20px; top: 15px;">Back</a>
		</div>
		<div class="commons-panel-content">
			<p><?php _e('Here you can manage your photos.', 'xoousers'); ?></p>
			<a  id="add_new_files"  href="#"> <?php _e('Upload Files', 'xoousers'); ?></a>
			<div class="photo-list">                         
				<div class="res_sortable_container white_content" id="resp_t_image_list">
					<a href="javascript:;" class="close"></a>
					<?php $xoouserultra->photogallery->post_media_display($gal_id); ?>                       
				</div>
				<ul id="usersultra-photolist" class="usersultra-photolist-private">
					<?php _e('loading photos ...', 'xoousers'); ?>
				</ul>
			</div>
		</div>                    
	</div>

	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			$.post(ajaxurl, {
				action: 'reload_photos', 'gal_id': '<?php echo $gal_id ?>'
			}, function (response) {
				$("#usersultra-photolist").html(response);
			});
			$('.white_content a.close').click(function(){				
				$( "#resp_t_image_list" ).slideUp( "slow");	
				fadeOut();
				return false; 
				e.preventDefault();
			});
		});
	</script>
<?php } ?>
<input type="hidden" value="<?php echo $page_id ?>" name="page_id" id="page_id" />
<script type="text/javascript">
	jQuery(document).ready(function ($) {
		$('#back-link').attr('href',$('.userultra-admin .nav-tab-wrapper a.nav-tab-active').attr('href'));
	});
</script>