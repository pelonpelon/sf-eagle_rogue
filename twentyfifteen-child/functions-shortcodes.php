<?php


/*

$tw = isset($md['twitter_url']) ? $md['twitter_url'] : false;
$fb = isset($md['facebook_url']) ? $md['facebook_url'] : false;
$tm = isset($md['tumblr_url']) ? $md['tumblr_url'] : false;
 * */

function shortcode_get_field_array($prefix, $args){
  $attrs = shortcode_atts( array(
    'id' => false,
    'fmt' => false,
  ), $args );
  if ($attrs['id']){
    $attrs['id'] = $prefix . $attrs['id'];
    $data = get_post_meta(get_the_ID(), $attrs['id'], false);
    $attrs['items'] = array_pop($data);
  }
  return  (object) $attrs;
}

function shortcode_title( $args ){
  $post_title = get_the_title();
  if ($post_title) {
    $title = str_replace(' !@# ', '&nbsp;', strtoupper(str_replace('&nbsp;', ' !@# ', $post_title)));
    $attrs = shortcode_atts( array(
      'align' => 'center',
    ), $args );
    $markup = '<h3 class=\'title\' style=\'text-align: ';
    $markup .= $attrs['align'];
    $markup .= ';\'>';
    $markup .= "$title";
    $markup .= '</h3>';
    return $markup;
  }
}
add_shortcode( 'title', 'shortcode_title' );

function shortcode_post_title( $args ){
  return get_the_title();
}
add_shortcode( 'post_title', 'shortcode_post_title' );

function shortcode_subtitle( $args ){
  $subtitle = get_post_meta(get_the_ID(), 'event_subtitle', true);
  if ($subtitle) {
    $attrs = shortcode_atts( array(
      'align' => 'center',
    ), $args );
    $markup = '<h4 class="subtitle" style=\'text-align: ';
    $markup .= $attrs['align'];
    $markup .= ';\'>';
    $markup .= "$subtitle";
    $markup .= '</h4>';
    return $markup;
  }
}
add_shortcode( 'subtitle', 'shortcode_subtitle' );

// gets metadata conditional altering the output
function shortcode_post_meta( $args ){
  $field = shortcode_get_field_array('event_', $args);

  // in case of missing id, return empty string //FIXX log this somehow
  if (!$field->id) {return "";}
  $cls = str_replace('_', '-', $field->id);
  $markup = '';
  if ($field->id[strlen($field->id)-1] == 's' ) {
    if ($field->fmt == 'list') {
      $markup = '<ul class=\'' .$cls. '\'>';
      while (!empty($field->items)) {
        $markup .= '<li>';
        $markup .= array_shift($field->items);
        $markup .= '</li>';
      }
      $markup .= '</ul>';
    }else if($field->fmt == 'row') {
      while (!empty($field->items)) {
        $markup .= array_pop($field->items);
        if (!empty($field->items)) {
          $markup .= ' & ';
        }
      }
    }
  } else {
    $data = get_post_meta(get_the_ID(), $field->id, true);
    if ($field->fmt == 'bare') {
      $output = $data;
    }else{
      $output = '<span class=\'' .$cls. '\'>' .$data. '</span>';
    }
    $markup = $output;
  }

  return $markup;
}
add_shortcode( 'meta', 'shortcode_post_meta' );

// Event who
function list_who() {
  $ID = get_the_ID();
  $hosts = implode(' • ', get_post_meta($ID, 'event_hosts', true));
  $guests = implode(' • ', get_post_meta($ID, 'event_guests', true));
  $djs = implode(' • ', get_post_meta($ID, 'event_djs', true));
  $markup = '';
  if ($hosts) { $markup .= ' <li class="hosts"><span class="label">Hosting: </span>' .$hosts. '</li>'; }
  if ($guests) { $markup .= ' <li class="guests"><span class="label">With: </span>' .$guests. '</li>'; }
  if ($djs) { $markup .= ' <li class="djs"><span class="label">Spinning: </span>' .$djs. '</li>'; }
  return $markup;
}

function row_who() {
  $ID = get_the_ID();

  $markup = '';

  $hosts_array = get_post_meta($ID, 'event_hosts', true);
  if ($hosts_array) {
    foreach ($hosts_array as &$host) { $host = str_replace(' ', '&nbsp', $host); unset($host); }
    $hosts = '<span class="person">' .implode(' </span><span class="person">', $hosts_array). '</span>';
    $markup .= ' <li class="hosts"><span class="label">hosting: </span>' .$hosts. '</li>';
  }

  $guests_array = get_post_meta($ID, 'event_guests', true);
  if ($guests_array) {
    foreach ($guests_array as &$guest) { $guest = str_replace(' ', '&nbsp', $guest); unset($host); }
    $guests = '<span class="person">' .implode(' </span><span class="person">', $guests_array). '</span>';
    $markup .= ' <li class="guests"><span class="label">with: </span>' .$guests. '</li>';
  }

  $djs_array = get_post_meta($ID, 'event_djs', true);
  if ($djs_array) {
    foreach ($djs_array as &$dj) { $dj = str_replace(' ', '&nbsp', $dj); unset($host); }
    $djs = '<span class="person">' .implode(' </span><span class="person">', $djs_array). '</span>';
    $markup .= ' <li class="djs"><span class="label">spinning: </span>' .$djs. '</li>';
  }

  return $markup;
}

function shortcode_event_who( $args ){
  $markup = '';
  $field = shortcode_get_field_array('event_', $args);
//if ($field->id == 'list') {throw new Exception(print_r($args));}
  // the default
  if ((!$field->id && !$field->fmt) || (!$field->id && $field->fmt)) {
    $who = row_who();
    if ($who) {
      $markup = '<div class="who">';
      $markup .= '<ul>';
      $markup .= row_who();
      $markup .= '</ul>';
      $markup .= '</div>';
    }
  }

  // Want specific data
  if ($field->id) {

    // if it's a list
    if ($field->id[strlen($field->id)-1] == 's' ){

      // vertical list
      if ($field->fmt == 'row') {
        $who = row_who();
        if ($who) {
          $markup = '<div class="who">';
          $markup .= '<ul>';
          $markup .= row_who();
          $markup .= '</ul>';
          $markup .= '</div>';
        }
      } else if ($field->fmt == 'bare') {
        while (!empty($field->items)) {
          $markup .= array_pop($field->items);
          if (!empty($field->items)) {
            $markup .= ' • ';
          }
        }

      // default vertical list
      } else if ($field->fmt == 'list') {
        $who = list_who();
        if ($who) {
          $markup = '<div class="who">';
          $markup .= '<ul>';
          $markup .= list_who();
          $markup .= '</ul>';
          $markup .= '</div>';
        }
      }

      // it's not a list
    } else {
        $data = get_post_meta(get_the_ID(), $field->id, true);
        if ($data) {
          $markup = $data. ' - not a list';
        }
    }
  }
  return $markup;
}
add_shortcode( 'who', 'shortcode_event_who' );

function shortcode_event_url() {
  $url = get_post_meta(get_the_ID(), 'event_url', true);
  $markup = '';
  if ($url) {
    $markup .= $url;
  }
  return $markup;
}
add_shortcode( 'url', 'shortcode_event_url' );

function shortcode_event_more() {
  $url = get_post_meta(get_the_ID(), 'event_url', true);
  $markup = '';
  if ($url) {
      $markup .= '<a class="more" href="' .$url. '" target="_blank">MORE INFO...</a><br />';
  }
  return $markup;
}
add_shortcode( 'more', 'shortcode_event_more' );

function shortcode_event_cover() {
    $data = get_post_meta(get_the_ID(), 'event_cover', true);
    $markup = '';
    if ($data) {
      $markup .= '<span class="label cover">Cover: </span>' . $data;
    }
    return $markup;
}
add_shortcode( 'cover', 'shortcode_event_cover' );

function shortcode_event_when($args) {
  $attrs = shortcode_atts( array(
    'fmt' => false,
  ), $args );
  $ID = get_the_ID();
  $date = new DateTime(get_the_date('r'), new DateTimeZone('America/Los_Angeles'));
  $starthour = $date->format('g:ia');
  $event_endtime = get_post_meta($ID, 'event_endtime', true);
  $endtime = new DateTime($event_endtime);
  $endhour = $endtime->format('g:ia');
  $event_date = $date->format('l, M d');
  if (!$attrs['fmt']) {
    $markup = '<div class="when">';
    $markup .= '<span class="date">' .$event_date. '</span><br />';
    $markup .= '<span class="time">' .$starthour. ' :: ' .$endhour. '</span><br />';
    $markup .= '</div>';
    return $markup;
  }else{
    return $date->format($attrs['fmt']);
  }
}
add_shortcode( 'when', 'shortcode_event_when' );

// Get any page contents
function shortcode_page_content_by_title( $args ){
    $attrs = shortcode_atts( array(
        'title' => 'Error',
    ), $args );
    $title = $attrs['title'];
    $title_oneword = str_replace(array('_',' '), '-', strtolower($title));
    $page = get_page_by_title_safely($title);
    $markup = '<div class="wp-page '.$title_oneword.'">';
    $markup .= do_shortcode($page->post_content);
    $markup .= '</div>';
    return $markup;
}
add_shortcode( 'page', 'shortcode_page_content_by_title' );

// Get template contents
function shortcode_template_content_by_title( $args ){
  $attrs = shortcode_atts( array(
    'title' => 'Error',
  ), $args );
  $title = $attrs['title'];
  $title_oneword = str_replace(array('_',' '), '-', strtolower($title));
  $template = get_page_by_title($title);
  if ($template) {
      $markup = '<div class="wp-template '.$title_oneword.'">';
      $markup .= do_shortcode($template->post_content);
      $markup .= '</div>';
      return $markup;
  }else{
      $markup = '<div class="wp-template">';
      $markup .= '</div>';
      return '<!-- template: ' . $title_oneword . ' NOT FOUND --> '
          . $markup;
  }
}
add_shortcode( 'template', 'shortcode_template_content_by_title' );

// Get any image in database
function shortcode_image_by_name( $args ){
  $attachment_url = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'large');
    $attrs = shortcode_atts( array(
        'title' => false,
        'size' => 'large',
    ), $args );
    $title = $attrs['title'];
    if ($title) {
      return get_image_url_by_slug($title);
    }else if ($attachment_url[0]) {
      return $attachment_url[0];
    }else{
      return '';
    }
}
add_shortcode( 'image', 'shortcode_image_by_name' );

function shortcode_band_list( $args ){
  $ID = get_the_ID();
  $band_names = shortcode_get_field_array('event_', array('id' => 'band_names' ) );
  $band_urls = shortcode_get_field_array('event_', array('id' => 'band_urls' ) );
  if (!$band_urls->items) {
    $band_urls->items = array_fill(0, 10, 'https://www.facebook.com/SFEagle.ThursdayNightLive/');
  }
  $promoter = get_post_meta($ID, 'event_promoter', true);
  if ($promoter) {
    $promoter_url = get_post_meta($ID, 'event_promoter_url', true);
  }else{
    $promoter_url = '#';
  }

  $field = shortcode_get_field_array('event_', $args);

  $markup = '<div class=\'band-list\'>';

  if (!$field->id) {
    if ($promoter) {
      $markup .= '<h4 class=\'promoter\'>';
      $markup .= $promoter;
      $markup .= '</h4>';
    }
    $markup .= '<ul>';
    while (!empty($band_names->items)) {
      $markup .= '<li>• ';
      $markup .= array_shift($band_names->items);
      $markup .= '</li>';
    }
    $markup .= '</ul>';
  } else if ($field->id == 'event_complete') {
    //throw new Exception('<pre>field' . print_r($field) . '</pre>');
    if ($promoter) {
      $markup .= '<h4 class=\'promoter\'>';
      if ($promoter_url) {
        $markup .= '<a href=\'';
        $markup .= $promoter_url;
        $markup .= '\' target=\'_blank\'>';
      }
        $markup .= $promoter;
      if ($promoter_url) {
        $markup .= '</a>';
      }
      $markup .= '</h4>';
    }
    $markup .= '<ul>';
    while (!empty($band_names->items)) {
      $markup .= '<li>';
      if ($url = array_shift($band_urls->items)) {
        $markup .= '<a href=\'';
        $markup .= $url;
        $markup .= '\' target=\'_blank\'>';
      }
      $markup .= array_shift($band_names->items);
      if ($url) {
        $markup .= '</a>';
      }
      $markup .= '</li>';
    }
    $markup .= '</ul>';
  }
  $markup .= '</div>';
  return $markup;
}
add_shortcode( 'band_list', 'shortcode_band_list' );

// gets STAFF metadata conditional altering the output
function shortcode_staff_meta( $args ){
  $field = shortcode_get_field_array('staff_', $args);
  //var_export($field);

  // in case of missing id, return empty string //FIXX log this somehow
  if (!$field->id) {return "";}
  $cls = str_replace('_', '-', $field->id);
  $markup = '';
  if ($field->id[strlen($field->id)-1] == 's' ) {
    if ($field->fmt == 'list') {
      $markup = '<ul class=\'' .$cls. '\'>';
      while (!empty($field->items)) {
        $markup .= '<li>';
        $markup .= array_shift($field->items);
        $markup .= '</li>';
      }
      $markup .= '</ul>';
    }else if($field->fmt == 'row') {
      while (!empty($field->items)) {
        $markup .= array_pop($field->items);
        if (!empty($field->items)) {
          $markup .= ' & ';
        }
      }
    }
  } else {
    $data = get_post_meta(get_the_ID(), $field->id, true);
    if ($field->fmt == 'markup') {
      $output = '<span class=\'' .$cls. '\'>' .$data. '</span>';
    }else{
      $output = $data;
    }
    $markup = $output;
  }

  return $markup;
}
add_shortcode( 'staff', 'shortcode_staff_meta' );

require_once('functions-shortcodes-social.php');
