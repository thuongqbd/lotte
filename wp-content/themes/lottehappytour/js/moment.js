(function($) {
	curentUrl = stripQueryStringAndHashFromPath(window.location.href);
    $(function() {
        var carouselVideo = $('.container-slide-video .myjcarousel');
        carouselVideo
            .on('jcarousel:reload jcarousel:create', function (e) {
                var carousel = $(this),
                    width = carousel.innerWidth();
                if (width >= 768) {
                    width = width / 4;
                } else{
                    width = width / 2;
                }

                carousel.jcarousel('items').css('width', Math.ceil(width) + 'px');
            })
            .jcarousel({
                wrap: 'circular'
            });
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

        var carouselAlbum = $('.container-slide-album .myjcarousel');
        carouselAlbum
            .on('jcarousel:reload jcarousel:create', function () {
                var carousel = $(this),
                    width = carousel.innerWidth();
                if (width >= 582) {
                    width = width / 3;
                } else{
                    width = width / 2;
                }

                carousel.jcarousel('items').css('width', Math.ceil(width) + 'px');
            })
            .jcarousel({
                wrap: 'circular'
            });
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
                html += '<li data-vid="' + this.video_unique_vid + '" data-date="' + this.create_at + '" data-id="'+this.id+'" data-gal_id="'+this.gal_id+'" style="width: 209px;"><p id="title" class="hidden">' + this.title + '</p><a href="javascript:void(0)" class="content"><img src="' + this.src + '" alt="' + this.title + '"><div class="icon-video"></div></a></li>';
            });
            html += '</ul>';
            jcarousel.html(html);
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
                            carouselVideo.jcarousel('reload');
							$('div.container-video').html(data.firstVideo);
							var url = addParameter(curentUrl,'gallery',gal_id);
							window.history.pushState({"html":'',"pageTitle":'Lotte Happy Tour'},"", url);
							$('.group .container-slide-video li').on('click',function(){
								var title = $(this).find('#title').html();
								console.log('click video');
								data = $(this).data();
								console.log(data);
								html = '<div class="video-warp" > <iframe width="100%" height="610px" src="http://www.youtube.com/embed/'+data.vid+'?autohide=1&modestbranding=1&showinfo=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe> <!--<div class="icon">VIDEOS</div>--> <!--<div class="icon-album">ALBUM</div>--> </div> <div class="video-bar"></div> <div class="video-des"> <h3>'+title+'|</h3> <span class="time">'+data.date+'</span> </div>';
								$('div.container-video').html(html);
								var url = addParameter(curentUrl,'gallery',data.gal_id);
								url = addParameter(url,'video',data.id);
								window.history.pushState({"html":'',"pageTitle":'Lotte Happy Tour'},"", url);
							});
						}
					}
				});
				scrollIntoView('div.video-warp');
			}
		});
		$('.group .container-slide-video li').on('click',function(){
			var title = $(this).find('#title').html();
			console.log('click video');
			data = $(this).data();
			console.log(data);
			html = '<div class="video-warp" > <iframe width="100%" height="610px" src="http://www.youtube.com/embed/'+data.vid+'?autohide=1&modestbranding=1&showinfo=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe> <!--<div class="icon">VIDEOS</div>--> <!--<div class="icon-album">ALBUM</div>--> </div> <div class="video-bar"></div> <div class="video-des"> <h3>'+title+'|</h3> <span class="time">'+data.date+'</span> </div>';
			$('div.container-video').html(html);
			var url = addParameter(curentUrl,'gallery',data.gal_id);
			url = addParameter(url,'video',data.id);
			window.history.pushState({"html":'',"pageTitle":'Lotte Happy Tour'},"", url);
			scrollIntoView('div.video-warp');
		});
		var query = query_string();
		if (typeof(query.gallery) !== 'undefined'){
			var requestAlbum = carouselAlbum.find('li[data-gal_id='+query.gallery+']');
			console.log(requestAlbum);
			if(requestAlbum.length){
				carouselAlbum.jcarousel('scroll',requestAlbum);
				if (typeof(query.video) !== 'undefined'){
					var requestVideo = carouselVideo.find('li[data-id='+query.video+']');
					if(requestVideo.length){
						carouselVideo.jcarousel('scroll',requestVideo);
						
					}
				}
			}
		}
    });
})(jQuery);