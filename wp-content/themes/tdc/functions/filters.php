<?php

/**
 * filters.php
 *
 * Sets up and removes filters for this theme.
 */





/* --------------------------------- *
 * CONTENTS                          *
 * --------------------------------- */
/**
 * $ADD......................Add filters
 * Custom gravatar...........Different default gravatar
 * Slug bodyclass............Adds slug to the 'body' classes
 * Remove rel................Removes invalid 'rel' attribute
 * Read article button.......Adds a 'Read artcle' button to excerpts
 * Remove type...............Removes 'type' attribute
 * Remove dimensions.........Strips dimensions off images
 * TinyMCE formats...........Adds custom formats to TinyMCE
 * Defer JavaScript..........Adds a way of deferring JavaScripts
 *
 * $REMOVE...................Remove filters
 * Remove empty tags.........Remove empty <p> tags and spacing around shortcodes
 */





/* --------------------------------- *
 * $ADD                              *
 * --------------------------------- */
add_filter("avatar_defaults",      "soshal_gravatar");
add_filter("body_class",           "soshal_slug_bodyclass");
add_filter("the_category",         "soshal_remove_rel");
add_filter("excerpt_more",         "soshal_read_article_button");
add_filter("style_loader_tag",     "soshal_remove_type");
add_filter("post_thumbnail_html",  "soshal_remove_dimensions", 10);
add_filter("post_thumbnail_html",  "soshal_remove_dimensions", 10);
add_filter("image_send_to_editor", "soshal_remove_dimensions", 10);
add_filter("mce_buttons_2",        "soshal_tinymce_buttons");
add_filter("the_content",          "soshal_remove_empty_tags");
add_filter("tiny_mce_plugins",     "soshal_disable_emojicons_tinymce");
add_filter("clean_url",            "soshal_defer_scripts", 11, 1);



/**
 * Custom gravatar.
 *
 * Displays a different default gravatar in discussions.
 *
 * @param  array $avatar_defaults Collection of avatar default settings.
 * @return array                  Modified avatar settings.
 */
function soshal_gravatar($avatar_defaults) {

  $avatar = $GLOBALS["template_uri"] . "/img/gravatar.jpg";
  $avatar_defaults[$avatar] = "Custom Gravatar";

  return $avatar_defaults;

}



/**
 * Slug bodyclass.
 *
 * Add the current slug to the 'body' classes.
 *
 * @param  array $classes Array of body classes.
 * @return array          Modified array of body classes.
 */
function soshal_slug_bodyclass($classes) {

  global $post;

  if (is_home()) {

    $key = array_search("blog", $classes);

    if ($key > -1) {
      unset($classes[$key]);
    }

  } elseif (is_page()) {

    $classes[] = sanitize_html_class($post->post_name);

  } elseif (is_singular()) {

    $classes[] = sanitize_html_class($post->post_name);

  }

  return $classes;

}



/**
 * Remove rel.
 *
 * Removes invalid 'rel' attribute.
 *
 * @param  string $html HTML as a atring.
 * @return string       String with the invalid 'category' value removed.
 */
function soshal_remove_rel($html) {

    return str_replace("rel=\"category tag\"", "rel=\"tag\"", $html);

}



/**
 * Read article button.
 *
 * Appends a 'Read article' button to excerpts.
 *
 * @param  string $html HTML as a string.
 * @return string       HTML string with a 'Read Article' button added.
 */
function soshal_read_article_button($html) {

    global $post;

    return "... <a class=\"btn btn--primary\" href=\"" . get_permalink($post->ID) . "\">" . __("Read Article", "soshal") . "</a>";

}



/**
 * Remove type.
 *
 * Removes 'type' attribute from enqueued stylesheets.
 *
 * @param  string $html HTML as a string.
 * @return string       String with the 'rel' attribute removed.
 */
function soshal_remove_type($html) {

    return preg_replace("~\s+type=[\"'][^\"']++[\"']~", "", $html);

}



/**
 * Remove dimensions.
 *
 * Removes 'width' and 'height' attributes.
 *
 * @param  string $html HTML tag containing width/height attributes.
 * @return string       HTML tag with the width/height attributes removed.
 */
function soshal_remove_dimensions($html) {

   $html = preg_replace("/(width|height)=\"\d*\"\s/", "", $html);

   return $html;

}



/**
 * Add custom formats to TinyMCE.
 *
 * @param  array $init_array Initialization options.
 * @return array             Modified options.
 */
function soshal_tinymce_formats($init_array) {

  // Define the style_formats array.
  $style_formats = array(

    array(
      "title"    => "button link",
      "selector" => "a",
      "classes"  => "btn",
      "wrapper"  => false
    )

  );

  $init_array['style_formats'] = json_encode($style_formats);

  return $init_array;

}



/**
 * Adds the style select option to TinyMCE.
 *
 * @param  array $buttons The TinyMCE buttons.
 * @return array          The modified TinyMCE buttons.
 */
function soshal_tinymce_buttons($buttons) {

  array_unshift($buttons, "styleselect");

  return $buttons;

}



/**
 * Remove empty <p> tags and spacing around shortcodes
 *
 * @param  string $content HTML as a string.
 * @return string          HTML as a string.
 */
function soshal_remove_empty_tags($content) {

    $tags = array(
        "<p>["    => "[",
        "]</p>"   => "]",
        "]<br>"   => "]",
        "]<br />" => "]",
        "<p></p>" => "",
    );

    $content = strtr($content, $tags);

    return $content;

}



/**
 * Disable emojicons in TinyMCE.
 *
 * @param  array $plugins A list of plugins.
 * @return array          Modified list of plugins.
 */
function soshal_disable_emojicons_tinymce($plugins) {

  if (is_array($plugins)) {

    return array_diff($plugins, array("wpemoji"));

  } else {

    return array();

  }

}





/**
 * Defer JavaScripts.
 *
 * @param  string $url The script tag.
 * @return string      The modified script tag.
 */
function soshal_defer_scripts($url) {

  if (strpos($url, "#defer") === false) {

    return $url;

  } else if (is_admin()) {

    return str_replace("#defer", "", $url);

  } else {

    return str_replace("#defer", "", $url) . "' defer='defer";

  }

}





/* --------------------------------- *
 * $REMOVE                           *
 * --------------------------------- */
remove_filter("the_excerpt",      "wpautop");
remove_filter("wp_mail",          "wp_staticize_emoji_for_email");
remove_filter("the_content_feed", "wp_staticize_emoji");
remove_filter("comment_text_rss", "wp_staticize_emoji");

?>