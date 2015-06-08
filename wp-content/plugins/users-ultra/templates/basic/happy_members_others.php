<?php
global $xoouserultra;
?>
<?php if(count($users_list)):?>
<div class="member-slide-album">
	<div class="wraper">
		<div class="myjcarousel">
			<ul>
				<?php foreach ($users_list as $user):?>
				<li>
					<div class="content">
						<!--<img src="images/slide-moment/album1.jpg" width="236px" height="151px" alt="">-->
						<?php echo $xoouserultra->userpanel->get_user_pic($user->data->ID, '220', $pic_type, $pic_boder_type, '') ?>
						<div class="title-album"><?php echo $xoouserultra->userpanel->get_display_name($user->data->ID); ?></div>
						<?php 
						$dob = get_user_meta($user->data->ID, $key = 'dob', true);
						if($dob):?>
						<div class="time"><?php echo $dob?></div>
						<?php endif;?>
						<!--<div class="icon-video"></div>-->
					</div>
				</li>
				<?php endforeach;?>
		</div>
		<p class="photo-title">
			Phượt thủ khác
		</p>
		<a href="#" class="myjcarousel-control-prev"></a>
		<a href="#" class="myjcarousel-control-next"></a>
	</div>
</div>
<?php endif?>
                