(function($) {
    $(function() {
		$('.happy-moment-slider .jcarousel li').on('click',function(event){
			var title = $(this).find('#title').html();
			event.preventDefault();
			data = $(this).data();
			h2 = $(this).closest('.container').find('.group.happy-moment-wp-title h2');
			h2.html(title);
			newContent = '';
			if(!$(this).closest('.group.happy-moment-wp').hasClass('spirit')){
				iframe = $(this).closest('.group.happy-moment-wp').find('.happy-moment-clip iframe');
				html = '<iframe width="100%" height="100%" src="http://www.youtube.com/embed/'+data.vid+'?autohide=1&modestbranding=1&showinfo=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
				iframe.replaceWith(html);
			}else{
				img = $(this).closest('.group.happy-moment-wp').find('.happy-moment-clip img#main_photo');
				img.attr('src',data.large);
			}
			
			
		});

    });
})(jQuery);