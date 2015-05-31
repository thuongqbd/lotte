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
						<?php echo $xoouserultra->userpanel->get_user_pic($user->data->ID, '220', $pic_type, $pic_boder_type, $pic_size_type2) ?>
						<div class="title-album"><?php echo $xoouserultra->userpanel->get_display_name($user->data->ID); ?></div>
						<div class="time">May, 15,2015</div>
						<!--<div class="icon-video"></div>-->
					</div>
				</li>
				<?php endforeach;?>
		</div>
		<p class="photo-title">
			Other Members
		</p>
		<a href="#" class="myjcarousel-control-prev"></a>
		<a href="#" class="myjcarousel-control-next"></a>
	</div>
</div>
<?php endif?>
                