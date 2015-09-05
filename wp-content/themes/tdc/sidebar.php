<?php

/**
 * sidebar.php
 *
 * Displays the sidebar, with the searchform and widget areas.
 *
 * @todo: check if the sidebar code actually works.
 */

?>
<div class="sidebar" role="complementary">

  <?php get_template_part("searchform"); ?>
  <?php if (!function_exists("dynamic_sidebar") || !dynamic_sidebar("widget-area-1")) ?>
  <?php if (!function_exists("dynamic_sidebar") || !dynamic_sidebar("widget-area-2")) ?>

</div>