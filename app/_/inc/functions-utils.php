<?php

// replace spaces with &nbsp;
function nbsp ($string) {
    return str_replace(" ", "&nbsp;", $string);
}
// replace <br /> with ' '
function br2sp ($string) {
  $tmp = str_replace("<br>", " ", $string);
  return str_replace("<br />", " ", $tmp);
}

// var_dump but pretty
function pretty( $var ){
    echo str_replace(',', ',<br>', var_export($var));
}

// Show error page if page not in db and published
function get_page_by_title_safely( $title, $alt_title = 'Error' ) {
    if (($page = get_page_by_title($title)) && ($page->post_status == 'publish')) {
        return $page;
    }elseif(($page = get_page_by_title($alt_title)) && ($page->post_status == 'publish')) {
        if ($alt_title == 'Error') { $page->post_content .= '<p>>>> ' . $title . ' ???</p>'; }
        return $page;
        // we don't care if Error is a published page
    }elseif($page = get_page_by_title('Error')) {
        $page->post_content .= '<p>>>> ' . $title . ' ???</p>';
        return $page;
    }else{
        throw new Exception('Sorry, I can\'t find that. Is the Error page missing?');
    }
}

// send post content through shortcode filter
function get_page_by_title_filtered( $title ){
    $page = get_page_by_title_safely($title);
    return do_shortcode($page->post_content);
}
