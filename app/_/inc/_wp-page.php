<?php
global $included_page_title;
$Title = $included_page_title;
$title = strtolower($Title);
?>
<div id="<?php echo $title; ?>" class="wp-page page-content">

<?php
    $page = get_page_by_title_safely($Title);
    echo do_shortcode($page->post_content);
?>

</div>
