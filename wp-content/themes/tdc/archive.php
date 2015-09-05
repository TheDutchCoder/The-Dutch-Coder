<?php

/**
 * archive.php
 *
 * Displays a paginated archive of posts.
 */

get_header();

?>

  <main role="main" id="main">

    <h1><?php _e("Archives", "soshal"); ?></h1>
    <?php get_template_part("loop"); ?>
    <?php get_template_part("pagination"); ?>

  </main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>