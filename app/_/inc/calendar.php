<div id="Calendar" class="page-content">

<?php
    $page = get_page_by_title('Calendar');
    //var_dump($page);
    ?> <div class="calendar"><?php echo $page->post_content; ?></div>  <?php
?>

</div>
