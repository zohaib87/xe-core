/*--------------------------------------------------------------
# Mian Js Start
--------------------------------------------------------------*/
(function($) {

/*--------------------------------------------------------------
# Dynamic Styles
--------------------------------------------------------------*/
$('*[class*="xe-"]').each(function(){
    var css = $(this).data('xe-css');
    $( "<style>"+css+"</style>" ).appendTo( "head" );
    $(this).removeAttr('data-xe-css');
});

/*--------------------------------------------------------------
# Animation
--------------------------------------------------------------*/
var wow = new WOW({
    boxClass: 'wow', // animated element css class (default is wow)
    animateClass: 'animated', // animation css class (default is animated)
    offset: 100, // distance to the element when triggering the animation (default is 0)
    mobile: false // trigger animations on mobile devices (true is default)
});
wow.init();

/*--------------------------------------------------------------
# Counters
--------------------------------------------------------------*/
$('.count').counterUp({
    delay: 50,
    time: 5000
});
	
})( jQuery );