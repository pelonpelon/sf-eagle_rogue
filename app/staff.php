<?php require('./_/inc/init.php'); ?>
<!doctype html>
<!--[if lt IE 7]>    <html class="no-js ie ie6 lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>     <html class="no-js ie ie7 lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>     <html class="no-js ie ie8 lt-ie9"> <![endif]-->
<!--[if IE 9]>     <html class="no-js ie ie9 lt-ie10"> <![endif]-->
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5-els.js"></script>
<![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
<head>
  <title></title>
  <meta name="description" content="">
  <?php require("_/inc/head.php"); ?>
</head>
<body>
<div class="pg-frame">
  <?php require('_/inc/header.php'); ?>
  <?php require('_/inc/home.php'); ?>

  <!--[if lt IE 9]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser.
    Please <a href="http://browsehappy.com/">upgrade your browser</a>
    or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
  <![endif]-->

  <?php //require('_/inc/footer.php'); ?>

</div>
  <!-- JAVASCRIPT -->
  <?php require('_/inc/analytics.php'); ?>

  <?php require('_/inc/tail.php'); ?>
</body>
</html>
