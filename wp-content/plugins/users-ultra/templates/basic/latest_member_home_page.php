<?php
global $xoouserultra;
?>
<div class="container">
    <div class="title-home happy-diary-title happy-member-home for-sp">
        <table cellspacing="0" cellpadding="0">
            <tr>
                <td class="first"><h2>Phượt thủ</h2></td>
                <td class="second">
                    <img class="mobile-brea" src="<?php echo get_template_directory_uri(); ?>/images/breadcrumb-arrow-mobile.png" alt=""/>
                    <img class="not-mobile-brea" src="<?php echo get_template_directory_uri(); ?>/images/breadcrumb-arrow.png" alt=""/></td>
                <td class="line-title">&nbsp;</td>

            </tr>
        </table>
    </div>
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
							<li class="item">
								<div class="item-list">
									<div class="avatar">
										<?php echo $xoouserultra->userpanel->get_user_pic($user_id, null, $pic_type, $pic_boder_type, $pic_size_type) ?>
									</div>
									<p><?php echo $xoouserultra->userpanel->get_display_name($user_id) ?></p>
								</div>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="title-happy-members">
				<h2>Phượt thủ</h2>
				<div class="group-dots-control">
					<a href="#" class="next jcarousel-control-prev2" data-jcarouselcontrol="true"></a>
					<a href="#" class="pre jcarousel-control-next2" data-jcarouselcontrol="true"></a>	`
				</div>
			</div>
		</div>
	</div>
</div>