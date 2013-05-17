// Set up PhotoSwipe with all anchor tags in the Gallery container
(function(window, PhotoSwipe){
	document.addEventListener('DOMContentLoaded', function(){
		var
		options = {},
		instance = PhotoSwipe.attach( window.document.querySelectorAll('#Gallery a'), options );	
	}, false);
}(window, window.Code.PhotoSwipe));

//jQuery version
// $(document).ready(function(){

// 	var myPhotoSwipe = $("#Gallery a").photoSwipe({ enableMouseWheel: false , enableKeyboard: false });

// });