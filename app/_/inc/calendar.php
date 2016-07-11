
$Title = $_GET('title');
$title = lcfirst($title);
<div id=$title class="page-content">

<?php
    $page = get_page_by_title($Title);
    //var_dump($page);
    ?> <div class=$title><?php echo $page->post_content; ?></div>  <?php
?>

</div>
