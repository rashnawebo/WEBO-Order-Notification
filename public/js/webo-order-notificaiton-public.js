(function( $ ) {
	'use strict';

	var slideUpNotification = function(){
		$(".won.webo-order-notification").slideUp('slow', function() {
            var cook        = getCookie('won_orders');

            let decoded_str = decodeURIComponent(cook);
            let json_obj    = JSON.parse(decoded_str);
            var obj_length  = json_obj.length;
            var random_int  = Math.floor(Math.random() * obj_length)

            var popup_html = '<a class="won-product-url" href="' + json_obj[random_int].product_url + '" target="_blank">' +
                            '<div class="won-notification">' +
                                '<div class="won-product-image">' +
                                    '<img class="won-product-img" src="' + json_obj[random_int].image_url +'">' +
                                '</div>' +
                                '<div class="won-order-content">' +
                                    '<p class="won-billing-name">' + json_obj[random_int].customer_name + ' recently purchased</p>' +
                                    '<p class="won-product-name" ><b>' + json_obj[random_int].product_name + '</b></p>' +
                                    '<small>About <span class="won-time-diff">' + json_obj[random_int].time_ago + '</span> ago</small>' +
                                '</div>' +
                            '</div>' +
                        '</a>' +
                        '<span class="won-close">x</span>';
            $('.webo-order-notification').html(popup_html);

        });
	}
    var slideDownNotification = function() {
        $(".won.webo-order-notification").slideDown('slow');
    }

    var setUpInterval   = setInterval(slideUpNotification, 7000);
    var setDownInterval = setInterval(slideDownNotification, 4000);

    $(document).ready(function(){
        $('.webo-order-notification').mouseenter(function(){
            console.log('hovering');
            clearInterval(setUpInterval);
            clearInterval(setDownInterval);
        }).mouseout(function(){
            setUpInterval   = setInterval(slideUpNotification, 7000);
            setDownInterval = setInterval(slideDownNotification, 4000);
        });
    });

	function getCookie(name) {
	    const value = `; ${document.cookie}`;
		const parts = value.split(`; ${name}=`);
		if (parts.length === 2) return parts.pop().split(';').shift();
    }

})( jQuery );
