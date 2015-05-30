(function($) {
    $(function() {
        var carouselVideo = $('.happy-spirit .container-slide-video .myjcarousel').jcarousel();

        $('.happy-spirit .container-slide-video .myjcarousel-control-prev')
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $('.happy-spirit .container-slide-video .myjcarousel-control-next')
            .on('jcarouselcontrol:active', function() {
                $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '+=1'
            });

        var carouselAlbum = $('.happy-spirit .container-slide-album .myjcarousel').jcarousel();
                            
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
                html += '<li data-large="' + this.large + '" data-title="' + this.title + '" data-date="' + this.create_at + '"><a href="javascript:void(0)" class="content"><img src="' + this.src + '" alt="' + this.title + '"></a></li>';
            });

            html += '</ul>';

            // Append items
            jcarousel.html(html);

            // Reload carousel
            jcarousel.jcarousel('reload');
        };
		
		$('.happy-spirit .group .container-slide-album li').on('click',function(){
			if(!$(this).hasClass('active')){
				console.log('click album');
				$('.container-slide-album li').removeClass('active');
				$(this).addClass('active');
				var gal_id = $(this).data('gal_id');
				$.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {"action": "photos_of_gallery", "gal_id": gal_id},					
					success: function(data){
						if(data){
							data = JSON.parse(data);
							setup(carouselVideo,data);
							$('div.container-video').html(data.firstPhoto);
							$('.group .container-slide-video li').on('click',function(){
								console.log('click video');
								data = $(this).data();
								console.log(data);
								html = '<div class="video-warp" style="height:610px"><img src="'+data.large+'" alt="'+data.name+'"></div> <div class="video-bar"></div> <div class="video-des"> <h3>'+data.title+'|</h3> <span class="time">'+data.date+'</span> </div>';
								$('div.container-video').html(html);
							});
						}
					}
				});
			}
		});
		$('.happy-spirit  .group .container-slide-video li').on('click',function(){
			data = $(this).data();
			console.log(data);
			html = '<div class="video-warp" style="height:610px"> <img src="'+data.large+'" alt="'+data.name+'"></div> <div class="video-bar"></div> <div class="video-des"> <h3>'+data.title+'|</h3> <span class="time">'+data.date+'</span> </div>';
			$('div.container-video').html(html);
		});

    });
})(jQuery);