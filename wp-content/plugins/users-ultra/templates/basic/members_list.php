<?php
function sectionArray($array, $step) {
	$sectioned = array();

	$k = 0;
	for ($i = 0; $i < count($array); $i++) {
		if (!($i % $step)) {
			$k++;
		}
		$sectioned[$k][] = $array[$i];
	}
	return $sectioned;
}

global $xoouserultra;
//var_dump(get_the_author_meta('',$users_list['users'][0]->ID));die;

?>
<div class="group">
	<div class="happy-member-block">
		<div class="carousel-wrapper-header">
			<div class="jcarousel-member" data-jcarousel="true">
				<ul style="left: 0px; top: 0px;">
					<?php 
					$usersList = sectionArray($users_list['users'], 10);
					foreach ($usersList as  $list):
					?>
						<li>
						<?php
							$hasBotton = count($list)>5?TRUE:FALSE;						
							$childList = sectionArray($list, 5);
							$i=0;
							foreach ($childList as $child):								
							?>
								<div class="member-list <?= $i==1?'member-list-bottom':'member-list-top'?>">
								<?php
								foreach ($child as $item):
//									$date = date_create($item->user_registered);
									$dob = get_user_meta($item->ID, $key = 'dob', true);
									$address = get_user_meta($item->ID, $key = 'address', true);
									if($i == 1):
								?>
									<div class="member-item-top">
										<?php echo $xoouserultra->userpanel->get_user_pic($item->ID, $pic_size, $pic_type, $pic_boder_type, $pic_size_type,'link-profile') ?>
										<a href="<?php echo $xoouserultra->userpanel->get_user_profile_permalink($item->ID)?>"><h2><?php echo $xoouserultra->userpanel->get_display_name($item->ID) ?></h2></a>
										<!--<p class="website"><a href="#">behance.net</a></p>-->
										<?php 
											$dob = get_user_meta($item->ID, $key = 'dob', true);
											$address = get_user_meta($item->ID, $key = 'address', true);
										?>
											<p class="date"><?php echo $dob?></p>
											<p class="location"><?php echo $address?></p>
									</div>
									<?php else: ?>
									<div class="member-item-top">
										<a href="<?php echo $xoouserultra->userpanel->get_user_profile_permalink($item->ID)?>"><h2><?php echo $xoouserultra->userpanel->get_display_name($item->ID) ?></h2></a>
										<!--<p class="website"><a href="<?php echo $xoouserultra->userpanel->get_user_profile_permalink($item->ID)?>">behance.net</a></p>-->
										<p class="date"><?php echo $dob?></p>
										<p class="location"><?php echo $address?></p>
										<?php echo $xoouserultra->userpanel->get_user_pic($item->ID, $pic_size, $pic_type, $pic_boder_type, $pic_size_type,'link-profile') ?>
									</div>
									<?php endif; ?>
								<?php 
								endforeach;
								?>
								</div>
							<?php
								$i++;
							endforeach;
							?>
						</li>
					<?php 
					endforeach;
					?>
				</ul>
			</div>
		</div>
		<div class="controll-position">
			<a href="#" class="jcarousel-control-prev-member inactive" data-jcarouselcontrol="true">‹</a>
			<a href="#" class="jcarousel-control-next-member" data-jcarouselcontrol="true">›</a>
		</div>
	</div>
</div>
<script>
	(function($) {
    $(function() {
        $('.jcarousel-member').jcarousel();
        
        $('.jcarousel-control-prev-member')
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $('.jcarousel-control-next-member')
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });
    });
})(jQuery);
</script>