var RH = RH || {};

/**
 * iPhones don't let anything over videos, so we have to hide videos when menu
 * dropdowns are clicked
 */
RH.hideVideos = function() {
	jQuery('video').each(function() {
		jQuery(this).data('hidden', true);
		jQuery(this).hide();
	});
}

RH.showVideos = function() {
	jQuery('video').each(function() {
		if (jQuery(this).data('hidden') === true) {
			jQuery(this).show();
		}
	});
}

// initialized on every page
jQuery(document).ready(function() {

    jQuery('#simple-menu').sidr({
        name: 'campus-menu'
    });

    jQuery('.frontpage-banner').slick({dots: true});

    jQuery('.faq-slides').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        dots: false,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }
        ]
    });

    jQuery('.icon-close, .main-content').on('click', function(){
        jQuery.sidr('close', 'campus-menu');
    });


    // core feeds
	jQuery('.core-events').each(function() {
		var self = jQuery(this);
		jQuery.ajax({
			url: self.data('core-feed-url'),
			type: 'get',
			dataType: 'jsonp'
		}).done(function(response, textStatus, jqXHR) {
			if (response.length === 0) {
				self.children('p').html('There are no upcoming events.');
				return;
			}
			self.empty();
			var lastStart = [];
			var months = ['January', 'February', 'March', 'April', 'May',
			'June', 'July', 'August', 'September', 'October', 'November',
			'December'];

			if (self.data('core-limit') > 0) {
				response.length = parseInt(self.data('core-limit'));
			}
			for (var event in response) {
				var date = response[event].start.split(' ')[0].split('-');

				if (date.toString() != lastStart.toString()) {
					var time = document.createElement('time');
					var span = document.createElement('span');
					var month = span.cloneNode();
					month.className = 'month';
					month.innerHTML = months[parseInt(date[1]) - 1];
					var day = span.cloneNode();
					day.className = 'day';
					day.innerHTML = parseInt(date[2]);
					var year = span.cloneNode();
					year.className = 'year';
					year.innerHTML = date[0];
					time.appendChild(month);
					time.appendChild(day);
					time.appendChild(year);

					self.append(time);
				}

				lastStart = date;

				var a = document.createElement('a');
				a.target = '_blank';
				a.href = response[event].url;
				a.innerHTML = response[event].title;

				self.append(a);
			}
		}).fail(function() {
			self.children('p').html('There are no upcoming events.');
		});
	});

	// put galleries in lightboxes
	jQuery('.gallery').each(function() {
		var id = jQuery(this).attr('id');
		jQuery(this).find('.gallery-icon a').attr('rel', 'lightbox['+id+']');
	}).lightbox();

	jQuery('.flash-message').delay(5000).slideUp();
	jQuery('img')
		.removeAttr('width')
		.removeAttr('height');

	var preserveAspectRatio = function(container) {
		var element = $(container).find('video');
		if (element.length === 0 || typeof $(element)[0].player === 'undefined') {
			return;
		}
		var player = $(element)[0].player;
		var w = $(container).width();
		var h = w*9/16;
		player.setPlayerSize(w, h);
	}

	// improve media elements
	jQuery('video')
		.mediaelementplayer({
			pluginPath: RH.base_url+'/swf/',
			success: function(media, node) {
				if (media.pluginType !== 'native' && jQuery(node).attr('data-streamfile')) {
					media.setSrc(jQuery(node).attr('data-streamfile'));
					media.load();
				}
			}
		});
	jQuery('audio').mediaelementplayer({
		pluginPath: RH.base_url+'/swf/',
		audioWidth: 200,
		audioHeight: 20,
		features: ['playpause', 'progress', 'current']
	});

	if (jQuery('video').length > 0) {
		jQuery(window).resize(function() {
			jQuery('.embedded-video').each(function() {
				preserveAspectRatio(this);
			});
		});
	}

	jQuery(window).resize();

	// responsive breakpoints
	mediaCheck({
		media: '(max-width: 569px)',
		entry: RH.mobileEnter,
		exit: RH.mobileExit
	});
	mediaCheck({
		media: '(max-width: 1025px)',
		entry: RH.tabletEnter,
		exit: RH.tabletExit
	});

	jQuery('#access > ul > li').hover(function() {
		var menu = jQuery(this).children('.submenu');
		if (menu.length === 0) {
			return;
		}
		var pos = jQuery(this).position();
		var width = jQuery(window).width();
		if (pos.left + menu.width() > width) {
			menu.css({
				right: 0
			});
		}
	});


	// implement super sonic hyper-responsive clicking for touchscreens
	new FastClick(document.body);
});
