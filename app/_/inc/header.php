<div id="fb-root"></div>

<header class="site-header">
<!--   <div id="hamburger"" class="hamburger" onclick="event.preventDefault(); jpm.trigger(true); "></div> -->
    <h1 class="site-title">SF-EAGLE</h1> <!-- FIXX ••• should be st-title -->
    <p class="site-subtitle">398 12th St</p> <!-- FIXX •••  st-subtitle -->

<?php
    $Logo = get_page_by_title_safely('Logo');
    //$logo get_page_by_title('Logos') ? get_page_by_title : 'no';
    //if ($Logo = get_page_by_title('Logo')) {
        $logo_modal_contents = get_post_meta($Logo->ID, 'event_modal', true);
        if (strlen($logo_modal_contents) > 1) { $lb = 'open-lightbox'; } else { $lb = ''; }
        $logo_modal_contents_filtered = do_shortcode($logo_modal_contents);
?>

    <div class="logo <?php echo $lb ?>">
        <?php echo $Logo->post_content; ?>
        <div class="hide-this"><?php echo $logo_modal_contents_filtered ?></div>
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
        $PSA = get_page_by_title('PSA');        //FIXX • should be post for email
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
          <li class="hamburger" onclick="event.preventDefault(); jpm.trigger(true);"></li>
          <li class="home" onclick="jpm.trigger(true);"><a href="index.php">HOME</a></li>
          <li class="staff" onclick="jpm.trigger(true);"><a href="staff.php">STAFF</a></li>

<?php foreach ($pages as $page) {
        $title_raw = $page->post_title;
        $title = strtolower($page->post_title);
        $file = $title . '.php';
        echo '<li class="' .$title. '" onclick="jpm.trigger(true);"><a href="' . $file . '">' . strtoupper($title) . '</a></li>';
} ?>

          <li class="social facebook" onclick="jpm.trigger(true);"><a href="https://www.facebook.com/SFEagle" target="_blank"><img src="_/img/facebook-60x60.png" /></a></li>
          <li class="social instagram" onclick="jpm.trigger(true);"><a href="https://www.instagram.com/sfeagle/" target="_blank"><img src="_/img/instagram-60x60.png" /></a></li>
          <li class="social tumblr" onclick="jpm.trigger(true);"><a href="http://sfeaglebar.tumblr.com/" target="_blank"><img src="_/img/tumblr-60x60.png" /></a></li>
          <li class="social twitter" onclick="jpm.trigger(true);"><a href="https://twitter.com/sfeaglebar" target="_blank"><img src="_/img/twitter-60x60.png" /></a></li>
          <li class="social googleplus" onclick="jpm.trigger(true);"><a href="https://plus.google.com/104184281608152528049/posts" target="_blank"><img src="_/img/googleplus-60x60.png" /></a></li>
          <li class="social email" onclick="jpm.trigger(true);"><a href="mailto:info@sf-eagle.com?subject=Sent%20via%20website" target="_blank"><img src="_/img/mail-60x60.png" /></a></li>

        </ul>
    </nav>
