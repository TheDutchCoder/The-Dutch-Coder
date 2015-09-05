<?php

/**
 * walkers.php
 *
 * Sets up custom walker functions for this theme.
 */





/* --------------------------------- *
 * CONTENTS                          *
 * --------------------------------- */
/**
 * Nav walker................Creates a BEM style nav menu.
 */



/**
 * Nav walker.
 *
 * Creates a BEM style navigation menu.
 *
 * Optional arguments:
 * back_button         Renders back buttons for every sub nav
 */
class soshal_nav_walker extends Walker_Nav_Menu {



  /**
   * Starts a new level of navigation (a sub nav).
   *
   * @param  string  &$output The output HTML.
   * @param  int     $depth   The maximum depth of the menu to render.
   * @param  array   $args    The provided options.
   */
  function start_lvl(&$output, $depth = 0, $args = array()) {

    $back_button = $args->back_button;
    $output .= "<ul class=\"nav nav--sub\">";

    // Render back buttons for mobile navigation.
    if ($back_button) {

      $output .= "<li class=\"nav__item\"><a href=\"#\" class=\"nav__link nav__link--back\" title=\"" . __("Return to the previous menu", "soshal") . "\">Back</a></li>";

    }

  }



  /**
   * End a level.
   *
   * @param  string  &$output The output HTML.
   * @param  int     $depth   The maximum depth of the menu to render.
   * @param  array   $args    The provided options.
   */
  function end_lvl(&$output, $depth = 0, $args = array()) {

    $output .= "</ul>";

  }



  /**
   * Start an element (nav item and link).
   *
   * @param  string  &$output           The output HTML.
   * @param  object  $object            The menu item object.
   * @param  int     $depth             The maximum depth of the menu to render.
   * @param  array   $args              The provided options.
   * @param  int     $current_object_id The ID of the current item.
   */
  function start_el(&$output, $object, $depth = 0, $args = array(), $current_object_id = 0) {

    $object_id           = $object->ID;
    $object_title        = $object->title;
    $object_url          = $object->url;
    $object_classes      = $object->classes;
    $object_is_current   = $object->current;
    $object_is_ancestor  = $object->current_item_ancestor;
    $object_is_parent    = $object->current_item_parent;
    $object_has_children = $object->menu_item_parent;
    $object_target       = $object->target;
    $object_attr_title   = $object->attr_title;

    // Empty the classes array so we can build our own and add our custom
    // classes to the nav items.
    $object->classes = array("nav__item");

    if ($object_is_current) {

      array_push($object->classes, "nav__item--current");

    }

    if ($object_is_ancestor) {

      array_push($object->classes, "nav__item--ancestor");

    }

    if ($object_is_parent) {

      array_push($object->classes, "nav__item--parent");

    }

    if (in_array("menu-item-has-children", $object_classes)) {

      array_push($object->classes, "nav__item--has-subnav");

    }

    $output .= "<li class=\"" . implode(" ", $object->classes) . "\"><a href=\"" . $object_url . "\" class=\"nav__link\"" . ($object_target ? " target=\"_blank\"" : "") . ($object_attr_title ? " title=\"" . $object_attr_title . "\"" : "") . ">" . $object_title . "</a>";

  }



  /**
   * Ends an element.
   *
   * @param  string  &$output The output HTML.
   * @param  object  $object  The menu item object.
   * @param  int     $depth   The maximum depth of the menu to render.
   * @param  array   $args    The provided options.
   */
  function end_el(&$output, $object, $depth = 0, $args = array()) {

    $output .= "</li>";

  }

}

?>