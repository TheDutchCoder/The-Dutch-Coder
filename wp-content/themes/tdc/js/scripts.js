/*!
 * scripts.js
 *
 * Call any plugins and other regular JavaScript and jQuery code here.
 */

;(function($, window, document, undefined) {

    $(function() {

        // Attaches the togglemenu plugin to the menu button that's visible for
        // mobile users.
        $('.js-toggle-nav').togglemenu({
            nav:    '.nav--main',
            subnav: '.nav--sub',
            item:   '.nav--item',
            link:   '.nav__link',
            back:   '.nav__link--back',

            active:   '.is-active',
            inactive: '.is-inactive',
            open:     '.is-open',

            reset_on_close: true,
            reset_query:    'screen and (min-width: 40em)'
        });

    });

})(jQuery, window, document);
