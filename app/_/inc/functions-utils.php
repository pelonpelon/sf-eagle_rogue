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

// send post content through shortcode filter
function get_page_by_title_filtered( $title ){
    $page = get_page_by_title($title);
    return do_shortcode($page->post_content);
}
