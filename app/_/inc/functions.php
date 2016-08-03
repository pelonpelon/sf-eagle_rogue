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

// Check email every 15 minutes for post
add_action( 'shutdown', 'retrieve_post_via_mail' );
function retrieve_post_via_mail() {
    //require_once('wp-cron.php');
    $file = APP_PATH.'logs/transients.log';
    flush(); // Display the page before the mail fetching begins
    if ( get_transient( 'retrieve_post_via_mail' ) ) {
        return; // The mail has been checked recently; don't check again
    } else { // The mail has not been checked in more than 15 minutes
        do_action( APP_PATH.'inc/wp-mail.php' );
        set_transient( 'retrieve_post_via_mail', 1, 15 * MINUTE_IN_SECONDS ); // check again in 15 minutes.
    }
}

// Check and advance weekly and monthly expired events
add_action( 'shutdown', 'advance_periodic_events' );
function advance_periodic_events() {
    $file = APP_PATH.'logs/transients.log';
    //throw new Exception("\n\n". APP_PATH2 ."\n\n".__file__."\n\n".$file."\n\n".getcwd()."\n\n");
    $entry = "\n\n" .date('ymd G:i:s'). " :advance_periodic_events\n";
    file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);
    flush(); // Display the page before the mail fetching begins
    if ( get_transient( 'advance_periodic_events' ) ) {
        $entry = date('ymd G:i:s'). " :advance_periodic_events :skipping action wp-cron.php\n";
        file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);
        return;
    } else {
        $entry = date('ymd G:i:s'). " :advance_periodic_events :require_once wp-cron.php\n";
        file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);
        require_once('wp-cron.php');
        reschedule_weekly_events();
        reschedule_monthly_events();

        //do_action( 'wp-cron.php' );
        if (set_transient( 'advance_periodic_events', 1, 15 * MINUTE_IN_SECONDS )) { // check  every hour
            $entry = date('ymd G:i:s'). " :advance_periodic_events :set transient success\n";
            file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);
        }else{
            $entry = date('ymd G:i:s'). " :advance_periodic_events :set transient failed\n";
            file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);
        }
    }
}

function HasFormError($fieldName) {
    global $FormErrors;

    if (isset($FormErrors[$fieldName])) {
        return $FormErrors[$fieldName];
    }

    return false;
}


//NOTES GODADDY runs chron jobs. wp-cron.php is executed when requested
//NOTES set_transient is an option but runs too often
