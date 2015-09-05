<?php

/**
 * actions.php
 *
 * Sets up and removes actions for this theme.
 */





/* --------------------------------- *
 * CONTENTS                          *
 * --------------------------------- */
/**
 * $ADD......................Add actions
 * Scripts...................Javascripts
 * Menus.....................Wordpress menus
 * Pagination................Custom paginator
 * Styles....................Stylesheets
 * Text domain...............Adds translation support
 *
 * $REMOVE...................Remove actions
 */





/* --------------------------------- *
 * $ADD                              *
 * --------------------------------- */
add_action("init",               "soshal_scripts");
add_action("init",               "soshal_menus");
add_action("wp_enqueue_scripts", "soshal_styles");
add_action("after_setup_theme",  "soshal_text_domain");



/**
 * Scripts.
 *
 * Loads Javascripts in the appropriate places.
 */
function soshal_scripts() {

  // jQuery.
  wp_deregister_script("jquery");
  wp_enqueue_script("jquery", (stripos($_SERVER["SERVER_PROTOCOL"], "https") ? "https" : "http") . "://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js", array(), null, true);

  // Web Font Loader.
  wp_enqueue_script("webfontloader", $GLOBALS["template_uri"] . "/js/vendor/webfontloader.js#defer", array(), null, false);

  // Plugins & scripts.
  wp_enqueue_script("scripts", $GLOBALS["template_uri"] . "/js/dist/scripts.min.js", array(), null, true);

}





/**
 * Menus.
 *
 * Registers all the menu positions for the theme.
 */
function soshal_menus() {

  register_nav_menus(array(
    "nav--global" => __("Global Navigation",  "soshal"),
    "nav--main"   => __("Main Navigation",    "soshal"),
    "nav--aside"  => __("Sidebar Navigation", "soshal"),
    "nav--footer" => __("Footer Navigation",  "soshal")
  ));

}



/**
 * Styles.
 *
 * Enqueues our stylesheet(s).
 */
function soshal_styles() {

  wp_register_style("soshal-css", $GLOBALS["template_uri"] . "/style.css", array(), "1.0");
  wp_enqueue_style("soshal-css");

}



/**
 * Textdomain.
 *
 * Adds translations support for the theme.
 */
function soshal_text_domain() {

  load_theme_textdomain("soshal", $GLOBALS["template_dir"] . "/languages");

}





/* --------------------------------- *
 * $REMOVE                           *
 * --------------------------------- */
/**
 * This basically cleans up the head, as there's some stuff we don't really need
 * in a typical build. Feel free to comment out items you do need.
 */
remove_action("wp_head",             "feed_links_extra", 3);
remove_action("wp_head",             "feed_links", 2);
remove_action("wp_head",             "rsd_link");
remove_action("wp_head",             "wlwmanifest_link");
remove_action("wp_head",             "wp_generator");
remove_action("wp_head",             "rel_canonical");
remove_action("wp_head",             "wp_shortlink_wp_head", 10, 0);
remove_action("wp_head",             "print_emoji_detection_script", 7);
remove_action("admin_print_styles",  "print_emoji_styles");
remove_action("admin_print_scripts", "print_emoji_detection_script");
remove_action("wp_print_styles",     "print_emoji_styles");

?>