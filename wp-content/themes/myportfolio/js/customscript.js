jQuery.fn.exists = function(callback) {
  var args = [].slice.call(arguments, 1);
  if (this.length) {
	callback.call(this, args);
  }
  return this;
};

/*----------------------------------------------------
/* Make all anchor links smooth scrolling
/*--------------------------------------------------*/
jQuery(document).ready(function($) {
 // scroll handler
  var scrollToAnchor = function( id, event ) {
	// grab the element to scroll to based on the name
	var elem = $("a[name='"+ id +"']");
	// if that didn't work, look for an element with our ID
	if ( typeof( elem.offset() ) === "undefined" ) {
	  elem = $("#"+id);
	}
	// if the destination element exists
	if ( typeof( elem.offset() ) !== "undefined" ) {
	  // cancel default event propagation
	  event.preventDefault();

	  // do the scroll
	  // also hide mobile menu
	  var scroll_to = elem.offset().top;
	  $('html, body').removeClass('mobile-menu-active').animate({
			  scrollTop: scroll_to
	  }, 600, 'swing', function() { if (scroll_to > 46) window.location.hash = id; } );
	}
  };
  // bind to click event
  $("a").click(function( event ) {
	// only do this if it's an anchor link
	var href = $(this).attr("href");
	if ( href && href.match("#") && href !== '#' ) {
	  // scroll to the location
	  var parts = href.split('#'),
		url = parts[0],
		target = parts[1];
	  if ((!url || url == window.location.href.split('#')[0]) && target)
		scrollToAnchor( target, event );
	}
  });
});

/*----------------------------------------------------
/*  Dropdown menu
/* ------------------------------------------------- */
jQuery(document).ready(function($) {
	
	function mtsDropdownMenu() {
		var wWidth = $(window).width();
		if(wWidth > 865) {
			$('.navigation ul.sub-menu, .navigation ul.children').hide();
			var timer;
			var delay = 100;
			$('.navigation li').hover( 
			  function() {
				var $this = $(this);
				timer = setTimeout(function() {
					$this.children('ul.sub-menu, ul.children').slideDown('fast');
				}, delay);
				
			  },
			  function() {
				$(this).children('ul.sub-menu, ul.children').hide();
				clearTimeout(timer);
			  }
			);
		} else {
			$('.navigation li').unbind('hover');
			$('.navigation li.active > ul.sub-menu, .navigation li.active > ul.children').show();
		}
	}

	mtsDropdownMenu();

	$(window).resize(function() {
		mtsDropdownMenu();
	});
});

/*---------------------------------------------------
/*  Vertical menus toggles
/* -------------------------------------------------*/
jQuery(document).ready(function($) {

	$('.widget_nav_menu, .navigation .menu').addClass('toggle-menu');
	$('.toggle-menu ul.sub-menu, .toggle-menu ul.children').addClass('toggle-submenu');
	$('.toggle-menu ul.sub-menu').parent().addClass('toggle-menu-item-parent');

	$('.toggle-menu .toggle-menu-item-parent').append('<span class="toggle-caret"><i class="fa fa-plus"></i></span>');

	$('.toggle-caret').click(function(e) {
		e.preventDefault();
		$(this).parent().toggleClass('active').children('.toggle-submenu').slideToggle('fast');
	});
});

/*----------------------------------------------------
/* Social button scripts
/*---------------------------------------------------*/
jQuery(document).ready(function($){
	(function(d, s) {
	  var js, fjs = d.getElementsByTagName(s)[0], load = function(url, id) {
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.src = url; js.id = id;
		fjs.parentNode.insertBefore(js, fjs);
	  };
	jQuery('span.facebookbtn, span.facebooksharebtn, .facebook_like').exists(function() {
	  load('//connect.facebook.net/en_US/all.js#xfbml=1&version=v2.3', 'fbjssdk');
	});
	jQuery('span.gplusbtn').exists(function() {
	  load('https://apis.google.com/js/plusone.js', 'gplus1js');
	});
	jQuery('span.twitterbtn').exists(function() {
	  load('//platform.twitter.com/widgets.js', 'tweetjs');
	});
	jQuery('span.linkedinbtn').exists(function() {
	  load('//platform.linkedin.com/in.js', 'linkedinjs');
	});
	jQuery('span.pinbtn').exists(function() {
	  load('//assets.pinterest.com/js/pinit.js', 'pinterestjs');
	});
	jQuery('span.stumblebtn').exists(function() {
	  load('//platform.stumbleupon.com/1/widgets.js', 'stumbleuponjs');
	});
	}(document, 'script'));
});

/*----------------------------------------------------
/* Lazy load avatars
/*---------------------------------------------------*/
jQuery(document).ready(function($){
	var lazyloadAvatar = function(){
		$('.comment-author .avatar').each(function(){
			var distanceToTop = $(this).offset().top;
			var scroll = $(window).scrollTop();
			var windowHeight = $(window).height();
			var isVisible = distanceToTop - scroll < windowHeight;
			if( isVisible ){
				var hashedUrl = $(this).attr('data-src');
				if ( hashedUrl ) {
					$(this).attr('src',hashedUrl).removeClass('loading');
				}
			}
		});
	};
	if ( $('.comment-author .avatar').length > 0 ) {
		$('.comment-author .avatar').each(function(i,el){
			$(el).attr('data-src', el.src).removeAttr('src').addClass('loading');
		});
		$(function(){
			$(window).scroll(function(){
				lazyloadAvatar();
			});
		});
		lazyloadAvatar();
	}
});

/*----------------------------------------------------
/* Next/Prev Articles' Toggle
/*---------------------------------------------------*/
jQuery(document).ready(function($){
	$('.single-prev-next .prev, .previous_post a.previous_full_post').hover(
		function () {
			$('.previous_post a.previous_full_post').animate({'left':'36px'},100, 'linear'),
			$('.next_post a.next_full_post').animate({'right':'-333px'},100, 'linear')
		}
	);
	$('.single-prev-next .next, .next_post a.next_full_post').hover(
		function () {
			$('.next_post a.next_full_post').animate({'right':'36px'},100, 'linear'),
			$('.previous_post a.previous_full_post').animate({'left':'-333px'},100, 'linear')
		}
	);
});

/*----------------------------------------------------
/* Loading Effects
/*---------------------------------------------------*/
jQuery(document).ready(function($) {

	if ( $('body').hasClass('mts-loading-active') ) {

		var isAnimating = false,
			docElem = window.document.documentElement,
			toUrl = '';

		/**
		 * gets the viewport width and height
		 * based on http://responsejs.com/labs/dimensions/
		 */
		function getViewport( axis ) {
			var client, inner;
			if( axis === 'x' ) {
				client = docElem['clientWidth'];
				inner = window['innerWidth'];
			}
			else if( axis === 'y' ) {
				client = docElem['clientHeight'];
				inner = window['innerHeight'];
			}
			
			return client < inner ? inner : client;
		}

		function scrollX() { return window.pageXOffset || docElem.scrollLeft; }
		function scrollY() { return window.pageYOffset || docElem.scrollTop; }

		if ( $('body').hasClass('mts-portfolio-loading-active') ) {

			$(document).on('click', '.mts-portfolio-loader-link', function(e) {

				e.preventDefault();

				if ( isAnimating ) {
					return false;
				}
				isAnimating = true;

				var $this = $(this),
					$item = $this.closest('.grid__item'),
					$gridEl = $('.page-container'),
					$gridItemsContainer = $('div.grid'),
					$contentItemsContainer = $('div.grid-popup-content'),
					$dummy = $('<div class="placeholder"></div>');

				toUrl = $this.attr('href');

				$item.addClass('grid__item--loading grid__item--animate');

				// set the width/heigth and position
				$dummy.css({
					WebkitTransform : 'translate3d(' + $item[0].offsetLeft + 'px, ' + $item[0].offsetTop + 'px, 0px) scale3d(' + $item[0].offsetWidth/$gridItemsContainer[0].offsetWidth + ',' + $item[0].offsetHeight/getViewport('y') + ',1)',
					transform	   : 'translate3d(' + $item[0].offsetLeft + 'px, ' + $item[0].offsetTop + 'px, 0px) scale3d(' + $item[0].offsetWidth/$gridItemsContainer[0].offsetWidth + ',' + $item[0].offsetHeight/getViewport('y') + ',1)'
				});

				// add transition class 
				$dummy.addClass('placeholder--trans-in');

				// insert it after all the grid items
				$gridItemsContainer.append( $dummy );

				$dummy.css({
					WebkitTransform : 'translate3d(0px, ' + scrollY() + 'px, 0px)',
					transform	   : 'translate3d(0px, ' + scrollY() + 'px, 0px)'
				});
			});
		}

		$(document).on("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", '.placeholder',  function() {
			// add transition class 
			$(this).removeClass('placeholder--trans-in').addClass('placeholder--trans-out');
			// position the content container
			$('div.grid-popup-content')/*.css('top', scrollY() + 'px' )*/.addClass('content--show');
			$(docElem).addClass('noscroll');
			isAnimating = false;

			window.location.href = toUrl;
		});

		if ( $('body').hasClass('mts-blog-loading-active') ) {

			$(document).on('click', '.mts-blog-loader-link', function(e) {

				e.preventDefault();

				if ( isAnimating ) {
					return false;
				}
				isAnimating = true;

				var $this = $(this),
					$item = $this.closest('.grid__item'),
					$gridEl = $('.page-container'),
					$gridItemsContainer = $('div.grid'),
					$contentItemsContainer = $('div.grid-popup-content'),
					$dummy = $('<div class="placeholder"></div>');

				toUrl = $this.attr('href');

				$item.addClass('grid__item--loading');
				setTimeout(function() {
					$item.addClass('grid__item--animate');
					// reveal/load content after the last element animates out (todo: wait for the last transition to finish)
					setTimeout(function() {
						// set the width/heigth and position
						$dummy.css({
							WebkitTransform : 'translate3d(' + $item[0].offsetLeft + 'px, ' + $item[0].offsetTop + 'px, 0px) scale3d(' + $item[0].offsetWidth/$gridItemsContainer[0].offsetWidth + ',' + $item[0].offsetHeight/getViewport('y') + ',1)',
							transform	   : 'translate3d(' + $item[0].offsetLeft + 'px, ' + $item[0].offsetTop + 'px, 0px) scale3d(' + $item[0].offsetWidth/$gridItemsContainer[0].offsetWidth + ',' + $item[0].offsetHeight/getViewport('y') + ',1)'
						});

						// add transition class 
						$dummy.addClass('placeholder--trans-in');

						// insert it after all the grid items
						$gridItemsContainer.append( $dummy );

						setTimeout(function() {
							$dummy.css({
								WebkitTransform : 'translate3d(0px, ' + scrollY() + 'px, 0px)',
								transform	   : 'translate3d(0px, ' + scrollY() + 'px, 0px)'
							});
						}, 25);
					}, 500);
				}, 2000);
			});
		}
	}

});

jQuery( window ).load(function() {
	if ( jQuery('.grid-popup-content.content--show').length ) {
		jQuery('.grid-popup-content').removeClass('content--show');
	}
});

/**
 * pathLoader.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2014, Codrops
 * http://www.codrops.com
 */
;( function( window ) {
	
	'use strict';

	function MtsPathLoader( el ) {
		this.el = el;
		// clear stroke
		this.el.style.strokeDasharray = this.el.style.strokeDashoffset = this.el.getTotalLength();
	}

	MtsPathLoader.prototype._draw = function( val ) {
		this.el.style.strokeDashoffset = this.el.getTotalLength() * ( 1 - val );
	}

	MtsPathLoader.prototype.setProgress = function( val, callback ) {
		this._draw(val);
		if( callback && typeof callback === 'function' ) {
			// give it a time (ideally the same like the transition time) so that the last progress increment animation is still visible.
			setTimeout( callback, 200 );
		}
	}

	MtsPathLoader.prototype.setProgressFn = function( fn ) {
		if( typeof fn === 'function' ) { fn( this ); }
	}

	// add to global namespace
	window.MtsPathLoader = MtsPathLoader;

})( window );

/*!
 * mtsclassie - class helper functions
 * from bonzo https://github.com/ded/bonzo
 * 
 * mtsclassie.has( elem, 'my-class' ) -> true/false
 * mtsclassie.add( elem, 'my-new-class' )
 * mtsclassie.remove( elem, 'my-unwanted-class' )
 * mtsclassie.toggle( elem, 'my-class' )
 */

/*jshint browser: true, strict: true, undef: true */
/*global define: false */

( function( window ) {

	'use strict';

	// class helper functions from bonzo https://github.com/ded/bonzo

	function classReg( className ) {
		return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
	}

	// classList support for class management
	// altho to be fair, the api sucks because it won't accept multiple classes at once
	var hasClass, addClass, removeClass;

	if ( 'classList' in document.documentElement ) {
		hasClass = function( elem, c ) {
			return elem.classList.contains( c );
		};
		addClass = function( elem, c ) {
			elem.classList.add( c );
		};
		removeClass = function( elem, c ) {
			elem.classList.remove( c );
		};
	}
	else {
		hasClass = function( elem, c ) {
			return classReg( c ).test( elem.className );
		};
		addClass = function( elem, c ) {
			if ( !hasClass( elem, c ) ) {
				elem.className = elem.className + ' ' + c;
			}
		};
		removeClass = function( elem, c ) {
			elem.className = elem.className.replace( classReg( c ), ' ' );
		};
	}

	function toggleClass( elem, c ) {
		var fn = hasClass( elem, c ) ? removeClass : addClass;
		fn( elem, c );
	}

	var mtsclassie = {
		// full names
		hasClass: hasClass,
		addClass: addClass,
		removeClass: removeClass,
		toggleClass: toggleClass,
		// short names
		has: hasClass,
		add: addClass,
		remove: removeClass,
		toggle: toggleClass
	};

	// transport
	if ( typeof define === 'function' && define.amd ) {
		// AMD
		define( mtsclassie );
	} else {
		// browser global
		window.mtsclassie = mtsclassie;
	}

})( window );

/**
 * main.js
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2014, Codrops
 * http://www.codrops.com
 */
(function() {
	if ( document.getElementById( 'ip-loader-circle' ) !== null ) {
		var support = { animations : Modernizr.cssanimations },
			container = document.getElementById( 'ip-container' ),
			header = container.querySelector( 'header.ip-header' ),
			loader = new MtsPathLoader( document.getElementById( 'ip-loader-circle' ) ),
			animEndEventNames = { 'WebkitAnimation' : 'webkitAnimationEnd', 'OAnimation' : 'oAnimationEnd', 'msAnimation' : 'MSAnimationEnd', 'animation' : 'animationend' },
			// animation end event name
			animEndEventName = animEndEventNames[ Modernizr.prefixed( 'animation' ) ];

		function init() {
			var onEndInitialAnimation = function() {
				if( support.animations ) {
					this.removeEventListener( animEndEventName, onEndInitialAnimation );
				}

				startLoading();
			};

			// initial animation
			mtsclassie.add( container, 'loading' );

			if( support.animations ) {
				container.addEventListener( animEndEventName, onEndInitialAnimation );
			}
			else {
				onEndInitialAnimation();
			}
		}

		function startLoading() {
			// simulate loading something..
			var simulationFn = function(instance) {
				var progress = 0,
					interval = setInterval( function() {
						progress = Math.min( progress + Math.random() * 0.1, 1 );

						instance.setProgress( progress );

						// reached the end
						if( progress === 1 ) {
							mtsclassie.remove( container, 'loading' );
							mtsclassie.add( container, 'loaded' );
							clearInterval( interval );

							var onEndHeaderAnimation = function(ev) {
								if( support.animations ) {
									if( ev.target !== header ) return;
									this.removeEventListener( animEndEventName, onEndHeaderAnimation );
								}

								mtsclassie.add( document.body, 'layout-switch' );
								window.removeEventListener( 'scroll', noscroll );
							};
						}
					}, 80 );
			};

			loader.setProgressFn( simulationFn );
		}
		
		function noscroll() {
			window.scrollTo( 0, 0 );
		}

		init();
	}
})();

/**
 * jquery.dlmenu.js v1.0.1
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2013, Codrops
 * http://www.codrops.com
 */
;( function( $, window, undefined ) {

	'use strict';

	// global
	var Modernizr = window.Modernizr, $body = $( 'body' ), $close = $( '.dl-close' );

	$.DLMenu = function( options, element ) {
		this.$el = $( element );
		this._init( options );
	};

	// the options
	$.DLMenu.defaults = {
		// classes for the animation effects
		animationClasses : { classin : 'dl-animate-in-1', classout : 'dl-animate-out-1' },
		// callback: click a link that has a sub menu
		// el is the link element (li); name is the level name
		onLevelClick : function( el, name ) { return false; },
		// callback: click a link that does not have a sub menu
		// el is the link element (li); ev is the event obj
		onLinkClick : function( el, ev ) { return false; }
	};

	$.DLMenu.prototype = {
		_init : function( options ) {

			// options
			this.options = $.extend( true, {}, $.DLMenu.defaults, options );
			// cache some elements and initialize some variables
			this._config();
			
			var animEndEventNames = {
					'WebkitAnimation' : 'webkitAnimationEnd',
					'OAnimation' : 'oAnimationEnd',
					'msAnimation' : 'MSAnimationEnd',
					'animation' : 'animationend'
				},
				transEndEventNames = {
					'WebkitTransition' : 'webkitTransitionEnd',
					'MozTransition' : 'transitionend',
					'OTransition' : 'oTransitionEnd',
					'msTransition' : 'MSTransitionEnd',
					'transition' : 'transitionend'
				};
			// animation end event name
			this.animEndEventName = animEndEventNames[ Modernizr.prefixed( 'animation' ) ] + '.dlmenu';
			// transition end event name
			this.transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ] + '.dlmenu',
			// support for css animations and css transitions
			this.supportAnimations = Modernizr.cssanimations,
			this.supportTransitions = Modernizr.csstransitions;

			this._initEvents();

		},
		_config : function() {
			this.open = false;
			this.$trigger = this.$el.children( '.dl-trigger' );
			this.$menu = this.$el.children( 'ul.dl-menu' );
			this.$menuitems = this.$menu.find( 'li:not(.dl-back)' );
			this.$el.find( 'ul.sub-menu' ).prepend( '<li class="dl-back"><a href="#">'+mts_customscript.i18n_back+'</a></li>' );
			this.$back = this.$menu.find( 'li.dl-back' );
		},
		_initEvents : function() {

			var self = this;

			this.$trigger.on( 'click.dlmenu', function() {
				
				if( self.open ) {
					self._closeMenu();
				} 
				else {
					self._openMenu();
				}
				return false;

			} );

			this.$menuitems.on( 'click.dlmenu', function( event ) {
				
				event.stopPropagation();

				var $item = $(this),
					$submenu = $item.children( 'ul.sub-menu' );

				if( $submenu.length > 0 ) {

					var $flyin = $submenu.clone().css( 'opacity', 0 ).insertAfter( self.$menu ),
						onAnimationEndFn = function() {
							self.$menu.off( self.animEndEventName ).removeClass( self.options.animationClasses.classout ).addClass( 'dl-subview' );
							$item.addClass( 'dl-subviewopen' ).parents( '.dl-subviewopen:first' ).removeClass( 'dl-subviewopen' ).addClass( 'dl-subview' );
							$flyin.remove();
						};

					setTimeout( function() {
						$flyin.addClass( self.options.animationClasses.classin );
						self.$menu.addClass( self.options.animationClasses.classout );
						if( self.supportAnimations ) {
							self.$menu.on( self.animEndEventName, onAnimationEndFn );
						}
						else {
							onAnimationEndFn.call();
						}

						self.options.onLevelClick( $item, $item.children( 'a:first' ).text() );
					} );

					return false;

				}
				else {
					self.options.onLinkClick( $item, event );
				}

			} );

			this.$back.on( 'click.dlmenu', function( event ) {
				
				var $this = $( this ),
					$submenu = $this.parents( 'ul.sub-menu:first' ),
					$item = $submenu.parent(),

					$flyin = $submenu.clone().insertAfter( self.$menu );

				var onAnimationEndFn = function() {
					self.$menu.off( self.animEndEventName ).removeClass( self.options.animationClasses.classin );
					$flyin.remove();
				};

				setTimeout( function() {
					$flyin.addClass( self.options.animationClasses.classout );
					self.$menu.addClass( self.options.animationClasses.classin );
					if( self.supportAnimations ) {
						self.$menu.on( self.animEndEventName, onAnimationEndFn );
					}
					else {
						onAnimationEndFn.call();
					}

					$item.removeClass( 'dl-subviewopen' );
					
					var $subview = $this.parents( '.dl-subview:first' );
					if( $subview.is( 'li' ) ) {
						$subview.addClass( 'dl-subviewopen' );
					}
					$subview.removeClass( 'dl-subview' );
				} );

				return false;

			} );
			
		},
		closeMenu : function() {
			if( this.open ) {
				this._closeMenu();
			}
		},
		_closeMenu : function() {
			var self = this,
				onTransitionEndFn = function() {
					self.$menu.off( self.transEndEventName );
					self._resetMenu();
				};
			
			this.$menu.removeClass( 'dl-menuopen' );
			this.$menu.addClass( 'dl-menu-toggle' );
			$('.dl-close').removeClass( 'dl-active');
			this.$trigger.removeClass( 'dl-active' );
			
			if( this.supportTransitions ) {
				this.$menu.on( this.transEndEventName, onTransitionEndFn );
				$('.logo-wrap').show();
				$('.mts-cart').show();
				$('#site-header').css('min-height', '125px');
				$('.dl-menuwrapper button.dl-close').addClass('hidden');
				$('.dl-menuwrapper button.dl-trigger').show();
			}
			else {
				onTransitionEndFn.call();
			}

			this.open = false;
		},
		openMenu : function() {
			if( !this.open ) {
				this._openMenu();
			}
		},
		_openMenu : function() {
			var self = this;
			if ($(window).width() < 865) {
				$('.logo-wrap').hide();
				$('.mts-cart').hide();
				$('#site-header').css('min-height', '300px');
			}			
			$('.dl-menuwrapper button.dl-trigger').hide();
			$('.dl-menuwrapper button.dl-close').removeClass('hidden');
			
			$close.off( 'click' ).on( 'click.dlmenu', function() {
				self._closeMenu() ;
			} );			
			this.$menu.addClass( 'dl-menuopen dl-menu-toggle' ).on( this.transEndEventName, function() {
				$( this ).removeClass( 'dl-menu-toggle' );
			} );
			$('.dl-close').addClass( 'dl-active');
			this.$trigger.addClass( 'dl-active' );
			this.open = true;
		},
		// resets the menu to its original state (first level of options)
		_resetMenu : function() {
			this.$menu.removeClass( 'dl-subview' );
			this.$menuitems.removeClass( 'dl-subview dl-subviewopen' );
		}
	};

	var logError = function( message ) {
		if ( window.console ) {
			window.console.error( message );
		}
	};

	$.fn.dlmenu = function( options ) {
		if ( typeof options === 'string' ) {
			var args = Array.prototype.slice.call( arguments, 1 );
			this.each(function() {
				var instance = $.data( this, 'dlmenu' );
				if ( !instance ) {
					logError( "cannot call methods on dlmenu prior to initialization; " +
					"attempted to call method '" + options + "'" );
					return;
				}
				if ( !$.isFunction( instance[options] ) || options.charAt(0) === "_" ) {
					logError( "no such method '" + options + "' for dlmenu instance" );
					return;
				}
				instance[ options ].apply( instance, args );
			});
		} 
		else {
			this.each(function() {	
				var instance = $.data( this, 'dlmenu' );
				if ( instance ) {
					instance._init();
				}
				else {
					instance = $.data( this, 'dlmenu', new $.DLMenu( options, this ) );
				}
			});
		}
		return this;
	};

} )( jQuery, window );

jQuery(document).ready(function($){
	$( '#dl-menu' ).dlmenu({
		animationClasses : { classin : 'dl-animate-in-2', classout : 'dl-animate-out-2' }
	});
});