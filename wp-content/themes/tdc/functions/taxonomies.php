<?php

/**
 * taxonomies.php
 *
 * Sets up taxonomies for this theme.
 */





/* --------------------------------- *
 * CONTENTS                          *
 * --------------------------------- */
/**
 * $ADD......................Add taxonomies
 * Example taxonomy..........Registers the 'example' taxonomy
 */





/* --------------------------------- *
 * $ADD                              *
 * --------------------------------- */
// add_action("init", "register_taxonomy_example");



/**
 * Example taxonomy.
 *
 * Registers the 'example' taxonomy and attaches it to the 'example' custom post
 * type.
 */
function register_taxonomy_example() {

  $labels = array(
    "name"                       => _x("Examples", "soshal"),
    "singular_name"              => _x("Example", "soshal"),
    "search_items"               => _x("Search Examples", "soshal"),
    "popular_items"              => _x("Popular Examples", "soshal"),
    "all_items"                  => _x("All Examples", "soshal"),
    "parent_item"                => _x("Parent Example", "soshal"),
    "parent_item_colon"          => _x("Parent Example:", "soshal"),
    "edit_item"                  => _x("Edit Example", "soshal"),
    "update_item"                => _x("Update Example", "soshal"),
    "add_new_item"               => _x("Add New Example", "soshal"),
    "new_item_name"              => _x("New Example", "soshal"),
    "separate_items_with_commas" => _x("Separate examples with commas", "soshal"),
    "add_or_remove_items"        => _x("Add or remove Examples", "soshal"),
    "choose_from_most_used"      => _x("Choose from most used Examples", "soshal"),
    "menu_name"                  => _x("Examples", "soshal")
  );

  $args = array(
    "labels"            => $labels,
    "public"            => true,
    "show_in_nav_menus" => true,
    "show_ui"           => true,
    "show_tagcloud"     => true,
    "show_admin_column" => false,
    "hierarchical"      => false,
    "rewrite"           => true,
    "query_var"         => true
  );

  register_taxonomy("example", array("example"), $args);

}

?>