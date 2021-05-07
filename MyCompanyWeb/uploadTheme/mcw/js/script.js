$(document).ready(function() {
	var win_loc = window.location.href;
	if(win_loc.indexOf('#') >= 0){
		var wl_split = win_loc.split('#')[1],
			$wl_target = $('#' + wl_split);
		if($wl_target.get(0).tagName == 'BUTTON'){
			$($wl_target.attr('data-target')).addClass('in');
			$.scrollTo($wl_target, 1e3, {
				offset: {
					top: 0
				}
			});
		}
	}
	
	
	function o() {
		var o = $(".owl-carousel .center").find(".photo-bgr").data("coments");
		$(".owl-carousel-coments .owl-carousel-coments-item").removeClass("active"), $(".owl-carousel-coments #" + o).addClass("active")
	}
	$(".nav a").click(function() {
		var o = $(this).attr("href");
		if(o.indexOf('#') == 0){
			return $.scrollTo(o, 1e3, {
				offset: {
					top: 0
				}
			}), !1
		}
		else{
			var split = o.split('#'),
				sp_url = split[0],
				loc = window.location.href.split('#')[0],
				base = $(this).attr("data-base");
			
			if(loc == base || loc == base + '/' || loc == base + '/index.html' || loc == base + '/index.html/' || loc == base + '/index.php' || loc == base + '/index.php/'){
				var $target = $('#' + split[1]);
				if($target.get(0).tagName == 'BUTTON'){
					$($target.attr('data-target')).addClass('in');
				}
				return $.scrollTo($target, 1e3, {
					offset: {
						top: 0
					}
				}), !1
			}
		}
	}), $(".menu-col ul li a").click(function() {
		var o = $(this).attr("href");
		return $.scrollTo(o, 1e3, {
			offset: {
				top: 0
			}
		}), !1
	}), $(".special-offers").click(function() {
		$("#get-free-domain").addClass("in").css("height", "100%");
		var o = $(this).attr("href");
		return $.scrollTo(o, 500, {
			offset: {
				top: 0
			}
		}), !1
	}), $(window).scroll(function() {
		$(this).scrollTop() > 50 ? $("#back-to-top").fadeIn() : $("#back-to-top").fadeOut()
	}), $("#back-to-top").click(function() {
		return $("#back-to-top").tooltip("hide"), $("body,html").animate({
			scrollTop: 0
		}, 800), !1
	}), $(window).width() < 767 && $(".panel-heading").each(function() {
		$(this).attr("data-toggle", "collapse")
	}), $("#owl-feedback").owlCarousel({
		center: !0,
		items: 10,
		loop: !0,
		margin: 5,
		mouseDrag: !1,
		nav: !0,
		navText: ["<img src='img/left_arrow.png' alt='img'>", "<img src='img/right_arrow.png' alt='img'>"],
		responsive: {
			0: {
				items: 1
			},
			768: {
				items: 5
			}
		},
		onDragged: o
	}), $(".owl-prev, .owl-next").click(function() {
		o()
	});
	var t = 500,
		e = null;
	$(".burger-click-region").on("click", function() {
		if (null === e) {
			var o = $(this);
			o.toggleClass("active"), o.parent().toggleClass("is-open"), o.hasClass("active") || o.addClass("closing"), e = setTimeout(function() {
				o.removeClass("closing"), clearTimeout(e), e = null
			}, t)
		}
	}), $(".plan-detailes").on("vclick", function() {
		return $(".plan-detailes").addClass("collapsed"), $(this).removeClass("collapsed"), !1
	});
	
	$('#ajax-contact').on('submit', function(){
		var $this = $(this);
		$.ajax({
			type: 'POST',
			url: $this.attr('action'),
			data: $this.serialize()
		})
		.done(function(data){
			var popup = new jPopup({
				title : '<h2>Congratulations!</h2>',
				content : 'You are signed up for newsletters now.',
				closeButton: true,
				overlay: true,
				overlayClose: true,
				freeze: false
			}).open();
		})
		.fail(function(){
			var popup = new jPopup({
				title : '<h2>Oops!</h2>',
				content : 'An error occured and your message could not be sent.',
				closeButton: true,
				overlay: true,
				overlayClose: true,
				freeze: false
			}).open();
		})
		.always(function(){});
		return false;
	});
	
	$('.invoke_popup').on('click', function(){
		var $this = $(this);
		
		var popup = new jPopup({
			title : '<h2>' + $this.html() + '</h2>',
			content : '<iframe src="' + $this.attr('href') + '" width="300" height="300"></iframe>',
			closeButton: true,
			overlay: true,
			overlayClose: true,
			freeze: false,
			classes: 'large-popup'
		}).open();
		
		return false;
	});
    
    

    
});
	
	
