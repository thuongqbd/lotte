(function($) {
    $(function() {
        var jcarousel = $('.jcarousel');

        jcarousel
            .on('jcarousel:reload jcarousel:create', function () {
                var carousel = $(this),
                    width = carousel.innerWidth();
                if (width >= 600) {
                    width = width / 3;
                } else if (width >= 350) {
                    width = width / 2;
                }

                carousel.jcarousel('items').css('width', Math.ceil(width) + 'px');
            })
            .jcarousel({
                wrap: 'circular'
            });

        $('.jcarousel-control-prev')
            .jcarouselControl({
                target: '-=1'
            });

        $('.jcarousel-control-next')
            .jcarouselControl({
                target: '+=1'
            });
    });
})(jQuery);


(function($) {
	$(function() {
        var jcarousel = $('.jcarousel.jcarousel1');

        jcarousel
            .on('jcarousel:reload jcarousel:create', function () {
                var carousel = $(this),
                    width = carousel.innerWidth();
                if (width >= 600) {
                    width = width / 3;
                } else if (width >= 350) {
                    width = width / 2;
                }

                carousel.jcarousel('items').css('width', Math.ceil(width) + 'px');
            })
            .jcarousel({
                wrap: 'circular',
				vertical: true
            });
		
        $('.jcarousel-control-prev1')
            .jcarouselControl({
                target: '-=1'
            });

        $('.jcarousel-control-next1')
            .jcarouselControl({
                target: '+=1'
            });
    });
})(jQuery);

(function($) {
    $(function() {
        var jcarousel = $('.jcarousel.jcarousel2');

        jcarousel
            .on('jcarousel:reload jcarousel:create', function () {
                var carousel = $(this),
                    width = carousel.innerWidth();

                if (width >= 600) {
                    width = width / 3;
                } else if (width >= 350) {
                    width = width / 2;
                }

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

                if (width >= 600) {
                    width = width / 3;
                } else if (width >= 350) {
                    width = width / 2;
                }

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
