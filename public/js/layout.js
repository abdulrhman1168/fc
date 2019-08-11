/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a New module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 45);
/******/ })
/************************************************************************/
/******/ ({

/***/ 45:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(46);
__webpack_require__(47);
__webpack_require__(48);
__webpack_require__(49);
__webpack_require__(50);
module.exports = __webpack_require__(51);


/***/ }),

/***/ 46:
/***/ (function(module, exports) {

var App = function () {
  var t,
      e = !1,
      o = !1,
      a = !1,
      i = !1,
      n = [],
      l = "../assets/",
      s = "global/img/",
      r = "global/plugins/",
      c = "global/css/",
      d = { blue: "#89C4F4", red: "#F3565D", green: "#1bbc9b", purple: "#9b59b6", grey: "#95a5a6", yellow: "#F8CB00" },
      p = function p() {
    "rtl" === $("body").css("direction") && (e = !0), o = !!navigator.userAgent.match(/MSIE 8.0/), a = !!navigator.userAgent.match(/MSIE 9.0/), i = !!navigator.userAgent.match(/MSIE 10.0/), i && $("html").addClass("ie10"), (i || a || o) && $("html").addClass("ie");
  },
      h = function h() {
    for (var t = 0; t < n.length; t++) {
      var e = n[t];e.call();
    }
  },
      u = function u() {
    var t,
        e = $(window).width();if (o) {
      var a;$(window).resize(function () {
        a != document.documentElement.clientHeight && (t && clearTimeout(t), t = setTimeout(function () {
          h();
        }, 50), a = document.documentElement.clientHeight);
      });
    } else $(window).resize(function () {
      $(window).width() != e && (e = $(window).width(), t && clearTimeout(t), t = setTimeout(function () {
        h();
      }, 50));
    });
  },
      f = function f() {
    $("body").on("click", ".portlet > .portlet-title > .tools > a.remove", function (t) {
      t.preventDefault();var e = $(this).closest(".portlet");$("body").hasClass("page-portlet-fullscreen") && $("body").removeClass("page-portlet-fullscreen"), e.find(".portlet-title .fullscreen").tooltip("destroy"), e.find(".portlet-title > .tools > .reload").tooltip("destroy"), e.find(".portlet-title > .tools > .remove").tooltip("destroy"), e.find(".portlet-title > .tools > .config").tooltip("destroy"), e.find(".portlet-title > .tools > .collapse, .portlet > .portlet-title > .tools > .expand").tooltip("destroy"), e.remove();
    }), $("body").on("click", ".portlet > .portlet-title .fullscreen", function (t) {
      t.preventDefault();var e = $(this).closest(".portlet");if (e.hasClass("portlet-fullscreen")) $(this).removeClass("on"), e.removeClass("portlet-fullscreen"), $("body").removeClass("page-portlet-fullscreen"), e.children(".portlet-body").css("height", "auto");else {
        var o = App.getViewPort().height - e.children(".portlet-title").outerHeight() - parseInt(e.children(".portlet-body").css("padding-top")) - parseInt(e.children(".portlet-body").css("padding-bottom"));$(this).addClass("on"), e.addClass("portlet-fullscreen"), $("body").addClass("page-portlet-fullscreen"), e.children(".portlet-body").css("height", o);
      }
    }), $("body").on("click", ".portlet > .portlet-title > .tools > a.reload", function (t) {
      t.preventDefault();var e = $(this).closest(".portlet").children(".portlet-body"),
          o = $(this).attr("data-url"),
          a = $(this).attr("data-error-display");o ? (App.blockUI({ target: e, animate: !0, overlayColor: "none" }), $.ajax({ type: "GET", cache: !1, url: o, dataType: "html", success: function success(t) {
          App.unblockUI(e), e.html(t), App.initAjax();
        }, error: function error(t, o, i) {
          App.unblockUI(e);var n = "Error on reloading the content. Please check your connection and try again.";"toastr" == a && toastr ? toastr.error(n) : "notific8" == a && $.notific8 ? ($.notific8("zindex", 11500), $.notific8(n, { theme: "ruby", life: 3e3 })) : alert(n);
        } })) : (App.blockUI({ target: e, animate: !0, overlayColor: "none" }), window.setTimeout(function () {
        App.unblockUI(e);
      }, 1e3));
    }), $('.portlet .portlet-title a.reload[data-load="true"]').click(), $("body").on("click", ".portlet > .portlet-title > .tools > .collapse, .portlet .portlet-title > .tools > .expand", function (t) {
      t.preventDefault();var e = $(this).closest(".portlet").children(".portlet-body");$(this).hasClass("collapse") ? ($(this).removeClass("collapse").addClass("expand"), e.slideUp(200)) : ($(this).removeClass("expand").addClass("collapse"), e.slideDown(200));
    });
  },
      b = function b() {
    if ($("body").on("click", ".md-checkbox > label, .md-radio > label", function () {
      var t = $(this),
          e = $(this).children("span:first-child");e.addClass("inc");var o = e.clone(!0);e.before(o), $("." + e.attr("class") + ":last", t).remove();
    }), $("body").hasClass("page-md")) {
      var t, e, o, a, i;$("body").on("click", "a.btn, button.btn, input.btn, label.btn", function (n) {
        t = $(this), 0 == t.find(".md-click-circle").length && t.prepend("<span class='md-click-circle'></span>"), e = t.find(".md-click-circle"), e.removeClass("md-click-animate"), e.height() || e.width() || (o = Math.max(t.outerWidth(), t.outerHeight()), e.css({ height: o, width: o })), a = n.pageX - t.offset().left - e.width() / 2, i = n.pageY - t.offset().top - e.height() / 2, e.css({ top: i + "px", left: a + "px" }).addClass("md-click-animate"), setTimeout(function () {
          e.remove();
        }, 1e3);
      });
    }var n = function n(t) {
      "" != t.val() ? t.addClass("edited") : t.removeClass("edited");
    };$("body").on("keydown", ".form-md-floating-label .form-control", function (t) {
      n($(this));
    }), $("body").on("blur", ".form-md-floating-label .form-control", function (t) {
      n($(this));
    }), $(".form-md-floating-label .form-control").each(function () {
      $(this).val().length > 0 && $(this).addClass("edited");
    });
  },
      g = function g() {
    $().iCheck && $(".icheck").each(function () {
      var t = $(this).attr("data-checkbox") ? $(this).attr("data-checkbox") : "icheckbox_minimal-grey",
          e = $(this).attr("data-radio") ? $(this).attr("data-radio") : "iradio_minimal-grey";t.indexOf("_line") > -1 || e.indexOf("_line") > -1 ? $(this).iCheck({ checkboxClass: t, radioClass: e, insert: '<div class="icheck_line-icon"></div>' + $(this).attr("data-label") }) : $(this).iCheck({ checkboxClass: t, radioClass: e });
    });
  },
      m = function m() {
    $().bootstrapSwitch && $(".make-switch").bootstrapSwitch();
  },
      v = function v() {
    $().confirmation && $("[data-toggle=confirmation]").confirmation({ btnOkClass: "btn btn-sm btn-success", btnCancelClass: "btn btn-sm btn-danger" });
  },
      y = function y() {
    $("body").on("shown.bs.collapse", ".accordion.scrollable", function (t) {
      App.scrollTo($(t.target));
    });
  },
      C = function C() {
    if (encodeURI(location.hash)) {
      var t = encodeURI(location.hash.substr(1));$('a[href="#' + t + '"]').parents(".tab-pane:hidden").each(function () {
        var t = $(this).attr("id");$('a[href="#' + t + '"]').click();
      }), $('a[href="#' + t + '"]').click();
    }$().tabdrop && $(".tabbable-tabdrop .nav-pills, .tabbable-tabdrop .nav-tabs").tabdrop({ text: '<i class="fa fa-ellipsis-v"></i>&nbsp;<i class="fa fa-angle-down"></i>' });
  },
      w = function w() {
    $("body").on("hide.bs.modal", function () {
      $(".modal:visible").size() > 1 && $("html").hasClass("modal-open") === !1 ? $("html").addClass("modal-open") : $(".modal:visible").size() <= 1 && $("html").removeClass("modal-open");
    }), $("body").on("show.bs.modal", ".modal", function () {
      $(this).hasClass("modal-scroll") && $("body").addClass("modal-open-noscroll");
    }), $("body").on("hidden.bs.modal", ".modal", function () {
      $("body").removeClass("modal-open-noscroll");
    }), $("body").on("hidden.bs.modal", ".modal:not(.modal-cached)", function () {
      $(this).removeData("bs.modal");
    });
  },
      x = function x() {
    $(".tooltips").tooltip(), $(".portlet > .portlet-title .fullscreen").tooltip({ trigger: "hover", container: "body", title: "Fullscreen" }), $(".portlet > .portlet-title > .tools > .reload").tooltip({ trigger: "hover", container: "body", title: "Reload" }), $(".portlet > .portlet-title > .tools > .remove").tooltip({ trigger: "hover", container: "body", title: "Remove" }), $(".portlet > .portlet-title > .tools > .config").tooltip({ trigger: "hover", container: "body", title: "Settings" }), $(".portlet > .portlet-title > .tools > .collapse, .portlet > .portlet-title > .tools > .expand").tooltip({ trigger: "hover", container: "body", title: "Collapse/Expand" });
  },
      k = function k() {
    $("body").on("click", ".dropdown-menu.hold-on-click", function (t) {
      t.stopPropagation();
    });
  },
      I = function I() {
    $("body").on("click", '[data-close="alert"]', function (t) {
      $(this).parent(".alert").hide(), $(this).closest(".note").hide(), t.preventDefault();
    }), $("body").on("click", '[data-close="note"]', function (t) {
      $(this).closest(".note").hide(), t.preventDefault();
    }), $("body").on("click", '[data-remove="note"]', function (t) {
      $(this).closest(".note").remove(), t.preventDefault();
    });
  },
      A = function A() {
    "function" == typeof autosize && autosize(document.querySelectorAll("textarea.autosizeme"));
  },
      S = function S() {
    $(".popovers").popover(), $(document).on("click.bs.popover.data-api", function (e) {
      t && t.popover("hide");
    });
  },
      z = function z() {
    App.initSlimScroll(".scroller");
  },
      P = function P() {
    jQuery.fancybox && $(".fancybox-button").size() > 0 && $(".fancybox-button").fancybox({ groupAttr: "data-rel", prevEffect: "none", nextEffect: "none", closeBtn: !0, helpers: { title: { type: "inside" } } });
  },
      T = function T() {
    $().counterUp && $("[data-counter='counterup']").counterUp({ delay: 10, time: 1e3 });
  },
      D = function D() {
    (o || a) && $("input[placeholder]:not(.placeholder-no-fix), textarea[placeholder]:not(.placeholder-no-fix)").each(function () {
      var t = $(this);"" === t.val() && "" !== t.attr("placeholder") && t.addClass("placeholder").val(t.attr("placeholder")), t.focus(function () {
        t.val() == t.attr("placeholder") && t.val("");
      }), t.blur(function () {
        "" !== t.val() && t.val() != t.attr("placeholder") || t.val(t.attr("placeholder"));
      });
    });
  },
      U = function U() {
    $().select2 && ($.fn.select2.defaults.set("theme", "bootstrap"), $(".select2me").select2({ placeholder: "Select", width: "auto", allowClear: !0 }));
  },
      E = function E() {
    $("[data-auto-height]").each(function () {
      var t = $(this),
          e = $("[data-height]", t),
          o = 0,
          a = t.attr("data-mode"),
          i = parseInt(t.attr("data-offset") ? t.attr("data-offset") : 0);e.each(function () {
        "height" == $(this).attr("data-height") ? $(this).css("height", "") : $(this).css("min-height", "");var t = "base-height" == a ? $(this).outerHeight() : $(this).outerHeight(!0);t > o && (o = t);
      }), o += i, e.each(function () {
        "height" == $(this).attr("data-height") ? $(this).css("height", o) : $(this).css("min-height", o);
      }), t.attr("data-related") && $(t.attr("data-related")).css("height", t.height());
    });
  };return { init: function init() {
      p(), u(), b(), g(), m(), z(), P(), U(), f(), I(), k(), C(), x(), S(), y(), w(), v(), A(), T(), this.addResizeHandler(E), D();
    }, initAjax: function initAjax() {
      g(), m(), z(), U(), P(), k(), x(), S(), y(), v();
    }, initComponents: function initComponents() {
      this.initAjax();
    }, setLastPopedPopover: function setLastPopedPopover(e) {
      t = e;
    }, addResizeHandler: function addResizeHandler(t) {
      n.push(t);
    }, runResizeHandlers: function runResizeHandlers() {
      h();
    }, scrollTo: function scrollTo(t, e) {
      var o = t && t.size() > 0 ? t.offset().top : 0;t && ($("body").hasClass("page-header-fixed") ? o -= $(".page-header").height() : $("body").hasClass("page-header-top-fixed") ? o -= $(".page-header-top").height() : $("body").hasClass("page-header-menu-fixed") && (o -= $(".page-header-menu").height()), o += e ? e : -1 * t.height()), $("html,body").animate({ scrollTop: o }, "slow");
    }, initSlimScroll: function initSlimScroll(t) {
      $().slimScroll && $(t).each(function () {
        if (!$(this).attr("data-initialized")) {
          var t;t = $(this).attr("data-height") ? $(this).attr("data-height") : $(this).css("height"), $(this).slimScroll({ allowPageScroll: !0, size: "7px", color: $(this).attr("data-handle-color") ? $(this).attr("data-handle-color") : "#bbb", wrapperClass: $(this).attr("data-wrapper-class") ? $(this).attr("data-wrapper-class") : "slimScrollDiv", railColor: $(this).attr("data-rail-color") ? $(this).attr("data-rail-color") : "#eaeaea", position: e ? "left" : "right", height: t, alwaysVisible: "1" == $(this).attr("data-always-visible"), railVisible: "1" == $(this).attr("data-rail-visible"), disableFadeOut: !0 }), $(this).attr("data-initialized", "1");
        }
      });
    }, destroySlimScroll: function destroySlimScroll(t) {
      $().slimScroll && $(t).each(function () {
        if ("1" === $(this).attr("data-initialized")) {
          $(this).removeAttr("data-initialized"), $(this).removeAttr("style");var t = {};$(this).attr("data-handle-color") && (t["data-handle-color"] = $(this).attr("data-handle-color")), $(this).attr("data-wrapper-class") && (t["data-wrapper-class"] = $(this).attr("data-wrapper-class")), $(this).attr("data-rail-color") && (t["data-rail-color"] = $(this).attr("data-rail-color")), $(this).attr("data-always-visible") && (t["data-always-visible"] = $(this).attr("data-always-visible")), $(this).attr("data-rail-visible") && (t["data-rail-visible"] = $(this).attr("data-rail-visible")), $(this).slimScroll({ wrapperClass: $(this).attr("data-wrapper-class") ? $(this).attr("data-wrapper-class") : "slimScrollDiv", destroy: !0 });var e = $(this);$.each(t, function (t, o) {
            e.attr(t, o);
          });
        }
      });
    }, scrollTop: function scrollTop() {
      App.scrollTo();
    }, blockUI: function blockUI(t) {
      t = $.extend(!0, {}, t);var e = "";if (e = t.animate ? '<div class="loading-message ' + (t.boxed ? "loading-message-boxed" : "") + '"><div class="block-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>' : t.iconOnly ? '<div class="loading-message ' + (t.boxed ? "loading-message-boxed" : "") + '"><img src="' + this.getGlobalImgPath() + 'loading-spinner-grey.gif" align=""></div>' : t.textOnly ? '<div class="loading-message ' + (t.boxed ? "loading-message-boxed" : "") + '"><span>&nbsp;&nbsp;' + (t.message ? t.message : "LOADING...") + "</span></div>" : '<div class="loading-message ' + (t.boxed ? "loading-message-boxed" : "") + '"><img src="' + this.getGlobalImgPath() + 'loading-spinner-grey.gif" align=""><span>&nbsp;&nbsp;' + (t.message ? t.message : "LOADING...") + "</span></div>", t.target) {
        var o = $(t.target);o.height() <= $(window).height() && (t.cenrerY = !0), o.block({ message: e, baseZ: t.zIndex ? t.zIndex : 1e3, centerY: void 0 !== t.cenrerY && t.cenrerY, css: { top: "10%", border: "0", padding: "0", backgroundColor: "none" }, overlayCSS: { backgroundColor: t.overlayColor ? t.overlayColor : "#555", opacity: t.boxed ? .05 : .1, cursor: "wait" } });
      } else $.blockUI({ message: e, baseZ: t.zIndex ? t.zIndex : 1e3, css: { border: "0", padding: "0", backgroundColor: "none" }, overlayCSS: { backgroundColor: t.overlayColor ? t.overlayColor : "#555", opacity: t.boxed ? .05 : .1, cursor: "wait" } });
    }, unblockUI: function unblockUI(t) {
      t ? $(t).unblock({ onUnblock: function onUnblock() {
          $(t).css("position", ""), $(t).css("zoom", "");
        } }) : $.unblockUI();
    }, startPageLoading: function startPageLoading(t) {
      t && t.animate ? ($(".page-spinner-bar").remove(), $("body").append('<div class="page-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>')) : ($(".page-loading").remove(), $("body").append('<div class="page-loading"><img src="' + this.getGlobalImgPath() + 'loading-spinner-grey.gif"/>&nbsp;&nbsp;<span>' + (t && t.message ? t.message : "Loading...") + "</span></div>"));
    }, stopPageLoading: function stopPageLoading() {
      $(".page-loading, .page-spinner-bar").remove();
    }, alert: function alert(t) {
      t = $.extend(!0, { container: "", place: "append", type: "success", message: "", close: !0, reset: !0, focus: !0, closeInSeconds: 0, icon: "" }, t);var e = App.getUniqueID("App_alert"),
          o = '<div id="' + e + '" class="custom-alerts alert alert-' + t.type + ' fade in">' + (t.close ? '<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>' : "") + ("" !== t.icon ? '<i class="fa-lg fa fa-' + t.icon + '"></i>  ' : "") + t.message + "</div>";return t.reset && $(".custom-alerts").remove(), t.container ? "append" == t.place ? $(t.container).append(o) : $(t.container).prepend(o) : 1 === $(".page-fixed-main-content").size() ? $(".page-fixed-main-content").prepend(o) : ($("body").hasClass("page-container-bg-solid") || $("body").hasClass("page-content-white")) && 0 === $(".page-head").size() ? $(".page-title").after(o) : $(".page-bar").size() > 0 ? $(".page-bar").after(o) : $(".page-breadcrumb, .breadcrumbs").after(o), t.focus && App.scrollTo($("#" + e)), t.closeInSeconds > 0 && setTimeout(function () {
        $("#" + e).remove();
      }, 1e3 * t.closeInSeconds), e;
    }, initFancybox: function initFancybox() {
      P();
    }, getActualVal: function getActualVal(t) {
      return t = $(t), t.val() === t.attr("placeholder") ? "" : t.val();
    }, getURLParameter: function getURLParameter(t) {
      var e,
          o,
          a = window.location.search.substring(1),
          i = a.split("&");for (e = 0; e < i.length; e++) {
        if (o = i[e].split("="), o[0] == t) return unescape(o[1]);
      }return null;
    }, isTouchDevice: function isTouchDevice() {
      try {
        return document.createEvent("TouchEvent"), !0;
      } catch (t) {
        return !1;
      }
    }, getViewPort: function getViewPort() {
      var t = window,
          e = "inner";return "innerWidth" in window || (e = "client", t = document.documentElement || document.body), { width: t[e + "Width"], height: t[e + "Height"] };
    }, getUniqueID: function getUniqueID(t) {
      return "prefix_" + Math.floor(Math.random() * new Date().getTime());
    }, isIE8: function isIE8() {
      return o;
    }, isIE9: function isIE9() {
      return a;
    }, isRTL: function isRTL() {
      return e;
    }, isAngularJsApp: function isAngularJsApp() {
      return "undefined" != typeof angular;
    }, getAssetsPath: function getAssetsPath() {
      return l;
    }, setAssetsPath: function setAssetsPath(t) {
      l = t;
    }, setGlobalImgPath: function setGlobalImgPath(t) {
      s = t;
    }, getGlobalImgPath: function getGlobalImgPath() {
      return l + s;
    }, setGlobalPluginsPath: function setGlobalPluginsPath(t) {
      r = t;
    }, getGlobalPluginsPath: function getGlobalPluginsPath() {
      return l + r;
    }, getGlobalCssPath: function getGlobalCssPath() {
      return l + c;
    }, getBrandColor: function getBrandColor(t) {
      return d[t] ? d[t] : "";
    }, getResponsiveBreakpoint: function getResponsiveBreakpoint(t) {
      var e = { xs: 480, sm: 768, md: 992, lg: 1200 };return e[t] ? e[t] : 0;
    } };
}();jQuery(document).ready(function () {
  App.init();
});

/***/ }),

/***/ 47:
/***/ (function(module, exports) {

var Dashboard = function () {
  return { initJQVMAP: function initJQVMAP() {
      if (jQuery().vectorMap) {
        var e = function e(_e) {
          jQuery(".vmaps").hide(), jQuery("#vmap_" + _e).show();
        },
            t = function t(e) {
          var t = jQuery("#vmap_" + e);if (1 === t.size()) {
            var a = { map: "world_en", backgroundColor: null, borderColor: "#333333", borderOpacity: .5, borderWidth: 1, color: "#c6c6c6", enableZoom: !0, hoverColor: "#c9dfaf", hoverOpacity: null, values: sample_data, normalizeFunction: "linear", scaleColors: ["#b6da93", "#909cae"], selectedColor: "#c9dfaf", selectedRegion: null, showTooltip: !0, onLabelShow: function onLabelShow(e, t, a) {}, onRegionOver: function onRegionOver(e, t) {
                "ca" == t && e.preventDefault();
              }, onRegionClick: function onRegionClick(e, t, a) {
                var i = 'You clicked "' + a + '" which has the code: ' + t.toUpperCase();alert(i);
              } };a.map = e + "_en", t.width(t.parent().parent().width()), t.show(), t.vectorMap(a), t.hide();
          }
        };t("world"), t("usa"), t("europe"), t("russia"), t("germany"), e("world"), jQuery("#regional_stat_world").click(function () {
          e("world");
        }), jQuery("#regional_stat_usa").click(function () {
          e("usa");
        }), jQuery("#regional_stat_europe").click(function () {
          e("europe");
        }), jQuery("#regional_stat_russia").click(function () {
          e("russia");
        }), jQuery("#regional_stat_germany").click(function () {
          e("germany");
        }), $("#region_statistics_loading").hide(), $("#region_statistics_content").show(), App.addResizeHandler(function () {
          jQuery(".vmaps").each(function () {
            var e = jQuery(this);e.width(e.parent().width());
          });
        });
      }
    }, initCalendar: function initCalendar() {
      if (jQuery().fullCalendar) {
        var e = new Date(),
            t = e.getDate(),
            a = e.getMonth(),
            i = e.getFullYear(),
            l = {};$("#calendar").width() <= 400 ? ($("#calendar").addClass("mobile"), l = { left: "title, prev, next", center: "", right: "today,month,agendaWeek,agendaDay" }) : ($("#calendar").removeClass("mobile"), l = App.isRTL() ? { right: "title", center: "", left: "prev,next,today,month,agendaWeek,agendaDay" } : { left: "title", center: "", right: "prev,next,today,month,agendaWeek,agendaDay" }), $("#calendar").fullCalendar("destroy"), $("#calendar").fullCalendar({ disableDragging: !1, header: l, editable: !0, events: [{ title: "All Day", start: new Date(i, a, 1), backgroundColor: App.getBrandColor("yellow") }, { title: "Long Event", start: new Date(i, a, t - 5), end: new Date(i, a, t - 2), backgroundColor: App.getBrandColor("blue") }, { title: "Repeating Event", start: new Date(i, a, t - 3, 16, 0), allDay: !1, backgroundColor: App.getBrandColor("red") }, { title: "Repeating Event", start: new Date(i, a, t + 6, 16, 0), allDay: !1, backgroundColor: App.getBrandColor("green") }, { title: "Meeting", start: new Date(i, a, t + 9, 10, 30), allDay: !1 }, { title: "Lunch", start: new Date(i, a, t, 14, 0), end: new Date(i, a, t, 14, 0), backgroundColor: App.getBrandColor("grey"), allDay: !1 }, { title: "Birthday", start: new Date(i, a, t + 1, 19, 0), end: new Date(i, a, t + 1, 22, 30), backgroundColor: App.getBrandColor("purple"), allDay: !1 }, { title: "Click for Google", start: new Date(i, a, 28), end: new Date(i, a, 29), backgroundColor: App.getBrandColor("yellow"), url: "http://google.com/" }] });
      }
    }, initCharts: function initCharts() {
      function e(e, t, a, i) {
        $('<div id="tooltip" class="chart-tooltip">' + i + "</div>").css({ position: "absolute", display: "none", top: t - 40, left: e - 40, border: "0px solid #ccc", padding: "2px 6px", "background-color": "#fff" }).appendTo("body").fadeIn(200);
      }if (jQuery.plot) {
        var t = [["02/2013", 1500], ["03/2013", 2500], ["04/2013", 1700], ["05/2013", 800], ["06/2013", 1500], ["07/2013", 2350], ["08/2013", 1500], ["09/2013", 1300], ["10/2013", 4600]];if (0 != $("#site_statistics").size()) {
          $("#site_statistics_loading").hide(), $("#site_statistics_content").show();var a = ($.plot($("#site_statistics"), [{ data: t, lines: { fill: .6, lineWidth: 0 }, color: ["#f89f9f"] }, { data: t, points: { show: !0, fill: !0, radius: 5, fillColor: "#f89f9f", lineWidth: 3 }, color: "#fff", shadowSize: 0 }], { xaxis: { tickLength: 0, tickDecimals: 0, mode: "categories", min: 0, font: { lineHeight: 14, style: "normal", variant: "small-caps", color: "#6F7B8A" } }, yaxis: { ticks: 5, tickDecimals: 0, tickColor: "#eee", font: { lineHeight: 14, style: "normal", variant: "small-caps", color: "#6F7B8A" } }, grid: { hoverable: !0, clickable: !0, tickColor: "#eee", borderColor: "#eee", borderWidth: 1 } }), null);$("#site_statistics").bind("plothover", function (t, i, l) {
            if ($("#x").text(i.x.toFixed(2)), $("#y").text(i.y.toFixed(2)), l) {
              if (a != l.dataIndex) {
                a = l.dataIndex, $("#tooltip").remove();l.datapoint[0].toFixed(2), l.datapoint[1].toFixed(2);e(l.pageX, l.pageY, l.datapoint[0], l.datapoint[1] + " visits");
              }
            } else $("#tooltip").remove(), a = null;
          });
        }if (0 != $("#site_activities").size()) {
          var i = null;$("#site_activities_loading").hide(), $("#site_activities_content").show();var l = [["DEC", 300], ["JAN", 600], ["FEB", 1100], ["MAR", 1200], ["APR", 860], ["MAY", 1200], ["JUN", 1450], ["JUL", 1800], ["AUG", 1200], ["SEP", 600]];$.plot($("#site_activities"), [{ data: l, lines: { fill: .2, lineWidth: 0 }, color: ["#BAD9F5"] }, { data: l, points: { show: !0, fill: !0, radius: 4, fillColor: "#9ACAE6", lineWidth: 2 }, color: "#9ACAE6", shadowSize: 1 }, { data: l, lines: { show: !0, fill: !1, lineWidth: 3 }, color: "#9ACAE6", shadowSize: 0 }], { xaxis: { tickLength: 0, tickDecimals: 0, mode: "categories", min: 0, font: { lineHeight: 18, style: "normal", variant: "small-caps", color: "#6F7B8A" } }, yaxis: { ticks: 5, tickDecimals: 0, tickColor: "#eee", font: { lineHeight: 14, style: "normal", variant: "small-caps", color: "#6F7B8A" } }, grid: { hoverable: !0, clickable: !0, tickColor: "#eee", borderColor: "#eee", borderWidth: 1 } });$("#site_activities").bind("plothover", function (t, a, l) {
            if ($("#x").text(a.x.toFixed(2)), $("#y").text(a.y.toFixed(2)), l && i != l.dataIndex) {
              i = l.dataIndex, $("#tooltip").remove();l.datapoint[0].toFixed(2), l.datapoint[1].toFixed(2);e(l.pageX, l.pageY, l.datapoint[0], l.datapoint[1] + "M$");
            }
          }), $("#site_activities").bind("mouseleave", function () {
            $("#tooltip").remove();
          });
        }
      }
    }, initEasyPieCharts: function initEasyPieCharts() {
      jQuery().easyPieChart && ($(".easy-pie-chart .number.transactions").easyPieChart({ animate: 1e3, size: 75, lineWidth: 3, barColor: App.getBrandColor("yellow") }), $(".easy-pie-chart .number.visits").easyPieChart({ animate: 1e3, size: 75, lineWidth: 3, barColor: App.getBrandColor("green") }), $(".easy-pie-chart .number.bounce").easyPieChart({ animate: 1e3, size: 75, lineWidth: 3, barColor: App.getBrandColor("red") }), $(".easy-pie-chart-reload").click(function () {
        $(".easy-pie-chart .number").each(function () {
          var e = Math.floor(100 * Math.random());$(this).data("easyPieChart").update(e), $("span", this).text(e);
        });
      }));
    }, initSparklineCharts: function initSparklineCharts() {
      jQuery().sparkline && ($("#sparkline_bar").sparkline([8, 9, 10, 11, 10, 10, 12, 10, 10, 11, 9, 12, 11, 10, 9, 11, 13, 13, 12], { type: "bar", width: "100", barWidth: 5, height: "55", barColor: "#f36a5b", negBarColor: "#e02222" }), $("#sparkline_bar2").sparkline([9, 11, 12, 13, 12, 13, 10, 14, 13, 11, 11, 12, 11, 11, 10, 12, 11, 10], { type: "bar", width: "100", barWidth: 5, height: "55", barColor: "#5c9bd1", negBarColor: "#e02222" }), $("#sparkline_bar5").sparkline([8, 9, 10, 11, 10, 10, 12, 10, 10, 11, 9, 12, 11, 10, 9, 11, 13, 13, 12], { type: "bar", width: "100", barWidth: 5, height: "55", barColor: "#35aa47", negBarColor: "#e02222" }), $("#sparkline_bar6").sparkline([9, 11, 12, 13, 12, 13, 10, 14, 13, 11, 11, 12, 11, 11, 10, 12, 11, 10], { type: "bar", width: "100", barWidth: 5, height: "55", barColor: "#ffb848", negBarColor: "#e02222" }), $("#sparkline_line").sparkline([9, 10, 9, 10, 10, 11, 12, 10, 10, 11, 11, 12, 11, 10, 12, 11, 10, 12], { type: "line", width: "100", height: "55", lineColor: "#ffb848" }));
    }, initMorisCharts: function initMorisCharts() {
      Morris.EventEmitter && $("#sales_statistics").size() > 0 && (dashboardMainChart = Morris.Area({ element: "sales_statistics", padding: 0, behaveLikeLine: !1, gridEnabled: !1, gridLineColor: !1, axes: !1, fillOpacity: 1, data: [{ period: "2011 Q1", sales: 1400, profit: 400 }, { period: "2011 Q2", sales: 1100, profit: 600 }, { period: "2011 Q3", sales: 1600, profit: 500 }, { period: "2011 Q4", sales: 1200, profit: 400 }, { period: "2012 Q1", sales: 1550, profit: 800 }], lineColors: ["#399a8c", "#92e9dc"], xkey: "period", ykeys: ["sales", "profit"], labels: ["Sales", "Profit"], pointSize: 0, lineWidth: 0, hideHover: "auto", resize: !0 }));
    }, initChat: function initChat() {
      var e = $("#chats"),
          t = $(".chats", e),
          a = $(".chat-form", e),
          i = $("input", a),
          l = $(".btn", a),
          o = function o(a) {
        a.preventDefault();var l = i.val();if (0 != l.length) {
          var o = new Date(),
              n = o.getHours() + ":" + o.getMinutes(),
              r = "";r += '<li class="out">', r += '<img class="avatar" alt="" src="' + Layout.getLayoutImgPath() + 'avatar1.jpg"/>', r += '<div class="message">', r += '<span class="arrow"></span>', r += '<a href="#" class="name">Bob Nilson</a>&nbsp;', r += '<span class="datetime">at ' + n + "</span>", r += '<span class="body">', r += l, r += "</span>", r += "</div>", r += "</li>";t.append(r);i.val("");var s = function s() {
            var t = 0;return e.find("li.out, li.in").each(function () {
              t += $(this).outerHeight();
            }), t;
          };e.find(".scroller").slimScroll({ scrollTo: s() });
        }
      };$("body").on("click", ".message .name", function (e) {
        e.preventDefault();var t = $(this).text();i.val("@" + t + ":"), App.scrollTo(i);
      }), l.click(o), i.keypress(function (e) {
        if (13 == e.which) return o(e), !1;
      });
    }, initDashboardDaterange: function initDashboardDaterange() {
      jQuery().daterangepicker && ($("#dashboard-report-range").daterangepicker({ ranges: { Today: [moment(), moment()], Yesterday: [moment().subtract("days", 1), moment().subtract("days", 1)], "Last 7 Days": [moment().subtract("days", 6), moment()], "Last 30 Days": [moment().subtract("days", 29), moment()], "This Month": [moment().startOf("month"), moment().endOf("month")], "Last Month": [moment().subtract("month", 1).startOf("month"), moment().subtract("month", 1).endOf("month")] }, locale: { format: "MM/DD/YYYY", separator: " - ", applyLabel: "Apply", cancelLabel: "Cancel", fromLabel: "From", toLabel: "To", customRangeLabel: "Custom", daysOfWeek: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"], monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"], firstDay: 1 }, opens: App.isRTL() ? "right" : "left" }, function (e, t, a) {
        "0" != $("#dashboard-report-range").attr("data-display-range") && $("#dashboard-report-range span").html(e.format("MMMM D, YYYY") + " - " + t.format("MMMM D, YYYY"));
      }), "0" != $("#dashboard-report-range").attr("data-display-range") && $("#dashboard-report-range span").html(moment().subtract("days", 29).format("MMMM D, YYYY") + " - " + moment().format("MMMM D, YYYY")), $("#dashboard-report-range").show());
    }, initAmChart1: function initAmChart1() {
      if ("undefined" != typeof AmCharts && 0 !== $("#dashboard_amchart_1").size()) {
        var e = [{ date: "2012-01-05", distance: 480, townName: "Miami", townName2: "Miami", townSize: 10, latitude: 25.83, duration: 501 }, { date: "2012-01-06", distance: 386, townName: "Tallahassee", townSize: 7, latitude: 30.46, duration: 443 }, { date: "2012-01-07", distance: 348, townName: "New Orleans", townSize: 10, latitude: 29.94, duration: 405 }, { date: "2012-01-08", distance: 238, townName: "Houston", townName2: "Houston", townSize: 16, latitude: 29.76, duration: 309 }, { date: "2012-01-09", distance: 218, townName: "Dalas", townSize: 17, latitude: 32.8, duration: 287 }, { date: "2012-01-10", distance: 349, townName: "Oklahoma City", townSize: 11, latitude: 35.49, duration: 485 }, { date: "2012-01-11", distance: 603, townName: "Kansas City", townSize: 10, latitude: 39.1, duration: 890 }, { date: "2012-01-12", distance: 534, townName: "Denver", townName2: "Denver", townSize: 18, latitude: 39.74, duration: 810 }, { date: "2012-01-13", townName: "Salt Lake City", townSize: 12, distance: 425, duration: 670, latitude: 40.75, alpha: .4 }, { date: "2012-01-14", latitude: 36.1, duration: 470, townName: "Las Vegas", townName2: "Las Vegas", bulletClass: "lastBullet" }, { date: "2012-01-15" }];AmCharts.makeChart("dashboard_amchart_1", { type: "serial", fontSize: 12, fontFamily: "Open Sans", dataDateFormat: "YYYY-MM-DD", dataProvider: e, addClassNames: !0, startDuration: 1, color: "#6c7b88", marginLeft: 0, categoryField: "date", categoryAxis: { parseDates: !0, minPeriod: "DD", autoGridCount: !1, gridCount: 50, gridAlpha: .1, gridColor: "#FFFFFF", axisColor: "#555555", dateFormats: [{ period: "DD", format: "DD" }, { period: "WW", format: "MMM DD" }, { period: "MM", format: "MMM" }, { period: "YYYY", format: "YYYY" }] }, valueAxes: [{ id: "a1", title: "distance", gridAlpha: 0, axisAlpha: 0 }, { id: "a2", position: "right", gridAlpha: 0, axisAlpha: 0, labelsEnabled: !1 }, { id: "a3", title: "duration", position: "right", gridAlpha: 0, axisAlpha: 0, inside: !0, duration: "mm", durationUnits: { DD: "d. ", hh: "h ", mm: "min", ss: "" } }], graphs: [{ id: "g1", valueField: "distance", title: "distance", type: "column", fillAlphas: .7, valueAxis: "a1", balloonText: "[[value]] miles", legendValueText: "[[value]] mi", legendPeriodValueText: "total: [[value.sum]] mi", lineColor: "#08a3cc", alphaField: "alpha" }, { id: "g2", valueField: "latitude", classNameField: "bulletClass", title: "latitude/city", type: "line", valueAxis: "a2", lineColor: "#786c56", lineThickness: 1, legendValueText: "[[description]]/[[value]]", descriptionField: "townName", bullet: "round", bulletSizeField: "townSize", bulletBorderColor: "#02617a", bulletBorderAlpha: 1, bulletBorderThickness: 2, bulletColor: "#89c4f4", labelText: "[[townName2]]", labelPosition: "right", balloonText: "latitude:[[value]]", showBalloon: !0, animationPlayed: !0 }, { id: "g3", title: "duration", valueField: "duration", type: "line", valueAxis: "a3", lineAlpha: .8, lineColor: "#e26a6a", balloonText: "[[value]]", lineThickness: 1, legendValueText: "[[value]]", bullet: "square", bulletBorderColor: "#e26a6a", bulletBorderThickness: 1, bulletBorderAlpha: .8, dashLengthField: "dashLength", animationPlayed: !0 }], chartCursor: { zoomable: !1, categoryBalloonDateFormat: "DD", cursorAlpha: 0, categoryBalloonColor: "#e26a6a", categoryBalloonAlpha: .8, valueBalloonsEnabled: !1 }, legend: { bulletType: "round", equalWidths: !1, valueWidth: 120, useGraphSettings: !0, color: "#6c7b88" } });
      }
    }, initAmChart2: function initAmChart2() {
      if ("undefined" != typeof AmCharts && 0 !== $("#dashboard_amchart_2").size()) {
        var e = "M9,0C4.029,0,0,4.029,0,9s4.029,9,9,9s9-4.029,9-9S13.971,0,9,0z M9,15.93 c-3.83,0-6.93-3.1-6.93-6.93S5.17,2.07,9,2.07s6.93,3.1,6.93,6.93S12.83,15.93,9,15.93 M12.5,9c0,1.933-1.567,3.5-3.5,3.5S5.5,10.933,5.5,9S7.067,5.5,9,5.5 S12.5,7.067,12.5,9z",
            t = "M19.671,8.11l-2.777,2.777l-3.837-0.861c0.362-0.505,0.916-1.683,0.464-2.135c-0.518-0.517-1.979,0.278-2.305,0.604l-0.913,0.913L7.614,8.804l-2.021,2.021l2.232,1.061l-0.082,0.082l1.701,1.701l0.688-0.687l3.164,1.504L9.571,18.21H6.413l-1.137,1.138l3.6,0.948l1.83,1.83l0.947,3.598l1.137-1.137V21.43l3.725-3.725l1.504,3.164l-0.687,0.687l1.702,1.701l0.081-0.081l1.062,2.231l2.02-2.02l-0.604-2.689l0.912-0.912c0.326-0.326,1.121-1.789,0.604-2.306c-0.452-0.452-1.63,0.101-2.135,0.464l-0.861-3.838l2.777-2.777c0.947-0.947,3.599-4.862,2.62-5.839C24.533,4.512,20.618,7.163,19.671,8.11z";AmCharts.makeChart("dashboard_amchart_2", { type: "map", theme: "light", pathToImages: "../assets/global/plugins/amcharts/ammap/images/", dataProvider: { map: "worldLow", linkToObject: "london", images: [{ id: "london", color: "#009dc7", svgPath: e, title: "London", latitude: 51.5002, longitude: -.1262, scale: 1.5, zoomLevel: 2.74, zoomLongitude: -20.1341, zoomLatitude: 49.1712, lines: [{ latitudes: [51.5002, 50.4422], longitudes: [-.1262, 30.5367] }, { latitudes: [51.5002, 46.948], longitudes: [-.1262, 7.4481] }, { latitudes: [51.5002, 59.3328], longitudes: [-.1262, 18.0645] }, { latitudes: [51.5002, 40.4167], longitudes: [-.1262, -3.7033] }, { latitudes: [51.5002, 46.0514], longitudes: [-.1262, 14.506] }, { latitudes: [51.5002, 48.2116], longitudes: [-.1262, 17.1547] }, { latitudes: [51.5002, 44.8048], longitudes: [-.1262, 20.4781] }, { latitudes: [51.5002, 55.7558], longitudes: [-.1262, 37.6176] }, { latitudes: [51.5002, 38.7072], longitudes: [-.1262, -9.1355] }, { latitudes: [51.5002, 54.6896], longitudes: [-.1262, 25.2799] }, { latitudes: [51.5002, 64.1353], longitudes: [-.1262, -21.8952] }, { latitudes: [51.5002, 40.43], longitudes: [-.1262, -74] }], images: [{ label: "Flights from London", svgPath: t, left: 100, top: 45, labelShiftY: 5, color: "#d93d5e", labelColor: "#d93d5e", labelRollOverColor: "#d93d5e", labelFontSize: 20 }, { label: "show flights from Vilnius", left: 106, top: 70, labelColor: "#6c7b88", labelRollOverColor: "#d93d5e", labelFontSize: 11, linkToObject: "vilnius" }] }, { id: "vilnius", color: "#009dc7", svgPath: e, title: "Vilnius", latitude: 54.6896, longitude: 25.2799, scale: 1.5, zoomLevel: 4.92, zoomLongitude: 15.4492, zoomLatitude: 50.2631, lines: [{ latitudes: [54.6896, 50.8371], longitudes: [25.2799, 4.3676] }, { latitudes: [54.6896, 59.9138], longitudes: [25.2799, 10.7387] }, { latitudes: [54.6896, 40.4167], longitudes: [25.2799, -3.7033] }, { latitudes: [54.6896, 50.0878], longitudes: [25.2799, 14.4205] }, { latitudes: [54.6896, 48.2116], longitudes: [25.2799, 17.1547] }, { latitudes: [54.6896, 44.8048], longitudes: [25.2799, 20.4781] }, { latitudes: [54.6896, 55.7558], longitudes: [25.2799, 37.6176] }, { latitudes: [54.6896, 37.9792], longitudes: [25.2799, 23.7166] }, { latitudes: [54.6896, 54.6896], longitudes: [25.2799, 25.2799] }, { latitudes: [54.6896, 51.5002], longitudes: [25.2799, -.1262] }, { latitudes: [54.6896, 53.3441], longitudes: [25.2799, -6.2675] }], images: [{ label: "Flights from Vilnius", svgPath: t, left: 100, top: 45, labelShiftY: 5, color: "#d93d5e", labelColor: "#d93d5e", labelRollOverColor: "#d93d5e", labelFontSize: 20 }, { label: "show flights from London", left: 106, top: 70, labelColor: "#009dc7", labelRollOverColor: "#d93d5e", labelFontSize: 11, linkToObject: "london" }] }, { svgPath: e, title: "Brussels", latitude: 50.8371, longitude: 4.3676 }, { svgPath: e, title: "Prague", latitude: 50.0878, longitude: 14.4205 }, { svgPath: e, title: "Athens", latitude: 37.9792, longitude: 23.7166 }, { svgPath: e, title: "Reykjavik", latitude: 64.1353, longitude: -21.8952 }, { svgPath: e, title: "Dublin", latitude: 53.3441, longitude: -6.2675 }, { svgPath: e, title: "Oslo", latitude: 59.9138, longitude: 10.7387 }, { svgPath: e, title: "Lisbon", latitude: 38.7072, longitude: -9.1355 }, { svgPath: e, title: "Moscow", latitude: 55.7558, longitude: 37.6176 }, { svgPath: e, title: "Belgrade", latitude: 44.8048, longitude: 20.4781 }, { svgPath: e, title: "Bratislava", latitude: 48.2116, longitude: 17.1547 }, { svgPath: e, title: "Ljubljana", latitude: 46.0514, longitude: 14.506 }, { svgPath: e, title: "Madrid", latitude: 40.4167, longitude: -3.7033 }, { svgPath: e, title: "Stockholm", latitude: 59.3328, longitude: 18.0645 }, { svgPath: e, title: "Bern", latitude: 46.948, longitude: 7.4481 }, { svgPath: e, title: "Kiev", latitude: 50.4422, longitude: 30.5367 }, { svgPath: e, title: "Paris", latitude: 48.8567, longitude: 2.351 }, { svgPath: e, title: "New York", latitude: 40.43, longitude: -74 }] }, zoomControl: { buttonFillColor: "#dddddd" }, areasSettings: { unlistedAreasColor: "#15A892" }, imagesSettings: { color: "#d93d5e", rollOverColor: "#d93d5e", selectedColor: "#009dc7" }, linesSettings: { color: "#d93d5e", alpha: .4 }, backgroundZoomsToTop: !0, linesAboveImages: !0, "export": { enabled: !0, libs: { path: "http://www.amcharts.com/lib/3/plugins/export/libs/" } } });
      }
    }, initAmChart3: function initAmChart3() {
      if ("undefined" != typeof AmCharts && 0 !== $("#dashboard_amchart_3").size()) {
        AmCharts.makeChart("dashboard_amchart_3", { type: "serial", addClassNames: !0, theme: "light", path: "../assets/global/plugins/amcharts/ammap/images/", autoMargins: !1, marginLeft: 30, marginRight: 8, marginTop: 10, marginBottom: 26, balloon: { adjustBorderColor: !1, horizontalPadding: 10, verticalPadding: 8, color: "#ffffff" }, dataProvider: [{ year: 2009, income: 23.5, expenses: 21.1 }, { year: 2010, income: 26.2, expenses: 30.5 }, { year: 2011, income: 30.1, expenses: 34.9 }, { year: 2012, income: 29.5, expenses: 31.1 }, { year: 2013, income: 30.6, expenses: 28.2 }, { year: 2014, income: 34.1, expenses: 32.9, dashLengthColumn: 5, alpha: .2, additional: "(projection)" }], valueAxes: [{ axisAlpha: 0, position: "left" }], startDuration: 1, graphs: [{ alphaField: "alpha", balloonText: "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>", fillAlphas: 1, title: "Income", type: "column", valueField: "income", dashLengthField: "dashLengthColumn" }, { id: "graph2", balloonText: "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>", bullet: "round", lineThickness: 3, bulletSize: 7, bulletBorderAlpha: 1, bulletColor: "#FFFFFF", useLineColorForBulletBorder: !0, bulletBorderThickness: 3, fillAlphas: 0, lineAlpha: 1, title: "Expenses", valueField: "expenses" }], categoryField: "year", categoryAxis: { gridPosition: "start", axisAlpha: 0, tickLength: 0 }, "export": { enabled: !0 } });
      }
    }, initAmChart4: function initAmChart4() {
      if ("undefined" != typeof AmCharts && 0 !== $("#dashboard_amchart_4").size()) {
        var e = AmCharts.makeChart("dashboard_amchart_4", { type: "pie", theme: "light", path: "../assets/global/plugins/amcharts/ammap/images/", dataProvider: [{ country: "Lithuania", value: 260 }, { country: "Ireland", value: 201 }, { country: "Germany", value: 65 }, { country: "Australia", value: 39 }, { country: "UK", value: 19 }, { country: "Latvia", value: 10 }], valueField: "value", titleField: "country", outlineAlpha: .4, depth3D: 15, balloonText: "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>", angle: 30, "export": { enabled: !0 } });jQuery(".chart-input").off().on("input change", function () {
          var t = jQuery(this).data("property"),
              a = e,
              i = Number(this.value);e.startDuration = 0, "innerRadius" == t && (i += "%"), a[t] = i, e.validateNow();
        });
      }
    }, initWorldMapStats: function initWorldMapStats() {
      0 !== $("#mapplic").size() && ($("#mapplic").mapplic({ source: "../assets/global/plugins/mapplic/world.json", height: 265, animate: !1, sidebar: !1, minimap: !1, locations: !0, deeplinking: !0, fullscreen: !1, hovertip: !0, zoombuttons: !1, clearbutton: !1, developer: !1, maxscale: 2, skin: "mapplic-dark", zoom: !0 }), $("#widget_sparkline_bar").sparkline([8, 7, 9, 8.5, 8, 8.2, 8, 8.5, 9, 8, 9], { type: "bar", width: "100", barWidth: 5, height: "30", barColor: "#4db3a4", negBarColor: "#e02222" }), $("#widget_sparkline_bar2").sparkline([8, 7, 9, 8.5, 8, 8.2, 8, 8.5, 9, 8, 9], { type: "bar", width: "100", barWidth: 5, height: "30", barColor: "#f36a5a", negBarColor: "#e02222" }), $("#widget_sparkline_bar3").sparkline([8, 7, 9, 8.5, 8, 8.2, 8, 8.5, 9, 8, 9], { type: "bar", width: "100", barWidth: 5, height: "30", barColor: "#5b9bd1", negBarColor: "#e02222" }), $("#widget_sparkline_bar4").sparkline([8, 7, 9, 8.5, 8, 8.2, 8, 8.5, 9, 8, 9], { type: "bar", width: "100", barWidth: 5, height: "30", barColor: "#9a7caf", negBarColor: "#e02222" }));
    }, init: function init() {
      this.initJQVMAP(), this.initCalendar(), this.initCharts(), this.initEasyPieCharts(), this.initSparklineCharts(), this.initChat(), this.initDashboardDaterange(), this.initMorisCharts(), this.initAmChart1(), this.initAmChart2(), this.initAmChart3(), this.initAmChart4(), this.initWorldMapStats();
    } };
}();App.isAngularJsApp() === !1 && jQuery(document).ready(function () {
  Dashboard.init();
});

/***/ }),

/***/ 48:
/***/ (function(module, exports) {

var Layout = function () {
  var e = "layouts/layout/img/",
      a = "layouts/layout/css/",
      t = App.getResponsiveBreakpoint("md"),
      i = [],
      s = [],
      o = function o() {
    var e,
        a = $(".page-content"),
        i = $(".page-sidebar"),
        s = $("body");if (s.hasClass("page-footer-fixed") === !0 && s.hasClass("page-sidebar-fixed") === !1) {
      var o = App.getViewPort().height - $(".page-footer").outerHeight() - $(".page-header").outerHeight(),
          n = i.outerHeight();n > o && (o = n + $(".page-footer").outerHeight()), a.height() < o && a.css("min-height", o);
    } else {
      if (s.hasClass("page-sidebar-fixed")) e = l(), s.hasClass("page-footer-fixed") === !1 && (e -= $(".page-footer").outerHeight());else {
        var r = $(".page-header").outerHeight(),
            d = $(".page-footer").outerHeight();e = App.getViewPort().width < t ? App.getViewPort().height - r - d : i.height() + 20, e + r + d <= App.getViewPort().height && (e = App.getViewPort().height - r - d);
      }a.css("min-height", e);
    }
  },
      n = function n(e, a, i) {
    var s = location.hash.toLowerCase(),
        o = $(".page-sidebar-menu");if ("click" === e || "set" === e ? a = $(a) : "match" === e && o.find("li > a").each(function () {
      var e = $(this).attr("ui-sref");if (i && e) {
        if (i.is(e)) return void (a = $(this));
      } else {
        var t = $(this).attr("href");if (t && (t = t.toLowerCase(), t.length > 1 && s.substr(1, t.length - 1) == t.substr(1))) return void (a = $(this));
      }
    }), a && 0 != a.size() && "javascript:;" != a.attr("href") && "javascript:;" != a.attr("ui-sref") && "#" != a.attr("href") && "#" != a.attr("ui-sref")) {
      parseInt(o.data("slide-speed")), o.data("keep-expanded");o.hasClass("page-sidebar-menu-hover-submenu") === !1 ? o.find("li.nav-item.open").each(function () {
        var e = !1;$(this).find("li").each(function () {
          var t = $(this).attr("ui-sref");if (i && t) {
            if (i.is(t)) return void (e = !0);
          } else if ($(this).find(" > a").attr("href") === a.attr("href")) return void (e = !0);
        }), e !== !0 && ($(this).removeClass("open"), $(this).find("> a > .arrow.open").removeClass("open"), $(this).find("> .sub-menu").slideUp());
      }) : o.find("li.open").removeClass("open"), o.find("li.active").removeClass("active"), o.find("li > a > .selected").remove(), a.parents("li").each(function () {
        $(this).addClass("active"), $(this).find("> a > span.arrow").addClass("open"), 1 === $(this).parent("ul.page-sidebar-menu").size() && $(this).find("> a").append('<span class="selected"></span>'), 1 === $(this).children("ul.sub-menu").size() && $(this).addClass("open");
      }), "click" === e && App.getViewPort().width < t && $(".page-sidebar").hasClass("in") && $(".page-header .responsive-toggler").click();
    }
  },
      r = function r() {
    $(".page-sidebar-mobile-offcanvas .responsive-toggler").click(function (e) {
      $("body").toggleClass("page-sidebar-mobile-offcanvas-open"), e.preventDefault(), e.stopPropagation();
    }), $("body").hasClass("page-sidebar-mobile-offcanvas") && $(document).on("click", function (e) {
      $("body").hasClass("page-sidebar-mobile-offcanvas-open") && 0 === $(e.target).closest(".page-sidebar-mobile-offcanvas .responsive-toggler").length && 0 === $(e.target).closest(".page-sidebar-wrapper").length && ($("body").removeClass("page-sidebar-mobile-offcanvas-open"), e.preventDefault(), e.stopPropagation());
    }), $(".page-sidebar-menu").on("click", "li > a.nav-toggle, li > a > span.nav-toggle", function (e) {
      var a = $(this).closest(".nav-item").children(".nav-link");if (!(App.getViewPort().width >= t && !$(".page-sidebar-menu").attr("data-initialized") && $("body").hasClass("page-sidebar-closed") && 1 === a.parent("li").parent(".page-sidebar-menu").size())) {
        var i = a.next().hasClass("sub-menu");if (!(App.getViewPort().width >= t && 1 === a.parents(".page-sidebar-menu-hover-submenu").size())) {
          if (i === !1) return void (App.getViewPort().width < t && $(".page-sidebar").hasClass("in") && $(".page-header .responsive-toggler").click());var s = a.parent().parent(),
              n = a,
              r = $(".page-sidebar-menu"),
              l = a.next(),
              d = r.data("auto-scroll"),
              p = parseInt(r.data("slide-speed")),
              c = r.data("keep-expanded");c || (s.children("li.open").children("a").children(".arrow").removeClass("open"), s.children("li.open").children(".sub-menu:not(.always-open)").slideUp(p), s.children("li.open").removeClass("open"));var h = -200;l.is(":visible") ? ($(".arrow", n).removeClass("open"), n.parent().removeClass("open"), l.slideUp(p, function () {
            d === !0 && $("body").hasClass("page-sidebar-closed") === !1 && ($("body").hasClass("page-sidebar-fixed") ? r.slimScroll({ scrollTo: n.position().top }) : App.scrollTo(n, h)), o();
          })) : i && ($(".arrow", n).addClass("open"), n.parent().addClass("open"), l.slideDown(p, function () {
            d === !0 && $("body").hasClass("page-sidebar-closed") === !1 && ($("body").hasClass("page-sidebar-fixed") ? r.slimScroll({ scrollTo: n.position().top }) : App.scrollTo(n, h)), o();
          })), e.preventDefault();
        }
      }
    }), App.isAngularJsApp() && $(".page-sidebar-menu li > a").on("click", function (e) {
      App.getViewPort().width < t && $(this).next().hasClass("sub-menu") === !1 && $(".page-header .responsive-toggler").click();
    }), $(".page-sidebar").on("click", " li > a.ajaxify", function (e) {
      e.preventDefault(), App.scrollTop();var a = $(this).attr("href"),
          i = $(".page-sidebar ul");i.children("li.active").removeClass("active"), i.children("arrow.open").removeClass("open"), $(this).parents("li").each(function () {
        $(this).addClass("active"), $(this).children("a > span.arrow").addClass("open");
      }), $(this).parents("li").addClass("active"), App.getViewPort().width < t && $(".page-sidebar").hasClass("in") && $(".page-header .responsive-toggler").click(), Layout.loadAjaxContent(a, $(this));
    }), $(".page-content").on("click", ".ajaxify", function (e) {
      e.preventDefault(), App.scrollTop();var a = $(this).attr("href");App.getViewPort().width < t && $(".page-sidebar").hasClass("in") && $(".page-header .responsive-toggler").click(), Layout.loadAjaxContent(a);
    }), $(document).on("click", ".page-header-fixed-mobile .page-header .responsive-toggler", function () {
      App.scrollTop();
    }), p(), $(".page-sidebar").on("click", ".sidebar-search .remove", function (e) {
      e.preventDefault(), $(".sidebar-search").removeClass("open");
    }), $(".page-sidebar .sidebar-search").on("keypress", "input.form-control", function (e) {
      if (13 == e.which) return $(".sidebar-search").submit(), !1;
    }), $(".sidebar-search .submit").on("click", function (e) {
      e.preventDefault(), $("body").hasClass("page-sidebar-closed") && $(".sidebar-search").hasClass("open") === !1 ? (1 === $(".page-sidebar-fixed").size() && $(".page-sidebar .sidebar-toggler").click(), $(".sidebar-search").addClass("open")) : $(".sidebar-search").submit();
    }), 0 !== $(".sidebar-search").size() && ($(".sidebar-search .input-group").on("click", function (e) {
      e.stopPropagation();
    }), $("body").on("click", function () {
      $(".sidebar-search").hasClass("open") && $(".sidebar-search").removeClass("open");
    }));
  },
      l = function l() {
    var e = App.getViewPort().height - $(".page-header").outerHeight(!0);return $("body").hasClass("page-footer-fixed") && (e -= $(".page-footer").outerHeight()), e;
  },
      d = function d() {
    var e = $(".page-sidebar-menu");return o(), 0 === $(".page-sidebar-fixed").size() ? void App.destroySlimScroll(e) : void (App.getViewPort().width >= t && !$("body").hasClass("page-sidebar-menu-not-fixed") && (e.attr("data-height", l()), App.destroySlimScroll(e), App.initSlimScroll(e), o()));
  },
      p = function p() {
    $("body").hasClass("page-sidebar-fixed") && $(".page-sidebar").on("mouseenter", function () {
      $("body").hasClass("page-sidebar-closed") && $(this).find(".page-sidebar-menu").removeClass("page-sidebar-menu-closed");
    }).on("mouseleave", function () {
      $("body").hasClass("page-sidebar-closed") && $(this).find(".page-sidebar-menu").addClass("page-sidebar-menu-closed");
    });
  },
      c = function c() {
    $("body").on("click", ".sidebar-toggler", function (e) {
      var a = $("body"),
          t = $(".page-sidebar"),
          i = $(".page-sidebar-menu");$(".sidebar-search", t).removeClass("open"), a.hasClass("page-sidebar-closed") ? (a.removeClass("page-sidebar-closed"), i.removeClass("page-sidebar-menu-closed"), Cookies && Cookies.set("sidebar_closed", "0")) : (a.addClass("page-sidebar-closed"), i.addClass("page-sidebar-menu-closed"), a.hasClass("page-sidebar-fixed") && i.trigger("mouseleave"), Cookies && Cookies.set("sidebar_closed", "1")), $(window).trigger("resize");
    });
  },
      h = function h() {
    $(".page-header").on("click", '.hor-menu a[data-toggle="tab"]', function (e) {
      e.preventDefault();var a = $(".hor-menu .nav"),
          t = a.find("li.current");$("li.active", t).removeClass("active"), $(".selected", t).remove();var i = $(this).parents("li").last();i.addClass("current"), i.find("a:first").append('<span class="selected"></span>');
    }), $(".page-header").on("click", ".search-form", function (e) {
      $(this).addClass("open"), $(this).find(".form-control").focus(), $(".page-header .search-form .form-control").on("blur", function (e) {
        $(this).closest(".search-form").removeClass("open"), $(this).unbind("blur");
      });
    }), $(".page-header").on("keypress", ".hor-menu .search-form .form-control", function (e) {
      if (13 == e.which) return $(this).closest(".search-form").submit(), !1;
    }), $(".page-header").on("mousedown", ".search-form.open .submit", function (e) {
      e.preventDefault(), e.stopPropagation(), $(this).closest(".search-form").submit();
    }), $(document).on("click", ".mega-menu-dropdown .dropdown-menu", function (e) {
      e.stopPropagation();
    });
  },
      u = function u() {
    $("body").on("shown.bs.tab", 'a[data-toggle="tab"]', function () {
      o();
    });
  },
      g = function g() {
    var e = 300,
        a = 500;navigator.userAgent.match(/iPhone|iPad|iPod/i) ? $(window).bind("touchend touchcancel touchleave", function (t) {
      $(this).scrollTop() > e ? $(".scroll-to-top").fadeIn(a) : $(".scroll-to-top").fadeOut(a);
    }) : $(window).scroll(function () {
      $(this).scrollTop() > e ? $(".scroll-to-top").fadeIn(a) : $(".scroll-to-top").fadeOut(a);
    }), $(".scroll-to-top").click(function (e) {
      return e.preventDefault(), $("html, body").animate({ scrollTop: 0 }, a), !1;
    });
  },
      f = function f() {
    $(".full-height-content").each(function () {
      var e,
          a = $(this);if (e = App.getViewPort().height - $(".page-header").outerHeight(!0) - $(".page-footer").outerHeight(!0) - $(".page-title").outerHeight(!0) - $(".page-bar").outerHeight(!0), a.hasClass("portlet")) {
        var i = a.find(".portlet-body");App.destroySlimScroll(i.find(".full-height-content-body")), e = e - a.find(".portlet-title").outerHeight(!0) - parseInt(a.find(".portlet-body").css("padding-top")) - parseInt(a.find(".portlet-body").css("padding-bottom")) - 5, App.getViewPort().width >= t && a.hasClass("full-height-content-scrollable") ? (e -= 35, i.find(".full-height-content-body").css("height", e), App.initSlimScroll(i.find(".full-height-content-body"))) : i.css("min-height", e);
      } else App.destroySlimScroll(a.find(".full-height-content-body")), App.getViewPort().width >= t && a.hasClass("full-height-content-scrollable") ? (e -= 35, a.find(".full-height-content-body").css("height", e), App.initSlimScroll(a.find(".full-height-content-body"))) : a.css("min-height", e);
    });
  };return { initHeader: function initHeader() {
      h();
    }, setSidebarMenuActiveLink: function setSidebarMenuActiveLink(e, a) {
      n(e, a, null);
    }, setAngularJsSidebarMenuActiveLink: function setAngularJsSidebarMenuActiveLink(e, a, t) {
      n(e, a, t);
    }, initSidebar: function initSidebar(e) {
      d(), r(), c(), App.isAngularJsApp() && n("match", null, e), App.addResizeHandler(d);
    }, initContent: function initContent() {
      f(), u(), App.addResizeHandler(o), App.addResizeHandler(f);
    }, initFooter: function initFooter() {
      g();
    }, init: function init() {
      this.initHeader(), this.initSidebar(null), this.initContent(), this.initFooter();
    }, loadAjaxContent: function loadAjaxContent(e, a) {
      var t = $(".page-content .page-content-body");App.startPageLoading({ animate: !0 }), $.ajax({ type: "GET", cache: !1, url: e, dataType: "html", success: function success(e) {
          App.stopPageLoading(), t.html(e);for (var s = 0; s < i.length; s++) {
            i[s].call(e);
          }a.size() > 0 && 0 === a.parents("li.open").size() && $(".page-sidebar-menu > li.open > a").click(), Layout.fixContentHeight(), App.initAjax();
        }, error: function error(e, a, i) {
          App.stopPageLoading(), t.html("<h4>Could not load the requested content.</h4>");for (var o = 0; o < s.length; o++) {
            s[o].call(e);
          }
        } });
    }, addAjaxContentSuccessCallback: function addAjaxContentSuccessCallback(e) {
      i.push(e);
    }, addAjaxContentErrorCallback: function addAjaxContentErrorCallback(e) {
      s.push(e);
    }, fixContentHeight: function fixContentHeight() {
      o();
    }, initFixedSidebarHoverEffect: function initFixedSidebarHoverEffect() {
      p();
    }, initFixedSidebar: function initFixedSidebar() {
      d();
    }, getLayoutImgPath: function getLayoutImgPath() {
      return App.getAssetsPath() + e;
    }, getLayoutCssPath: function getLayoutCssPath() {
      return App.getAssetsPath() + a;
    } };
}();App.isAngularJsApp() === !1 && jQuery(document).ready(function () {
  Layout.init();
});

/***/ }),

/***/ 49:
/***/ (function(module, exports) {

var Demo = function () {
  var e = function e() {
    var e = $(".theme-panel");$("body").hasClass("page-boxed") === !1 && $(".layout-option", e).val("fluid"), $(".sidebar-option", e).val("default"), $(".page-header-option", e).val("fixed"), $(".page-footer-option", e).val("default"), $(".sidebar-pos-option").attr("disabled") === !1 && $(".sidebar-pos-option", e).val(App.isRTL() ? "right" : "left");var a = function a() {
      $("body").removeClass("page-boxed").removeClass("page-footer-fixed").removeClass("page-sidebar-fixed").removeClass("page-header-fixed").removeClass("page-sidebar-reversed"), $(".page-header > .page-header-inner").removeClass("container"), 1 === $(".page-container").parent(".container").size() && $(".page-container").insertAfter("body >.page-wrapper > .clearfix"), 1 === $(".page-footer > .container").size() ? $(".page-footer").html($(".page-footer > .container").html()) : 1 === $(".page-footer").parent(".container").size() && ($(".page-footer").insertAfter(".page-container"), $(".scroll-to-top").insertAfter(".page-footer")), $(".top-menu > .navbar-nav > li.dropdown").removeClass("dropdown-dark"), $("body > .page-wrapper > .container").remove();
    },
        o = "",
        t = function t() {
      var t = $(".layout-option", e).val(),
          i = $(".sidebar-option", e).val(),
          r = $(".page-header-option", e).val(),
          d = $(".page-footer-option", e).val(),
          s = $(".sidebar-pos-option", e).val(),
          n = $(".sidebar-style-option", e).val(),
          p = $(".sidebar-menu-option", e).val(),
          l = $(".page-header-top-dropdown-style-option", e).val();if ("fixed" == i && "default" == r && (alert("Default Header with Fixed Sidebar option is not supported. Proceed with Fixed Header with Fixed Sidebar."), $(".page-header-option", e).val("fixed"), $(".sidebar-option", e).val("fixed"), i = "fixed", r = "fixed"), a(), "boxed" === t) {
        $("body").addClass("page-boxed"), $(".page-header > .page-header-inner").addClass("container");$("body > .page-wrapper > .clearfix").after('<div class="container"></div>');$(".page-container").appendTo("body > .page-wrapper > .container"), "fixed" === d ? $(".page-footer").html('<div class="container">' + $(".page-footer").html() + "</div>") : $(".page-footer").appendTo("body > .page-wrapper > .container");
      }o != t && App.runResizeHandlers(), o = t, "fixed" === r ? ($("body").addClass("page-header-fixed"), $(".page-header").removeClass("navbar-static-top").addClass("navbar-fixed-top")) : ($("body").removeClass("page-header-fixed"), $(".page-header").removeClass("navbar-fixed-top").addClass("navbar-static-top")), $("body").hasClass("page-full-width") === !1 && ("fixed" === i ? ($("body").addClass("page-sidebar-fixed"), $("page-sidebar-menu").addClass("page-sidebar-menu-fixed"), $("page-sidebar-menu").removeClass("page-sidebar-menu-default"), Layout.initFixedSidebarHoverEffect()) : ($("body").removeClass("page-sidebar-fixed"), $("page-sidebar-menu").addClass("page-sidebar-menu-default"), $("page-sidebar-menu").removeClass("page-sidebar-menu-fixed"), $(".page-sidebar-menu").unbind("mouseenter").unbind("mouseleave"))), "dark" === l ? $(".top-menu > .navbar-nav > li.dropdown").addClass("dropdown-dark") : $(".top-menu > .navbar-nav > li.dropdown").removeClass("dropdown-dark"), "fixed" === d ? $("body").addClass("page-footer-fixed") : $("body").removeClass("page-footer-fixed"), "light" === n ? $(".page-sidebar-menu").addClass("page-sidebar-menu-light") : $(".page-sidebar-menu").removeClass("page-sidebar-menu-light"), "hover" === p ? "fixed" == i ? ($(".sidebar-menu-option", e).val("accordion"), alert("Hover Sidebar Menu is not compatible with Fixed Sidebar Mode. Select Default Sidebar Mode Instead.")) : $(".page-sidebar-menu").addClass("page-sidebar-menu-hover-submenu") : $(".page-sidebar-menu").removeClass("page-sidebar-menu-hover-submenu"), App.isRTL() ? "left" === s ? ($("body").addClass("page-sidebar-reversed"), $("#frontend-link").tooltip("destroy").tooltip({ placement: "right" })) : ($("body").removeClass("page-sidebar-reversed"), $("#frontend-link").tooltip("destroy").tooltip({ placement: "left" })) : "right" === s ? ($("body").addClass("page-sidebar-reversed"), $("#frontend-link").tooltip("destroy").tooltip({ placement: "left" })) : ($("body").removeClass("page-sidebar-reversed"), $("#frontend-link").tooltip("destroy").tooltip({ placement: "right" })), Layout.fixContentHeight(), Layout.initFixedSidebar();
    },
        i = function i(e) {
      var a = App.isRTL() ? e + "-rtl" : e;$("#style_color").attr("href", Layout.getLayoutCssPath() + "themes/" + a + ".min.css"), "light2" == e ? $(".page-logo img").attr("src", Layout.getLayoutImgPath() + "logo-invert.png") : $(".page-logo img").attr("src", Layout.getLayoutImgPath() + "logo.png");
    };$(".toggler", e).click(function () {
      $(".toggler").hide(), $(".toggler-close").show(), $(".theme-panel > .theme-options").show();
    }), $(".toggler-close", e).click(function () {
      $(".toggler").show(), $(".toggler-close").hide(), $(".theme-panel > .theme-options").hide();
    }), $(".theme-colors > ul > li", e).click(function () {
      var a = $(this).attr("data-style");i(a), $("ul > li", e).removeClass("current"), $(this).addClass("current");
    }), $("body").hasClass("page-boxed") && $(".layout-option", e).val("boxed"), $("body").hasClass("page-sidebar-fixed") && $(".sidebar-option", e).val("fixed"), $("body").hasClass("page-header-fixed") && $(".page-header-option", e).val("fixed"), $("body").hasClass("page-footer-fixed") && $(".page-footer-option", e).val("fixed"), $("body").hasClass("page-sidebar-reversed") && $(".sidebar-pos-option", e).val("right"), $(".page-sidebar-menu").hasClass("page-sidebar-menu-light") && $(".sidebar-style-option", e).val("light"), $(".page-sidebar-menu").hasClass("page-sidebar-menu-hover-submenu") && $(".sidebar-menu-option", e).val("hover");$(".sidebar-option", e).val(), $(".page-header-option", e).val(), $(".page-footer-option", e).val(), $(".sidebar-pos-option", e).val(), $(".sidebar-style-option", e).val(), $(".sidebar-menu-option", e).val();$(".layout-option, .page-header-option, .page-header-top-dropdown-style-option, .sidebar-option, .page-footer-option, .sidebar-pos-option, .sidebar-style-option, .sidebar-menu-option", e).change(t);
  },
      a = function a(e) {
    var a = "rounded" === e ? "components-rounded" : "components";a = App.isRTL() ? a + "-rtl" : a, $("#style_components").attr("href", App.getGlobalCssPath() + a + ".min.css"), "undefined" != typeof Cookies && Cookies.set("layout-style-option", e);
  };return { init: function init() {
      e(), $(".theme-panel .layout-style-option").change(function () {
        a($(this).val());
      }), "undefined" != typeof Cookies && "rounded" === Cookies.get("layout-style-option") && (a(Cookies.get("layout-style-option")), $(".theme-panel .layout-style-option").val(Cookies.get("layout-style-option")));
    } };
}();App.isAngularJsApp() === !1 && jQuery(document).ready(function () {
  Demo.init();
});

/***/ }),

/***/ 50:
/***/ (function(module, exports) {

var QuickSidebar = function () {
  var i = function i() {
    $(".dropdown-quick-sidebar-toggler a, .page-quick-sidebar-toggler, .quick-sidebar-toggler").click(function (i) {
      $("body").toggleClass("page-quick-sidebar-open");
    });
  },
      a = function a() {
    var i = $(".page-quick-sidebar-wrapper"),
        a = i.find(".page-quick-sidebar-chat"),
        e = function e() {
      var e,
          t = i.find(".page-quick-sidebar-chat-users");e = i.height() - i.find(".nav-tabs").outerHeight(!0), App.destroySlimScroll(t), t.attr("data-height", e), App.initSlimScroll(t);var r = a.find(".page-quick-sidebar-chat-user-messages"),
          s = e - a.find(".page-quick-sidebar-chat-user-form").outerHeight(!0);s -= a.find(".page-quick-sidebar-nav").outerHeight(!0), App.destroySlimScroll(r), r.attr("data-height", s), App.initSlimScroll(r);
    };e(), App.addResizeHandler(e), i.find(".page-quick-sidebar-chat-users .media-list > .media").click(function () {
      a.addClass("page-quick-sidebar-content-item-shown");
    }), i.find(".page-quick-sidebar-chat-user .page-quick-sidebar-back-to-list").click(function () {
      a.removeClass("page-quick-sidebar-content-item-shown");
    });var t = function t(i) {
      i.preventDefault();var e = a.find(".page-quick-sidebar-chat-user-messages"),
          t = a.find(".page-quick-sidebar-chat-user-form .form-control"),
          r = t.val();if (0 !== r.length) {
        var s = function s(i, a, e, t, r) {
          var s = "";return s += '<div class="post ' + i + '">', s += '<img class="avatar" alt="" src="' + Layout.getLayoutImgPath() + t + '.jpg"/>', s += '<div class="message">', s += '<span class="arrow"></span>', s += '<a href="#" class="name">Bob Nilson</a>&nbsp;', s += '<span class="datetime">' + a + "</span>", s += '<span class="body">', s += r, s += "</span>", s += "</div>", s += "</div>";
        },
            n = new Date(),
            c = s("out", n.getHours() + ":" + n.getMinutes(), "Bob Nilson", "avatar3", r);c = $(c), e.append(c), e.slimScroll({ scrollTo: "1000000px" }), t.val(""), setTimeout(function () {
          var i = new Date(),
              a = s("in", i.getHours() + ":" + i.getMinutes(), "Ella Wong", "avatar2", "Lorem ipsum doloriam nibh...");a = $(a), e.append(a), e.slimScroll({ scrollTo: "1000000px" });
        }, 3e3);
      }
    };a.find(".page-quick-sidebar-chat-user-form .btn").click(t), a.find(".page-quick-sidebar-chat-user-form .form-control").keypress(function (i) {
      if (13 == i.which) return t(i), !1;
    });
  },
      e = function e() {
    var i = $(".page-quick-sidebar-wrapper"),
        a = function a() {
      var a,
          e = i.find(".page-quick-sidebar-alerts-list");a = i.height() - 80 - i.find(".nav-justified > .nav-tabs").outerHeight(), App.destroySlimScroll(e), e.attr("data-height", a), App.initSlimScroll(e);
    };a(), App.addResizeHandler(a);
  },
      t = function t() {
    var i = $(".page-quick-sidebar-wrapper"),
        a = function a() {
      var a,
          e = i.find(".page-quick-sidebar-settings-list");a = i.height() - 80 - i.find(".nav-justified > .nav-tabs").outerHeight(), App.destroySlimScroll(e), e.attr("data-height", a), App.initSlimScroll(e);
    };a(), App.addResizeHandler(a);
  };return { init: function init() {
      i(), a(), e(), t();
    } };
}();App.isAngularJsApp() === !1 && jQuery(document).ready(function () {
  QuickSidebar.init();
});

/***/ }),

/***/ 51:
/***/ (function(module, exports) {

var QuickNav = function () {
  return { init: function init() {
      if ($(".quick-nav").length > 0) {
        var i = $(".quick-nav");i.each(function () {
          var i = $(this),
              n = i.find(".quick-nav-trigger");n.on("click", function (n) {
            n.preventDefault(), i.toggleClass("nav-is-visible");
          });
        }), $(document).on("click", function (n) {
          !$(n.target).is(".quick-nav-trigger") && !$(n.target).is(".quick-nav-trigger span") && i.removeClass("nav-is-visible");
        });
      }
    } };
}();QuickNav.init();

/***/ })

/******/ });