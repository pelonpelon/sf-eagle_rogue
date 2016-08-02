<?php
// display shortcodes
//add_action( 'admin_notices', 'show_shortcodes' );
//print '<pre>' . htmlspecialchars( print_r( $GLOBALS['shortcode_tags'], TRUE ) ) . '</pre>';
//add_action('load-' $pagenow, 'show_shortcodes');
//function show_shortcodes()
//{
  //global $shortcode_tags;
  //$help=implode($shortcode_tags);
  //$help="<pre>" .$help. "</pre>";
  //$where = get_current_screen();
  //if ( $where->base != 'post' ) { return; }
  //get_current_screen()->add_help_tab($where->ID,  )
//}
add_action( "load-post.php", 'add_post_shortcodes_tab' , 20 );
function add_post_shortcodes_tab()
{
  $screen = get_current_screen();

  if($screen->id == 'post')
  {
    //throw new Exception(gettype($GLOBALS['shortcode_tags']));
    ksort($GLOBALS['shortcode_tags']);
    $shortcodes=implode('<br />',array_keys($GLOBALS['shortcode_tags']));
    $screen->add_help_tab( array(
      'id'       => 'post_help'
      ,'title'    => __( 'Shortcodes', 'text_domain' )
      ,'content'  => $shortcodes
    ) );
  }
}

add_action( "admin_notices", 'add_events_type_meta_data_tab' , 20 );
function add_events_type_meta_data_tab()
{
  $screen = get_current_screen();

  if($screen->id == 'post')
  {
    $new_start_num = get_the_date('r');

    $args = array(
      'meta_key'      => 'date_num',
      'orderby'       => 'meta_value_num',
      'order'         => 'DEC',
      'post_type'     => 'event',
      'post_status' => 'publish',
      'numberposts'   => 10
    );
    $old_events = get_posts($args);
    $new_starttime = get_post_meta(get_the_ID(), 'event_starttime', true);
    if ($new_starttime) {
      $new_start_date = new DateTime($new_starttime, new DateTimeZone('America/Los_Angeles'));
    }else{
      $new_start_date = new DateTime();
    }
    foreach($old_events as $old) {

      //echo $old->date . ' ' . $old->time . ' - ' . $old->date_num . ' =? ' . $new_start_date->format('U') . '<br>';
      if ($new_start_date->format('U') == $old->date_num) {
        //throw new Exception('got a match: ' . $old->post_title);
        //throw new Exception($old->date_num);
      //echo $new_start_date->format('Y-m-d G:i');
        //$output = '<pre>' . htmlspecialchars( print_r( $old, TRUE ) ) . '</pre>';
        $markup = '<div style="background-color: black; color: aliceblue; padding: 3px; width: 66%;">';
        //foreach ($old as $key => $value) {
          //$markup .= '<div>' . $key . ' => ' . $value . '</div>';
        //}

        $markup .= '<div>' . $old->post_title . '</div>';
        $notes = get_post_meta($old->ID, 'notes', true);
        $markup .= '<div><span style="color: blue;">notes:</span><br>' . $notes . '</div>';
        $image = get_post_meta($old->ID, 'image', true);
        $markup .= '<div><span style="color: blue;">image:</span><br>' . $image . '</div>';
        $crowd = get_post_meta($old->ID, 'crowd', true);
        $markup .= '<div><span style="color: blue;">crowd:</span><br>' . implode(' ', $crowd) . '</div>';
        $price = get_post_meta($old->ID, 'price', true);
        $markup .= '<div><span style="color: blue;">price:</span><br>$' . $price . '</div>';
        $link = get_post_meta($old->ID, 'link', true);
        $markup .= '<div><span style="color: blue;">link:</span><br>' . $link . '</div>';
        $type_of_event = get_post_meta($old->ID, 'type_of_event', true);
        $markup .= '<div><span style="color: blue;">type:</span><br>' . implode('•',$type_of_event) . '</div>';
        if (implode('', $type_of_event) == 'music') {
          $promoter = get_post_meta($old->ID, 'promoter', true);
          $markup .= '<div><span style="color: blue;">promoter:</span><br>' . $promoter . '</div>';
          $promoter_link = get_post_meta($old->ID, 'promoter_link', true);
          $markup .= '<div><span style="color: blue;">promoter_link:</span><br>' . $promoter_link . '</div>';
          $band_1 = get_post_meta($old->ID, 'band_#1', true);
          $markup .= '<div><span style="color: blue;">band_#1:</span><br>' . $band_1 . '</div>';
          $band_1_link = get_post_meta($old->ID, 'band_#1_link', true);
          $markup .= '<div><span style="color: blue;">band_#1_link:</span><br>' . $band_1_link . '</div>';
          $band_2 = get_post_meta($old->ID, 'band_#2', true);
          $markup .= '<div><span style="color: blue;">band_#2:</span><br>' . $band_2 . '</div>';
          $band_2_link = get_post_meta($old->ID, 'band_#2_link', true);
          $markup .= '<div><span style="color: blue;">band_#2_link:</span><br>' . $band_2_link . '</div>';
          $band_3 = get_post_meta($old->ID, 'band_#3', true);
          $markup .= '<div><span style="color: blue;">band_#3:</span><br>' . $band_3 . '</div>';
          $band_3_link = get_post_meta($old->ID, 'band_#3_link', true);
          $markup .= '<div><span style="color: blue;">band_#3_link:</span><br>' . $band_3_link . '</div>';
          $band_4 = get_post_meta($old->ID, 'band_#4', true);
          $markup .= '<div><span style="color: blue;">band_#4:</span><br>' . $band_4 . '</div>';
          $band_4_link = get_post_meta($old->ID, 'band_#4_link', true);
          $markup .= '<div><span style="color: blue;">band_#4_link:</span><br>' . $band_4_link . '</div>';
        }
        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($old->ID), 'full');
        $markup .= '<div><span style="color: blue;">thumb:</span><br>' . $thumb[0] . '</div>';
        $markup .= '</div>';
        print $markup;
      }
    }
  }
}

// enforce custom field required    //FIXX ••• notices show up on wrong screens 
add_action( 'admin_notices', 'required_custom_fields' );
function required_custom_fields() {
  $where = get_current_screen();
  if ( $where->base != 'post' ) { return; }
  $ID = get_the_ID();
  $post_type = get_post_field( 'post_type', $ID );
  if ( $post_type == 'post' ) {
    $needed = array();
    $missing = array();
    if ( get_post_meta($ID, 'event_starttime', true) == null ) $needed[] = 'Start_Time' ;
    if ( get_post_meta($ID, 'event_endtime', true) == null ) $needed[] = 'End_Time' ;
    if ( get_post_meta($ID, 'event_postcard', true) == null ) $needed[] = 'Postcard' ;
    if ( get_post_meta($ID, 'event_url', true) == null ) $needed[] = 'Facebook' ;
    if ( get_post_meta($ID, 'event_djs', true) == null ) $missing[] = 'DJs' ;
    if ( get_post_meta($ID, 'event_hosts', true) == null ) $missing[] = 'Hosts' ;
    if (!empty($needed)):
      $markup = '<div style="background-color: gold; padding: 3px; width: 33%;"><h3 style="margin: 0;">NEEDED: ';
    $markup .= ' ' . implode('&nbsp;&nbsp;&nbsp;&nbsp;', $needed) . '</h3></div>';
    echo $markup;
    endif;
    if (!empty($missing)):
      $markup = '<div style="background-color: skyblue; padding: 3px; width: 33%;"><h3 style="margin: 0;">MISSING: ';
    $markup .= ' ' . implode('&nbsp;&nbsp;&nbsp;&nbsp;', $missing) . '</h3></div>';
    echo $markup;
    endif;
  }
}

// set publish date to custom field: start_time
add_action( 'admin_notices', 'update_publish_date' );
function update_publish_date() {
  $where = get_current_screen();
  if ( $where->base != 'post' ) { return; }
  $ID = get_the_ID();
  $post_type = get_post_field( 'post_type', $ID );
  if ( $post_type == 'post' ) {
    $start_time = get_post_meta($ID, 'event_starttime', true);
    $start_time_gmt = new DateTime($start_time);
    date_modify($start_time_gmt, '+8 hours');
    $pub_date = get_the_date('Y-m-d H:i');
    if ( ($start_time != '') && ($start_time != $pub_date) ) {
      $start_time .= ':00';
      $post_data = array('ID' => $ID, 'post_date' => $start_time, 'post_date_gmt' => $start_time_gmt->format('Y-m-d H:i:s'));
      wp_update_post($post_data);
      echo '<div style="background-color: lightgreen; padding: 5px; width: 33%;"><h3 style="margin: 0;">Pub Date Updated: ' . $start_time . '</h3></div>';
    }
  }
}


// Default post editor text //
function diww_default_post_content( $content ) {
  $where = get_current_screen();
  if ( $where->action != 'add' ) { return; }
  $ID = get_the_ID();
  $post_type = $where->post_type;
  if ( $post_type == 'post' ) {
    $content = '[title align="left"]
[when]
<p>[who]</p>
[more]';
  }
  if ( $post_type == 'staff' ) {
    $content = '[meta id=\'nickname\'] is one heluva guy
          <ul class="social_media">
          <li><a href="[meta id=\'facebook_url\']" target="_blank">Facebook</a></li>
          <li><a href="[meta id=\'twitter_url\']" target="_blank">Twitter</a></li>
          </ul>';
  }
    return $content;
  //}
}
add_filter( 'default_content', 'diww_default_post_content' );


// warn that date not set back one year
//add_action( 'admin_notices', 'warn_publish_date_needs_setback' );
//function warn_publish_date_needs_setback() {
  //$where = get_current_screen();
  //if ( $where->base != 'post' ) { return; }

  //$now = new DateTime();
  //$today = $now->format('ymd');
  //$this_year = $now->format('y');
  //$post_date = get_the_date();
  //$post_year = get_the_date('y');
  //$status = get_post_status();
  //if ( ($this_year == $post_year) && ($status == 'publish') ) {
    //echo '<div style="background-color: red; padding: 10px; width: 66%;"><h1 style="margin: 0";>Set date back one year: ' . get_the_date() . '</h1></div>';
  //}
//}


