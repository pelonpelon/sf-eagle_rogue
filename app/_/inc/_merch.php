<?php
$page_name = 'merch';
$Page_name = 'Merch';       //FIXX ••• use str_replace or better to capitalize
?>

<div id=<?php echo $Page_name; ?> class="page-content">

<?php
    $page = get_page_by_title($Page_name);
?>
    <div class="wp-page <?php echo $page_name; ?>"><?php echo $page->post_content; ?></div>';

</div>

