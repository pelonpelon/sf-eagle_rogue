<?php
global $included_page_title;
$Title = $included_page_title;
$title = strtolower($Title);
?>
<div id="<?php echo $title; ?>" class="wp-page page-content">

<?php
$args = array(
    'order'         => 'DEC',
    'post_type'     => 'post',
    'post_status' => 'publish',
    'numberposts'   => -1
);
    $page = get_page_by_title_safely($Title);
    echo do_shortcode($page->post_content);
?>

</div>
