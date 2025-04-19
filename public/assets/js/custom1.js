(function($) {
    "use strict";

	// ______________ Page Loading
	$(window).on("load", function(e) {
		$("#global-loader").fadeOut("slow");
	})
	
	// ______________Cover Image
	$(".cover-image").each(function() {
		var attr = $(this).attr('data-image-src');
		if (typeof attr !== typeof undefined && attr !== false) {
			$(this).css('background', 'url(' + attr + ') center center');
		}
	});

	$('.table-subheader').click(function(){
		$(this).nextUntil('tr.table-subheader').slideToggle(100);
	});

	// ______________ Horizonatl
	$(document).ready(function() {
      $("a[data-theme]").click(function() {
        $("head link#theme").attr("href", $(this).data("theme"));
        $(this).toggleClass('active').siblings().removeClass('active');
      });

      $("a[data-effect]").click(function() {
        $("head link#effect").attr("href", $(this).data("effect"));
        $(this).toggleClass('active').siblings().removeClass('active');
      });
    });

	// ______________Full screen
	$("#fullscreen-button").on("click", function toggleFullScreen() {
      if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
        if (document.documentElement.requestFullScreen) {
          document.documentElement.requestFullScreen();
        } else if (document.documentElement.mozRequestFullScreen) {
          document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullScreen) {
          document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        } else if (document.documentElement.msRequestFullscreen) {
          document.documentElement.msRequestFullscreen();
        }
      } else {
        if (document.cancelFullScreen) {
          document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
          document.webkitCancelFullScreen();
        } else if (document.msExitFullscreen) {
          document.msExitFullscreen();
        }
      }
    })

	// ______________Active Class
	$(document).ready(function() {
		$(".horizontalMenu-list li a").each(function() {
			var pageUrl = window.location.href.split(/[?#]/)[0];
			if (this.href == pageUrl) {
				$(this).addClass("active");
				$(this).parent().addClass("active"); // add active to li of the current link
				$(this).parent().parent().prev().addClass("active"); // add active class to an anchor
				$(this).parent().parent().prev().click(); // click the item to make it drop
			}
		});
		$(".horizontal-megamenu li a").each(function() {
			var pageUrl = window.location.href.split(/[?#]/)[0];
			if (this.href == pageUrl) {
				$(this).addClass("active");
				$(this).parent().addClass("active"); // add active to li of the current link
				$(this).parent().parent().parent().parent().parent().parent().parent().prev().addClass("active"); // add active class to an anchor
				$(this).parent().parent().prev().click(); // click the item to make it drop
			}
		});
		$(".horizontalMenu-list .sub-menu .sub-menu li a").each(function() {
			var pageUrl = window.location.href.split(/[?#]/)[0];
			if (this.href == pageUrl) {
				$(this).addClass("active");
				$(this).parent().addClass("active"); // add active to li of the current link
				$(this).parent().parent().parent().parent().prev().addClass("active"); // add active class to an anchor
				$(this).parent().parent().prev().click(); // click the item to make it drop
			}
		});
	});

	// ______________Quantity Cart Increase & Descrease
	$(function () {
		$('.add').on('click',function(){
			var $qty=$(this).closest('div').find('.qty');
			var currentVal = parseInt($qty.val());
			if (!isNaN(currentVal)) {
				$qty.val(currentVal + 1);
			} 
			
		});
		$('.minus').on('click',function(){
			var $qty=$(this).closest('div').find('.qty');
			var currentVal = parseInt($qty.val());
			if (!isNaN(currentVal) && currentVal > 0) {
				$qty.val(currentVal - 1);
			}
		});
	});

	// __________MODAL
	
	// showing modal with effect
	$('.modal-effect').on('click', function(e) {
		e.preventDefault();
		var effect = $(this).attr('data-bs-effect');
		$('#modaldemo8').addClass(effect);
	});
		
	// hide modal with effect
	$('#modaldemo8').on('hidden.bs.modal', function(e) {
		$(this).removeClass(function(index, className) {
			return (className.match(/(^|\s)effect-\S+/g) || []).join(' ');
		});
	});

	// ______________Back to top Button
	$(window).on("scroll", function(e) {
    	if ($(this).scrollTop() > 0) {
            $('#back-to-top').fadeIn('slow');
        } else {
            $('#back-to-top').fadeOut('slow');
        }
    });
    $("#back-to-top").on("click", function(e){
        $("html, body").animate({
            scrollTop: 0
        }, 0);
        return false;
    });

	// ______________ StarRating
	var ratingOptions = {
		selectors: {
			starsSelector: '.rating-stars',
			starSelector: '.rating-star',
			starActiveClass: 'is--active',
			starHoverClass: 'is--hover',
			starNoHoverClass: 'is--no-hover',
			targetFormElementSelector: '.rating-value'
		}
	};
	$(".rating-stars").ratingStars(ratingOptions);

	// ______________ Chart-circle
	if ($('.chart-circle').length) {
		$('.chart-circle').each(function() {
			let $this = $(this);

			$this.circleProgress({
			  fill: {
				color: $this.attr('data-color')
			  },
			  size: $this.height(),
			  startAngle: -Math.PI / 4 * 2,
			  emptyFill: '#e2e2e9',
			  lineCap: 'round'
			});
		});
	}

	// ______________ Chart-circle
	if ($('.chart-circle-transparent').length) {
		$('.chart-circle-transparent').each(function() {
			let $this = $(this);

			$this.circleProgress({
			  fill: {
				color: $this.attr('data-color')
			  },
			  size: $this.height(),
			  startAngle: -Math.PI / 4 * 2,
			  emptyFill: 'rgba(0, 0, 0, 0.1)',
			  lineCap: 'round'
			});
		});
	}

	// ______________ Chart-circle
	if ($('.chart-circle-primary').length) {
		$('.chart-circle-primary').each(function() {
			let $this = $(this);

			$this.circleProgress({
			  fill: {
				color: $this.attr('data-color')
			  },
			  size: $this.height(),
			  startAngle: -Math.PI / 4 * 2,
			  emptyFill: 'rgba(112, 94, 200, 0.4)',
			  lineCap: 'round'
			});
		});
	}

	// ______________ Chart-circle
	if ($('.chart-circle-secondary').length) {
		$('.chart-circle-secondary').each(function() {
			let $this = $(this);

			$this.circleProgress({
			  fill: {
				color: $this.attr('data-color')
			  },
			  size: $this.height(),
			  startAngle: -Math.PI / 4 * 2,
			  emptyFill: 'rgba(251, 28, 82, 0.4)',
			  lineCap: 'round'
			});
		});
	}

	// ______________ Chart-circle
	if ($('.chart-circle-success').length) {
		$('.chart-circle-success').each(function() {
			let $this = $(this);

			$this.circleProgress({
			  fill: {
				color: $this.attr('data-color')
			  },
			  size: $this.height(),
			  startAngle: -Math.PI / 4 * 2,
			  emptyFill: 'rgba(66, 196, 138, 0.5)',
			  lineCap: 'round'
			});
		});
	}

	// ______________ Chart-circle
	if ($('.chart-circle-warning').length) {
		$('.chart-circle-warning').each(function() {
			let $this = $(this);

			$this.circleProgress({
			  fill: {
				color: $this.attr('data-color')
			  },
			  size: $this.height(),
			  startAngle: -Math.PI / 4 * 2,
			  emptyFill: 'rgba(255, 171, 0, 0.5)',
			  lineCap: 'round'
			});
		});
	}

	// ______________ Global Search
	$(document).on("click", "[data-bs-toggle='search']", function(e) {
		var body = $("body");

		if(body.hasClass('search-gone')) {
			body.addClass('search-gone');
			body.removeClass('search-show');
		}else{
			body.removeClass('search-gone');
			body.addClass('search-show');
		}
	});
	var toggleSidebar = function() {
		var w = $(window);
		if(w.outerWidth() <= 1024) {
			$("body").addClass("sidebar-gone");
			$(document).off("click", "body").on("click", "body", function(e) {
				if($(e.target).hasClass('sidebar-show') || $(e.target).hasClass('search-show')) {
					$("body").removeClass("sidebar-show");
					$("body").addClass("sidebar-gone");
					$("body").removeClass("search-show");
				}
			});
		}else{
			$("body").removeClass("sidebar-gone");
		}
	}
	toggleSidebar();
	$(window).resize(toggleSidebar);

	$(document).on("click", ".close-btn", function() {
		$("body").removeClass("search-show");
	});

	const DIV_CARD = 'div.card';

	// ______________ Attach Remove
	$(document).on('click', '[data-toggle="remove"]', function(e) {
		let $a = $(this).closest(".attach-supportfiles");
		$a.remove();
		e.preventDefault();
		return false;
	});

	
	// ______________ Tooltip
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
 	 return new bootstrap.Tooltip(tooltipTriggerEl)
	})


	// ______________ Popover
	var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
	var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
	html:
	return new bootstrap.Popover(popoverTriggerEl)
	})
	
	// ______________ Card Remove
	$(document).on('click', '[data-bs-toggle="card-close"]', function(e) {
		let $card = $(this).closest(DIV_CARD);
		$card.remove();
		e.preventDefault();
		return false;
	});


	// ______________ Card Remove
	$(document).on('click', '[data-bs-toggle="card-remove"]', function(e) {
		let $card = $(this).closest(DIV_CARD);
		$card.remove();
		e.preventDefault();
		return false;
	});

	// ______________ Card Collapse
	$(document).on('click', '[data-bs-toggle="card-collapse"]', function(e) {
		let $card = $(this).closest(DIV_CARD);
		$card.toggleClass('card-collapsed');
		e.preventDefault();
		return false;
	});

	// ______________ Card Fullscreen
	$(document).on('click', '[data-bs-toggle="card-fullscreen"]', function(e) {
		let $card = $(this).closest(DIV_CARD);
		$card.toggleClass('card-fullscreen').removeClass('card-collapsed');
		e.preventDefault();
		return false;
	});

	// sparkline1
	$(".sparkline_bar").sparkline([2, 4, 3, 4, 5, 4, 5, 4, 3, 4], {
		height: 20,
		type: 'bar',
		colorMap: {
			'7': '#a1a1a1'
		},
		barColor: '#ff5b51'
	});

	// sparkline2
	$(".sparkline_bar1").sparkline([3, 4, 3, 4, 5, 4, 5, 6, 4, 6,], {
		height: 20,
		type: 'bar',
		colorMap: {
			'7': '#c34444'
		},
		barColor: '#44c386'
	});

	// sparkline3
	$(".sparkline_bar2").sparkline([3, 4, 3, 4, 5, 4, 5, 6, 4, 6,], {
		height: 20,
		type: 'bar',
		colorMap: {
			'7': '#a1a1a1'
		},
		barColor: '#fa057a'
	});

	// ______________ SWITCHER-toggle ______________//
	
	$('.layout-setting').on("click", function(e) {
		if (document) {
			$('body').toggleClass('dark-mode');
		} else {
			$('body').removeClass('dark-mode');
			$('body').addClass('light-mode');
		}
	});

	

	  $('.default-menu').on('click', function() {
		var ww = document.body.clientWidth;
		if (ww >= 992) {
			$('body').removeClass('sidenav-toggled');
		}
	});


	/*Light Layout Start*/
    $(document).on("click", '#myonoffswitch1', function() {
        if (this.checked) {
            $('body').addClass('light-mode');
            $('body').removeClass('dark-mode');
            $('body').removeClass('light-menu');
			$('body').removeClass('gradient-hormenu');
			$('body').removeClass('dark-mode');
			$('body').removeClass('color-header');
			$('body').removeClass('dark-header'); 
			$('body').removeClass('dark-menu');
			$('body').removeClass('gradient-menu');
			$('body').removeClass('gradient-header');
			$('body').removeClass('color-menu');
            localStorage.setItem("light-mode", "True");
        } else {
            $('body').removeClass('light-mode');
            localStorage.setItem("light-mode", "false");
        }
    });
	/*Light Layout End*/

	/*Dark Layout Start*/
    $(document).on("click", '#myonoffswitch2', function() {
        if (this.checked) {
            $('body').addClass('dark-mode');
			$('body').removeClass('light-mode');
			$('body').removeClass('light-menu');
			$('body').removeClass('color-menu');
			$('body').removeClass('dark-header');
			$('body').removeClass('color-header');
			$('body').removeClass('light-header');
			$('body').removeClass('dark-menu');
			$('body').removeClass('light-hormenu');
			$('body').removeClass('gradient-hormenu');
			$('body').removeClass('gradient-menu');
            localStorage.setItem("dark-mode", "True");
        } else {
            $('body').removeClass('dark-mode');
            localStorage.setItem("dark-mode", "false");
        }
    });
	/*Dark Layout End*/

	/*Light Menu Start*/
    $(document).on("click", '#myonoffswitch3', function() {
        if (this.checked) {
            $('body').addClass('light-menu');
            $('body').removeClass('color-menu');
			$('body').removeClass('dark-menu');
			$('body').removeClass('gradient-menu');
			$('body').removeClass('light-hormenu');
			$('body').removeClass('dark-hormenu');
			$('body').removeClass('color-hormenu');
            localStorage.setItem("light-menu", "True");
        } else {
            $('body').removeClass('light-menu');
            localStorage.setItem("light-menu", "false");
        }
    });
	/*Light Menu End*/

    /*Color Menu Start*/
    $(document).on("click", '#myonoffswitch4', function() {
        if (this.checked) {
            $('body').addClass('color-menu');
			$('body').removeClass('light-menu');
			$('body').removeClass('dark-menu');
			$('body').removeClass('gradient-menu');
			$('body').removeClass('light-hormenu');
			$('body').removeClass('dark-hormenu');
			$('body').removeClass('color-hormenu');
            localStorage.setItem("color-menu", "True");
        } else {
            $('body').removeClass('color-menu');
            localStorage.setItem("color-menu", "false");
        }
    });
	/*Color Menu End*/

    /*Dark Menu Start*/
    $(document).on("click", '#myonoffswitch5', function() {
        if (this.checked) {
            $('body').addClass('dark-menu');
			$('body').removeClass('color-menu');
			$('body').removeClass('light-menu');
			$('body').removeClass('gradient-menu');
			$('body').removeClass('light-hormenu');
			$('body').removeClass('dark-hormenu');
			$('body').removeClass('dark-hormenu');
            localStorage.setItem("dark-menu", "True");
        } else {
            $('body').removeClass('dark-menu');
            localStorage.setItem("dark-menu", "false");
        }
    });
	/*Dark Menu End*/

	/*Gradient Menu Start*/
    $(document).on("click", '#myonoffswitch25', function() {
        if (this.checked) {
            $('body').addClass('gradient-menu');
            $('body').removeClass('color-menu');
			$('body').removeClass('light-menu');
			$('body').removeClass('dark-menu');
			$('body').removeClass('light-hormenu');
			$('body').removeClass('dark-hormenu');
			$('body').removeClass('dark-hormenu');
            localStorage.setItem("gradient-menu", "True");
        } else {
            $('body').removeClass('gradient-menu');
            localStorage.setItem("gradient-menu", "false");
        }
    });
	/*Gradient Menu End*/

	/*Light Header Start*/
    $(document).on("click", '#myonoffswitch6', function() {
        if (this.checked) {
            $('body').addClass('light-header');
			$('body').removeClass('color-header');
			$('body').removeClass('dark-header');
			$('body').removeClass('gradient-header');
            localStorage.setItem("light-header", "True");
        } else {
            $('body').removeClass('light-header');
            localStorage.setItem("light-header", "false");
        }
    });
	/*Light Header End*/

	/*Color Header Start*/
    $(document).on("click", '#myonoffswitch7', function() {
        if (this.checked) {
            $('body').addClass('color-header');
			$('body').removeClass('light-header');
			$('body').removeClass('dark-header');
			 $('body').removeClass('gradient-header');
            localStorage.setItem("color-header", "True");
        } else {
            $('body').removeClass('color-header');
            localStorage.setItem("color-header", "false");
        }
    });
	/*Color Header End*/

	/*Dark Header Start*/
    $(document).on("click", '#myonoffswitch8', function() {
        if (this.checked) {
            $('body').addClass('dark-header');
			$('body').removeClass('color-header');
			$('body').removeClass('light-header');
			 $('body').removeClass('gradient-header');
            localStorage.setItem("dark-header", "True");
        } else {
            $('body').removeClass('dark-header');
            localStorage.setItem("dark-header", "false");
        }
    });
	/*Dark Header End*/

	/*Gradient Header Start*/
    $(document).on("click", '#myonoffswitch26', function() {
        if (this.checked) {
            $('body').addClass('gradient-header');
			$('body').removeClass('dark-header');
			$('body').removeClass('color-header');
			$('body').removeClass('light-header');
            localStorage.setItem("gradient-header", "True");
        } else {
            $('body').removeClass('gradient-header');
            localStorage.setItem("gradient-header", "false");
        }
    });
	/*Gradient Header End*/

	/*Full Width Layout Start*/
    $('#myonoffswitch9').click(function() {
        if (this.checked) {
            $('body').addClass('layout-fullwidth');
			$('body').removeClass('layout-boxed');
			$('body').removeClass('light-hormenu');
			$('body').removeClass('color-hormenu');
			$('body').removeClass('dark-hormenu');
			$('body').removeClass('gradient-hormenu');
			$('body').removeClass('dark-menu');
			$('body').removeClass('color-menu');
			$('body').removeClass('light-menu');
			$('body').removeClass('gradient-menu');
            localStorage.setItem("layout-fullwidth", "True");
        } else {
            $('body').removeClass('layout-fullwidth');
            localStorage.setItem("layout-fullwidth", "false");
        }
    });
	/*Full Width Layout End*/

	/*Boxed Layout Start*/
    $('#myonoffswitch10').click(function() {
        if (this.checked) {
            $('body').addClass('layout-boxed');
			$('body').removeClass('layout-fullwidth');
			$('body').removeClass('color-hormenu');
			$('body').removeClass('light-hormenu');
			$('body').removeClass('dark-hormenu');
			$('body').removeClass('gradient-hormenu');
			$('body').removeClass('dark-menu');
			$('body').removeClass('color-menu');
			$('body').removeClass('light-menu');
			$('body').removeClass('gradient-menu');
            localStorage.setItem("layout-boxed", "True");
        } else {
            $('body').removeClass('layout-boxed');
            localStorage.setItem("layout-boxed", "false");
        }
    });
	/*Boxed Layout End*/

	/*Header-Position Styles Start*/
	$('#myonoffswitch11').click(function() {
        if (this.checked) {
            $('body').addClass('fixed-layout');
			$('body').removeClass('scrollable-layout');
			$('body').removeClass('light-hormenu');
			$('body').removeClass('color-hormenu');
			$('body').removeClass('dark-hormenu');
			$('body').removeClass('gradient-hormenu');
			$('body').removeClass('dark-menu');
			$('body').removeClass('color-menu');
			$('body').removeClass('light-menu');
			$('body').removeClass('gradient-menu');
            localStorage.setItem("fixed-layout", "True");
        } else {
            $('body').removeClass('fixed-layout');
            localStorage.setItem("fixed-layout", "false");
        }
    });
	$('#myonoffswitch12').click(function() {
        if (this.checked) {
            $('body').addClass('scrollable-layout');
			$('body').removeClass('fixed-layout');
			$('body').removeClass('color-hormenu');
			$('body').removeClass('light-hormenu');
			$('body').removeClass('dark-hormenu');
			$('body').removeClass('gradient-hormenu');
			$('body').removeClass('dark-menu');
			$('body').removeClass('color-menu');
			$('body').removeClass('light-menu');
			$('body').removeClass('gradient-menu');
            localStorage.setItem("scrollable-layout", "True");
        } else {
            $('body').removeClass('scrollable-layout');
            localStorage.setItem("scrollable-layout", "false");
        }
    });
	/*Header-Position Styles End*/

	
	/*Default Sidemenu Start*/
    $(document).on("click", '#myonoffswitch13', function() {
        if (this.checked) {
			$('body').addClass('default-menu');
			hovermenu();
			$('body').removeClass('closed-menu');
			$('body').removeClass('icontext-menu');
			$('body').removeClass('sideicon-menu');
			$('body').removeClass('sidenav-toggled');
        } else {
            $('body').removeClass('default-menu');
        }
    });
	/*Default Sidemenu End*/

	
	/*Closed Sidemenu Start*/
    $(document).on("click", '#myonoffswitch30', function() {
        if (this.checked) {
			$('body').addClass('closed-menu');
			hovermenu();
			$('body').addClass('sidenav-toggled');
			$('body').removeClass('default-menu');
			$('body').removeClass('icontext-menu');
			$('body').removeClass('sideicon-menu');
        } else {
            $('body').removeClass('default-menu');
			$('body').removeClass('sidenav-toggled');
        }
    });
	/*Closed Sidemenu End*/

	
	/*Icon Text Sidemenu Start*/
	$('#myonoffswitch14').click(function() {
        if (this.checked) {
			$('body').addClass('icontext-menu');
			icontext();
			$('body').addClass('sidenav-toggled');
			$('body').removeClass('default-menu');
			$('body').removeClass('sideicon-menu');
			$('body').removeClass('closed-menu');

        } else {
            $('body').removeClass('icontext-menu');
			$('body').removeClass('sidenav-toggled');
        }
    });
	/*Icon Text Sidemenu End*/
	
	/*Icon Overlay Sidemenu Start*/
	$('#myonoffswitch15').click(function() {
        if (this.checked) {
            $('body').addClass('sideicon-menu');
			hovermenu();
            $('body').addClass('sidenav-toggled');
			$('body').removeClass('default-menu');
			$('body').removeClass('icontext-menu');
			$('body').removeClass('closed-menu');
        } else {
            $('body').removeClass('sideicon-menu');
			$('body').removeClass('sidenav-toggled');
        }
    });
	/*Icon Overlay Sidemenu End*/

	/*Horizontal Style*/

	$('#background7').click(function() {
        if (this.checked) {
			$('body').addClass('light-hormenu');
            $('body').removeClass('color-hormenu');
			$('body').removeClass('dark-hormenu');
			$('body').removeClass('gradient-hormenu');
			$('body').removeClass('dark-menu');
			$('body').removeClass('color-menu');
			$('body').removeClass('light-menu');
			$('body').removeClass('gradient-menu');
			localStorage.setItem("light-hormenu", "True");
        } else {
            $('body').removeClass('light-hormenu');
			localStorage.setItem("light-hormenu", "False");
        }
    });
	$('#background8').click(function() {
        if (this.checked) {
			$('body').addClass('color-hormenu');
			$('body').removeClass('light-hormenu');
			$('body').removeClass('dark-hormenu');
			$('body').removeClass('gradient-hormenu');
			$('body').removeClass('dark-menu');
			$('body').removeClass('color-menu');
			$('body').removeClass('light-menu');
			$('body').removeClass('gradient-menu');
			localStorage.setItem("color-hormenu", "True");
        } else {
            $('body').removeClass('color-hormenu');
			localStorage.setItem("color-hormenu", "False");
        }
    });

	$('#background9').click(function() {
        if (this.checked) {
			$('body').addClass('dark-hormenu');
			$('body').removeClass('color-hormenu');
			$('body').removeClass('light-hormenu');
			$('body').removeClass('gradient-hormenu');
			$('body').removeClass('dark-menu');
			$('body').removeClass('color-menu');
			$('body').removeClass('light-menu');
			$('body').removeClass('gradient-menu');
			localStorage.setItem("dark-hormenu", "True");
        } else {
            $('body').removeClass('dark-hormenu');
			localStorage.setItem("dark-hormenu", "False");
        }
    });
	$('#background13').click(function() {
        if (this.checked) {
			$('body').addClass('gradient-hormenu');
			$('body').removeClass('dark-hormenu');
			$('body').removeClass('color-hormenu');
			$('body').removeClass('light-hormenu');
			$('body').removeClass('dark-menu');
			$('body').removeClass('color-menu');
			$('body').removeClass('light-menu');
			$('body').removeClass('gradient-menu');
			localStorage.setItem("gradient-hormenu", "True");
        } else {
            $('body').removeClass('gradient-hormenu');
			localStorage.setItem("gradient-hormenu", "False");
        }
    });
	
	  $('#myonoffswitch55').click(function() {
        if (this.checked) {
            $('body').addClass('rtl');
            $('body').removeClass('ltr');
			$("html[lang=en]").attr("dir", "rtl");
            localStorage.setItem("rtl", "True");
            $("head link#style").attr("href", $(this));
            (document.getElementById("style")?.setAttribute("href", "../../assets/plugins/bootstrap/css/bootstrap.rtl.min.css"));

			var carousel = $('.owl-carousel');
				$.each(carousel ,function( index, element)  {
				// element == this
				var carouselData = $(element).data('owl.carousel');
				carouselData.settings.rtl = true; //don't know if both are necessary
				carouselData.options.rtl = true;
				$(element).trigger('refresh.owl.carousel');
			});
        } else {
            $('body').removeClass('rtl');
            $('body').addClass('ltr');
            localStorage.setItem("rtl", "false"); 
            $("head link#style").attr("href", $(this));
            (document.getElementById("style")?.setAttribute("href", "../../assets/plugins/bootstrap/css/bootstrap.min.css"));
         }
    });
	
    $('#myonoffswitch54').click(function() {
	
        if (this.checked) {
            $('body').addClass('ltr');
            $('body').removeClass('rtl');
			$("html[lang=en]").attr("dir", "ltr");
            localStorage.setItem("ltr", "True");
            $("head link#style").attr("href", $(this));
            (document.getElementById("style")?.setAttribute("href", "../../assets/plugins/bootstrap/css/bootstrap.min.css"));
			var carousel = $('.owl-carousel');
			$.each(carousel ,function( index, element)  {
			// element == this
			var carouselData = $(element).data('owl.carousel');
			carouselData.settings.rtl = false; //don't know if both are necessary
			carouselData.options.rtl = false;
			$(element).trigger('refresh.owl.carousel');

		
		});
        } else {
            $('body').removeClass('ltr');
            $('body').addClass('rtl');
            localStorage.setItem("ltr", "false"); 
            $("head link#style").attr("href", $(this));
            (document.getElementById("style")?.setAttribute("href", "../../assets/plugins/bootstrap/css/bootstrap.rtl.min.css"));
         }
    });
		
		// $(document).ready (function(){
		// 	let bodyRtl = $('body').hasClass('rtl');
		// 	if (bodyRtl) {
		// 			$('body').addClass('rtl');
		// 			localStorage.setItem("rtl", "True");
		// 			$("head link#style").attr("href", $(this));
		// 			(document.getElementById("style")?.setAttribute("href", "../../assets/plugins/bootstrap/css/bootstrap.rtl.min.css"));
		// 		} 
		// 		else {
		// 			$('body').removeClass('rtl');
		// 			localStorage.setItem("rtl", "false");
		// 			$("head link#style").attr("href", $(this));
		// 			(document.getElementById("style")?.setAttribute("href", "../../assets/plugins/bootstrap/css/bootstrap.min.css"));
		// 		};
		// });

})(jQuery);


