<?php

/**
 * 404.php
 *
 * The typical "page not found" page.
 * Displays an error whenever a resource is requested but not found.
 */

get_header();

?>

  <main role="main" id="main">

    <h1><?php _e("Page or file not found.", "soshal"); ?></h1>
    <p><?php _e("We couldn't find what you were looking for.", "soshal") ?> <a href="<?php echo home_url(); ?>"><?php _e("Return to the homepage.",  "soshal"); ?></a></p>

  </main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>