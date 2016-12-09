(function($){
	$(document).ready(function() {

    // Forms submitter
    $('form .form_submit').click(function(e){
        e.preventDefault();
        $(this).parents('form').submit();
    });


    // Callback form
    $(".popup_callback_open").click(function(e) {
        e.preventDefault();
        $("#popup_callback").modal();
    });

    $('#popup_callback button[type=submit]').click(function(e){
        e.preventDefault();
        var form_selector = '#popup_callback form';
        if ( validate_form(form_selector) ) {
            feedback_send(form_selector);
            $(form_selector).slideUp();
            $('#popup_callback .modal-title').hide();
            $('#popup_callback .after-submit').show();
            clear_form(form_selector);
        }
    });


    // Index callback form
    $('#index_callback button[type=submit]').click(function(e){
        e.preventDefault();
        var form_selector = '#index_callback form';
        if ( validate_form(form_selector) ) {
            feedback_send(form_selector);
            $(form_selector).slideUp(300, function(){
                $('#index_callback .complete').fadeIn(500);
            });
            clear_form(form_selector);
        }
    });



    // Watchback form
    $(".popup_watchback_open").click(function(e) {
        e.preventDefault();
        $("#popup_watchback").modal();
    });

    $('#popup_watchback button[type=submit]').click(function(e){
        e.preventDefault();
        var form_selector = '#popup_watchback form';
        if ( validate_form(form_selector) ) {
            feedback_send(form_selector);
            $(form_selector).slideUp();
            $('#popup_watchback .modal-title').hide();
            $('#popup_watchback .after-submit').show();
            clear_form(form_selector);
        }
    });


	// Toggle search filter
	var filterBlock = $('#filters');
	$(document).on('click', '.toggle-filter, .toggle-filter1', function () {
		var showed = filterBlock.data('show');
		var $this = $(this);

		if (showed){
			filterBlock.slideUp(400);
			filterBlock.data('show', false);
			$this.html('Розширений пошук <span class="glyphicon glyphicon-chevron-down"></span>');
		}else {
			filterBlock.slideDown(400);
			filterBlock.data('show', true);
			$this.html('Приховати <span class="glyphicon glyphicon-chevron-up"></span>')
		}
	});



    // Send feedback
    function feedback_send(form_selector) {
        var form = $(form_selector);
        $.ajax({
            url: form.attr('action'),
            data: form.serialize(),
            type: 'POST',
            dataType: 'text',
            success: function (response) {
				if (form_selector == '#popup_watchback form'){
					dataLayer.push({'event': 'sendWatchbackForm'});
				}else if (form_selector == '#popup_callback form'){
					dataLayer.push({'event': 'sendCallbackForm'});
				}else { };
			},
            error: function (jqXHR) { }
        });
    }

    function clear_form(form_selector) {
        var fields_selector = form_selector + ' input';
        fields_selector += ', ' + form_selector + ' textarea';
        $(fields_selector).each(function(){
            $(this).val('');
        });
    }

    function validate_form(form_selector) {
        var telephone = $(form_selector + ' input[name=telephone]').val();
        var email = $(form_selector + ' input[name=email]').val();
        if ( telephone.length < 5 && email.length < 5 ) return false;
        return true;
    }


    // Change search display style
    $('.change-display-style').click(function(e){
        e.preventDefault();
        change_display_style( $(this).data('style') );
        $('.change-display-style').removeClass('active');
        $(this).addClass('active');
        Cookies.set('display-style', $(this).data('style'), { expires: 365 });
    });

    function change_display_style(class_to_display) {
        $('.search-result .display-style').hide();
        $('.search-result .display-style-' + class_to_display).show();
    }


		$(".popup_callback_open").click(function () {
			$("#popup_callback").modal();
		});
		$(".popup_watchback_open").click(function () {
			$("#popup_watchback").modal();
		});

		$('.response').click(function(e) {
		e.preventDefault();

		$('.nav').toggleClass('active');
		});

		$('.popup_open').click(function(e) {
		e.preventDefault();

		$('.selection_popup').toggleClass('active');
		$('.popup_open').toggleClass('active');
		});

		$('.map_close').click(function(e) {
		e.preventDefault();
		$('.map_canvas').toggleClass('active');
		});

		var owl = $("#owl-team");

		owl.owlCarousel({

			itemsCustom : [
				[0, 1],
				[450, 1],
				[600, 2],
				[700, 2],
				[1000, 4],
				[1200, 4],
				[1400, 4],
				[1600, 4]
			],
			navigation : false

		});

		var sync1 = $("#sync1");
		var sync2 = $("#sync2");

		sync1.owlCarousel({
			singleItem : true,
			slideSpeed : 1000,
			navigation: false,
			pagination:false,
			afterAction : syncPosition,
			responsiveRefreshRate : 200,
		});

		sync2.owlCarousel({
			items : 4,
			itemsDesktop      : [1199,4],
			itemsDesktopSmall     : [979,4],
			itemsTablet       : [768,4],
			itemsMobile       : [479,4],
			pagination:false,
			responsiveRefreshRate : 100,
			afterInit : function(el){
				el.find(".owl-item").eq(0).addClass("synced");
			}
		});

		function syncPosition(el){
			var current = this.currentItem;
			$("#sync2")
				.find(".owl-item")
				.removeClass("synced")
				.eq(current)
				.addClass("synced")
			if($("#sync2").data("owlCarousel") !== undefined){
				center(current)
			}
		}

		$("#sync2").on("click", ".owl-item", function(e){
			e.preventDefault();
			var number = $(this).data("owlItem");
			sync1.trigger("owl.goTo",number);
		});

		function center(number){
			var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
			var num = number;
			var found = false;
			for(var i in sync2visible){
				if(num === sync2visible[i]){
					var found = true;
				}
			}

			if(found===false){
				if(num>sync2visible[sync2visible.length-1]){
					sync2.trigger("owl.goTo", num - sync2visible.length+2)
				}else{
					if(num - 1 === -1){
						num = 0;
					}
					sync2.trigger("owl.goTo", num);
				}
			} else if(num === sync2visible[sync2visible.length-1]){
				sync2.trigger("owl.goTo", sync2visible[1])
			} else if(num === sync2visible[0]){
				sync2.trigger("owl.goTo", num-1)
			}

		}
	});
})(jQuery);

function initialize() {
	var map;
	var upravbud = new google.maps.LatLng(49.427447, 26.984324);
	var MY_MAPTYPE_ID = 'mystyle';
	var stylez = [{}];

	var mapOptions = {
		zoom: 17,
		disableDefaultUI: false,
		center: new google.maps.LatLng(49.427447, 26.984324),
		scrollwheel: false,
		mapTypeControlOptions: {
		 mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID]
		},
		mapTypeId: MY_MAPTYPE_ID
	};

	map = new google.maps.Map(document.getElementById("map_canvas"),mapOptions);
	var styledMapOptions = {
		name: ""
	};

	var jayzMapType = new google.maps.StyledMapType(stylez, styledMapOptions);
	map.mapTypes.set(MY_MAPTYPE_ID, jayzMapType);
	var marker = new google.maps.Marker({
		position: upravbud,
		map: map,
		title:"",
		icon: 'img/marker.png'
	});


}

var saveclass = null;

function saveTheme(cookieValue)
{
	var sel = document.getElementById('ThemeSelect');

	saveclass = saveclass ? saveclass : document.body.className;
	document.body.className = saveclass + ' ' + sel.value;

	setCookie('theme', cookieValue, 365);
}

function setCookie(cookieName, cookieValue, nDays) {
	var today = new Date();
	var expire = new Date();

	if (nDays==null || nDays==0)
		nDays=1;

	expire.setTime(today.getTime() + 3600000*24*nDays);
	document.cookie = cookieName+"="+cookieValue + ";expires="+expire.toGMTString();
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') c = c.substring(1, c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
	}
	return null;
}

document.addEventListener('DOMContentLoaded', function() {
	var themeSelect = document.getElementById('ThemeSelect');
	var selectedTheme = readCookie('theme');

	themeSelect.value = selectedTheme;
	saveclass = saveclass ? saveclass : document.body.className;
	document.body.className = saveclass + ' ' + selectedTheme;
});

/*/
$(document).ready(function() {

	var sync1 = $("#sync1");
	var sync2 = $("#sync2");

	sync1.owlCarousel({
		singleItem : true,
		slideSpeed : 1000,
		navigation: true,
		pagination:false,
		afterAction : syncPosition,
		responsiveRefreshRate : 200,
	});

	sync2.owlCarousel({
		items : 15,
		itemsDesktop      : [1199,10],
		itemsDesktopSmall     : [979,10],
		itemsTablet       : [768,8],
		itemsMobile       : [479,4],
		pagination:false,
		responsiveRefreshRate : 100,
		afterInit : function(el){
			el.find(".owl-item").eq(0).addClass("synced");
		}
	});

	function syncPosition(el){
		var current = this.currentItem;
		$("#sync2")
			.find(".owl-item")
			.removeClass("synced")
			.eq(current)
			.addClass("synced")
		if($("#sync2").data("owlCarousel") !== undefined){
			center(current)
		}
	}

	$("#sync2").on("click", ".owl-item", function(e){
		e.preventDefault();
		var number = $(this).data("owlItem");
		sync1.trigger("owl.goTo",number);
	});

	function center(number){
		var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
		var num = number;
		var found = false;
		for(var i in sync2visible){
			if(num === sync2visible[i]){
				var found = true;
			}
		}

		if(found===false){
			if(num>sync2visible[sync2visible.length-1]){
				sync2.trigger("owl.goTo", num - sync2visible.length+2)
			}else{
				if(num - 1 === -1){
					num = 0;
				}
				sync2.trigger("owl.goTo", num);
			}
		} else if(num === sync2visible[sync2visible.length-1]){
			sync2.trigger("owl.goTo", sync2visible[1])
		} else if(num === sync2visible[0]){
			sync2.trigger("owl.goTo", num-1)
		}

	}

});
/**/
