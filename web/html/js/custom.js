$(document).ready(function(){
    if (is_touch_device()) {
        $('body').addClass('touch-device');
    }
    // Images to background images
    responsiveBgImagesInit = function () {

        var ResponsiveBackgroundImage = /** @class */ (function () {
            function ResponsiveBackgroundImage(element) {
                var _this = this;
                this.element = element;
                this.img = element.querySelector('img');
                this.src = '';
                this.img.addEventListener('load', function () {
                    _this.update();
                });
                if (this.img.complete) {
                    this.update();
                }
            }
            ResponsiveBackgroundImage.prototype.update = function () {
                var src = typeof this.img.currentSrc !== 'undefined' ? this.img.currentSrc : this.img.src;
                if (this.src !== src) {
                    this.src = src;
                    this.element.style.backgroundImage = 'url("' + this.src + '")';
                }
            };
            return ResponsiveBackgroundImage;
        }());

        var elements = document.querySelectorAll('[data-responsive-background-image]');
        for (var i = 0; i < elements.length; i++) {
            new ResponsiveBackgroundImage(elements[i]);
        }

    };
    responsiveBgImagesInit();

    // Calc dropdown menu position
    $('.dropdown').on('show.bs.dropdown', function(e){
        var containerObj = $('.container:first');
        var containerOffset = containerObj.offset();
        var parentMenu = $(this);
        var offsetParentMenu = parentMenu.offset();
        var dropdownMenu = $(this).find('.dropdown-menu');
        L1 = containerOffset.left + containerObj.width() - offsetParentMenu.left; // length from current menu item to right side
        var totalWidth = 0; // total width of popup-dropdown menu
        parentMenu.find('div').each(function() {
            if($(this).hasClass('col3')){
                totalWidth = totalWidth + 480; // CSS constant
            }
            if ($(this).hasClass('col2')) {
                totalWidth = totalWidth + 320; // CSS constant
            }
            if ($(this).hasClass('col1')){
                totalWidth = totalWidth + 160; // CSS constant
            }
        });
        console.log('L1='+L1+' totalWidth='+totalWidth);
        if (L1 < totalWidth){
            console.log('delta='+(L1 - totalWidth - 27));
            dropdownMenu.css('left', L1 - totalWidth - 27); // left padding + right padding = 30
        }
    });

    //$('.dropdown').on('hide.bs.dropdown', function(e){
        //$(this).find('.dropdown-menu').first().stop(true, true).slideUp(100);
    //});

    // Home page slider
    var slickCnt = 0;
    $('.main-slider').slick({
        dots: false,
        arrows: false,
        infinite: true,
        speed: 500,
        //swipe: true,
        //lazyLoad: 'ondemand',
        slidesToShow: 1,
        slidesToScroll: 1,
        fade: true,
        variableWidth: false,
        variableHeight: false,
        //cssEase: 'linear',
        //prevArrow: $('.prev'),
        //nextArrow: $('.next'),
        autoplay:false,
        autoplaySpeed:3000,
        asNavFor: '.slider-nav',
        //initialSlide: initialSlide
        responsive: [{
            breakpoint: 992,
            settings: {
                dots: true
            }
        }]
    });


    $('.main-slider').closest('.slider-container').on('mouseover, mouseenter', function(){
        $('.main-slider').slick('slickPause');
        //!!!$('.main-slider').addClass('hover');
    });
    $('.main-slider').closest('.slider-container').on('mouseout, mouseleave', function(){
        $('.main-slider').removeClass('hover');
        //!!!$('.main-slider').slick('slickPlay');
    });

    $('.slider-nav')
        .on('init', function(){
            slickCnt++;
        }).slick({
            infinite:true,
            slidesToShow: 4,
            slidesToScroll: 1,
            //slidesPerRow:4,
            asNavFor: '.main-slider',
            dots: false,
            arrows: false,
            centerMode: false,
            focusOnSelect: true
    });
    /*$('.slider-nav .slick-slide').on('click', function (event) {
        $('.main-slider').slick('slickGoTo', $(this).data('slickIndex'));
    });*/

    // Timeline slider
    var slickNN = 0;
    $('.timeline-slider').slick({
        dots: false,
        arrows: false,
        infinite: true,
        speed: 500,
        //swipe: true,
        lazyLoad: 'ondemand',
        slidesToShow: 1,
        slidesToScroll: 1,
        fade: true,
        //cssEase: 'linear',
        //prevArrow: $('.prev'),
        //nextArrow: $('.next'),
        pauseOnHover:false,
        autoplay:false,
        autoplaySpeed:3500,
        asNavFor: '.slider-nav-timeline'
       /*customPaging : function(slider, i) {
            var sDate = $('.timeline-slider').find('.slide'+(i+1)).data('date');
            return sDate;
        }*/
    });
    if($('body').hasClass('touch-device')){
        $('.timeline-img-bg, .timeline-img').addClass('brightness');
    }

    /*var timelineVisible = false;
    var timelineHover = false;
    $('.slider-nav-timeline-container').on('mouseover, mouseenter', function() {
        timelineHover = true;
    });
    $('.slider-nav-timeline-container').on('mouseout, mouseleave', function() {
        timelineHover = false;
    });*/
    /*$('.timeline-slider').on('mouseover, mouseenter', $.debounce(100, function(){
            $('.timeline-slider').slick('slickPause');
            $('.slider-nav-timeline-container').fadeTo(300, 1);
            $('.timeline-img-bg, .timeline-img').addClass('brightness');
            timelineVisible = true;
        })
    );*/
    /*$('.timeline-slider').on('mouseover', function(){
        timelineVisible = true;
        //timelineHover = true;
        $('.timeline-slider').slick('slickPause');
        $('.slider-nav-timeline-container').fadeTo(200, 1, function(){
            $('.timeline-img-bg, .timeline-img').addClass('brightness');
        });
    });*/
    /*$('.timeline-slider').on('mouseleave', $.debounce(500, function(){
            console.log('mouseleave');
            timelineVisible = false;
            setTimeout(function() {
                if(!timelineVisible && !timelineHover){
                    $('.timeline-img-bg, .timeline-img').removeClass('brightness');
                    $('.slider-nav-timeline-container').fadeTo(200, 0);
                    //!!!$('.timeline-slider').slick('slickPlay');
                }
            }, 50);
        })
    );*/
    /*$('.timeline-slider').on('mouseleave', function(){
        console.log('mouseleave');
        timelineVisible = false;
        setTimeout(function() {
            if(!timelineVisible && !timelineHover){
                $('.timeline-img-bg, .timeline-img').removeClass('brightness');
                $('.slider-nav-timeline-container').fadeTo(200, 0);
                //!!!$('.timeline-slider').slick('slickPlay');
            }
        }, 50);
    });*/



    $('.timeline-slider').closest('.slider-container').on('mouseover, mouseenter', $.debounce(195, function () {
        $('.timeline-slider').slick('slickPause');
        $(this).addClass('hover');
    }));
    $('.timeline-slider').closest('.slider-container').on('mouseout, mouseleave', $.debounce(195, function () {
        $(this).removeClass('hover');
        $('.timeline-slider').slick('slickPlay');
    }));


    // Timeline slider navigation
    $('.slider-nav-timeline')
        .on('init', function(){
            slickNN++;
        }).slick({
        slidesToShow: 15,
        slidesToScroll: 5,
        asNavFor: '.timeline-slider',
        dots: false,
        arrows: false,
        infinite: false,
        focusOnSelect: true,
        pauseOnHover: true,
        autoplay:false,
        autoplaySpeed:3000,
        //variableWidth: true
        centerMode: false,
        centerPadding: 50,
        responsive: [{
            breakpoint: 1310,
            settings: {
                slidesToShow: 12
            }

        }, {
            breakpoint: 1280,
            settings: {
                slidesToShow: 11
            }

        }, {
            breakpoint: 1090,
            settings: {
                slidesToShow: 9
            }

        }, {
            breakpoint: 992,
            settings: {
                slidesToShow: 6,
                arrows: false,
                slidesToScroll: 1
            }
        }, {

            breakpoint: 900,
            settings: {
                slidesToShow: 6,
                arrows: false,
                slidesToScroll: 1
            }

        }, {

            breakpoint: 768,
            settings: {
                centerMode: true,
                slidesToShow: 5,
                arrows: true,
                slidesToScroll: 1
            }

        }, {

            breakpoint: 520,
            settings: {
                centerMode: true,
                slidesToShow: 4,
                arrows: true,
                slidesToScroll: 1
            }

        }, {

            breakpoint: 400,
            settings: {
                centerMode: true,
                slidesToShow: 3,
                arrows: true,
                slidesToScroll: 1
            }

        },{

            breakpoint: 350,
            settings: {
                centerMode: true,
                slidesToShow: 3,
                arrows: true,
                slidesToScroll: 1
            }

        }]
    });
    $('.slider-nav-timeline').on('beforeChange', function(event, slick, currentSlide, nextSlide){
        $('.timeline-slider').slick('slickGoTo', nextSlide);
    });


    $('.square-slider').on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
        //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
        var i = (currentSlide ? currentSlide : 0) + 1;
        $('.square-slider-counter').text(i + ' / ' + slick.slideCount);
    });
    $('.square-slider').slick({
        dots: true,
        arrows: false,
        infinite: true,
        speed: 500,
        //swipe: true,
        //lazyLoad: 'ondemand',
        slidesToShow: 1,
        slidesToScroll: 1,
        fade: true,
        //cssEase: 'linear',
        //prevArrow: $('.prev'),
        //nextArrow: $('.next'),
        autoplay:true,
        autoplaySpeed:2500
        //initialSlide: initialSlide
    });

    if($('.general-slider').find('.slide').length > 1) {
        $('.general-slider').on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
            //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
            var i = (currentSlide ? currentSlide : 0) + 1;
            $('.square-slider-counter').text(i + ' / ' + slick.slideCount);
        });
    }
    $('.general-slider').slick({
        lazyLoad: 'ondemand'
    });

    $('.history-slider').slick({
        dots: false,
        arrows: false,
        infinite: false,
        speed: 500,
        //swipe: true,
        //lazyLoad: 'ondemand',
        slidesToShow: 10,
        slidesToScroll: 1,
        fade: false,
        //cssEase: 'linear',
        //prevArrow: $('.prev'),
        //nextArrow: $('.next'),
        autoplay:true,
        autoplaySpeed:2500,
        pauseOnHover: true,
        responsive: [{

            breakpoint: 1280,
            settings: {
                slidesToShow: 10
            }

        }, {

            breakpoint: 1090,
            settings: {
                slidesToShow: 8
            }

        }, {

            breakpoint: 900,
            settings: {
                slidesToShow: 6
            }

        }, {

            breakpoint: 760,
            settings: {
                slidesToShow: 4
            }

        }, {

            breakpoint: 520,
            settings: {
                slidesToShow: 3
            }

        }, {

            breakpoint: 400,
            settings: {
                slidesToShow: 2
            }

        },{

            breakpoint: 350,
            settings: {
                slidesToShow: 1
            }

        }]
    });

    $('.services-slider').slick({
        dots: false,
        arrows: false,
        infinite: true,
        speed: 500,
        //swipe: true,
        //lazyLoad: 'ondemand',
        slidesToShow: 8,
        slidesToScroll: 1,
        fade: false,
        //cssEase: 'linear',
        //prevArrow: $('.prev'),
        //nextArrow: $('.next'),
        variableWidth: false,
        autoplay:true,
        autoplaySpeed:2500,
        pauseOnHover: true,
        responsive: [{

            breakpoint: 1280,
            settings: {
                slidesToShow: 8
            }

        }, {

            breakpoint: 1090,
            settings: {
                slidesToShow: 7
            }

        }, {

            breakpoint: 900,
            settings: {
                slidesToShow: 6
            }

        }, {

            breakpoint: 760,
            settings: {
                slidesToShow: 4
            }

        }, {

            breakpoint: 520,
            settings: {
                slidesToShow: 3
            }

        }, {

            breakpoint: 400,
            settings: {
                slidesToShow: 2
            }

        },{

            breakpoint: 350,
            settings: {
                slidesToShow: 1
            }

        }]
    });
    $('#services-slider-acryl').hide();

    // Switch Acryl and Glass services sliders
    $('.services-filter').find('a').on('click', $.debounce(500, function(){
            if($(this).parent().hasClass('active')){
                return false;
            }
            var oldFilter = $('.services-filter').find('.active > a').data('cat');
            var filter = $(this).data('cat');
            $('.list-inline-item').removeClass('active');
            $(this).parent().addClass('active');
            /*
             $('.services-slider').slick('slickUnfilter');
             $('.services-slider').slick('slickFilter', function() {
             return $('[data-cat="'+filter+'"]', this).length === 1;
             });
             $(this).parent().addClass('active');*/
            $('#services-slider-'+oldFilter).fadeOut(0, function(){
                if($('#services-slider-' + filter).hasClass('services-slider')) {
                    $('#services-slider-' + filter).slick('refresh');
                }
                $('#services-slider-'+filter).fadeIn(500, function(){
                    if($('#services-slider-'+filter).hasClass('services-slider')) {
                        $('#services-slider-' + filter).slick('slickPlay');
                    }
                });
            });
        })
    );


    // Logos
    $('.logos-slider').slick({
        dots: false,
        arrows: false,
        infinite: false,
        speed: 500,
        //swipe: true,
        //lazyLoad: 'ondemand',
        slidesToShow: 6,
        slidesToScroll: 1,
        fade: false,
        /*variableWidth: true,
        variableHeight: true,*/
        centerMode: false,
        autoplay:true,
        autoplaySpeed:2500,
        responsive: [{
            breakpoint: 1280,
            settings: {
                slidesToShow: 6
            }

        }, {
            breakpoint: 1090,
            settings: {
                slidesToShow: 5
            }

        }, {

            breakpoint: 900,
            settings: {
                slidesToShow: 4
            }

        }, {

            breakpoint: 760,
            settings: {
                slidesToShow: 3
            }

        }, {

            breakpoint: 520,
            settings: {
                slidesToShow: 2
            }

        }, {

            breakpoint: 400,
            settings: {
                slidesToShow: 2
            }

        },{

            breakpoint: 350,
            settings: {
                slidesToShow: 1
            }

        }]
    });

    
    // Searchbox animation effect
    $('.searchbox-btn').on('click', function(){
        var deltaFix = 0;
        if ($( window ).width() > 1000) deltaFix = 43;
        var newWidth = $('.searchbox-form').width() - 70 - deltaFix;
        $('.searchbox').animate({ width: newWidth+'px' }, function(){
            $('.searchbox-close').fadeIn(400);
            $('.searchbox-form').addClass('active');
        });

    });

    $('.mobile-logo-navbar-container').find('.searchbox-btn').off().on('click', function(){
        var newWidth = $('.mobile-logo-navbar-container').width() - 70;
        //$('.searchbox-container').css('width','100%');
        $('.searchbox-container').animate({ width: '100%' });
        $('.searchbox').animate({ width: newWidth+'px' }, function(){
            $('.searchbox-form').addClass('active');
            $('.searchbox-close').fadeIn(400);
        });
    });

    $('.searchbox-close').on('click', function(){
        $('.searchbox-close').fadeOut(400, function(){
            $('.searchbox').animate({ width:'0' });
            $('.searchbox-form').removeClass('active');
            $('.searchbox-container').css('width','');
        });
    });

    // Animation efects by wow.js + animate.css
    if(jQuery.isFunction(jQuery.fn.WOW)) {
        wow = new WOW(
            {
                animateClass: 'animated',
                offset: 100
            }
        );
        wow.init();
    }

    if($('body.nav-dotted').length){
        var dottedMenu = $('<div id="nav-dotes"><ul></ul></div>');
        $(dottedMenu).insertAfter('#outer-wrap');
        $('section').each(function(){
            sectionDescription = $(this).data('slide');
            if(sectionDescription.length > 1){
                $('#nav-dotes > ul').append('<li data-slide="'+sectionDescription+'">'+sectionDescription+'</li>');
            }
        });

        $('#nav-dotes').find('li').click(function (event) {
            event.preventDefault();
            $('#nav-dotes').find('li').removeClass('active');
            $(this).addClass('active');
            goToByScroll($(this).data('slide'));
        });

        //Setup waypoints plugin
        var waypoints = $('section').waypoint(function(direction) {
            dataslide = $(this.element).data('slide');
            console.log($(this.element).data('slide'));
            console.log(this.element.class + ' hit 25% from top of window =>'+dataslide);
            $('#nav-dotes').find('li').removeClass('active');
            $('#nav-dotes li[data-slide="' + dataslide + '"]').addClass('active');
        }, {
            offset: '35%'
        });

        //waypoints doesnt detect the first slide when user scrolls back up to the top so we add this little bit of code, that removes the class
        //from navigation link slide 2 and adds it to navigation link slide 1.
        $(window).scroll(function () {
            if ($(window).scrollTop() <= $('.site-header').height() + 2) {
                $('#nav-dotes').find('li').removeClass('active');
                $('#nav-dotes').find('li:first').addClass('active');
            }
        });

    }

    if($('.anchors-menu').length){
        var anchorsMenu = $('<nav class="nav flex-column"></nav>');
        $('.anchors-menu').append(anchorsMenu);
        $('.anchor').each(function(){
            $(anchorsMenu).append('<a class="nav-link" href="#'+$(this).attr('id')+'">'+$(this).text()+'</a>');
        });
        $('.anchors-menu').find('a').on('click', function (event) {
            // if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 800);
                return false;
            }
            // }
            return false;
        });

    }

    $('.site-body').find('.corner-link > a').addClass('underlined');
    $('p').find('a').addClass('underlined');
    $('.site-footer').find('a').addClass('underlined');

    // matchHeight makes the height of all selected elements exactly equal
    if(jQuery.isFunction(jQuery.fn.matchHeight)) {
        //$.fn.matchHeight._maintainScroll = true;
        //$.fn.matchHeight._throttle = 1000;
        if ($('.box-menu').length) {
            $('.box-menu').matchHeight();
        }
        if ($('.icon-teaser').length) {
            //alert($('.icon-teaser').length);
            $('.icon-teaser').find('h3').matchHeight();
        }
        if ($('.icon-teaser-v2').length) {
            $('.icon-teaser-v2').find('h3').matchHeight();
        }
        if ($('.news-item').length) {
            $('.news-item').find('.news-title').matchHeight();
            $('.news-item').find('.news-text').matchHeight();
        }
    }

    $('.has-submenu').on('click', function() {
        $(this).toggleClass('active');
    });

    // totop var
    var totop = $('#totop');
    var bodyScroll = $('html,body');
    totop.on("click", function(event) {
        event.preventDefault();
        bodyScroll.animate({
            scrollTop: 0
        }, 800);
    });

    if(jQuery.isFunction(jQuery.fn.hmbrgr)) {
        var burgerBtn = $('.hmbrgr').hmbrgr({
            width: 30, 		// optional - set hamburger width
            height: 19, 		// optional - set hamburger height
            speed: 200,		// optional - set animation speed
            barHeight: 3,			// optional - set bars height
            barRadius: 0,			// optional - set bars border radius
            barColor: '#1a1a1a'	// optional - set bars color
        });
        $('.site-overlay').on('click', function(){
            $('.hmbrgr').trigger('click');
            $("body").removeClass('pushy-open-left')
        });
    }

    $('.btn-r-menu').on('click', function(){
        var rightNav = '<div class="'+$('.right-nav-container').attr('class')+' popup-nav">'+$('.right-nav-container').html()+'</div>';
        $('#outer-wrap').append(rightNav);
        $('.popup-nav').fadeTo( "slow" , 0.99);
        $('.popup-nav').animate({ left: '0' }, function(){
            $('.btn-done').on('click', function(){
                $('.popup-nav').animate({ left: '100vw' }, function(){
                    $('.popup-nav').remove();
                });
            });
        });
    });

    $( window ).on ('load', function() {

    });
    $( window ).on ('resize', function() {
        $('.searchbox-close').trigger('click');
        var windowWidth = $( window ).width();
        //console.log(windowWidth);
        if (windowWidth <= 767) {
            $('.h-footer').off().on('click', function(event) {
                return true;
            });
        } else {
            $('.h-footer').on('click', function(event) {
                event.preventDefault();
                return false;
            });
            if($("body").hasClass('pushy-open-left')){
                $('.hmbrgr').trigger('click');
            }
            //$("body").removeClass('pushy-open-left');
            //$('.hmbrgr').removeClass('cross').removeClass('expand');
        }
    });
    $( window ).on('scroll', function(){
        if ($(window).scrollTop() > 350) {
            totop.fadeIn(500);
        } else {
            totop.fadeOut(300);
        }
    });
    $( window ).scroll();
    $( window ).resize();
});

function goToByScroll(dataslide) {
    var nav = $('section[data-slide="' + dataslide + '"]');
    if (nav.length) {
        $('html,body').animate({
            scrollTop: nav.offset().top
        }, 2000, 'easeInOutQuint');
    }
}
// Detect a Touch Screen
function is_touch_device() {
    return (('ontouchstart' in window)
    || (navigator.MaxTouchPoints > 0)
    || (navigator.msMaxTouchPoints > 0));
}

// decrypt helper function
function decryptCharcode(n,start,end,offset) {
    n = n + offset;
    if (offset > 0 && n > end) {
        n = start + (n - end - 1);
    } else if (offset < 0 && n < start) {
        n = end - (start - n - 1);
    }
    return String.fromCharCode(n);
}
// decrypt string
function decryptString(enc,offset) {
    var dec = "";
    var len = enc.length;
    for(var i=0; i < len; i++) {
        var n = enc.charCodeAt(i);
        if (n >= 0x2B && n <= 0x3A) {
            dec += decryptCharcode(n,0x2B,0x3A,offset);	// 0-9 . , - + / :
        } else if (n >= 0x40 && n <= 0x5A) {
            dec += decryptCharcode(n,0x40,0x5A,offset);	// A-Z @
        } else if (n >= 0x61 && n <= 0x7A) {
            dec += decryptCharcode(n,0x61,0x7A,offset);	// a-z
        } else {
            dec += enc.charAt(i);
        }
    }
    return dec;
}
// decrypt spam-protected emails
function linkTo_UnCryptMailto(s) {
    location.href = decryptString(s,3);
}