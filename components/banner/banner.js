/**
 * Animated scroll link anchor in header.
 */
jQuery(document).ready(function($){
	$('.odin-scroll-link a').on('click', function(e) {
		e.preventDefault();
		var scrollTop = $(this).attr('href');
		if(scrollTop) {
			$('html, body').animate({ scrollTop: $(scrollTop).offset().top}, 500, 'linear');
		}
	});
});
