<?php

/**
 * custom_post_types.php
 *
 * Sets up custom post types for this theme.
 */





/* --------------------------------- *
 * CONTENTS                          *
 * --------------------------------- */
/**
 * $ADD......................Add Custom Post Types
 * Example post type.........Registers the Example post type
 */





/* --------------------------------- *
 * $ADD                              *
 * --------------------------------- */
// add_action("init", "soshal_post_type_example");



/**
 * Example post type.
 *
 * Registers the 'example' post type, used for... well... examples.
 */
function soshal_post_type_example() {

  $labels = array(
    "name"               => _x("Examples", "soshal"),
    "singular_name"      => _x("Example", "soshal"),
    "add_new"            => _x("Add New", "soshal"),
    "add_new_item"       => _x("Add New Example", "soshal"),
    "edit_item"          => _x("Edit Example", "soshal"),
    "new_item"           => _x("New Example", "soshal"),
    "view_item"          => _x("View Example", "soshal"),
    "search_items"       => _x("Search Examples", "soshal"),
    "not_found"          => _x("No examples found", "soshal"),
    "not_found_in_trash" => _x("No examples found in Trash", "soshal"),
    "parent_item_colon"  => _x("Parent Example:", "soshal"),
    "menu_name"          => _x("Examples", "soshal")
  );

  $args = array(
    "labels"              => $labels,
    "hierarchical"        => false,
    "description"         => "Examples and things",
    "supports"            => array("title", "editor", "excerpt", "thumbnail"),
    "taxonomies"          => array("category", "post_tag", "page-category"),
    "public"              => true,
    "show_ui"             => true,
    "show_in_menu"        => true,
    "show_in_nav_menus"   => true,
    "menu_icon"           => "dashicons-id-alt",
    "menu_position"       => 5,
    "publicly_queryable"  => true,
    "exclude_from_search" => false,
    "has_archive"         => true,
    "query_var"           => true,
    "can_export"          => true,
    "rewrite"             => true,
    "capability_type"     => "post"
  );

  register_post_type("example", $args);

}

?>