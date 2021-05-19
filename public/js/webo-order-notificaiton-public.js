(function( $ ) {
	'use strict';

	var slideNotification = function(){
		$(".won.webo-order-notification").stop().slideToggle('slow', function() {
            var cook = getCookie('won_orders');
            // var search = cook.replace(/\\/g, "");
            let decoded_str = decodeURIComponent(cook);
            let json_obj =JSON.parse(decoded_str);

            $.each(json_obj, function(index, element) {
                $('.won-billing-name').html(element.customer_name);
                $('.won-product-name').html(element.product_name);
                $('.won-time-diff').html(element.time_ago);
                $('.won-product-url').attr('href', element.product_url);
                $('.won-product-img').attr('src', element.image_url);
            });
        });
	}
	var interval = setInterval(slideNotification, 4000);

    /* $('.won.webo-order-notification').hover(function() {
        setInterval(slideNotification, 4000);
    }, function() {
    	interval = setInterval( slideNotification, 4000);
    });

	$(".won-close").click(function()
	{
		$(".won.webo-order-notification").stop().slideToggle('slow');
  	}); */

	function getCookie(name) {
	    const value = `; ${document.cookie}`;
		const parts = value.split(`; ${name}=`);
		if (parts.length === 2) return parts.pop().split(';').shift();
    }

})( jQuery );
