/* Initialize
*/
var kt_isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (kt_isMobile.Android() || kt_isMobile.BlackBerry() || kt_isMobile.iOS() || kt_isMobile.Opera() || kt_isMobile.Windows());
    }
};
jQuery(document).ready(function ($) {

	// Bootstrap Init
		$("[rel=tooltip]").tooltip();
		$('[data-toggle=tooltip]').tooltip();
		$("[data-toggle=popover]").popover();
		$('#authorTab a').click(function (e) {e.preventDefault(); $(this).tab('show'); });
		$('.sc_tabs a').click(function (e) {e.preventDefault(); $(this).tab('show'); });
		
			$(document).mouseup(function (e) {
			    var container = $("#kad-menu-search-popup");
				if (!container.is(e.target) && container.has(e.target).length === 0) {
			        $('#kad-menu-search-popup.in').collapse('hide');
			    }
			});
		$(".videofit").fitVids();
		$(".embed-youtube").fitVids();

		$('.collapse-next').click(function (e) {
			//e.preventDefault();
		    var $target = $(this).siblings('.sf-dropdown-menu');
		     if($target.hasClass('in') ) {
		    	$target.collapse('toggle');
		    	$(this).removeClass('toggle-active');
		    } else {
		    	$target.collapse('toggle');
		    	$(this).addClass('toggle-active');
		    }
		});
	// Lightbox
		$.extend(true, $.magnificPopup.defaults, {
			tClose: '',
			tLoading: light_load, // Text that is displayed during loading. Can contain %curr% and %total% keys
			gallery: {
				tPrev: '', // Alt text on left arrow
				tNext: '', // Alt text on right arrow
				tCounter: light_of // Markup for "1 of 7" counter
			},
			image: {
				tError: light_error, // Error message when image could not be loaded
				titleSrc: function(item) {
					return item.el.find('img').attr('alt');
					}
				}
		});
		$("a[rel^='lightbox']").magnificPopup({type:'image'});
		$("a[data-rel^='lightbox']").magnificPopup({type:'image'});
		$('.kad-light-gallery').each(function(){
			$(this).find('a[rel^="lightbox"]').magnificPopup({
				type: 'image',
				gallery: {
					enabled:true
					},
					image: {
						titleSrc: 'title'
					},
				});
		});
		$('.kad-light-gallery').each(function(){
			$(this).find("a[data-rel^='lightbox']").magnificPopup({
				type: 'image',
				gallery: {
					enabled:true
					},
					image: {
						titleSrc: 'title'
					}
				});
		});
		$('.kad-light-wp-gallery').each(function(){
			$(this).find('a[rel^="lightbox"]').magnificPopup({
				type: 'image',
				gallery: {
					enabled:true
					},
					image: {
						titleSrc: function(item) {
						return item.el.find('img').attr('alt');
						}
					}
				});
		});
		$('.kad-light-wp-gallery').each(function(){
			$(this).find("a[data-rel^='lightbox']").magnificPopup({
				type: 'image',
				gallery: {
					enabled:true
					},
					image: {
						titleSrc: function(item) {
						return item.el.find('img').attr('alt');
						}
					}
				});
		});
		$("a.ktvideolight").magnificPopup({type:'iframe'});
		$(".no-lightbox").magnificPopup({
		disableOn: function() {
		 return false;
		}
		});
		function kad_infintescroll_newelements() {
			$("a[rel^='lightbox']").magnificPopup({type:'image'});
		$("a[data-rel^='lightbox']").magnificPopup({type:'image'});
		$('.kad-light-gallery').each(function(){
			$(this).find('a[rel^="lightbox"]').magnificPopup({
				type: 'image',
				gallery: {
					enabled:true
					},
					image: {
						titleSrc: 'title'
					},
				});
		});
		$('.kad-light-gallery').each(function(){
			$(this).find("a[data-rel^='lightbox']").magnificPopup({
				type: 'image',
				gallery: {
					enabled:true
					},
					image: {
						titleSrc: 'title'
					}
				});
		});
		$('.kad-light-wp-gallery').each(function(){
			$(this).find('a[rel^="lightbox"]').magnificPopup({
				type: 'image',
				gallery: {
					enabled:true
					},
					image: {
						titleSrc: function(item) {
						return item.el.find('img').attr('alt');
						}
					}
				});
		});
		$('.kad-light-wp-gallery').each(function(){
			$(this).find("a[data-rel^='lightbox']").magnificPopup({
				type: 'image',
				gallery: {
					enabled:true
					},
					image: {
						titleSrc: function(item) {
						return item.el.find('img').attr('alt');
						}
					}
				});
		});
		}
		$(window).on("infintescrollnewelements", function( event ) {kad_infintescroll_newelements();});
			// Custom Select
		$('#archive-orderby').customSelect();
		if( $(window).width() > 790 && !kt_isMobile.any() ) {
			$('.kad-select').select2({minimumResultsForSearch: -1 });
			$('.variations td.product_value select').select2({minimumResultsForSearch: -1 });
			$('.woocommerce-ordering .orderby').select2({minimumResultsForSearch: -1 });
			$('.component_options_select').select2({minimumResultsForSearch: -1 });
			$( '.component' ).on( 'wc-composite-item-updated', function() {
				$('select').select2("destroy");
				$('select').select2({minimumResultsForSearch: -1 });
			});
		} else {
			$('.kad-select').customSelect();
			$('.woocommerce-ordering .orderby').customSelect();
			$('.variations td.product_value select').customSelect();
		}
		var select2select = $('body').attr('data-jsselect');
		if( $(window).width() > 790 && !kt_isMobile.any() && (select2select == 1 )) {
			$('select').select2({minimumResultsForSearch: -1 });
			$('select.country_select').select2();
			$('select.state_select').select2();
		}

	if ($('.tab-pane .kad_product_wrapper').length) {
		var $container = $('.kad_product_wrapper');
		$('.sc_tabs').on('shown.bs.tab', function  (e) {
			$container.isotopeb({masonry: {columnWidth: '.kad_product'}, transitionDuration: '0.8s'});
		});
	}
	if ($('.panel-body .kad_product_wrapper').length) {
		var $container = $('.kad_product_wrapper');
		$('.panel-group').on('shown.bs.collapse', function  (e) {
		$container.isotopeb({masonry: {columnWidth: '.kad_product'}, transitionDuration: '0.8s'});
		});
		$('.panel-group').on('hidden.bs.collapse', function  (e) {
			$container.isotopeb({masonry: {columnWidth: '.kad_product'}, transitionDuration: '0.8s'});
		});
	}
	// anchor scroll
	
		$('.kad_fullslider_arrow').localScroll();
		var stickyheader = $('body').attr('data-sticky'),
		header = $('#kad-banner'),
		productscroll = $('body').attr('data-product-tab-scroll');
		if(productscroll == 1 && $(window).width() > 992){
			if(stickyheader == 1) {var offset_h = $(header).height() + 100; } else { var offset_h = 100;}
			$('.woocommerce-tabs').localScroll({offset: -offset_h});
		}

	// Sticky Header Varibles
	var stickyheader = $('body').attr('data-sticky'),
		shrinkheader = $('#kad-banner').attr('data-header-shrink'),
		mobilestickyheader = $('#kad-banner').attr('data-mobile-sticky'),
		win = $(window),
		header = $('.stickyheader #kad-banner'),
		headershrink = $('.stickyheader #kad-banner #kad-shrinkheader'),
		logo = $('.stickyheader #kad-banner #logo a, .stickyheader #kad-banner #logo a #thelogo'),
		logobox = $('.stickyheader #kad-banner #logo a img'),
		menu = $('.stickyheader #kad-banner .nav-main ul.sf-menu > li > a'),
		content = $('.stickyheader .wrap'),
		mobilebox = $('.stickyheader .mobile-stickyheader .mobile_menu_collapse'),
		headerouter = $('.stickyheader .sticky-wrapper'),
		shrinkheader_height = $('#kad-banner').attr('data-header-base-height'),
		topOffest = $('body').hasClass('admin-bar') ? 32 : 0;

	function kad_sticky_header() {
		var header_height = $(header).height(),
		topbar_height = $('.stickyheader #kad-banner #topbar').height();
		set_height = function() {
				var scrollt = win.scrollTop(),
                newH = 0;
                if(scrollt < shrinkheader_height/1) {
                    newH = shrinkheader_height - scrollt/2;
                    header.removeClass('header-scrolled');
                }else{
                    newH = shrinkheader_height/2;
                    header.addClass('header-scrolled');
                }
                menu.css({'height': newH + 'px', 'lineHeight': newH + 'px'});
                headershrink.css({'height': newH + 'px', 'lineHeight': newH + 'px'});
                header.css({'height': newH + topbar_height + 'px'});
                logo.css({'height': newH + 'px', 'lineHeight': newH + 'px'});
                logobox.css({'maxHeight': newH + 'px'});
            };
		if (shrinkheader == 1 && stickyheader == 1 && $(window).width() > 992 ) {
	        header.css({'top': topOffest + 'px'});
			header.sticky({topSpacing:topOffest});
			win.scroll(set_height);
		} else if( stickyheader == 1 && $(window).width() > 992) {
			header.css({'height': header_height + 'px'});
			header.css({'top': topOffest + 'px'});
			header.sticky({topSpacing:topOffest});
		} else if (shrinkheader == 1 && stickyheader == 1 && mobilestickyheader == 1 && $(window).width() < 992 ) {
			header.css({'height': 'auto'});
			header.sticky({topSpacing:topOffest});
			var win_height = $(window).height();
			var mobileh_height = shrinkheader_height/2;
			mobilebox.css({'maxHeight': win_height - mobileh_height + 'px'});
		} else {
			header.css({'position':'static'});
			content.css({'padding-top': '15px'});
			header.css({'height': 'auto'});
		}

	}
	header.imagesLoadedn( function() {
		kad_sticky_header();
	});
	//Superfish Menu
		$('ul.sf-menu').superfish({
			delay:       200,
			animation:   {opacity:'show',height:'show'},
			speed:       'fast'
		});
	function kad_fullwidth_panel() {
		$('.kt-panel-row-stretch').each(function(){
			var margins = $(window).width() - $(this).parent('.panel-grid').width();
			$(this).css({'padding-left': margins/2 + 'px'});
			$(this).css({'padding-right': margins/2 + 'px'});
			$(this).css({'margin-left': '-' + margins/2 + 'px'});
			$(this).css({'margin-right': '-' + margins/2 + 'px'});
			$(this).css({'visibility': 'visible'});
		});
		$('.panel-row-style-wide-grey').each(function(){
			var margins = $(window).width() - $(this).parent('.panel-grid').width();
			$(this).css({'padding-left': margins/2 + 'px'});
			$(this).css({'padding-right': margins/2 + 'px'});
			$(this).css({'margin-left': '-' + margins/2 + 'px'});
			$(this).css({'margin-right': '-' + margins/2 + 'px'});
			$(this).css({'visibility': 'visible'});
		});
		$('.panel-row-style-wide-feature').each(function(){
			var margins = $(window).width() - $(this).parent('.panel-grid').width();
			$(this).css({'padding-left': margins/2 + 'px'});
			$(this).css({'padding-right': margins/2 + 'px'});
			$(this).css({'margin-left': '-' + margins/2 + 'px'});
			$(this).css({'margin-right': '-' + margins/2 + 'px'});
			$(this).css({'visibility': 'visible'});
		});
		$('.panel-row-style-wide-parallax').each(function(){
			var margins = $(window).width() - $(this).parent('.panel-grid').width();
			$(this).css({'padding-left': margins/2 + 'px'});
			$(this).css({'padding-right': margins/2 + 'px'});
			$(this).css({'margin-left': '-' + margins/2 + 'px'});
			$(this).css({'margin-right': '-' + margins/2 + 'px'});
			$(this).css({'visibility': 'visible'});
		});
		$('.kt-panel-row-full-stretch').each(function(){
			var margins = $(window).width() - $(this).parent('.panel-grid').width();
			$(this).css({'margin-left': '-' + margins/2 + 'px'});
			$(this).css({'margin-right': '-' + margins/2 + 'px'});
			$(this).css({'width': + $(window).width() + 'px'});
			$(this).css({'visibility': 'visible'});
		});
		$('.kt-custom-row-full-stretch').each(function(){
			var margins = $(window).width() - $(this).parents('#content').width();
			$(this).css({'margin-left': '-' + margins/2 + 'px'});
			$(this).css({'margin-right': '-' + margins/2 + 'px'});
			$(this).css({'width': + $(window).width() + 'px'});
			$(this).css({'visibility': 'visible'});
		});
		$('.kt-custom-row-full').each(function(){
			var margins = $(window).width() - $(this).parents('#content').width();
			$(this).css({'padding-left': margins/2 + 'px'});
			$(this).css({'padding-right': margins/2 + 'px'});
			$(this).css({'margin-left': '-' + margins/2 + 'px'});
			$(this).css({'margin-right': '-' + margins/2 + 'px'});
			$(this).css({'visibility': 'visible'});
		});
	}
	kad_fullwidth_panel();
	$(window).on("debouncedresize", function( event ) {kad_fullwidth_panel();});
	 
	 //aminiate in
    var $animate = $('body').attr('data-animate');
    if( $animate == 1 && $(window).width() > 790) {
            //fadein
        $('.kad-animation').each(function() {
            $(this).appear(function() {
            	$(this).delay($(this).attr('data-delay')).animate({'opacity' : 1, 'top' : 0},800,'swing');},{accX: 0, accY: -25},'easeInCubic');
        });
        $('.kt-animate-fade-in-up').each(function() {
            $(this).appear(function() {
            	$(this).animate({'opacity' : 1, 'top' : 0},900,'swing');},{accX: 0, accY: -25},'easeInCubic');
        });
        $('.kt-animate-fade-in-down').each(function() {
            $(this).appear(function() {
            	$(this).animate({'opacity' : 1, 'top' : 0},900,'swing');},{accX: 0, accY: -25},'easeInCubic');
        });
        $('.kt-animate-fade-in-left').each(function() {
            $(this).appear(function() {
            	$(this).animate({'opacity' : 1, 'left' : 0},900,'swing');},{accX: -25, accY: 0},'easeInCubic');
        });
        $('.kt-animate-fade-in-right').each(function() {
            $(this).appear(function() {
            	$(this).animate({'opacity' : 1, 'right' : 0},900,'swing');},{accX: -25, accY: 0},'easeInCubic');
        });
        $('.kt-animate-fade-in').each(function() {
            $(this).appear(function() {
            	$(this).animate({'opacity' : 1 },900,'swing');});
        });
    } else {
    	$('.kad-animation').each(function() {
    		$(this).animate({'opacity' : 1, 'top' : 0});
    	});
    	$('.kt-animate-fade-in-up').each(function() {
    		$(this).animate({'opacity' : 1, 'top' : 0});
    	});
    	$('.kt-animate-fade-in-down').each(function() {
    		$(this).animate({'opacity' : 1, 'top' : 0});
    	});
    	$('.kt-animate-fade-in-left').each(function() {
    		$(this).animate({'opacity' : 1, 'left' : 0});
    	});
    	$('.kt-animate-fade-in-right').each(function() {
    		$(this).animate({'opacity' : 1, 'right' : 0});
    	});
    	$('.kt-animate-fade-in').each(function() {
    		$(this).animate({'opacity' : 1});
    	});
    }

     //init Flexslider
     $('.kt-flexslider').each(function(){

	 	var flex_speed = $(this).data('flex-speed'),
		flex_animation = $(this).data('flex-animation'),
		flex_initdelay = $(this).data('flex-initdelay'),
		flex_animation_speed = $(this).data('flex-anim-speed'),
		flex_auto = $(this).data('flex-auto');
		if(flex_initdelay == null) {flex_initdelay = 0;}
	 	$(this).flexslider({
	 		animation: flex_animation,
			animationSpeed: flex_animation_speed,
			slideshow: flex_auto,
			initDelay: flex_initdelay,
			slideshowSpeed: flex_speed,
			start: function ( slider ) {
				slider.removeClass( 'loading' );
			}
		});
    });

     //init isotope
    $('.init-isotope').each(function(){
    	var isocontainer = $(this),
    	iso_selector = $(this).data('iso-selector'),
    	iso_style = $(this).data('iso-style'),
    	iso_filter = $(this).data('iso-filter');
		isocontainer.imagesLoadedn( function(){
			isocontainer.isotopeb({masonry: {columnWidth: iso_selector}, layoutMode:iso_style, itemSelector: iso_selector, transitionDuration: '0.8s'});
			if(isocontainer.attr('data-fade-in') == 1) {
				var isochild = isocontainer.find('.kt_item_fade_in');
				isochild.css('opacity',0);
					isochild.each(function(i){
									$(this).delay(i*150).animate({'opacity':1},350);
					});
			}
			if(iso_filter == true) {
				var thisparent = isocontainer.parents('.main');
				var thisfilters = thisparent.find('#filters');
				if(thisfilters.length) {
				thisfilters.on( 'click', 'a', function( event ) {
						var filtr = $(this).attr('data-filter');
						isocontainer.isotopeb({ filter: filtr });
						  return false; 
					});
					var $optionSets = $('#options .option-set'),
	          		$optionLinks = $optionSets.find('a');	
					$optionLinks.click(function(){ 
						var $this = $(this); if ( $this.hasClass('selected') ) {return false;}
						var $optionSet = $this.parents('.option-set'); $optionSet.find('.selected').removeClass('selected'); $this.addClass('selected');
					});
				}
			}
		});
				
	});
// Toggle 
if ($('.kt_product_toggle_container').length) {
			var thistoggleon = $('.kt_product_toggle_container .toggle_list'),
			thistoggleoff = $('.kt_product_toggle_container .toggle_grid');
			thistoggleon.click(function(){
					if ( $(this).hasClass('toggle_active') ) {return false;}
					$(this).parents('.kt_product_toggle_container').find('.toggle_active').removeClass('toggle_active');
					$(this).addClass('toggle_active');
					if ($('.kad_product_wrapper').length) { 
						$('.kad_product_wrapper').addClass('shopcolumn1');
						$('.kad_product_wrapper').addClass('tfsinglecolumn');
						var $container = $('.kad_product_wrapper'),
						iso_selector = $('.kad_product_wrapper').data('iso-selector');
						$container.isotopeb({masonry: {columnWidth: iso_selector}, transitionDuration: '.4s'});
					}
					  return false; 
				});
			thistoggleoff.click(function(){
					if ( $(this).hasClass('toggle_active') ) {return false;}
					$(this).parents('.kt_product_toggle_container').find('.toggle_active').removeClass('toggle_active');
					$(this).addClass('toggle_active');
					if ($('.kad_product_wrapper').length) { 
						$('.kad_product_wrapper').removeClass('shopcolumn1');
						$('.kad_product_wrapper').removeClass('tfsinglecolumn');
						var $container = $('.kad_product_wrapper'),
						iso_selector = $('.kad_product_wrapper').data('iso-selector');
						$container.isotopeb({masonry: {columnWidth: iso_selector}, transitionDuration: '.4s'});
					}
					  return false; 
				});
			}
	if ($('.kt_product_toggle_container_list').length) {
			var thistoggleon = $('.kt_product_toggle_container_list .toggle_list'),
			thistoggleoff = $('.kt_product_toggle_container_list .toggle_grid');
			thistoggleon.click(function(){
					if ( $(this).hasClass('toggle_active') ) {return false;}
					$(this).parents('.kt_product_toggle_container_list').find('.toggle_active').removeClass('toggle_active');
					$(this).addClass('toggle_active');
					if ($('.kad_product_wrapper').length) { 
						$('.kad_product_wrapper').addClass('shopcolumn1');
						$('.kad_product_wrapper').addClass('tfsinglecolumn');
						$('.kad_product_wrapper').removeClass('kt_force_grid_three');
						var $container = $('.kad_product_wrapper'),
						iso_selector = $('.kad_product_wrapper').data('iso-selector');
						$container.isotopeb({masonry: {columnWidth: iso_selector}, transitionDuration: '.4s'});
					}
					  return false; 
				});
			thistoggleoff.click(function(){
					if ( $(this).hasClass('toggle_active') ) {return false;}
					$(this).parents('.kt_product_toggle_container_list').find('.toggle_active').removeClass('toggle_active');
					$(this).addClass('toggle_active');
					if ($('.kad_product_wrapper').length) { 
						$('.kad_product_wrapper').removeClass('shopcolumn1');
						$('.kad_product_wrapper').removeClass('tfsinglecolumn');
						$('.kad_product_wrapper').addClass('kt_force_grid_three');
						var $container = $('.kad_product_wrapper'),
						iso_selector = $('.kad_product_wrapper').data('iso-selector');
						$container.isotopeb({masonry: {columnWidth: iso_selector}, transitionDuration: '.4s'});
					}
					  return false; 
				});
	}
if ($('.woocommerce-tabs .panel .init-isotope').length) {
		var $container = $('.init-isotope'),
		iso_selector = $('.init-isotope').data('iso-selector');
		function woo_refreash_iso(){
			$container.isotopeb({masonry: {columnWidth: iso_selector}, transitionDuration: '0s'});
		}
	$('.woocommerce-tabs ul.tabs li a' ).click( function() {
		setTimeout(woo_refreash_iso, 50);
	});
}
if ($('.panel-body .init-isotope').length) {
		var $container = $('.init-isotope'),
		iso_selector = $('.init-isotope').data('iso-selector');
		$('.panel-group').on('shown.bs.collapse', function  (e) {
		$container.isotopeb({masonry: {columnWidth: iso_selector}, transitionDuration: '0s'});
		});
	}
	if ($('.tab-pane .init-isotope').length) {
		var $container = $('.init-isotope'),
		iso_selector = $('.init-isotope').data('iso-selector');
		$('.sc_tabs').on('shown.bs.tab', function  (e) {
			$container.isotopeb({masonry: {columnWidth: iso_selector}, transitionDuration: '0s'});
		});
	}
		 //init carousel
     jQuery('.initcaroufedsel').each(function(){
     	  var container = jQuery(this);
          var wcontainerclass = container.data('carousel-container'), 
          cspeed = container.data('carousel-speed'), 
          ctransition = container.data('carousel-transition'),
          cscroll = container.data('carousel-scroll'), 
          cauto = container.data('carousel-auto'),
          carouselid = container.data('carousel-id'),
          ss = container.data('carousel-ss'), 
          xs = container.data('carousel-xs'),
          sm = container.data('carousel-sm'),
          md = container.data('carousel-md');
          if(cscroll == '') {cscroll = null;}
          var wcontainer = jQuery(wcontainerclass);
          function getUnitWidth() {var width;
          if(jQuery(window).width() <= 540) {
          width = wcontainer.width() / ss;
          } else if(jQuery(window).width() <= 768) {
          width = wcontainer.width() / xs;
          } else if(jQuery(window).width() <= 990) {
          width = wcontainer.width() / sm;
          } else {
          width = wcontainer.width() / md;
          }
          return width;
          }

          function setWidths() {
          var unitWidth = getUnitWidth() -1;
          container.children().css({ width: unitWidth });
          }
          setWidths();
          function initCarousel() {
          container.carouFredSel({
            scroll: {items:cscroll, easing: "swing", duration: ctransition, pauseOnHover : true}, 
            auto: {play: cauto, timeoutDuration: cspeed},
              prev: '#prevport-'+carouselid, next: '#nextport-'+carouselid, pagination: false, swipe: true, items: {visible: null}
            });
	      }
	      container.imagesLoadedn( function(){
	      	wcontainer.animate({'opacity' : 1});
          	initCarousel();
          	wcontainer.parent().removeClass('carousel_outerrim_load');
      	});
          	jQuery(window).on("debouncedresize", function( event ) {
          		container.trigger("destroy");
          		setWidths();
          		initCarousel();
          	});
    });
		//init carouselslider
	    jQuery('.initcarouselslider').each(function(){
	     	  var container = jQuery(this);
	          var wcontainerclass = container.data('carousel-container'), 
	          cspeed = container.data('carousel-speed'), 
	          ctransition = container.data('carousel-transition'),
	          cauto = container.data('carousel-auto'),
	          carouselid = container.data('carousel-id'),
	          carheight = container.data('carousel-height'),
	          align = 'center';
	          var wcontainer = jQuery(wcontainerclass);

	          function setWidths() {
	            var unitWidth = container.width();
	            container.children().css({ width: unitWidth });
	              if(jQuery(window).width() <= 768) {
	                  carheight = null;
	                  container.children().css({ height: 'auto' });
	              }
	          }
	          setWidths();
	          function initCarouselslider() {
	            container.carouFredSel({
	              width: '100%',
	              height: carheight,
	              align: align,
	              auto: {play: cauto, timeoutDuration: cspeed},
	              scroll: {items : 1,easing: 'quadratic'},
	              items: {visible: 1,width: 'variable'},
	              prev: '#prevport-'+carouselid,
	              next: '#nextport-'+carouselid,
	              swipe: {onMouse: false,onTouch: true},
	            });
		      }
		      container.imagesLoadedn( function(){
	          	initCarouselslider();
	            wcontainer.animate({'opacity' : 1});
	            wcontainer.css({ height: 'auto' });
	            wcontainer.parent().removeClass('loading');
	      	});
	          	jQuery(window).on("debouncedresize", function( event ) {
	          		container.trigger("destroy");
	          		setWidths();
	          		initCarouselslider();
	          	});
	    });
    //init image carousel
    jQuery('.initimagecarousel').each(function(){
     	  var container = jQuery(this);
          var wcontainerclass = container.data('carousel-container'), 
          cspeed = container.data('carousel-speed'), 
          ctransition = container.data('carousel-transition'),
          cauto = container.data('carousel-auto'),
          carouselid = container.data('carousel-id'),
          carheight = container.data('carousel-height'),
          align = false;
          var wcontainer = jQuery(wcontainerclass);

          function setWidths() {
          	if(jQuery(window).width() <= 767) {
            	align = 'center';
                carheight = null;
                var unitWidth = jQuery(window).width() -10;
                container.children().css({ width: unitWidth });
                container.children().css({ height: 'auto' });
            }
          }
          setWidths();
        function initImageCarousel() {
            container.carouFredSel({
				width: '100%',
				height: carheight,
				align: align,
				auto: {play: true, timeoutDuration: cspeed},
				scroll: {items : 1,easing: 'quadratic'},
				items: {visible: 1, width: 'variable'},
                prev: '#prevport-'+carouselid, 
                next: '#nextport-'+carouselid,
                swipe: {onMouse: true,onTouch: true},
                onCreate: function() {
					jQuery('.gallery-carousel').css('positon','static');
				}
            });
	      }
	    container.imagesLoadedn( function(){
          	initImageCarousel();
            wcontainer.animate({'opacity' : 1});
            wcontainer.css({ height: 'auto' });
            wcontainer.parent().removeClass('loading');
      	});
          	jQuery(window).on("debouncedresize", function( event ) {
          		container.trigger("destroy");
          		setWidths();
          		initImageCarousel();
          	});
    });

});
if( kt_isMobile.any() ) {
jQuery(document).ready(function ($) {
	matchMedia('only screen and (max-width: 480px)').addListener(function(list){
		$('select.hasCustomSelect').removeAttr("style");
		$('select.hasCustomSelect').css({'width':'250px'});
    	$('.kad-select.customSelect').remove();
    	$('select.kad-select').customSelect();
    	$('.customSelectInner').css('width','100%');
	});
		$('.caroufedselclass').tswipe({
			              excludedElements:"button, input, select, textarea, .noSwipe",
						   tswipeLeft: function() {
							$('.caroufedselclass').trigger('next', 1);
						  },
						  tswipeRight: function() {
							$('.caroufedselclass').trigger('prev', 1);
						  },
						  tap: function(event, target) {
							window.open(jQuery(target).closest('.grid_item').find('a').attr('href'), '_self');
						  }
		});
		$('.caroufedselgallery').tswipe({
			              excludedElements:"button, input, select, textarea, .noSwipe",
						   tswipeLeft: function() {
							$('.caroufedselgallery').trigger('next', 1);
						  },
						  tswipeRight: function() {
							$('.caroufedselgallery').trigger('prev', 1);
						  },
						  tap: function(event, target) {
							  magnificPopup(jQuery(target).closest('.grid_item').find('a.lightboxhover').attr('href'));
							}
		});
	});
}
jQuery( window ).load(function () {
	   jQuery.stellar({
    	horizontalScrolling: false,
		verticalOffset: 40
    });
	jQuery('body').animate({'opacity' : 1});
});

