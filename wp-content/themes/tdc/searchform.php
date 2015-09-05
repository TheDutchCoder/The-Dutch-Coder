<?php

/**
 * searchform.php
 *
 * Displays the standard search form.
 */

?>
<form class="form form--search" method="get" action="<?php echo home_url(); ?>" role="search">
  <p class="form__group">
    <label for="search" class="form__label visuallyhidden">Search</label>
    <input type="search" id="search" name="s" placeholder="<?php _e("Type and hit enter to search.", "soshal"); ?>" class="form__element">
    <button type="submit" role="button" class="form__element btn btn--primary"><?php _e("Search", "soshal"); ?></button>
  </p>
</form>