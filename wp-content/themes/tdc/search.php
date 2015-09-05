<?php

/**
 * search.php
 *
 * Displays search results.
 */

get_header();

?>

  <main role="main" id="main">

    <h1><?php echo sprintf(__("%s Search Results for ", "soshal"), $wp_query->found_posts) . get_search_query(); ?></h1>
    <?php get_template_part("loop"); ?>
    <?php get_template_part("pagination"); ?>

  </main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>