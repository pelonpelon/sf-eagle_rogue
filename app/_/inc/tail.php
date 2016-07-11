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

<!-- Grow touchable items, like buttons, for fat fingers -->        <!--NOTE ••• is this a thing? -->
<script>
//if (Modernizr.touchevents) {
    //var els = document.querySelectorAll('.touch');
    //for (var i=0; i<els.length; i++){els[i].classList.add('touch-button-size')};
//}
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

<!-- Facebook -->
<script>
if (window.matchMedia) {
    //alert('matchMedia is present');
    mql = window.matchMedia("(min-device-width: 768px) and (orientation:landscape)");
    if (mql.matches) {loadFacebook();}
    mql.addListener(mqlHandler);
    function mqlHandler(mql) {
      if(mql.matches) {loadFacebook();}
    };
};
function loadFacebook() {
    is_live('loadFacebook');
    if(!live){
        return;
    }
    var js,
        fjs = document.getElementsByTagName('script')[0];
    if (document.getElementById('facebook-jssdk')) return;
    js = document.createElement('script');
    js.id = 'facebook-jssdk';
    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";
    fjs.parentNode.insertBefore(js, fjs);
};
//(function(d, s, id) {
    //var js,
        //fjs = d.getElementsByTagName(s)[0];
    //if (d.getElementById(id)) return;
    //js = d.createElement(s);
    //js.id = id;
    //js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";
    //fjs.parentNode.insertBefore(js, fjs);
//}(document, 'script', 'facebook-jssdk'));
</script>

<!-- build:remove:dist -->
<script src="//localhost:1025/livereload.js"></script>

<!-- /build -->
