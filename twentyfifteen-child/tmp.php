<?php

$prefix = 'event_';

function shortcode_title( $args ){
  $attrs = shortcode_atts( array(
    'align' => 'center',
  ), $args );
  $markup = '<h3 style=\'text-align: ';
  $markup .= $attrs['align'];
  $markup .= ';\'>';
  $markup .= get_the_title();
  $markup .= '</h3>';
  return $markup;
}
add_shortcode( 'title', 'shortcode_title' );

function shortcode_post_title( $args ){
  return get_the_title();
}
add_shortcode( 'post_title', 'shortcode_post_title' );

function shortcode_subtitle( $args ){
  $attrs = shortcode_atts( array(
    'align' => 'center',
  ), $args );
  $markup = '<h4 style=\'text-align: ';
  $markup .= $attrs['align'];
  $markup .= ';\'>';
  $markup .= get_post_meta(get_the_ID(), 'event_subtitle', true);
  $markup .= '</h4>';
  return $markup;
}
add_shortcode( 'subtitle', 'shortcode_subtitle' );

function shortcode_get_field_array($args){
    global $prefix;
    $attrs = shortcode_atts( array(
        'id' => 'default',
        'fmt' => 'bare',
    ), $args );
    $attrs['id'] = $prefix . $attrs['id'];
    $data = get_post_meta(get_the_ID(), $attrs['id'], false);
    $attrs['items'] = array_pop($data);
    return  (object) $attrs;
}

// gets metadata conditional altering the output
function shortcode_post_meta( $args ){
  //var_export($args);
  $field = shortcode_get_field_array($args);
  //var_export($field);
  //throw new Exception("EXEPTION: $field->list");
  if ($field->id[strlen($field->id)-1] == 's' ) {
    if ($field->fmt == 'list') {
  //throw new Exception("EXEPTION: $field->items");
      $cls = str_replace('_', '-', $args['id']);
      $markup = '<ul class=\'' .$cls. '\'>';
      while (!empty($field->items)) {
        $markup .= '<li>';
        $markup .= array_shift($field->items);
        $markup .= '</li>';
      }
      $markup .= '</ul>';
    }else if($field->fmt == 'row') {
      $markup = '';
      while (!empty($field->items)) {
        //$markup .= '<span class=' . $field->id . '>' . array_pop($field->items) . '</span> ';
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
      $cls = str_replace('_', '-', $args['id']);
      $output = '<span class=\'' .$cls. '\'>' .$data. '</span>';
    }
    //$markup = '<span class=' . $field->id . '>' . $output . '</span>';
    $markup = $output;
  }
  //throw new Exception("EXEPTION: $markup");

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
function shortcode_event_who( $args ){
  $markup = '';
  $field = shortcode_get_field_array($args);
  if ($field->id != 'event_default' ) {
      // vertical list
      if ($field->fmt == 'list') {
        $markup = '<div class="who">';
        $markup .= '<ul>';
        if ($field->id == 'event_hosts') { $markup .= '<li class="hosts label">Hosted by:</li>'; }
        elseif ($field->id == 'event_guests') { $markup .= '<li class="guests label">With:</li>'; }
        elseif ($field->id == 'event_djs') { $markup .= '<li class="djs label">DJs:</li>'; }
        while (!empty($field->items)) {
          $markup .= '<li>• ';
          $markup .= array_shift($field->items);
          $markup .= '</li>';
        }
        $markup .= '</ul>';
        $markup .= '</div>';
      // A & B & C
      } else if ($field->fmt == 'row' || !$field->fmt) {
        $markup = '<div class="who">';
        if ($field->id == 'event_hosts') { $markup .= '<span class="hosts label">Hosted by: </span>'; }
        elseif ($field->id == 'event_guests') { $markup .= '<span class="guests label">With: </span>'; }
        elseif ($field->id == 'event_djs') { $markup .= '<span class="djs label">DJs: </span>' ; }
        while (!empty($field->items)) {
          $markup .= array_pop($field->items);
          if (!empty($field->items)) {
            $markup .= ' & ';
          }
        }
        $markup .= '</div>';
      } else if ($field->fmt == 'bare') {
        while (!empty($field->items)) {
          $markup .= array_pop($field->items);
          if (!empty($field->items)) {
            $markup .= ' • ';
          }
        }
        // just return the data  
    } else {
          $markup = '<div class="who">';
          $markup .= '<ul>';
          $markup .= list_who();
          $markup .= '</ul>';
          $markup .= '</div>';
      // just return the data  
      } else {
          $data = get_post_meta(get_the_ID(), $field->id, true);
          $markup = $data;
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
  $page = get_page_by_title_safely($title);
  return do_shortcode($page->post_content);
}
add_shortcode( 'page', 'shortcode_page_content_by_title' );

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
  $band_names = shortcode_get_field_array( array('id' => 'band_names' ) );
  $band_urls = shortcode_get_field_array( array('id' => 'band_urls' ) );
  if (!$band_urls->items) {
    $band_urls->items = array_fill(0, 10, 'https://www.facebook.com/SFEagle.ThursdayNightLive/');
  }
  $promoter = get_post_meta($ID, 'event_promoter', true);
  if ($promoter) {
    $promoter_url = get_post_meta($ID, 'event_promoter_url', true);
  }else{
    $promoter_url = '#';
  }

  $field = shortcode_get_field_array($args);

  $markup = '<div class=\'band-list\'>';

  if ($field->id == 'event_default' ) {
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
      $markup .= '<h4 class=\'promoter\'><a href=\'';
      $markup .= $promoter_url;
      $markup .= '\' target=\'_blank\'>';
      $markup .= $promoter;
      $markup .= '</a></h4>'; 
    }
    $markup .= '<ul>';
    while (!empty($band_names->items)) {
      $markup .= '<li>• ';
      $markup .= '<a href=\'';
      $markup .= array_shift($band_urls->items);
      $markup .= '\' target=\'_blank\'>';
      $markup .= array_shift($band_names->items);
      $markup .= '</a></li>';
    }
    $markup .= '</ul>';
  }
  $markup .= '</div>';
  return $markup;
}
add_shortcode( 'band_list', 'shortcode_band_list' );

