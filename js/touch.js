var RH = RH || {};

/**
 * State-tracking to prevent memory leaks and reapplied effects
 */
RH.inTablet = false;
RH.inMobile = false;

/**
 * Called when entering the tablet breakpoint
 */
RH.tabletEnter = function () {
    if (RH.inTablet) {
        return;
    }
    RH.inTablet = true;
	jQuery('.global-navigation li.menu').on('click', function() {
		// RH.hideMenuOptions('menu');
		jQuery('#access').stop().slideToggle();
	});
	// no double click :hover for iphone
	jQuery('nav#access li').on('touchstart', function() {
		$(this).addClass('touch');
	});
	jQuery('nav#access li').on('touchmove', function() {
		$(this).removeClass('touch');
	});
	jQuery('nav#access li').on('click touchend', function() {
		$(this).removeClass('touch');
		window.location = $(this).children('a').attr('href');
	});
	// make footer touch-friendly
	jQuery('footer .tabs a').on('click', function() {
		jQuery('footer .tabs a').removeClass('selected');
		jQuery('#footer > div').hide();
		var selector = jQuery(this).data('tab');
		jQuery(selector).show();
		jQuery(this).addClass('selected');
	});
	jQuery('footer .tabs a:first-child').click();
	// for you people resizing the browser :)
	// RH.hideMenuOptions();
}

/**
 * Called when exiting the tablet breakpoint
 */
RH.tabletExit = function() {
	if (!RH.inTablet) {
		return;
	}
	RH.inTablet = false;
	// reset footer
	jQuery('#footer > div').show();
	jQuery('footer .tabs a').off('click');
	jQuery('#access').show();
	jQuery('.global-navigation li.menu').off('click');
}

/**
 * Called when entering the mobile breakpoint
 */
RH.mobileEnter = function() {
	if (RH.inMobile) {
		return;
	}
	RH.inMobile = true;
	// jQuery('.global-navigation li.menu').on('click', function() {
	// 	RH.hideMenuOptions('menu');
	// 	jQuery('#access').slideToggle();
	// });
	jQuery('.global-navigation li.campuses').on('click', function() {
		RH.hideMenuOptions('campuses');
		jQuery(this).children('ul').toggleClass('touch');
		jQuery(this).children('ul').hasClass('touch') ? RH.hideVideos() : RH.showVideos();
	});
	jQuery('.global-navigation li.search').on('click', function() {
		RH.hideMenuOptions('search');
		jQuery(this).children('form').toggleClass('touch');
		if (jQuery(this).children('form').hasClass('touch')) {
			RH.hideVideos();
			jQuery(this).find('input[type=search]').focus();
		} else {
			RH.showVideos();
		}
	});
	jQuery('.global-navigation li.search form').on('click', function(event) {
		// prevent clicking on input from closing the search form
		event.stopPropagation();
	});
}

/**
 * Called when exiting the mobile breakpoint
 */
RH.mobileExit = function() {
	if (!RH.inMobile) {
		return;
	}
	RH.inMobile = false;
	jQuery('#access').show();
	jQuery('.global-navigation li.campuses').off('click');
	jQuery('.global-navigation li.search').off('click');
}

RH.hideMenuOptions = function(keep) {
	if (keep !== 'menu') {
		jQuery('#access').slideUp(function() {
			jQuery(this).css('display', '');
		});
	}
	if (keep !== 'campuses') {
		jQuery('.global-navigation li.campuses ul').removeClass('touch');
	}
	if (keep !== 'search') {
		jQuery('.global-navigation li.search form').removeClass('touch');
	}
}
