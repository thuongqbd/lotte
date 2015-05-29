(function($) {
    $(function() {
        var carouselVideo = $('.container-slide-video .myjcarousel').jcarousel();

        $('.container-slide-video .myjcarousel-control-prev')
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $('.container-slide-video .myjcarousel-control-next')
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });

        var carouselAlbum = $('.container-slide-album .myjcarousel').jcarousel();
                            
            $('.container-slide-album .myjcarousel-control-prev')
                .on('jcarouselcontrol:active', function() {
                    $(this).removeClass('inactive');
                })
                .on('jcarouselcontrol:inactive', function() {
                    $(this).addClass('inactive');
                })
                .jcarouselControl({
                    target: '-=1'
                });

            $('.container-slide-album .myjcarousel-control-next')
                .on('jcarouselcontrol:active', function() {
                    $(this).removeClass('inactive');
                })
                .on('jcarouselcontrol:inactive', function() {
                    $(this).addClass('inactive');
                })
                .jcarouselControl({
                    target: '+=1'
                });
		
		var setup = function(jcarousel,data) {
            var html = '<ul style="left: 0px; top: 0px;">';

            $.each(data.items, function() {
                html += '<li data-vid="' + this.video_unique_vid + '" data-title="' + this.title + '" data-date="' + this.create_at + '"><a href="javascript:void(0)" class="content"><img src="' + this.src + '" alt="' + this.title + '"></a></li>';
            });

            html += '</ul>';

            // Append items
            jcarousel.html(html);

            // Reload carousel
            jcarousel.jcarousel('reload');
        };
		
		$('.group .container-slide-album li').on('click',function(){
			if(!$(this).hasClass('active')){
				console.log('click album');
				$('.container-slide-album li').removeClass('active');
				$(this).addClass('active');
				var gal_id = $(this).data('gal_id');
				$.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {"action": "videos_of_gallery", "video_gal_id": gal_id},					
					success: function(data){
						if(data){
							data = JSON.parse(data);
							setup(carouselVideo,data);
							$('div.container-video').html(data.firstVideo);
							$('.group .container-slide-video li').on('click',function(){
								console.log('click video');
								data = $(this).data();
								console.log(data);
								html = '<div class="video-warp" style="height:610px"> <iframe width="100%" height="610px" src="http://www.youtube.com/embed/'+data.vid+'?autohide=1&modestbranding=1&showinfo=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe> <!--<div class="icon">VIDEOS</div>--> <!--<div class="icon-album">ALBUM</div>--> </div> <div class="video-bar"></div> <div class="video-des"> <h3>'+data.title+'|</h3> <span class="time">'+data.date+'</span> </div>';
								$('div.container-video').html(html);
							});
						}
					}
				});
			}
		});
		$('.group .container-slide-video li').on('click',function(){
			console.log('click video');
			data = $(this).data();
			console.log(data);
			html = '<div class="video-warp" style="height:610px"> <iframe width="100%" height="610px" src="http://www.youtube.com/embed/'+data.vid+'?autohide=1&modestbranding=1&showinfo=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe> <!--<div class="icon">VIDEOS</div>--> <!--<div class="icon-album">ALBUM</div>--> </div> <div class="video-bar"></div> <div class="video-des"> <h3>'+data.title+'|</h3> <span class="time">'+data.date+'</span> </div>';
			$('div.container-video').html(html);
		});
    });
})(jQuery);
