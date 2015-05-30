<?php
global $xoouserultra;
?>
<div class="container">
	<div class="group happy-member">
		<div class="content-happy-member">
			<div class="happy-members-slider">
				<div class="jcarousel-wrapper">
					<div class="jcarousel jcarousel2" data-jcarousel="true">
						<ul>
							<?php
							foreach ($users_list['users'] as $user) : $user_id = $user->ID;
								if ($pic_boder_type == "rounded") {
									$class_avatar = "avatar";
								}
								?> 
							<li class="item" style="width: 228px;">
								<div class="item-list">
									<?php echo $xoouserultra->userpanel->get_user_pic($user_id, $pic_size, $pic_type, $pic_boder_type, $pic_size_type) ?>
									<p><?php echo $xoouserultra->userpanel->get_display_name($user_id) ?></p>
								</div>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="title-happy-members">
				<h2>Happy members</h2>
				<div class="group-dots-control">
					<a href="#" class="next jcarousel-control-prev2" data-jcarouselcontrol="true"></a>
					<a href="#" class="pre jcarousel-control-next2" data-jcarouselcontrol="true"></a>	`
				</div>
			</div>
		</div>
	</div>
</div>