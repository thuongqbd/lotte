jQuery(document).ready(function($){
	$(".drop-down-menu").on('click', function(){
		$('.main-menu-mobile').css('display','block');
		$('.mobile-menu').addClass('show');
	});
	$('.main-menu-mobile').on('click', function(){
		$(this).css('display','none');
		$(".mobile-menu").removeClass('show');
	});
});