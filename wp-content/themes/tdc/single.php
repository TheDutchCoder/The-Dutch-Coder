<?php

/**
 * single.php
 *
 * Default page for the single view of posts/pages.
 */

get_header();

?>

  <main role="main" id="main">

    <h1><?php _e("Recent Posts", "soshal"); ?></h1>

    <?php

    if (have_posts()) {

      while (have_posts()) {

        the_post();

        ?>
        <article id="post-<?php the_ID(); ?>" class="article">
          <h2 class="article__heading"><?php the_title(); ?></h2>

          <?php if (has_post_thumbnail()) { ?>
          <a href="<?php echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)) ?>" class="article__thumbnail">
            <?php the_post_thumbnail("medium"); ?>
          </a>
          <?php } ?>

          <div class="article__meta">
            <time class="article__date" datetime="<?php the_time("Y-m-d"); ?> <?php the_time("H:i"); ?>"><?php the_date(); ?> <?php the_time(); ?></time>
            <span class="article__author"><?php _e("Written by: ", "soshal"); ?> <?php the_author_posts_link(); ?></span>
          </div>

          <div class="article__body">
            <?php the_content(); ?>
          </div>

          <?php if (has_tags()) { ?>
          <div class="article__tags">
            <p><?php _e("Tags", "soshal"); ?></p>
            <?php soshal_tags(); ?>
          </div>
          <?php } ?>

          <?php if (has_categories()) { ?>
          <div class="article__categories">
            <p><?php _e("Categories", "soshal"); ?></p>
            <?php soshal_categories(); ?>
          </div>
          <?php } ?>

          <?php

          // Oh WordPress...
          //
          // have_comments() does not work unless you actually try and get the
          // comments first.
          //
          // We need to change this to include a template with
          // comments_template().

          ?>
          <?php if (have_comments()) { ?>
          <div class="article__comments">
            <p>Thread the comments here.</p>
          </div>
          <?php } ?>
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