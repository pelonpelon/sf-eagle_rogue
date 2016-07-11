<?php
global $included_page_title;
$Title = $included_page_title;
$title = strtolower($Title);
?>
<div id=$title class="page-content">

<?php
    $page = get_page_by_title($Title);
    //var_dump($page);
    echo do_shortcode($page->post_content);
?>

</div>
