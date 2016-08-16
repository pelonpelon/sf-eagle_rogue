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

// Click on news <a> stop modal from loading
$('.news a').on('click', function(e){e.stopPropagation();});

// Click on link in jslghtbx-caption <a> stop modal from closing

//$('.jslghtbx-caption').on('click', function(e){
//console.log('clicked');
//e.stopPropagation();});


