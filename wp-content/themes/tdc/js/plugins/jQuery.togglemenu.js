/*!
 * jQuery.togglemenu.js
 *
 * A plugin that helps creating mobile friendly navigation menus.
 *
 * @author  Reinier Kaper <reinier.kaper@soshal.ca>
 * @example

$('.js-toggle-nav').togglemenu({
    nav:    '.nav--main',
    subnav: '.nav--sub',
    itemv:  '.nav--item',
    link:   '.nav__link',
    back:   '.nav__link--back',

    active:   '.is-active',
    inactive: '.is-active',
    open:     '.is-open',

    reset_on_close: true,
    reset_query:    'screen and (min-width: 40em)'
});

 * nav            {string}  The element to tie the plugin to.
 * subnav         {string}  The selector for sub navigation.
 * item           {string}  The selector for nav items.
 * link           {string}  The selector for nav links.
 * back           {string}  The selector for (optional) back links.
 *
 * active         {string}  The class name for active elements.
 * inactive       {string}  The class name for inactive elements.
 * open           {string}  The class name for open elements.
 *
 * reset_on_close {Boolean} Enable to completely reset the navigation on close.
 * reset_query    {string}  Mediaquery where the plugin should be disabled.
 */

;(function($, window, document, undefined) {


    /**
     * The name of the plugin.
     *
     * @type {string}
     */
    var pluginName = 'togglemenu';



    /**
     * The defaults for the plugin.
     *
     * @type {object}
     */
    var defaults = {
            nav:      '.nav--main',
            subnav:   '.nav--sub',
            item:     '.nav__item',
            link:     '.nav__link',
            back:     '.nav__link--back',

            active:   '.is-active',
            inactive: '.is-inactive',
            open:     '.is-open',

            reset_on_close: true,
            reset_query: 'screen and (min-width: 40em)'
        };



    /**
     * The actual plugin constructor.
     *
     * @param {object} element The element the plugin is attached to.
     * @param {object} options The user provided plugin options.
     */
    function Plugin(element, options) {

        this.element = element;
        this.options = $.extend({}, defaults, options) ;

        this._defaults = defaults;
        this._name = pluginName;

        this.has_events = false;

        this.init();
        this.initEvents();

    }



    /**
     * Plugin methods.
     *
     * @type {object}
     */
    Plugin.prototype = {



        /**
         * Initializes the plugin.
         */
        init: function() {

            this.selectors = {
                nav:      ('.' + this.options.nav).replace('..', '.'),
                subnav:   ('.' + this.options.subnav).replace('..', '.'),
                item:     ('.' + this.options.item).replace('..', '.'),
                link:     ('.' + this.options.link).replace('..', '.'),
                back:     ('.' + this.options.back).replace('..', '.'),
                active:   ('.' + this.options.active).replace('..', '.'),
                inactive: ('.' + this.options.inactive).replace('..', '.'),
                open:     ('.' + this.options.open).replace('..', '.')
            };

            this.classes = {
                nav:      this.options.nav.replace(/^\./g, ''),
                subnav:   this.options.subnav.replace(/^\./g, ''),
                item:     this.options.item.replace(/^\./g, ''),
                link:     this.options.link.replace(/^\./g, ''),
                back:     this.options.back.replace(/^\./g, ''),
                active:   this.options.active.replace(/^\./g, ''),
                inactive: this.options.inactive.replace(/^\./g, ''),
                open:     this.options.open.replace(/^\./g, '')
            };

        },



        /**
         * Initializes the event handlers.
         */
        initEvents: function() {

            var self = this;

            this.has_events = true;


            // When the trigger is clicked, toggle the menu.
            $(this.element).on('click', function(event) {

                var is_open = $(self.selectors.nav).hasClass(self.classes.open);

                event.preventDefault();
                self.toggleNav(is_open);

            });


            // When a link is clicked, check for a subnav.
            // If the subnav is closed, open it. In all other cases, follow the
            // link normally.
            $([this.selectors.nav + ' ' + this.selectors.link, this.selectors.nav + ' ' + this.selectors.back].join(',')).on('click', function(event) {

                var $link,
                    $subnav,
                    is_back,
                    is_closed;

                $link = $(this);
                is_back = $link.hasClass(self.classes.back);
                $subnav = is_back ? $link.parent(self.selectors.subnav) : $link.siblings(self.selectors.subnav);
                is_closed = !!$subnav.length && !$subnav.hasClass(self.classes.open);

                if (is_back) {

                    event.preventDefault();
                    self.closeSubnav($subnav);

                } else {

                    if (is_closed) {

                        event.preventDefault();
                        self.openSubnav($link, $subnav);

                    }

                }

            });


            // When the window is resized, check if the navigation needs to be
            // reset, but only if we can use Modernizr's mq() method.
            if (typeof window.Modernizr === 'object' &&
                typeof window.Modernizr.mq === 'function') {

                $(window).on('resize', function() {

                    window.requestAnimationFrame(self.handleResize.bind(self));

                }).resize();

            }

        },



        /**
         * Removes all events.
         */
        removeEvents: function() {

            this.has_events = false;

            $(this.element).off('click');
            $([this.selectors.nav + ' ' + this.selectors.link, this.selectors.nav + ' ' + this.selectors.back].join(',')).off('click');

        },



        /**
         * Toggles the attached navigation.
         *
         * @param {bool} is_open Whether the navigation is currently open.
         */
        toggleNav: function(is_open) {

            var self = this;


            // When the navigation is currently open, close it, otherwise open
            // the navigation.
            if (is_open && !self.options.reset_on_close) {

                $(self.element)
                    .removeClass(self.classes.active);

                $(self.selectors.nav)
                    .removeClass(self.classes.open);

            } else if (is_open && self.options.reset_on_close) {

                self.resetNav();

            } else {

                $(self.element)
                    .addClass(self.classes.active);

                $(self.selectors.nav)
                    .addClass(self.classes.open);

            }

        },



        /**
         * Resets all elements to their initial state.
         */
        resetNav: function() {

            var self = this;


            $(self.element)
                .removeClass(self.classes.active);

            $(self.selectors.nav)
                .removeClass(self.classes.open)
                .find([
                    self.selectors.subnav,
                    self.selectors.link,
                    self.selectors.item,
                    self.selectors.back
                ].join())
                .removeClass([
                    self.classes.active,
                    self.classes.inactive,
                    self.classes.open
                ].join(' '));

        },



        /**
         * Opens the subnavigation.
         */
        openSubnav: function($link, $subnav) {

            var self = this;

            $link
                .addClass(self.classes.active)
                .closest(self.selectors.item)
                .addClass(self.classes.active)
                .siblings()
                .addClass(self.classes.inactive);

            $subnav
                .addClass(self.classes.open);

        },



        /**
         * Closes the subnavigation.
         *
         * @param {object} $subnav The subnavigation to close.
         */
        closeSubnav: function($subnav) {

            var self = this;

            $subnav
                .siblings()
                .removeClass(self.classes.active);

            $subnav
                .removeClass(self.classes.open)
                .find([
                    self.selectors.subnav,
                    self.selectors.link,
                    self.selectors.item,
                    self.selectors.back
                ].join())
                .removeClass([
                    self.classes.active,
                    self.classes.inactive,
                    self.classes.open
                ].join(' '))
                .end()
                .closest(self.selectors.item)
                .removeClass(self.classes.active)
                .siblings()
                .removeClass([
                    self.classes.active,
                    self.classes.inactive,
                    self.classes.open
                ].join(' '));

        },



        /**
         * Handles window resizing events.
         */
        handleResize: function() {

            var self = this;

            // See if the plugin needs to reset when the reset query is hit.
            // The window width check is to prevent the event from incorrectly
            // firing in some browsers.
            if ($(window).width() !== self.window_width) {

                self.window_width = $(window).width();

                if (window.Modernizr.mq(self.options.reset_query)) {

                    self.resetNav();

                    if (self.has_events) {
                        self.removeEvents();
                    }

                } else {

                    if (!self.has_events) {

                        self.initEvents();

                    }

                }

            }

        }

    };



    /**
     * A really lightweight plugin wrapper around the constructor, preventing
     * against multiple instantiations.
     *
     * @param  {object} options The user provided plugin options.
     * @return {object}         The jQuery object (for chaining).
     */
    $.fn[pluginName] = function (options) {
        return this.each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName,
                new Plugin(this, options));
            }
        });
    };



})(jQuery, window, document);
