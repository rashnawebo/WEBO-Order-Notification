(function( $ ) {
	'use strict';

	var slideNotification = function(){
		$(".won.webo-order-notification").stop().slideToggle('slow');
	}
	var interval = setInterval(slideNotification, 4000);

    console.log(JSON.parse(getCookie('won_orders')));

    /* $('.won.webo-order-notification').hover(function() {
        setInterval(slideNotification, 4000);
    }, function() {
    	interval = setInterval( slideNotification, 4000);
    });

	$(".won-close").click(function()
	{
		$(".won.webo-order-notification").stop().slideToggle('slow');
  	}); */

    function setDynamicContent() {

    }

	function getCookie(name) {
	    const value = `; ${document.cookie}`;
		const parts = value.split(`; ${name}=`);
		if (parts.length === 2) return parts.pop().split(';').shift();
    }

})( jQuery );
