        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width">
        <!-- Custom Favicon -->
        <link rel="shortcut icon" href="http://<?php echo($ServerName); ?>/favicon.ico">


        <!-- build:css({.tmp,app}) _/css/main.css -->
        <link rel="stylesheet" href="_/css/main.css">
        <link rel="stylesheet" href="_/css/layout.css">
        <!-- endbuild -->

        <!-- build:js(app) _/vendor/mod-jq.min.js -->
        <script src="_/vendor/modernizr.js"></script>
        <script src="_/vendor/jquery-2.1.1.js"></script>
        <!-- endbuild -->

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1,  user-scalable=1, minimal-ui">
  <meta name="apple-mobile-web-app-capable" content="yes"/>
  <link rel="stylesheet" href="_/vendor/lightbox.css">


    <!-- Don't connect with the internet if we don't have to -->
      <script>
        var uri = new URL(window.document.URL),
            live = true;
        if (uri.hostname.substr(0,3) == '127' || uri.hostname.substr(0,3) == '192' || uri.hostname.substr(0,3) == '169' ) {
            live = false;
        } else if (uri.hostname == "sf-eagle.mirror" || uri.hostname == "localhost") {
            live = false
        }
        function is_live(msg){
            console.info(live ? 'HOT' : 'COLD' + ": " + msg);
        }

        is_live('is_live() function in head.php');
      </script>

<!--      <script async src="_/vendor/fastclick.min.js"></script>
        <script>(function() {
            content = document.getElementsByClassName('page-content');
            window.addEventListener('load', function() {
                return FastClick.attach(content[0], false);
            });

            }).call(this);
        </script>
-->

          <!-- <script src="_/vendor/jquery-2.1.4.min.js"></script> -->

        <!-- uild:js(app) _/vendor/jquery.min.js -->
        <!-- endbuild -->



<!--build:js _/vendor/respond.js -->
<!--[if lt IE 9]>
<script src="_/vendor/jRespond.min.js"></script>
<![endif]-->
<!-- endbuild -->
