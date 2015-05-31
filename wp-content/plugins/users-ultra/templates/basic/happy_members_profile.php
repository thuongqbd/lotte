<?php
global $xoouserultra;
?>
<div class="content">
	<div class="profile">
		<div class="avatar"><?php echo $xoouserultra->userpanel->get_user_pic($user_id, $pic_size, $pic_type, $pic_boder_type, $pic_size_type) ?> </div>
		<h2 class="name"><?php echo $xoouserultra->userpanel->get_display_name($current_user->ID); ?></h2>
		<!--<div class="website">www.behance.net</div>-->
		<div class="extra">
			<div class="birthday">May , 15, 1985</div>
			<div class="location">South of Viet Nam</div>
		</div>
		
	</div>
	<div class="feature-image">
		<?php if(count($listVideos)):?>
		<div class="stage-image list-videos">
			<div class="myjcarousel">
				<ul>
					<?php 
					$getTwo = 0;
					foreach ($listVideos as $video):?>						
					<li data-vid="<?php echo $video->video_unique_vid?>">
						<?php if($getTwo < 2): $getTwo++?>
						<iframe width="100%" height="100%" src="http://www.youtube.com/embed/<?php echo $video->video_unique_vid?>?autohide=1&modestbranding=1&showinfo=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
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
						<a href="<?php echo $photo->photo_large?>" data-lightbox="example-1" data-title='<?php echo $photo->photo_desc?>'>
							<img src="<?php echo $photo->photo_thumb?>" alt="<?php echo $photo->name?>">
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