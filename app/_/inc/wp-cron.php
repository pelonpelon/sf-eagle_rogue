<?php

global $past_items;

//$file = APP_PATH.'logs/transients.log';
$entry = date('ymd G:i:s'). " :wp-cron.php\n";
//file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);

$args = array(
    'orderby'       => 'post_date',
    'order'         => 'DEC',
    'post_type'     => array('post'),
    'post_status'   => array('publish'),
    'numberposts'   => 100
);
$past_items = new WP_Query( $args );
//print_r($past_items->have_posts());
//throw new Exception($past_items->have_posts());

//FIXX ••• send email to myself to confirm

// reset past events scheduled weekly
function reschedule_weekly_events() {
    global $past_items;
    //$file = APP_PATH.'logs/transients.log';
    $entry = date('ymd G:i:s'). " :wp-cron.php :reschedule_weekly_events\n";
    //file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);

    while ($past_items->have_posts()): $past_items->the_post();

    $ID = get_the_ID();
    $weekly = get_post_meta($ID, 'event_weekly', true);
    if (!$weekly || !in_category('event')) { continue; }
    $now = new DateTime();
    $today = $now->format('l');
    $date = new DateTime(get_the_date('r'), new DateTimeZone('America/Los_Angeles'));
    $post_date = $date->format('Y-m-d');
    //if ($ID == 5573){throw new Exception("post_date < today: ". $post_date . " < " . $date->format('Y-m-d'));};
    if ($post_date >= $now->format('Y-m-d')) { continue; }
    $post_day = $date->format('l');
    $post_time = $date->format('G:i');

    if ($now->format('Y-m-d') != $post_day ) {
        $new_date_utc = strtotime("$post_day $post_time America/Los_Angeles");
        $date_gmt = new DateTime('@'.$new_date_utc);
        $date_gmt_string = $date_gmt->format('Y-m-d H:i:s');
        $date_gmt->setTimeZone( new DateTimeZone('America/Los_Angeles' ));
        $date_string = $date_gmt->format('Y-m-d H:i:s');
        $post_data = array('ID' => $ID, 'post_date' => $date_string, 'post_date_gmt' => $date_gmt_string);
        wp_update_post($post_data);
        $date_string = $date_gmt->format('Y-m-d H:i');
        update_post_meta($ID, 'event_starttime', $date_string);

        //$file = APP_PATH.'logs/transients.log';
        $entry = date('ymd G:i:s'). ' :wp-cron.php: ' .get_the_title(). ' scheduled for ' .$date_string;
        $entry .= date('ymd G:i:s'). " :wp-cron.php :reschedule_weekly_events SENDING EMAIL\n";
        //file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);

        wp_mail( CONTACT_EMAIL, 'reschedule_weekly_events: '. get_the_title(),
            get_the_title(). ' scheduled for ' .$date_string );
    }
    endwhile;
    wp_reset_postdata();
}

// reset past events scheduled monthly
function reschedule_monthly_events() {
    global $past_items;
    //$file = APP_PATH.'logs/transients.log';
    $entry =  date('ymd G:i:s'). " :wp-cron.php :reschedule_monthly_events\n";
    //file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);

    while ($past_items->have_posts()): $past_items->the_post();

    $ID = $past_items->post->ID;
    $md = get_post_custom($ID);

    if (!isset($md['event_monthly_ordinals'][0]) || !in_category('event')) { continue; }
    //$monthly_ordinal = $md['event_monthly_ordinals'][0];

    $now = new DateTime();
    $today = $now->format('l');
    $date = new DateTime(get_the_date('r'), new DateTimeZone('America/Los_Angeles'));
    $post_date = $date->format('Y-m-d');
    if ($post_date >= $now->format('Y-m-d')) { continue; }
    $post_day = $date->format('l');
    $post_time = $date->format('G:i');

    $monthly_day = $md['event_monthly_days'][0];

    if ($today != $post_day ) {
        foreach ($md['event_monthly_ordinals'] as $monthly_ordinal) {
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

            //$file = APP_PATH.'logs/transients.log';
            $entry = date('ymd G:i:s'). ' :wp-cron.php: ' .get_the_title(). ' scheduled for ' .$date_string;
            $entry .= date('ymd G:i:s'). " :wp-cron.php :reschedule_monthly_events SENDING EMAIL\n";
            //file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);

            wp_mail( CONTACT_EMAIL, 'reschedule_monthly_events: '. get_the_title(),
                get_the_title(). ' scheduled for ' .$date_string );
        }
    }
    endwhile;
    wp_reset_postdata();
}
//reschedule_weekly_events();
//reschedule_monthly_events();
//if ( ! wp_next_scheduled( 'every_morning_at_3am' ) ) {
    //wp_schedule_event( strtotime('03:00'), 'daily', 'every_morning_at_3am' );
//}
//if ( ! wp_next_scheduled( 'every_morning_at_2am' ) ) {
    //wp_schedule_event( strtotime('02:00'), 'daily', 'every_morning_at_2am' );
//}
//add_action( 'every_morning_at_2am', 'reschedule_weekly_events' );
//add_action( 'every_morning_at_3am', 'reschedule_monthly_events' );

