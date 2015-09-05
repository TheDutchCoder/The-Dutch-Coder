<?php

/**
 * shortcodes.php
 *
 * Sets up shortcodes for this theme.
 */





/* --------------------------------- *
 * CONTENTS                          *
 * --------------------------------- */
/**
 * $ADD......................Add shortcodes
 * Example...................An example shortcode
 */





/* --------------------------------- *
 * $ADD                              *
 * --------------------------------- */
// add_shortcode("example", "soshal_example_shortcode");



/**
 * Example.
 *
 * An example container wrapper.
 *
 * @param  array  $atts    An array of options.
 * @param  string $content The content to go inside the container.
 * @return string          A string of formatted HTML.
 */
function soshal_example_shortcode($atts, $content = null) {

  $args = shortcode_atts(
    array(
      "last" => ""
    ),
    $atts
  );

  $last  = (bool) $args["last"];

  $output = '</div>';
  $output .= '<div class="container container--alt">';
  $output .= do_shortcode($content);
  $output .= '</div>';
  $output .= ($last ? '' : '<div class="container">');

  return $output;

}

?>