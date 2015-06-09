<?php
global $xoouserultra;
$time = time();
?>
<div class="content">
	<div class="container-profile">
		<div class="profile">
			<div class="avatar"><?php echo $xoouserultra->userpanel->get_user_pic($user_id, $pic_size, $pic_type, $pic_boder_type, $pic_size_type) ?> </div>
			<h2 class="name"><?php echo $xoouserultra->userpanel->get_display_name($current_user->ID); ?></h2>
			<!--<div class="website">www.behance.net</div>-->
			<div class="extra">
				<?php 
					$dob = get_user_meta($user_id, $key = 'dob', true);
					$address = get_user_meta($user_id, $key = 'address', true);
					$desc = get_user_meta($user_id, $key = 'description', true);
				?>
				<?php if($dob):?>
				<div class="birthday"><?php echo $dob?></div>
				<?php endif;?>
				<?php if($address):?>
				<div class="location"><?php echo $address?></div>
				<?php endif;?>
			</div>

		</div>	
	</div>
	<div class="container-feature">
		<div class="feature-image">
			<?php if($desc):?>
				<div class="user-description"><?php echo $desc?></div>
			<?php endif;?>
			<?php if(count($listVideos)):?>
			<div class="stage-image list-videos">
				<div class="myjcarousel">
					<ul>
						<?php 
						$getTwo = 0;
						foreach ($listVideos as $video):?>						
						<li data-vid="<?php echo $video->video_unique_vid?>">
							<?php if($getTwo < 2): $getTwo++?>
							<iframe width="100%" height="100%" src="//www.youtube.com/embed/<?php echo $video->video_unique_vid?>?autohide=1&modestbranding=1&showinfo=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
							<?php endif?>
						</li>
						<?php endforeach;?>
					</ul>
				</div>
				<a href="#" class="myjcarousel-control-prev"><span>&lsaquo;</span></a>
				<a href="#" class="myjcarousel-control-next"><span>&rsaquo;</span></a>
			</div>
			<?php endif; ?>
			<?php if(count($listPhotos)):?>
			<div class="navigation-image list-photos">
				<div class="myjcarousel">
					<ul>
						<?php foreach ($listPhotos as $photo):?>
						<li>
							<a href="<?php echo $photo->photo_large?>" class="fancybox fancybox_<?php echo $time?>" data-fancybox-group='gallery' title='<?php echo $photo->photo_desc?>'>
								<img src="<?php echo $photo->photo_thumb?>" alt="<?php echo $photo->photo_name?>">
							</a>
						</li>
						<?php endforeach;?>
					</ul>
					<a href="#" class="myjcarousel-control-prev">&lsaquo;</a>
					<a href="#" class="myjcarousel-control-next">&rsaquo;</a>
				</div>
			</div>
			<?php endif;?>
		</div>
	</div>
	
</div>
<script>
	jQuery(document).ready(function($){$(".fancybox_<?php echo $time?>").fancybox()});
</script>