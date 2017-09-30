var $ = jQuery.noConflict();

$(document).ready(function($) {
	"use strict";

	/*-------------------------------------------------*/
	/* =  Dropdown Menu - Superfish
	/*-------------------------------------------------*/
	try {
		$('ul.sf-menu').superfish({
			delay: 400,
			autoArrows: false,
			speed: 'fast',
			animation: {opacity:'show', height:'show'}
		});
	} catch (err){

	}


	/*-------------------------------------------------*/
	/* =  Mobile Menu
	/*-------------------------------------------------*/
	// Create the dropdown base
    $("<select />").appendTo("#nav");
    
    // Create default option "Go to..."
    $("<option />", {
		"selected": "selected",
		"value"   : "",
		"text"    : "Go to..."
    }).appendTo("#nav select");
    
    // Populate dropdown with menu items
    $(".sf-menu a").each(function() {
		var el = $(this);
		$("<option />", {
			"value"   : el.attr("href"),
			"text"    : el.text()
		}).appendTo("#nav select");
    });

    $("#nav select").change(function() {
		window.location = $(this).find("option:selected").val();
    });



	/*-------------------------------------------------*/
	/* =  flexslider
	/*-------------------------------------------------*/
	try {

		var SliderPost = $('.flexslider');

		SliderPost.flexslider({
			animation: "slide",
			slideshowSpeed: 4000,
		});
	} catch(err) {

	}
	
	/*-------------------------------------------------*/
	/* =  Scroll to TOP
	/*-------------------------------------------------*/
	$('a[href="#top"]').click(function(){
        $('html, body').animate({scrollTop: 0}, 'slow');
        return false;
    });

	/*-------------------------------------------------*/
	/* =  Input & Textarea Placeholder
	/*-------------------------------------------------*/
	// $('input[type="text"], textarea').each(function(){
	// 	$(this).attr({'data-value': $(this).attr('placeholder')});
	// 	$(this).removeAttr('placeholder');
	// 	$(this).attr({'value': $(this).attr('data-value')});
	// });
    //
	// $('input[type="text"], textarea').focus(function(){
	// 	$(this).removeClass('error');
	// 	if($(this).val().toLowerCase() === $(this).attr('data-value').toLowerCase()){
	// 		$(this).val('');
	// 	}
	// }).blur( function(){
	// 	if($(this).val() === ''){
	// 		$(this).val($(this).attr('data-value'));
	// 	}
	// });

   	/*-------------------------------------------------*/
	/* =  Fancybox
	/*-------------------------------------------------*/

	$("a[data-fancybox-group^='group']").fancybox({
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'titlePosition' 	: 'over',
		'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
			return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
		}
	});


     $(document).ready(function () {           
         $('.bxslider').bxSlider({
             mode: 'horizontal',
             slideMargin: 0,
             auto:false
         });             
     });


  	/*-------------------------------------------------*/
	/* =  CarouSels
	/*-------------------------------------------------*/

    //  Responsive layout, resizing the items
    if( $('#foo4').length ) {

		$('#foo4').carouFredSel({
		  responsive: true,
		  width: '100%',
		 scroll: 2,
		prev: '#prev3',
                
		next: '#next3',
		  items: {
			width: 300,
			height: 'auto', 
			visible: {
			  min: 1,
			  max: 5
			}
		  }
		});

	}
	
	//  Responsive layout, resizing the items
    if( $('#myCarousel').length ) {

		$('#myCarousel').carouFredSel({
		  responsive: true,
		  width: '100%',
		  scroll: 1,
		prev: '#prev3',
		next: '#next3',
		  items: {
			width: 300,
			height: 'auto', 
			visible: {
			  min: 1,
			  max: 1
			}
		  }
		});

	}

     $(document).ready(function(){
	  $('.slider3').bxSlider({
	    slideWidth: 280,
	    minSlides: 1,
	    maxSlides: 6,
	    slideMargin: 20
	  });
	});


     $(document).ready(function(){
	  $('.slider4').bxSlider({
	    slideWidth: 280,
	    minSlides: 1,
	    maxSlides: 6,
	    slideMargin: 20
	  });
	});


     $(document).ready(function(){
	  $('.slider5').bxSlider({
	    slideWidth: 230,
	    minSlides: 1,
	    maxSlides: 6,
	    slideMargin: 20
	  });
	});

 	/* ---------------------------------------------------------------------- */
	/*	info box toggle
	/* ---------------------------------------------------------------------- */

	$(".info-toggle" ).click(function(e) {
		e.preventDefault();

		$(".info-box").toggleClass("active")
		$(".info-content" ).slideToggle(400);
	});


 	/*-------------------------------------------------*/
	/* =  Isotope
	/*-------------------------------------------------*/
	var winDow = $(window);
	// Needed variables
	var $container=$('.filter-container');
	var $filter=$('.filter');

	try{
		$container.imagesLoaded( function(){
			$container.show();
			$container.isotope({
				filter:'*',
				layoutMode:'masonry',
				animationOptions:{
					duration:750,
					easing:'linear'
				}
			});
		});
	} catch(err) {
	}

	winDow.bind('resize', function(){
		var selector = $filter.find('a.active').attr('data-filter');

		try {
			$container.isotope({ 
				filter	: selector,
				animationOptions: {
					duration: 750,
					easing	: 'linear',
					queue	: false,
				}
			});
		} catch(err) {
		}
		return false;
	});
	
	// Isotope Filter 
	$filter.find('a').click(function(){
		var selector = $(this).attr('data-filter');

		try {
			$container.isotope({ 
				filter	: selector,
				animationOptions: {
					duration: 750,
					easing	: 'linear',
					queue	: false,
				}
			});
		} catch(err) {

		}
		return false;
	});


	var filterItemA	= $('.filter a');

	filterItemA.on('click', function(){
		var $this = $(this);
		if ( !$this.hasClass('active')) {
			filterItemA.removeClass('active');
			$this.addClass('active');
		}
	});


   /*-------------------------------------------------*/
	/* =  Tabs Widget - { Popular, Recent and Comments }
	/*-------------------------------------------------*/
	$('.tab-links li a').live('click', function(e){
		e.preventDefault();
		if (!$(this).parent('li').hasClass('active')){
			var link = $(this).attr('href');

			$(this).parents('ul').children('li').removeClass('active');
			$(this).parent().addClass('active');

			$('.tabs-widget > div').hide();

			$(link).fadeIn();
		}
	});


	

	/* ---------------------------------------------------------------------- */
	/*	Portfolio
	/* ---------------------------------------------------------------------- */
	
	$('#filterOptions li a').click(function() {
		// fetch the class of the clicked item
		var ourClass = $(this).attr('class');
		
		// reset the active class on all the buttons
		$('#filterOptions li').removeClass('active');
		// update the active state on our clicked button
		$(this).parent().addClass('active');
		
		if(ourClass == 'all') {
			// show all our items
			$('#ourHolder').children('div.item').show();	
		}
		else {
			// hide all elements that don't share ourClass
			$('#ourHolder').children('div:not(.' + ourClass + ')').hide();
			// show all elements that do share ourClass
			$('#ourHolder').children('div.' + ourClass).show();
		}
		return false;
	});

	/*-------------------------------------------------*/
	/* =  preloader function
	/*-------------------------------------------------*/
	var body = $('body');
	body.addClass('active');

	winDow.load( function(){
		var mainDiv = $('#container'),
			preloader = $('.preloader');

			preloader.fadeOut(400, function(){
				mainDiv.delay(400).addClass('active');
			});
	});

});

/*-------------------------custom-----------------------------*/

(function($){
	"use strict";
	var craper = {			
			count: 0,
			tweets: function( options, selector ){
				
				options.action = '_sh_ajax_callback';
				options.subaction = 'tweets';
			
				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data:options,
					//dataType:"json",
					success: function(res){

						var reply = res;
						
						var html = '';
						
						/*$.each(reply, function(k, element) {
							html += '<li>'+element.text+'</li>';
						});*/
						
						$(selector).html( res );	
						
					}
				});
				
			},
			
			wishlist: function(options, selector)
			{
				options.action = '_sh_ajax_callback';
				
				if( $(selector).data('_sh_add_to_wishlist') === true ){
					craper.msg( 'You have already done this job', 'error' );
					return;
				}
				
				$(selector).data('_sh_add_to_wishlist', true );

				craper.loading(true);
				
				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data:options,
					dataType:"json",
					success: function(res){

						try{
							var newjason = res;

							if( newjason.code === 'fail'){
								$(selector).data('_sh_add_to_wishlist', false );
								craper.loading(false);
								craper.msg( newjason.msg, 'error' );
							}else if( newjason.code === 'exists'){
								$(selector).data('_sh_add_to_wishlist', true );
								craper.loading(false);
								craper.msg( newjason.msg, 'error' );
							}else if( newjason.code === 'success' ){
								craper.loading(false);
								$(selector).data('_sh_add_to_wishlist', true );
								craper.msg( newjason.msg, 'success' );
							}else if( newjason.code === 'del' ){
								craper.loading(false);
								$(selector).data('_sh_add_to_wishlist', true );
								$(selector).parents('tr').remove();
								craper.msg( newjason.msg, 'success' );
							}
							
							
						}
						catch(e){
							craper.loading(false);
							$(selector).data('_sh_add_to_wishlist', false );
							craper.msg( 'There was an error while adding product to whishlist '+e.message, 'error' );
							
						}
					}
				});
			},
			loading: function( show ){
				if( $('.loading' ).length === 0 ) {
					$('body').append('<div class="loading" style="display:none;"></div>');
				}
				
				if( show === true ){
					$('.loading').show('slow');
				}
				if( show === false ){
					$('.loading').hide('slow');
				}
			},
			
			msg: function( msg, type ){
				if( $('#pop' ).length === 0 ) {
					$('body').append('<div style="display: none;" id="pop"><div class="pop"><div class="alert"><p></p></div></div></div>');
				}
				var alert_type = 'alert-' + type;
				
				$('#pop > .pop p').html( msg );
				$('#pop > .pop > .alert').addClass(alert_type);
				
				$('#pop').slideDown('slow').delay(5000).fadeOut('slow', function(){
					$('#pop .pop .alert').removeClass(alert_type);
				});
				
				
			},
			
			
		};
	
	$.fn.sh_tweets = function( options ){
		
		var settings = {
				screen_name	:	'wordpress',
				count		:	3,
				template	:	'blockquote'
			};
			
			options = $.extend( settings, options );
			
			craper.tweets( options, this );
	};
	
	jQuery(document).ready(function($) {
            //$('.tweets-shortcode').sh_tweets();
		
		$('.add_to_wishlist, a[rel="product_del_wishlist"]').click(function(e) {
			e.preventDefault();
			
			if( $(this).attr('rel') === 'product_del_wishlist' ){
				if( confirm( 'Are you sure! you want to delete it' ) ){
					var opt = {subaction:'wishlist_del', data_id:$(this).attr('data-id')};
					craper.wishlist( opt, this );
				}
			}else{
				var opt = {subaction:'wishlist', data_id:$(this).attr('data-id')};
				craper.wishlist( opt, this );
			}
			
		});/**wishlist end*/
	
	//Contact us Form
	
		$('#contact-form').submit(function(){

			var action = $(this).attr('action');

			$("#message2").slideUp(700,function() {
				$('#message2').hide();
			});

			$('#submit')
				.attr('disabled','disabled');

			craper.loading(true);
			
			$.post(action, {
				contact_name: $('#contact_name').val(),
				contact_email: $('#contact_email').val(),
				contact_website: $('#contact_website').val(),
				contact_message: $('#contact_message').val()
			},
			function(data){
				craper.loading(false);
				document.getElementById('message2').innerHTML = data;
				$('#message2').slideDown('slow');
				$('#submit').removeAttr('disabled');
				if(data.match('success') != null) $('#contactform').fadeOut('slow');

			}
		);

		

		return false;

	});
		
	// Contact Form widget 
	
	
	$('#contact').submit(function(){ 
		
		var action = $(this).attr('action');

		$("#message").slideUp(750,function() {
			$('#message').hide();
		});
		var theme_url = $('#wp_theme_root_url').data('path');
		var this_form = this;

 		$('#submit').attr('disabled','disabled');
		$('img.loader').css('visibility', 'visible');

		$.post(action, {
			contact_name: $('#contact_name1').val(),
			contact_email: $('#contact_email1').val(),
			contact_message: $('#contact_message1').val(),
			recaptcha_challenge_field : function(){
				if( $('#recaptcha_challenge_field').length ) return $('#recaptcha_challenge_field').val();
			},
			recaptcha_response_field : function(){
				if( $('#recaptcha_response_field').length ) return $('#recaptcha_response_field').val();
			},
			//verify: $('#verify').val()
		},
			function(data){
				$('#msg.message').html( data );
				$('#msg').slideDown('slow');
				$('#contact img.loader').css('visibility', 'hidden');
				$('#submit').removeAttr('disabled');
				if(data.match('success') != null) $('#contact').slideUp('slow');

			}
		);
		
			return false;
		});


		$('.lg-panel.htabs > a').click( function( e ) {
			e.preventDefault();
			var id = $(this).attr('id');

			$('.lg-panel.htabs > a').removeClass('active');
			$(this).addClass('active');
			
			if( id === 'grid' ) {
				$('.product-grid.dark > .grid-item').css('display', 'block');
				$('.product-grid.dark > .grid-item-list').css('display', 'none');
			}
			if( id === 'list' ) {
				$('.product-grid.dark > .grid-item').css('display', 'none');
				$('.product-grid.dark > .grid-item-list').css('display', 'block');
			}
		});

	});
		
})(jQuery);

