<div id="fb-root"></div>

<header class="st-header">
<!--   <div id="hamburger"" class="hamburger" onclick="event.preventDefault(); jpm.trigger(true); "></div> -->
    <h1 class="page-title">SF-EAGLE</h1> <!-- FIXX ••• should be st-title -->
    <p class="page-subtitle">398 12th St</p> <!-- FIXX •••  st-subtitle -->

<?php
    $Logo = get_page_by_title_safely('Logo');
    //$logo get_page_by_title('Logos') ? get_page_by_title : 'no';
    //if ($Logo = get_page_by_title('Logo')) {
        $modal_contents = get_post_meta($Logo->ID, 'event_modal', true);
        if (strlen($modal_contents) > 1) { $lb = 'open-lightbox'; } else { $lb = ''; }
        $modal_contents_filtered = do_shortcode($modal_contents);
?>

    <div class="page logo <?php echo $lb ?>">
        <?php echo $Logo->post_content; ?>
        <div class="hide-this"><?php echo $modal_contents_filtered ?></div>
     </div>

<script>
    /* necessary to get logo modal to work properly */
    modal_contents = $('.logo .hide-this').html();
    $('.logo.open-lightbox img').addClass('noclick');
    $('.logo.open-lightbox img').attr('data-jslghtbx', '<?php echo $spacer_url; ?>');
    $('.logo.open-lightbox img').attr('data-jslghtbx-caption', modal_contents);
</script>

<?php
        // Bright Pink Emergency Notice fixed to top of page
        // can't use get_page_by_title_safely
        $PSA = get_page_by_title('PSA');        //FIXX ••• should be post for email
        if (strlen($PSA->post_content) > 1) {
?>

        <div class="header-psa"><?php echo $PSA->post_content; ?></div>

<?php } ?>
         <div id="panel">
         <a class="menu-trigger hamburger" href="#menu"></a>
         </div>
</header>

<?php
  $Pages = get_page_by_title_safely('Pages');
  $args = array(
    'sort_order' => 'asc',
    'sort_column' => 'menu_order',
    'hierarchical' => 1,
    'exclude' => '',
    'include' => '',
    'meta_key' => '',
    'meta_value' => '',
    'authors' => '',
    'child_of' => $Pages->ID,
    'parent' => -1,
    'exclude_tree' => '',
    'number' => '',
    'offset' => 0,
    'post_type' => 'page',
    'post_status' => 'publish'
  );
  $pages = get_pages($args);
?>
    <nav id="menu">
        <ul>
          <li id="menu-header" class="hamburger" onclick="event.preventDefault(); jpm.trigger(true);"></li>
          <li id="menu-home" class="Home" onclick="jpm.trigger(true);"><a href="index.php">HOME</a></li>
          <li id="menu-staff" class="Staff" onclick="jpm.trigger(true);"><a href="staff.php">STAFF</a></li>

<?php foreach ($pages as $page) {
        $title_raw = $page->post_title;
        $title = strtolower($page->post_title);
        $file = $title . '.php';
        echo '<li id="menu-' . $title . '" class="menu-item" onclick="jpm.trigger(true);"><a href="' . $file . '">' . strtoupper($title) . '</a></li>';
} ?>

        </ul>
    </nav>
