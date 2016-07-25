<?php
  /**
    * @package WordPress
    * @var bool
    **/

  date_default_timezone_set('America/Los_Angeles');

  define('WP_DEBUG', true); // HOTT ••• dev only
  ini_set('error_reporting', E_ALL);
  //error_reporting(-1);
  ini_set('display_errors', 'stderr');
  ini_set('html_errors', true);
  ini_set('error_prepend_string', 'GIRRRLLL ... ');

  define('WP_USE_THEMES', false);
  include_once( dirname( __FILE__ ) . '/../../../../wp_rogue/wp-blog-header.php' );

  //set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] );

	require("_/inc/functions.php");

    /*
     * Used in a few places during dev
     */
    $root_wp_url = "http://sf-eagle.mirror/wp/"; //HOTT ••• dev only
    // $spacer_url=$root_wp_url . "wp-content/uploads/2016/07/1pixel.gif"; //HOTT ••• check this, dev
    $spacer_url=get_image_url_by_slug('1pixel'); //HOTT ••• check this, dev


	//Constants
	define("FROM_EMAIL", "http://sf-eagle.com/rogue <webform@http://sf-eagle.com/rogue>");

	//Setup Variable for tracking VirtualPageViews in analytics.
	$VirtualPageView = "";

	//Variables to store Site/URL information
	$ServerName = $_SERVER['SERVER_NAME'];
	$SiteSection = "";
	$SubSection = "";

	$RequestMethod = $_SERVER['REQUEST_METHOD'];
	$FormErrors = array();

	//setSectionInfo();

	//SET SERVER SPECIFIC VARIABLES AND CONSTANTS
	switch ($ServerName) {
		case 'localhost':
			define("CONTACT_EMAIL", "");
			define("ANALYTICS_ID", "");
			break;

		case 'http://sf-eagle.com/rogue/www':
			define("CONTACT_EMAIL", "");
			define("ANALYTICS_ID", "UA-42163204-1");
			break;
	}

?>
