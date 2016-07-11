        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width">
        <!-- Custom Favicon -->
        <link rel="shortcut icon" href="http://<?php echo($ServerName); ?>/favicon.ico">


        <!-- uild:css({.tmp,app}) _/css/bootstrap.css -->
        <!-- <link rel="stylesheet" href="_/bower_components/bootstrap/dist/css/bootstrap.css"> -->
        <!-- <link rel="stylesheet" href="_/bower_components/bootstrap/dist/css/bootstrap-theme.css"> -->
        <!-- endbuild -->

        <!-- build:css({.tmp,app}) _/css/site-styles.css -->
        <link rel="stylesheet" href="_/css/main.css">
        <link rel="stylesheet" href="_/css/layout.css">
        <!-- endbuild -->

        <!-- build:js _/js/vendor/modernizr.js -->
        <!-- <script src="_/vendor/modernizr-build.js"></script> -->
        <!-- endbuild -->

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1,  user-scalable=0, minimal-ui">
  <meta name="apple-mobile-web-app-capable" content="yes"/>
  <link rel="stylesheet" href="_/vendor/lightbox.css">


    <!-- Don't connect with the internet if we don't have to -->
      <script>
        var uri = new URL(window.document.URL);
        var live = uri.hostname == "sf-eagle.mirror" || uri.hostname == "localhost" || uri.hostname == "127.0.0.1"  ? false : true;
        function is_live(msg){
            console.info(live ? 'HOT' : 'COLD' + ": " + msg);
        }
        is_live('head.php');


      </script>

          <!-- <script src="_/vendor/jquery-2.1.4.min.js"></script> -->
          <script src="_/vendor/jquery-2.1.1.js"></script>



<!-- uild:js _/js/respond.js -->
<!--[if lt IE 9]>
<script src="_/vendor/jRespond.min.js"></script>
<![endif]-->
<!-- endbuild -->
