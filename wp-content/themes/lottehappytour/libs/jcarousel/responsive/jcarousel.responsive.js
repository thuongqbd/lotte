//(function($) {
//    $(function() {
//        var jcarousel = $('.jcarousel');
//
//        jcarousel
//            .on('jcarousel:reload jcarousel:create', function () {
//                var carousel = $(this),
//                    width = carousel.innerWidth();
//                if (width >= 600) {
//                    width = width / 3;
//                } else if (width >= 350) {
//                    width = width / 2;
//                }
//
//                carousel.jcarousel('items').css('width', Math.ceil(width) + 'px');
//            })
//            .jcarousel({
//                wrap: 'circular'
//            });
//
//        $('.jcarousel-control-prev')
//            .jcarouselControl({
//                target: '-=1'
//            });
//
//        $('.jcarousel-control-next')
//            .jcarouselControl({
//                target: '+=1'
//            });
//    });
//})(jQuery);


(function($) {
	$(function() {
        var jcarousel = $('.jcarousel.jcarousel1');
         var d = $( window ).innerWidth();
        jcarousel
            .on('jcarousel:reload jcarousel:create', function () {
                var carousel = $(this),
                    width = carousel.innerWidth();
                    //console.log(width);
                    if (width >= 582) {
                        width = width / 3;
                    } else if(width <= 251){
                        width = width / 1;
                    } else{
                        width = width / 2;
                    }
//                if(width >= 480 && width < 721)
//                {
//                    width = width / 3;
//                }
//                if (width < 251) {
//                    width = width / 2;
//                }
//                if (width >= 721) {
//                    width = width/1;
//                } else if(width >= 480 && width < 721){
//                    width = width / 3;
//                } else if(width <480){
//                    width = width /2;
//                }else{width = width/1}
//                if (width >= 600) {
//                    width = width / 3;
//                } else if (width >= 350) {
//                    width = width / 2;
//                } 
//                else if(width) {width = width/2}

                carousel.jcarousel('items').css('width', Math.ceil(width) + 'px');
            });
            if(d <= 768)
            {
                jcarousel.jcarousel({
                    wrap: 'circular',
                    vertical: false
                });
            }
            else
            {
                jcarousel.jcarousel({
                    wrap: 'circular',
                    vertical: true
                });
            }
            
		
        $('.jcarousel-control-prev1')
            .on('jcarouselcontrol:active', function() {
                    $(this).removeClass('inactive');
            })
            .on('jcarouselcontrol:inactive', function() {
                $(this).addClass('inactive');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $('.jcarousel-control-next1')
            .on('jcarouselpagination:active', 'a', function() {
                $(this).addClass('active');
            })
            .on('jcarouselpagination:inactive', 'a', function() {
                $(this).removeClass('active');
            })
            .on('click', function(e) {
                e.preventDefault();
            })
            .jcarouselControl({
                target: '+=1'
            });
    });
})(jQuery);

(function($) {
    $(function() {
        var jcarousel2 = $('.jcarousel.jcarousel2');

        jcarousel2
            .on('jcarousel:reload jcarousel:create', function () {
                var carousel = $(this),
                    width = carousel.innerWidth();
                    //console.log('as'+width);
                    width = width / 3;

                carousel.jcarousel('items').css('width', Math.ceil(width) + 'px');
            })
            .jcarousel({
                wrap: 'circular'
            });

        $('.jcarousel-control-prev2')
            .jcarouselControl({
                target: '-=1'
            });

        $('.jcarousel-control-next2')
            .jcarouselControl({
                target: '+=1'
            });
    });
})(jQuery);


(function($) {
    $(function() {
        var jcarousel = $('.jcarousel.jcarousel3');

        jcarousel
            .on('jcarousel:reload jcarousel:create', function () {
                var carousel = $(this),
                    width = carousel.innerWidth();
                   // console.log('b  '+width);
//                if (width >= 600) {
//                    width = width / 3;
//                } else if (width >= 350) {
                    if(width >= 600)
                        width = width / 3;
                    else
                        width = width / 2;
//                }

               carousel.jcarousel('items').css('width', Math.ceil(width) + 'px');
            })
            .jcarousel({
                wrap: 'circular'
            });

        $('.jcarousel-control-prev3')
            .jcarouselControl({
                target: '-=1'
            });

        $('.jcarousel-control-next3')
            .jcarouselControl({
                target: '+=1'
            });
    });
})(jQuery);


(function($) {
    $(function() {
        var jcarousel = $('.jcarouselheader-mobile');

        jcarousel
            .on('jcarousel:reload jcarousel:create', function () {
                var carousel = $(this),
                    width = carousel.innerWidth();
               carousel.jcarousel('items').css('width', Math.ceil(width) + 'px');
            })
            .jcarousel({
                wrap: 'circular'
            });

        $('.jcarousel-control-prev-mobile')
            .jcarouselControl({
                target: '-=1'
            });

        $('.jcarousel-control-next-mobile')
            .jcarouselControl({
                target: '+=1'
            });
    });
})(jQuery);


(function($) {
    $(function() {
        var jcarousel = $('.jcarouselheader-category');

        jcarousel
            .on('jcarousel:reload jcarousel:create', function () {
                var carousel = $(this),
                    width = carousel.innerWidth();
               carousel.jcarousel('items').css('width', Math.ceil(width) + 'px');
            })
            .jcarousel({
                wrap: 'circular'
            });

        $('.jcarousel-control-prev-category')
            .jcarouselControl({
                target: '-=1'
            });

        $('.jcarousel-control-next-category')
            .jcarouselControl({
                target: '+=1'
            });
    });
})(jQuery);
