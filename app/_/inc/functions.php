<?php
include 'functions-utils.php';
include 'functions-settings.php';

//add_action( 'pre_get_posts', 'exclude_category_from_blog' );
/**
 * Exclude Category from Blog
 *
 */
function exclude_category_from_blog( $query ) {

	//if( $query->is_main_query() && $query->is_home() ) {
		$query->set( 'cat', '-2' );
    //}

}
//add_action( 'pre_get_posts', 'change_event_posts_per_page' );
/**
 * Change Posts Per Page for Event Archive
 *
 */
function change_event_posts_per_page( $query ) {

	//if( $query->is_main_query() && !is_admin() && is_post_type_archive( 'event' ) ) {
		$query->set( 'posts_per_page', '-1' );
	//}
}


	function setSectionInfo() {
		global $SiteSection, $SubSection;
		$SiteSection = "";
		$SubSection = "";

		$path = parse_url($_SERVER['PHP_SELF'], PHP_URL_PATH);
		$pathInfo = trim(pathinfo($path, PATHINFO_DIRNAME));

		if ($pathInfo != "/") {
			$pathInfo = trim($pathInfo, "/");
			$pathParts = explode("/",$pathInfo);
			$SiteSection = $pathParts[0];

			if (count($pathParts) > 1) {
				$SubSection = $pathParts[1];
			}
		} else {
			if (basename($_SERVER['SCRIPT_NAME']) == "index.php") {
				$SiteSection = "home";
			}
		}
	}

	function slugify($text, $makeLowerCase = true) {
		// replace non letter or digits by -
		$text = preg_replace('~[^\\pL\d]+~u', '-', $text);

		// trim
		$text = trim($text, '-');

		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		// lowercase
		if ($makeLowerCase) {
			$text = strtolower($text);
		}

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		if (empty($text)) {
			return 'n-a';
		}

		return $text;
	}

	function ScrubText($text) {
		if (!isset($text) || trim($text)==='') {
			return '';
		}

		return trim($text);
	}

	function SendMail($to, $subject, $message, $html = true, $from = FROM_EMAIL) {
		$headers = "";
		if ($html) {
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		}
		$headers .= "From: " . $from;

		return mail($to, $subject, $message, $headers);
	}

	function HasFormError($fieldName) {
		global $FormErrors;

		if (isset($FormErrors[$fieldName])) {
			return $FormErrors[$fieldName];
		}

		return false;
	}

?>