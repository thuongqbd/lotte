(function($) {
	function updateMeta(url,title,description,image){
		var curentTitle = $('head title').text();
		var metaUrl = $('head meta[property="og:url"]').attr('content');
		var metaTitle = $('head meta[property="og:title"]').attr('content');
		var metaDesc = $('head meta[property="og:description"]');
		var metaImage = $('head meta[property="og:image"]');
		
		$('head meta[property="og:url"]').attr('content',url);
		$('head meta[property="og:title"]').attr('content',title + ' | Khoảnh Khắc Hạnh Phúc - Lotte Happy Tour');
		if(metaDesc.length && description != '')
			$('head meta[property="og:description"]').attr('content',description);
		
		if(metaImage.length)
			$('head meta[property="og:image"]').attr('content',image);
		else
			$('head').append('<meta property="og:image" content="'+image+'">');
		$('head title').text(title + ' - Khoảnh Khắc Hạnh Phúc - Lotte Happy Tour' );
		$('head link[rel="canonical"]').attr('href',url);
	}
	function reloadFacebook(url){
		$('#fb-like-share').html('<div class="fb-like" data-href="'+url+'" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>');
		$('#fb-comments').html('<div class="fb-comments" data-href="'+url+'" data-numposts="10" data-colorscheme="light"></div>');
		if (typeof FB !== 'undefined') {
			FB.XFBML.parse(document.getElementById('fb-like-share'));
			FB.XFBML.parse(document.getElementById('fb-comments'));
		}
	}
	curentUrl = stripQueryStringAndHashFromPath(window.location.href);
    $(function() {
        var carouselVideo = $('.happy-spirit .container-slide-video .myjcarousel');
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

        var carouselAlbum = $('.happy-spirit .container-slide-album .myjcarousel');
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
            var html = '<ul>';
            $.each(data.items, function() {
                html += '<li data-large="' + this.large + '" data-date="' + this.create_at + '" data-id="'+this.id+'" data-gal_id="'+this.gal_id+'"><p id="title" class="hidden">' + this.title + '</p><p id="desc" class="hidden">' + this.desc + '</p><a href="javascript:void(0)" class="content"><img src="' + this.src + '" alt="' + this.title + '"></a></li>';
            });
            html += '</ul>';
            jcarousel.html(html);
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
//							$('div.container-video').fadeOut(100);
							data = JSON.parse(data);
							setup(carouselVideo,data);
							carouselVideo.jcarousel('reload');
//							$('div.container-video').html(data.firstPhoto).fadeIn( 2000 );
							$('.group .container-slide-video li').first().trigger('click');
						}
					}
				});
				
			}
		});
		$('.happy-spirit  .group .container-slide-video').on('click','li',function(){
			$('div.container-video').fadeOut(100);
			var title = $(this).find('#title').html();
			var desc = $(this).find('#desc').html();
			var image = $(this).find('.content img').attr('src');
			title = typeof title != 'undefined'?title:'';
			desc = typeof desc != 'undefined'?desc:'';
			data = $(this).data();
			console.log(data);
			html = '<div class="video-warp photo"> <img src="'+data.large+'" alt="'+data.name+'"></div> <div class="video-bar"></div> <div class="video-des"> <h3>'+title+'</h3><p class="desc">'+desc+'</p></div>';
			$('div.container-video').html(html).fadeIn( 2000 );
			var url = addParameter(curentUrl,'gallery',data.gal_id);
			url = addParameter(url,'photo',data.id);
			window.history.pushState({"html":'',"pageTitle":'Lotte Happy Tour'},"", url);
			updateMeta(url,title,desc,image);
			scrollIntoView('div.video-warp');
			reloadFacebook(url);
			$.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {"action": "spirit_update_facebook", "gallery_id": data.gal_id,"photo_id":data.id}
				});
		});
		var query = query_string();
		if (typeof(query.gallery) !== 'undefined'){
			var requestAlbum = carouselAlbum.find('li[data-gal_id='+query.gallery+']');
			console.log(requestAlbum);
			if(requestAlbum.length){
				carouselAlbum.jcarousel('scroll',requestAlbum);
				if (typeof(query.photo) !== 'undefined'){
					var requestPhoto = carouselVideo.find('li[data-id='+query.photo+']');
					if(requestPhoto.length){
						carouselVideo.jcarousel('scroll',requestPhoto);
						
					}
				}
			}
		}
    });
})(jQuery);