(function( $ ) {
	'use strict';

	var slideUpNotification = function(){
        $(".won.webo-order-notification").toggleClass("display_notification");
        var cook        = getCookie('won_orders');
        if (typeof(cook) === 'undefined' ) {
            return;
        } 
        else {
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
                                    '<p class="won-billing-name"><span>' + json_obj[random_int].customer_name + '</span> recently purchased</p>' +
                                    '<p class="won-product-name" ><b>' + json_obj[random_int].product_name + '</b></p>' +
                                    '<small>About <span class="won-time-diff">' + json_obj[random_int].time_ago + '</span> ago</small>' +
                                '</div>' +
                            '</div>' +
                        '</a>' +
                        '<span class="won-close"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times" class="svg-inline--fa fa-times fa-w-11" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512"><path fill="#082e73" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path></svg></span>';
            $('.webo-order-notification').html(popup_html);
        }
	}


    var setUpInterval = setInterval(slideUpNotification, 7000);
    
    $(document).on('click', '.won-close', function () {
        $(".won.webo-order-notification").hide();
    });


	function getCookie(name) {
	    const value = `; ${document.cookie}`;
		const parts = value.split(`; ${name}=`);
		if (parts.length === 2) return parts.pop().split(';').shift();
    }

})( jQuery );
