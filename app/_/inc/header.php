<header class="st-header">

        <h1 class="page-title">SF-EAGLE</h1> <!-- FIXX should be st-title -->
        <p class="page-subtitle">398 12th St</p> <!-- FIXX: st-subtitle -->
<?php
try {
    $Logo = get_page_by_title('Logo');
    $modal_contents = get_post_meta($Logo->ID, 'event_modal', true);
    if (strlen($modal_contents) > 1) { $lb = 'open-lightbox'; } else { $lb = ''; }
    $modal_contents_filtered = do_shortcode($modal_contents);
?>
    <div class="page logo <?php echo $lb ?>">
        <?php echo $Logo->post_content; ?>
        <div class="hide-this"><?php echo $modal_contents_filtered ?></div>
      </div>
<?php

} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
//var_dump($Logo_page);
        $PSA = get_page_by_title('PSA');
        if (strlen($PSA->post_content) > 1) {
?>
        <div class="header-psa"><?php echo $PSA->post_content; ?></div>
<?php } ?>

  <div id="menu"></div>
  <div class="menu-trigger">
    <div class="header">
        <div class="hamburger"></div>
    </div>
  </div>
  <table id="menu-panel">
    <tr>
      <td id="menu-item1" class="menu-item"><a href="index.php">HOME</a></td>
    </tr>
    <tr>
      <td id="menu-item2" class="menu-item"><a href="staff.php">STAFF</a></td>
    </tr>
    <tr>
      <td id="menu-item3" class="menu-item"><a href="merch.php">MERCHANDISE</a></td>
    </tr>
    <tr>
      <td id="menu-item4" class="menu-item"><a href="contact.php">CONNECT</a></td>
    </tr>
    <tr>
      <td id="menu-item5" class="menu-item"><a href="calendar.php">CALENDAR</a></td>
    </tr>
    <tr>
      <td id="menu-item6" class="menu-item"><a href="dore.php">DORE</a></td>
    </tr>
  </table>

</header>
