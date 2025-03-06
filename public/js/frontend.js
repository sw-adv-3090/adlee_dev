var _____WB$wombat$assign$function_____ = function(name) {return (self._wb_wombat && self._wb_wombat.local_init && self._wb_wombat.local_init(name)) || self[name]; };
if (!self.__WB_pmw) { self.__WB_pmw = function(obj) { this.__WB_source = obj; return this; } }
{
  let window = _____WB$wombat$assign$function_____("window");
  let self = _____WB$wombat$assign$function_____("self");
  let document = _____WB$wombat$assign$function_____("document");
  let location = _____WB$wombat$assign$function_____("location");
  let top = _____WB$wombat$assign$function_____("top");
  let parent = _____WB$wombat$assign$function_____("parent");
  let frames = _____WB$wombat$assign$function_____("frames");
  let opener = _____WB$wombat$assign$function_____("opener");

; (function ($) {
    $(function () {

        /**
         * Toggle Sub Menu
         */
        window.variationsMenuManager = window.variationsMenuManager || {

            subMenuElements: '.wp-block-navigation-submenu__toggle, .wp-block-navigation-item.has-child > a',
            menuLinks: '.wp-block-navigation a',
            closeButton: '.wp-block-navigation__responsive-container-close',

            checkMenuLinks: function () {

                const _this = this;

                $(this.menuLinks).on('click', function () {

                    const href = $(this).attr('href');
                    const regex = new RegExp('#');

                    if (regex.test(href)) {

                        $(_this.closeButton).trigger('click');
                    }
                });
            },

            bindToggleSubMenu: function () {

                $(this.subMenuElements).on('click', function (e) {

                    if ($(window).width() <= 767) {

                        e.preventDefault();
                        $(this).parent().children('ul').slideToggle('fast');
                    }
                });
            },

            init: function () {

                // Toggle SubMenu
                this.bindToggleSubMenu();

                // Close Menu on mobile if there is a #
                this.checkMenuLinks();
            }
        }

        variationsMenuManager.init();

        /**
         * Sticky Header
         */
        window.variationsManageStickyHeader = window.variationsManageStickyHeader || {

            header: '.is-position-sticky',
            cleanClass: 'mx_clean_header_background',

            manageHeader: function () {

                if ($(this.header).length === 0) return;

                const window_width = $(window).width();

                if (window_width < 768) {

                    $(this.header).removeClass(this.cleanClass);
                    return;
                }

                const scroll_position = $(document).scrollTop();

                if (scroll_position < 50) {

                    $(this.header).addClass(this.cleanClass);
                } else {

                    $(this.header).removeClass(this.cleanClass);
                }

            },

            init: function () {

                const _this = this;

                // Check when page is ready
                this.manageHeader();

                // Check on scroll event
                $(window).on('scroll', function () {

                    _this.manageHeader();
                });
            }
        }

        variationsManageStickyHeader.init();

    });
})(jQuery);

}
/*
     FILE ARCHIVED ON 00:26:00 Apr 13, 2024 AND RETRIEVED FROM THE
     INTERNET ARCHIVE ON 12:27:10 Sep 04, 2024.
     JAVASCRIPT APPENDED BY WAYBACK MACHINE, COPYRIGHT INTERNET ARCHIVE.

     ALL OTHER CONTENT MAY ALSO BE PROTECTED BY COPYRIGHT (17 U.S.C.
     SECTION 108(a)(3)).
*/
/*
playback timings (ms):
  captures_list: 0.573
  exclusion.robots: 0.028
  exclusion.robots.policy: 0.016
  esindex: 0.01
  cdx.remote: 24.906
  LoadShardBlock: 88.241 (3)
  PetaboxLoader3.datanode: 99.512 (4)
  load_resource: 103.897
  PetaboxLoader3.resolve: 50.689
*/