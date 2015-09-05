<?php

/**
 * index.php
 *
 * The last file that WordPress will use to display a page.
 */

get_header();

?>

  <main role="main" id="main">

    <h1><?php _e("Latest Posts", "soshal"); ?></h1>
    <?php get_template_part("loop"); ?>
    <?php get_template_part("pagination"); ?>

  </main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>