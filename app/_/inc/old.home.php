
<div class="scrollbox">
    <div class="scroller">
<?php
      $args = array(
      'orderby'       => 'post_date',
      'order'         => 'ASC',
      'post_type'     => 'post',
      'post_status'   => 'publish',
      'numberposts'   => -1
      );
      $posts_by_post_date = get_posts($args);
?>
      <div class="news-box">
<?php
      foreach ( $posts_by_post_date as $post) {
        if ( ! in_category('news')) { continue; }
?>
            <div class="post news-item">
<?php
            $attachment_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
            $news_content = $post->post_content;
            $attrs = array('class' => 'noclick', 'data-jslghtbx' => $attachment_url, 'data-jslghtbx-caption' => $news_content);
            if ( has_post_thumbnail() ) {
                $post_thumbnail_img = get_the_post_thumbnail(null, 'thumbnail', $attrs);
            } else {
                $thumbnail_ID = get_attachment_ID_by_slug('1pixel');
                set_post_thumbnail( $post, $thumbnail_ID );
                $post_thumbnail_img = get_the_post_thumbnail(null, 'thumbnail', $attrs);
           }
?>
              <div class="news-content open-lightbox">
              <div class="post-thumbnail"><?php echo $post_thumbnail_img ?></div>
                <span><?php echo rwmb_meta( 'event_postcard' ); ?></span>
              </div>
            </div>
            <hr>
<?php } ?>
      </div>

      <div class="event-box">
<?php
      $current_day = '';
      foreach ( $posts_by_post_date as $post) {
        if ( ! in_category('event')) { continue; }
            $attachment_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
            $post_content = $post->post_content;
            $date = new DateTime($post->post_date);
            date_add($date, date_interval_create_from_date_string('1 year'));
            if ( $date->format('l') != $current_day ) {
                $current_day = $date->format('l');
                $new_day = true;
            } else {
                $new_day = false;
            }
            $post_day = $post->post_date;
            $attrs = array('data-jslghtbx' => $attachment_url, 'data-jslghtbx-caption' => $post_content);
            if ( has_post_thumbnail() ) {
                $post_thumbnail = get_the_post_thumbnail(null, 'thumbnail', $attrs);
            } else {
                set_post_thumbnail( $post, 80);
                $post_thumbnail = get_the_post_thumbnail(null, 'thumbnail', $attrs);
            }
            if ($new_day) { ?>
                <div class="new-day">
                  <span class="post-day"><?php echo $date->format('l'); ?></span>
                  <span class="post-date"><?php echo $date->format('M d'); ?></span>
                </div>
            <?php } ?>
            <div class="post event-item <?php echo $current_day; ?>">
            <div class="post-thumbnail"><?php echo get_the_post_thumbnail(null, 'thumbnail', $attrs) ?></div>
          <div class="event-info-box open-lightbox">
            <div class="event-title"><?php the_title(); ?></div>
            <div class="event-content"><?php echo rwmb_meta( 'event_postcard' ); ?></div>
            <div class="event-start-time"><?php echo $date->format('g:ia'); ?></div>
          </div>
        </div>
<?php } ?>
      </div>
    </div>
</div>
        <script>
        $('.open-lightbox')
            .each(function(){
                    var imgsrc = $(this).parent().find('img')[0];
                    $(this).on('click', function(){
                        lightbox.open(imgsrc);
                    })
                });
        </script>
