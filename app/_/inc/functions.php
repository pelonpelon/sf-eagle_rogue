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
    flush(); // Display the page before the mail fetching begins
    if ( get_transient( 'retrieve_post_via_mail' ) ) {
        return; // The mail has been checked recently; don't check again
    } else { // The mail has not been checked in more than 15 minutes
        do_action( 'wp-mail.php' );
        set_transient( 'retrieve_post_via_mail', 1, 15 * MINUTE_IN_SECONDS ); // check again in 15 minutes.
    }
}

function HasFormError($fieldName) {
    global $FormErrors;

    if (isset($FormErrors[$fieldName])) {
        return $FormErrors[$fieldName];
    }

    return false;
}

// reset past events scheduled weekly
function reschedule_weekly_events() {
    $args = array(
        'orderby'       => 'post_date',
        'order'         => 'ASC',
        'post_type'     => array('post'),
        'post_status'   => array('publish'),
        'numberposts'   => 100
    );
    $Items = new WP_Query( $args );

    while ($Items->have_posts()): $Items->the_post();

    $ID = $Items->post->ID;
    $weekly = get_post_meta($ID, 'event_weekly', true);
    if (!$weekly || !in_category('event')) { continue; }

    $now = new DateTime();
    $today = $now->format('l');
    $date = new DateTime(get_the_date('r'), new DateTimeZone('America/Los_Angeles'));
    $post_day = $date->format('l');
    $post_time = $date->format('G:i');

    if ($today != $post_day ) {
        $new_date_utc = strtotime("$post_day $post_time America/Los_Angeles");
        $date_gmt = new DateTime('@'.$new_date_utc);
        $date_gmt_string = $date_gmt->format('Y-m-d H:i:s');
        $date_gmt->setTimeZone( new DateTimeZone('America/Los_Angeles' ));
        $date_string = $date_gmt->format('Y-m-d H:i:s');
        //throw new Exception($post_day.'_'.$post_time.' ds: '.$date_string.' gmt: '.$date_gmt_string);
        $post_data = array('ID' => $ID, 'post_date' => $date_string, 'post_date_gmt' => $date_gmt_string);
        wp_update_post($post_data);
        $date_string = $date_gmt->format('Y-m-d H:i');
        update_post_meta($ID, 'event_starttime', $date_string);
    }
endwhile;
}
// reset past events scheduled monthly
function reschedule_monthly_events() {
    $args = array(
        'orderby'       => 'post_date',
        'order'         => 'ASC',
        'post_type'     => array('post'),
        'post_status'   => array('publish'),
        'numberposts'   => 100
    );
    $Items = new WP_Query( $args );

    while ($Items->have_posts()): $Items->the_post();

    $ID = $Items->post->ID;
    $monthly_day = get_post_meta($ID, 'event_monthly_day', true);
    if (!$monthly_day || !in_category('event')) { continue; }
    $monthly_ordinal = get_post_meta($ID, 'event_monthly_ordinal', true);

    $now = new DateTime();
    $today = $now->format('l');
    $date = new DateTime(get_the_date('r'), new DateTimeZone('America/Los_Angeles'));
    $post_day = $date->format('l');
    $post_time = $date->format('G:i');

    if ($today != $post_day ) {
        $new_date_utc = strtotime("$monthly_ordinal $post_day of next month $post_time America/Los_Angeles");
        $date_gmt = new DateTime('@'.$new_date_utc);
        $date_gmt_string = $date_gmt->format('Y-m-d H:i:s');
        $date_gmt->setTimeZone( new DateTimeZone('America/Los_Angeles' ));
        $date_string = $date_gmt->format('Y-m-d H:i:s');
        //throw new Exception($post_day.'_'.$post_time.' ds: '.$date_string.' gmt: '.$date_gmt_string);
        $post_data = array('ID' => $ID, 'post_date' => $date_string, 'post_date_gmt' => $date_gmt_string);
        wp_update_post($post_data);
        $date_string = $date_gmt->format('Y-m-d H:i');
        update_post_meta($ID, 'event_starttime', $date_string);
    }
endwhile;
}
if ( ! wp_next_scheduled( 'every_morning_at_2am' ) ) {
    wp_schedule_event( strtotime('02:00'), 'daily', 'every_morning_at_2am' );
}
add_action( 'every_morning_at_2am', 'reschedule_weekly_events' );
add_action( 'every_morning_at_2am', 'reschedule_monthly_events' );

