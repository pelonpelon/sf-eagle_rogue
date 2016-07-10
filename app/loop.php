<?php
  // Include WordPress
  define('WP_USE_THEMES', false);
  require('../../wp/wp-blog-header.php');
  query_posts('showposts=10');
?>
<html><head><title><title></title>
<head>
  <body>
<?php while (have_posts()): the_post(); ?>
   <h2><?php the_title(); ?></h2>
   <?php the_excerpt(); ?>
   <p><a href="<?php the_permalink(); ?>" class="red">Read more...</a></p>
<?php endwhile; ?>

</body>
</head></html>
