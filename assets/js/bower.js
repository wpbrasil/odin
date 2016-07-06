+function(a) {
    "use strict";
    function b() {
        var a = document.createElement("bootstrap"), b = {
            WebkitTransition: "webkitTransitionEnd",
            MozTransition: "transitionend",
            OTransition: "oTransitionEnd otransitionend",
            transition: "transitionend"
        };
        for (var c in b) if (void 0 !== a.style[c]) return {
            end: b[c]
        };
        return !1;
    }
    a.fn.emulateTransitionEnd = function(b) {
        var c = !1, d = this;
        a(this).one("bsTransitionEnd", function() {
            c = !0;
        });
        var e = function() {
            c || a(d).trigger(a.support.transition.end);
        };
        return setTimeout(e, b), this;
    }, a(function() {
        a.support.transition = b(), a.support.transition && (a.event.special.bsTransitionEnd = {
            bindType: a.support.transition.end,
            delegateType: a.support.transition.end,
            handle: function(b) {
                if (a(b.target).is(this)) return b.handleObj.handler.apply(this, arguments);
            }
        });
    });
}(jQuery), +function(a) {
    "use strict";
    function b(b) {
        return this.each(function() {
            var c = a(this), e = c.data("bs.alert");
            e || c.data("bs.alert", e = new d(this)), "string" == typeof b && e[b].call(c);
        });
    }
    var c = '[data-dismiss="alert"]', d = function(b) {
        a(b).on("click", c, this.close);
    };
    d.VERSION = "3.3.6", d.TRANSITION_DURATION = 150, d.prototype.close = function(b) {
        function c() {
            g.detach().trigger("closed.bs.alert").remove();
        }
        var e = a(this), f = e.attr("data-target");
        f || (f = e.attr("href"), f = f && f.replace(/.*(?=#[^\s]*$)/, ""));
        var g = a(f);
        b && b.preventDefault(), g.length || (g = e.closest(".alert")), g.trigger(b = a.Event("close.bs.alert")), 
        b.isDefaultPrevented() || (g.removeClass("in"), a.support.transition && g.hasClass("fade") ? g.one("bsTransitionEnd", c).emulateTransitionEnd(d.TRANSITION_DURATION) : c());
    };
    var e = a.fn.alert;
    a.fn.alert = b, a.fn.alert.Constructor = d, a.fn.alert.noConflict = function() {
        return a.fn.alert = e, this;
    }, a(document).on("click.bs.alert.data-api", c, d.prototype.close);
}(jQuery), +function(a) {
    "use strict";
    function b(b) {
        return this.each(function() {
            var d = a(this), e = d.data("bs.button"), f = "object" == typeof b && b;
            e || d.data("bs.button", e = new c(this, f)), "toggle" == b ? e.toggle() : b && e.setState(b);
        });
    }
    var c = function(b, d) {
        this.$element = a(b), this.options = a.extend({}, c.DEFAULTS, d), this.isLoading = !1;
    };
    c.VERSION = "3.3.6", c.DEFAULTS = {
        loadingText: "loading..."
    }, c.prototype.setState = function(b) {
        var c = "disabled", d = this.$element, e = d.is("input") ? "val" : "html", f = d.data();
        b += "Text", null == f.resetText && d.data("resetText", d[e]()), setTimeout(a.proxy(function() {
            d[e](null == f[b] ? this.options[b] : f[b]), "loadingText" == b ? (this.isLoading = !0, 
            d.addClass(c).attr(c, c)) : this.isLoading && (this.isLoading = !1, d.removeClass(c).removeAttr(c));
        }, this), 0);
    }, c.prototype.toggle = function() {
        var a = !0, b = this.$element.closest('[data-toggle="buttons"]');
        if (b.length) {
            var c = this.$element.find("input");
            "radio" == c.prop("type") ? (c.prop("checked") && (a = !1), b.find(".active").removeClass("active"), 
            this.$element.addClass("active")) : "checkbox" == c.prop("type") && (c.prop("checked") !== this.$element.hasClass("active") && (a = !1), 
            this.$element.toggleClass("active")), c.prop("checked", this.$element.hasClass("active")), 
            a && c.trigger("change");
        } else this.$element.attr("aria-pressed", !this.$element.hasClass("active")), this.$element.toggleClass("active");
    };
    var d = a.fn.button;
    a.fn.button = b, a.fn.button.Constructor = c, a.fn.button.noConflict = function() {
        return a.fn.button = d, this;
    }, a(document).on("click.bs.button.data-api", '[data-toggle^="button"]', function(c) {
        var d = a(c.target);
        d.hasClass("btn") || (d = d.closest(".btn")), b.call(d, "toggle"), a(c.target).is('input[type="radio"]') || a(c.target).is('input[type="checkbox"]') || c.preventDefault();
    }).on("focus.bs.button.data-api blur.bs.button.data-api", '[data-toggle^="button"]', function(b) {
        a(b.target).closest(".btn").toggleClass("focus", /^focus(in)?$/.test(b.type));
    });
}(jQuery), +function(a) {
    "use strict";
    function b(b) {
        return this.each(function() {
            var d = a(this), e = d.data("bs.carousel"), f = a.extend({}, c.DEFAULTS, d.data(), "object" == typeof b && b), g = "string" == typeof b ? b : f.slide;
            e || d.data("bs.carousel", e = new c(this, f)), "number" == typeof b ? e.to(b) : g ? e[g]() : f.interval && e.pause().cycle();
        });
    }
    var c = function(b, c) {
        this.$element = a(b), this.$indicators = this.$element.find(".carousel-indicators"), 
        this.options = c, this.paused = null, this.sliding = null, this.interval = null, 
        this.$active = null, this.$items = null, this.options.keyboard && this.$element.on("keydown.bs.carousel", a.proxy(this.keydown, this)), 
        "hover" == this.options.pause && !("ontouchstart" in document.documentElement) && this.$element.on("mouseenter.bs.carousel", a.proxy(this.pause, this)).on("mouseleave.bs.carousel", a.proxy(this.cycle, this));
    };
    c.VERSION = "3.3.6", c.TRANSITION_DURATION = 600, c.DEFAULTS = {
        interval: 5e3,
        pause: "hover",
        wrap: !0,
        keyboard: !0
    }, c.prototype.keydown = function(a) {
        if (!/input|textarea/i.test(a.target.tagName)) {
            switch (a.which) {
              case 37:
                this.prev();
                break;

              case 39:
                this.next();
                break;

              default:
                return;
            }
            a.preventDefault();
        }
    }, c.prototype.cycle = function(b) {
        return b || (this.paused = !1), this.interval && clearInterval(this.interval), this.options.interval && !this.paused && (this.interval = setInterval(a.proxy(this.next, this), this.options.interval)), 
        this;
    }, c.prototype.getItemIndex = function(a) {
        return this.$items = a.parent().children(".item"), this.$items.index(a || this.$active);
    }, c.prototype.getItemForDirection = function(a, b) {
        var c = this.getItemIndex(b), d = "prev" == a && 0 === c || "next" == a && c == this.$items.length - 1;
        if (d && !this.options.wrap) return b;
        var e = "prev" == a ? -1 : 1, f = (c + e) % this.$items.length;
        return this.$items.eq(f);
    }, c.prototype.to = function(a) {
        var b = this, c = this.getItemIndex(this.$active = this.$element.find(".item.active"));
        if (!(a > this.$items.length - 1 || a < 0)) return this.sliding ? this.$element.one("slid.bs.carousel", function() {
            b.to(a);
        }) : c == a ? this.pause().cycle() : this.slide(a > c ? "next" : "prev", this.$items.eq(a));
    }, c.prototype.pause = function(b) {
        return b || (this.paused = !0), this.$element.find(".next, .prev").length && a.support.transition && (this.$element.trigger(a.support.transition.end), 
        this.cycle(!0)), this.interval = clearInterval(this.interval), this;
    }, c.prototype.next = function() {
        if (!this.sliding) return this.slide("next");
    }, c.prototype.prev = function() {
        if (!this.sliding) return this.slide("prev");
    }, c.prototype.slide = function(b, d) {
        var e = this.$element.find(".item.active"), f = d || this.getItemForDirection(b, e), g = this.interval, h = "next" == b ? "left" : "right", i = this;
        if (f.hasClass("active")) return this.sliding = !1;
        var j = f[0], k = a.Event("slide.bs.carousel", {
            relatedTarget: j,
            direction: h
        });
        if (this.$element.trigger(k), !k.isDefaultPrevented()) {
            if (this.sliding = !0, g && this.pause(), this.$indicators.length) {
                this.$indicators.find(".active").removeClass("active");
                var l = a(this.$indicators.children()[this.getItemIndex(f)]);
                l && l.addClass("active");
            }
            var m = a.Event("slid.bs.carousel", {
                relatedTarget: j,
                direction: h
            });
            return a.support.transition && this.$element.hasClass("slide") ? (f.addClass(b), 
            f[0].offsetWidth, e.addClass(h), f.addClass(h), e.one("bsTransitionEnd", function() {
                f.removeClass([ b, h ].join(" ")).addClass("active"), e.removeClass([ "active", h ].join(" ")), 
                i.sliding = !1, setTimeout(function() {
                    i.$element.trigger(m);
                }, 0);
            }).emulateTransitionEnd(c.TRANSITION_DURATION)) : (e.removeClass("active"), f.addClass("active"), 
            this.sliding = !1, this.$element.trigger(m)), g && this.cycle(), this;
        }
    };
    var d = a.fn.carousel;
    a.fn.carousel = b, a.fn.carousel.Constructor = c, a.fn.carousel.noConflict = function() {
        return a.fn.carousel = d, this;
    };
    var e = function(c) {
        var d, e = a(this), f = a(e.attr("data-target") || (d = e.attr("href")) && d.replace(/.*(?=#[^\s]+$)/, ""));
        if (f.hasClass("carousel")) {
            var g = a.extend({}, f.data(), e.data()), h = e.attr("data-slide-to");
            h && (g.interval = !1), b.call(f, g), h && f.data("bs.carousel").to(h), c.preventDefault();
        }
    };
    a(document).on("click.bs.carousel.data-api", "[data-slide]", e).on("click.bs.carousel.data-api", "[data-slide-to]", e), 
    a(window).on("load", function() {
        a('[data-ride="carousel"]').each(function() {
            var c = a(this);
            b.call(c, c.data());
        });
    });
}(jQuery), +function(a) {
    "use strict";
    function b(b) {
        var c, d = b.attr("data-target") || (c = b.attr("href")) && c.replace(/.*(?=#[^\s]+$)/, "");
        return a(d);
    }
    function c(b) {
        return this.each(function() {
            var c = a(this), e = c.data("bs.collapse"), f = a.extend({}, d.DEFAULTS, c.data(), "object" == typeof b && b);
            !e && f.toggle && /show|hide/.test(b) && (f.toggle = !1), e || c.data("bs.collapse", e = new d(this, f)), 
            "string" == typeof b && e[b]();
        });
    }
    var d = function(b, c) {
        this.$element = a(b), this.options = a.extend({}, d.DEFAULTS, c), this.$trigger = a('[data-toggle="collapse"][href="#' + b.id + '"],[data-toggle="collapse"][data-target="#' + b.id + '"]'), 
        this.transitioning = null, this.options.parent ? this.$parent = this.getParent() : this.addAriaAndCollapsedClass(this.$element, this.$trigger), 
        this.options.toggle && this.toggle();
    };
    d.VERSION = "3.3.6", d.TRANSITION_DURATION = 350, d.DEFAULTS = {
        toggle: !0
    }, d.prototype.dimension = function() {
        var a = this.$element.hasClass("width");
        return a ? "width" : "height";
    }, d.prototype.show = function() {
        if (!this.transitioning && !this.$element.hasClass("in")) {
            var b, e = this.$parent && this.$parent.children(".panel").children(".in, .collapsing");
            if (!(e && e.length && (b = e.data("bs.collapse"), b && b.transitioning))) {
                var f = a.Event("show.bs.collapse");
                if (this.$element.trigger(f), !f.isDefaultPrevented()) {
                    e && e.length && (c.call(e, "hide"), b || e.data("bs.collapse", null));
                    var g = this.dimension();
                    this.$element.removeClass("collapse").addClass("collapsing")[g](0).attr("aria-expanded", !0), 
                    this.$trigger.removeClass("collapsed").attr("aria-expanded", !0), this.transitioning = 1;
                    var h = function() {
                        this.$element.removeClass("collapsing").addClass("collapse in")[g](""), this.transitioning = 0, 
                        this.$element.trigger("shown.bs.collapse");
                    };
                    if (!a.support.transition) return h.call(this);
                    var i = a.camelCase([ "scroll", g ].join("-"));
                    this.$element.one("bsTransitionEnd", a.proxy(h, this)).emulateTransitionEnd(d.TRANSITION_DURATION)[g](this.$element[0][i]);
                }
            }
        }
    }, d.prototype.hide = function() {
        if (!this.transitioning && this.$element.hasClass("in")) {
            var b = a.Event("hide.bs.collapse");
            if (this.$element.trigger(b), !b.isDefaultPrevented()) {
                var c = this.dimension();
                this.$element[c](this.$element[c]())[0].offsetHeight, this.$element.addClass("collapsing").removeClass("collapse in").attr("aria-expanded", !1), 
                this.$trigger.addClass("collapsed").attr("aria-expanded", !1), this.transitioning = 1;
                var e = function() {
                    this.transitioning = 0, this.$element.removeClass("collapsing").addClass("collapse").trigger("hidden.bs.collapse");
                };
                return a.support.transition ? void this.$element[c](0).one("bsTransitionEnd", a.proxy(e, this)).emulateTransitionEnd(d.TRANSITION_DURATION) : e.call(this);
            }
        }
    }, d.prototype.toggle = function() {
        this[this.$element.hasClass("in") ? "hide" : "show"]();
    }, d.prototype.getParent = function() {
        return a(this.options.parent).find('[data-toggle="collapse"][data-parent="' + this.options.parent + '"]').each(a.proxy(function(c, d) {
            var e = a(d);
            this.addAriaAndCollapsedClass(b(e), e);
        }, this)).end();
    }, d.prototype.addAriaAndCollapsedClass = function(a, b) {
        var c = a.hasClass("in");
        a.attr("aria-expanded", c), b.toggleClass("collapsed", !c).attr("aria-expanded", c);
    };
    var e = a.fn.collapse;
    a.fn.collapse = c, a.fn.collapse.Constructor = d, a.fn.collapse.noConflict = function() {
        return a.fn.collapse = e, this;
    }, a(document).on("click.bs.collapse.data-api", '[data-toggle="collapse"]', function(d) {
        var e = a(this);
        e.attr("data-target") || d.preventDefault();
        var f = b(e), g = f.data("bs.collapse"), h = g ? "toggle" : e.data();
        c.call(f, h);
    });
}(jQuery), +function(a) {
    "use strict";
    function b(b) {
        var c = b.attr("data-target");
        c || (c = b.attr("href"), c = c && /#[A-Za-z]/.test(c) && c.replace(/.*(?=#[^\s]*$)/, ""));
        var d = c && a(c);
        return d && d.length ? d : b.parent();
    }
    function c(c) {
        c && 3 === c.which || (a(e).remove(), a(f).each(function() {
            var d = a(this), e = b(d), f = {
                relatedTarget: this
            };
            e.hasClass("open") && (c && "click" == c.type && /input|textarea/i.test(c.target.tagName) && a.contains(e[0], c.target) || (e.trigger(c = a.Event("hide.bs.dropdown", f)), 
            c.isDefaultPrevented() || (d.attr("aria-expanded", "false"), e.removeClass("open").trigger(a.Event("hidden.bs.dropdown", f)))));
        }));
    }
    function d(b) {
        return this.each(function() {
            var c = a(this), d = c.data("bs.dropdown");
            d || c.data("bs.dropdown", d = new g(this)), "string" == typeof b && d[b].call(c);
        });
    }
    var e = ".dropdown-backdrop", f = '[data-toggle="dropdown"]', g = function(b) {
        a(b).on("click.bs.dropdown", this.toggle);
    };
    g.VERSION = "3.3.6", g.prototype.toggle = function(d) {
        var e = a(this);
        if (!e.is(".disabled, :disabled")) {
            var f = b(e), g = f.hasClass("open");
            if (c(), !g) {
                "ontouchstart" in document.documentElement && !f.closest(".navbar-nav").length && a(document.createElement("div")).addClass("dropdown-backdrop").insertAfter(a(this)).on("click", c);
                var h = {
                    relatedTarget: this
                };
                if (f.trigger(d = a.Event("show.bs.dropdown", h)), d.isDefaultPrevented()) return;
                e.trigger("focus").attr("aria-expanded", "true"), f.toggleClass("open").trigger(a.Event("shown.bs.dropdown", h));
            }
            return !1;
        }
    }, g.prototype.keydown = function(c) {
        if (/(38|40|27|32)/.test(c.which) && !/input|textarea/i.test(c.target.tagName)) {
            var d = a(this);
            if (c.preventDefault(), c.stopPropagation(), !d.is(".disabled, :disabled")) {
                var e = b(d), g = e.hasClass("open");
                if (!g && 27 != c.which || g && 27 == c.which) return 27 == c.which && e.find(f).trigger("focus"), 
                d.trigger("click");
                var h = " li:not(.disabled):visible a", i = e.find(".dropdown-menu" + h);
                if (i.length) {
                    var j = i.index(c.target);
                    38 == c.which && j > 0 && j--, 40 == c.which && j < i.length - 1 && j++, ~j || (j = 0), 
                    i.eq(j).trigger("focus");
                }
            }
        }
    };
    var h = a.fn.dropdown;
    a.fn.dropdown = d, a.fn.dropdown.Constructor = g, a.fn.dropdown.noConflict = function() {
        return a.fn.dropdown = h, this;
    }, a(document).on("click.bs.dropdown.data-api", c).on("click.bs.dropdown.data-api", ".dropdown form", function(a) {
        a.stopPropagation();
    }).on("click.bs.dropdown.data-api", f, g.prototype.toggle).on("keydown.bs.dropdown.data-api", f, g.prototype.keydown).on("keydown.bs.dropdown.data-api", ".dropdown-menu", g.prototype.keydown);
}(jQuery), +function(a) {
    "use strict";
    function b(b, d) {
        return this.each(function() {
            var e = a(this), f = e.data("bs.modal"), g = a.extend({}, c.DEFAULTS, e.data(), "object" == typeof b && b);
            f || e.data("bs.modal", f = new c(this, g)), "string" == typeof b ? f[b](d) : g.show && f.show(d);
        });
    }
    var c = function(b, c) {
        this.options = c, this.$body = a(document.body), this.$element = a(b), this.$dialog = this.$element.find(".modal-dialog"), 
        this.$backdrop = null, this.isShown = null, this.originalBodyPad = null, this.scrollbarWidth = 0, 
        this.ignoreBackdropClick = !1, this.options.remote && this.$element.find(".modal-content").load(this.options.remote, a.proxy(function() {
            this.$element.trigger("loaded.bs.modal");
        }, this));
    };
    c.VERSION = "3.3.6", c.TRANSITION_DURATION = 300, c.BACKDROP_TRANSITION_DURATION = 150, 
    c.DEFAULTS = {
        backdrop: !0,
        keyboard: !0,
        show: !0
    }, c.prototype.toggle = function(a) {
        return this.isShown ? this.hide() : this.show(a);
    }, c.prototype.show = function(b) {
        var d = this, e = a.Event("show.bs.modal", {
            relatedTarget: b
        });
        this.$element.trigger(e), this.isShown || e.isDefaultPrevented() || (this.isShown = !0, 
        this.checkScrollbar(), this.setScrollbar(), this.$body.addClass("modal-open"), this.escape(), 
        this.resize(), this.$element.on("click.dismiss.bs.modal", '[data-dismiss="modal"]', a.proxy(this.hide, this)), 
        this.$dialog.on("mousedown.dismiss.bs.modal", function() {
            d.$element.one("mouseup.dismiss.bs.modal", function(b) {
                a(b.target).is(d.$element) && (d.ignoreBackdropClick = !0);
            });
        }), this.backdrop(function() {
            var e = a.support.transition && d.$element.hasClass("fade");
            d.$element.parent().length || d.$element.appendTo(d.$body), d.$element.show().scrollTop(0), 
            d.adjustDialog(), e && d.$element[0].offsetWidth, d.$element.addClass("in"), d.enforceFocus();
            var f = a.Event("shown.bs.modal", {
                relatedTarget: b
            });
            e ? d.$dialog.one("bsTransitionEnd", function() {
                d.$element.trigger("focus").trigger(f);
            }).emulateTransitionEnd(c.TRANSITION_DURATION) : d.$element.trigger("focus").trigger(f);
        }));
    }, c.prototype.hide = function(b) {
        b && b.preventDefault(), b = a.Event("hide.bs.modal"), this.$element.trigger(b), 
        this.isShown && !b.isDefaultPrevented() && (this.isShown = !1, this.escape(), this.resize(), 
        a(document).off("focusin.bs.modal"), this.$element.removeClass("in").off("click.dismiss.bs.modal").off("mouseup.dismiss.bs.modal"), 
        this.$dialog.off("mousedown.dismiss.bs.modal"), a.support.transition && this.$element.hasClass("fade") ? this.$element.one("bsTransitionEnd", a.proxy(this.hideModal, this)).emulateTransitionEnd(c.TRANSITION_DURATION) : this.hideModal());
    }, c.prototype.enforceFocus = function() {
        a(document).off("focusin.bs.modal").on("focusin.bs.modal", a.proxy(function(a) {
            this.$element[0] === a.target || this.$element.has(a.target).length || this.$element.trigger("focus");
        }, this));
    }, c.prototype.escape = function() {
        this.isShown && this.options.keyboard ? this.$element.on("keydown.dismiss.bs.modal", a.proxy(function(a) {
            27 == a.which && this.hide();
        }, this)) : this.isShown || this.$element.off("keydown.dismiss.bs.modal");
    }, c.prototype.resize = function() {
        this.isShown ? a(window).on("resize.bs.modal", a.proxy(this.handleUpdate, this)) : a(window).off("resize.bs.modal");
    }, c.prototype.hideModal = function() {
        var a = this;
        this.$element.hide(), this.backdrop(function() {
            a.$body.removeClass("modal-open"), a.resetAdjustments(), a.resetScrollbar(), a.$element.trigger("hidden.bs.modal");
        });
    }, c.prototype.removeBackdrop = function() {
        this.$backdrop && this.$backdrop.remove(), this.$backdrop = null;
    }, c.prototype.backdrop = function(b) {
        var d = this, e = this.$element.hasClass("fade") ? "fade" : "";
        if (this.isShown && this.options.backdrop) {
            var f = a.support.transition && e;
            if (this.$backdrop = a(document.createElement("div")).addClass("modal-backdrop " + e).appendTo(this.$body), 
            this.$element.on("click.dismiss.bs.modal", a.proxy(function(a) {
                return this.ignoreBackdropClick ? void (this.ignoreBackdropClick = !1) : void (a.target === a.currentTarget && ("static" == this.options.backdrop ? this.$element[0].focus() : this.hide()));
            }, this)), f && this.$backdrop[0].offsetWidth, this.$backdrop.addClass("in"), !b) return;
            f ? this.$backdrop.one("bsTransitionEnd", b).emulateTransitionEnd(c.BACKDROP_TRANSITION_DURATION) : b();
        } else if (!this.isShown && this.$backdrop) {
            this.$backdrop.removeClass("in");
            var g = function() {
                d.removeBackdrop(), b && b();
            };
            a.support.transition && this.$element.hasClass("fade") ? this.$backdrop.one("bsTransitionEnd", g).emulateTransitionEnd(c.BACKDROP_TRANSITION_DURATION) : g();
        } else b && b();
    }, c.prototype.handleUpdate = function() {
        this.adjustDialog();
    }, c.prototype.adjustDialog = function() {
        var a = this.$element[0].scrollHeight > document.documentElement.clientHeight;
        this.$element.css({
            paddingLeft: !this.bodyIsOverflowing && a ? this.scrollbarWidth : "",
            paddingRight: this.bodyIsOverflowing && !a ? this.scrollbarWidth : ""
        });
    }, c.prototype.resetAdjustments = function() {
        this.$element.css({
            paddingLeft: "",
            paddingRight: ""
        });
    }, c.prototype.checkScrollbar = function() {
        var a = window.innerWidth;
        if (!a) {
            var b = document.documentElement.getBoundingClientRect();
            a = b.right - Math.abs(b.left);
        }
        this.bodyIsOverflowing = document.body.clientWidth < a, this.scrollbarWidth = this.measureScrollbar();
    }, c.prototype.setScrollbar = function() {
        var a = parseInt(this.$body.css("padding-right") || 0, 10);
        this.originalBodyPad = document.body.style.paddingRight || "", this.bodyIsOverflowing && this.$body.css("padding-right", a + this.scrollbarWidth);
    }, c.prototype.resetScrollbar = function() {
        this.$body.css("padding-right", this.originalBodyPad);
    }, c.prototype.measureScrollbar = function() {
        var a = document.createElement("div");
        a.className = "modal-scrollbar-measure", this.$body.append(a);
        var b = a.offsetWidth - a.clientWidth;
        return this.$body[0].removeChild(a), b;
    };
    var d = a.fn.modal;
    a.fn.modal = b, a.fn.modal.Constructor = c, a.fn.modal.noConflict = function() {
        return a.fn.modal = d, this;
    }, a(document).on("click.bs.modal.data-api", '[data-toggle="modal"]', function(c) {
        var d = a(this), e = d.attr("href"), f = a(d.attr("data-target") || e && e.replace(/.*(?=#[^\s]+$)/, "")), g = f.data("bs.modal") ? "toggle" : a.extend({
            remote: !/#/.test(e) && e
        }, f.data(), d.data());
        d.is("a") && c.preventDefault(), f.one("show.bs.modal", function(a) {
            a.isDefaultPrevented() || f.one("hidden.bs.modal", function() {
                d.is(":visible") && d.trigger("focus");
            });
        }), b.call(f, g, this);
    });
}(jQuery), +function(a) {
    "use strict";
    function b(b) {
        return this.each(function() {
            var d = a(this), e = d.data("bs.tooltip"), f = "object" == typeof b && b;
            !e && /destroy|hide/.test(b) || (e || d.data("bs.tooltip", e = new c(this, f)), 
            "string" == typeof b && e[b]());
        });
    }
    var c = function(a, b) {
        this.type = null, this.options = null, this.enabled = null, this.timeout = null, 
        this.hoverState = null, this.$element = null, this.inState = null, this.init("tooltip", a, b);
    };
    c.VERSION = "3.3.6", c.TRANSITION_DURATION = 150, c.DEFAULTS = {
        animation: !0,
        placement: "top",
        selector: !1,
        template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
        trigger: "hover focus",
        title: "",
        delay: 0,
        html: !1,
        container: !1,
        viewport: {
            selector: "body",
            padding: 0
        }
    }, c.prototype.init = function(b, c, d) {
        if (this.enabled = !0, this.type = b, this.$element = a(c), this.options = this.getOptions(d), 
        this.$viewport = this.options.viewport && a(a.isFunction(this.options.viewport) ? this.options.viewport.call(this, this.$element) : this.options.viewport.selector || this.options.viewport), 
        this.inState = {
            click: !1,
            hover: !1,
            focus: !1
        }, this.$element[0] instanceof document.constructor && !this.options.selector) throw new Error("`selector` option must be specified when initializing " + this.type + " on the window.document object!");
        for (var e = this.options.trigger.split(" "), f = e.length; f--; ) {
            var g = e[f];
            if ("click" == g) this.$element.on("click." + this.type, this.options.selector, a.proxy(this.toggle, this)); else if ("manual" != g) {
                var h = "hover" == g ? "mouseenter" : "focusin", i = "hover" == g ? "mouseleave" : "focusout";
                this.$element.on(h + "." + this.type, this.options.selector, a.proxy(this.enter, this)), 
                this.$element.on(i + "." + this.type, this.options.selector, a.proxy(this.leave, this));
            }
        }
        this.options.selector ? this._options = a.extend({}, this.options, {
            trigger: "manual",
            selector: ""
        }) : this.fixTitle();
    }, c.prototype.getDefaults = function() {
        return c.DEFAULTS;
    }, c.prototype.getOptions = function(b) {
        return b = a.extend({}, this.getDefaults(), this.$element.data(), b), b.delay && "number" == typeof b.delay && (b.delay = {
            show: b.delay,
            hide: b.delay
        }), b;
    }, c.prototype.getDelegateOptions = function() {
        var b = {}, c = this.getDefaults();
        return this._options && a.each(this._options, function(a, d) {
            c[a] != d && (b[a] = d);
        }), b;
    }, c.prototype.enter = function(b) {
        var c = b instanceof this.constructor ? b : a(b.currentTarget).data("bs." + this.type);
        return c || (c = new this.constructor(b.currentTarget, this.getDelegateOptions()), 
        a(b.currentTarget).data("bs." + this.type, c)), b instanceof a.Event && (c.inState["focusin" == b.type ? "focus" : "hover"] = !0), 
        c.tip().hasClass("in") || "in" == c.hoverState ? void (c.hoverState = "in") : (clearTimeout(c.timeout), 
        c.hoverState = "in", c.options.delay && c.options.delay.show ? void (c.timeout = setTimeout(function() {
            "in" == c.hoverState && c.show();
        }, c.options.delay.show)) : c.show());
    }, c.prototype.isInStateTrue = function() {
        for (var a in this.inState) if (this.inState[a]) return !0;
        return !1;
    }, c.prototype.leave = function(b) {
        var c = b instanceof this.constructor ? b : a(b.currentTarget).data("bs." + this.type);
        if (c || (c = new this.constructor(b.currentTarget, this.getDelegateOptions()), 
        a(b.currentTarget).data("bs." + this.type, c)), b instanceof a.Event && (c.inState["focusout" == b.type ? "focus" : "hover"] = !1), 
        !c.isInStateTrue()) return clearTimeout(c.timeout), c.hoverState = "out", c.options.delay && c.options.delay.hide ? void (c.timeout = setTimeout(function() {
            "out" == c.hoverState && c.hide();
        }, c.options.delay.hide)) : c.hide();
    }, c.prototype.show = function() {
        var b = a.Event("show.bs." + this.type);
        if (this.hasContent() && this.enabled) {
            this.$element.trigger(b);
            var d = a.contains(this.$element[0].ownerDocument.documentElement, this.$element[0]);
            if (b.isDefaultPrevented() || !d) return;
            var e = this, f = this.tip(), g = this.getUID(this.type);
            this.setContent(), f.attr("id", g), this.$element.attr("aria-describedby", g), this.options.animation && f.addClass("fade");
            var h = "function" == typeof this.options.placement ? this.options.placement.call(this, f[0], this.$element[0]) : this.options.placement, i = /\s?auto?\s?/i, j = i.test(h);
            j && (h = h.replace(i, "") || "top"), f.detach().css({
                top: 0,
                left: 0,
                display: "block"
            }).addClass(h).data("bs." + this.type, this), this.options.container ? f.appendTo(this.options.container) : f.insertAfter(this.$element), 
            this.$element.trigger("inserted.bs." + this.type);
            var k = this.getPosition(), l = f[0].offsetWidth, m = f[0].offsetHeight;
            if (j) {
                var n = h, o = this.getPosition(this.$viewport);
                h = "bottom" == h && k.bottom + m > o.bottom ? "top" : "top" == h && k.top - m < o.top ? "bottom" : "right" == h && k.right + l > o.width ? "left" : "left" == h && k.left - l < o.left ? "right" : h, 
                f.removeClass(n).addClass(h);
            }
            var p = this.getCalculatedOffset(h, k, l, m);
            this.applyPlacement(p, h);
            var q = function() {
                var a = e.hoverState;
                e.$element.trigger("shown.bs." + e.type), e.hoverState = null, "out" == a && e.leave(e);
            };
            a.support.transition && this.$tip.hasClass("fade") ? f.one("bsTransitionEnd", q).emulateTransitionEnd(c.TRANSITION_DURATION) : q();
        }
    }, c.prototype.applyPlacement = function(b, c) {
        var d = this.tip(), e = d[0].offsetWidth, f = d[0].offsetHeight, g = parseInt(d.css("margin-top"), 10), h = parseInt(d.css("margin-left"), 10);
        isNaN(g) && (g = 0), isNaN(h) && (h = 0), b.top += g, b.left += h, a.offset.setOffset(d[0], a.extend({
            using: function(a) {
                d.css({
                    top: Math.round(a.top),
                    left: Math.round(a.left)
                });
            }
        }, b), 0), d.addClass("in");
        var i = d[0].offsetWidth, j = d[0].offsetHeight;
        "top" == c && j != f && (b.top = b.top + f - j);
        var k = this.getViewportAdjustedDelta(c, b, i, j);
        k.left ? b.left += k.left : b.top += k.top;
        var l = /top|bottom/.test(c), m = l ? 2 * k.left - e + i : 2 * k.top - f + j, n = l ? "offsetWidth" : "offsetHeight";
        d.offset(b), this.replaceArrow(m, d[0][n], l);
    }, c.prototype.replaceArrow = function(a, b, c) {
        this.arrow().css(c ? "left" : "top", 50 * (1 - a / b) + "%").css(c ? "top" : "left", "");
    }, c.prototype.setContent = function() {
        var a = this.tip(), b = this.getTitle();
        a.find(".tooltip-inner")[this.options.html ? "html" : "text"](b), a.removeClass("fade in top bottom left right");
    }, c.prototype.hide = function(b) {
        function d() {
            "in" != e.hoverState && f.detach(), e.$element.removeAttr("aria-describedby").trigger("hidden.bs." + e.type), 
            b && b();
        }
        var e = this, f = a(this.$tip), g = a.Event("hide.bs." + this.type);
        if (this.$element.trigger(g), !g.isDefaultPrevented()) return f.removeClass("in"), 
        a.support.transition && f.hasClass("fade") ? f.one("bsTransitionEnd", d).emulateTransitionEnd(c.TRANSITION_DURATION) : d(), 
        this.hoverState = null, this;
    }, c.prototype.fixTitle = function() {
        var a = this.$element;
        (a.attr("title") || "string" != typeof a.attr("data-original-title")) && a.attr("data-original-title", a.attr("title") || "").attr("title", "");
    }, c.prototype.hasContent = function() {
        return this.getTitle();
    }, c.prototype.getPosition = function(b) {
        b = b || this.$element;
        var c = b[0], d = "BODY" == c.tagName, e = c.getBoundingClientRect();
        null == e.width && (e = a.extend({}, e, {
            width: e.right - e.left,
            height: e.bottom - e.top
        }));
        var f = d ? {
            top: 0,
            left: 0
        } : b.offset(), g = {
            scroll: d ? document.documentElement.scrollTop || document.body.scrollTop : b.scrollTop()
        }, h = d ? {
            width: a(window).width(),
            height: a(window).height()
        } : null;
        return a.extend({}, e, g, h, f);
    }, c.prototype.getCalculatedOffset = function(a, b, c, d) {
        return "bottom" == a ? {
            top: b.top + b.height,
            left: b.left + b.width / 2 - c / 2
        } : "top" == a ? {
            top: b.top - d,
            left: b.left + b.width / 2 - c / 2
        } : "left" == a ? {
            top: b.top + b.height / 2 - d / 2,
            left: b.left - c
        } : {
            top: b.top + b.height / 2 - d / 2,
            left: b.left + b.width
        };
    }, c.prototype.getViewportAdjustedDelta = function(a, b, c, d) {
        var e = {
            top: 0,
            left: 0
        };
        if (!this.$viewport) return e;
        var f = this.options.viewport && this.options.viewport.padding || 0, g = this.getPosition(this.$viewport);
        if (/right|left/.test(a)) {
            var h = b.top - f - g.scroll, i = b.top + f - g.scroll + d;
            h < g.top ? e.top = g.top - h : i > g.top + g.height && (e.top = g.top + g.height - i);
        } else {
            var j = b.left - f, k = b.left + f + c;
            j < g.left ? e.left = g.left - j : k > g.right && (e.left = g.left + g.width - k);
        }
        return e;
    }, c.prototype.getTitle = function() {
        var a, b = this.$element, c = this.options;
        return a = b.attr("data-original-title") || ("function" == typeof c.title ? c.title.call(b[0]) : c.title);
    }, c.prototype.getUID = function(a) {
        do a += ~~(1e6 * Math.random()); while (document.getElementById(a));
        return a;
    }, c.prototype.tip = function() {
        if (!this.$tip && (this.$tip = a(this.options.template), 1 != this.$tip.length)) throw new Error(this.type + " `template` option must consist of exactly 1 top-level element!");
        return this.$tip;
    }, c.prototype.arrow = function() {
        return this.$arrow = this.$arrow || this.tip().find(".tooltip-arrow");
    }, c.prototype.enable = function() {
        this.enabled = !0;
    }, c.prototype.disable = function() {
        this.enabled = !1;
    }, c.prototype.toggleEnabled = function() {
        this.enabled = !this.enabled;
    }, c.prototype.toggle = function(b) {
        var c = this;
        b && (c = a(b.currentTarget).data("bs." + this.type), c || (c = new this.constructor(b.currentTarget, this.getDelegateOptions()), 
        a(b.currentTarget).data("bs." + this.type, c))), b ? (c.inState.click = !c.inState.click, 
        c.isInStateTrue() ? c.enter(c) : c.leave(c)) : c.tip().hasClass("in") ? c.leave(c) : c.enter(c);
    }, c.prototype.destroy = function() {
        var a = this;
        clearTimeout(this.timeout), this.hide(function() {
            a.$element.off("." + a.type).removeData("bs." + a.type), a.$tip && a.$tip.detach(), 
            a.$tip = null, a.$arrow = null, a.$viewport = null;
        });
    };
    var d = a.fn.tooltip;
    a.fn.tooltip = b, a.fn.tooltip.Constructor = c, a.fn.tooltip.noConflict = function() {
        return a.fn.tooltip = d, this;
    };
}(jQuery), +function(a) {
    "use strict";
    function b(b) {
        return this.each(function() {
            var d = a(this), e = d.data("bs.popover"), f = "object" == typeof b && b;
            !e && /destroy|hide/.test(b) || (e || d.data("bs.popover", e = new c(this, f)), 
            "string" == typeof b && e[b]());
        });
    }
    var c = function(a, b) {
        this.init("popover", a, b);
    };
    if (!a.fn.tooltip) throw new Error("Popover requires tooltip.js");
    c.VERSION = "3.3.6", c.DEFAULTS = a.extend({}, a.fn.tooltip.Constructor.DEFAULTS, {
        placement: "right",
        trigger: "click",
        content: "",
        template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
    }), c.prototype = a.extend({}, a.fn.tooltip.Constructor.prototype), c.prototype.constructor = c, 
    c.prototype.getDefaults = function() {
        return c.DEFAULTS;
    }, c.prototype.setContent = function() {
        var a = this.tip(), b = this.getTitle(), c = this.getContent();
        a.find(".popover-title")[this.options.html ? "html" : "text"](b), a.find(".popover-content").children().detach().end()[this.options.html ? "string" == typeof c ? "html" : "append" : "text"](c), 
        a.removeClass("fade top bottom left right in"), a.find(".popover-title").html() || a.find(".popover-title").hide();
    }, c.prototype.hasContent = function() {
        return this.getTitle() || this.getContent();
    }, c.prototype.getContent = function() {
        var a = this.$element, b = this.options;
        return a.attr("data-content") || ("function" == typeof b.content ? b.content.call(a[0]) : b.content);
    }, c.prototype.arrow = function() {
        return this.$arrow = this.$arrow || this.tip().find(".arrow");
    };
    var d = a.fn.popover;
    a.fn.popover = b, a.fn.popover.Constructor = c, a.fn.popover.noConflict = function() {
        return a.fn.popover = d, this;
    };
}(jQuery), +function(a) {
    "use strict";
    function b(c, d) {
        this.$body = a(document.body), this.$scrollElement = a(a(c).is(document.body) ? window : c), 
        this.options = a.extend({}, b.DEFAULTS, d), this.selector = (this.options.target || "") + " .nav li > a", 
        this.offsets = [], this.targets = [], this.activeTarget = null, this.scrollHeight = 0, 
        this.$scrollElement.on("scroll.bs.scrollspy", a.proxy(this.process, this)), this.refresh(), 
        this.process();
    }
    function c(c) {
        return this.each(function() {
            var d = a(this), e = d.data("bs.scrollspy"), f = "object" == typeof c && c;
            e || d.data("bs.scrollspy", e = new b(this, f)), "string" == typeof c && e[c]();
        });
    }
    b.VERSION = "3.3.6", b.DEFAULTS = {
        offset: 10
    }, b.prototype.getScrollHeight = function() {
        return this.$scrollElement[0].scrollHeight || Math.max(this.$body[0].scrollHeight, document.documentElement.scrollHeight);
    }, b.prototype.refresh = function() {
        var b = this, c = "offset", d = 0;
        this.offsets = [], this.targets = [], this.scrollHeight = this.getScrollHeight(), 
        a.isWindow(this.$scrollElement[0]) || (c = "position", d = this.$scrollElement.scrollTop()), 
        this.$body.find(this.selector).map(function() {
            var b = a(this), e = b.data("target") || b.attr("href"), f = /^#./.test(e) && a(e);
            return f && f.length && f.is(":visible") && [ [ f[c]().top + d, e ] ] || null;
        }).sort(function(a, b) {
            return a[0] - b[0];
        }).each(function() {
            b.offsets.push(this[0]), b.targets.push(this[1]);
        });
    }, b.prototype.process = function() {
        var a, b = this.$scrollElement.scrollTop() + this.options.offset, c = this.getScrollHeight(), d = this.options.offset + c - this.$scrollElement.height(), e = this.offsets, f = this.targets, g = this.activeTarget;
        if (this.scrollHeight != c && this.refresh(), b >= d) return g != (a = f[f.length - 1]) && this.activate(a);
        if (g && b < e[0]) return this.activeTarget = null, this.clear();
        for (a = e.length; a--; ) g != f[a] && b >= e[a] && (void 0 === e[a + 1] || b < e[a + 1]) && this.activate(f[a]);
    }, b.prototype.activate = function(b) {
        this.activeTarget = b, this.clear();
        var c = this.selector + '[data-target="' + b + '"],' + this.selector + '[href="' + b + '"]', d = a(c).parents("li").addClass("active");
        d.parent(".dropdown-menu").length && (d = d.closest("li.dropdown").addClass("active")), 
        d.trigger("activate.bs.scrollspy");
    }, b.prototype.clear = function() {
        a(this.selector).parentsUntil(this.options.target, ".active").removeClass("active");
    };
    var d = a.fn.scrollspy;
    a.fn.scrollspy = c, a.fn.scrollspy.Constructor = b, a.fn.scrollspy.noConflict = function() {
        return a.fn.scrollspy = d, this;
    }, a(window).on("load.bs.scrollspy.data-api", function() {
        a('[data-spy="scroll"]').each(function() {
            var b = a(this);
            c.call(b, b.data());
        });
    });
}(jQuery), +function(a) {
    "use strict";
    function b(b) {
        return this.each(function() {
            var d = a(this), e = d.data("bs.tab");
            e || d.data("bs.tab", e = new c(this)), "string" == typeof b && e[b]();
        });
    }
    var c = function(b) {
        this.element = a(b);
    };
    c.VERSION = "3.3.6", c.TRANSITION_DURATION = 150, c.prototype.show = function() {
        var b = this.element, c = b.closest("ul:not(.dropdown-menu)"), d = b.data("target");
        if (d || (d = b.attr("href"), d = d && d.replace(/.*(?=#[^\s]*$)/, "")), !b.parent("li").hasClass("active")) {
            var e = c.find(".active:last a"), f = a.Event("hide.bs.tab", {
                relatedTarget: b[0]
            }), g = a.Event("show.bs.tab", {
                relatedTarget: e[0]
            });
            if (e.trigger(f), b.trigger(g), !g.isDefaultPrevented() && !f.isDefaultPrevented()) {
                var h = a(d);
                this.activate(b.closest("li"), c), this.activate(h, h.parent(), function() {
                    e.trigger({
                        type: "hidden.bs.tab",
                        relatedTarget: b[0]
                    }), b.trigger({
                        type: "shown.bs.tab",
                        relatedTarget: e[0]
                    });
                });
            }
        }
    }, c.prototype.activate = function(b, d, e) {
        function f() {
            g.removeClass("active").find("> .dropdown-menu > .active").removeClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded", !1), 
            b.addClass("active").find('[data-toggle="tab"]').attr("aria-expanded", !0), h ? (b[0].offsetWidth, 
            b.addClass("in")) : b.removeClass("fade"), b.parent(".dropdown-menu").length && b.closest("li.dropdown").addClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded", !0), 
            e && e();
        }
        var g = d.find("> .active"), h = e && a.support.transition && (g.length && g.hasClass("fade") || !!d.find("> .fade").length);
        g.length && h ? g.one("bsTransitionEnd", f).emulateTransitionEnd(c.TRANSITION_DURATION) : f(), 
        g.removeClass("in");
    };
    var d = a.fn.tab;
    a.fn.tab = b, a.fn.tab.Constructor = c, a.fn.tab.noConflict = function() {
        return a.fn.tab = d, this;
    };
    var e = function(c) {
        c.preventDefault(), b.call(a(this), "show");
    };
    a(document).on("click.bs.tab.data-api", '[data-toggle="tab"]', e).on("click.bs.tab.data-api", '[data-toggle="pill"]', e);
}(jQuery), +function(a) {
    "use strict";
    function b(b) {
        return this.each(function() {
            var d = a(this), e = d.data("bs.affix"), f = "object" == typeof b && b;
            e || d.data("bs.affix", e = new c(this, f)), "string" == typeof b && e[b]();
        });
    }
    var c = function(b, d) {
        this.options = a.extend({}, c.DEFAULTS, d), this.$target = a(this.options.target).on("scroll.bs.affix.data-api", a.proxy(this.checkPosition, this)).on("click.bs.affix.data-api", a.proxy(this.checkPositionWithEventLoop, this)), 
        this.$element = a(b), this.affixed = null, this.unpin = null, this.pinnedOffset = null, 
        this.checkPosition();
    };
    c.VERSION = "3.3.6", c.RESET = "affix affix-top affix-bottom", c.DEFAULTS = {
        offset: 0,
        target: window
    }, c.prototype.getState = function(a, b, c, d) {
        var e = this.$target.scrollTop(), f = this.$element.offset(), g = this.$target.height();
        if (null != c && "top" == this.affixed) return e < c && "top";
        if ("bottom" == this.affixed) return null != c ? !(e + this.unpin <= f.top) && "bottom" : !(e + g <= a - d) && "bottom";
        var h = null == this.affixed, i = h ? e : f.top, j = h ? g : b;
        return null != c && e <= c ? "top" : null != d && i + j >= a - d && "bottom";
    }, c.prototype.getPinnedOffset = function() {
        if (this.pinnedOffset) return this.pinnedOffset;
        this.$element.removeClass(c.RESET).addClass("affix");
        var a = this.$target.scrollTop(), b = this.$element.offset();
        return this.pinnedOffset = b.top - a;
    }, c.prototype.checkPositionWithEventLoop = function() {
        setTimeout(a.proxy(this.checkPosition, this), 1);
    }, c.prototype.checkPosition = function() {
        if (this.$element.is(":visible")) {
            var b = this.$element.height(), d = this.options.offset, e = d.top, f = d.bottom, g = Math.max(a(document).height(), a(document.body).height());
            "object" != typeof d && (f = e = d), "function" == typeof e && (e = d.top(this.$element)), 
            "function" == typeof f && (f = d.bottom(this.$element));
            var h = this.getState(g, b, e, f);
            if (this.affixed != h) {
                null != this.unpin && this.$element.css("top", "");
                var i = "affix" + (h ? "-" + h : ""), j = a.Event(i + ".bs.affix");
                if (this.$element.trigger(j), j.isDefaultPrevented()) return;
                this.affixed = h, this.unpin = "bottom" == h ? this.getPinnedOffset() : null, this.$element.removeClass(c.RESET).addClass(i).trigger(i.replace("affix", "affixed") + ".bs.affix");
            }
            "bottom" == h && this.$element.offset({
                top: g - b - f
            });
        }
    };
    var d = a.fn.affix;
    a.fn.affix = b, a.fn.affix.Constructor = c, a.fn.affix.noConflict = function() {
        return a.fn.affix = d, this;
    }, a(window).on("load", function() {
        a('[data-spy="affix"]').each(function() {
            var c = a(this), d = c.data();
            d.offset = d.offset || {}, null != d.offsetBottom && (d.offset.bottom = d.offsetBottom), 
            null != d.offsetTop && (d.offset.top = d.offsetTop), b.call(c, d);
        });
    });
}(jQuery), function(a) {
    "use strict";
    a.fn.fitVids = function(b) {
        var c = {
            customSelector: null
        };
        if (!document.getElementById("fit-vids-style")) {
            var d = document.head || document.getElementsByTagName("head")[0], e = ".fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}", f = document.createElement("div");
            f.innerHTML = '<p>x</p><style id="fit-vids-style">' + e + "</style>", d.appendChild(f.childNodes[1]);
        }
        return b && a.extend(c, b), this.each(function() {
            var b = [ "iframe[src*='player.vimeo.com']", "iframe[src*='youtube.com']", "iframe[src*='youtube-nocookie.com']", "iframe[src*='kickstarter.com'][src*='video.html']", "object", "embed" ];
            c.customSelector && b.push(c.customSelector);
            var d = a(this).find(b.join(","));
            d = d.not("object object"), d.each(function() {
                var b = a(this);
                if (!("embed" === this.tagName.toLowerCase() && b.parent("object").length || b.parent(".fluid-width-video-wrapper").length)) {
                    var c = "object" === this.tagName.toLowerCase() || b.attr("height") && !isNaN(parseInt(b.attr("height"), 10)) ? parseInt(b.attr("height"), 10) : b.height(), d = isNaN(parseInt(b.attr("width"), 10)) ? b.width() : parseInt(b.attr("width"), 10), e = c / d;
                    if (!b.attr("id")) {
                        var f = "fitvid" + Math.floor(999999 * Math.random());
                        b.attr("id", f);
                    }
                    b.wrap('<div class="fluid-width-video-wrapper"></div>').parent(".fluid-width-video-wrapper").css("padding-top", 100 * e + "%"), 
                    b.removeAttr("height").removeAttr("width");
                }
            });
        });
    };
}(window.jQuery || window.Zepto), !function(a, b) {
    "object" == typeof exports && "undefined" != typeof module ? module.exports = b() : "function" == typeof define && define.amd ? define(b) : a.moment = b();
}(this, function() {
    "use strict";
    function a() {
        return md.apply(null, arguments);
    }
    function b(a) {
        md = a;
    }
    function c(a) {
        return a instanceof Array || "[object Array]" === Object.prototype.toString.call(a);
    }
    function d(a) {
        return "[object Object]" === Object.prototype.toString.call(a);
    }
    function e(a) {
        var b;
        for (b in a) return !1;
        return !0;
    }
    function f(a) {
        return a instanceof Date || "[object Date]" === Object.prototype.toString.call(a);
    }
    function g(a, b) {
        var c, d = [];
        for (c = 0; c < a.length; ++c) d.push(b(a[c], c));
        return d;
    }
    function h(a, b) {
        return Object.prototype.hasOwnProperty.call(a, b);
    }
    function i(a, b) {
        for (var c in b) h(b, c) && (a[c] = b[c]);
        return h(b, "toString") && (a.toString = b.toString), h(b, "valueOf") && (a.valueOf = b.valueOf), 
        a;
    }
    function j(a, b, c, d) {
        return qb(a, b, c, d, !0).utc();
    }
    function k() {
        return {
            empty: !1,
            unusedTokens: [],
            unusedInput: [],
            overflow: -2,
            charsLeftOver: 0,
            nullInput: !1,
            invalidMonth: null,
            invalidFormat: !1,
            userInvalidated: !1,
            iso: !1,
            parsedDateParts: [],
            meridiem: null
        };
    }
    function l(a) {
        return null == a._pf && (a._pf = k()), a._pf;
    }
    function m(a) {
        if (null == a._isValid) {
            var b = l(a), c = nd.call(b.parsedDateParts, function(a) {
                return null != a;
            });
            a._isValid = !isNaN(a._d.getTime()) && b.overflow < 0 && !b.empty && !b.invalidMonth && !b.invalidWeekday && !b.nullInput && !b.invalidFormat && !b.userInvalidated && (!b.meridiem || b.meridiem && c), 
            a._strict && (a._isValid = a._isValid && 0 === b.charsLeftOver && 0 === b.unusedTokens.length && void 0 === b.bigHour);
        }
        return a._isValid;
    }
    function n(a) {
        var b = j(NaN);
        return null != a ? i(l(b), a) : l(b).userInvalidated = !0, b;
    }
    function o(a) {
        return void 0 === a;
    }
    function p(a, b) {
        var c, d, e;
        if (o(b._isAMomentObject) || (a._isAMomentObject = b._isAMomentObject), o(b._i) || (a._i = b._i), 
        o(b._f) || (a._f = b._f), o(b._l) || (a._l = b._l), o(b._strict) || (a._strict = b._strict), 
        o(b._tzm) || (a._tzm = b._tzm), o(b._isUTC) || (a._isUTC = b._isUTC), o(b._offset) || (a._offset = b._offset), 
        o(b._pf) || (a._pf = l(b)), o(b._locale) || (a._locale = b._locale), od.length > 0) for (c in od) d = od[c], 
        e = b[d], o(e) || (a[d] = e);
        return a;
    }
    function q(b) {
        p(this, b), this._d = new Date(null != b._d ? b._d.getTime() : NaN), pd === !1 && (pd = !0, 
        a.updateOffset(this), pd = !1);
    }
    function r(a) {
        return a instanceof q || null != a && null != a._isAMomentObject;
    }
    function s(a) {
        return 0 > a ? Math.ceil(a) || 0 : Math.floor(a);
    }
    function t(a) {
        var b = +a, c = 0;
        return 0 !== b && isFinite(b) && (c = s(b)), c;
    }
    function u(a, b, c) {
        var d, e = Math.min(a.length, b.length), f = Math.abs(a.length - b.length), g = 0;
        for (d = 0; e > d; d++) (c && a[d] !== b[d] || !c && t(a[d]) !== t(b[d])) && g++;
        return g + f;
    }
    function v(b) {
        a.suppressDeprecationWarnings === !1 && "undefined" != typeof console && console.warn && console.warn("Deprecation warning: " + b);
    }
    function w(b, c) {
        var d = !0;
        return i(function() {
            return null != a.deprecationHandler && a.deprecationHandler(null, b), d && (v(b + "\nArguments: " + Array.prototype.slice.call(arguments).join(", ") + "\n" + new Error().stack), 
            d = !1), c.apply(this, arguments);
        }, c);
    }
    function x(b, c) {
        null != a.deprecationHandler && a.deprecationHandler(b, c), qd[b] || (v(c), qd[b] = !0);
    }
    function y(a) {
        return a instanceof Function || "[object Function]" === Object.prototype.toString.call(a);
    }
    function z(a) {
        var b, c;
        for (c in a) b = a[c], y(b) ? this[c] = b : this["_" + c] = b;
        this._config = a, this._ordinalParseLenient = new RegExp(this._ordinalParse.source + "|" + /\d{1,2}/.source);
    }
    function A(a, b) {
        var c, e = i({}, a);
        for (c in b) h(b, c) && (d(a[c]) && d(b[c]) ? (e[c] = {}, i(e[c], a[c]), i(e[c], b[c])) : null != b[c] ? e[c] = b[c] : delete e[c]);
        for (c in a) h(a, c) && !h(b, c) && d(a[c]) && (e[c] = i({}, e[c]));
        return e;
    }
    function B(a) {
        null != a && this.set(a);
    }
    function C(a, b, c) {
        var d = this._calendar[a] || this._calendar.sameElse;
        return y(d) ? d.call(b, c) : d;
    }
    function D(a) {
        var b = this._longDateFormat[a], c = this._longDateFormat[a.toUpperCase()];
        return b || !c ? b : (this._longDateFormat[a] = c.replace(/MMMM|MM|DD|dddd/g, function(a) {
            return a.slice(1);
        }), this._longDateFormat[a]);
    }
    function E() {
        return this._invalidDate;
    }
    function F(a) {
        return this._ordinal.replace("%d", a);
    }
    function G(a, b, c, d) {
        var e = this._relativeTime[c];
        return y(e) ? e(a, b, c, d) : e.replace(/%d/i, a);
    }
    function H(a, b) {
        var c = this._relativeTime[a > 0 ? "future" : "past"];
        return y(c) ? c(b) : c.replace(/%s/i, b);
    }
    function I(a, b) {
        var c = a.toLowerCase();
        zd[c] = zd[c + "s"] = zd[b] = a;
    }
    function J(a) {
        return "string" == typeof a ? zd[a] || zd[a.toLowerCase()] : void 0;
    }
    function K(a) {
        var b, c, d = {};
        for (c in a) h(a, c) && (b = J(c), b && (d[b] = a[c]));
        return d;
    }
    function L(a, b) {
        Ad[a] = b;
    }
    function M(a) {
        var b = [];
        for (var c in a) b.push({
            unit: c,
            priority: Ad[c]
        });
        return b.sort(function(a, b) {
            return a.priority - b.priority;
        }), b;
    }
    function N(b, c) {
        return function(d) {
            return null != d ? (P(this, b, d), a.updateOffset(this, c), this) : O(this, b);
        };
    }
    function O(a, b) {
        return a.isValid() ? a._d["get" + (a._isUTC ? "UTC" : "") + b]() : NaN;
    }
    function P(a, b, c) {
        a.isValid() && a._d["set" + (a._isUTC ? "UTC" : "") + b](c);
    }
    function Q(a) {
        return a = J(a), y(this[a]) ? this[a]() : this;
    }
    function R(a, b) {
        if ("object" == typeof a) {
            a = K(a);
            for (var c = M(a), d = 0; d < c.length; d++) this[c[d].unit](a[c[d].unit]);
        } else if (a = J(a), y(this[a])) return this[a](b);
        return this;
    }
    function S(a, b, c) {
        var d = "" + Math.abs(a), e = b - d.length, f = a >= 0;
        return (f ? c ? "+" : "" : "-") + Math.pow(10, Math.max(0, e)).toString().substr(1) + d;
    }
    function T(a, b, c, d) {
        var e = d;
        "string" == typeof d && (e = function() {
            return this[d]();
        }), a && (Ed[a] = e), b && (Ed[b[0]] = function() {
            return S(e.apply(this, arguments), b[1], b[2]);
        }), c && (Ed[c] = function() {
            return this.localeData().ordinal(e.apply(this, arguments), a);
        });
    }
    function U(a) {
        return a.match(/\[[\s\S]/) ? a.replace(/^\[|\]$/g, "") : a.replace(/\\/g, "");
    }
    function V(a) {
        var b, c, d = a.match(Bd);
        for (b = 0, c = d.length; c > b; b++) Ed[d[b]] ? d[b] = Ed[d[b]] : d[b] = U(d[b]);
        return function(b) {
            var e, f = "";
            for (e = 0; c > e; e++) f += d[e] instanceof Function ? d[e].call(b, a) : d[e];
            return f;
        };
    }
    function W(a, b) {
        return a.isValid() ? (b = X(b, a.localeData()), Dd[b] = Dd[b] || V(b), Dd[b](a)) : a.localeData().invalidDate();
    }
    function X(a, b) {
        function c(a) {
            return b.longDateFormat(a) || a;
        }
        var d = 5;
        for (Cd.lastIndex = 0; d >= 0 && Cd.test(a); ) a = a.replace(Cd, c), Cd.lastIndex = 0, 
        d -= 1;
        return a;
    }
    function Y(a, b, c) {
        Wd[a] = y(b) ? b : function(a, d) {
            return a && c ? c : b;
        };
    }
    function Z(a, b) {
        return h(Wd, a) ? Wd[a](b._strict, b._locale) : new RegExp($(a));
    }
    function $(a) {
        return _(a.replace("\\", "").replace(/\\(\[)|\\(\])|\[([^\]\[]*)\]|\\(.)/g, function(a, b, c, d, e) {
            return b || c || d || e;
        }));
    }
    function _(a) {
        return a.replace(/[-\/\\^$*+?.()|[\]{}]/g, "\\$&");
    }
    function aa(a, b) {
        var c, d = b;
        for ("string" == typeof a && (a = [ a ]), "number" == typeof b && (d = function(a, c) {
            c[b] = t(a);
        }), c = 0; c < a.length; c++) Xd[a[c]] = d;
    }
    function ba(a, b) {
        aa(a, function(a, c, d, e) {
            d._w = d._w || {}, b(a, d._w, d, e);
        });
    }
    function ca(a, b, c) {
        null != b && h(Xd, a) && Xd[a](b, c._a, c, a);
    }
    function da(a, b) {
        return new Date(Date.UTC(a, b + 1, 0)).getUTCDate();
    }
    function ea(a, b) {
        return c(this._months) ? this._months[a.month()] : this._months[(this._months.isFormat || fe).test(b) ? "format" : "standalone"][a.month()];
    }
    function fa(a, b) {
        return c(this._monthsShort) ? this._monthsShort[a.month()] : this._monthsShort[fe.test(b) ? "format" : "standalone"][a.month()];
    }
    function ga(a, b, c) {
        var d, e, f, g = a.toLocaleLowerCase();
        if (!this._monthsParse) for (this._monthsParse = [], this._longMonthsParse = [], 
        this._shortMonthsParse = [], d = 0; 12 > d; ++d) f = j([ 2e3, d ]), this._shortMonthsParse[d] = this.monthsShort(f, "").toLocaleLowerCase(), 
        this._longMonthsParse[d] = this.months(f, "").toLocaleLowerCase();
        return c ? "MMM" === b ? (e = sd.call(this._shortMonthsParse, g), -1 !== e ? e : null) : (e = sd.call(this._longMonthsParse, g), 
        -1 !== e ? e : null) : "MMM" === b ? (e = sd.call(this._shortMonthsParse, g), -1 !== e ? e : (e = sd.call(this._longMonthsParse, g), 
        -1 !== e ? e : null)) : (e = sd.call(this._longMonthsParse, g), -1 !== e ? e : (e = sd.call(this._shortMonthsParse, g), 
        -1 !== e ? e : null));
    }
    function ha(a, b, c) {
        var d, e, f;
        if (this._monthsParseExact) return ga.call(this, a, b, c);
        for (this._monthsParse || (this._monthsParse = [], this._longMonthsParse = [], this._shortMonthsParse = []), 
        d = 0; 12 > d; d++) {
            if (e = j([ 2e3, d ]), c && !this._longMonthsParse[d] && (this._longMonthsParse[d] = new RegExp("^" + this.months(e, "").replace(".", "") + "$", "i"), 
            this._shortMonthsParse[d] = new RegExp("^" + this.monthsShort(e, "").replace(".", "") + "$", "i")), 
            c || this._monthsParse[d] || (f = "^" + this.months(e, "") + "|^" + this.monthsShort(e, ""), 
            this._monthsParse[d] = new RegExp(f.replace(".", ""), "i")), c && "MMMM" === b && this._longMonthsParse[d].test(a)) return d;
            if (c && "MMM" === b && this._shortMonthsParse[d].test(a)) return d;
            if (!c && this._monthsParse[d].test(a)) return d;
        }
    }
    function ia(a, b) {
        var c;
        if (!a.isValid()) return a;
        if ("string" == typeof b) if (/^\d+$/.test(b)) b = t(b); else if (b = a.localeData().monthsParse(b), 
        "number" != typeof b) return a;
        return c = Math.min(a.date(), da(a.year(), b)), a._d["set" + (a._isUTC ? "UTC" : "") + "Month"](b, c), 
        a;
    }
    function ja(b) {
        return null != b ? (ia(this, b), a.updateOffset(this, !0), this) : O(this, "Month");
    }
    function ka() {
        return da(this.year(), this.month());
    }
    function la(a) {
        return this._monthsParseExact ? (h(this, "_monthsRegex") || na.call(this), a ? this._monthsShortStrictRegex : this._monthsShortRegex) : (h(this, "_monthsShortRegex") || (this._monthsShortRegex = ie), 
        this._monthsShortStrictRegex && a ? this._monthsShortStrictRegex : this._monthsShortRegex);
    }
    function ma(a) {
        return this._monthsParseExact ? (h(this, "_monthsRegex") || na.call(this), a ? this._monthsStrictRegex : this._monthsRegex) : (h(this, "_monthsRegex") || (this._monthsRegex = je), 
        this._monthsStrictRegex && a ? this._monthsStrictRegex : this._monthsRegex);
    }
    function na() {
        function a(a, b) {
            return b.length - a.length;
        }
        var b, c, d = [], e = [], f = [];
        for (b = 0; 12 > b; b++) c = j([ 2e3, b ]), d.push(this.monthsShort(c, "")), e.push(this.months(c, "")), 
        f.push(this.months(c, "")), f.push(this.monthsShort(c, ""));
        for (d.sort(a), e.sort(a), f.sort(a), b = 0; 12 > b; b++) d[b] = _(d[b]), e[b] = _(e[b]);
        for (b = 0; 24 > b; b++) f[b] = _(f[b]);
        this._monthsRegex = new RegExp("^(" + f.join("|") + ")", "i"), this._monthsShortRegex = this._monthsRegex, 
        this._monthsStrictRegex = new RegExp("^(" + e.join("|") + ")", "i"), this._monthsShortStrictRegex = new RegExp("^(" + d.join("|") + ")", "i");
    }
    function oa(a) {
        return pa(a) ? 366 : 365;
    }
    function pa(a) {
        return a % 4 === 0 && a % 100 !== 0 || a % 400 === 0;
    }
    function qa() {
        return pa(this.year());
    }
    function ra(a, b, c, d, e, f, g) {
        var h = new Date(a, b, c, d, e, f, g);
        return 100 > a && a >= 0 && isFinite(h.getFullYear()) && h.setFullYear(a), h;
    }
    function sa(a) {
        var b = new Date(Date.UTC.apply(null, arguments));
        return 100 > a && a >= 0 && isFinite(b.getUTCFullYear()) && b.setUTCFullYear(a), 
        b;
    }
    function ta(a, b, c) {
        var d = 7 + b - c, e = (7 + sa(a, 0, d).getUTCDay() - b) % 7;
        return -e + d - 1;
    }
    function ua(a, b, c, d, e) {
        var f, g, h = (7 + c - d) % 7, i = ta(a, d, e), j = 1 + 7 * (b - 1) + h + i;
        return 0 >= j ? (f = a - 1, g = oa(f) + j) : j > oa(a) ? (f = a + 1, g = j - oa(a)) : (f = a, 
        g = j), {
            year: f,
            dayOfYear: g
        };
    }
    function va(a, b, c) {
        var d, e, f = ta(a.year(), b, c), g = Math.floor((a.dayOfYear() - f - 1) / 7) + 1;
        return 1 > g ? (e = a.year() - 1, d = g + wa(e, b, c)) : g > wa(a.year(), b, c) ? (d = g - wa(a.year(), b, c), 
        e = a.year() + 1) : (e = a.year(), d = g), {
            week: d,
            year: e
        };
    }
    function wa(a, b, c) {
        var d = ta(a, b, c), e = ta(a + 1, b, c);
        return (oa(a) - d + e) / 7;
    }
    function xa(a) {
        return va(a, this._week.dow, this._week.doy).week;
    }
    function ya() {
        return this._week.dow;
    }
    function za() {
        return this._week.doy;
    }
    function Aa(a) {
        var b = this.localeData().week(this);
        return null == a ? b : this.add(7 * (a - b), "d");
    }
    function Ba(a) {
        var b = va(this, 1, 4).week;
        return null == a ? b : this.add(7 * (a - b), "d");
    }
    function Ca(a, b) {
        return "string" != typeof a ? a : isNaN(a) ? (a = b.weekdaysParse(a), "number" == typeof a ? a : null) : parseInt(a, 10);
    }
    function Da(a, b) {
        return "string" == typeof a ? b.weekdaysParse(a) % 7 || 7 : isNaN(a) ? null : a;
    }
    function Ea(a, b) {
        return c(this._weekdays) ? this._weekdays[a.day()] : this._weekdays[this._weekdays.isFormat.test(b) ? "format" : "standalone"][a.day()];
    }
    function Fa(a) {
        return this._weekdaysShort[a.day()];
    }
    function Ga(a) {
        return this._weekdaysMin[a.day()];
    }
    function Ha(a, b, c) {
        var d, e, f, g = a.toLocaleLowerCase();
        if (!this._weekdaysParse) for (this._weekdaysParse = [], this._shortWeekdaysParse = [], 
        this._minWeekdaysParse = [], d = 0; 7 > d; ++d) f = j([ 2e3, 1 ]).day(d), this._minWeekdaysParse[d] = this.weekdaysMin(f, "").toLocaleLowerCase(), 
        this._shortWeekdaysParse[d] = this.weekdaysShort(f, "").toLocaleLowerCase(), this._weekdaysParse[d] = this.weekdays(f, "").toLocaleLowerCase();
        return c ? "dddd" === b ? (e = sd.call(this._weekdaysParse, g), -1 !== e ? e : null) : "ddd" === b ? (e = sd.call(this._shortWeekdaysParse, g), 
        -1 !== e ? e : null) : (e = sd.call(this._minWeekdaysParse, g), -1 !== e ? e : null) : "dddd" === b ? (e = sd.call(this._weekdaysParse, g), 
        -1 !== e ? e : (e = sd.call(this._shortWeekdaysParse, g), -1 !== e ? e : (e = sd.call(this._minWeekdaysParse, g), 
        -1 !== e ? e : null))) : "ddd" === b ? (e = sd.call(this._shortWeekdaysParse, g), 
        -1 !== e ? e : (e = sd.call(this._weekdaysParse, g), -1 !== e ? e : (e = sd.call(this._minWeekdaysParse, g), 
        -1 !== e ? e : null))) : (e = sd.call(this._minWeekdaysParse, g), -1 !== e ? e : (e = sd.call(this._weekdaysParse, g), 
        -1 !== e ? e : (e = sd.call(this._shortWeekdaysParse, g), -1 !== e ? e : null)));
    }
    function Ia(a, b, c) {
        var d, e, f;
        if (this._weekdaysParseExact) return Ha.call(this, a, b, c);
        for (this._weekdaysParse || (this._weekdaysParse = [], this._minWeekdaysParse = [], 
        this._shortWeekdaysParse = [], this._fullWeekdaysParse = []), d = 0; 7 > d; d++) {
            if (e = j([ 2e3, 1 ]).day(d), c && !this._fullWeekdaysParse[d] && (this._fullWeekdaysParse[d] = new RegExp("^" + this.weekdays(e, "").replace(".", ".?") + "$", "i"), 
            this._shortWeekdaysParse[d] = new RegExp("^" + this.weekdaysShort(e, "").replace(".", ".?") + "$", "i"), 
            this._minWeekdaysParse[d] = new RegExp("^" + this.weekdaysMin(e, "").replace(".", ".?") + "$", "i")), 
            this._weekdaysParse[d] || (f = "^" + this.weekdays(e, "") + "|^" + this.weekdaysShort(e, "") + "|^" + this.weekdaysMin(e, ""), 
            this._weekdaysParse[d] = new RegExp(f.replace(".", ""), "i")), c && "dddd" === b && this._fullWeekdaysParse[d].test(a)) return d;
            if (c && "ddd" === b && this._shortWeekdaysParse[d].test(a)) return d;
            if (c && "dd" === b && this._minWeekdaysParse[d].test(a)) return d;
            if (!c && this._weekdaysParse[d].test(a)) return d;
        }
    }
    function Ja(a) {
        if (!this.isValid()) return null != a ? this : NaN;
        var b = this._isUTC ? this._d.getUTCDay() : this._d.getDay();
        return null != a ? (a = Ca(a, this.localeData()), this.add(a - b, "d")) : b;
    }
    function Ka(a) {
        if (!this.isValid()) return null != a ? this : NaN;
        var b = (this.day() + 7 - this.localeData()._week.dow) % 7;
        return null == a ? b : this.add(a - b, "d");
    }
    function La(a) {
        if (!this.isValid()) return null != a ? this : NaN;
        if (null != a) {
            var b = Da(a, this.localeData());
            return this.day(this.day() % 7 ? b : b - 7);
        }
        return this.day() || 7;
    }
    function Ma(a) {
        return this._weekdaysParseExact ? (h(this, "_weekdaysRegex") || Pa.call(this), a ? this._weekdaysStrictRegex : this._weekdaysRegex) : (h(this, "_weekdaysRegex") || (this._weekdaysRegex = pe), 
        this._weekdaysStrictRegex && a ? this._weekdaysStrictRegex : this._weekdaysRegex);
    }
    function Na(a) {
        return this._weekdaysParseExact ? (h(this, "_weekdaysRegex") || Pa.call(this), a ? this._weekdaysShortStrictRegex : this._weekdaysShortRegex) : (h(this, "_weekdaysShortRegex") || (this._weekdaysShortRegex = qe), 
        this._weekdaysShortStrictRegex && a ? this._weekdaysShortStrictRegex : this._weekdaysShortRegex);
    }
    function Oa(a) {
        return this._weekdaysParseExact ? (h(this, "_weekdaysRegex") || Pa.call(this), a ? this._weekdaysMinStrictRegex : this._weekdaysMinRegex) : (h(this, "_weekdaysMinRegex") || (this._weekdaysMinRegex = re), 
        this._weekdaysMinStrictRegex && a ? this._weekdaysMinStrictRegex : this._weekdaysMinRegex);
    }
    function Pa() {
        function a(a, b) {
            return b.length - a.length;
        }
        var b, c, d, e, f, g = [], h = [], i = [], k = [];
        for (b = 0; 7 > b; b++) c = j([ 2e3, 1 ]).day(b), d = this.weekdaysMin(c, ""), e = this.weekdaysShort(c, ""), 
        f = this.weekdays(c, ""), g.push(d), h.push(e), i.push(f), k.push(d), k.push(e), 
        k.push(f);
        for (g.sort(a), h.sort(a), i.sort(a), k.sort(a), b = 0; 7 > b; b++) h[b] = _(h[b]), 
        i[b] = _(i[b]), k[b] = _(k[b]);
        this._weekdaysRegex = new RegExp("^(" + k.join("|") + ")", "i"), this._weekdaysShortRegex = this._weekdaysRegex, 
        this._weekdaysMinRegex = this._weekdaysRegex, this._weekdaysStrictRegex = new RegExp("^(" + i.join("|") + ")", "i"), 
        this._weekdaysShortStrictRegex = new RegExp("^(" + h.join("|") + ")", "i"), this._weekdaysMinStrictRegex = new RegExp("^(" + g.join("|") + ")", "i");
    }
    function Qa() {
        return this.hours() % 12 || 12;
    }
    function Ra() {
        return this.hours() || 24;
    }
    function Sa(a, b) {
        T(a, 0, 0, function() {
            return this.localeData().meridiem(this.hours(), this.minutes(), b);
        });
    }
    function Ta(a, b) {
        return b._meridiemParse;
    }
    function Ua(a) {
        return "p" === (a + "").toLowerCase().charAt(0);
    }
    function Va(a, b, c) {
        return a > 11 ? c ? "pm" : "PM" : c ? "am" : "AM";
    }
    function Wa(a) {
        return a ? a.toLowerCase().replace("_", "-") : a;
    }
    function Xa(a) {
        for (var b, c, d, e, f = 0; f < a.length; ) {
            for (e = Wa(a[f]).split("-"), b = e.length, c = Wa(a[f + 1]), c = c ? c.split("-") : null; b > 0; ) {
                if (d = Ya(e.slice(0, b).join("-"))) return d;
                if (c && c.length >= b && u(e, c, !0) >= b - 1) break;
                b--;
            }
            f++;
        }
        return null;
    }
    function Ya(a) {
        var b = null;
        if (!we[a] && "undefined" != typeof module && module && module.exports) try {
            b = se._abbr, require("./locale/" + a), Za(b);
        } catch (c) {}
        return we[a];
    }
    function Za(a, b) {
        var c;
        return a && (c = o(b) ? ab(a) : $a(a, b), c && (se = c)), se._abbr;
    }
    function $a(a, b) {
        if (null !== b) {
            var c = ve;
            return b.abbr = a, null != we[a] ? (x("defineLocaleOverride", "use moment.updateLocale(localeName, config) to change an existing locale. moment.defineLocale(localeName, config) should only be used for creating a new locale See http://momentjs.com/guides/#/warnings/define-locale/ for more info."), 
            c = we[a]._config) : null != b.parentLocale && (null != we[b.parentLocale] ? c = we[b.parentLocale]._config : x("parentLocaleUndefined", "specified parentLocale is not defined yet. See http://momentjs.com/guides/#/warnings/parent-locale/")), 
            we[a] = new B(A(c, b)), Za(a), we[a];
        }
        return delete we[a], null;
    }
    function _a(a, b) {
        if (null != b) {
            var c, d = ve;
            null != we[a] && (d = we[a]._config), b = A(d, b), c = new B(b), c.parentLocale = we[a], 
            we[a] = c, Za(a);
        } else null != we[a] && (null != we[a].parentLocale ? we[a] = we[a].parentLocale : null != we[a] && delete we[a]);
        return we[a];
    }
    function ab(a) {
        var b;
        if (a && a._locale && a._locale._abbr && (a = a._locale._abbr), !a) return se;
        if (!c(a)) {
            if (b = Ya(a)) return b;
            a = [ a ];
        }
        return Xa(a);
    }
    function bb() {
        return rd(we);
    }
    function cb(a) {
        var b, c = a._a;
        return c && -2 === l(a).overflow && (b = c[Zd] < 0 || c[Zd] > 11 ? Zd : c[$d] < 1 || c[$d] > da(c[Yd], c[Zd]) ? $d : c[_d] < 0 || c[_d] > 24 || 24 === c[_d] && (0 !== c[ae] || 0 !== c[be] || 0 !== c[ce]) ? _d : c[ae] < 0 || c[ae] > 59 ? ae : c[be] < 0 || c[be] > 59 ? be : c[ce] < 0 || c[ce] > 999 ? ce : -1, 
        l(a)._overflowDayOfYear && (Yd > b || b > $d) && (b = $d), l(a)._overflowWeeks && -1 === b && (b = de), 
        l(a)._overflowWeekday && -1 === b && (b = ee), l(a).overflow = b), a;
    }
    function db(a) {
        var b, c, d, e, f, g, h = a._i, i = xe.exec(h) || ye.exec(h);
        if (i) {
            for (l(a).iso = !0, b = 0, c = Ae.length; c > b; b++) if (Ae[b][1].exec(i[1])) {
                e = Ae[b][0], d = Ae[b][2] !== !1;
                break;
            }
            if (null == e) return void (a._isValid = !1);
            if (i[3]) {
                for (b = 0, c = Be.length; c > b; b++) if (Be[b][1].exec(i[3])) {
                    f = (i[2] || " ") + Be[b][0];
                    break;
                }
                if (null == f) return void (a._isValid = !1);
            }
            if (!d && null != f) return void (a._isValid = !1);
            if (i[4]) {
                if (!ze.exec(i[4])) return void (a._isValid = !1);
                g = "Z";
            }
            a._f = e + (f || "") + (g || ""), jb(a);
        } else a._isValid = !1;
    }
    function eb(b) {
        var c = Ce.exec(b._i);
        return null !== c ? void (b._d = new Date((+c[1]))) : (db(b), void (b._isValid === !1 && (delete b._isValid, 
        a.createFromInputFallback(b))));
    }
    function fb(a, b, c) {
        return null != a ? a : null != b ? b : c;
    }
    function gb(b) {
        var c = new Date(a.now());
        return b._useUTC ? [ c.getUTCFullYear(), c.getUTCMonth(), c.getUTCDate() ] : [ c.getFullYear(), c.getMonth(), c.getDate() ];
    }
    function hb(a) {
        var b, c, d, e, f = [];
        if (!a._d) {
            for (d = gb(a), a._w && null == a._a[$d] && null == a._a[Zd] && ib(a), a._dayOfYear && (e = fb(a._a[Yd], d[Yd]), 
            a._dayOfYear > oa(e) && (l(a)._overflowDayOfYear = !0), c = sa(e, 0, a._dayOfYear), 
            a._a[Zd] = c.getUTCMonth(), a._a[$d] = c.getUTCDate()), b = 0; 3 > b && null == a._a[b]; ++b) a._a[b] = f[b] = d[b];
            for (;7 > b; b++) a._a[b] = f[b] = null == a._a[b] ? 2 === b ? 1 : 0 : a._a[b];
            24 === a._a[_d] && 0 === a._a[ae] && 0 === a._a[be] && 0 === a._a[ce] && (a._nextDay = !0, 
            a._a[_d] = 0), a._d = (a._useUTC ? sa : ra).apply(null, f), null != a._tzm && a._d.setUTCMinutes(a._d.getUTCMinutes() - a._tzm), 
            a._nextDay && (a._a[_d] = 24);
        }
    }
    function ib(a) {
        var b, c, d, e, f, g, h, i;
        b = a._w, null != b.GG || null != b.W || null != b.E ? (f = 1, g = 4, c = fb(b.GG, a._a[Yd], va(rb(), 1, 4).year), 
        d = fb(b.W, 1), e = fb(b.E, 1), (1 > e || e > 7) && (i = !0)) : (f = a._locale._week.dow, 
        g = a._locale._week.doy, c = fb(b.gg, a._a[Yd], va(rb(), f, g).year), d = fb(b.w, 1), 
        null != b.d ? (e = b.d, (0 > e || e > 6) && (i = !0)) : null != b.e ? (e = b.e + f, 
        (b.e < 0 || b.e > 6) && (i = !0)) : e = f), 1 > d || d > wa(c, f, g) ? l(a)._overflowWeeks = !0 : null != i ? l(a)._overflowWeekday = !0 : (h = ua(c, d, e, f, g), 
        a._a[Yd] = h.year, a._dayOfYear = h.dayOfYear);
    }
    function jb(b) {
        if (b._f === a.ISO_8601) return void db(b);
        b._a = [], l(b).empty = !0;
        var c, d, e, f, g, h = "" + b._i, i = h.length, j = 0;
        for (e = X(b._f, b._locale).match(Bd) || [], c = 0; c < e.length; c++) f = e[c], 
        d = (h.match(Z(f, b)) || [])[0], d && (g = h.substr(0, h.indexOf(d)), g.length > 0 && l(b).unusedInput.push(g), 
        h = h.slice(h.indexOf(d) + d.length), j += d.length), Ed[f] ? (d ? l(b).empty = !1 : l(b).unusedTokens.push(f), 
        ca(f, d, b)) : b._strict && !d && l(b).unusedTokens.push(f);
        l(b).charsLeftOver = i - j, h.length > 0 && l(b).unusedInput.push(h), b._a[_d] <= 12 && l(b).bigHour === !0 && b._a[_d] > 0 && (l(b).bigHour = void 0), 
        l(b).parsedDateParts = b._a.slice(0), l(b).meridiem = b._meridiem, b._a[_d] = kb(b._locale, b._a[_d], b._meridiem), 
        hb(b), cb(b);
    }
    function kb(a, b, c) {
        var d;
        return null == c ? b : null != a.meridiemHour ? a.meridiemHour(b, c) : null != a.isPM ? (d = a.isPM(c), 
        d && 12 > b && (b += 12), d || 12 !== b || (b = 0), b) : b;
    }
    function lb(a) {
        var b, c, d, e, f;
        if (0 === a._f.length) return l(a).invalidFormat = !0, void (a._d = new Date(NaN));
        for (e = 0; e < a._f.length; e++) f = 0, b = p({}, a), null != a._useUTC && (b._useUTC = a._useUTC), 
        b._f = a._f[e], jb(b), m(b) && (f += l(b).charsLeftOver, f += 10 * l(b).unusedTokens.length, 
        l(b).score = f, (null == d || d > f) && (d = f, c = b));
        i(a, c || b);
    }
    function mb(a) {
        if (!a._d) {
            var b = K(a._i);
            a._a = g([ b.year, b.month, b.day || b.date, b.hour, b.minute, b.second, b.millisecond ], function(a) {
                return a && parseInt(a, 10);
            }), hb(a);
        }
    }
    function nb(a) {
        var b = new q(cb(ob(a)));
        return b._nextDay && (b.add(1, "d"), b._nextDay = void 0), b;
    }
    function ob(a) {
        var b = a._i, d = a._f;
        return a._locale = a._locale || ab(a._l), null === b || void 0 === d && "" === b ? n({
            nullInput: !0
        }) : ("string" == typeof b && (a._i = b = a._locale.preparse(b)), r(b) ? new q(cb(b)) : (c(d) ? lb(a) : f(b) ? a._d = b : d ? jb(a) : pb(a), 
        m(a) || (a._d = null), a));
    }
    function pb(b) {
        var d = b._i;
        void 0 === d ? b._d = new Date(a.now()) : f(d) ? b._d = new Date(d.valueOf()) : "string" == typeof d ? eb(b) : c(d) ? (b._a = g(d.slice(0), function(a) {
            return parseInt(a, 10);
        }), hb(b)) : "object" == typeof d ? mb(b) : "number" == typeof d ? b._d = new Date(d) : a.createFromInputFallback(b);
    }
    function qb(a, b, f, g, h) {
        var i = {};
        return "boolean" == typeof f && (g = f, f = void 0), (d(a) && e(a) || c(a) && 0 === a.length) && (a = void 0), 
        i._isAMomentObject = !0, i._useUTC = i._isUTC = h, i._l = f, i._i = a, i._f = b, 
        i._strict = g, nb(i);
    }
    function rb(a, b, c, d) {
        return qb(a, b, c, d, !1);
    }
    function sb(a, b) {
        var d, e;
        if (1 === b.length && c(b[0]) && (b = b[0]), !b.length) return rb();
        for (d = b[0], e = 1; e < b.length; ++e) b[e].isValid() && !b[e][a](d) || (d = b[e]);
        return d;
    }
    function tb() {
        var a = [].slice.call(arguments, 0);
        return sb("isBefore", a);
    }
    function ub() {
        var a = [].slice.call(arguments, 0);
        return sb("isAfter", a);
    }
    function vb(a) {
        var b = K(a), c = b.year || 0, d = b.quarter || 0, e = b.month || 0, f = b.week || 0, g = b.day || 0, h = b.hour || 0, i = b.minute || 0, j = b.second || 0, k = b.millisecond || 0;
        this._milliseconds = +k + 1e3 * j + 6e4 * i + 1e3 * h * 60 * 60, this._days = +g + 7 * f, 
        this._months = +e + 3 * d + 12 * c, this._data = {}, this._locale = ab(), this._bubble();
    }
    function wb(a) {
        return a instanceof vb;
    }
    function xb(a, b) {
        T(a, 0, 0, function() {
            var a = this.utcOffset(), c = "+";
            return 0 > a && (a = -a, c = "-"), c + S(~~(a / 60), 2) + b + S(~~a % 60, 2);
        });
    }
    function yb(a, b) {
        var c = (b || "").match(a) || [], d = c[c.length - 1] || [], e = (d + "").match(Ge) || [ "-", 0, 0 ], f = +(60 * e[1]) + t(e[2]);
        return "+" === e[0] ? f : -f;
    }
    function zb(b, c) {
        var d, e;
        return c._isUTC ? (d = c.clone(), e = (r(b) || f(b) ? b.valueOf() : rb(b).valueOf()) - d.valueOf(), 
        d._d.setTime(d._d.valueOf() + e), a.updateOffset(d, !1), d) : rb(b).local();
    }
    function Ab(a) {
        return 15 * -Math.round(a._d.getTimezoneOffset() / 15);
    }
    function Bb(b, c) {
        var d, e = this._offset || 0;
        return this.isValid() ? null != b ? ("string" == typeof b ? b = yb(Td, b) : Math.abs(b) < 16 && (b = 60 * b), 
        !this._isUTC && c && (d = Ab(this)), this._offset = b, this._isUTC = !0, null != d && this.add(d, "m"), 
        e !== b && (!c || this._changeInProgress ? Sb(this, Mb(b - e, "m"), 1, !1) : this._changeInProgress || (this._changeInProgress = !0, 
        a.updateOffset(this, !0), this._changeInProgress = null)), this) : this._isUTC ? e : Ab(this) : null != b ? this : NaN;
    }
    function Cb(a, b) {
        return null != a ? ("string" != typeof a && (a = -a), this.utcOffset(a, b), this) : -this.utcOffset();
    }
    function Db(a) {
        return this.utcOffset(0, a);
    }
    function Eb(a) {
        return this._isUTC && (this.utcOffset(0, a), this._isUTC = !1, a && this.subtract(Ab(this), "m")), 
        this;
    }
    function Fb() {
        return this._tzm ? this.utcOffset(this._tzm) : "string" == typeof this._i && this.utcOffset(yb(Sd, this._i)), 
        this;
    }
    function Gb(a) {
        return !!this.isValid() && (a = a ? rb(a).utcOffset() : 0, (this.utcOffset() - a) % 60 === 0);
    }
    function Hb() {
        return this.utcOffset() > this.clone().month(0).utcOffset() || this.utcOffset() > this.clone().month(5).utcOffset();
    }
    function Ib() {
        if (!o(this._isDSTShifted)) return this._isDSTShifted;
        var a = {};
        if (p(a, this), a = ob(a), a._a) {
            var b = a._isUTC ? j(a._a) : rb(a._a);
            this._isDSTShifted = this.isValid() && u(a._a, b.toArray()) > 0;
        } else this._isDSTShifted = !1;
        return this._isDSTShifted;
    }
    function Jb() {
        return !!this.isValid() && !this._isUTC;
    }
    function Kb() {
        return !!this.isValid() && this._isUTC;
    }
    function Lb() {
        return !!this.isValid() && (this._isUTC && 0 === this._offset);
    }
    function Mb(a, b) {
        var c, d, e, f = a, g = null;
        return wb(a) ? f = {
            ms: a._milliseconds,
            d: a._days,
            M: a._months
        } : "number" == typeof a ? (f = {}, b ? f[b] = a : f.milliseconds = a) : (g = He.exec(a)) ? (c = "-" === g[1] ? -1 : 1, 
        f = {
            y: 0,
            d: t(g[$d]) * c,
            h: t(g[_d]) * c,
            m: t(g[ae]) * c,
            s: t(g[be]) * c,
            ms: t(g[ce]) * c
        }) : (g = Ie.exec(a)) ? (c = "-" === g[1] ? -1 : 1, f = {
            y: Nb(g[2], c),
            M: Nb(g[3], c),
            w: Nb(g[4], c),
            d: Nb(g[5], c),
            h: Nb(g[6], c),
            m: Nb(g[7], c),
            s: Nb(g[8], c)
        }) : null == f ? f = {} : "object" == typeof f && ("from" in f || "to" in f) && (e = Pb(rb(f.from), rb(f.to)), 
        f = {}, f.ms = e.milliseconds, f.M = e.months), d = new vb(f), wb(a) && h(a, "_locale") && (d._locale = a._locale), 
        d;
    }
    function Nb(a, b) {
        var c = a && parseFloat(a.replace(",", "."));
        return (isNaN(c) ? 0 : c) * b;
    }
    function Ob(a, b) {
        var c = {
            milliseconds: 0,
            months: 0
        };
        return c.months = b.month() - a.month() + 12 * (b.year() - a.year()), a.clone().add(c.months, "M").isAfter(b) && --c.months, 
        c.milliseconds = +b - +a.clone().add(c.months, "M"), c;
    }
    function Pb(a, b) {
        var c;
        return a.isValid() && b.isValid() ? (b = zb(b, a), a.isBefore(b) ? c = Ob(a, b) : (c = Ob(b, a), 
        c.milliseconds = -c.milliseconds, c.months = -c.months), c) : {
            milliseconds: 0,
            months: 0
        };
    }
    function Qb(a) {
        return 0 > a ? -1 * Math.round(-1 * a) : Math.round(a);
    }
    function Rb(a, b) {
        return function(c, d) {
            var e, f;
            return null === d || isNaN(+d) || (x(b, "moment()." + b + "(period, number) is deprecated. Please use moment()." + b + "(number, period). See http://momentjs.com/guides/#/warnings/add-inverted-param/ for more info."), 
            f = c, c = d, d = f), c = "string" == typeof c ? +c : c, e = Mb(c, d), Sb(this, e, a), 
            this;
        };
    }
    function Sb(b, c, d, e) {
        var f = c._milliseconds, g = Qb(c._days), h = Qb(c._months);
        b.isValid() && (e = null == e || e, f && b._d.setTime(b._d.valueOf() + f * d), g && P(b, "Date", O(b, "Date") + g * d), 
        h && ia(b, O(b, "Month") + h * d), e && a.updateOffset(b, g || h));
    }
    function Tb(a, b) {
        var c = a.diff(b, "days", !0);
        return -6 > c ? "sameElse" : -1 > c ? "lastWeek" : 0 > c ? "lastDay" : 1 > c ? "sameDay" : 2 > c ? "nextDay" : 7 > c ? "nextWeek" : "sameElse";
    }
    function Ub(b, c) {
        var d = b || rb(), e = zb(d, this).startOf("day"), f = a.calendarFormat(this, e) || "sameElse", g = c && (y(c[f]) ? c[f].call(this, d) : c[f]);
        return this.format(g || this.localeData().calendar(f, this, rb(d)));
    }
    function Vb() {
        return new q(this);
    }
    function Wb(a, b) {
        var c = r(a) ? a : rb(a);
        return !(!this.isValid() || !c.isValid()) && (b = J(o(b) ? "millisecond" : b), "millisecond" === b ? this.valueOf() > c.valueOf() : c.valueOf() < this.clone().startOf(b).valueOf());
    }
    function Xb(a, b) {
        var c = r(a) ? a : rb(a);
        return !(!this.isValid() || !c.isValid()) && (b = J(o(b) ? "millisecond" : b), "millisecond" === b ? this.valueOf() < c.valueOf() : this.clone().endOf(b).valueOf() < c.valueOf());
    }
    function Yb(a, b, c, d) {
        return d = d || "()", ("(" === d[0] ? this.isAfter(a, c) : !this.isBefore(a, c)) && (")" === d[1] ? this.isBefore(b, c) : !this.isAfter(b, c));
    }
    function Zb(a, b) {
        var c, d = r(a) ? a : rb(a);
        return !(!this.isValid() || !d.isValid()) && (b = J(b || "millisecond"), "millisecond" === b ? this.valueOf() === d.valueOf() : (c = d.valueOf(), 
        this.clone().startOf(b).valueOf() <= c && c <= this.clone().endOf(b).valueOf()));
    }
    function $b(a, b) {
        return this.isSame(a, b) || this.isAfter(a, b);
    }
    function _b(a, b) {
        return this.isSame(a, b) || this.isBefore(a, b);
    }
    function ac(a, b, c) {
        var d, e, f, g;
        return this.isValid() ? (d = zb(a, this), d.isValid() ? (e = 6e4 * (d.utcOffset() - this.utcOffset()), 
        b = J(b), "year" === b || "month" === b || "quarter" === b ? (g = bc(this, d), "quarter" === b ? g /= 3 : "year" === b && (g /= 12)) : (f = this - d, 
        g = "second" === b ? f / 1e3 : "minute" === b ? f / 6e4 : "hour" === b ? f / 36e5 : "day" === b ? (f - e) / 864e5 : "week" === b ? (f - e) / 6048e5 : f), 
        c ? g : s(g)) : NaN) : NaN;
    }
    function bc(a, b) {
        var c, d, e = 12 * (b.year() - a.year()) + (b.month() - a.month()), f = a.clone().add(e, "months");
        return 0 > b - f ? (c = a.clone().add(e - 1, "months"), d = (b - f) / (f - c)) : (c = a.clone().add(e + 1, "months"), 
        d = (b - f) / (c - f)), -(e + d) || 0;
    }
    function cc() {
        return this.clone().locale("en").format("ddd MMM DD YYYY HH:mm:ss [GMT]ZZ");
    }
    function dc() {
        var a = this.clone().utc();
        return 0 < a.year() && a.year() <= 9999 ? y(Date.prototype.toISOString) ? this.toDate().toISOString() : W(a, "YYYY-MM-DD[T]HH:mm:ss.SSS[Z]") : W(a, "YYYYYY-MM-DD[T]HH:mm:ss.SSS[Z]");
    }
    function ec(b) {
        b || (b = this.isUtc() ? a.defaultFormatUtc : a.defaultFormat);
        var c = W(this, b);
        return this.localeData().postformat(c);
    }
    function fc(a, b) {
        return this.isValid() && (r(a) && a.isValid() || rb(a).isValid()) ? Mb({
            to: this,
            from: a
        }).locale(this.locale()).humanize(!b) : this.localeData().invalidDate();
    }
    function gc(a) {
        return this.from(rb(), a);
    }
    function hc(a, b) {
        return this.isValid() && (r(a) && a.isValid() || rb(a).isValid()) ? Mb({
            from: this,
            to: a
        }).locale(this.locale()).humanize(!b) : this.localeData().invalidDate();
    }
    function ic(a) {
        return this.to(rb(), a);
    }
    function jc(a) {
        var b;
        return void 0 === a ? this._locale._abbr : (b = ab(a), null != b && (this._locale = b), 
        this);
    }
    function kc() {
        return this._locale;
    }
    function lc(a) {
        switch (a = J(a)) {
          case "year":
            this.month(0);

          case "quarter":
          case "month":
            this.date(1);

          case "week":
          case "isoWeek":
          case "day":
          case "date":
            this.hours(0);

          case "hour":
            this.minutes(0);

          case "minute":
            this.seconds(0);

          case "second":
            this.milliseconds(0);
        }
        return "week" === a && this.weekday(0), "isoWeek" === a && this.isoWeekday(1), "quarter" === a && this.month(3 * Math.floor(this.month() / 3)), 
        this;
    }
    function mc(a) {
        return a = J(a), void 0 === a || "millisecond" === a ? this : ("date" === a && (a = "day"), 
        this.startOf(a).add(1, "isoWeek" === a ? "week" : a).subtract(1, "ms"));
    }
    function nc() {
        return this._d.valueOf() - 6e4 * (this._offset || 0);
    }
    function oc() {
        return Math.floor(this.valueOf() / 1e3);
    }
    function pc() {
        return new Date(this.valueOf());
    }
    function qc() {
        var a = this;
        return [ a.year(), a.month(), a.date(), a.hour(), a.minute(), a.second(), a.millisecond() ];
    }
    function rc() {
        var a = this;
        return {
            years: a.year(),
            months: a.month(),
            date: a.date(),
            hours: a.hours(),
            minutes: a.minutes(),
            seconds: a.seconds(),
            milliseconds: a.milliseconds()
        };
    }
    function sc() {
        return this.isValid() ? this.toISOString() : null;
    }
    function tc() {
        return m(this);
    }
    function uc() {
        return i({}, l(this));
    }
    function vc() {
        return l(this).overflow;
    }
    function wc() {
        return {
            input: this._i,
            format: this._f,
            locale: this._locale,
            isUTC: this._isUTC,
            strict: this._strict
        };
    }
    function xc(a, b) {
        T(0, [ a, a.length ], 0, b);
    }
    function yc(a) {
        return Cc.call(this, a, this.week(), this.weekday(), this.localeData()._week.dow, this.localeData()._week.doy);
    }
    function zc(a) {
        return Cc.call(this, a, this.isoWeek(), this.isoWeekday(), 1, 4);
    }
    function Ac() {
        return wa(this.year(), 1, 4);
    }
    function Bc() {
        var a = this.localeData()._week;
        return wa(this.year(), a.dow, a.doy);
    }
    function Cc(a, b, c, d, e) {
        var f;
        return null == a ? va(this, d, e).year : (f = wa(a, d, e), b > f && (b = f), Dc.call(this, a, b, c, d, e));
    }
    function Dc(a, b, c, d, e) {
        var f = ua(a, b, c, d, e), g = sa(f.year, 0, f.dayOfYear);
        return this.year(g.getUTCFullYear()), this.month(g.getUTCMonth()), this.date(g.getUTCDate()), 
        this;
    }
    function Ec(a) {
        return null == a ? Math.ceil((this.month() + 1) / 3) : this.month(3 * (a - 1) + this.month() % 3);
    }
    function Fc(a) {
        var b = Math.round((this.clone().startOf("day") - this.clone().startOf("year")) / 864e5) + 1;
        return null == a ? b : this.add(a - b, "d");
    }
    function Gc(a, b) {
        b[ce] = t(1e3 * ("0." + a));
    }
    function Hc() {
        return this._isUTC ? "UTC" : "";
    }
    function Ic() {
        return this._isUTC ? "Coordinated Universal Time" : "";
    }
    function Jc(a) {
        return rb(1e3 * a);
    }
    function Kc() {
        return rb.apply(null, arguments).parseZone();
    }
    function Lc(a) {
        return a;
    }
    function Mc(a, b, c, d) {
        var e = ab(), f = j().set(d, b);
        return e[c](f, a);
    }
    function Nc(a, b, c) {
        if ("number" == typeof a && (b = a, a = void 0), a = a || "", null != b) return Mc(a, b, c, "month");
        var d, e = [];
        for (d = 0; 12 > d; d++) e[d] = Mc(a, d, c, "month");
        return e;
    }
    function Oc(a, b, c, d) {
        "boolean" == typeof a ? ("number" == typeof b && (c = b, b = void 0), b = b || "") : (b = a, 
        c = b, a = !1, "number" == typeof b && (c = b, b = void 0), b = b || "");
        var e = ab(), f = a ? e._week.dow : 0;
        if (null != c) return Mc(b, (c + f) % 7, d, "day");
        var g, h = [];
        for (g = 0; 7 > g; g++) h[g] = Mc(b, (g + f) % 7, d, "day");
        return h;
    }
    function Pc(a, b) {
        return Nc(a, b, "months");
    }
    function Qc(a, b) {
        return Nc(a, b, "monthsShort");
    }
    function Rc(a, b, c) {
        return Oc(a, b, c, "weekdays");
    }
    function Sc(a, b, c) {
        return Oc(a, b, c, "weekdaysShort");
    }
    function Tc(a, b, c) {
        return Oc(a, b, c, "weekdaysMin");
    }
    function Uc() {
        var a = this._data;
        return this._milliseconds = Ue(this._milliseconds), this._days = Ue(this._days), 
        this._months = Ue(this._months), a.milliseconds = Ue(a.milliseconds), a.seconds = Ue(a.seconds), 
        a.minutes = Ue(a.minutes), a.hours = Ue(a.hours), a.months = Ue(a.months), a.years = Ue(a.years), 
        this;
    }
    function Vc(a, b, c, d) {
        var e = Mb(b, c);
        return a._milliseconds += d * e._milliseconds, a._days += d * e._days, a._months += d * e._months, 
        a._bubble();
    }
    function Wc(a, b) {
        return Vc(this, a, b, 1);
    }
    function Xc(a, b) {
        return Vc(this, a, b, -1);
    }
    function Yc(a) {
        return 0 > a ? Math.floor(a) : Math.ceil(a);
    }
    function Zc() {
        var a, b, c, d, e, f = this._milliseconds, g = this._days, h = this._months, i = this._data;
        return f >= 0 && g >= 0 && h >= 0 || 0 >= f && 0 >= g && 0 >= h || (f += 864e5 * Yc(_c(h) + g), 
        g = 0, h = 0), i.milliseconds = f % 1e3, a = s(f / 1e3), i.seconds = a % 60, b = s(a / 60), 
        i.minutes = b % 60, c = s(b / 60), i.hours = c % 24, g += s(c / 24), e = s($c(g)), 
        h += e, g -= Yc(_c(e)), d = s(h / 12), h %= 12, i.days = g, i.months = h, i.years = d, 
        this;
    }
    function $c(a) {
        return 4800 * a / 146097;
    }
    function _c(a) {
        return 146097 * a / 4800;
    }
    function ad(a) {
        var b, c, d = this._milliseconds;
        if (a = J(a), "month" === a || "year" === a) return b = this._days + d / 864e5, 
        c = this._months + $c(b), "month" === a ? c : c / 12;
        switch (b = this._days + Math.round(_c(this._months)), a) {
          case "week":
            return b / 7 + d / 6048e5;

          case "day":
            return b + d / 864e5;

          case "hour":
            return 24 * b + d / 36e5;

          case "minute":
            return 1440 * b + d / 6e4;

          case "second":
            return 86400 * b + d / 1e3;

          case "millisecond":
            return Math.floor(864e5 * b) + d;

          default:
            throw new Error("Unknown unit " + a);
        }
    }
    function bd() {
        return this._milliseconds + 864e5 * this._days + this._months % 12 * 2592e6 + 31536e6 * t(this._months / 12);
    }
    function cd(a) {
        return function() {
            return this.as(a);
        };
    }
    function dd(a) {
        return a = J(a), this[a + "s"]();
    }
    function ed(a) {
        return function() {
            return this._data[a];
        };
    }
    function fd() {
        return s(this.days() / 7);
    }
    function gd(a, b, c, d, e) {
        return e.relativeTime(b || 1, !!c, a, d);
    }
    function hd(a, b, c) {
        var d = Mb(a).abs(), e = jf(d.as("s")), f = jf(d.as("m")), g = jf(d.as("h")), h = jf(d.as("d")), i = jf(d.as("M")), j = jf(d.as("y")), k = e < kf.s && [ "s", e ] || 1 >= f && [ "m" ] || f < kf.m && [ "mm", f ] || 1 >= g && [ "h" ] || g < kf.h && [ "hh", g ] || 1 >= h && [ "d" ] || h < kf.d && [ "dd", h ] || 1 >= i && [ "M" ] || i < kf.M && [ "MM", i ] || 1 >= j && [ "y" ] || [ "yy", j ];
        return k[2] = b, k[3] = +a > 0, k[4] = c, gd.apply(null, k);
    }
    function id(a) {
        return void 0 === a ? jf : "function" == typeof a && (jf = a, !0);
    }
    function jd(a, b) {
        return void 0 !== kf[a] && (void 0 === b ? kf[a] : (kf[a] = b, !0));
    }
    function kd(a) {
        var b = this.localeData(), c = hd(this, !a, b);
        return a && (c = b.pastFuture(+this, c)), b.postformat(c);
    }
    function ld() {
        var a, b, c, d = lf(this._milliseconds) / 1e3, e = lf(this._days), f = lf(this._months);
        a = s(d / 60), b = s(a / 60), d %= 60, a %= 60, c = s(f / 12), f %= 12;
        var g = c, h = f, i = e, j = b, k = a, l = d, m = this.asSeconds();
        return m ? (0 > m ? "-" : "") + "P" + (g ? g + "Y" : "") + (h ? h + "M" : "") + (i ? i + "D" : "") + (j || k || l ? "T" : "") + (j ? j + "H" : "") + (k ? k + "M" : "") + (l ? l + "S" : "") : "P0D";
    }
    var md, nd;
    nd = Array.prototype.some ? Array.prototype.some : function(a) {
        for (var b = Object(this), c = b.length >>> 0, d = 0; c > d; d++) if (d in b && a.call(this, b[d], d, b)) return !0;
        return !1;
    };
    var od = a.momentProperties = [], pd = !1, qd = {};
    a.suppressDeprecationWarnings = !1, a.deprecationHandler = null;
    var rd;
    rd = Object.keys ? Object.keys : function(a) {
        var b, c = [];
        for (b in a) h(a, b) && c.push(b);
        return c;
    };
    var sd, td = {
        sameDay: "[Today at] LT",
        nextDay: "[Tomorrow at] LT",
        nextWeek: "dddd [at] LT",
        lastDay: "[Yesterday at] LT",
        lastWeek: "[Last] dddd [at] LT",
        sameElse: "L"
    }, ud = {
        LTS: "h:mm:ss A",
        LT: "h:mm A",
        L: "MM/DD/YYYY",
        LL: "MMMM D, YYYY",
        LLL: "MMMM D, YYYY h:mm A",
        LLLL: "dddd, MMMM D, YYYY h:mm A"
    }, vd = "Invalid date", wd = "%d", xd = /\d{1,2}/, yd = {
        future: "in %s",
        past: "%s ago",
        s: "a few seconds",
        m: "a minute",
        mm: "%d minutes",
        h: "an hour",
        hh: "%d hours",
        d: "a day",
        dd: "%d days",
        M: "a month",
        MM: "%d months",
        y: "a year",
        yy: "%d years"
    }, zd = {}, Ad = {}, Bd = /(\[[^\[]*\])|(\\)?([Hh]mm(ss)?|Mo|MM?M?M?|Do|DDDo|DD?D?D?|ddd?d?|do?|w[o|w]?|W[o|W]?|Qo?|YYYYYY|YYYYY|YYYY|YY|gg(ggg?)?|GG(GGG?)?|e|E|a|A|hh?|HH?|kk?|mm?|ss?|S{1,9}|x|X|zz?|ZZ?|.)/g, Cd = /(\[[^\[]*\])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g, Dd = {}, Ed = {}, Fd = /\d/, Gd = /\d\d/, Hd = /\d{3}/, Id = /\d{4}/, Jd = /[+-]?\d{6}/, Kd = /\d\d?/, Ld = /\d\d\d\d?/, Md = /\d\d\d\d\d\d?/, Nd = /\d{1,3}/, Od = /\d{1,4}/, Pd = /[+-]?\d{1,6}/, Qd = /\d+/, Rd = /[+-]?\d+/, Sd = /Z|[+-]\d\d:?\d\d/gi, Td = /Z|[+-]\d\d(?::?\d\d)?/gi, Ud = /[+-]?\d+(\.\d{1,3})?/, Vd = /[0-9]*['a-z\u00A0-\u05FF\u0700-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+|[\u0600-\u06FF\/]+(\s*?[\u0600-\u06FF]+){1,2}/i, Wd = {}, Xd = {}, Yd = 0, Zd = 1, $d = 2, _d = 3, ae = 4, be = 5, ce = 6, de = 7, ee = 8;
    sd = Array.prototype.indexOf ? Array.prototype.indexOf : function(a) {
        var b;
        for (b = 0; b < this.length; ++b) if (this[b] === a) return b;
        return -1;
    }, T("M", [ "MM", 2 ], "Mo", function() {
        return this.month() + 1;
    }), T("MMM", 0, 0, function(a) {
        return this.localeData().monthsShort(this, a);
    }), T("MMMM", 0, 0, function(a) {
        return this.localeData().months(this, a);
    }), I("month", "M"), L("month", 8), Y("M", Kd), Y("MM", Kd, Gd), Y("MMM", function(a, b) {
        return b.monthsShortRegex(a);
    }), Y("MMMM", function(a, b) {
        return b.monthsRegex(a);
    }), aa([ "M", "MM" ], function(a, b) {
        b[Zd] = t(a) - 1;
    }), aa([ "MMM", "MMMM" ], function(a, b, c, d) {
        var e = c._locale.monthsParse(a, d, c._strict);
        null != e ? b[Zd] = e : l(c).invalidMonth = a;
    });
    var fe = /D[oD]?(\[[^\[\]]*\]|\s+)+MMMM?/, ge = "January_February_March_April_May_June_July_August_September_October_November_December".split("_"), he = "Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec".split("_"), ie = Vd, je = Vd;
    T("Y", 0, 0, function() {
        var a = this.year();
        return 9999 >= a ? "" + a : "+" + a;
    }), T(0, [ "YY", 2 ], 0, function() {
        return this.year() % 100;
    }), T(0, [ "YYYY", 4 ], 0, "year"), T(0, [ "YYYYY", 5 ], 0, "year"), T(0, [ "YYYYYY", 6, !0 ], 0, "year"), 
    I("year", "y"), L("year", 1), Y("Y", Rd), Y("YY", Kd, Gd), Y("YYYY", Od, Id), Y("YYYYY", Pd, Jd), 
    Y("YYYYYY", Pd, Jd), aa([ "YYYYY", "YYYYYY" ], Yd), aa("YYYY", function(b, c) {
        c[Yd] = 2 === b.length ? a.parseTwoDigitYear(b) : t(b);
    }), aa("YY", function(b, c) {
        c[Yd] = a.parseTwoDigitYear(b);
    }), aa("Y", function(a, b) {
        b[Yd] = parseInt(a, 10);
    }), a.parseTwoDigitYear = function(a) {
        return t(a) + (t(a) > 68 ? 1900 : 2e3);
    };
    var ke = N("FullYear", !0);
    T("w", [ "ww", 2 ], "wo", "week"), T("W", [ "WW", 2 ], "Wo", "isoWeek"), I("week", "w"), 
    I("isoWeek", "W"), L("week", 5), L("isoWeek", 5), Y("w", Kd), Y("ww", Kd, Gd), Y("W", Kd), 
    Y("WW", Kd, Gd), ba([ "w", "ww", "W", "WW" ], function(a, b, c, d) {
        b[d.substr(0, 1)] = t(a);
    });
    var le = {
        dow: 0,
        doy: 6
    };
    T("d", 0, "do", "day"), T("dd", 0, 0, function(a) {
        return this.localeData().weekdaysMin(this, a);
    }), T("ddd", 0, 0, function(a) {
        return this.localeData().weekdaysShort(this, a);
    }), T("dddd", 0, 0, function(a) {
        return this.localeData().weekdays(this, a);
    }), T("e", 0, 0, "weekday"), T("E", 0, 0, "isoWeekday"), I("day", "d"), I("weekday", "e"), 
    I("isoWeekday", "E"), L("day", 11), L("weekday", 11), L("isoWeekday", 11), Y("d", Kd), 
    Y("e", Kd), Y("E", Kd), Y("dd", function(a, b) {
        return b.weekdaysMinRegex(a);
    }), Y("ddd", function(a, b) {
        return b.weekdaysShortRegex(a);
    }), Y("dddd", function(a, b) {
        return b.weekdaysRegex(a);
    }), ba([ "dd", "ddd", "dddd" ], function(a, b, c, d) {
        var e = c._locale.weekdaysParse(a, d, c._strict);
        null != e ? b.d = e : l(c).invalidWeekday = a;
    }), ba([ "d", "e", "E" ], function(a, b, c, d) {
        b[d] = t(a);
    });
    var me = "Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday".split("_"), ne = "Sun_Mon_Tue_Wed_Thu_Fri_Sat".split("_"), oe = "Su_Mo_Tu_We_Th_Fr_Sa".split("_"), pe = Vd, qe = Vd, re = Vd;
    T("H", [ "HH", 2 ], 0, "hour"), T("h", [ "hh", 2 ], 0, Qa), T("k", [ "kk", 2 ], 0, Ra), 
    T("hmm", 0, 0, function() {
        return "" + Qa.apply(this) + S(this.minutes(), 2);
    }), T("hmmss", 0, 0, function() {
        return "" + Qa.apply(this) + S(this.minutes(), 2) + S(this.seconds(), 2);
    }), T("Hmm", 0, 0, function() {
        return "" + this.hours() + S(this.minutes(), 2);
    }), T("Hmmss", 0, 0, function() {
        return "" + this.hours() + S(this.minutes(), 2) + S(this.seconds(), 2);
    }), Sa("a", !0), Sa("A", !1), I("hour", "h"), L("hour", 13), Y("a", Ta), Y("A", Ta), 
    Y("H", Kd), Y("h", Kd), Y("HH", Kd, Gd), Y("hh", Kd, Gd), Y("hmm", Ld), Y("hmmss", Md), 
    Y("Hmm", Ld), Y("Hmmss", Md), aa([ "H", "HH" ], _d), aa([ "a", "A" ], function(a, b, c) {
        c._isPm = c._locale.isPM(a), c._meridiem = a;
    }), aa([ "h", "hh" ], function(a, b, c) {
        b[_d] = t(a), l(c).bigHour = !0;
    }), aa("hmm", function(a, b, c) {
        var d = a.length - 2;
        b[_d] = t(a.substr(0, d)), b[ae] = t(a.substr(d)), l(c).bigHour = !0;
    }), aa("hmmss", function(a, b, c) {
        var d = a.length - 4, e = a.length - 2;
        b[_d] = t(a.substr(0, d)), b[ae] = t(a.substr(d, 2)), b[be] = t(a.substr(e)), l(c).bigHour = !0;
    }), aa("Hmm", function(a, b, c) {
        var d = a.length - 2;
        b[_d] = t(a.substr(0, d)), b[ae] = t(a.substr(d));
    }), aa("Hmmss", function(a, b, c) {
        var d = a.length - 4, e = a.length - 2;
        b[_d] = t(a.substr(0, d)), b[ae] = t(a.substr(d, 2)), b[be] = t(a.substr(e));
    });
    var se, te = /[ap]\.?m?\.?/i, ue = N("Hours", !0), ve = {
        calendar: td,
        longDateFormat: ud,
        invalidDate: vd,
        ordinal: wd,
        ordinalParse: xd,
        relativeTime: yd,
        months: ge,
        monthsShort: he,
        week: le,
        weekdays: me,
        weekdaysMin: oe,
        weekdaysShort: ne,
        meridiemParse: te
    }, we = {}, xe = /^\s*((?:[+-]\d{6}|\d{4})-(?:\d\d-\d\d|W\d\d-\d|W\d\d|\d\d\d|\d\d))(?:(T| )(\d\d(?::\d\d(?::\d\d(?:[.,]\d+)?)?)?)([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?/, ye = /^\s*((?:[+-]\d{6}|\d{4})(?:\d\d\d\d|W\d\d\d|W\d\d|\d\d\d|\d\d))(?:(T| )(\d\d(?:\d\d(?:\d\d(?:[.,]\d+)?)?)?)([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?/, ze = /Z|[+-]\d\d(?::?\d\d)?/, Ae = [ [ "YYYYYY-MM-DD", /[+-]\d{6}-\d\d-\d\d/ ], [ "YYYY-MM-DD", /\d{4}-\d\d-\d\d/ ], [ "GGGG-[W]WW-E", /\d{4}-W\d\d-\d/ ], [ "GGGG-[W]WW", /\d{4}-W\d\d/, !1 ], [ "YYYY-DDD", /\d{4}-\d{3}/ ], [ "YYYY-MM", /\d{4}-\d\d/, !1 ], [ "YYYYYYMMDD", /[+-]\d{10}/ ], [ "YYYYMMDD", /\d{8}/ ], [ "GGGG[W]WWE", /\d{4}W\d{3}/ ], [ "GGGG[W]WW", /\d{4}W\d{2}/, !1 ], [ "YYYYDDD", /\d{7}/ ] ], Be = [ [ "HH:mm:ss.SSSS", /\d\d:\d\d:\d\d\.\d+/ ], [ "HH:mm:ss,SSSS", /\d\d:\d\d:\d\d,\d+/ ], [ "HH:mm:ss", /\d\d:\d\d:\d\d/ ], [ "HH:mm", /\d\d:\d\d/ ], [ "HHmmss.SSSS", /\d\d\d\d\d\d\.\d+/ ], [ "HHmmss,SSSS", /\d\d\d\d\d\d,\d+/ ], [ "HHmmss", /\d\d\d\d\d\d/ ], [ "HHmm", /\d\d\d\d/ ], [ "HH", /\d\d/ ] ], Ce = /^\/?Date\((\-?\d+)/i;
    a.createFromInputFallback = w("moment construction falls back to js Date. This is discouraged and will be removed in upcoming major release. Please refer to http://momentjs.com/guides/#/warnings/js-date/ for more info.", function(a) {
        a._d = new Date(a._i + (a._useUTC ? " UTC" : ""));
    }), a.ISO_8601 = function() {};
    var De = w("moment().min is deprecated, use moment.max instead. http://momentjs.com/guides/#/warnings/min-max/", function() {
        var a = rb.apply(null, arguments);
        return this.isValid() && a.isValid() ? this > a ? this : a : n();
    }), Ee = w("moment().max is deprecated, use moment.min instead. http://momentjs.com/guides/#/warnings/min-max/", function() {
        var a = rb.apply(null, arguments);
        return this.isValid() && a.isValid() ? a > this ? this : a : n();
    }), Fe = function() {
        return Date.now ? Date.now() : +new Date();
    };
    xb("Z", ":"), xb("ZZ", ""), Y("Z", Td), Y("ZZ", Td), aa([ "Z", "ZZ" ], function(a, b, c) {
        c._useUTC = !0, c._tzm = yb(Td, a);
    });
    var Ge = /([\+\-]|\d\d)/gi;
    a.updateOffset = function() {};
    var He = /^(\-)?(?:(\d*)[. ])?(\d+)\:(\d+)(?:\:(\d+)\.?(\d{3})?\d*)?$/, Ie = /^(-)?P(?:(-?[0-9,.]*)Y)?(?:(-?[0-9,.]*)M)?(?:(-?[0-9,.]*)W)?(?:(-?[0-9,.]*)D)?(?:T(?:(-?[0-9,.]*)H)?(?:(-?[0-9,.]*)M)?(?:(-?[0-9,.]*)S)?)?$/;
    Mb.fn = vb.prototype;
    var Je = Rb(1, "add"), Ke = Rb(-1, "subtract");
    a.defaultFormat = "YYYY-MM-DDTHH:mm:ssZ", a.defaultFormatUtc = "YYYY-MM-DDTHH:mm:ss[Z]";
    var Le = w("moment().lang() is deprecated. Instead, use moment().localeData() to get the language configuration. Use moment().locale() to change languages.", function(a) {
        return void 0 === a ? this.localeData() : this.locale(a);
    });
    T(0, [ "gg", 2 ], 0, function() {
        return this.weekYear() % 100;
    }), T(0, [ "GG", 2 ], 0, function() {
        return this.isoWeekYear() % 100;
    }), xc("gggg", "weekYear"), xc("ggggg", "weekYear"), xc("GGGG", "isoWeekYear"), 
    xc("GGGGG", "isoWeekYear"), I("weekYear", "gg"), I("isoWeekYear", "GG"), L("weekYear", 1), 
    L("isoWeekYear", 1), Y("G", Rd), Y("g", Rd), Y("GG", Kd, Gd), Y("gg", Kd, Gd), Y("GGGG", Od, Id), 
    Y("gggg", Od, Id), Y("GGGGG", Pd, Jd), Y("ggggg", Pd, Jd), ba([ "gggg", "ggggg", "GGGG", "GGGGG" ], function(a, b, c, d) {
        b[d.substr(0, 2)] = t(a);
    }), ba([ "gg", "GG" ], function(b, c, d, e) {
        c[e] = a.parseTwoDigitYear(b);
    }), T("Q", 0, "Qo", "quarter"), I("quarter", "Q"), L("quarter", 7), Y("Q", Fd), 
    aa("Q", function(a, b) {
        b[Zd] = 3 * (t(a) - 1);
    }), T("D", [ "DD", 2 ], "Do", "date"), I("date", "D"), L("date", 9), Y("D", Kd), 
    Y("DD", Kd, Gd), Y("Do", function(a, b) {
        return a ? b._ordinalParse : b._ordinalParseLenient;
    }), aa([ "D", "DD" ], $d), aa("Do", function(a, b) {
        b[$d] = t(a.match(Kd)[0], 10);
    });
    var Me = N("Date", !0);
    T("DDD", [ "DDDD", 3 ], "DDDo", "dayOfYear"), I("dayOfYear", "DDD"), L("dayOfYear", 4), 
    Y("DDD", Nd), Y("DDDD", Hd), aa([ "DDD", "DDDD" ], function(a, b, c) {
        c._dayOfYear = t(a);
    }), T("m", [ "mm", 2 ], 0, "minute"), I("minute", "m"), L("minute", 14), Y("m", Kd), 
    Y("mm", Kd, Gd), aa([ "m", "mm" ], ae);
    var Ne = N("Minutes", !1);
    T("s", [ "ss", 2 ], 0, "second"), I("second", "s"), L("second", 15), Y("s", Kd), 
    Y("ss", Kd, Gd), aa([ "s", "ss" ], be);
    var Oe = N("Seconds", !1);
    T("S", 0, 0, function() {
        return ~~(this.millisecond() / 100);
    }), T(0, [ "SS", 2 ], 0, function() {
        return ~~(this.millisecond() / 10);
    }), T(0, [ "SSS", 3 ], 0, "millisecond"), T(0, [ "SSSS", 4 ], 0, function() {
        return 10 * this.millisecond();
    }), T(0, [ "SSSSS", 5 ], 0, function() {
        return 100 * this.millisecond();
    }), T(0, [ "SSSSSS", 6 ], 0, function() {
        return 1e3 * this.millisecond();
    }), T(0, [ "SSSSSSS", 7 ], 0, function() {
        return 1e4 * this.millisecond();
    }), T(0, [ "SSSSSSSS", 8 ], 0, function() {
        return 1e5 * this.millisecond();
    }), T(0, [ "SSSSSSSSS", 9 ], 0, function() {
        return 1e6 * this.millisecond();
    }), I("millisecond", "ms"), L("millisecond", 16), Y("S", Nd, Fd), Y("SS", Nd, Gd), 
    Y("SSS", Nd, Hd);
    var Pe;
    for (Pe = "SSSS"; Pe.length <= 9; Pe += "S") Y(Pe, Qd);
    for (Pe = "S"; Pe.length <= 9; Pe += "S") aa(Pe, Gc);
    var Qe = N("Milliseconds", !1);
    T("z", 0, 0, "zoneAbbr"), T("zz", 0, 0, "zoneName");
    var Re = q.prototype;
    Re.add = Je, Re.calendar = Ub, Re.clone = Vb, Re.diff = ac, Re.endOf = mc, Re.format = ec, 
    Re.from = fc, Re.fromNow = gc, Re.to = hc, Re.toNow = ic, Re.get = Q, Re.invalidAt = vc, 
    Re.isAfter = Wb, Re.isBefore = Xb, Re.isBetween = Yb, Re.isSame = Zb, Re.isSameOrAfter = $b, 
    Re.isSameOrBefore = _b, Re.isValid = tc, Re.lang = Le, Re.locale = jc, Re.localeData = kc, 
    Re.max = Ee, Re.min = De, Re.parsingFlags = uc, Re.set = R, Re.startOf = lc, Re.subtract = Ke, 
    Re.toArray = qc, Re.toObject = rc, Re.toDate = pc, Re.toISOString = dc, Re.toJSON = sc, 
    Re.toString = cc, Re.unix = oc, Re.valueOf = nc, Re.creationData = wc, Re.year = ke, 
    Re.isLeapYear = qa, Re.weekYear = yc, Re.isoWeekYear = zc, Re.quarter = Re.quarters = Ec, 
    Re.month = ja, Re.daysInMonth = ka, Re.week = Re.weeks = Aa, Re.isoWeek = Re.isoWeeks = Ba, 
    Re.weeksInYear = Bc, Re.isoWeeksInYear = Ac, Re.date = Me, Re.day = Re.days = Ja, 
    Re.weekday = Ka, Re.isoWeekday = La, Re.dayOfYear = Fc, Re.hour = Re.hours = ue, 
    Re.minute = Re.minutes = Ne, Re.second = Re.seconds = Oe, Re.millisecond = Re.milliseconds = Qe, 
    Re.utcOffset = Bb, Re.utc = Db, Re.local = Eb, Re.parseZone = Fb, Re.hasAlignedHourOffset = Gb, 
    Re.isDST = Hb, Re.isLocal = Jb, Re.isUtcOffset = Kb, Re.isUtc = Lb, Re.isUTC = Lb, 
    Re.zoneAbbr = Hc, Re.zoneName = Ic, Re.dates = w("dates accessor is deprecated. Use date instead.", Me), 
    Re.months = w("months accessor is deprecated. Use month instead", ja), Re.years = w("years accessor is deprecated. Use year instead", ke), 
    Re.zone = w("moment().zone is deprecated, use moment().utcOffset instead. http://momentjs.com/guides/#/warnings/zone/", Cb), 
    Re.isDSTShifted = w("isDSTShifted is deprecated. See http://momentjs.com/guides/#/warnings/dst-shifted/ for more information", Ib);
    var Se = Re, Te = B.prototype;
    Te.calendar = C, Te.longDateFormat = D, Te.invalidDate = E, Te.ordinal = F, Te.preparse = Lc, 
    Te.postformat = Lc, Te.relativeTime = G, Te.pastFuture = H, Te.set = z, Te.months = ea, 
    Te.monthsShort = fa, Te.monthsParse = ha, Te.monthsRegex = ma, Te.monthsShortRegex = la, 
    Te.week = xa, Te.firstDayOfYear = za, Te.firstDayOfWeek = ya, Te.weekdays = Ea, 
    Te.weekdaysMin = Ga, Te.weekdaysShort = Fa, Te.weekdaysParse = Ia, Te.weekdaysRegex = Ma, 
    Te.weekdaysShortRegex = Na, Te.weekdaysMinRegex = Oa, Te.isPM = Ua, Te.meridiem = Va, 
    Za("en", {
        ordinalParse: /\d{1,2}(th|st|nd|rd)/,
        ordinal: function(a) {
            var b = a % 10, c = 1 === t(a % 100 / 10) ? "th" : 1 === b ? "st" : 2 === b ? "nd" : 3 === b ? "rd" : "th";
            return a + c;
        }
    }), a.lang = w("moment.lang is deprecated. Use moment.locale instead.", Za), a.langData = w("moment.langData is deprecated. Use moment.localeData instead.", ab);
    var Ue = Math.abs, Ve = cd("ms"), We = cd("s"), Xe = cd("m"), Ye = cd("h"), Ze = cd("d"), $e = cd("w"), _e = cd("M"), af = cd("y"), bf = ed("milliseconds"), cf = ed("seconds"), df = ed("minutes"), ef = ed("hours"), ff = ed("days"), gf = ed("months"), hf = ed("years"), jf = Math.round, kf = {
        s: 45,
        m: 45,
        h: 22,
        d: 26,
        M: 11
    }, lf = Math.abs, mf = vb.prototype;
    mf.abs = Uc, mf.add = Wc, mf.subtract = Xc, mf.as = ad, mf.asMilliseconds = Ve, 
    mf.asSeconds = We, mf.asMinutes = Xe, mf.asHours = Ye, mf.asDays = Ze, mf.asWeeks = $e, 
    mf.asMonths = _e, mf.asYears = af, mf.valueOf = bd, mf._bubble = Zc, mf.get = dd, 
    mf.milliseconds = bf, mf.seconds = cf, mf.minutes = df, mf.hours = ef, mf.days = ff, 
    mf.weeks = fd, mf.months = gf, mf.years = hf, mf.humanize = kd, mf.toISOString = ld, 
    mf.toString = ld, mf.toJSON = ld, mf.locale = jc, mf.localeData = kc, mf.toIsoString = w("toIsoString() is deprecated. Please use toISOString() instead (notice the capitals)", ld), 
    mf.lang = Le, T("X", 0, 0, "unix"), T("x", 0, 0, "valueOf"), Y("x", Rd), Y("X", Ud), 
    aa("X", function(a, b, c) {
        c._d = new Date(1e3 * parseFloat(a, 10));
    }), aa("x", function(a, b, c) {
        c._d = new Date(t(a));
    }), a.version = "2.14.1", b(rb), a.fn = Se, a.min = tb, a.max = ub, a.now = Fe, 
    a.utc = j, a.unix = Jc, a.months = Pc, a.isDate = f, a.locale = Za, a.invalid = n, 
    a.duration = Mb, a.isMoment = r, a.weekdays = Rc, a.parseZone = Kc, a.localeData = ab, 
    a.isDuration = wb, a.monthsShort = Qc, a.weekdaysMin = Tc, a.defineLocale = $a, 
    a.updateLocale = _a, a.locales = bb, a.weekdaysShort = Sc, a.normalizeUnits = J, 
    a.relativeTimeRounding = id, a.relativeTimeThreshold = jd, a.calendarFormat = Tb, 
    a.prototype = Se;
    var nf = a;
    return nf;
}), function(a, b) {
    "object" == typeof exports && "undefined" != typeof module && "function" == typeof require ? b(require("../moment")) : "function" == typeof define && define.amd ? define([ "../moment" ], b) : b(a.moment);
}(this, function(a) {
    "use strict";
    var b = a.defineLocale("pt-br", {
        months: "Janeiro_Fevereiro_Março_Abril_Maio_Junho_Julho_Agosto_Setembro_Outubro_Novembro_Dezembro".split("_"),
        monthsShort: "Jan_Fev_Mar_Abr_Mai_Jun_Jul_Ago_Set_Out_Nov_Dez".split("_"),
        weekdays: "Domingo_Segunda-feira_Terça-feira_Quarta-feira_Quinta-feira_Sexta-feira_Sábado".split("_"),
        weekdaysShort: "Dom_Seg_Ter_Qua_Qui_Sex_Sáb".split("_"),
        weekdaysMin: "Dom_2ª_3ª_4ª_5ª_6ª_Sáb".split("_"),
        weekdaysParseExact: !0,
        longDateFormat: {
            LT: "HH:mm",
            LTS: "HH:mm:ss",
            L: "DD/MM/YYYY",
            LL: "D [de] MMMM [de] YYYY",
            LLL: "D [de] MMMM [de] YYYY [às] HH:mm",
            LLLL: "dddd, D [de] MMMM [de] YYYY [às] HH:mm"
        },
        calendar: {
            sameDay: "[Hoje às] LT",
            nextDay: "[Amanhã às] LT",
            nextWeek: "dddd [às] LT",
            lastDay: "[Ontem às] LT",
            lastWeek: function() {
                return 0 === this.day() || 6 === this.day() ? "[Último] dddd [às] LT" : "[Última] dddd [às] LT";
            },
            sameElse: "L"
        },
        relativeTime: {
            future: "em %s",
            past: "%s atrás",
            s: "poucos segundos",
            m: "um minuto",
            mm: "%d minutos",
            h: "uma hora",
            hh: "%d horas",
            d: "um dia",
            dd: "%d dias",
            M: "um mês",
            MM: "%d meses",
            y: "um ano",
            yy: "%d anos"
        },
        ordinalParse: /\d{1,2}º/,
        ordinal: "%dº"
    });
    return b;
});