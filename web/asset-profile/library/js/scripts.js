(function($){
    "use strict";

	/* FIX TRIM FOR IE8 */
    if ( typeof String.prototype.trim !== 'function' ) {
        String.prototype.trim = function() {
            return this.replace(/^\s+|\s+$/g, '');
        };
    }

	/* -----------------------------------------------------------------------------

	 GLOBAL FUNCTIONS

	 ----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
	 ACCORDION
	 ------------------------------------------------------------------------- */

    $.fn.uouAccordion = function(){

        var self = $(this),
            items = self.find( '.e-accordion-item' );

        items.find( '.e-accordion-item-content:visible' ).css( 'display', 'block' );
        items.find( '.e-accordion-item-content:hidden' ).css( 'display', 'none' );

        items.find( '.e-accordion-toggle' ).each(function(){
            $(this).click(function(){

                if ( ! self.hasClass( 'm-type-toggle' ) ) {
                    self.find( '.e-accordion-item.m-active .e-accordion-toggle .fa-minus' ).removeClass( 'fa-minus' ).addClass( 'fa-plus' );
                    self.find( '.e-accordion-item.m-active .e-accordion-item-content' ).slideUp(300);
                    self.find( '.e-accordion-item' ).removeClass( 'active' );
                }

                $(this).find( '.fa' ).toggleClass( 'fa-plus fa-minus' );
                $(this).parents( '.e-accordion-item' ).toggleClass( 'm-active' ).find( '.e-accordion-item-content' ).slideToggle(300, function(){
                    if ( $(this).is( ':visible' ) ) {
                        $(this).css( 'display', 'block' );
                    }
                    else {
                        $(this).css( 'display', 'none' );
                    }
                });

            });
        });

        return false;

    };

	/* -------------------------------------------------------------------------
	 CONTACT FORM
	 ------------------------------------------------------------------------- */

    $.fn.uouContactForm = function(){

        var form = $(this).prop( 'tagName' ).toLowerCase() === 'form' ? $(this) : $(this).find( 'form' ),
            submit_btn = form.find( '.e-submit-btn' );

        form.submit(function(e){
            e.preventDefault();

            if ( ! submit_btn.hasClass( 'loading' ) ) {

                // form not valid
                if ( ! form.uouFormValid() ) {
                    form.find( 'p.b-alert-message.m-warning.m-validation' ).slideDown(300);
                    return false;
                }
                // form valid
                else {

                    submit_btn.addClass( 'm-loading' ).attr( 'data-label', submit_btn.text() );
                    submit_btn.text( submit_btn.data( 'loading-label' ) );

                    // ajax request
                    $.ajax({
                        type: 'POST',
                        url: form.attr( 'action' ),
                        data: form.serialize(),
                        success: function( data ){

                            form.find( '.b-alert-message.m-validation' ).hide();
                            form.prepend( data );
                            form.find( '.b-alert-message.m-success, .b-alert-message.m-phpvalidation' ).slideDown(300);
                            submit_btn.removeClass( 'm-loading' );
                            submit_btn.text( submit_btn.attr( 'data-label' ) );

                            // reset all inputs
                            if ( data.indexOf( 'success' ) > 0 ) {
                                form.find( 'input, textarea' ).each( function() {
                                    $(this).val( '' );
                                });
                                form.find( '.m-error' ).removeClass( 'm-error' );
                            }

                        },
                        error: function(){
                            form.find( '.b-alert-message.m-success' ).slideUp(300);
                            form.find( '.b-alert-message.m-validation' ).slideUp(300);
                            form.find( '.b-alert-message.m-request' ).slideDown(300);
                            submit_btn.removeClass( 'm-loading' );
                            submit_btn.text( submit_btn.attr( 'data-label' ) );
                        }
                    });

                }

            }
        });
    };

	/* ---------------------------------------------------------------------
	 FLUID EMBED VIDEOS
	 By Chris Coyier & tweaked by Mathias Bynens
	 --------------------------------------------------------------------- */

    $.fn.uouFluidVideo = function(){

        var self = $(this),
            iframe = $(this).find( 'iframe' );

        var reload_fluid_video = function(){

            var newWidth = self.width();
            iframe
                .width(newWidth)
                .height(newWidth * iframe.data( 'aspectRatio' ));

        };
        var generate_fluid_video = function(){
            iframe.data( 'aspectRatio', iframe.height() / iframe.width() )
                .removeAttr( 'height' )
                .removeAttr( 'width' );
            reload_fluid_video();
        };
        generate_fluid_video();
        $(window).resize(function(){
            reload_fluid_video();
        });

    };

	/* -------------------------------------------------------------------------
	 FORM ELEMENTS
	 ------------------------------------------------------------------------- */

    // CHEKCBOX INPUT
    $.fn.uouCheckboxInput = function(){

        var self = $(this),
            input = self.find( 'input' );

        // INITIAL STATE
        if ( input.is( ':checked' ) ) {
            self.addClass( 'm-active' );
        }
        else {
            self.removeClass( 'm-active' );
        }

        // CHANGE STATE
        input.change(function(){
            if ( input.is( ':checked' ) ) {
                self.addClass( 'm-active' );
            }
            else {
                self.removeClass( 'm-active' );
            }
        });

    };

    // RADIO INPUT
    $.fn.uouRadioInput = function(){

        var self = $(this),
            input = self.find( 'input' ),
            group = input.attr( 'name' );

        // INITIAL STATE
        if ( input.is( ':checked' ) ) {
            self.addClass( 'm-active' );
        }

        // CHANGE STATE
        input.change(function(){
            if ( group ) {
                $( '.b-radio-input input[name="' + group + '"]' ).parent().removeClass( 'm-active' );
            }
            if ( input.is( ':checked' ) ) {
                self.addClass( 'm-active' );
            }
        });

    };

    // SELECT BOX
    $.fn.uouSelectBox = function(){

        var self = $(this),
            select = self.find( 'select' );
        self.prepend( '<ul class="e-select-clone m-custom-list"></ul>' );

        var placeholder = select.data( 'placeholder' ) ? select.data( 'placeholder' ) : select.find( 'option:eq(0)' ).text(),
            clone = self.find( '.e-select-clone' );
        self.prepend( '<input class="e-value-holder" type="text" disabled="disabled" placeholder="' + placeholder + '"><i class="fa fa-chevron-down"></i>' );
        var value_holder = self.find( '.e-value-holder' );

        // INPUT PLACEHOLDER FIX FOR IE
        if ( $.fn.placeholder ) {
            self.find( 'input, textarea' ).placeholder();
        }

        // CREATE CLONE LIST
        select.find( 'option' ).each(function(){
            if ( $(this).attr( 'value' ) ){
                clone.append( '<li data-value="' + $(this).val() + '">' + $(this).text() + '</li>' );
            }
        });

        // TOGGLE LIST
        self.click(function(){
            var media_query_breakpoint = uouMediaQueryBreakpoint();
            if ( media_query_breakpoint > 991 ) {
                clone.slideToggle(100);
                self.toggleClass( 'm-active' );
            }
        });

        // CLICK
        clone.find( 'li' ).click(function(){

            value_holder.val( $(this).text() );
            select.find( 'option[value="' + $(this).attr( 'data-value' ) + '"]' ).attr( 'selected', 'selected' );

            // IF LIST OF LINKS
            if ( self.hasClass( 'links' ) ) {
                window.location.href = select.val();
            }

        });

        // HIDE LIST
        self.bind( 'clickoutside', function(event){
            clone.slideUp(100);
        });

        // LIST OF LINKS
        if ( self.hasClass( 'links' ) ) {
            select.change( function(){
                window.location.href = select.val();
            });
        }

    };

	/* -------------------------------------------------------------------------
	 FORM VALIDATION
	 ------------------------------------------------------------------------- */

    $.fn.uouFormValid = function() {

        function emailValid( email ) {
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }

        var form = $(this),
            formValid = true;

        form.find( 'input.m-required, textarea.m-required, select.m-required' ).each(function(){

            var field = $(this),
                value = field.val(),
                valid = false;

            if ( value.trim() !== '' ) {

                // email field
                if ( field.hasClass( 'm-email' ) ) {
                    if ( ! emailValid( value ) ) {
                        field.addClass( 'm-error' );
                    }
                    else {
                        field.removeClass( 'm-error' );
                        valid = true;
                    }
                }

                // select field
                else if ( field.prop( 'tagName' ).toLowerCase() === 'select' ) {

                    if ( value === null || value === field.data( 'placeholder' ) ) {
                        field.addClass( 'm-error' );
                        field.parents( '.b-select-box' ).addClass( 'm-error' );
                    }
                    else {
                        field.removeClass( 'm-error' );
                        valid = true;
                    }
                }

                // default field
                else {
                    field.removeClass( 'm-error' );
                    valid = true;
                }

            }
            else {
                field.addClass( 'm-error' );
            }
            formValid = ! valid ? false : formValid;

        });

        return formValid;

    };

	/* -------------------------------------------------------------------------
	 LIGHTBOX
	 ------------------------------------------------------------------------- */

    // LIGHTBOX STRINGS SETUP
    $.extend( true, $.magnificPopup.defaults, {
        tClose: 'Close (Esc)',
        tLoading: 'Loading...',
        gallery: {
            tPrev: 'Previous (Left arrow key)', // Alt text on left arrow
            tNext: 'Next (Right arrow key)', // Alt text on right arrow
            tCounter: '%curr% / %total%' // Markup for "1 of 7" counter
        },
        image: {
            tError: '<a href="%url%">The image</a> could not be loaded.' // Error message when image could not be loaded
        },
        ajax: {
            tError: '<a href="%url%">The content</a> could not be loaded.' // Error message when ajax request failed
        }
    });

    // FUNCTION
    $.fn.uouInitLightboxes = function(){
        if ( $.fn.magnificPopup ) {
            $(this).find( 'a.m-lightbox' ).each(function(){

                var self = $(this),
                    lightbox_group = self.data( 'lightbox-group' ) ? self.data( 'lightbox-group' ) : false;

                if ( lightbox_group ) {
                    $( 'a.m-lightbox[data-lightbox-group="' + lightbox_group + '"]' ).magnificPopup({
                        type: 'image',
                        removalDelay: 300,
                        mainClass: 'mfp-fade',
                        gallery: {
                            enabled: true
                        }
                    });
                }
                else {
                    self.magnificPopup({
                        type: 'image'
                    });
                }

            });
        }
    };

	/* -------------------------------------------------------------------------
	 MEDIA QUERY BREAKPOINT
	 ------------------------------------------------------------------------- */

    var uouMediaQueryBreakpoint = function() {

        if ( $( '#media-query-breakpoint' ).length < 1 ) {
            $( 'body' ).append( '<var id="media-query-breakpoint"><span></span></var>' );
        }
        var value = $( '#media-query-breakpoint' ).css( 'content' );
        if ( typeof value !== 'undefined' ) {
            value = value.replace( "\"", "" ).replace( "\"", "" ).replace( "\'", "" ).replace( "\'", "" );
            if ( isNaN( parseInt( value, 10 ) ) ){
                $( '#media-query-breakpoint span' ).each(function(){
                    value = window.getComputedStyle( this, ':before' ).content;
                });
                value = value.replace( "\"", "" ).replace( "\"", "" ).replace( "\'", "" ).replace( "\'", "" );
            }
            if(isNaN(parseInt(value,10))){
                value = 1199;
            }
        }
        else {
            value = 1199;
        }
        return value;

    };

	/* -------------------------------------------------------------------------
	 PROGRESS BAR
	 ------------------------------------------------------------------------- */

    $.fn.uouProgressBar = function(){

        var self = $(this),
            percentage = self.data( 'percentage' ) ? parseInt( self.data( 'percentage' ) ) : 100,
            inner = self.find( '.e-progress-bar-inner > span' ),
            media_query_breakpoint = uouMediaQueryBreakpoint();

        // WITH INVIEW ANIMATIONS
        if ( $( 'body' ).hasClass( 'm-enable-inview-animations' ) && media_query_breakpoint > 991 ) {
            self.one( 'inview', function(){
                inner.css( 'width', percentage + '%' );
            });
        }
        // WITHOUT INVIEW ANIMATIONS
        else {
            inner.css( 'width', percentage + '%' );
        }

        // TYPE 2
        if ( self.hasClass( 'm-type-2' ) ) {

            var button = self.find( '.e-toggle' ),
                text = self.find( '.e-progress-bar-text' );
            button.click(function(){
                button.find( '.fa' ).toggleClass( 'fa-plus fa-minus' );
                if ( text.is( ':visible' ) ) {
                    text.css( 'display', 'block' );
                }
                else {
                    text.css( 'display', 'none' );
                }
                text.slideToggle(300);
                self.toggleClass( 'm-active' );
            });
        }

    };

	/* -------------------------------------------------------------------------
	 RADIAL PROGRESS BAR
	 http://blog.invatechs.com/round_progress_bar_with_html5_css3_and_javascript
	 ------------------------------------------------------------------------- */

    $.fn.uouRadialProgressBar = function(){

        var self = $(this),
            percentage = self.data( 'percentage' ) ? parseInt( self.data( 'percentage' ) ) : 100,
            html = '',
            media_query_breakpoint = uouMediaQueryBreakpoint();

        // CREATE HTML
        html += '<div class="e-loader"><div class="e-loader-bg"><div class="e-text">0%</div></div>';
        html += '<div class="e-spiner-holder-one e-animate-0-25-a"><div class="e-spiner-holder-two e-animate-0-25-b"><div class="e-loader-spiner" style=""></div></div></div>';
        html += '<div class="e-spiner-holder-one e-animate-25-50-a"><div class="e-spiner-holder-two e-animate-25-50-b"><div class="e-loader-spiner"></div></div></div>';
        html += '<div class="e-spiner-holder-one e-animate-50-75-a"><div class="e-spiner-holder-two e-animate-50-75-b"><div class="e-loader-spiner"></div></div></div>';
        html += '<div class="e-spiner-holder-one e-animate-75-100-a"><div class="e-spiner-holder-two e-animate-75-100-b"><div class="e-loader-spiner"></div></div></div>';
        html += '</div>';
        self.prepend( html );

        // SET PERCENTAGE FUNCTION
        var set_percentage = function( percentage ){
            var angle;
            if ( percentage < 25 ) {
                angle = -90 + ( percentage / 100 ) * 360;
                self.find( '.e-animate-0-25-b' ).css( 'transform', 'rotate(' + angle + 'deg)' );
            }
            else if ( percentage >= 25 && percentage < 50 ) {
                angle = -90 + ( ( percentage - 25 ) / 100 ) * 360;
                self.find( '.e-animate-0-25-b' ).css( 'transform', 'rotate(0deg)' );
                self.find( '.e-animate-25-50-b' ).css( 'transform', 'rotate(' + angle + 'deg)' );
            }
            else if ( percentage >= 50 && percentage < 75 ) {
                angle = -90 + ( ( percentage-50 ) / 100 ) * 360;
                self.find( '.e-animate-25-50-b, .e-animate-0-25-b' ).css( 'transform', 'rotate(0deg)' );
                self.find( '.e-animate-50-75-b' ).css( 'transform' , 'rotate(' + angle + 'deg)' );
            }
            else if ( percentage >= 75 && percentage <= 100 ) {
                angle = -90 + ( ( percentage - 75 ) / 100 ) * 360;
                self.find(' .e-animate-50-75-b, .e-animate-25-50-b, .e-animate-0-25-b' ).css( 'transform', 'rotate(0deg)' );
                self.find( '.e-animate-75-100-b' ).css( 'transform', 'rotate(' + angle + 'deg)' );
            }
            self.find( '.e-text' ).html( percentage + '%' );
        };

        var clearProgress = function() {
            self.find( '.e-animate-75-100-b, .e-animate-50-75-b, .e-animate-25-50-b, .e-animate-0-25-b' ).css( 'transform', 'rotate(90deg)' );
        };

        // SET PERCENTAGE
        if ( $( 'body' ).hasClass( 'm-enable-inview-animations' ) && media_query_breakpoint > 991 ) {
            self.one( 'inview', function(){
                for ( var i = 0; i <= percentage; i++ ) {
                    (function(i) {
                        setTimeout(function(){ set_percentage( i ); }, i * 10);
                    })(i);
                }
            });
        }
        else {
            set_percentage( percentage );
        }

    };

	/* -------------------------------------------------------------------------
	 SLIDER
	 ------------------------------------------------------------------------- */

    $.fn.uouSlider = function(){
        if ( $.fn.owlCarousel ) {

            var slider = $(this),
                slide_list = slider.find( '.e-slide-list' ),
                slides = slider.find( '.e-slide' ),
                interval = slider.data( 'interval' ) ? parseInt( slider.data( 'interval' ) ) > 0 : false;

            slide_list.owlCarousel({
                autoPlay: interval,
                slideSpeed: 300,
                pagination: true,
                paginationSpeed : 400,
                singleItem:true
            });

        }
    };

	/* -------------------------------------------------------------------------
	 TABBED
	 ------------------------------------------------------------------------- */

    $.fn.uouTabbed = function(){

        var self = $(this),
            tabs = self.find( '> .e-tab-title-list > .e-tab-title' ),
            contents = self.find( '> .e-tab-content-list > .e-tab-content' );

        tabs.click(function(e){
            if ( ! $(this).hasClass( 'm-active' ) ) {
                var index = $(this).index();
                tabs.filter( '.m-active' ).removeClass( 'm-active' );
                $(this).addClass( 'm-active' );
                contents.filter( '.m-active' ).hide().removeClass( 'm-active' );
                contents.filter( ':eq(' + index + ')' ).show().addClass( 'm-active' );

                // CHANGE LOCATION HASH IF NEEDED
                var target = $(e.target);
                if ( target.attr( 'href' ) ) {
                    if ( history.pushState ) {
                        history.pushState( null, null, target.attr( 'href' ) );
                    }
                    else {
                        location.hash = target.attr( 'href' );
                    }
                }
                return false;

            }
        });

    };

	/* -------------------------------------------------------------------------
	 TWITTER FEED
	 ------------------------------------------------------------------------- */

    $.fn.uouTwitterFeed = function(){
        if ( $.fn.tweet ) {

            var self = $(this),
                feed_id = self.data( 'id' ),
                feed_limit = self.data( 'limit' ),
                feed_content = self.find( '.e-twitter-feed-content' );

            feed_content.bind( 'loaded', function(){
                self.removeClass( 'm-loading' );
                if ( self.hasClass( 'm-paginated' ) && $.fn.owlCarousel ) {
                    var interval = self.data( 'interval' ) ? parseInt( self.data( 'interval' ) ) > 0 : false;
                    self.find( '.e-tweet-list' ).fadeIn(500);
                    self.find( '.e-tweet-list' ).owlCarousel({
                        autoPlay: interval,
                        slideSpeed: 300,
                        pagination: false,
                        paginationSpeed : 400,
                        singleItem:true
                    });
                }
            });

            feed_content.tweet({
                username: feed_id,
                modpath: './library/twitter/',
                count: feed_limit,
                loading_text: '<span class="b-loading-anim"><span></span></span>'
            });

        }
    };


    $(document).ready(function(){
		/* -----------------------------------------------------------------------------

		 GENERAL

		 ----------------------------------------------------------------------------- */

// GET ACTUAL MEDIA QUERY BREAKPOINT
        var media_query_breakpoint = uouMediaQueryBreakpoint();

// INPUT PLACEHOLDER FIX FOR IE
        if ( $.fn.placeholder ) {
            $( 'input, textarea' ).placeholder();
        }

// ACCORDIONS
        $( '.b-accordion' ).each(function(){
            $(this).uouAccordion();
        });

// FORM ELEMENTS
        $( '.b-checkbox-input' ).each(function(){
            $(this).uouCheckboxInput();
        });
        $( '.b-radio-input' ).each(function(){
            $(this).uouRadioInput();
        });
        $( '.b-select-box' ).each(function(){
            $(this).uouSelectBox();
        });

// FLUID VIDEOS
        $( '.b-embed-video' ).each(function(){
            $(this).uouFluidVideo();
        });

// LIGHTBOXES
        $( 'body' ).uouInitLightboxes();

// PROGRESS BARS
        $( '.b-progress-bar' ).each(function(){
            $(this).uouProgressBar();
        });
        $( '.b-radial-progress-bar' ).each(function(){
            $(this).uouRadialProgressBar();
        });

// SLIDERS
        $( '.b-slider' ).each(function(){
            $(this).uouSlider();
        });

// TABS
        $( '.b-tabs' ).each(function(){
            $(this).uouTabbed();
        });


		/* -----------------------------------------------------------------------------

		 TOPBAR

		 ----------------------------------------------------------------------------- */

		/* -------------------------------------------------------------------------
		 TOPBAR MENU
		 ------------------------------------------------------------------------- */

        $( '.e-topbar-menu li.m-has-submenu' ).each(function(){

            var self = $(this);

            // HOVER
            self.hover(function(){
                if ( media_query_breakpoint > 991 ) {
                    $(this).addClass( 'hover' );
                    $(this).find( '> ul' ).stop( true, true ).slideDown(200);
                }
            }, function(){
                if ( media_query_breakpoint > 991 ) {
                    $(this).removeClass( 'hover' );
                    $(this).find( '> ul' ).stop( true, true ).delay(10).slideUp(200);
                }
            });

        });


		/* -----------------------------------------------------------------------------

		 HEADER

		 ----------------------------------------------------------------------------- */

		/* -------------------------------------------------------------------------
		 HEADER MENU
		 ------------------------------------------------------------------------- */

        $( '.e-header-menu' ).each(function(){

            var self = $(this);

            // SECTION SWITCH
            self.find( 'a[href*="#"]' ).each(function(){

                var self = $(this),
                    hash = self.attr( 'href' ).replace(/^.*?#/,''),
                    parent = self.parent();

                // SWITCH ON CLICK
                self.click(function(){

                    // check if link is anchor for the current page
                    if ( $( '#' + hash ).length > 0 ) {

                        if ( history.pushState ) {
                            history.pushState( null, null, self.attr( 'href' ) );
                        }
                        else {
                            location.hash = self.attr( 'href' );
                        }
                        $( '.e-header-menu > ul > li.m-active' ).removeClass( 'm-active' );
                        if ( parent.parent().hasClass( 'e-sub-menu' ) ) {
                            parent.parent().parent().addClass( 'm-active' );
                        }
                        else {
                            parent.addClass( 'm-active' );
                        }

                        $( '.e-profile-section:visible' ).slideUp(300);
                        $( '#' + hash + '.e-profile-section' ).slideDown(300);

                        if ( hash === 'profile' && $( '.e-header-content' ).data( 'floating' ) && $( '.e-header-content' ).data( 'floating' ) === 'yes' ) {
                            $( '.e-header-content' ).addClass( 'm-floating' );
                        }
                        else {
                            $( '.e-header-content' ).removeClass( 'm-floating' );
                        }

                        return false;
                    }

                });

                // SECTION SWITCH ON REFRESH
                if ( location.hash !== '' && hash === location.hash.substring(1) && $( '#' + hash ).length > 0 ) {

                    $( '.e-header-menu > ul > li.m-active' ).removeClass( 'm-active' );
                    parent.addClass( 'm-active' );
                    $( '.e-profile-section:visible' ).hide();
                    $( '#' + hash + '.e-profile-section' ).show();

                    // "prevent" browser to scroll to element
                    window.scrollTo(0, 0);
                    $(window).one( 'scroll', function(){
                        window.scrollTo(0, 0);
                    });

                    if ( hash === 'profile' && $( '.e-header-content' ).data( 'floating' ) && $( '.e-header-content' ).data( 'floating' ) === 'yes' ) {
                        $( '.e-header-content' ).addClass( 'm-floating' );
                    }
                    else {
                        $( '.e-header-content' ).removeClass( 'm-floating' );
                    }

                }

            });

            // SUBMENU HOVER
            self.find( '> ul > li.m-has-submenu' ).each(function(){
                $(this).hover(function(){
                    if ( media_query_breakpoint > 991 ) {
                        $(this).addClass( 'm-hover' );
                        $(this).find( '> ul' ).stop( true, true ).slideDown(200);
                    }
                }, function(){
                    if ( media_query_breakpoint > 991 ) {
                        $(this).removeClass( 'm-hover' );
                        $(this).find( '> ul' ).stop( true, true ).delay(10).slideUp(200);
                    }
                });
            });

            // MENU / TOPBAR TOGGLE
            self.find( '.e-header-menu-toggle' ).click(function(){
                self.find( '> ul' ).slideToggle(300);
                $( '#topbar' ).slideToggle(300);
            });

            // SUBMENU TOGGLE
            self.find( 'li.m-has-submenu' ).each(function(){
                $(this).append( '<button class="e-submenu-toggle"><i class="fa fa-chevron-down"></i></button>' );
            });
            self.find( '.e-submenu-toggle' ).each(function(){
                $(this).click(function(){
                    $(this).parent().find( '> .e-sub-menu' ).slideToggle(200);
                    $(this).find( '.fa' ).toggleClass( 'fa-chevron-down fa-chevron-up' );
                });
            });

        });


		/* -----------------------------------------------------------------------------

		 CORE

		 ----------------------------------------------------------------------------- */

		/* -------------------------------------------------------------------------
		 PORTFOLIO
		 ------------------------------------------------------------------------- */

        $( '.b-portfolio' ).each(function(){

            var portfolio = $(this),
                filter = portfolio.find( '.e-filter' ),
                list = portfolio.find( '.e-project-list' ),
                thumbs = list.find( '.gallery-item' );

            portfolio.one( 'inview', function(){
                if ( $.fn.isotope ) {

                    list.isotope({
                        itemSelector : '.e-project-item',
                        layoutMode : 'fitRows'
                    });

                    // FILTER
                    if ( filter.length > 0 ) {
                        filter.find( 'button' ).each(function(){

                            var self = $(this),
                                category = self.data( 'category' ),
                                active_filter = category !== '*' ? '.m-category-' + category : category;

                            self.click(function(){
                                if ( ! self.hasClass( 'm-active' ) ) {

                                    list.isotope({ filter: active_filter });
                                    filter.find( '.m-active' ).removeClass( 'm-active' );
                                    self.addClass( 'm-active' );
                                }
                            });
                        });
                    }

                }
            });

        });

		/* -------------------------------------------------------------------------
		 VALIDATE BLOG COMMENTS
		 ------------------------------------------------------------------------- */

        $( '#comments .e-comment-form form' ).submit(function(){

            var form = $(this);
            if ( ! form.uouFormValid() ) {
                form.find( '.b-alert-message.m-validation' ).slideDown(300);
                return false;
            }

        });

		/* -------------------------------------------------------------------------
		 CONTACT FORM
		 ------------------------------------------------------------------------- */

        $( '#contact-form, #contact-form-2' ).each(function(){
            $(this).uouContactForm();
        });


		/* -----------------------------------------------------------------------------

		 TWITTER FEED

		 ----------------------------------------------------------------------------- */

        $( '#twitter-feed' ).each(function(){
            $(this).uouTwitterFeed();
        });


		/* -----------------------------------------------------------------------------

		 SCREEN RESIZE

		 ----------------------------------------------------------------------------- */

        $(window).resize(function(){

            if ( uouMediaQueryBreakpoint() !== media_query_breakpoint ) {
                media_query_breakpoint = uouMediaQueryBreakpoint();

                $( '.e-header-menu > ul, .e-header-menu .e-sub-menu, #topbar .e-sub-menu' ).removeAttr( 'style' );
                $( '.e-header-menu .e-submenu-toggle > .fa' ).removeClass( 'fa-chevron-up' ).addClass( 'fa-chevron-down' );

            }

        });

		/* -----------------------------------------------------------------------------

		 STYLE SWITCHER

		 ----------------------------------------------------------------------------- */

        if ( $( 'body' ).hasClass( 'm-enable-style-switcher' ) ) {

            // CREATE STYLE SWITCHER
            var style_switcher_html = '<div id="style-switcher"><button class="e-style-switcher-toggle"><i class="ico fa fa-cog"></i></button>';
            style_switcher_html += '<div class="e-style-switcher-content"><ul class="m-custom-list e-skin-list">';
            style_switcher_html += '<li><button class="m-skin-lime m-active" data-skin="lime"><span>Lime</span></button></li>';
            style_switcher_html += '<li><button class="m-skin-blue" data-skin="blue"><span>Blue</span></button></li>';
            style_switcher_html += '<li><button class="m-skin-orange" data-skin="orange"><span>Orange</span></button></li>';
            style_switcher_html += '<li><button class="m-skin-darkblue" data-skin="darkblue"><span>Dark Blue</span></button></li>';
            style_switcher_html += '<li><button class="m-skin-fadedorange" data-skin="fadedorange"><span>Faded Orange</span></button></li>';
            style_switcher_html += '</ul></div></div>';
            $( 'body' ).append( style_switcher_html );

            // INIT SWITCHER
            $( '#style-switcher' ).each(function(){

                var switcher = $(this),
                    toggle = switcher.find( '.e-style-switcher-toggle' ),
                    skins = switcher.find( '.e-skin-list button' );

                // TOGGLE SWITCHER
                toggle.click(function(){
                    switcher.toggleClass( 'm-active' );
                });

                // SET SKIN
                skins.click(function(){
                    skins.filter( '.m-active' ).removeClass( 'm-active' );
                    $(this).toggleClass( 'm-active' );

                    if ( $( 'head #skin-temp' ).length < 1 ) {
                        $( 'head' ).append( '<link id="skin-temp" rel="stylesheet" type="text/css" href="asset-profile/library/css/skins/' + $(this).data( 'skin' ) + '.css">' );
                    }
                    else {
                        $( '#skin-temp' ).attr( 'href', 'asset-profile/library/css/skins/' + $(this).data( 'skin' ) + '.css' );
                    }

                });

            });

        }
// STYLE SWITCHER END



		/* END. */
    });
})(jQuery);