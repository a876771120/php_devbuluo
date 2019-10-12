(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory(require('jquery')) :
    typeof define === 'function' && define.amd ? define('element', ['jquery'], factory) :
    (global = global || self, global.element = factory(global.jQuery));
}(this, function ($) { 'use strict';

    $ = $ && $.hasOwnProperty('default') ? $['default'] : $;

    var element = function element(type, el, options) {
      return new element.Items[type](el, options);
    },
        Selector = {
      //navMenu
      navMenus: "[dui-menubar]",
      menus: ".dui-menu",
      submenus: ".dui-submenu",
      submenusTitles: ".dui-submenu__title",
      jump: '.dui-menu-item',
      //dropDown
      dropDown: "[dui-dropdown]",
      dropDownToggle: ".dui-dropdown-toggle",
      dropDownMenu: ".dui-dropdown-menu"
    },
        className = {
      isOpen: 'is-open',
      isActive: 'is-active'
    };

    element.Items = element.prototype = {
      navMenu: function navMenu(el, options) {
        var that = this;
        that.elem = el;
        dui.setData(el, 'navMenu', options);

        var submenus = $(that.elem).children(Selector.submenus),
            $jump = $(that.elem).find(Selector.jump),
            itemClick = function itemClick(e) {
          $(that.elem).find(Selector.jump).removeClass(className.isActive);
          $(this).addClass(className.isActive);
        };

        var data = el.vnode.data.navMenu;
        /**
         * 递归初始化元素的方法
         * @param {Array} list 要初始化的集合
         * @param {Integer} level 当前层级
         * @param {Boolean} openonly 是否只打开一个
         */

        var menuRender = function menuRender(list, level, openonly) {
          var isOpen = false; //是否已经有一个打开了

          $.each(list, function (i, item) {
            var $item = $(item),
                $title = $item.children(Selector.submenusTitles),
                nextMenu = $item.children(Selector.menus),
                //子菜单
            open = $item.hasClass(className.isOpen) ? true : false,
                //是否是打开
            show = function () {
              if (open && !isOpen) {
                isOpen = true;
                return true;
              } else {
                $item.removeClass(className.isOpen);
                return false;
              }
            }(); //判断是否显示下级菜单


            $title[0].isOpen = open;
            $title[0].transition = dui.collapseTransition(nextMenu[0], {
              show: show
            });

            $title[0].show = function () {
              $title[0].transition.show();
              $title[0].isOpen = true;
              $title.parent().addClass('is-opened');
            };

            $title[0].hide = function () {
              $title[0].transition.hide();
              $title[0].isOpen = false;
              $title.parent().removeClass('is-opened');
            };

            var titleClick = function titleClick(e) {
              e.preventDefault();
              var that = this,
                  open = that.isOpen,
                  Others = $(that).parent().siblings().find(Selector.submenusTitles);

              if (open) {
                //关闭
                that.hide();
              } else {
                //打开
                that.show();

                if (openonly) {
                  Others.each(function (index, other) {
                    other.hide();
                  });
                }
              }
            };

            $title.off('click', titleClick).on('click', titleClick); //继续下一级菜单

            var children = nextMenu.children(Selector.submenus);

            if (children) {
              menuRender(children, level + 1, openonly);
            }
          });
        };

        menuRender(submenus, 1, data.openonly); //设置高亮事件

        $jump.off('click', itemClick).on('click', itemClick);
      },
      dropDown: function dropDown(el, options) {
        var that = this;
        that.options = $.extend(true, {}, options);
        dui.setData(el, 'dropDown', {}, {});
        var data = el.vnode.data.dropDown;
        var x = {
          top: 'bottom',
          'bottom': 'top'
        };
        var ref = $(el).find(Selector.dropDownToggle);
        var pop = $(el).find(Selector.dropDownMenu);
        that.popper = dui.addPopper(ref[0], pop[0], {
          onCreate: function onCreate(data) {
            that.transition = dui.transition(pop[0], {
              name: 'dui-zoom-in-' + x[data._options.placement]
            });
          },
          onUpdate: function onUpdate(data) {
            that.transition.data.name = 'dui-zoom-in-' + x[data.placement];
          }
        });
        that.visible = pop.css('display') == 'none' ? true : false;
        that.toggle = ref.attr('toggle') == 'hover' ? 'hover' : 'click';
        that.showTimeout = 0;
        that.hideTimeout = 150;
        that.timerout = 0;

        var show = function show() {
          clearTimeout(that.timerout);

          if (pop.css('display') !== 'none') {
            return;
          } else {
            that.timerout = setTimeout(function () {
              that.popper.updatePopper();
              that.transition.show();
            }, that.toggle === 'hover' ? that.showTimeout : 0);
          }
        };

        var hide = function hide() {
          clearTimeout(that.timerout);
          that.timerout = setTimeout(function () {
            that.transition.hide();
          }, that.toggle === 'hover' ? that.hideTimeout : 0);
        };

        if (that.toggle === 'hover') {
          ref.hover(show, hide);
          pop.hover(show, hide);
        } else {
          ref.on('click', function (e) {
            if (that.visible) {
              that.visible = false;
              show();
            } else {
              that.visible = true;
              hide();
            }
          });
        }
      }
    };

    element.render = function (type, filter) {
      var filter = function () {
        return filter ? '[dui-filter="' + filter + '"]' : '';
      }(),
          Items = {
        navMenu: function navMenu() {
          $(Selector.navMenus + filter).each(function (i, el) {
            element('navMenu', el, {
              openonly: typeof $(el).attr('openonly') === "undefined" ? false : true
            });
          });
        },
        dropDown: function dropDown() {
          $(Selector.dropDown + filter).each(function (i, el) {
            element('dropDown', el, {});
          });
        }
      };

      Items[type] ? Items[type]() : dui.each(Items, function (key, fn) {
        fn();
      });
    };

    element.render();

    return element;

}));
