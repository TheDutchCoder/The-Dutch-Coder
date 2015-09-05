<?php

/**
 * tag.php
 *
 * Displays a paginated list of posts with a tag.
 */

get_header();

?>

  <main role="main" id="main">

    <h1><?php echo __("Tag Archive: ", "soshal") . single_tag_title("", false); ?></h1>
    <?php get_template_part("loop"); ?>
    <?php get_template_part("pagination"); ?>

  </main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>