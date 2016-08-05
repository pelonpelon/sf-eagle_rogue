<?php
add_filter( 'rwmb_meta_boxes', 'event_meta_boxes' );
function event_meta_boxes( $meta_boxes ) {
  $prefix = 'event_';
  $now = new DateTime();
  $now = new DateTime(null, new DateTimeZone('America/Los_Angeles'));
  date_modify($now, 'yesterday 9:00 pm');
  $partytime = $now->format('Y-m-d H:i');
  date_modify($now, '2:00 am ' . date('T'));
  $closingtime = $now->format('Y-m-d H:i');
  $meta_boxes[] = array(
    'title'       => __( 'Event Details', $prefix ),
    'post_types'  => 'post',
    'autosave'    => true,
    'context'     => 'advanced',
    'priority'    => 'high',
    'fields'      => array(
      array(
        'name'     => esc_html__( 'SUBTITLE', $prefix ),
        'id'     => $prefix . 'subtitle',
        'type' => 'text',
        'size'  =>  '40',
      ),
      // START TIME
      array(
        'name'     => esc_html__( 'START TIME', $prefix ),
        'id'     => $prefix . 'starttime',
        'type'     => 'datetime',
        'std'    => $partytime,
        // jQuery datetime picker options.
        // For date options, see here http://api.jqueryui.com/datepicker
        // For time options, see here http://trentrichardson.com/examples/timepicker/
        'js_options' => array(
          'stepMinute'   => 30,
          'showTimepicker' => true,
        ),
      ),
      // END TIME
      array(
        'name'     => esc_html__( 'END TIME', $prefix ),
        'id'     => $prefix . 'endtime',
        'type'       => 'time',
        'std'    => '02:00',
        // jQuery datetime picker options.
        // For date options, see here http://api.jqueryui.com/datepicker
        // For time options, see here http://trentrichardson.com/examples/timepicker/
        'js_options' => array(
          'stepMinute' => 30,
          'showSecond' => false,
          'stepSecond' => 10,
        ),
      ),
      // EXPIRES
      array(
        'name'     => esc_html__( 'EXPIRES (news)', $prefix ),
        'id'     => $prefix . 'expires',
        'type'     => 'datetime',
        'std'    => $partytime,
        'js_options' => array(
          'stepMinute'   => 30,
          'showTimepicker' => true,
        ),
      ),
      // WEEKLY
      array(
        'name' => esc_html__( 'WEEKLY', $prefix ),
        'id'   => $prefix . 'weekly',
        'type' => 'checkbox',
        'std'  => 0,
        'desc' => 'id=weekly',
      ),
      // MONTHLY ORDINALS
      array(
          'name'    => esc_html__( 'MONTHLY ORDINALS', $prefix ),
          'id'     => $prefix . 'monthly_ordinals',
          'type'    => 'checkbox_list',
          // Options of checkboxes, in format 'value' => 'Label'
          'options' => array(
              'first' => esc_html__( 'first', $prefix  ),
              'second' => esc_html__( 'second', $prefix  ),
              'third' => esc_html__( 'third', $prefix  ),
              'fourth' => esc_html__( 'fourth', $prefix  ),
              'fifth' => esc_html__( 'fifth', $prefix  ),
          ),
      ),
      // MONTHLY DAY
      array(
        'name'    => esc_html__( 'MONTHLY DAYS', $prefix ),
        'id'     => $prefix . 'monthly_days',
        'type'    => 'radio',
        'options' => array(
          'Monday' => esc_html__( 'Mon', $prefix  ),
          'Tuesday' => esc_html__( 'Tues', $prefix  ),
          'Wednesday' => esc_html__( 'Wed', $prefix  ),
          'Thursday' => esc_html__( 'Thurs', $prefix  ),
          'Friday' => esc_html__( 'Fri', $prefix  ),
          'Saturday' => esc_html__( 'Sat', $prefix  ),
          'Sunday' => esc_html__( 'Sun', $prefix  ),
        ),
      ),
      // URL
      array(
      'name' => esc_html__( 'URL (FB)', $prefix ),
      'id'   => $prefix . 'url',
      'type' => 'url',
      'std'  => '',
      'size'  =>  '60',
      ),
      // DEFAULT URL
      array(
        'name' => esc_html__( 'DEFAULT URL', $prefix ),
        'id'   => $prefix . 'default_url',
        'type' => 'url',
        'std'  => '',
        'size'  =>  '60',
      ),
      // DJs
      array(
      'id'   => $prefix . 'djs',
      'name' => esc_html__( 'DJs', $prefix ),
      'type' => 'text',
      'clone'=> true,
      'size'  =>  '60',
      ),
      // HOSTS
      array(
        'name' => esc_html__( 'HOSTS', $prefix ),
        'id'   => $prefix . 'hosts',
        'type' => 'text',
        'clone'=> true,
        'size'  =>  '60',
      ),
      // GUESTS
      array(
        'name' => esc_html__( 'GUESTS', $prefix ),
        'id'   => $prefix . 'guests',
        'type' => 'text',
        'clone'=> true,
        'size'  =>  '60',
      ),
      // COVER
      array(
        'name'     => esc_html__( 'COVER', $prefix ),
        'id'     => $prefix . 'cover',
        'type' => 'text',
        'size'  =>  '8',
        'maxlength' =>  '8',
        'pattern'   => '^\$[0-9]{1,3}$',
        'placeholder' =>  '$0',
      ),
      // COVER
      array(
        'name'     => esc_html__( 'DRINK SPECIAL', $prefix ),
        'id'     => $prefix . 'drink_special',
        'type' => 'text',
        'size'  =>  '60',
        'maxlength' =>  '60',
      ),
      // POSTCARD
      array(
        'name'  => esc_html__( 'POSTCARD', $prefix ),
        'id'    => $prefix . 'postcard',
        'type'  => 'wysiwyg',
        // Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
        'raw'   => true,
        'std'   => '[title]
[subtitle]
[who]',
        'options' => array(
          'textarea_rows' => 7,
          'teeny'     => false,
          'media_buttons' => false,
        ),
      ),
      // IMAGE ADVANCED (WP 3.5+)
      array(
        'name'             => esc_html__( 'GENERIC POSTER', $prefix ),
        'id'   => $prefix . 'generic_poster',
        'type'             => 'image_advanced',
        'max_file_uploads' => 1,
      ),
      // NOTES
      array(
        'name' => esc_html__( 'NOTES', $prefix ),
        'id'   => $prefix . 'notes',
        'type' => 'textarea',
        'cols' => 60,
        'rows' => 8,
      ),
    ),
  );
  $meta_boxes[] = array(
    'title'    => __( 'LIVE MUSIC', $prefix ),
    'post_types' => 'post',
    'autosave'   => true,
    'context'     => 'side',
    'priority'   => 'low',
    'fields'   => array(
    // TEXT
    array(
      'name'  => esc_html__( 'PROMOTER', $prefix ),
      'id'   => $prefix . 'promoter',
      'type'  => 'text',
      'std'   => esc_html__( '', $prefix ),
      'size'  =>  '60',
    ),
    // URL
    array(
      'name' => esc_html__( 'PROMOTER URL', $prefix ),
      'id'   => $prefix . 'promoter_url',
      'type' => 'url',
      'std'  => '',
      'size'  =>  '60',
    ),
    array(
      'name'  => esc_html__( 'BAND NAMES', $prefix ),
      'id'   => $prefix . 'band_names',
      'type'  => 'text',
      'clone' => true,
      'size'  =>  '60',
    ),
    // URL
    array(
      'name' => esc_html__( 'BAND URLS', $prefix ),
      'id'   => $prefix . 'band_urls',
      'type' => 'url',
      'desc'  => 'https://www.facebook.com/SFEagle.ThursdayNightLive/',
      'clone' => true,
      'size'  =>  '60',
    ),
    ),
  );

  $meta_boxes[] = array(
    'title'    => esc_html__( 'PAGE MODAL', $prefix ),
    'post_types' => 'page',
    'autosave'   => true,
    'fields'   => array(
    array(
      'name'  => esc_html__( 'POPUP MODAL', $prefix ),
      'id'    => $prefix . 'modal',
      'type'  => 'wysiwyg',
      // Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
      'raw'   => true,
      // Editor settings, see wp_editor() function: look4wp.com/wp_editor
      'options' => array(
      'textarea_rows' => 8,
      'teeny'     => false,
      'media_buttons' => true,
      ),
    ),
    ),
  );

  //
  //
  // STAFF
  //
  //
  $prefix = 'staff_';
  $meta_boxes[] = array(
    'title'    => esc_html__( 'STAFF DETAILS', $prefix ),
    'post_types' => 'staff',
    'autosave'   => true,
    'fields'   => array(
      array(
        'name' => esc_html__( 'NICKNAME', $prefix ),
        'id'   => $prefix . 'nickname',
        'type' => 'text',
      ),
      array(
        'name' => esc_html__( 'POSITION', $prefix ),
        'id'   => $prefix . 'position',
        'type' => 'text',
      ),
      array(
        'name'       => esc_html__( 'BIRTHDAY', 'your-prefix' ),
        'id'         => $prefix . 'birthday',
        'type'       => 'date',
        'std'        => 'Jan 01, 1983',
        // jQuery date picker options. See here http://api.jqueryui.com/datepicker
        'js_options' => array(
          'appendText'      => esc_html__( '(Jan 01, 1979)', 'your-prefix' ),
          'dateFormat'      => esc_html__( 'M dd, yy', 'your-prefix' ),
          'changeMonth'     => true,
          'changeYear'      => true,
          'showButtonPanel' => true,
        ),
      ),
      array(
        'name' => esc_html__( 'FACEBOOK URL', $prefix ),
        'id'   => $prefix . 'facebook_url',
        'type' => 'url',
        'size'  =>  '60',
      ),
      array(
        'name' => esc_html__( 'INSTAGRAM URL', $prefix ),
        'id'   => $prefix . 'instagram_url',
        'type' => 'url',
        'size'  =>  '60',
      ),
      array(
        'name' => esc_html__( 'TWITTER URL', $prefix ),
        'id'   => $prefix . 'twitter_url',
        'type' => 'url',
        'size'  =>  '60',
      ),
      array(
        'name' => esc_html__( 'TUMBLR URL', $prefix ),
        'id'   => $prefix . 'tumblr_url',
        'type' => 'url',
        'size'  =>  '60',
      ),
      array(
        'name' => esc_html__( 'OTHER SM URL', $prefix ),
        'id'   => $prefix . 'other_sm_url',
        'type' => 'url',
        'size'  =>  '60',
      ),
      array(
        'name' => esc_html__( 'WEBSITE URL', $prefix ),
        'id'   => $prefix . 'website_url',
        'type' => 'url',
        'size'  =>  '60',
      ),
      array(
        'name'  => esc_html__( 'POSTCARD', $prefix ),
        'id'    => $prefix . 'postcard',
        'type'  => 'wysiwyg',
        'raw'   => true,
        'std'   => '<ul class="details">
  <li>[title align="left"]</li>
  <li>[staff id="position"]</li>
</ul>',
        'options' => array(
          'textarea_rows' => 16,
          'teeny'     => false,
          'media_buttons' => true,
        ),
      ),
    ),
  );
  return $meta_boxes;
}


