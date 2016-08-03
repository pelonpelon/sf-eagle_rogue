<?php
    date_default_timezone_set('America/Los_Angeles');
    $now = new DateTime();
    $now_std = $now->format('Y-m-d G:i');
    $today = $now->format('l');

      $args = array(
          'orderby'       => 'post_date',
          'order'         => 'ASC',
          'post_type'     => array('post'),
          'post_status'   => array('publish', 'future'),
          'posts_per_page'=> -1,
          'numberposts'   => 100
      );
      $Items = new WP_Query( $args );

?>

  <div id="home" class="page-content">

      <div class="pages">       <!--TODOd • add head and foot pages rarely used -->
            <?php echo $logo_modal_contents_filtered; ?>
      </div>
  <div class="scrollbox">
      <div class="scroller">

<?php
      $TopMessage = get_page_by_title_safely('Top Message');
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

<?php } ?>

        <div class="news">

<?php
      while ($Items->have_posts()): $Items->the_post();

      $ID = get_the_id();
      // get all metadata for this post
      $md = get_post_custom($ID);

      $expires_std = isset($md['event_expires'][0]) ? $md['event_expires'][0] : '3000-01-01 00:00';
      $expires_obj = new DateTime($expires_std);
      if ( ! in_category('news') || ($expires_std && $expires_obj->format('U') <= $now->format('U')) ) { continue; }

?>

            <div class="item open-lightbox">

<?php
      $attachment_url = wp_get_attachment_url( get_post_thumbnail_id( $ID ) );
      $news_content = do_shortcode(get_the_content());
      $attrs = array('class' => 'noclick', 'data-jslghtbx' => $attachment_url, 'data-jslghtbx-caption' => $news_content);
      //$postcard = do_shortcode(get_post_meta($ID, 'event_postcard', true));
      $postcard = do_shortcode( isset($md['event_postcard'][0]) ? $md['event_postcard'][0] : '' );
      if ( has_post_thumbnail() ) {
          $post_thumbnail_img = get_the_post_thumbnail(null, 'thumbnail', $attrs);
      } else {
          $thumbnail_ID = get_image_ID_by_slug('1pixel');
          set_post_thumbnail( $post, $thumbnail_ID );
          $post_thumbnail_img = get_the_post_thumbnail(null, 'thumbnail', $attrs);
      }
?>

                <div class="content">
                  <!--  <div class="expires"><php echo $expires_std; ?></div> --> <!--//FIXX add news expire date in camo ??? -->
                    <div class="thumbnail"><?php echo $post_thumbnail_img ?></div>
                      <div class='postcard'><?php echo $postcard; ?></div>
                    </div>
                </div>
                <hr>

<?php
      endwhile;
      wp_reset_postdata();
      $current_day = '';

      $tags = get_tags(array('get' => 'all'));
      $taglist = ' ';
      $tagcloud = ' ';
      if ($tags) {
          foreach ($tags as $tag) {
              $taglist .= '<span> ' . $tag->slug . ' </span>';
              $tagcloud .= '<a class="tag-button" href="#filtered_list" onclick="allItems(\'hide\'); $(\'.tag-'
                  . $tag->slug . '\').show(\'slow\', \'linear\').prev(\'.new-day\').show(\'slow\', \'linear\');">'
                  . $tag->name . '</a> ';
          }
      }
?>

            </div>  <!--news-->

            <script>
              function allItems(visibility) {
                if (visibility == 'hide') {
                    $('.item').hide('slow', 'linear'); $('.new-day').hide('slow', 'linear');
                }
                if (visibility == 'show') {
                    $('.item').show('slow', 'linear'); $('.new-day').show('slow', 'linear');
                }
              }
            </script>

            <a href="#tagcloud" class="tagcloud-button" onclick="$('.tagcloud').slideToggle();" >Filter:  <br /><?php echo $taglist; ?></a>
<a name="tagcloud"></a>
            <div class="tagcloud" style="display:none;"><?php echo $tagcloud; ?>
<a name="filtered_list"></a>
                <a class="show-everything tag-button" onclick="$('.tagcloud').slideToggle(); allItems('show');">everything</a>
            </div>
<a name="events_top"></a>
            <div class="event">
<?php
      //$event_count=0;
      while ($Items->have_posts()): $Items->the_post();
          if ( ! in_category('event')) { continue; }
      //$event_count+=1;
      //echo $event_count.' '.get_the_title();
          $ID = $Items->post->ID;
          // get all metadata for this post
          $md = get_post_custom($ID);

          $date = new DateTime(get_the_date('r'));
          $post_day = $date->format('l');
          $post_date = $date->format('M d');
          $post_start_time = $date->format('G:i');
          //$endtime = get_post_meta($ID, 'event_endtime', true);
          $endtime = $md['event_endtime'][0];
          $event_end_time = new DateTime(get_the_date('r'));
          date_modify($event_end_time, $endtime);
          $countdown = round(($event_end_time->format('U') - $now->format('U'))/3600);
          if ($event_end_time < $date) {
              date_modify($event_end_time, '+1 day');
          }
          if ($event_end_time < $now) {
              //$weekly = get_post_meta($ID, 'event_weekly', true); //FIXX ••• does this work
              //$monthly = get_post_meta($ID, 'event_monthy_days', true);
              $weekly = isset($md['event_weekly']);
              $monthly = isset($md['event_monthy_ordinals']);
              //throw new Exception("weekly: ". ($weekly ? 'true' : 'false') ." monthly: ". ($monthly ? 'true' : 'false') );
              if (!$weekly && !$monthly) {
                  $post_data = array('ID' => $ID, 'post_status' => 'pending');
                  wp_update_post($post_data);

                  $file = APP_PATH.'logs/transients.log';
                  $entry = date('ymd G:i:s'). " :home.php " .get_the_title(). " new status: pending\n\n";
                  file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);

                  continue;
              }
              continue;
          }
          if ( $date->format('Y-m-d') != $current_day ) {
              $current_day = $date->format('Y-m-d');
              $new_day = true;
          } else {
              $new_day = false;
          }

          $generic_poster_id = isset($md['event_generic_poster'][0]) ? $md['event_generic_poster'][0] : false;
          $generic_poster_url = $generic_poster_id ? wp_get_attachment_url( $generic_poster_id ) : false;
          $event_content = do_shortcode(get_the_content());

          if ( has_post_thumbnail() ) {
              $attachment_url = wp_get_attachment_url( get_post_thumbnail_id( $ID ) );
              if ($generic_poster_url && $attachment_url == $spacer_url) {
                  $attachment_url = $generic_poster_url;
                  set_post_thumbnail( $post, $generic_poster_id );
              }
          } else {
              if ($generic_poster_url) {
                  $attachment_url = $generic_poster_url;
                  set_post_thumbnail( $post, $generic_poster_id );
              }else{
                  $thumbnail_ID = get_image_ID_by_slug('1pixel');
                  set_post_thumbnail( $post, $thumbnail_ID );
                  $attachment_url = wp_get_attachment_url( get_post_thumbnail_id( $ID ) );
              }
          }

          $attrs = array('class' => 'noclick', 'data-jslghtbx' => $attachment_url, 'data-jslghtbx-caption' => $event_content);
          $post_thumbnail_img = get_the_post_thumbnail(null, 'thumbnail', $attrs);
          //$drink_special = get_post_meta($ID, 'event_drink_special', true);
          $drink_special = isset($md['event_drink_special'][0]) ? $md['event_drink_special'][0] : '';
          $cover = isset($md['event_cover'][0]) ? $md['event_cover'][0] : '';

          $postcard = do_shortcode(isset($md['event_postcard'][0]) ? $md['event_postcard'][0] : '');
          $tags = get_the_tags($ID);
          $taglist = ' ';
          if ($tags) {
              foreach ($tags as $tag) {
                  $taglist .= 'tag-' . $tag->name . ' ';
              }
          }

          if ($new_day) {

  ?>

          <div class="new-day">
            <div class="date-box">
                <span class="day"><?php echo $post_day; ?></span>
                <span class="date"><?php echo $post_date; ?></span>
            </div>
            <span class="drink-special"><?php echo $drink_special; ?></span>
          </div>

  <?php } ?>

          <div class="item  open-lightbox <?php echo $post_day . $taglist; ?> ">
              <div class="thumbnail"><?php echo $post_thumbnail_img; ?></div>
              <div class="content"><?php echo $postcard; ?>
              <div class="info">
                  <!-- <div class="cover"><php echo get_post_meta($ID, 'event_cover', true); ?></div> -->
                  <div class="cover"><?php echo $cover; ?></div>
                  <div class="start-time">
        <?php

            if ( $now->format('Y-m-d') == $current_day ) {
              for ($x = 0; $x < $countdown; $x++) { echo '. '; }
            }
            echo $date->format('g:i a');
        ?>
                </div>
              </div>
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
