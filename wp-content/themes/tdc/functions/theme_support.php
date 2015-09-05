<?php

/**
 * theme_support.php
 *
 * Sets up items that need theme support.
 */

if (function_exists("add_theme_support")) {

  // Enable menus.
  add_theme_support("menus");

  // Thumbnail sizes.
  add_theme_support("post-thumbnails");
  add_image_size("small",  120, "", true); // Small Thumbnail
  add_image_size("medium", 250, "", true); // Medium Thumbnail
  add_image_size("large",  700, "", true); // Large Thumbnail

  // Background image sizes.
  add_image_size("background-pocket", 720,  404,  true); // Pocket sizes.
  add_image_size("background-hand",   960,  540,  true); // Hand sizes.
  add_image_size("background-lap",    1280, 720,  true); // Lap sizes.
  add_image_size("background-desk",   1920, 1080, true); // Desk sizes.
  add_image_size("background-wide",   2560, 1440, true); // Wide sizes.

  // HTML5 output.
  add_theme_support("html5", array(
    "search-form",
    "comment-form",
    "comment-list",
    "gallery",
    "caption"
  ));

}

?>