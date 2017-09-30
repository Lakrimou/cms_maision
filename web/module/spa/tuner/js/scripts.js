/**/
/* on load event */
/**/
"use strict";
jQuery(document).ready( function (){
	if ( !is_mobile_device () ) {
		$('body').append('<div id="tuner" class="tuner"> <div class="colors"> <p>Color Skin</p> <div id="color-1" class="color-picker" data-color="#76c08a" style="background-color:#76c08a;"></div> </div><div class="layout-style"><p>Layout Style</p><div class="page-style wide active">Wide</div><div class="page-style boxed">Boxed</div></div><i id="tuner-switcher" class="fa fa-cog"></i> </div> <div id="tuner-style-1" class="tuner-style" style="display: none;"> /* Colors for: main color */ strong,.select-title,.section-title,.shop-info-title,.banner-title,.title-under h3,.title-under.alt a h3:hover,blockquote,.font-alt,.list-style-1 li:before,.list-style-2 li:before,.list-style-3 li:before,.list-style-4 li:before,.list-style-3 li > a > span,.list-style-3 li > a:hover > span,.promo-title-top,.promo-title,.tel-wrap address a:hover,.inner-nav ul li a:hover,.inner-nav ul li a.active,.mobile-nav:hover,.mobile-nav.active,.submenu-mega-title,.button-border,.button:hover,.features-center:hover .features-icon i,.features-title,.features-icon.alt-1 i,.tparrows:hover:before,.shop-container .info a:hover,.shop-title,.group,#list-grid > div.active,.single-price .reg-price,.shop-categories a,table.shopping-cart-table tr td a.shop-cart-name,table.shopping-cart-table tr td a.shop-cart-name:hover,.list-style-2.shop-cart li:last-child,.login-enter a,.code-enter a,form.form.login .lost,form.form.login .lost:hover,.billing-fields select,.billing-fields .list-style-2 li .free,.payment_method_paypal label a,.payment_method_paypal label a:hover,.footer-contact a.mail,.twitter-footer a,.twitter-footer .twitt,.footer-soc-links a:hover,.alt-1 .news-title,.alt-2 .news-title,.alt-3 .news-title,.alt-1 .news-date,.accordion > dt > a,.toggle > dt > a:before,.toggle > dd,.nav-tabs > li > a,.nav-tabs>li>a:hover,.tab-title,.skill-bar .name span,.skill-bar .name .skill-bar-perc,.pricing-title,.alt-2 .gift-title h3,.alt-1 .gift-price,.alt-2 .gift-step,.alt-3 .gift-inside-1,.serv-title,.exp-title,.work-filter a,.alt-1 .portfolio-title,.blog-title,.blog-post .blog-title.comments span,.blog-item .blog-date,.blog-comment,.blog-title.link a,.blog-title.link a:hover,.comment .meta,.comment .reply:hover,aside h3,aside h4,.search-submit,.widget-categories .cat-item span,.widget-comments .comments-bottom,.widget-archives li a:hover,.link-color,.widget-twitter a,.widget-twitter .twitt,.widget-tag,.widget-tag a:hover,.widget-meta li:before,.widget-meta li a:hover,.ui-datepicker-inline thead,.ui-datepicker-title,.ui-datepicker-prev,.ui-datepicker-next,.widget-navigation>ul>li>a,.widget-navigation>ul>li>ul>li.active>a,.widget-navigation>ul>li>ul>li.hover>a,.widget-navigation>ul>li>ul>li:hover>a,.widget-navigation>ul>li>ul>li.active,.widget-navigation>ul>li>ul>li>ul>li.hover>a,.contact-title,.contact-follow a:hover,.info-boxes.confirmation-message .info-box-icon,.info-boxes.confirmation-message.alt .info-title,.info-boxes.confirmation-message.alt .close-button,#scroll-top { color: #<span>cws_theme_main#</span>; }      .submenu,.title-under.alt a h3:hover,.title-under h3,.title-under.alt h3,.mobile-on .desktop-nav ul,.mobile-on .desktop-nav ul li ul,.mobile-on .desktop-nav ul li a,.mobile-on .inner-nav ul li .submenu li a,.button,.button-border,.list-style-2.shop-cart li:before,input.input-text:focus,.nav-tabs>li.active>a,  .nav-tabs>li.active>a:focus,.nav-tabs>li.active>a:hover,.nav-tabs>li>a:hover,.alt-1.work-filter a.active,.alt-1.work-filter a:hover,.blog-title.link a:hover,.form input[type="text"]:focus, .form input[type="email"]:focus, .form input[type="number"]:focus, .form input[type="url"]:focus, .form input[type="search"]:focus, .form input[type="tel"]:focus, .form input[type="password"]:focus, .form input[type="date"]:focus, .form input[type="color"]:focus, .form select:focus,.form textarea:focus,.info-boxes.confirmation-message.alt,.nav-tabs > li > a,.tab-content,.skill-bar .bar,.alt-3 .gift-inside-2:before,.alt-3 .gift-inside-2:after,.alt-3 .gift-inside-2-white:before,.alt-3 .gift-inside-2-white:after,.alt-1.work-filter a,.blog-title.link a,aside,.price_slider .ui-slider-handle:before,.widget-cart .product, .widget-cart article,.widget-banner .product,.widget-selers .product,.ui-datepicker-calendar,.widget-navigation>ul,.widget-navigation>ul>li,.widget-navigation>ul>li>ul>li>a,.widget-navigation>ul>li>ul{ border-color: #<span>cws_theme_main#</span>; }     .dots-alt .owl-page.active span,.pricing-price,.widget-banner h4 span:before, .widget-banner h4 span:after,.preloader-wave:before,.preloader-wave:after,ins.ins-2,.circle-letter-2,.inner-nav ul li .submenu li a:before,.button,.button.button-border:hover,.features-icon,.features-title:before,.dots-alt .owl-page span,.single-price .old-price:before,.login-enter a:before,.code-enter a:before,.footer-tweets-item .line,.accordion > dt > a.active,.accordion > dt > a > i:before,.accordion > dt > a > i:after,.accordion > dd:before,.toggle > dt > a.active,.toggle > dd:before,.nav-tabs>li.active>a,  .nav-tabs>li.active>a:focus,.nav-tabs>li.active>a:hover,.nav-tabs>li>a:hover,.alt-3 .gift-inside-2,.alt-3 .gift-inside-2-white,.widget-post .author:before,.widget-twitter .tweet_time:before,.widget-tag a:before,.price_slider .ui-slider-range,.ui-datepicker-current-day,.widget-navigation>ul>li>ul>li>ul>li>a:before,.info-boxes.confirmation-message,.info-boxes.confirmation-message.alt .info-box-icon { background-color: #<span>cws_theme_main#</span>; }     .features-icon { -webkit-box-shadow: 0 0 0 2px #fff inset, 0 0 0 5px #<span>cws_theme_main#</span>; -moz-box-shadow: 0 0 0 2px #fff inset, 0 0 0 5px #<span>cws_theme_main#</span>; box-shadow: 0 0 0 2px #fff inset, 0 0 0 5px #<span>cws_theme_main#</span>; }   .features-center:hover .features-icon{ -webkit-box-shadow: 0 0 0 55px #fff inset, 0 0 0 5px #<span>cws_theme_main#</span>; -moz-box-shadow: 0 0 0 55px #fff inset, 0 0 0 5px #<span>cws_theme_main#</span>; box-shadow: 0 0 0 55px #fff inset, 0 0 0 5px #<span>cws_theme_main#</span>; }	.features-icon.alt-1{ -webkit-box-shadow: 0 0 0 2px #<span>cws_theme_main#</span> inset, 0 0 0 5px #ffffff; -moz-box-shadow: 0 0 0 2px #<span>cws_theme_main#</span> inset, 0 0 0 5px #ffffff; box-shadow: 0 0 0 2px #<span>cws_theme_main#</span> inset, 0 0 0 5px #ffffff; }	.features-center:hover .features-icon.alt-1{ -webkit-box-shadow: 0 0 0 55px #<span>cws_theme_main#</span> inset, 0 0 0 5px #ffffff; -moz-box-shadow: 0 0 0 55px #<span>cws_theme_main#</span> inset, 0 0 0 5px #ffffff; box-shadow: 0 0 0 55px #<span>cws_theme_main#</span> inset, 0 0 0 5px #ffffff; }	 .active.pricing-table .pricing-media:before{ -webkit-box-shadow: 0 0 0 10px #<span>cws_theme_main#</span> inset; -moz-box-shadow: 0 0 0 10px #<span>cws_theme_main#</span> inset; box-shadow: 0 0 0 10px #<span>cws_theme_main#</span> inset; }	#list-grid > div.active,.accordion > dt > a > i,.toggle > dt > a:before,.comment .reply:hover,.ui-datepicker-prev,.ui-datepicker-next{ -webkit-box-shadow: 0 0 0 1px #<span>cws_theme_main#</span> inset; -moz-box-shadow: 0 0 0 1px #<span>cws_theme_main#</span> inset; box-shadow: 0 0 0 1px #<span>cws_theme_main#</span> inset; }	.comment .reply, .ui-datepicker-prev:hover, .ui-datepicker-next:hover{ -webkit-box-shadow: 0 0 0 14px #<span>cws_theme_main#</span> inset; -moz-box-shadow: 0 0 0 14px #<span>cws_theme_main#</span> inset; box-shadow: 0 0 0 14px #<span>cws_theme_main#</span> inset; }	.alt-1 .gift-inside, .alt-2 .gift-inside{    -webkit-box-shadow: 0 0 0 200px rgba(<span class="darknest">cws_theme_main#</span>, 0.85) inset; -moz-box-shadow: 0 0 0 200px rgba(<span class="darknest">cws_theme_main#</span>, 0.85) inset; box-shadow: 0 0 0 200px rgba(<span class="darknest">cws_theme_main#</span>, 0.85) inset;}	.alt-1.portfolio-item a:hover .portfolio-media:before,.blog-item .blog-media:before{ background-color: rgba(<span class="darknest">cws_theme_main#</span>, 0.6); }	.ih-item.circle.effect13 .info{ background-color: rgba(<span class="darknest">cws_theme_main#</span>, 0.9); }	.shop-container.alt-2 .shop-media:before, .alt-1 .news-media:before{ background-color: rgba(<span class="darknest">cws_theme_main#</span>, 0.7); }   </div>  </div>  <style id="cws-cp-1"></style>')

		jQuery('#tuner-switcher').on('click', function()
		{
			jQuery('#tuner').toggleClass('tuner-visible');
		});

		jQuery('.color-picker').each( function(){
			var el = jQuery(this);
			var def_color = el.data( 'color' );
			var id = el.attr('id');
			var matches = /color-(\d+)/.exec( id );
			if ( matches != null ){
				var index = matches[1];
				var tuner_id = 'tuner-style-' + index;
				var style_id = 'cws-cp-' + index;
				var tuner_el = jQuery( '#' + tuner_id );
				var style_el = jQuery( '#' + style_id );
				if ( tuner_el.length && style_el.length ){
					
					el.ColorPicker({
						color: def_color,
						onShow: function(colpkr)
						{
							jQuery(colpkr).fadeIn(300);
							return false;
						},
						onHide: function(colpkr)
						{
							jQuery(colpkr).fadeOut(300);
							return false;
						},
						onChange: function (hsb, hex, rgb) {
							el.css('background-color', '#' + hex);
							tuner_el.find('span').text(hex);
							tuner_el.find('span.darknest').text(cws_Hex2RGBwithdark(hex,1));
							style_el.text(tuner_el.text());
						}
					});
				}

			}
		});
		$("html").addClass("t-pattern-1");
		jQuery('#tuner').on('click', '.patterns li', function()
		{
			jQuery(".tuner .patterns li").removeClass('active');
			jQuery(this).addClass("active");
			var body_el, body_cls, matches, old_pattern, new_pattern_index, new_pattern;
			body_el = jQuery('html');
			body_cls = body_el.attr('class');
			matches = /t-pattern-(\d+)/.exec( body_cls );
			if ( matches != null ){
				old_pattern = matches[0];
				body_el.removeClass(old_pattern);
			}
			new_pattern_index = jQuery(this).data('pattern');
			new_pattern = "t-pattern-" + new_pattern_index;
			body_el.addClass(new_pattern);
		});
		jQuery('#tuner').on('click', '.page-style', function() {
			$('.tuner .page-style').removeClass('active');
			$(this).addClass("active");
			if ( $(this).hasClass("boxed") ) {
				$("body").addClass("boxed");
			} else {
				$("body").removeClass("boxed");
			}
			width_sticky ();
			$(window).resize(function(){
				width_sticky();
			})
		})
	}
});
function width_sticky () {
	if ( $("body").hasClass("boxed") ) {
		var width_body = $("body").innerWidth();
		$("body.boxed .sticky-menu").css({"width":width_body+"px"});
	} else {
		$("body .sticky-menu").css({"width":"100%","left":"0"});
	}
}
function cws_Hex2RGBwithdark(hex,coef_color) {

  var coef_color = coef_color == undefined ? 1 : coef_color;
  var hex = hex.replace("#", "");

  var color = '';

  if (hex.length == 3) {
   color = Math.round(hexdec(hex.substr(0,1))/coef_color)+',';
   color = color + Math.round(hexdec(hex.substr(1,1))/coef_color)+',';
   color = color + Math.round(hexdec(hex.substr(2,1))/coef_color);
  }else if(hex.length == 6){
   color = Math.round(hexdec(hex.substr(0,2))/coef_color)+',';
   color = color + Math.round(hexdec(hex.substr(2,2))/coef_color)+',';
   color = color + Math.round(hexdec(hex.substr(4,2))/coef_color);
  }
  return color;
 }
 function hexdec(hex_string) {
  hex_string = (hex_string + '')
  .replace(/[^a-f0-9]/gi, '');
  return parseInt(hex_string, 16);
 }