<?php
add_filter( 'rwmb_meta_boxes', 'event_meta_boxes' );
function event_meta_boxes( $meta_boxes ) {
    $prefix = 'event_';
    $meta_boxes[] = array(
        'title'      => __( 'Event Details', $prefix ),
        'post_types' => 'post',
        'fields'     => array(
            array(
                'id'   => 'dj',
                'name' => __( 'DJs', $prefix ),
                'type' => 'text',
                'clone'=> true,
            ),
                  // SLIDER
            array(
              'name'       => esc_html__( 'Cover', $prefix ),
              'id'         => "{$prefix}Cover",
              'type'       => 'slider',
              // Text labels displayed before and after value
              'prefix'     => esc_html__( '$', $prefix ),
              // jQuery UI slider options. See here http://api.jqueryui.com/slider/
              'js_options' => array(
                'min'  => 1,
                'max'  => 100,
                'step' => 1,
              ),
              // Default value
              'std' 		=> 8,
            ),
        ),
    );
    return $meta_boxes;
}


