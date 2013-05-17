//bxslider
jQuery(document).ready(function($) {
    // Slideshow.
    // Examples in: http://bxslider.com/
    // $('#slideshow').bxSlider();
    $('.entry-content').fitVids();
});


//Photoswipe
// Set up PhotoSwipe with all anchor tags in the Gallery container
(function(window, PhotoSwipe){
	document.addEventListener('DOMContentLoaded', function(){
		var
		options = {},
		instance = PhotoSwipe.attach( window.document.querySelectorAll('#Gallery a'), options );	
	}, false);
}(window, window.Code.PhotoSwipe));