<?php

/**
 * category.php
 *
 * Displays a paginated list of posts within a category.
 */

get_header();

?>

  <main role="main" id="main">

    <h1><?php echo __("Categories for ", "soshal") . single_cat_title(); ?></h1>
    <?php get_template_part("loop"); ?>
    <?php get_template_part("pagination"); ?>

  </main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>