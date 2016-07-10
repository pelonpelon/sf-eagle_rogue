<!-- build:js(app) _/js/main.js -->
<!-- <script src="_/bower_components/jquery/jquery.js"></script> -->
<script src="_/js/functions.js"></script>
<script src="_/js/validation.js"></script>
<script src="_/vendor/jquery.jpanelmenu.js"></script>
<!-- endbuild -->

<!-- uild:js(app) /_/js/bootstrap.js -->
<!-- <script src="_/bower_components/bootstrap/dist/js/bootstrap.js"></script> -->
<!-- endbuild -->

  <!-- jPanelMenu -->
<script>
var jpm=$.jPanelMenu({
menu: 'menu',
    trigger: '.menu-trigger',
    panel: '#menu-panel',
    clone: 'false',
    });
jpm.on();
</script>

 <!-- <script defer async src="master.js"></script> -->
  <!-- Grow touchable items, like buttons, for fat fingers -->
<script>
if (Modernizr.touchevents) {
    var els = document.querySelectorAll('.touch');
    for (var i=0; i<els.length; i++){els[i].classList.add('touch-button-size')};
}
</script>
    <script src="_/vendor/lightbox.js" type="text/javascript"></script>
<script>
var options = {
    dimensions: 		true,
    captions: 			true,
    prevImg: 			false,
    nextImg: 			false,
    hideCloseBtn: 		true,
    closeOnClick: 		true,
    loadingAnimation: 	200,
    animElCount: 		4,
    preload: 			true,
    carousel: 			true,
    animation: 			400,
    nextOnClick: 		false,
    responsive: 		true,
    maxImgSize:			0.8,
    keyControls: 		true,
    addClickEvents:     true,
    // callbacks
    onopen: function(){
        // ...
    },
    onclose: function(){
        // ...
    },
    onload: function(){
        // ...
    },
    onresize: function(event){
        // ...
    },
    onloaderror: function(event){
        // ...
    }
  };

var lightbox = new Lightbox();
lightbox.load(options);
</script>

<!-- build:remove:dist -->
<script src="//localhost:1025/livereload.js"></script>
<!-- /build -->
