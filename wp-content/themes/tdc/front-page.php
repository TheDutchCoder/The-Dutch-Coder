<?php

/**
 * front-page.php
 *
 * The default front page template for this theme.
 *
 * When the frontpage is allowed to be used on other parts of the website, it's
 * better to create a custom template for it instead.
 */

get_header();

?>

  <main role="main" id="main">

    <h1><?php the_title(); ?></h1>

  </main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>