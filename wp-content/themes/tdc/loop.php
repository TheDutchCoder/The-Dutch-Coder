<?php

/**
 * loop.php
 *
 * The main loop for this theme.
 *
 * Generally used to display an article/post.
 *
 * @todo fine-tune the loop for use of single view items (e.g. an <article>)
 * element is redundant when only displaying an article in a <main> element.
 */

if (have_posts()) {

  while (have_posts()) {

    the_post();

    ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class("article"); ?>>

      <?php if (has_post_thumbnail()) { ?>
        <a class="thumb" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
          <?php the_post_thumbnail(array(120,120)); ?>
        </a>
      <?php } ?>

      <h2 class="article__heading"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

      <div class="article__meta">
        <time class="article__date" datetime="<?php the_time("Y-m-d"); ?> <?php the_time("H:i"); ?>"><?php the_date(); ?> <?php the_time(); ?></time>
        <p class="article__author"><?php _e("Published by", "soshal"); ?> <?php the_author_posts_link(); ?></p>
        <p class="article__comments"><?php if (comments_open(get_the_ID())) comments_popup_link(__("Leave your thoughts", "soshal"), __("1 Comment", "soshal"), __("% Comments", "soshal")); ?></p>
      </div>

      <p class="article__excerpt"><?php soshal_excerpt(); ?></p>

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