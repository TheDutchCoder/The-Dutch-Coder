<?php

/**
 * author.php
 *
 * Displays a list of authors.
 *
 * @todo Markup.
 */

get_header();

?>

  <main role="main" id="main">

    <?php

    if (have_posts()) {

      the_post();

      ?>

      <h1><?php echo __("Author Archives for ", "soshal") . get_the_author(); ?></h1>

      <?php

      if (get_the_author_meta("description")) {

        echo get_avatar(get_the_author_meta("user_email"));

        ?>
        <h2><?php echo __("About ", "soshal") . get_the_author(); ?></h2>
        <?php echo wpautop(get_the_author_meta("description")); ?>

        <?php

      }

      rewind_posts();

      while (have_posts()) {

        the_post();

        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

          <?php if (has_post_thumbnail()) { ?>
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
              <?php the_post_thumbnail(array(120,120)); ?>
            </a>
          <?php } ?>

          <h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

          <span class="date">
            <time datetime="<?php the_time("Y-m-d"); ?> <?php the_time("H:i"); ?>">
              <?php the_date(); ?> <?php the_time(); ?>
            </time>
          </span>
          <span class="author"><?php _e("Published by", "soshal"); ?> <?php the_author_posts_link(); ?></span>
          <span class="comments"><?php comments_popup_link(__("Leave your thoughts", "soshal"), __("1 Comment", "soshal"), __("% Comments", "soshal")); ?></span>

          <?php

          html5wp_excerpt("html5wp_index");
          edit_post_link();

          ?>

        </article>

        <?php

      }

    } else {

      ?>

      <article>

        <h2><?php _e("Sorry, nothing to display.", "soshal"); ?></h2>

      </article>

      <?php

    }

    get_template_part("pagination");

    ?>

  </main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>