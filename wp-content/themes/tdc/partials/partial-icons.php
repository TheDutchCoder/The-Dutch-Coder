<?php

/**
 * partial-icons.php
 *
 * Includes all the SVG icons as one big SVG file. This makes the icons easy to
 * style, doesn't cost any HTTP requests and is accessible as well.
 *
 * When used as an icon next to text, use a "presentation" role.
 * When used as a stand alone image, use an "img" role.
 *
 * @example An SVG used as an icon.
 * <a href="http://www.twitter.com/user"><svg class="icon icon--x2" role="presentation"><use xlink:href="#icon-twitter"></svg>Find us on Twitter</a>
 *
 * @example An SVG used as an image.
 * <a href="http://www.twitter.com/user"><svg class="icon icon--x2" title="Find us on twitter" role="img"><use xlink:href="#icon-twitter"></svg></a>
 */

?>
<svg xmlns="http://www.w3.org/2000/svg" class="hidden">

  <!-- General Icons -->
  <symbol id="icon-logo" viewBox="0 0 72 72">
    <title>Logo</title>
    <desc>A logo in a stroked circle shape</desc>
    <path fill-rule="evenodd" clip-rule="evenodd" d="M2,36c0,18.748,15.252,34,34,34s34-15.252,34-34S54.748,2,36,2 S2,17.252,2,36z M4.72,36C4.72,18.752,18.752,4.72,36,4.72c17.248,0,31.279,14.032,31.279,31.28 c0,17.248-14.031,31.28-31.279,31.28C18.752,67.28,4.72,53.248,4.72,36z"/>
  </symbol>

</svg>