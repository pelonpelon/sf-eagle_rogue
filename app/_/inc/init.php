<?php
  /**
    * @package WordPress
    * @var bool
    **/

  define('WP_DEBUG', true); // FIXX: dev only
  ini_set('error_reporting', E_ALL);
  //error_reporting(-1);
  ini_set('display_errors', 'stderr');
  ini_set('html_errors', true);
  ini_set('error_prepend_string', 'GIRRRLLL ... ');

  define('WP_USE_THEMES', false);
  require( dirname( __FILE__ ) . '/../../../../wp/wp-blog-header.php' );       //FIXX ••• dev

  /*
   *
   * Used in a few places during dev
   */
  $root_wp_url = "http://sf-eagle.mirror/wp/"; //FIXX dev only
  $spacer_url=$root_wp_url . "wp-content/uploads/2016/07/1pixel.gif"; //FIXX: check this, dev

  //set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] );

    date_default_timezone_set('America/Los_Angeles');
	require("_/inc/functions.php");

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

		case 'http://sf-eagle.com/rogue':
			define("CONTACT_EMAIL", "");
			define("ANALYTICS_ID", "");
			break;
	}

?>
