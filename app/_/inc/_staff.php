<?php
$args = array(
    'orderby'       => 'post_date',
    'order'         => 'ASC',
    'post_type'     => array('staff'),
    'post_status'   => array('publish'),
    'posts_per_page' => -1,
    'numberposts'   => -1
);
$Items = new WP_Query( $args );
?>

  <div id="staff" class="page-content">

  <div class="scrollbox">
  <div class="scroller">

  <div class="staff-box">  <?php

while ($Items->have_posts()): $Items->the_post();
$ID = $Items->post->ID;

?>
              <div class="post staff-item open-lightbox">
<?php
$attachment_url = wp_get_attachment_url( get_post_thumbnail_id( $ID ) );
$staff_content = do_shortcode(get_the_content());
$attrs = array('class' => 'noclick', 'data-jslghtbx' => $attachment_url, 'data-jslghtbx-caption' => $staff_content);
$profile = do_shortcode(get_post_meta($ID, 'event_profile', true));
if ( has_post_thumbnail() ) {
    $post_thumbnail_img = get_the_post_thumbnail(null, 'medium', $attrs);
} else {
    $thumbnail_ID = get_image_ID_by_slug('1pixel');
    set_post_thumbnail( $post, $thumbnail_ID );
    $post_thumbnail_img = get_the_post_thumbnail(null, 'thumbnail', $attrs);
}
?>
                <div class="staff-content">
                <div class="post-thumbnail"><?php echo $post_thumbnail_img ?></div>
                <div class='staff-profile'><?php echo $profile; ?></div>
                </div>
              </div>
<?php
endwhile;

//global $wp_query;
//var_dump($wp_query->query_vars);

wp_reset_postdata();
?>
      </div>
  </div>
  </div>
</div>

