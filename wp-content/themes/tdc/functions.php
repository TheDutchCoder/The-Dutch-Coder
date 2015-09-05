<?php
/**
 * functions.php
 *
 * Main functions file for this theme.
 *
 * Imports other partials from the 'functions' directory.
 */





/* --------------------------------- *
 * CONTENTS                          *
 * --------------------------------- */
/**
 * GLOBAL VARIABLES..........Global variables used throughout the theme.
 * INCLUDES..................All included partials.
 */





/* --------------------------------- *
 * GLOBAL VARIABLES                  *
 * --------------------------------- */
/**
 * Set some global variables that we can use throughout our theme, instead of
 * calling a function every single time.
 */
$GLOBALS["template_dir"] = get_template_directory();
$GLOBALS["template_uri"] = get_template_directory_uri();





/* --------------------------------- *
 * INCLUDES                          *
 * --------------------------------- */
/**
 * Include all partials for this theme.
 */
include "functions/actions.php";
include "functions/custom_post_types.php";
include "functions/filters.php";
include "functions/posts.php";
include "functions/shortcodes.php";
include "functions/sidebars.php";
include "functions/taxonomies.php";
include "functions/theme_support.php";
include "functions/walkers.php";

?>