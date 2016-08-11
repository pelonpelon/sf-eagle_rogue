<?php


function shortcode_social_buttons( $args ){

    $ID = get_the_ID();
    $md = get_post_custom($ID);
    $clean_title = strtoupper(
        strip_tags(
            str_replace(
                "&nbsp;", " ", str_replace(
                    "<", " <", get_the_title( $ID )
                )
            ), "&"
        )
    );
    $image_full = wp_get_attachment_image_src( get_post_thumbnail_id($ID), 'full');
    $starttime = new DateTime($md['event_starttime'][0]);
    $start = $starttime->format('D M-d');
    $fb_event_link = isset($md['event_url'][0]) ? $md['event_url'][0] : '';
    if (isset($md['event_band_names'])) {
        $band_array = maybe_unserialize($md['event_band_names'][0]);
        $bands = implode('–', $band_array);
        //$band_names = shortcode_get_field_array('event_', array('id' => 'band_names'));
        //$band_names = shortcode_get_field_array('event_', array('id' => 'band_names'));
        //print_r($band_names->items);
        //$bands = array_pop($band_names->items);
    }else{
        $bands = '';
    }

    $markup = '';
    $markup .= '<div class=social-buttons>SHARE';

    if ( $fb_event_link ) {
        $markup .= '<div class="facebook-button">';
        $markup .= '<div class="fb-share-button" data-href="';
        $markup .= $fb_event_link[0] . '"';
        $markup .= 'data-layout="button">';
        $markup .= '</div></div>';
    }

    $markup .= '<div class="tumblr-button">';
    $markup .= '<a class="tumblr-share-button"';
    $markup .= ' data-color="blue"';
    $markup .= ' data-notes="none"';
    $markup .= ' data-posttype="photo"';
    $markup .= ' data-tags="sfeagle website"';
    $markup .= ' data-content="' . $image_full[0] . '"';
    $markup .= ' data-caption="SF-Eagle • ';
    $markup .= $clean_title . ' • ';
    $markup .= $start . ' ';
    $markup .= $fb_event_link;
    $markup .= '"';
    $markup .= ' href="https://embed.tumblr.com/share">';
    $markup .= 'Tumblr</a>';
    $markup .= '</div>';

    $markup .= '<div class="twitter-button">';
    $markup .= '<a class="twitter-share-button"';
    $markup .= (' href="https://twitter.com/intent/tweet?via=sfeaglebar&text=SF-Eagle • ');
    $markup .= ($start . ' ' . $bands);
    $markup .= '&url=https%3A%2F%2Fsf-eagle.com"';
    $markup .= ' data-count="none">Twitter</a>';
    $markup .= '</div>';

    $markup .= '</div>';

    return $markup;
}
add_shortcode( 'social_buttons', 'shortcode_social_buttons' );
