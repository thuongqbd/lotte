(function($) {			
    $(function() {
        // Setup the carousels. Adjust the options for both carousels here.
        var memberStage      = $('.stage-image .myjcarousel').jcarousel();
        
		$('.stage-image .myjcarousel-control-prev')
                .on('jcarouselcontrol:active', function() {
                    $(this).removeClass('inactive');
                })
                .on('jcarouselcontrol:inactive', function() {
                    $(this).addClass('inactive');
                })
                .jcarouselControl({
                    target: '-=1'
                });

            $('.stage-image .myjcarousel-control-next')
                .on('jcarouselcontrol:active', function() {
                    $(this).removeClass('inactive');
                })
                .on('jcarouselcontrol:inactive', function() {
                    $(this).addClass('inactive');
                })
                .jcarouselControl({
                    target: '+=1'
                });
		memberStage.on('jcarousel:targetin', 'li', function() {
			nextLi = $(this).next('li');
			if(nextLi.length && nextLi.find('iframe').length == 0){
				data = nextLi.data();
				iframe = '<iframe width="100%" height="100%" src="http://www.youtube.com/embed/'+data.vid+'?autohide=1&modestbranding=1&showinfo=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
				nextLi.html(iframe);
			}
				
			});
		var memberNavigation = $('.navigation-image .myjcarousel').jcarousel();
        $('.navigation-image .myjcarousel-control-prev')
                .on('jcarouselcontrol:active', function() {
                    $(this).removeClass('inactive');
                })
                .on('jcarouselcontrol:inactive', function() {
                    $(this).addClass('inactive');
                })
                .jcarouselControl({
                    target: '-=1'
                });

            $('.navigation-image .myjcarousel-control-next')
                .on('jcarouselcontrol:active', function() {
                    $(this).removeClass('inactive');
                })
                .on('jcarouselcontrol:inactive', function() {
                    $(this).addClass('inactive');
                })
                .jcarouselControl({
                    target: '+=1'
                });
			
		var memberAlbum = $('.member-slide-album .myjcarousel').jcarousel();
                            
            $('.member-slide-album .myjcarousel-control-prev')
                .on('jcarouselcontrol:active', function() {
                    $(this).removeClass('inactive');
                })
                .on('jcarouselcontrol:inactive', function() {
                    $(this).addClass('inactive');
                })
                .jcarouselControl({
                    target: '-=1'
                });

            $('.member-slide-album .myjcarousel-control-next')
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
