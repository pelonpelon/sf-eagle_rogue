<!-- build:js(app) _/js/main.js -->
<script src="_/js/functions.js"></script>
<script src="_/js/validation.js"></script>
<script src="_/vendor/jquery.jpanelmenu.js"></script>
<script src="_/vendor/lightbox.js" type="text/javascript"></script>
<!-- endbuild -->

  <!-- jPanelMenu -->
<script>
var jpm=$.jPanelMenu({
    menu: '#menu',
    panel: '#panel',
    trigger: '.menu-trigger',
    closeOnContentClick: true,
    clone: true,
    duration: 0,
    });
jpm.on();
</script>

<!-- Grow touchable items, like buttons, for fat fingers -->        <!--NOTE ••• is this a thing? -->
<script>
//if (Modernizr.touchevents) {
    //var els = document.querySelectorAll('.touch');
    //for (var i=0; i<els.length; i++){els[i].classList.add('touch-button-size')};
//}
</script>
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

$('.open-lightbox')
.each(function(){
    var imgsrc = $(this).find('img')[0];
    $(this).on('click', function(e){
        if ( $(e.target).closest('.open-lightbox').length != 0 ) {
            lightbox.open(imgsrc);
        }
    })
});
</script>

<!-- Facebook -->
<script>
if (window.matchMedia) {

    // on load
    mql = window.matchMedia("(min-device-width: 768px) and (orientation:landscape)");
    var logo = $('.logo')[0];
    if (mql.matches) {
        loadFacebook();
        logo.classList.remove('open-lightbox');
    }

    // on orientation change
    mql.addListener(mqlHandler);
    function mqlHandler(mql) {
        if(mql.matches) {
            loadFacebook();
            // we don't want a tap on the logo to bring up facebook as well
            logo.classList.remove('open-lightbox');
        }else{
            logo.classList.add('open-lightbox');
        }
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
