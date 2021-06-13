/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/headroom.js/dist/headroom.js":
/*!***************************************************!*\
  !*** ./node_modules/headroom.js/dist/headroom.js ***!
  \***************************************************/
/***/ (function(module) {

/*!
 * headroom.js v0.12.0 - Give your page some headroom. Hide your header until you need it
 * Copyright (c) 2020 Nick Williams - http://wicky.nillia.ms/headroom.js
 * License: MIT
 */

(function (global, factory) {
   true ? module.exports = factory() :
  0;
}(this, function () { 'use strict';

  function isBrowser() {
    return typeof window !== "undefined";
  }

  /**
   * Used to detect browser support for adding an event listener with options
   * Credit: https://developer.mozilla.org/en-US/docs/Web/API/EventTarget/addEventListener
   */
  function passiveEventsSupported() {
    var supported = false;

    try {
      var options = {
        // eslint-disable-next-line getter-return
        get passive() {
          supported = true;
        }
      };
      window.addEventListener("test", options, options);
      window.removeEventListener("test", options, options);
    } catch (err) {
      supported = false;
    }

    return supported;
  }

  function isSupported() {
    return !!(
      isBrowser() &&
      function() {}.bind &&
      "classList" in document.documentElement &&
      Object.assign &&
      Object.keys &&
      requestAnimationFrame
    );
  }

  function isDocument(obj) {
    return obj.nodeType === 9; // Node.DOCUMENT_NODE === 9
  }

  function isWindow(obj) {
    // `obj === window` or `obj instanceof Window` is not sufficient,
    // as the obj may be the window of an iframe.
    return obj && obj.document && isDocument(obj.document);
  }

  function windowScroller(win) {
    var doc = win.document;
    var body = doc.body;
    var html = doc.documentElement;

    return {
      /**
       * @see http://james.padolsey.com/javascript/get-document-height-cross-browser/
       * @return {Number} the scroll height of the document in pixels
       */
      scrollHeight: function() {
        return Math.max(
          body.scrollHeight,
          html.scrollHeight,
          body.offsetHeight,
          html.offsetHeight,
          body.clientHeight,
          html.clientHeight
        );
      },

      /**
       * @see http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript
       * @return {Number} the height of the viewport in pixels
       */
      height: function() {
        return win.innerHeight || html.clientHeight || body.clientHeight;
      },

      /**
       * Gets the Y scroll position
       * @return {Number} pixels the page has scrolled along the Y-axis
       */
      scrollY: function() {
        if (win.pageYOffset !== undefined) {
          return win.pageYOffset;
        }

        return (html || body.parentNode || body).scrollTop;
      }
    };
  }

  function elementScroller(element) {
    return {
      /**
       * @return {Number} the scroll height of the element in pixels
       */
      scrollHeight: function() {
        return Math.max(
          element.scrollHeight,
          element.offsetHeight,
          element.clientHeight
        );
      },

      /**
       * @return {Number} the height of the element in pixels
       */
      height: function() {
        return Math.max(element.offsetHeight, element.clientHeight);
      },

      /**
       * Gets the Y scroll position
       * @return {Number} pixels the element has scrolled along the Y-axis
       */
      scrollY: function() {
        return element.scrollTop;
      }
    };
  }

  function createScroller(element) {
    return isWindow(element) ? windowScroller(element) : elementScroller(element);
  }

  /**
   * @param element EventTarget
   */
  function trackScroll(element, options, callback) {
    var isPassiveSupported = passiveEventsSupported();
    var rafId;
    var scrolled = false;
    var scroller = createScroller(element);
    var lastScrollY = scroller.scrollY();
    var details = {};

    function update() {
      var scrollY = Math.round(scroller.scrollY());
      var height = scroller.height();
      var scrollHeight = scroller.scrollHeight();

      // reuse object for less memory churn
      details.scrollY = scrollY;
      details.lastScrollY = lastScrollY;
      details.direction = scrollY > lastScrollY ? "down" : "up";
      details.distance = Math.abs(scrollY - lastScrollY);
      details.isOutOfBounds = scrollY < 0 || scrollY + height > scrollHeight;
      details.top = scrollY <= options.offset[details.direction];
      details.bottom = scrollY + height >= scrollHeight;
      details.toleranceExceeded =
        details.distance > options.tolerance[details.direction];

      callback(details);

      lastScrollY = scrollY;
      scrolled = false;
    }

    function handleScroll() {
      if (!scrolled) {
        scrolled = true;
        rafId = requestAnimationFrame(update);
      }
    }

    var eventOptions = isPassiveSupported
      ? { passive: true, capture: false }
      : false;

    element.addEventListener("scroll", handleScroll, eventOptions);
    update();

    return {
      destroy: function() {
        cancelAnimationFrame(rafId);
        element.removeEventListener("scroll", handleScroll, eventOptions);
      }
    };
  }

  function normalizeUpDown(t) {
    return t === Object(t) ? t : { down: t, up: t };
  }

  /**
   * UI enhancement for fixed headers.
   * Hides header when scrolling down
   * Shows header when scrolling up
   * @constructor
   * @param {DOMElement} elem the header element
   * @param {Object} options options for the widget
   */
  function Headroom(elem, options) {
    options = options || {};
    Object.assign(this, Headroom.options, options);
    this.classes = Object.assign({}, Headroom.options.classes, options.classes);

    this.elem = elem;
    this.tolerance = normalizeUpDown(this.tolerance);
    this.offset = normalizeUpDown(this.offset);
    this.initialised = false;
    this.frozen = false;
  }
  Headroom.prototype = {
    constructor: Headroom,

    /**
     * Start listening to scrolling
     * @public
     */
    init: function() {
      if (Headroom.cutsTheMustard && !this.initialised) {
        this.addClass("initial");
        this.initialised = true;

        // defer event registration to handle browser
        // potentially restoring previous scroll position
        setTimeout(
          function(self) {
            self.scrollTracker = trackScroll(
              self.scroller,
              { offset: self.offset, tolerance: self.tolerance },
              self.update.bind(self)
            );
          },
          100,
          this
        );
      }

      return this;
    },

    /**
     * Destroy the widget, clearing up after itself
     * @public
     */
    destroy: function() {
      this.initialised = false;
      Object.keys(this.classes).forEach(this.removeClass, this);
      this.scrollTracker.destroy();
    },

    /**
     * Unpin the element
     * @public
     */
    unpin: function() {
      if (this.hasClass("pinned") || !this.hasClass("unpinned")) {
        this.addClass("unpinned");
        this.removeClass("pinned");

        if (this.onUnpin) {
          this.onUnpin.call(this);
        }
      }
    },

    /**
     * Pin the element
     * @public
     */
    pin: function() {
      if (this.hasClass("unpinned")) {
        this.addClass("pinned");
        this.removeClass("unpinned");

        if (this.onPin) {
          this.onPin.call(this);
        }
      }
    },

    /**
     * Freezes the current state of the widget
     * @public
     */
    freeze: function() {
      this.frozen = true;
      this.addClass("frozen");
    },

    /**
     * Re-enables the default behaviour of the widget
     * @public
     */
    unfreeze: function() {
      this.frozen = false;
      this.removeClass("frozen");
    },

    top: function() {
      if (!this.hasClass("top")) {
        this.addClass("top");
        this.removeClass("notTop");

        if (this.onTop) {
          this.onTop.call(this);
        }
      }
    },

    notTop: function() {
      if (!this.hasClass("notTop")) {
        this.addClass("notTop");
        this.removeClass("top");

        if (this.onNotTop) {
          this.onNotTop.call(this);
        }
      }
    },

    bottom: function() {
      if (!this.hasClass("bottom")) {
        this.addClass("bottom");
        this.removeClass("notBottom");

        if (this.onBottom) {
          this.onBottom.call(this);
        }
      }
    },

    notBottom: function() {
      if (!this.hasClass("notBottom")) {
        this.addClass("notBottom");
        this.removeClass("bottom");

        if (this.onNotBottom) {
          this.onNotBottom.call(this);
        }
      }
    },

    shouldUnpin: function(details) {
      var scrollingDown = details.direction === "down";

      return scrollingDown && !details.top && details.toleranceExceeded;
    },

    shouldPin: function(details) {
      var scrollingUp = details.direction === "up";

      return (scrollingUp && details.toleranceExceeded) || details.top;
    },

    addClass: function(className) {
      this.elem.classList.add.apply(
        this.elem.classList,
        this.classes[className].split(" ")
      );
    },

    removeClass: function(className) {
      this.elem.classList.remove.apply(
        this.elem.classList,
        this.classes[className].split(" ")
      );
    },

    hasClass: function(className) {
      return this.classes[className].split(" ").every(function(cls) {
        return this.classList.contains(cls);
      }, this.elem);
    },

    update: function(details) {
      if (details.isOutOfBounds) {
        // Ignore bouncy scrolling in OSX
        return;
      }

      if (this.frozen === true) {
        return;
      }

      if (details.top) {
        this.top();
      } else {
        this.notTop();
      }

      if (details.bottom) {
        this.bottom();
      } else {
        this.notBottom();
      }

      if (this.shouldUnpin(details)) {
        this.unpin();
      } else if (this.shouldPin(details)) {
        this.pin();
      }
    }
  };

  /**
   * Default options
   * @type {Object}
   */
  Headroom.options = {
    tolerance: {
      up: 0,
      down: 0
    },
    offset: 0,
    scroller: isBrowser() ? window : null,
    classes: {
      frozen: "headroom--frozen",
      pinned: "headroom--pinned",
      unpinned: "headroom--unpinned",
      top: "headroom--top",
      notTop: "headroom--not-top",
      bottom: "headroom--bottom",
      notBottom: "headroom--not-bottom",
      initial: "headroom"
    }
  };

  Headroom.cutsTheMustard = isSupported();

  return Headroom;

}));


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
/*!********************************!*\
  !*** ./resources/js/script.js ***!
  \********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var headroom_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! headroom.js */ "./node_modules/headroom.js/dist/headroom.js");
/* harmony import */ var headroom_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(headroom_js__WEBPACK_IMPORTED_MODULE_0__);
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { if (typeof Symbol === "undefined" || !(Symbol.iterator in Object(arr))) return; var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

/*!

=========================================================
* Leaf Non-Profit environmental Bootstrap 4 Theme
=========================================================

* Product Page: https://themesberg.com/product/web-templates/leaf-non-profit-environmental-bootstrap-4-theme
* Copyright 2019 Themesberg (https://www.themesberg.com)

* Coded by https://themesberg.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

*/

"use strict";

$(document).ready(function () {
  // options
  var breakpoints = {
    sm: 540,
    md: 720,
    lg: 960,
    xl: 1140
  };
  var $navbarCollapse = $('.navbar-main .collapse'); // Collapse navigation

  $navbarCollapse.on('hide.bs.collapse', function () {
    var $this = $(this);
    $this.addClass('collapsing-out');
    $('html, body').css('overflow', 'initial');
  });
  $navbarCollapse.on('hidden.bs.collapse', function () {
    var $this = $(this);
    $this.removeClass('collapsing-out');
  });
  $navbarCollapse.on('shown.bs.collapse', function () {
    $('html, body').css('overflow', 'hidden');
  });
  $('.navbar-main .dropdown').on('hide.bs.dropdown', function () {
    var $this = $(this).find('.dropdown-menu');
    $this.addClass('close');
    setTimeout(function () {
      $this.removeClass('close');
    }, 200);
  });
  $(document).on('click', '.mega-dropdown', function (e) {
    e.stopPropagation();
  });
  $(document).on('click', '.navbar-nav > .dropdown', function (e) {
    e.stopPropagation();
  });
  $('.dropdown-submenu > .dropdown-toggle').click(function (e) {
    e.preventDefault();
    $(this).parent('.dropdown-submenu').toggleClass('show');
  }); // Headroom - show/hide navbar on scroll

  if ($('.headroom')[0]) {
    var headroom = new (headroom_js__WEBPACK_IMPORTED_MODULE_0___default())(document.querySelector("#navbar-main"), {
      offset: 0,
      tolerance: {
        up: 0,
        down: 0
      }
    });
    headroom.init();
  } // Background images for sections


  $('[data-background]').each(function () {
    $(this).css('background-image', 'url(' + $(this).attr('data-background') + ')');
  });
  $('[data-background-color]').each(function () {
    $(this).css('background-color', $(this).attr('data-background-color'));
  });
  $('[data-color]').each(function () {
    $(this).css('color', $(this).attr('data-color'));
  }); // Tooltip
  // $('[data-toggle="tooltip"]').tooltip();
  // Popover

  $('[data-toggle="popover"]').each(function () {
    var popoverClass = '';

    if ($(this).data('color')) {
      popoverClass = 'popover-' + $(this).data('color');
    }

    $(this).popover({
      trigger: 'focus',
      template: '<div class="popover ' + popoverClass + '" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
    });
  }); // Additional .focus class on form-groups

  $('.form-control').on('focus blur', function (e) {
    $(this).parents('.form-group').toggleClass('focused', e.type === 'focus' || this.value.length > 0);
  }).trigger('blur'); //CounterUp
  // $('.counter').counterUp({
  //     delay: 10,
  //     time: 1000,
  //     offset: 70,
  //     beginAt: 100,
  //     formatter: function (n) {
  //         return n.replace(/,/g, '.');
  //     }
  // });
  // $(".progress-bar").each(function () {
  //     $(this).waypoint(function () {
  //         var progressBar = $(".progress-bar");
  //         progressBar.each(function (indx) {
  //             $(this).css("width", $(this).attr("aria-valuenow") + "%");
  //         });
  //         $('.progress-bar').css({
  //             animation: "animate-positive 3s",
  //             opacity: "1"
  //         });
  //     }, {
  //             triggerOnce: true,
  //             offset: '60%'
  //         });
  // });
  // When in viewport

  $('[data-toggle="on-screen"]')[0] && $('[data-toggle="on-screen"]').onScreen({
    container: window,
    direction: 'vertical',
    doIn: function doIn() {//alert();
    },
    doOut: function doOut() {// Do something to the matched elements as they get off scren
    },
    tolerance: 200,
    throttle: 50,
    toggleClass: 'on-screen',
    debug: false
  }); // Scroll to anchor with scroll animation

  $('[data-toggle="scroll"]').on('click', function (event) {
    var hash = $(this).attr('href');
    var offset = $(this).data('offset') ? $(this).data('offset') : 0; // Animate scroll to the selected section

    $('html, body').stop(true, true).animate({
      scrollTop: $(hash).offset().top - offset
    }, 600);
    event.preventDefault();
  }); //Chart.js

  if ($('.ct-chart').length) {
    var chart = new Chartist.Line('.ct-chart', {
      labels: ['Year', '200', '600', '1000', '1400', '1600', '1800', '1900', '2000', '2019', '2100', '2200'],
      series: [[12, 9, 7, 8, 5, 4, 6, 2, 3, 3, 4, 6], [4, 5, 3, 7, 3, 5, 5, 3, 4, 4, 5, 5], [5, 3, 4, 5, 6, 3, 3, 4, 5, 6, 3, 4], [3, 4, 5, 6, 7, 6, 4, 5, 6, 7, 6, 3]]
    }, {
      plugins: [Chartist.plugins.tooltip()],
      low: 0
    }); // Let's put a sequence number aside so we can use it in the event callbacks

    var seq = 0,
        delays = 30,
        durations = 100; // Once the chart is fully created we reset the sequence

    chart.on('created', function () {
      seq = 0;
    }); // On each drawn element by Chartist we use the Chartist.Svg API to trigger SMIL animations

    chart.on('draw', function (data) {
      seq++;

      if (data.type === 'line') {
        // If the drawn element is a line we do a simple opacity fade in. This could also be achieved using CSS3 animations.
        data.element.animate({
          opacity: {
            // The delay when we like to start the animation
            begin: seq * delays + 1000,
            // Duration of the animation
            dur: durations,
            // The value where the animation should start
            from: 0,
            // The value where it should end
            to: 1
          }
        });
      } else if (data.type === 'label' && data.axis === 'x') {
        data.element.animate({
          y: {
            begin: seq * delays,
            dur: durations,
            from: data.y + 100,
            to: data.y,
            // We can specify an easing function from Chartist.Svg.Easing
            easing: 'easeOutQuart'
          }
        });
      } else if (data.type === 'label' && data.axis === 'y') {
        data.element.animate({
          x: {
            begin: seq * delays,
            dur: durations,
            from: data.x - 100,
            to: data.x,
            easing: 'easeOutQuart'
          }
        });
      } else if (data.type === 'point') {
        data.element.animate({
          x1: {
            begin: seq * delays,
            dur: durations,
            from: data.x - 10,
            to: data.x,
            easing: 'easeOutQuart'
          },
          x2: {
            begin: seq * delays,
            dur: durations,
            from: data.x - 10,
            to: data.x,
            easing: 'easeOutQuart'
          },
          opacity: {
            begin: seq * delays,
            dur: durations,
            from: 0,
            to: 1,
            easing: 'easeOutQuart'
          }
        });
      } else if (data.type === 'grid') {
        // Using data.axis we get x or y which we can use to construct our animation definition objects
        var pos1Animation = {
          begin: seq * delays,
          dur: durations,
          from: data[data.axis.units.pos + '1'] - 30,
          to: data[data.axis.units.pos + '1'],
          easing: 'easeOutQuart'
        };
        var pos2Animation = {
          begin: seq * delays,
          dur: durations,
          from: data[data.axis.units.pos + '2'] - 100,
          to: data[data.axis.units.pos + '2'],
          easing: 'easeOutQuart'
        };
        var animations = {};
        animations[data.axis.units.pos + '1'] = pos1Animation;
        animations[data.axis.units.pos + '2'] = pos2Animation;
        animations['opacity'] = {
          begin: seq * delays,
          dur: durations,
          from: 0,
          to: 1,
          easing: 'easeOutQuart'
        };
        data.element.animate(animations);
      }
    }); // For the sake of the example we update the chart every time it's created with a delay of 10 seconds

    chart.on('created', function () {
      if (window.__exampleAnimateTimeout) {
        clearTimeout(window.__exampleAnimateTimeout);
        window.__exampleAnimateTimeout = null;
      }

      window.__exampleAnimateTimeout = setTimeout(chart.update.bind(chart), 182000);
    });
  }

  if ($('.ct-chart-2').length) {
    // Chart 2
    new Chartist.Line('.ct-chart-2', {
      labels: [2002, 2003, 2006, 2008, 2010, 2012, 2014, 2018],
      series: [[0, 1, 1.5, 2.5, 3.5, 4, 5, 6]]
    }, {
      low: 0,
      showArea: true,
      plugins: [Chartist.plugins.tooltip()]
    });
  }

  if ($('.ct-chart-3').length) {
    // Chart 3
    var chart = new Chartist.Line('.ct-chart-3', {
      labels: [1920, 1940, 1960, 1980, 2000, 2020],
      series: [[-0.5, 0, 0.125, 0.4, 0.8, 1]]
    }, {
      plugins: [Chartist.plugins.tooltip()]
    }); // Listening for draw events that get emitted by the Chartist chart

    chart.on('draw', function (data) {
      // If the draw event was triggered from drawing a point on the line chart
      if (data.type === 'point') {
        // We are creating a new path SVG element that draws a triangle around the point coordinates
        var triangle = new Chartist.Svg('path', {
          d: ['M', data.x, data.y - 10, 'L', data.x - 10, data.y + 8, 'L', data.x + 10, data.y + 8, 'z'].join(' '),
          style: 'fill-opacity: 1'
        }, 'ct-area'); // With data.element we get the Chartist SVG wrapper and we can replace the original point drawn by Chartist with our newly created triangle

        data.element.replace(triangle);
      }
    });
  }

  if ($('.ct-chart-4').length) {
    // Chart 4
    new Chartist.Line('.ct-chart-4', {
      labels: ['2004', '2006', '2008', '2010', '2012', '2014', '2016'],
      series: [[-0, -100, -400, -600, -800, -1000, -1200]]
    }, {
      fullWidth: true,
      chartPadding: {
        right: 40
      },
      plugins: [Chartist.plugins.tooltip()]
    });
  }

  if ($('.ct-chart-5').length) {
    //Chart 5
    new Chartist.Line('.ct-chart-5', {
      labels: [1995, 2000, 2005, 2010, 2015, 2020],
      series: [[0.25, 1, 1.7, 2.5, 3, 3.3]]
    }, {
      low: 0,
      showArea: true,
      plugins: [Chartist.plugins.tooltip()]
    });
  } // Charts that are hidden first fix


  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $(e.currentTarget.hash).find('.ct-chart-3, .ct-chart, .ct-chart-2, .ct-chart-4, .ct-chart-5').each(function (el, tab) {
      tab.__chartist__.update();
    });
  }); //Smooth scroll
  // var scroll = new SmoothScroll('a[href*="#"]', {
  //     speed: 500,
  //     speedAsDuration: true
  // });
  // Equalize height to the max of the elements

  if ($(document).width() >= breakpoints.lg) {
    // object to keep track of id's and jQuery elements
    var equalize = {
      uniqueIds: [],
      elements: []
    }; // identify all unique id's

    $('[data-equalize-height]').each(function () {
      var id = $(this).attr('data-equalize-height');

      if (!equalize.uniqueIds.includes(id)) {
        equalize.uniqueIds.push(id);
        equalize.elements.push({
          id: id,
          elements: []
        });
      }
    }); // add elements in order

    $('[data-equalize-height]').each(function () {
      var $el = $(this);
      var id = $el.attr('data-equalize-height');
      equalize.elements.map(function (elements) {
        if (elements.id === id) {
          elements.elements.push($el);
        }
      });
    }); // equalize

    equalize.elements.map(function (elements) {
      var elements = elements.elements;

      if (elements.length) {
        var maxHeight = 0; // determine the larget height

        elements.map(function ($element) {
          maxHeight = maxHeight < $element.outerHeight() ? $element.outerHeight() : maxHeight;
        }); // make all elements with the same [data-equalize-height] value
        // equal the larget height

        elements.map(function ($element) {
          $element.height(maxHeight);
        });
      }
    });
  } // update target element content to match number of characters


  $('[data-bind-characters-target]').each(function () {
    var $text = $($(this).attr('data-bind-characters-target'));
    var maxCharacters = parseInt($(this).attr('maxlength'));
    $text.text(maxCharacters);
    $(this).on('keyup change', function (e) {
      var string = $(this).val();
      var characters = string.length;
      var charactersRemaining = maxCharacters - characters;
      $text.text(charactersRemaining);
    });
  }); // before & after photo

  var dragging = false,
      scrolling = false,
      resizing = false; //cache jQuery objects

  var imageComparisonContainers = $('.image-container'); //check if the .cd-image-container is in the viewport
  //if yes, animate it

  checkPosition(imageComparisonContainers);
  $(window).on('scroll', function () {
    if (!scrolling) {
      scrolling = true;
      !window.requestAnimationFrame ? setTimeout(function () {
        checkPosition(imageComparisonContainers);
      }, 100) : requestAnimationFrame(function () {
        checkPosition(imageComparisonContainers);
      });
    }
  }); //make the .cd-handle element draggable and modify .cd-resize-img width according to its position

  imageComparisonContainers.each(function () {
    var actual = $(this);
    drags(actual.find('.handle'), actual.find('.resize-img'), actual, actual.find('.image-label[data-type="original"]'), actual.find('.image-label[data-type="modified"]'));
  }); //upadate images label visibility

  $(window).on('resize', function () {
    if (!resizing) {
      resizing = true;
      !window.requestAnimationFrame ? setTimeout(function () {
        checkLabel(imageComparisonContainers);
      }, 100) : requestAnimationFrame(function () {
        checkLabel(imageComparisonContainers);
      });
    }
  });

  function checkPosition(container) {
    container.each(function () {
      var actualContainer = $(this);

      if ($(window).scrollTop() + $(window).height() * 0.5 > actualContainer.offset().top) {
        actualContainer.addClass('is-visible');
      }
    });
    scrolling = false;
  }

  function checkLabel(container) {
    container.each(function () {
      var actual = $(this);
      updateLabel(actual.find('.image-label[data-type="modified"]'), actual.find('.resize-img'), 'left');
      updateLabel(actual.find('.image-label[data-type="original"]'), actual.find('.resize-img'), 'right');
    });
    resizing = false;
  } //draggable funtionality - credits to http://css-tricks.com/snippets/jquery/draggable-without-jquery-ui/


  function drags(dragElement, resizeElement, container, labelContainer, labelResizeElement) {
    dragElement.on("mousedown vmousedown", function (e) {
      dragElement.addClass('draggable');
      resizeElement.addClass('resizable');
      var dragWidth = dragElement.outerWidth(),
          xPosition = dragElement.offset().left + dragWidth - e.pageX,
          containerOffset = container.offset().left,
          containerWidth = container.outerWidth(),
          minLeft = containerOffset + 10,
          maxLeft = containerOffset + containerWidth - dragWidth - 10;
      dragElement.parents().on("mousemove vmousemove", function (e) {
        if (!dragging) {
          dragging = true;
          !window.requestAnimationFrame ? setTimeout(function () {
            animateDraggedHandle(e, xPosition, dragWidth, minLeft, maxLeft, containerOffset, containerWidth, resizeElement, labelContainer, labelResizeElement);
          }, 100) : requestAnimationFrame(function () {
            animateDraggedHandle(e, xPosition, dragWidth, minLeft, maxLeft, containerOffset, containerWidth, resizeElement, labelContainer, labelResizeElement);
          });
        }
      }).on("mouseup vmouseup", function (e) {
        dragElement.removeClass('draggable');
        resizeElement.removeClass('resizable');
      });
      e.preventDefault();
    }).on("mouseup vmouseup", function (e) {
      dragElement.removeClass('draggable');
      resizeElement.removeClass('resizable');
    });
  }

  function animateDraggedHandle(e, xPosition, dragWidth, minLeft, maxLeft, containerOffset, containerWidth, resizeElement, labelContainer, labelResizeElement) {
    var leftValue = e.pageX + xPosition - dragWidth; //constrain the draggable element to move inside his container

    if (leftValue < minLeft) {
      leftValue = minLeft;
    } else if (leftValue > maxLeft) {
      leftValue = maxLeft;
    }

    var widthValue = (leftValue + dragWidth / 2 - containerOffset) * 100 / containerWidth + '%';
    $('.draggable').css('left', widthValue).on("mouseup vmouseup", function () {
      $(this).removeClass('draggable');
      resizeElement.removeClass('resizable');
    });
    $('.resizable').css('width', widthValue);
    updateLabel(labelResizeElement, resizeElement, 'left');
    updateLabel(labelContainer, resizeElement, 'right');
    dragging = false;
  }

  function updateLabel(label, resizeElement, position) {
    if (position == 'left') {
      label.offset().left + label.outerWidth() < resizeElement.offset().left + resizeElement.outerWidth() ? label.removeClass('is-hidden') : label.addClass('is-hidden');
    } else {
      label.offset().left > resizeElement.offset().left + resizeElement.outerWidth() ? label.removeClass('is-hidden') : label.addClass('is-hidden');
    }
  } // copy docs


  $('.copy-docs').on('click', function () {
    var $copy = $(this);
    var htmlEntities = $copy.parents('.nav-wrapper').siblings('.card').find('.tab-pane:last-of-type').html();
    var htmlDecoded = $('<div/>').html(htmlEntities).text().trim();
    var $temp = $('<textarea>');
    $('body').append($temp);
    $temp.val(htmlDecoded).select();
    document.execCommand('copy');
    $temp.remove();
    $copy.text('Copied!');
    $copy.addClass('copied');
    setTimeout(function () {
      $copy.text('Copy');
      $copy.removeClass('copied');
    }, 1000);
  });
  $('#loadOnClick').click(function () {
    var $button = $(this);
    var $loadContent = $('#extraContent');
    var $allLoaded = $('#allLoadedText');
    $button.addClass('btn-loading');
    $button.attr('disabled', true);
    setTimeout(function () {
      $loadContent.show();
      $button.hide();
      $allLoaded.show();
    }, 1500);
  });

  if ($('#vmap').length) {
    $('#vmap').vectorMap({
      map: 'world_en',
      backgroundColor: '#ffffff',
      borderColor: '#ffffff',
      borderOpacity: 0,
      borderWidth: 1,
      color: '#e9ecef',
      enableZoom: false,
      hoverColor: '#11AB7C',
      hoverOpacity: null,
      normalizeFunction: 'linear',
      scaleColors: ['#b6d6ff', '#005ace'],
      selectedColor: '#11AB7C',
      selectedRegions: null,
      showTooltip: true,
      onLabelShow: function onLabelShow(event, label, code) {
        switch (code) {
          case 'au':
            label.text('Australia: $283.26m');
            break;

          case 'ca':
            label.text('Canada: $277.03m');
            break;

          case 'fr':
            label.text('France: $136.17m');
            break;

          case 'de':
            label.text('Germany: $680.67m');
            break;

          case 'jp':
            label.text('Japan: $1,234.14m');
            break;

          case 'us':
            label.text('United States: $2,000.04m');
            break;

          case 'gb':
            label.text('United Kingdom: $2,830.80m');
            break;

          case 'ru':
            label.text('Russia: $830.80m');
            break;

          case 'cn':
            label.text('China: $830.80t');
            break;

          default:
            label.text('No data');
        }
      }
    });
  }

  $("#profile-btn").on('click', function () {
    $("#profile-menu").toggleClass("d-none").on("blur", function () {
      $(this).toggleClass("d-none");
    });
  });
  $("#change-photo").on("click", function () {
    $("#profile-img").click().on("change", function () {
      var _this$files = _slicedToArray(this.files, 1),
          file = _this$files[0];

      if (file) {
        $("#preview-thumbnail").attr("src", URL.createObjectURL(file));
        $(".reset-thumbnail").removeClass("d-none");
      }
    });
  });
  $(".reset-thumbnail").on("click", function () {
    $("#profile-img").val('');

    $("#preview-thumbnail").attr("src", $('#image-url').val());
    $(".reset-thumbnail").addClass("d-none");
  });
  $('.current-year').text(new Date().getFullYear());
});
})();

/******/ })()
;
