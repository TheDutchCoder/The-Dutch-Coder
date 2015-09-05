<?php

/**
 * comments.php
 *
 * Handles the display of comments for posts and pages.
 *
 * Checks for user credentials, as well as making sure the user is allowed to
 * comment on the post or page.
 */

?>
<div class="comments">

  <?php if (post_password_required()) { ?>
  <p><?php _e("Post is password protected. Enter the password to view any comments.", "soshal"); ?></p>
  <?php } else {

    if (have_comments()) {

    ?>
    <h2><?php comments_number(); ?></h2>
    <ul>
      <?php wp_list_comments("type=comment&callback=soshal_comments"); // Custom callback in functions.php ?>
    </ul>

    <?php

    } elseif (!comments_open() && !is_page() && post_type_supports(get_post_type(), "comments")) {

    ?>
    <p><?php _e("Comments are closed here.", "soshal"); ?></p>
    <?php

    }

  comment_form();

  }

  ?>

</div>