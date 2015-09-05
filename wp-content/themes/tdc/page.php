<?php

/**
 * page.php
 *
 * The default page template, used for static pages.
 */

get_header();

?>

  <main role="main" id="main">

    <h1><?php the_title(); ?></h1>

    <?php

    if (have_posts()) {

      while (have_posts()) {

        the_post();

        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class("article"); ?>>
          <h2 class="article__heading"><?php the_title(); ?></h2>
          <div class="article__body"><?php the_content(); ?></div>
          <div class="article__comments"><?php comments_template("", true); ?></div>
          <?php edit_post_link(); ?>
        </article>

        <?php

      }

    } else {

      ?>
      <article class="article">
        <h2 class="article__heading"><?php _e("Sorry, nothing to display.", "soshal"); ?></h2>
      </article>
      <?php

    }

    ?>

  </main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>