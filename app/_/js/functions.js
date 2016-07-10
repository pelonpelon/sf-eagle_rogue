/* global _gaq */

/* exported TrackEvent */
function TrackEvent(category, action, label, url) {
	try {
		_gaq.push(['_trackEvent', category, action, label]);

		if (url) {
			setTimeout(function() {
				document.location.href = url;
			}, 1000);
			return false;
		}
		return true;
	} catch(e) {
		//Do nothing, it's just a track event.
	}
}

// make logo image modal work

modal_contents = $('.logo .hidden').html();
console.log(modal_contents);
$('.logo.open-lightbox img').addClass('noclick');
$('.logo.open-lightbox img').attr('data-jslghtbx', 'http://127.0.0.1/Sites/sf-eagle/www/rogue/wp/wp-content/uploads/2016/07/1pixel.gif');
$('.logo.open-lightbox img').attr('data-jslghtbx-caption', modal_contents);


