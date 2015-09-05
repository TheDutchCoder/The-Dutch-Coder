<?php
/**
 * posts.php
 *
 * A collection of functions related to (displaying) posts.
 */





/* --------------------------------- *
 * CONTENTS                          *
 * --------------------------------- */
/**
 * soshal_excerpt............Custom excerpt function.
 * soshal_tags...............Custom tags walker.
 * soshal_categories.........Custom comment threading function.
 * soshal_pagination.........Custom pagination.
 * soshal_comments...........Custom comment threading.
 *
 * has_tags..................Check to see if the current post has tags.
 * has_categories............Check to see if the current post has categories.
 */





/**
 * Custom excerpt function.
 *
 * @param  int    $max_words Maximum amount of words to return.
 * @param  int    $max_chars Maximum amount of charcters to return.
 * @param  string $more      String to attach at the end.
 *
 * @todo: create functionality for 'more'.
 */
function soshal_excerpt($max_words = 30, $max_chars = 350, $more = "") {

  global $post;

  // Retrieve the regular excerpt and create an array out of all the words, so
  // we can easily do some calculations on it.
  $output = get_the_excerpt();
  $output_array = explode(" ", $output);
  $words = count($output_array);
  $chars = strlen($output);

  // Only modify the excerpt if it's longer (in either words or characters) than
  // requested.
  if ($words > $max_words || $chars > $max_chars) {

    // First limit the amount of words.
    $output_array = array_slice($output_array, 0, $max_words);
    $output = implode(" ", $output_array);

    // Then limit characters (if still needed).
    if (strlen($output) > $max_chars) {

      $output = trim(substr($output, 0, $max_chars));

    }

    // Append the 'more' suffix.
    $output .= "...";
    $output = preg_replace("/[\.]{4,}$/", "...", $output);

  }

  echo $output;

}



/**
 * Custom tags walker.
 *
 * Creates a BEM style list of tags.
 */
function soshal_tags() {

    global $post;

    $tags = wp_get_post_tags($post->ID);

    // Only output a result if there are tags to display.
    if ($tags) {

        $output = "<ul class=\"nav nav--inline nav--tags\">";

        foreach ($tags as $tag) {

            $tag_name = $tag->name;
            $tag_url = get_tag_link($tag->term_id);

            $output .= "<li class=\"nav__item\">";
            $output .= "<a href=\"" . $tag_url . "\" class=\"nav__link\">" . $tag_name . "</a>";
            $output .= "</li>";

        }

        $output .= "</ul>";

        echo $output;

    }

}



/**
 * Custom categories walker.
 *
 * Creates a BEM style list of categories.
 */
function soshal_categories() {

    global $post;

    $categories = get_the_category($post->ID);

    // Only output a result if there are categories to display.
    if ($categories) {

        $output = "<ul class=\"nav nav--inline nav--categories\">";

        foreach ($categories as $cat) {

            $cat_name = $cat->name;
            $cat_url = get_category_link($cat->term_id);

            $output .= "<li class=\"nav__item\">";
            $output .= "<a href=\"" . $cat_url . "\" class=\"nav__link\">" . $cat_name . "</a>";
            $output .= "</li>";

        }

        $output .= "</ul>";

        echo $output;

    }

}



/**
 * Custom pagination.
 *
 * Custom pagination function.
 *
 * @param  int  $max        The maximum amount of items to show.
 * @param  int  $range      How many pages -/+ of the current page to show.
 * @param  bool $next_prev  Include next/prev arrows.
 * @param  bool $first_last Include first/last arrows.
 *
 * @todo: make this work for things besides just pages.
 */
function soshal_pagination($max = null, $range = 2, $next_prev = true, $first_last = true) {

  global $paged;

  $paged = empty($paged) ? 1 : $paged;
  $showitems = ($range * 2) + 1;

  if ($max === null) {

    global $wp_query;

    $max = $wp_query->max_num_pages;
    $max = $max ? $max : 1;

  }

  // Determine within which range to show the paginator.
  $from = (($paged - $range) < 1) ? 1 : ($paged - $range);
  $to = (($paged + $range) > $max) ? $max : ($paged + $range);

  // Only show the paginator if there's more than one page.
  if ($max !== 1) {

    echo "<ul class=\"nav nav--inline nav--pagination\">";

    // Show the 'go to first page' link.
    if (($paged > 2) && ($paged > $range + 1) && ($showitems < $max) && $first_last) {

      echo "<li class=\"nav__item\"><a href=\"" . get_pagenum_link(1) . "\" class=\"nav__link\">&laquo;</a></li>";

    }

    // Show the 'go to previous page' link.
    if (($paged > 1) && ($showitems < $max) && $next_prev) {

      echo "<li class=\"nav__item\"><a href=\"" . get_pagenum_link($paged - 1) . "\" class=\"nav__link\">&lsaquo;</a></li>";

    }

    // Loop through all the pages in range.
    for ($i = $from; $i <= $to; $i++) {

      echo "<li class=\"nav__item" . (($paged === $i) ? " nav__item--current" : "") . "\"><a href=\"" . get_pagenum_link($i) . "\" class=\"nav__link" . (($paged === $i) ? " nav__link--current" : "") . "\">" . $i . "</a></li>";

    }

    // Show the 'go to next page' link.
    if (($paged < $max) && ($showitems < $max) && $next_prev) {

       echo "<li class=\"nav__item\"><a href=\"" . get_pagenum_link($paged + 1) . "\" class=\"nav__link\">&rsaquo;</a></li>";

    }

    // Show the 'go to last page' link.
    if (($paged < ($max - 1)) && (($paged + $range - 1) < $max) && ($showitems < $max) && $first_last) {

      echo "<li class=\"nav__item\"><a href=\"" . get_pagenum_link($max) . "\" class=\"nav__link\">&raquo;</a></li>";

    }

    echo "</ul>";

  }

}



/**
 * Checks if the post has any tags or not.
 *
 * @return bool True when there are tags related to this post.
 */
function has_tags() {

    global $post;

    return count(wp_get_post_tags($post->ID));

}



/**
 * Checks if the post has any categories or not.
 *
 * @return bool True when there are categories related to this post.
 */
function has_categories() {

    global $post;

    return count(get_the_category($post->ID));

}



/**
 * Custom comment threading.
 *
 * @param  string $comment [description]
 * @param  array  $args    [description]
 * @param  int    $depth   [description]
 *
 * @todo everything
 */
function soshal_comments($comment, $args, $depth) {
    $GLOBALS["comment"] = $comment;
    extract($args, EXTR_SKIP);

    if ( "div" == $args["style"] ) {
        $tag = "div";
        $add_below = "comment";
    } else {
        $tag = "li";
        $add_below = "div-comment";
    }
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args["has_children"] ) ? "" : "parent") ?> id="comment-<?php comment_ID() ?>">
    <?php if ( "div" != $args["style"] ) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>
    <div class="comment-author vcard">
    <?php if ($args["avatar_size"] != 0) echo get_avatar( $comment, $args["avatar_size"] ); ?>
    <?php printf(__("<cite class=\"fn\">%s</cite> <span class=\"says\">says:</span>"), get_comment_author_link()) ?>
    </div>
<?php if ($comment->comment_approved == "0") : ?>
    <em class="comment-awaiting-moderation"><?php _e("Your comment is awaiting moderation.") ?></em>
    <br />
<?php endif; ?>

    <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
        <?php
            printf( __("%1$s at %2$s"), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__("(Edit)"),"  ","" );
        ?>
    </div>

    <?php comment_text() ?>

    <div class="reply">
    <?php comment_reply_link(array_merge( $args, array("add_below" => $add_below, "depth" => $depth, "max_depth" => $args["max_depth"]))) ?>
    </div>
    <?php if ( "div" != $args["style"] ) : ?>
    </div>
    <?php endif; ?>
<?php } ?>