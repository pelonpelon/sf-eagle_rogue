<div id="home" class="page-content">
  <?php
      //$Drinks = get_page_by_title('Drink Specials');
      //$Contact_content = get_page_by_title_filtered('Contact Us');
      $Front_content = get_page_by_title_filtered('Front');
      // var_dump($Drinks);
  ?>
      <div class="pages">       <!--TODO ••• add head and foot pages rarely used -->
        <div class="page front">
            <div class="content"><?php echo $Front_content; ?></div>
        </div>
      </div>
  <div class="scrollbox">
  <div class="scroller">
  <?php

try {
      $TopMessage = get_page_by_title('Top Message');       //FIXX ••• should be a post for email
      if (strlen($TopMessage->post_content) > 1) {
          $event_modal = get_post_meta($TopMessage->ID, 'event_modal', true);
          $event_modal_filtered = do_shortcode($event_modal);
          if (strlen($event_modal) > 1) { $lb='open-lightbox'; }else{ $lb=''; }
?>
      <div class="page top-message <?php echo $lb; ?>">
          <img class="noclick" width="1" height="1" src=<?php echo $spacer_url; ?>
              data-jslghtbx=<?php echo $spacer_url; ?> data-jslghtbx-caption="<?php echo $event_modal_filtered; ?>" />
          <div class="content"><?php echo $TopMessage->post_content; ?></div>
      </div>
<?php
      }
} catch (Exception $e) { ;; }

      $args = array(
          'orderby'       => 'post_date',
          'order'         => 'ASC',
          'post_type'     => array('post', 'page'),
          'post_status'   => array('publish', 'future'),
          'numberposts'   => -1
      );
      $Items = new WP_Query( $args );
pretty($Items->post_count);
      ?>  <div class="news-box">  <?php

      while ($Items->have_posts()): $Items->the_post();
      $ID = $Items->post->ID;

      if ( ! in_category('news')) { continue; }     //FIXX ••• news needs a more button after 2 items
  ?>
              <div class="post news-item open-lightbox">
  <?php
      $attachment_url = wp_get_attachment_url( get_post_thumbnail_id( $ID ) );
      $news_content = get_the_content();
      $attrs = array('class' => 'noclick', 'data-jslghtbx' => $attachment_url, 'data-jslghtbx-caption' => $news_content);
      $postcard = do_shortcode(get_post_meta($ID, 'event_postcard', true));
      if ( has_post_thumbnail() ) {
          $post_thumbnail_img = get_the_post_thumbnail(null, 'thumbnail', $attrs);
      } else {
          $thumbnail_ID = get_attachment_ID_by_slug('1pixel');
          set_post_thumbnail( $post, $thumbnail_ID );
          $post_thumbnail_img = get_the_post_thumbnail(null, 'thumbnail', $attrs);
      }
  ?>
                <div class="news-content">
                <div class="post-thumbnail"><?php echo $post_thumbnail_img ?></div>
                  <div class='news-content'><?php echo $postcard; ?></div>
                </div>
              </div>
              <hr>
  <?php
      endwhile;

  //global $wp_query;
  //var_dump($wp_query->query_vars);

      wp_reset_postdata();

      $current_day = '';
  ?>
      </div>
      <div class="event-box">
  <?php

      while ($Items->have_posts()): $Items->the_post();
          if ( ! in_category('event')) { continue; }
          $ID = $Items->post->ID;

          //$now = new DateTime();
          //$today = $now->format('ymd');
          //$post_date = get_the_date('ymd');
          //$this_year = $now->format('y');
          //$post_year = get_the_date('y');
          //$cuttoff = new DateTime();
          //date_modify($cuttoff, '-6 months');
          //$status = get_post_status();

          $date = new DateTime(get_the_date('r'), new DateTimeZone('America/Los_Angeles'));
          //if ( ($status == 'publish') && ($date < $cuttoff) ) {
              //date_modify($date, '+1 year');
          //}

          if ( $date->format('l') != $current_day ) {
              $current_day = $date->format('l');
              $new_day = true;
          } else {
              $new_day = false;
          }
          $post_day = $date->format('l');
          $post_date = $date->format('M d');
          $attachment_url = wp_get_attachment_url( get_post_thumbnail_id( $ID ) );
          $event_content = do_shortcode(get_the_content());
          $attrs = array('class' => 'noclick', 'data-jslghtbx' => $attachment_url, 'data-jslghtbx-caption' => $event_content);
          $postcard = do_shortcode(get_post_meta($ID, 'event_postcard', true));

          $end_time = '2000-01-01';
          $end_time = get_post_meta($ID, 'event_endtime', true);
          $end_obj = new DateTime($end_time);
          $end_hour = $end_obj->format('gi');
          //wp_update_post(array('ID' => $ID, 'post_status' => 'publish'));

          if ( has_post_thumbnail() ) {
              $post_thumbnail_img = get_the_post_thumbnail(null, 'thumbnail', $attrs);
          } else {
              $thumbnail_ID = get_attachment_ID_by_slug('1pixel');
              set_post_thumbnail( $post, $thumbnail_ID );
              $post_thumbnail_img = get_the_post_thumbnail(null, 'thumbnail', $attrs);
          }
          if ($new_day) {

  ?>

          <div class="new-day">
            <span class="post-day"><?php echo $current_day; ?></span>
            <span class="post-date"><?php echo $post_date; ?></span>
          </div>

  <?php } ?>

          <div class="post event-item  open-lightbox <?php echo $current_day; ?>">
              <div class="post-thumbnail"><?php echo get_the_post_thumbnail(null, 'thumbnail', $attrs) ?></div>
              <div class="event-info-box">
                  <div class="event-content"><?php echo $postcard; ?></div>
                  <div class="event-start-time"><?php echo $date->format('g:ia'); ?></div>
              </div>
          </div>
  <?php
      endwhile;
      wp_reset_postdata();
  ?>
      </div>
  </div>
  </div>
</div>
<script>
$('.open-lightbox')
    .each(function(){
        var imgsrc = $(this).find('img')[0];
        $(this).on('click', function(){
            lightbox.open(imgsrc);
        })
    });
</script>
