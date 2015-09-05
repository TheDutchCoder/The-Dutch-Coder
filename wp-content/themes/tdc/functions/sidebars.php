<?php

/**
 * sidebars.php
 *
 * Sets up sidebars for this theme.
 */





/* --------------------------------- *
 * CONTENTS                          *
 * --------------------------------- */
/**
 * $ADD......................Add sidebars
 * Example sidebar...........Registers the Example sidebar
 */





/* --------------------------------- *
 * $ADD                              *
 * --------------------------------- */
// add_action("widgets_init", "soshal_sidebar_example");



/**
 * Example sidebar.
 */
function soshal_sidebar_example() {

  register_sidebar(array(
    "name"         => __("Main Sidebar", "soshal"),
    "id"           => "sidebar-1",
    "description"  => __("Widgets in this area will be shown on all posts and pages.", "soshal"),
    "before_title" => "<h2>",
    "after_title"  => "</h2>",
  ));

}

?>