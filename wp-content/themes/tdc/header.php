<?php

/**
 * header.php
 *
 * The global header for this theme.
 */

?><!doctype html>
<html <?php language_attributes(); ?> class="no-js">
  <head>
    <meta charset="<?php bloginfo("charset"); ?>">
    <title><?php wp_title(""); ?><?php if (wp_title("", false)) { echo " : "; } ?><?php bloginfo("name"); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Prefetch DNS, add more when needed -->
    <link rel="dns-prefetch" href="//ajax.googleapis.com">

    <?php

    // Include all favicons.
    //
    // Eventhough adding just one works fine, it's nicer to provide the full
    // experience to different devices. The best (and recommended) generator at
    // this time is: http://realfavicongenerator.net/

    get_template_part("partials/partial", "favicons");

    ?>

    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>

    <?php

    // Include SVG sprites as one big inline SVG file, so that we can flexibly
    // re-use and style them.

    get_template_part("partials/partial", "icons");

    ?>

    <header role="banner" class="header header--global">

      <?php

      // Provide a way to skip to the main content for users.
      // This improves accessibility.

      ?>
      <a href="#main" class="skip-link"><?php _e("Skip to the main content", "soshal"); ?></a>

      <?php

      // If an SVG can be used as a logo, it might be a better idea to use an
      // svg reference instead of an external image. This saves an HTTP request
      // and allows for easier styling as well.

      ?>
      <a href="<?php echo home_url(); ?>" aria-label="<?php _e("Return to the homepage", "soshal"); ?>" class="logo">
        <svg role="img" title="<?php _e("The company logo", "soshal"); ?>" class="logo__img icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-logo"></use></svg>
        <span class="visuallyhidden"><?php _e("Return to the homepage", "soshal"); ?></span>
      </a>

      <?php

      // Navigations should use the custom soshal_nav_walker for BEM style
      // output.
      //
      // Headings are not required, but recommended for accessibility.

      if (has_nav_menu("nav--main")) {

      ?>
      <nav role="navigation">
        <?php

        wp_nav_menu(array(
          "theme_location" => "nav--main",
          "container"      => false,
          "menu_class"     => "nav nav--main",
          "items_wrap"     => "<ul class=\"%2\$s\">%3\$s</ul>",
          "back_button"    => true,
          "walker"         => new soshal_nav_walker()
        ));

        ?>

        <?php

        // Include a mobile friendly way of accessing the navigation by
        // providing a button that opens/closes the menu. A standard jQuery
        // plugin is available that handles the events for this.

        ?>
        <button class="js-toggle-nav"><?php _e("Menu", "soshal"); ?></button>
      </nav>
      <?php

      }

      ?>

    </header>