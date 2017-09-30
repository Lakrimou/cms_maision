(function ($) {

    "use strict";


    //Hide Loading Box (Preloader)
    function handlePreloader() {
        if ($('.preloader').length) {
            $('.preloader').delay(500).fadeOut(500);
        }
    }


    //Update Header Style + Scroll to Top
    function headerStyle() {
        if ($('.main-header').length) {
            var windowpos = $(window).scrollTop();
            if (windowpos >= 50) {
                $('.main-header').addClass('fixed-header');
                $('.scroll-to-top').fadeIn(300);
            } else {
                $('.main-header').removeClass('fixed-header');
                $('.scroll-to-top').fadeOut(300);
            }
        }
    }

    headerStyle();


    //Add Onepage Nav
    if ($('.one-page-nav').length) {
        $('.one-page-nav').onePageNav({
            scrollChange: function ($currentListItem) {
                // console.log($currentListItem.prevObject.selector);
            }
        });
    }







    //Submenu Dropdown Toggle
    if ($('.main-header li.dropdown > ul').length) {
        $('.main-header li.dropdown').append('<div class="dropdown-btn"></div>');

        //Dropdown Button
        $('.main-header li.dropdown .dropdown-btn').on('click', function () {
            $(this).prev('ul').slideToggle(500);
        });
    }


    //Main Slider
    if ($('.main-slider .tp-banner').length) {

        jQuery('.main-slider .tp-banner').show().revolution({
            dottedOverlay: "none",
            delay: 10000,
            startwidth: 1200,
            startheight: 750,
            hideThumbs: 200,

            thumbWidth: 80,
            thumbHeight: 50,
            thumbAmount: 5,

            navigationType: "none",
            navigationArrows: "0",
            navigationStyle: "preview4",

            touchenabled: "on",
            onHoverStop: "off",

            swipe_velocity: 0.7,
            swipe_min_touches: 1,
            swipe_max_touches: 1,
            drag_block_vertical: false,

            parallax: "mouse",
            parallaxBgFreeze: "on",
            parallaxLevels: [7, 4, 3, 2, 5, 4, 3, 2, 1, 0],

            keyboardNavigation: "off",

            navigationHAlign: "center",
            navigationVAlign: "bottom",
            navigationHOffset: 0,
            navigationVOffset: 20,

            soloArrowLeftHalign: "left",
            soloArrowLeftValign: "bottom",
            soloArrowLeftHOffset: 0,
            soloArrowLeftVOffset: 0,

            soloArrowRightHalign: "right",
            soloArrowRightValign: "bottom",
            soloArrowRightHOffset: 0,
            soloArrowRightVOffset: 0,

            shadow: 0,
            fullWidth: "off",
            fullScreen: "off",

            spinner: "spinner4",

            stopLoop: "off",
            stopAfterLoops: -1,
            stopAtSlide: -1,

            shuffle: "off",

            autoHeight: "off",
            forceFullWidth: "on",

            hideThumbsOnMobile: "on",
            hideNavDelayOnMobile: 1500,
            hideBulletsOnMobile: "on",
            hideArrowsOnMobile: "on",
            hideThumbsUnderResolution: 0,

            hideSliderAtLimit: 0,
            hideCaptionAtLimit: 0,
            hideAllCaptionAtLilmit: 0,
            startWithSlide: 0,
            videoJsPath: "",
            fullScreenOffsetContainer: ""
        });


    }


    //Tabs Box
    if ($('.tabs-box').length) {

        //Tabs
        $('.tabs-box .tab-btn').on('click', function (e) {
            e.preventDefault();
            var target = $($(this).attr('href'));
            $('.tabs-box .tab-btn').removeClass('active-btn');
            $(this).addClass('active-btn');
            $('.tabs-box .tab').fadeOut(0);
            $('.tabs-box .tab').removeClass('active-tab');
            $(target).fadeIn(300);
            $(target).addClass('active-tab');
            var windowWidth = $(window).width();
            if (windowWidth <= 700) {
                $('html, body').animate({
                    scrollTop: $('.tabs-box').offset().top
                }, 1000);
            }
        });

    }


    //Three Column Slider
    if ($('.column-carousel.three-column').length) {
        $('.column-carousel.three-column').owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            autoplayHoverPause: false,
            autoplay: 5000,
            smartSpeed: 700,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                800: {
                    items: 2
                },
                1024: {
                    items: 3
                },
                1100: {
                    items: 3
                }
            }
        });
    }

    //Testimonials Slider (One COlumn Testimonials)
    if ($('.testimonial-slider .slider').length) {
        $('.testimonial-slider .slider').bxSlider({
            adaptiveHeight: true,
            auto: true,
            controls: true,
            pause: 5000,
            speed: 500,
            pager: false,
            mode: 'fade'
        });
    }


    //Video Gallery Slider
    if ($('.video-gallery').length) {
        var slider = new MasterSlider();

        slider.setup('video-gallery', {
            width: 1000,
            height: 532,
            space: 5,
            shuffle: true,
            loop: true,
            view: 'parallaxMask'
        });

        slider.control('arrows');
        slider.control('thumblist', {autohide: false, dir: 'h'});
    }


    //LightBox / Fancybox
    if ($('.lightbox-image').length) {
        $('.lightbox-image').fancybox();
    }


    //Gallery Filters
    if ($('.filter-list').length) {
        $('.filter-list').mixItUp({});
    }


    //Contact Form Validation
    if ($('#contact-form').length) {
        $('#contact-form').validate({
            rules: {
                username: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                subject: {
                    required: true
                },
                message: {
                    required: true
                }
            }
        });
    }


    // Google Map Settings
    if ($('#map-location').length) {
        var map;
        map = new GMaps({
            el: '#map-location',
            zoom: 14,
            scrollwheel: false,
            //Set Latitude and Longitude Here
            lat: -37.817085,
            lng: 144.955631
        });

        //Add map Marker
        map.addMarker({
            lat: -37.817085,
            lng: 144.955631,
            infoWindow: {
                content: '<p style="text-align:center;"><strong>Envato</strong><br>Melbourne VIC 3000, Australia</p>'
            }

        });
    }


    // Scroll to top
    if ($('.scroll-to-top').length) {
        $(".scroll-to-top").on('click', function () {
            // animate
            $('html, body').animate({
                scrollTop: $('html, body').offset().top
            }, 1000);

        });
    }


    // Elements Animation
    if ($('.wow').length) {
        var wow = new WOW(
            {
                boxClass: 'wow',      // animated element css class (default is wow)
                animateClass: 'animated', // animation css class (default is animated)
                offset: 0,          // distance to the element when triggering the animation (default is 0)
                mobile: true,       // trigger animations on mobile devices (default is true)
                live: true       // act on asynchronously loaded content (default is true)
            }
        );
        wow.init();
    }

    /* ==========================================================================
     When document is Scrollig, do
     ========================================================================== */

    $(window).on('scroll', function () {
        headerStyle();
    });

    /* ==========================================================================
     When document is loading, do
     ========================================================================== */

    $(window).on('load', function () {
        handlePreloader();
    });


})(window.jQuery);



// ================== on views===================


$.fn.isOnScreen = function() {

    var win = $(window);

    var viewport = {
        top: win.scrollTop(),
        left: win.scrollLeft()
    };
    viewport.right = viewport.left + win.width();
    viewport.bottom = viewport.top + win.height();

    var bounds = this.offset();
    bounds.right = bounds.left + this.outerWidth();
    bounds.bottom = bounds.top + this.outerHeight();

    return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
}

$(document).ready(function(){
    $(window).scroll(function(){
        if ($('#propo').isOnScreen() ) {

            $('.background.gallery').hide()
            $('.background.about').show()
            $('.background.annonce').hide()
            $('.background.contact').hide()
            $('.background.service').hide()
            $('.motif-container').attr('data-pour','background-propo');
            $('#backgroundcolor,#background-img').attr('data-pour','background-propo');

        }else if($('#service').isOnScreen()){
            $('.background.gallery').hide()
            $('.background.about').hide()
            $('.background.annonce').hide()
            $('.background.contact').hide()
            $('.background.service').show()
            $('#backgroundcolor,#background-img').attr('data-pour','background-service');


        } else if($('.sectionannonce').isOnScreen()){
            $('.background.gallery').hide()
            $('.background.about').hide()
            $('.background.annonce').show()
            $('.background.contact').hide()
            $('.background.service').hide()
            $('.motif-container').attr('data-pour','background-annonce');
            $('#backgroundcolor,#background-img').attr('data-pour','background-annonce');

        }else if($('.gallery-section').isOnScreen()){

            $('.background.gallery').show()
            $('.background.about').hide()
            $('.background.annonce').hide()
            $('.background.contact').hide()
            $('.background.service').hide()
            $('.motif-container').attr('data-pour','background-gallery');
            $('#backgroundcolor,#background-img').attr('data-pour','background-gallery');
        }
        else if($('.contact-section').isOnScreen()){
            $('.background.gallery').hide()
            $('.background.about').hide()
            $('.background.annonce').hide()
            $('.background.contact').show()
            $('.background.service').hide()
            $('.motif-container').attr('data-pour','background-contact');
            $('#backgroundcolor,#background-img').attr('data-pour','background-contact');
        }



    });
});

// --------------------------------------------------------resize image----------------------------------------------------------

                                            // ------------------part1----------------
            window.uploadPhotos = function(url, dataId){




                // Read in file
                var file = event.target.files[0];
                console.log("dd")
                // Ensure it's an image
                if(file.type.match(/image.*/)) {
                    console.log('An image has been loaded');

                    // Load the image
                    var reader = new FileReader();
                    reader.onload = function (readerEvent) {
                        var image = new Image();
                        image.onload = function (imageEvent) {

                            // Resize the image
                            var canvas = document.createElement('canvas'),
                                max_size = 1000,// TODO : pull max size from a site config
                                width = image.width,
                                height = image.height;
                            if (width > height) {
                                if (width > max_size) {
                                    height *= max_size / width;
                                    width = max_size;
                                }
                            } else {
                                if (height > max_size) {
                                    width *= max_size / height;
                                    height = max_size;
                                }
                            }
                            canvas.width = width;
                            canvas.height = height;
                            canvas.getContext('2d').drawImage(image, 0, 0, width, height);
                            var dataUrl = canvas.toDataURL('image/jpeg');
                            var resizedImage = dataURLToBlob(dataUrl);
                            $.event.trigger({
                                type: "imageResized",
                                blob: resizedImage,
                                url: dataUrl

                            });
                            $(dataId).val(dataUrl);
                        }
                        image.src = readerEvent.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            };
                                                    // ------------------part2----------------

                                    /* Utility function to convert a canvas to a BLOB */
                                    var dataURLToBlob = function(dataURL) {
                                        var BASE64_MARKER = ';base64,';
                                        if (dataURL.indexOf(BASE64_MARKER) == -1) {
                                            var parts = dataURL.split(',');
                                            var contentType = parts[0].split(':')[1];
                                            var raw = parts[1];

                                            return new Blob([raw], {type: contentType});
                                        }

                                        var parts = dataURL.split(BASE64_MARKER);
                                        var contentType = parts[0].split(':')[1];
                                        var raw = window.atob(parts[1]);
                                        var rawLength = raw.length;

                                        var uInt8Array = new Uint8Array(rawLength);

                                        for (var i = 0; i < rawLength; ++i) {
                                            uInt8Array[i] = raw.charCodeAt(i);
                                        }

                                        return new Blob([uInt8Array], {type: contentType});
                                    }
                                    /* End Utility function to convert a canvas to a BLOB      */


                                    // -------------------final-------------------------





// --------------------------------------------------------resize image----------------------------------------------------------
