(function e(t, n, r) {
    function s(o, u) {
        if (!n[o]) {
            if (!t[o]) {
                var a = typeof require == "function" && require;
                if (!u && a)return a(o, !0);
                if (i)return i(o, !0);
                var f = new Error("Cannot find module '" + o + "'");
                throw f.code = "MODULE_NOT_FOUND", f
            }
            var l = n[o] = {exports: {}};
            t[o][0].call(l.exports, function (e) {
                var n = t[o][1][e];
                return s(n ? n : e)
            }, l, l.exports, e, t, n, r)
        }
        return n[o].exports
    }

    var i = typeof require == "function" && require;
    for (var o = 0; o < r.length; o++)s(r[o]);
    return s
})({
    1: [function (require, module, exports) {
        function corslite(n, t, o) {
            function e(n) {
                return n >= 200 && 300 > n || 304 === n
            }

            function i() {
                void 0 === r.status || e(r.status) ? t.call(r, null, r) : t.call(r, r, null)
            }

            var l = !1;
            if ("undefined" == typeof window.XMLHttpRequest)return t(Error("Browser not supported"));
            if ("undefined" == typeof o) {
                var u = n.match(/^\s*https?:\/\/[^\/]*/);
                o = u && u[0] !== location.protocol + "//" + location.domain + (location.port ? ":" + location.port : "")
            }
            var r = new window.XMLHttpRequest;
            if (o && !("withCredentials" in r)) {
                r = new window.XDomainRequest;
                var a = t;
                t = function () {
                    if (l) a.apply(this, arguments); else {
                        var n = this, t = arguments;
                        setTimeout(function () {
                            a.apply(n, t)
                        }, 0)
                    }
                }
            }
            return "onload" in r ? r.onload = i : r.onreadystatechange = function () {
                    4 === r.readyState && i()
                }, r.onerror = function (n) {
                t.call(this, n || !0, null), t = function () {
                }
            }, r.onprogress = function () {
            }, r.ontimeout = function (n) {
                t.call(this, n, null), t = function () {
                }
            }, r.onabort = function (n) {
                t.call(this, n, null), t = function () {
                }
            }, r.open("GET", n, !0), r.send(null), l = !0, r
        }

        "undefined" != typeof module && (module.exports = corslite);
    }, {}], 2: [function (require, module, exports) {
        module.exports = Array.isArray || function (r) {
                return "[object Array]" == Object.prototype.toString.call(r)
            };
    }, {}], 3: [function (require, module, exports) {
        !function (t, e, i) {
            var n = t.L, o = {};
            o.version = "0.7.7", "object" == typeof module && "object" == typeof module.exports ? module.exports = o : "function" == typeof define && define.amd && define(o), o.noConflict = function () {
                return t.L = n, this
            }, t.L = o, o.Util = {
                extend: function (t) {
                    var e, i, n, o, s = Array.prototype.slice.call(arguments, 1);
                    for (i = 0, n = s.length; n > i; i++) {
                        o = s[i] || {};
                        for (e in o)o.hasOwnProperty(e) && (t[e] = o[e])
                    }
                    return t
                }, bind: function (t, e) {
                    var i = arguments.length > 2 ? Array.prototype.slice.call(arguments, 2) : null;
                    return function () {
                        return t.apply(e, i || arguments)
                    }
                }, stamp: function () {
                    var t = 0, e = "_leaflet_id";
                    return function (i) {
                        return i[e] = i[e] || ++t, i[e]
                    }
                }(), invokeEach: function (t, e, i) {
                    var n, o;
                    if ("object" == typeof t) {
                        o = Array.prototype.slice.call(arguments, 3);
                        for (n in t)e.apply(i, [n, t[n]].concat(o));
                        return !0
                    }
                    return !1
                }, limitExecByInterval: function (t, e, i) {
                    var n, o;
                    return function s() {
                        var a = arguments;
                        return n ? void(o = !0) : (n = !0, setTimeout(function () {
                                n = !1, o && (s.apply(i, a), o = !1)
                            }, e), void t.apply(i, a))
                    }
                }, falseFn: function () {
                    return !1
                }, formatNum: function (t, e) {
                    var i = Math.pow(10, e || 5);
                    return Math.round(t * i) / i
                }, trim: function (t) {
                    return t.trim ? t.trim() : t.replace(/^\s+|\s+$/g, "")
                }, splitWords: function (t) {
                    return o.Util.trim(t).split(/\s+/)
                }, setOptions: function (t, e) {
                    return t.options = o.extend({}, t.options, e), t.options
                }, getParamString: function (t, e, i) {
                    var n = [];
                    for (var o in t)n.push(encodeURIComponent(i ? o.toUpperCase() : o) + "=" + encodeURIComponent(t[o]));
                    return (e && -1 !== e.indexOf("?") ? "&" : "?") + n.join("&")
                }, template: function (t, e) {
                    return t.replace(/\{ *([\w_]+) *\}/g, function (t, n) {
                        var o = e[n];
                        if (o === i)throw new Error("No value provided for variable " + t);
                        return "function" == typeof o && (o = o(e)), o
                    })
                }, isArray: Array.isArray || function (t) {
                    return "[object Array]" === Object.prototype.toString.call(t)
                }, emptyImageUrl: "data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
            }, function () {
                function e(e) {
                    var i, n, o = ["webkit", "moz", "o", "ms"];
                    for (i = 0; i < o.length && !n; i++)n = t[o[i] + e];
                    return n
                }

                function i(e) {
                    var i = +new Date, o = Math.max(0, 16 - (i - n));
                    return n = i + o, t.setTimeout(e, o)
                }

                var n = 0, s = t.requestAnimationFrame || e("RequestAnimationFrame") || i, a = t.cancelAnimationFrame || e("CancelAnimationFrame") || e("CancelRequestAnimationFrame") || function (e) {
                        t.clearTimeout(e)
                    };
                o.Util.requestAnimFrame = function (e, n, a, r) {
                    return e = o.bind(e, n), a && s === i ? void e() : s.call(t, e, r)
                }, o.Util.cancelAnimFrame = function (e) {
                    e && a.call(t, e)
                }
            }(), o.extend = o.Util.extend, o.bind = o.Util.bind, o.stamp = o.Util.stamp, o.setOptions = o.Util.setOptions, o.Class = function () {
            }, o.Class.extend = function (t) {
                var e = function () {
                    this.initialize && this.initialize.apply(this, arguments), this._initHooks && this.callInitHooks()
                }, i = function () {
                };
                i.prototype = this.prototype;
                var n = new i;
                n.constructor = e, e.prototype = n;
                for (var s in this)this.hasOwnProperty(s) && "prototype" !== s && (e[s] = this[s]);
                t.statics && (o.extend(e, t.statics), delete t.statics), t.includes && (o.Util.extend.apply(null, [n].concat(t.includes)), delete t.includes), t.options && n.options && (t.options = o.extend({}, n.options, t.options)), o.extend(n, t), n._initHooks = [];
                var a = this;
                return e.__super__ = a.prototype, n.callInitHooks = function () {
                    if (!this._initHooksCalled) {
                        a.prototype.callInitHooks && a.prototype.callInitHooks.call(this), this._initHooksCalled = !0;
                        for (var t = 0, e = n._initHooks.length; e > t; t++)n._initHooks[t].call(this)
                    }
                }, e
            }, o.Class.include = function (t) {
                o.extend(this.prototype, t)
            }, o.Class.mergeOptions = function (t) {
                o.extend(this.prototype.options, t)
            }, o.Class.addInitHook = function (t) {
                var e = Array.prototype.slice.call(arguments, 1), i = "function" == typeof t ? t : function () {
                        this[t].apply(this, e)
                    };
                this.prototype._initHooks = this.prototype._initHooks || [], this.prototype._initHooks.push(i)
            };
            var s = "_leaflet_events";
            o.Mixin = {}, o.Mixin.Events = {
                addEventListener: function (t, e, i) {
                    if (o.Util.invokeEach(t, this.addEventListener, this, e, i))return this;
                    var n, a, r, h, l, u, c, d = this[s] = this[s] || {}, p = i && i !== this && o.stamp(i);
                    for (t = o.Util.splitWords(t), n = 0, a = t.length; a > n; n++)r = {action: e, context: i || this}, h = t[n], p ? (l = h + "_idx", u = l + "_len", c = d[l] = d[l] || {}, c[p] || (c[p] = [], d[u] = (d[u] || 0) + 1), c[p].push(r)) : (d[h] = d[h] || [], d[h].push(r));
                    return this
                }, hasEventListeners: function (t) {
                    var e = this[s];
                    return !!e && (t in e && e[t].length > 0 || t + "_idx" in e && e[t + "_idx_len"] > 0)
                }, removeEventListener: function (t, e, i) {
                    if (!this[s])return this;
                    if (!t)return this.clearAllEventListeners();
                    if (o.Util.invokeEach(t, this.removeEventListener, this, e, i))return this;
                    var n, a, r, h, l, u, c, d, p, _ = this[s], m = i && i !== this && o.stamp(i);
                    for (t = o.Util.splitWords(t), n = 0, a = t.length; a > n; n++)if (r = t[n], u = r + "_idx", c = u + "_len", d = _[u], e) {
                        if (h = m && d ? d[m] : _[r]) {
                            for (l = h.length - 1; l >= 0; l--)h[l].action !== e || i && h[l].context !== i || (p = h.splice(l, 1), p[0].action = o.Util.falseFn);
                            i && d && 0 === h.length && (delete d[m], _[c]--)
                        }
                    } else delete _[r], delete _[u], delete _[c];
                    return this
                }, clearAllEventListeners: function () {
                    return delete this[s], this
                }, fireEvent: function (t, e) {
                    if (!this.hasEventListeners(t))return this;
                    var i, n, a, r, h, l = o.Util.extend({}, e, {type: t, target: this}), u = this[s];
                    if (u[t])for (i = u[t].slice(), n = 0, a = i.length; a > n; n++)i[n].action.call(i[n].context, l);
                    r = u[t + "_idx"];
                    for (h in r)if (i = r[h].slice())for (n = 0, a = i.length; a > n; n++)i[n].action.call(i[n].context, l);
                    return this
                }, addOneTimeEventListener: function (t, e, i) {
                    if (o.Util.invokeEach(t, this.addOneTimeEventListener, this, e, i))return this;
                    var n = o.bind(function () {
                        this.removeEventListener(t, e, i).removeEventListener(t, n, i)
                    }, this);
                    return this.addEventListener(t, e, i).addEventListener(t, n, i)
                }
            }, o.Mixin.Events.on = o.Mixin.Events.addEventListener, o.Mixin.Events.off = o.Mixin.Events.removeEventListener, o.Mixin.Events.once = o.Mixin.Events.addOneTimeEventListener, o.Mixin.Events.fire = o.Mixin.Events.fireEvent, function () {
                var n = "ActiveXObject" in t, s = n && !e.addEventListener, a = navigator.userAgent.toLowerCase(), r = -1 !== a.indexOf("webkit"), h = -1 !== a.indexOf("chrome"), l = -1 !== a.indexOf("phantom"), u = -1 !== a.indexOf("android"), c = -1 !== a.search("android [23]"), d = -1 !== a.indexOf("gecko"), p = typeof orientation != i + "", _ = !t.PointerEvent && t.MSPointerEvent, m = t.PointerEvent && t.navigator.pointerEnabled || _, f = "devicePixelRatio" in t && t.devicePixelRatio > 1 || "matchMedia" in t && t.matchMedia("(min-resolution:144dpi)") && t.matchMedia("(min-resolution:144dpi)").matches, g = e.documentElement, v = n && "transition" in g.style, y = "WebKitCSSMatrix" in t && "m11" in new t.WebKitCSSMatrix && !c, P = "MozPerspective" in g.style, L = "OTransition" in g.style, x = !t.L_DISABLE_3D && (v || y || P || L) && !l, w = !t.L_NO_TOUCH && !l && (m || "ontouchstart" in t || t.DocumentTouch && e instanceof t.DocumentTouch);
                o.Browser = {ie: n, ielt9: s, webkit: r, gecko: d && !r && !t.opera && !n, android: u, android23: c, chrome: h, ie3d: v, webkit3d: y, gecko3d: P, opera3d: L, any3d: x, mobile: p, mobileWebkit: p && r, mobileWebkit3d: p && y, mobileOpera: p && t.opera, touch: w, msPointer: _, pointer: m, retina: f}
            }(), o.Point = function (t, e, i) {
                this.x = i ? Math.round(t) : t, this.y = i ? Math.round(e) : e
            }, o.Point.prototype = {
                clone: function () {
                    return new o.Point(this.x, this.y)
                }, add: function (t) {
                    return this.clone()._add(o.point(t))
                }, _add: function (t) {
                    return this.x += t.x, this.y += t.y, this
                }, subtract: function (t) {
                    return this.clone()._subtract(o.point(t))
                }, _subtract: function (t) {
                    return this.x -= t.x, this.y -= t.y, this
                }, divideBy: function (t) {
                    return this.clone()._divideBy(t)
                }, _divideBy: function (t) {
                    return this.x /= t, this.y /= t, this
                }, multiplyBy: function (t) {
                    return this.clone()._multiplyBy(t)
                }, _multiplyBy: function (t) {
                    return this.x *= t, this.y *= t, this
                }, round: function () {
                    return this.clone()._round()
                }, _round: function () {
                    return this.x = Math.round(this.x), this.y = Math.round(this.y), this
                }, floor: function () {
                    return this.clone()._floor()
                }, _floor: function () {
                    return this.x = Math.floor(this.x), this.y = Math.floor(this.y), this
                }, distanceTo: function (t) {
                    t = o.point(t);
                    var e = t.x - this.x, i = t.y - this.y;
                    return Math.sqrt(e * e + i * i)
                }, equals: function (t) {
                    return t = o.point(t), t.x === this.x && t.y === this.y
                }, contains: function (t) {
                    return t = o.point(t), Math.abs(t.x) <= Math.abs(this.x) && Math.abs(t.y) <= Math.abs(this.y)
                }, toString: function () {
                    return "Point(" + o.Util.formatNum(this.x) + ", " + o.Util.formatNum(this.y) + ")"
                }
            }, o.point = function (t, e, n) {
                return t instanceof o.Point ? t : o.Util.isArray(t) ? new o.Point(t[0], t[1]) : t === i || null === t ? t : new o.Point(t, e, n)
            }, o.Bounds = function (t, e) {
                if (t)for (var i = e ? [t, e] : t, n = 0, o = i.length; o > n; n++)this.extend(i[n])
            }, o.Bounds.prototype = {
                extend: function (t) {
                    return t = o.point(t), this.min || this.max ? (this.min.x = Math.min(t.x, this.min.x), this.max.x = Math.max(t.x, this.max.x), this.min.y = Math.min(t.y, this.min.y), this.max.y = Math.max(t.y, this.max.y)) : (this.min = t.clone(), this.max = t.clone()), this
                }, getCenter: function (t) {
                    return new o.Point((this.min.x + this.max.x) / 2, (this.min.y + this.max.y) / 2, t)
                }, getBottomLeft: function () {
                    return new o.Point(this.min.x, this.max.y)
                }, getTopRight: function () {
                    return new o.Point(this.max.x, this.min.y)
                }, getSize: function () {
                    return this.max.subtract(this.min)
                }, contains: function (t) {
                    var e, i;
                    return t = "number" == typeof t[0] || t instanceof o.Point ? o.point(t) : o.bounds(t), t instanceof o.Bounds ? (e = t.min, i = t.max) : e = i = t, e.x >= this.min.x && i.x <= this.max.x && e.y >= this.min.y && i.y <= this.max.y
                }, intersects: function (t) {
                    t = o.bounds(t);
                    var e = this.min, i = this.max, n = t.min, s = t.max, a = s.x >= e.x && n.x <= i.x, r = s.y >= e.y && n.y <= i.y;
                    return a && r
                }, isValid: function () {
                    return !(!this.min || !this.max)
                }
            }, o.bounds = function (t, e) {
                return !t || t instanceof o.Bounds ? t : new o.Bounds(t, e)
            }, o.Transformation = function (t, e, i, n) {
                this._a = t, this._b = e, this._c = i, this._d = n
            }, o.Transformation.prototype = {
                transform: function (t, e) {
                    return this._transform(t.clone(), e)
                }, _transform: function (t, e) {
                    return e = e || 1, t.x = e * (this._a * t.x + this._b), t.y = e * (this._c * t.y + this._d), t
                }, untransform: function (t, e) {
                    return e = e || 1, new o.Point((t.x / e - this._b) / this._a, (t.y / e - this._d) / this._c)
                }
            }, o.DomUtil = {
                get: function (t) {
                    return "string" == typeof t ? e.getElementById(t) : t
                }, getStyle: function (t, i) {
                    var n = t.style[i];
                    if (!n && t.currentStyle && (n = t.currentStyle[i]), (!n || "auto" === n) && e.defaultView) {
                        var o = e.defaultView.getComputedStyle(t, null);
                        n = o ? o[i] : null
                    }
                    return "auto" === n ? null : n
                }, getViewportOffset: function (t) {
                    var i, n = 0, s = 0, a = t, r = e.body, h = e.documentElement;
                    do {
                        if (n += a.offsetTop || 0, s += a.offsetLeft || 0, n += parseInt(o.DomUtil.getStyle(a, "borderTopWidth"), 10) || 0, s += parseInt(o.DomUtil.getStyle(a, "borderLeftWidth"), 10) || 0, i = o.DomUtil.getStyle(a, "position"), a.offsetParent === r && "absolute" === i)break;
                        if ("fixed" === i) {
                            n += r.scrollTop || h.scrollTop || 0, s += r.scrollLeft || h.scrollLeft || 0;
                            break
                        }
                        if ("relative" === i && !a.offsetLeft) {
                            var l = o.DomUtil.getStyle(a, "width"), u = o.DomUtil.getStyle(a, "max-width"), c = a.getBoundingClientRect();
                            ("none" !== l || "none" !== u) && (s += c.left + a.clientLeft), n += c.top + (r.scrollTop || h.scrollTop || 0);
                            break
                        }
                        a = a.offsetParent
                    } while (a);
                    a = t;
                    do {
                        if (a === r)break;
                        n -= a.scrollTop || 0, s -= a.scrollLeft || 0, a = a.parentNode
                    } while (a);
                    return new o.Point(s, n)
                }, documentIsLtr: function () {
                    return o.DomUtil._docIsLtrCached || (o.DomUtil._docIsLtrCached = !0, o.DomUtil._docIsLtr = "ltr" === o.DomUtil.getStyle(e.body, "direction")), o.DomUtil._docIsLtr
                }, create: function (t, i, n) {
                    var o = e.createElement(t);
                    return o.className = i, n && n.appendChild(o), o
                }, hasClass: function (t, e) {
                    if (t.classList !== i)return t.classList.contains(e);
                    var n = o.DomUtil._getClass(t);
                    return n.length > 0 && new RegExp("(^|\\s)" + e + "(\\s|$)").test(n)
                }, addClass: function (t, e) {
                    if (t.classList !== i)for (var n = o.Util.splitWords(e), s = 0, a = n.length; a > s; s++)t.classList.add(n[s]); else if (!o.DomUtil.hasClass(t, e)) {
                        var r = o.DomUtil._getClass(t);
                        o.DomUtil._setClass(t, (r ? r + " " : "") + e)
                    }
                }, removeClass: function (t, e) {
                    t.classList !== i ? t.classList.remove(e) : o.DomUtil._setClass(t, o.Util.trim((" " + o.DomUtil._getClass(t) + " ").replace(" " + e + " ", " ")))
                }, _setClass: function (t, e) {
                    t.className.baseVal === i ? t.className = e : t.className.baseVal = e
                }, _getClass: function (t) {
                    return t.className.baseVal === i ? t.className : t.className.baseVal
                }, setOpacity: function (t, e) {
                    if ("opacity" in t.style) t.style.opacity = e; else if ("filter" in t.style) {
                        var i = !1, n = "DXImageTransform.Microsoft.Alpha";
                        try {
                            i = t.filters.item(n)
                        } catch (o) {
                            if (1 === e)return
                        }
                        e = Math.round(100 * e), i ? (i.Enabled = 100 !== e, i.Opacity = e) : t.style.filter += " progid:" + n + "(opacity=" + e + ")"
                    }
                }, testProp: function (t) {
                    for (var i = e.documentElement.style, n = 0; n < t.length; n++)if (t[n] in i)return t[n];
                    return !1
                }, getTranslateString: function (t) {
                    var e = o.Browser.webkit3d, i = "translate" + (e ? "3d" : "") + "(", n = (e ? ",0" : "") + ")";
                    return i + t.x + "px," + t.y + "px" + n
                }, getScaleString: function (t, e) {
                    var i = o.DomUtil.getTranslateString(e.add(e.multiplyBy(-1 * t))), n = " scale(" + t + ") ";
                    return i + n
                }, setPosition: function (t, e, i) {
                    t._leaflet_pos = e, !i && o.Browser.any3d ? t.style[o.DomUtil.TRANSFORM] = o.DomUtil.getTranslateString(e) : (t.style.left = e.x + "px", t.style.top = e.y + "px")
                }, getPosition: function (t) {
                    return t._leaflet_pos
                }
            }, o.DomUtil.TRANSFORM = o.DomUtil.testProp(["transform", "WebkitTransform", "OTransform", "MozTransform", "msTransform"]), o.DomUtil.TRANSITION = o.DomUtil.testProp(["webkitTransition", "transition", "OTransition", "MozTransition", "msTransition"]), o.DomUtil.TRANSITION_END = "webkitTransition" === o.DomUtil.TRANSITION || "OTransition" === o.DomUtil.TRANSITION ? o.DomUtil.TRANSITION + "End" : "transitionend", function () {
                if ("onselectstart" in e) o.extend(o.DomUtil, {
                    disableTextSelection: function () {
                        o.DomEvent.on(t, "selectstart", o.DomEvent.preventDefault)
                    }, enableTextSelection: function () {
                        o.DomEvent.off(t, "selectstart", o.DomEvent.preventDefault)
                    }
                }); else {
                    var i = o.DomUtil.testProp(["userSelect", "WebkitUserSelect", "OUserSelect", "MozUserSelect", "msUserSelect"]);
                    o.extend(o.DomUtil, {
                        disableTextSelection: function () {
                            if (i) {
                                var t = e.documentElement.style;
                                this._userSelect = t[i], t[i] = "none"
                            }
                        }, enableTextSelection: function () {
                            i && (e.documentElement.style[i] = this._userSelect, delete this._userSelect)
                        }
                    })
                }
                o.extend(o.DomUtil, {
                    disableImageDrag: function () {
                        o.DomEvent.on(t, "dragstart", o.DomEvent.preventDefault)
                    }, enableImageDrag: function () {
                        o.DomEvent.off(t, "dragstart", o.DomEvent.preventDefault)
                    }
                })
            }(), o.LatLng = function (t, e, n) {
                if (t = parseFloat(t), e = parseFloat(e), isNaN(t) || isNaN(e))throw new Error("Invalid LatLng object: (" + t + ", " + e + ")");
                this.lat = t, this.lng = e, n !== i && (this.alt = parseFloat(n))
            }, o.extend(o.LatLng, {DEG_TO_RAD: Math.PI / 180, RAD_TO_DEG: 180 / Math.PI, MAX_MARGIN: 1e-9}), o.LatLng.prototype = {
                equals: function (t) {
                    if (!t)return !1;
                    t = o.latLng(t);
                    var e = Math.max(Math.abs(this.lat - t.lat), Math.abs(this.lng - t.lng));
                    return e <= o.LatLng.MAX_MARGIN
                }, toString: function (t) {
                    return "LatLng(" + o.Util.formatNum(this.lat, t) + ", " + o.Util.formatNum(this.lng, t) + ")"
                }, distanceTo: function (t) {
                    t = o.latLng(t);
                    var e = 6378137, i = o.LatLng.DEG_TO_RAD, n = (t.lat - this.lat) * i, s = (t.lng - this.lng) * i, a = this.lat * i, r = t.lat * i, h = Math.sin(n / 2), l = Math.sin(s / 2), u = h * h + l * l * Math.cos(a) * Math.cos(r);
                    return 2 * e * Math.atan2(Math.sqrt(u), Math.sqrt(1 - u))
                }, wrap: function (t, e) {
                    var i = this.lng;
                    return t = t || -180, e = e || 180, i = (i + e) % (e - t) + (t > i || i === e ? e : t), new o.LatLng(this.lat, i)
                }
            }, o.latLng = function (t, e) {
                return t instanceof o.LatLng ? t : o.Util.isArray(t) ? "number" == typeof t[0] || "string" == typeof t[0] ? new o.LatLng(t[0], t[1], t[2]) : null : t === i || null === t ? t : "object" == typeof t && "lat" in t ? new o.LatLng(t.lat, "lng" in t ? t.lng : t.lon) : e === i ? null : new o.LatLng(t, e)
            }, o.LatLngBounds = function (t, e) {
                if (t)for (var i = e ? [t, e] : t, n = 0, o = i.length; o > n; n++)this.extend(i[n])
            }, o.LatLngBounds.prototype = {
                extend: function (t) {
                    if (!t)return this;
                    var e = o.latLng(t);
                    return t = null !== e ? e : o.latLngBounds(t), t instanceof o.LatLng ? this._southWest || this._northEast ? (this._southWest.lat = Math.min(t.lat, this._southWest.lat), this._southWest.lng = Math.min(t.lng, this._southWest.lng), this._northEast.lat = Math.max(t.lat, this._northEast.lat), this._northEast.lng = Math.max(t.lng, this._northEast.lng)) : (this._southWest = new o.LatLng(t.lat, t.lng), this._northEast = new o.LatLng(t.lat, t.lng)) : t instanceof o.LatLngBounds && (this.extend(t._southWest), this.extend(t._northEast)), this
                }, pad: function (t) {
                    var e = this._southWest, i = this._northEast, n = Math.abs(e.lat - i.lat) * t, s = Math.abs(e.lng - i.lng) * t;
                    return new o.LatLngBounds(new o.LatLng(e.lat - n, e.lng - s), new o.LatLng(i.lat + n, i.lng + s))
                }, getCenter: function () {
                    return new o.LatLng((this._southWest.lat + this._northEast.lat) / 2, (this._southWest.lng + this._northEast.lng) / 2)
                }, getSouthWest: function () {
                    return this._southWest
                }, getNorthEast: function () {
                    return this._northEast
                }, getNorthWest: function () {
                    return new o.LatLng(this.getNorth(), this.getWest())
                }, getSouthEast: function () {
                    return new o.LatLng(this.getSouth(), this.getEast())
                }, getWest: function () {
                    return this._southWest.lng
                }, getSouth: function () {
                    return this._southWest.lat
                }, getEast: function () {
                    return this._northEast.lng
                }, getNorth: function () {
                    return this._northEast.lat
                }, contains: function (t) {
                    t = "number" == typeof t[0] || t instanceof o.LatLng ? o.latLng(t) : o.latLngBounds(t);
                    var e, i, n = this._southWest, s = this._northEast;
                    return t instanceof o.LatLngBounds ? (e = t.getSouthWest(), i = t.getNorthEast()) : e = i = t, e.lat >= n.lat && i.lat <= s.lat && e.lng >= n.lng && i.lng <= s.lng
                }, intersects: function (t) {
                    t = o.latLngBounds(t);
                    var e = this._southWest, i = this._northEast, n = t.getSouthWest(), s = t.getNorthEast(), a = s.lat >= e.lat && n.lat <= i.lat, r = s.lng >= e.lng && n.lng <= i.lng;
                    return a && r
                }, toBBoxString: function () {
                    return [this.getWest(), this.getSouth(), this.getEast(), this.getNorth()].join(",")
                }, equals: function (t) {
                    return t ? (t = o.latLngBounds(t), this._southWest.equals(t.getSouthWest()) && this._northEast.equals(t.getNorthEast())) : !1
                }, isValid: function () {
                    return !(!this._southWest || !this._northEast)
                }
            }, o.latLngBounds = function (t, e) {
                return !t || t instanceof o.LatLngBounds ? t : new o.LatLngBounds(t, e)
            }, o.Projection = {}, o.Projection.SphericalMercator = {
                MAX_LATITUDE: 85.0511287798, project: function (t) {
                    var e = o.LatLng.DEG_TO_RAD, i = this.MAX_LATITUDE, n = Math.max(Math.min(i, t.lat), -i), s = t.lng * e, a = n * e;
                    return a = Math.log(Math.tan(Math.PI / 4 + a / 2)), new o.Point(s, a)
                }, unproject: function (t) {
                    var e = o.LatLng.RAD_TO_DEG, i = t.x * e, n = (2 * Math.atan(Math.exp(t.y)) - Math.PI / 2) * e;
                    return new o.LatLng(n, i)
                }
            }, o.Projection.LonLat = {
                project: function (t) {
                    return new o.Point(t.lng, t.lat)
                }, unproject: function (t) {
                    return new o.LatLng(t.y, t.x)
                }
            }, o.CRS = {
                latLngToPoint: function (t, e) {
                    var i = this.projection.project(t), n = this.scale(e);
                    return this.transformation._transform(i, n)
                }, pointToLatLng: function (t, e) {
                    var i = this.scale(e), n = this.transformation.untransform(t, i);
                    return this.projection.unproject(n)
                }, project: function (t) {
                    return this.projection.project(t)
                }, scale: function (t) {
                    return 256 * Math.pow(2, t)
                }, getSize: function (t) {
                    var e = this.scale(t);
                    return o.point(e, e)
                }
            }, o.CRS.Simple = o.extend({}, o.CRS, {
                projection: o.Projection.LonLat, transformation: new o.Transformation(1, 0, -1, 0), scale: function (t) {
                    return Math.pow(2, t)
                }
            }), o.CRS.EPSG3857 = o.extend({}, o.CRS, {
                code: "EPSG:3857", projection: o.Projection.SphericalMercator, transformation: new o.Transformation(.5 / Math.PI, .5, -.5 / Math.PI, .5), project: function (t) {
                    var e = this.projection.project(t), i = 6378137;
                    return e.multiplyBy(i)
                }
            }), o.CRS.EPSG900913 = o.extend({}, o.CRS.EPSG3857, {code: "EPSG:900913"}), o.CRS.EPSG4326 = o.extend({}, o.CRS, {code: "EPSG:4326", projection: o.Projection.LonLat, transformation: new o.Transformation(1 / 360, .5, -1 / 360, .5)}), o.Map = o.Class.extend({
                includes: o.Mixin.Events, options: {crs: o.CRS.EPSG3857, fadeAnimation: o.DomUtil.TRANSITION && !o.Browser.android23, trackResize: !0, markerZoomAnimation: o.DomUtil.TRANSITION && o.Browser.any3d}, initialize: function (t, e) {
                    e = o.setOptions(this, e), this._initContainer(t), this._initLayout(), this._onResize = o.bind(this._onResize, this), this._initEvents(), e.maxBounds && this.setMaxBounds(e.maxBounds), e.center && e.zoom !== i && this.setView(o.latLng(e.center), e.zoom, {reset: !0}), this._handlers = [], this._layers = {}, this._zoomBoundLayers = {}, this._tileLayersNum = 0, this.callInitHooks(), this._addLayers(e.layers)
                }, setView: function (t, e) {
                    return e = e === i ? this.getZoom() : e, this._resetView(o.latLng(t), this._limitZoom(e)), this
                }, setZoom: function (t, e) {
                    return this._loaded ? this.setView(this.getCenter(), t, {zoom: e}) : (this._zoom = this._limitZoom(t), this)
                }, zoomIn: function (t, e) {
                    return this.setZoom(this._zoom + (t || 1), e)
                }, zoomOut: function (t, e) {
                    return this.setZoom(this._zoom - (t || 1), e)
                }, setZoomAround: function (t, e, i) {
                    var n = this.getZoomScale(e), s = this.getSize().divideBy(2), a = t instanceof o.Point ? t : this.latLngToContainerPoint(t), r = a.subtract(s).multiplyBy(1 - 1 / n), h = this.containerPointToLatLng(s.add(r));
                    return this.setView(h, e, {zoom: i})
                }, fitBounds: function (t, e) {
                    e = e || {}, t = t.getBounds ? t.getBounds() : o.latLngBounds(t);
                    var i = o.point(e.paddingTopLeft || e.padding || [0, 0]), n = o.point(e.paddingBottomRight || e.padding || [0, 0]), s = this.getBoundsZoom(t, !1, i.add(n));
                    s = e.maxZoom ? Math.min(e.maxZoom, s) : s;
                    var a = n.subtract(i).divideBy(2), r = this.project(t.getSouthWest(), s), h = this.project(t.getNorthEast(), s), l = this.unproject(r.add(h).divideBy(2).add(a), s);
                    return this.setView(l, s, e)
                }, fitWorld: function (t) {
                    return this.fitBounds([[-90, -180], [90, 180]], t)
                }, panTo: function (t, e) {
                    return this.setView(t, this._zoom, {pan: e})
                }, panBy: function (t) {
                    return this.fire("movestart"), this._rawPanBy(o.point(t)), this.fire("move"), this.fire("moveend")
                }, setMaxBounds: function (t) {
                    return t = o.latLngBounds(t), this.options.maxBounds = t, t ? (this._loaded && this._panInsideMaxBounds(), this.on("moveend", this._panInsideMaxBounds, this)) : this.off("moveend", this._panInsideMaxBounds, this)
                }, panInsideBounds: function (t, e) {
                    var i = this.getCenter(), n = this._limitCenter(i, this._zoom, t);
                    return i.equals(n) ? this : this.panTo(n, e)
                }, addLayer: function (t) {
                    var e = o.stamp(t);
                    return this._layers[e] ? this : (this._layers[e] = t, !t.options || isNaN(t.options.maxZoom) && isNaN(t.options.minZoom) || (this._zoomBoundLayers[e] = t, this._updateZoomLevels()), this.options.zoomAnimation && o.TileLayer && t instanceof o.TileLayer && (this._tileLayersNum++, this._tileLayersToLoad++, t.on("load", this._onTileLayerLoad, this)), this._loaded && this._layerAdd(t), this)
                }, removeLayer: function (t) {
                    var e = o.stamp(t);
                    return this._layers[e] ? (this._loaded && t.onRemove(this), delete this._layers[e], this._loaded && this.fire("layerremove", {layer: t}), this._zoomBoundLayers[e] && (delete this._zoomBoundLayers[e], this._updateZoomLevels()), this.options.zoomAnimation && o.TileLayer && t instanceof o.TileLayer && (this._tileLayersNum--, this._tileLayersToLoad--, t.off("load", this._onTileLayerLoad, this)), this) : this
                }, hasLayer: function (t) {
                    return t ? o.stamp(t) in this._layers : !1
                }, eachLayer: function (t, e) {
                    for (var i in this._layers)t.call(e, this._layers[i]);
                    return this
                }, invalidateSize: function (t) {
                    if (!this._loaded)return this;
                    t = o.extend({animate: !1, pan: !0}, t === !0 ? {animate: !0} : t);
                    var e = this.getSize();
                    this._sizeChanged = !0, this._initialCenter = null;
                    var i = this.getSize(), n = e.divideBy(2).round(), s = i.divideBy(2).round(), a = n.subtract(s);
                    return a.x || a.y ? (t.animate && t.pan ? this.panBy(a) : (t.pan && this._rawPanBy(a), this.fire("move"), t.debounceMoveend ? (clearTimeout(this._sizeTimer), this._sizeTimer = setTimeout(o.bind(this.fire, this, "moveend"), 200)) : this.fire("moveend")), this.fire("resize", {oldSize: e, newSize: i})) : this
                }, addHandler: function (t, e) {
                    if (!e)return this;
                    var i = this[t] = new e(this);
                    return this._handlers.push(i), this.options[t] && i.enable(), this
                }, remove: function () {
                    this._loaded && this.fire("unload"), this._initEvents("off");
                    try {
                        delete this._container._leaflet
                    } catch (t) {
                        this._container._leaflet = i
                    }
                    return this._clearPanes(), this._clearControlPos && this._clearControlPos(), this._clearHandlers(), this
                }, getCenter: function () {
                    return this._checkIfLoaded(), this._initialCenter && !this._moved() ? this._initialCenter : this.layerPointToLatLng(this._getCenterLayerPoint())
                }, getZoom: function () {
                    return this._zoom
                }, getBounds: function () {
                    var t = this.getPixelBounds(), e = this.unproject(t.getBottomLeft()), i = this.unproject(t.getTopRight());
                    return new o.LatLngBounds(e, i)
                }, getMinZoom: function () {
                    return this.options.minZoom === i ? this._layersMinZoom === i ? 0 : this._layersMinZoom : this.options.minZoom
                }, getMaxZoom: function () {
                    return this.options.maxZoom === i ? this._layersMaxZoom === i ? 1 / 0 : this._layersMaxZoom : this.options.maxZoom
                }, getBoundsZoom: function (t, e, i) {
                    t = o.latLngBounds(t);
                    var n, s = this.getMinZoom() - (e ? 1 : 0), a = this.getMaxZoom(), r = this.getSize(), h = t.getNorthWest(), l = t.getSouthEast(), u = !0;
                    i = o.point(i || [0, 0]);
                    do s++, n = this.project(l, s).subtract(this.project(h, s)).add(i), u = e ? n.x < r.x || n.y < r.y : r.contains(n); while (u && a >= s);
                    return u && e ? null : e ? s : s - 1
                }, getSize: function () {
                    return (!this._size || this._sizeChanged) && (this._size = new o.Point(this._container.clientWidth, this._container.clientHeight), this._sizeChanged = !1), this._size.clone()
                }, getPixelBounds: function () {
                    var t = this._getTopLeftPoint();
                    return new o.Bounds(t, t.add(this.getSize()))
                }, getPixelOrigin: function () {
                    return this._checkIfLoaded(), this._initialTopLeftPoint
                }, getPanes: function () {
                    return this._panes
                }, getContainer: function () {
                    return this._container
                }, getZoomScale: function (t) {
                    var e = this.options.crs;
                    return e.scale(t) / e.scale(this._zoom)
                }, getScaleZoom: function (t) {
                    return this._zoom + Math.log(t) / Math.LN2
                }, project: function (t, e) {
                    return e = e === i ? this._zoom : e, this.options.crs.latLngToPoint(o.latLng(t), e)
                }, unproject: function (t, e) {
                    return e = e === i ? this._zoom : e, this.options.crs.pointToLatLng(o.point(t), e)
                }, layerPointToLatLng: function (t) {
                    var e = o.point(t).add(this.getPixelOrigin());
                    return this.unproject(e)
                }, latLngToLayerPoint: function (t) {
                    var e = this.project(o.latLng(t))._round();
                    return e._subtract(this.getPixelOrigin())
                }, containerPointToLayerPoint: function (t) {
                    return o.point(t).subtract(this._getMapPanePos())
                }, layerPointToContainerPoint: function (t) {
                    return o.point(t).add(this._getMapPanePos())
                }, containerPointToLatLng: function (t) {
                    var e = this.containerPointToLayerPoint(o.point(t));
                    return this.layerPointToLatLng(e)
                }, latLngToContainerPoint: function (t) {
                    return this.layerPointToContainerPoint(this.latLngToLayerPoint(o.latLng(t)))
                }, mouseEventToContainerPoint: function (t) {
                    return o.DomEvent.getMousePosition(t, this._container)
                }, mouseEventToLayerPoint: function (t) {
                    return this.containerPointToLayerPoint(this.mouseEventToContainerPoint(t))
                }, mouseEventToLatLng: function (t) {
                    return this.layerPointToLatLng(this.mouseEventToLayerPoint(t))
                }, _initContainer: function (t) {
                    var e = this._container = o.DomUtil.get(t);
                    if (!e)throw new Error("Map container not found.");
                    if (e._leaflet)throw new Error("Map container is already initialized.");
                    e._leaflet = !0
                }, _initLayout: function () {
                    var t = this._container;
                    o.DomUtil.addClass(t, "leaflet-container" + (o.Browser.touch ? " leaflet-touch" : "") + (o.Browser.retina ? " leaflet-retina" : "") + (o.Browser.ielt9 ? " leaflet-oldie" : "") + (this.options.fadeAnimation ? " leaflet-fade-anim" : ""));
                    var e = o.DomUtil.getStyle(t, "position");
                    "absolute" !== e && "relative" !== e && "fixed" !== e && (t.style.position = "relative"), this._initPanes(), this._initControlPos && this._initControlPos()
                }, _initPanes: function () {
                    var t = this._panes = {};
                    this._mapPane = t.mapPane = this._createPane("leaflet-map-pane", this._container), this._tilePane = t.tilePane = this._createPane("leaflet-tile-pane", this._mapPane), t.objectsPane = this._createPane("leaflet-objects-pane", this._mapPane), t.shadowPane = this._createPane("leaflet-shadow-pane"), t.overlayPane = this._createPane("leaflet-overlay-pane"), t.markerPane = this._createPane("leaflet-marker-pane"), t.popupPane = this._createPane("leaflet-popup-pane");
                    var e = " leaflet-zoom-hide";
                    this.options.markerZoomAnimation || (o.DomUtil.addClass(t.markerPane, e), o.DomUtil.addClass(t.shadowPane, e), o.DomUtil.addClass(t.popupPane, e))
                }, _createPane: function (t, e) {
                    return o.DomUtil.create("div", t, e || this._panes.objectsPane)
                }, _clearPanes: function () {
                    this._container.removeChild(this._mapPane)
                }, _addLayers: function (t) {
                    t = t ? o.Util.isArray(t) ? t : [t] : [];
                    for (var e = 0, i = t.length; i > e; e++)this.addLayer(t[e])
                }, _resetView: function (t, e, i, n) {
                    var s = this._zoom !== e;
                    n || (this.fire("movestart"), s && this.fire("zoomstart")), this._zoom = e, this._initialCenter = t, this._initialTopLeftPoint = this._getNewTopLeftPoint(t), i ? this._initialTopLeftPoint._add(this._getMapPanePos()) : o.DomUtil.setPosition(this._mapPane, new o.Point(0, 0)), this._tileLayersToLoad = this._tileLayersNum;
                    var a = !this._loaded;
                    this._loaded = !0, this.fire("viewreset", {hard: !i}), a && (this.fire("load"), this.eachLayer(this._layerAdd, this)), this.fire("move"), (s || n) && this.fire("zoomend"), this.fire("moveend", {hard: !i})
                }, _rawPanBy: function (t) {
                    o.DomUtil.setPosition(this._mapPane, this._getMapPanePos().subtract(t))
                }, _getZoomSpan: function () {
                    return this.getMaxZoom() - this.getMinZoom()
                }, _updateZoomLevels: function () {
                    var t, e = 1 / 0, n = -(1 / 0), o = this._getZoomSpan();
                    for (t in this._zoomBoundLayers) {
                        var s = this._zoomBoundLayers[t];
                        isNaN(s.options.minZoom) || (e = Math.min(e, s.options.minZoom)), isNaN(s.options.maxZoom) || (n = Math.max(n, s.options.maxZoom))
                    }
                    t === i ? this._layersMaxZoom = this._layersMinZoom = i : (this._layersMaxZoom = n, this._layersMinZoom = e), o !== this._getZoomSpan() && this.fire("zoomlevelschange")
                }, _panInsideMaxBounds: function () {
                    this.panInsideBounds(this.options.maxBounds)
                }, _checkIfLoaded: function () {
                    if (!this._loaded)throw new Error("Set map center and zoom first.")
                }, _initEvents: function (e) {
                    if (o.DomEvent) {
                        e = e || "on", o.DomEvent[e](this._container, "click", this._onMouseClick, this);
                        var i, n, s = ["dblclick", "mousedown", "mouseup", "mouseenter", "mouseleave", "mousemove", "contextmenu"];
                        for (i = 0, n = s.length; n > i; i++)o.DomEvent[e](this._container, s[i], this._fireMouseEvent, this);
                        this.options.trackResize && o.DomEvent[e](t, "resize", this._onResize, this)
                    }
                }, _onResize: function () {
                    o.Util.cancelAnimFrame(this._resizeRequest), this._resizeRequest = o.Util.requestAnimFrame(function () {
                        this.invalidateSize({debounceMoveend: !0})
                    }, this, !1, this._container)
                }, _onMouseClick: function (t) {
                    !this._loaded || !t._simulated && (this.dragging && this.dragging.moved() || this.boxZoom && this.boxZoom.moved()) || o.DomEvent._skipped(t) || (this.fire("preclick"), this._fireMouseEvent(t))
                }, _fireMouseEvent: function (t) {
                    if (this._loaded && !o.DomEvent._skipped(t)) {
                        var e = t.type;
                        if (e = "mouseenter" === e ? "mouseover" : "mouseleave" === e ? "mouseout" : e, this.hasEventListeners(e)) {
                            "contextmenu" === e && o.DomEvent.preventDefault(t);
                            var i = this.mouseEventToContainerPoint(t), n = this.containerPointToLayerPoint(i), s = this.layerPointToLatLng(n);
                            this.fire(e, {latlng: s, layerPoint: n, containerPoint: i, originalEvent: t})
                        }
                    }
                }, _onTileLayerLoad: function () {
                    this._tileLayersToLoad--, this._tileLayersNum && !this._tileLayersToLoad && this.fire("tilelayersload")
                }, _clearHandlers: function () {
                    for (var t = 0, e = this._handlers.length; e > t; t++)this._handlers[t].disable()
                }, whenReady: function (t, e) {
                    return this._loaded ? t.call(e || this, this) : this.on("load", t, e), this
                }, _layerAdd: function (t) {
                    t.onAdd(this), this.fire("layeradd", {layer: t})
                }, _getMapPanePos: function () {
                    return o.DomUtil.getPosition(this._mapPane)
                }, _moved: function () {
                    var t = this._getMapPanePos();
                    return t && !t.equals([0, 0])
                }, _getTopLeftPoint: function () {
                    return this.getPixelOrigin().subtract(this._getMapPanePos())
                }, _getNewTopLeftPoint: function (t, e) {
                    var i = this.getSize()._divideBy(2);
                    return this.project(t, e)._subtract(i)._round()
                }, _latLngToNewLayerPoint: function (t, e, i) {
                    var n = this._getNewTopLeftPoint(i, e).add(this._getMapPanePos());
                    return this.project(t, e)._subtract(n)
                }, _getCenterLayerPoint: function () {
                    return this.containerPointToLayerPoint(this.getSize()._divideBy(2))
                }, _getCenterOffset: function (t) {
                    return this.latLngToLayerPoint(t).subtract(this._getCenterLayerPoint())
                }, _limitCenter: function (t, e, i) {
                    if (!i)return t;
                    var n = this.project(t, e), s = this.getSize().divideBy(2), a = new o.Bounds(n.subtract(s), n.add(s)), r = this._getBoundsOffset(a, i, e);
                    return this.unproject(n.add(r), e)
                }, _limitOffset: function (t, e) {
                    if (!e)return t;
                    var i = this.getPixelBounds(), n = new o.Bounds(i.min.add(t), i.max.add(t));
                    return t.add(this._getBoundsOffset(n, e))
                }, _getBoundsOffset: function (t, e, i) {
                    var n = this.project(e.getNorthWest(), i).subtract(t.min), s = this.project(e.getSouthEast(), i).subtract(t.max), a = this._rebound(n.x, -s.x), r = this._rebound(n.y, -s.y);
                    return new o.Point(a, r)
                }, _rebound: function (t, e) {
                    return t + e > 0 ? Math.round(t - e) / 2 : Math.max(0, Math.ceil(t)) - Math.max(0, Math.floor(e))
                }, _limitZoom: function (t) {
                    var e = this.getMinZoom(), i = this.getMaxZoom();
                    return Math.max(e, Math.min(i, t))
                }
            }), o.map = function (t, e) {
                return new o.Map(t, e)
            }, o.Projection.Mercator = {
                MAX_LATITUDE: 85.0840591556, R_MINOR: 6356752.314245179, R_MAJOR: 6378137, project: function (t) {
                    var e = o.LatLng.DEG_TO_RAD, i = this.MAX_LATITUDE, n = Math.max(Math.min(i, t.lat), -i), s = this.R_MAJOR, a = this.R_MINOR, r = t.lng * e * s, h = n * e, l = a / s, u = Math.sqrt(1 - l * l), c = u * Math.sin(h);
                    c = Math.pow((1 - c) / (1 + c), .5 * u);
                    var d = Math.tan(.5 * (.5 * Math.PI - h)) / c;
                    return h = -s * Math.log(d), new o.Point(r, h)
                }, unproject: function (t) {
                    for (var e, i = o.LatLng.RAD_TO_DEG, n = this.R_MAJOR, s = this.R_MINOR, a = t.x * i / n, r = s / n, h = Math.sqrt(1 - r * r), l = Math.exp(-t.y / n), u = Math.PI / 2 - 2 * Math.atan(l), c = 15, d = 1e-7, p = c, _ = .1; Math.abs(_) > d && --p > 0;)e = h * Math.sin(u), _ = Math.PI / 2 - 2 * Math.atan(l * Math.pow((1 - e) / (1 + e), .5 * h)) - u, u += _;
                    return new o.LatLng(u * i, a)
                }
            }, o.CRS.EPSG3395 = o.extend({}, o.CRS, {
                code: "EPSG:3395", projection: o.Projection.Mercator,
                transformation: function () {
                    var t = o.Projection.Mercator, e = t.R_MAJOR, i = .5 / (Math.PI * e);
                    return new o.Transformation(i, .5, -i, .5)
                }()
            }), o.TileLayer = o.Class.extend({
                includes: o.Mixin.Events, options: {minZoom: 0, maxZoom: 18, tileSize: 256, subdomains: "abc", errorTileUrl: "", attribution: "", zoomOffset: 0, opacity: 1, unloadInvisibleTiles: o.Browser.mobile, updateWhenIdle: o.Browser.mobile}, initialize: function (t, e) {
                    e = o.setOptions(this, e), e.detectRetina && o.Browser.retina && e.maxZoom > 0 && (e.tileSize = Math.floor(e.tileSize / 2), e.zoomOffset++, e.minZoom > 0 && e.minZoom--, this.options.maxZoom--), e.bounds && (e.bounds = o.latLngBounds(e.bounds)), this._url = t;
                    var i = this.options.subdomains;
                    "string" == typeof i && (this.options.subdomains = i.split(""))
                }, onAdd: function (t) {
                    this._map = t, this._animated = t._zoomAnimated, this._initContainer(), t.on({viewreset: this._reset, moveend: this._update}, this), this._animated && t.on({zoomanim: this._animateZoom, zoomend: this._endZoomAnim}, this), this.options.updateWhenIdle || (this._limitedUpdate = o.Util.limitExecByInterval(this._update, 150, this), t.on("move", this._limitedUpdate, this)), this._reset(), this._update()
                }, addTo: function (t) {
                    return t.addLayer(this), this
                }, onRemove: function (t) {
                    this._container.parentNode.removeChild(this._container), t.off({viewreset: this._reset, moveend: this._update}, this), this._animated && t.off({zoomanim: this._animateZoom, zoomend: this._endZoomAnim}, this), this.options.updateWhenIdle || t.off("move", this._limitedUpdate, this), this._container = null, this._map = null
                }, bringToFront: function () {
                    var t = this._map._panes.tilePane;
                    return this._container && (t.appendChild(this._container), this._setAutoZIndex(t, Math.max)), this
                }, bringToBack: function () {
                    var t = this._map._panes.tilePane;
                    return this._container && (t.insertBefore(this._container, t.firstChild), this._setAutoZIndex(t, Math.min)), this
                }, getAttribution: function () {
                    return this.options.attribution
                }, getContainer: function () {
                    return this._container
                }, setOpacity: function (t) {
                    return this.options.opacity = t, this._map && this._updateOpacity(), this
                }, setZIndex: function (t) {
                    return this.options.zIndex = t, this._updateZIndex(), this
                }, setUrl: function (t, e) {
                    return this._url = t, e || this.redraw(), this
                }, redraw: function () {
                    return this._map && (this._reset({hard: !0}), this._update()), this
                }, _updateZIndex: function () {
                    this._container && this.options.zIndex !== i && (this._container.style.zIndex = this.options.zIndex)
                }, _setAutoZIndex: function (t, e) {
                    var i, n, o, s = t.children, a = -e(1 / 0, -(1 / 0));
                    for (n = 0, o = s.length; o > n; n++)s[n] !== this._container && (i = parseInt(s[n].style.zIndex, 10), isNaN(i) || (a = e(a, i)));
                    this.options.zIndex = this._container.style.zIndex = (isFinite(a) ? a : 0) + e(1, -1)
                }, _updateOpacity: function () {
                    var t, e = this._tiles;
                    if (o.Browser.ielt9)for (t in e)o.DomUtil.setOpacity(e[t], this.options.opacity); else o.DomUtil.setOpacity(this._container, this.options.opacity)
                }, _initContainer: function () {
                    var t = this._map._panes.tilePane;
                    if (!this._container) {
                        if (this._container = o.DomUtil.create("div", "leaflet-layer"), this._updateZIndex(), this._animated) {
                            var e = "leaflet-tile-container";
                            this._bgBuffer = o.DomUtil.create("div", e, this._container), this._tileContainer = o.DomUtil.create("div", e, this._container)
                        } else this._tileContainer = this._container;
                        t.appendChild(this._container), this.options.opacity < 1 && this._updateOpacity()
                    }
                }, _reset: function (t) {
                    for (var e in this._tiles)this.fire("tileunload", {tile: this._tiles[e]});
                    this._tiles = {}, this._tilesToLoad = 0, this.options.reuseTiles && (this._unusedTiles = []), this._tileContainer.innerHTML = "", this._animated && t && t.hard && this._clearBgBuffer(), this._initContainer()
                }, _getTileSize: function () {
                    var t = this._map, e = t.getZoom() + this.options.zoomOffset, i = this.options.maxNativeZoom, n = this.options.tileSize;
                    return i && e > i && (n = Math.round(t.getZoomScale(e) / t.getZoomScale(i) * n)), n
                }, _update: function () {
                    if (this._map) {
                        var t = this._map, e = t.getPixelBounds(), i = t.getZoom(), n = this._getTileSize();
                        if (!(i > this.options.maxZoom || i < this.options.minZoom)) {
                            var s = o.bounds(e.min.divideBy(n)._floor(), e.max.divideBy(n)._floor());
                            this._addTilesFromCenterOut(s), (this.options.unloadInvisibleTiles || this.options.reuseTiles) && this._removeOtherTiles(s)
                        }
                    }
                }, _addTilesFromCenterOut: function (t) {
                    var i, n, s, a = [], r = t.getCenter();
                    for (i = t.min.y; i <= t.max.y; i++)for (n = t.min.x; n <= t.max.x; n++)s = new o.Point(n, i), this._tileShouldBeLoaded(s) && a.push(s);
                    var h = a.length;
                    if (0 !== h) {
                        a.sort(function (t, e) {
                            return t.distanceTo(r) - e.distanceTo(r)
                        });
                        var l = e.createDocumentFragment();
                        for (this._tilesToLoad || this.fire("loading"), this._tilesToLoad += h, n = 0; h > n; n++)this._addTile(a[n], l);
                        this._tileContainer.appendChild(l)
                    }
                }, _tileShouldBeLoaded: function (t) {
                    if (t.x + ":" + t.y in this._tiles)return !1;
                    var e = this.options;
                    if (!e.continuousWorld) {
                        var i = this._getWrapTileNum();
                        if (e.noWrap && (t.x < 0 || t.x >= i.x) || t.y < 0 || t.y >= i.y)return !1
                    }
                    if (e.bounds) {
                        var n = this._getTileSize(), o = t.multiplyBy(n), s = o.add([n, n]), a = this._map.unproject(o), r = this._map.unproject(s);
                        if (e.continuousWorld || e.noWrap || (a = a.wrap(), r = r.wrap()), !e.bounds.intersects([a, r]))return !1
                    }
                    return !0
                }, _removeOtherTiles: function (t) {
                    var e, i, n, o;
                    for (o in this._tiles)e = o.split(":"), i = parseInt(e[0], 10), n = parseInt(e[1], 10), (i < t.min.x || i > t.max.x || n < t.min.y || n > t.max.y) && this._removeTile(o)
                }, _removeTile: function (t) {
                    var e = this._tiles[t];
                    this.fire("tileunload", {tile: e, url: e.src}), this.options.reuseTiles ? (o.DomUtil.removeClass(e, "leaflet-tile-loaded"), this._unusedTiles.push(e)) : e.parentNode === this._tileContainer && this._tileContainer.removeChild(e), o.Browser.android || (e.onload = null, e.src = o.Util.emptyImageUrl), delete this._tiles[t]
                }, _addTile: function (t, e) {
                    var i = this._getTilePos(t), n = this._getTile();
                    o.DomUtil.setPosition(n, i, o.Browser.chrome), this._tiles[t.x + ":" + t.y] = n, this._loadTile(n, t), n.parentNode !== this._tileContainer && e.appendChild(n)
                }, _getZoomForUrl: function () {
                    var t = this.options, e = this._map.getZoom();
                    return t.zoomReverse && (e = t.maxZoom - e), e += t.zoomOffset, t.maxNativeZoom ? Math.min(e, t.maxNativeZoom) : e
                }, _getTilePos: function (t) {
                    var e = this._map.getPixelOrigin(), i = this._getTileSize();
                    return t.multiplyBy(i).subtract(e)
                }, getTileUrl: function (t) {
                    return o.Util.template(this._url, o.extend({s: this._getSubdomain(t), z: t.z, x: t.x, y: t.y}, this.options))
                }, _getWrapTileNum: function () {
                    var t = this._map.options.crs, e = t.getSize(this._map.getZoom());
                    return e.divideBy(this._getTileSize())._floor()
                }, _adjustTilePoint: function (t) {
                    var e = this._getWrapTileNum();
                    this.options.continuousWorld || this.options.noWrap || (t.x = (t.x % e.x + e.x) % e.x), this.options.tms && (t.y = e.y - t.y - 1), t.z = this._getZoomForUrl()
                }, _getSubdomain: function (t) {
                    var e = Math.abs(t.x + t.y) % this.options.subdomains.length;
                    return this.options.subdomains[e]
                }, _getTile: function () {
                    if (this.options.reuseTiles && this._unusedTiles.length > 0) {
                        var t = this._unusedTiles.pop();
                        return this._resetTile(t), t
                    }
                    return this._createTile()
                }, _resetTile: function () {
                }, _createTile: function () {
                    var t = o.DomUtil.create("img", "leaflet-tile");
                    return t.style.width = t.style.height = this._getTileSize() + "px", t.galleryimg = "no", t.onselectstart = t.onmousemove = o.Util.falseFn, o.Browser.ielt9 && this.options.opacity !== i && o.DomUtil.setOpacity(t, this.options.opacity), o.Browser.mobileWebkit3d && (t.style.WebkitBackfaceVisibility = "hidden"), t
                }, _loadTile: function (t, e) {
                    t._layer = this, t.onload = this._tileOnLoad, t.onerror = this._tileOnError, this._adjustTilePoint(e), t.src = this.getTileUrl(e), this.fire("tileloadstart", {tile: t, url: t.src})
                }, _tileLoaded: function () {
                    this._tilesToLoad--, this._animated && o.DomUtil.addClass(this._tileContainer, "leaflet-zoom-animated"), this._tilesToLoad || (this.fire("load"), this._animated && (clearTimeout(this._clearBgBufferTimer), this._clearBgBufferTimer = setTimeout(o.bind(this._clearBgBuffer, this), 500)))
                }, _tileOnLoad: function () {
                    var t = this._layer;
                    this.src !== o.Util.emptyImageUrl && (o.DomUtil.addClass(this, "leaflet-tile-loaded"), t.fire("tileload", {tile: this, url: this.src})), t._tileLoaded()
                }, _tileOnError: function () {
                    var t = this._layer;
                    t.fire("tileerror", {tile: this, url: this.src});
                    var e = t.options.errorTileUrl;
                    e && (this.src = e), t._tileLoaded()
                }
            }), o.tileLayer = function (t, e) {
                return new o.TileLayer(t, e)
            }, o.TileLayer.WMS = o.TileLayer.extend({
                defaultWmsParams: {service: "WMS", request: "GetMap", version: "1.1.1", layers: "", styles: "", format: "image/jpeg", transparent: !1}, initialize: function (t, e) {
                    this._url = t;
                    var i = o.extend({}, this.defaultWmsParams), n = e.tileSize || this.options.tileSize;
                    e.detectRetina && o.Browser.retina ? i.width = i.height = 2 * n : i.width = i.height = n;
                    for (var s in e)this.options.hasOwnProperty(s) || "crs" === s || (i[s] = e[s]);
                    this.wmsParams = i, o.setOptions(this, e)
                }, onAdd: function (t) {
                    this._crs = this.options.crs || t.options.crs, this._wmsVersion = parseFloat(this.wmsParams.version);
                    var e = this._wmsVersion >= 1.3 ? "crs" : "srs";
                    this.wmsParams[e] = this._crs.code, o.TileLayer.prototype.onAdd.call(this, t)
                }, getTileUrl: function (t) {
                    var e = this._map, i = this.options.tileSize, n = t.multiplyBy(i), s = n.add([i, i]), a = this._crs.project(e.unproject(n, t.z)), r = this._crs.project(e.unproject(s, t.z)), h = this._wmsVersion >= 1.3 && this._crs === o.CRS.EPSG4326 ? [r.y, a.x, a.y, r.x].join(",") : [a.x, r.y, r.x, a.y].join(","), l = o.Util.template(this._url, {s: this._getSubdomain(t)});
                    return l + o.Util.getParamString(this.wmsParams, l, !0) + "&BBOX=" + h
                }, setParams: function (t, e) {
                    return o.extend(this.wmsParams, t), e || this.redraw(), this
                }
            }), o.tileLayer.wms = function (t, e) {
                return new o.TileLayer.WMS(t, e)
            }, o.TileLayer.Canvas = o.TileLayer.extend({
                options: {async: !1}, initialize: function (t) {
                    o.setOptions(this, t)
                }, redraw: function () {
                    this._map && (this._reset({hard: !0}), this._update());
                    for (var t in this._tiles)this._redrawTile(this._tiles[t]);
                    return this
                }, _redrawTile: function (t) {
                    this.drawTile(t, t._tilePoint, this._map._zoom)
                }, _createTile: function () {
                    var t = o.DomUtil.create("canvas", "leaflet-tile");
                    return t.width = t.height = this.options.tileSize, t.onselectstart = t.onmousemove = o.Util.falseFn, t
                }, _loadTile: function (t, e) {
                    t._layer = this, t._tilePoint = e, this._redrawTile(t), this.options.async || this.tileDrawn(t)
                }, drawTile: function () {
                }, tileDrawn: function (t) {
                    this._tileOnLoad.call(t)
                }
            }), o.tileLayer.canvas = function (t) {
                return new o.TileLayer.Canvas(t)
            }, o.ImageOverlay = o.Class.extend({
                includes: o.Mixin.Events, options: {opacity: 1}, initialize: function (t, e, i) {
                    this._url = t, this._bounds = o.latLngBounds(e), o.setOptions(this, i)
                }, onAdd: function (t) {
                    this._map = t, this._image || this._initImage(), t._panes.overlayPane.appendChild(this._image), t.on("viewreset", this._reset, this), t.options.zoomAnimation && o.Browser.any3d && t.on("zoomanim", this._animateZoom, this), this._reset()
                }, onRemove: function (t) {
                    t.getPanes().overlayPane.removeChild(this._image), t.off("viewreset", this._reset, this), t.options.zoomAnimation && t.off("zoomanim", this._animateZoom, this)
                }, addTo: function (t) {
                    return t.addLayer(this), this
                }, setOpacity: function (t) {
                    return this.options.opacity = t, this._updateOpacity(), this
                }, bringToFront: function () {
                    return this._image && this._map._panes.overlayPane.appendChild(this._image), this
                }, bringToBack: function () {
                    var t = this._map._panes.overlayPane;
                    return this._image && t.insertBefore(this._image, t.firstChild), this
                }, setUrl: function (t) {
                    this._url = t, this._image.src = this._url
                }, getAttribution: function () {
                    return this.options.attribution
                }, _initImage: function () {
                    this._image = o.DomUtil.create("img", "leaflet-image-layer"), this._map.options.zoomAnimation && o.Browser.any3d ? o.DomUtil.addClass(this._image, "leaflet-zoom-animated") : o.DomUtil.addClass(this._image, "leaflet-zoom-hide"), this._updateOpacity(), o.extend(this._image, {galleryimg: "no", onselectstart: o.Util.falseFn, onmousemove: o.Util.falseFn, onload: o.bind(this._onImageLoad, this), src: this._url})
                }, _animateZoom: function (t) {
                    var e = this._map, i = this._image, n = e.getZoomScale(t.zoom), s = this._bounds.getNorthWest(), a = this._bounds.getSouthEast(), r = e._latLngToNewLayerPoint(s, t.zoom, t.center), h = e._latLngToNewLayerPoint(a, t.zoom, t.center)._subtract(r), l = r._add(h._multiplyBy(.5 * (1 - 1 / n)));
                    i.style[o.DomUtil.TRANSFORM] = o.DomUtil.getTranslateString(l) + " scale(" + n + ") "
                }, _reset: function () {
                    var t = this._image, e = this._map.latLngToLayerPoint(this._bounds.getNorthWest()), i = this._map.latLngToLayerPoint(this._bounds.getSouthEast())._subtract(e);
                    o.DomUtil.setPosition(t, e), t.style.width = i.x + "px", t.style.height = i.y + "px"
                }, _onImageLoad: function () {
                    this.fire("load")
                }, _updateOpacity: function () {
                    o.DomUtil.setOpacity(this._image, this.options.opacity)
                }
            }), o.imageOverlay = function (t, e, i) {
                return new o.ImageOverlay(t, e, i)
            }, o.Icon = o.Class.extend({
                options: {className: ""}, initialize: function (t) {
                    o.setOptions(this, t)
                }, createIcon: function (t) {
                    return this._createIcon("icon", t)
                }, createShadow: function (t) {
                    return this._createIcon("shadow", t)
                }, _createIcon: function (t, e) {
                    var i = this._getIconUrl(t);
                    if (!i) {
                        if ("icon" === t)throw new Error("iconUrl not set in Icon options (see the docs).");
                        return null
                    }
                    var n;
                    return n = e && "IMG" === e.tagName ? this._createImg(i, e) : this._createImg(i), this._setIconStyles(n, t), n
                }, _setIconStyles: function (t, e) {
                    var i, n = this.options, s = o.point(n[e + "Size"]);
                    i = "shadow" === e ? o.point(n.shadowAnchor || n.iconAnchor) : o.point(n.iconAnchor), !i && s && (i = s.divideBy(2, !0)), t.className = "leaflet-marker-" + e + " " + n.className, i && (t.style.marginLeft = -i.x + "px", t.style.marginTop = -i.y + "px"), s && (t.style.width = s.x + "px", t.style.height = s.y + "px")
                }, _createImg: function (t, i) {
                    return i = i || e.createElement("img"), i.src = t, i
                }, _getIconUrl: function (t) {
                    return o.Browser.retina && this.options[t + "RetinaUrl"] ? this.options[t + "RetinaUrl"] : this.options[t + "Url"]
                }
            }), o.icon = function (t) {
                return new o.Icon(t)
            }, o.Icon.Default = o.Icon.extend({
                options: {iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]}, _getIconUrl: function (t) {
                    var e = t + "Url";
                    if (this.options[e])return this.options[e];
                    o.Browser.retina && "icon" === t && (t += "-2x");
                    var i = o.Icon.Default.imagePath;
                    if (!i)throw new Error("Couldn't autodetect L.Icon.Default.imagePath, set it manually.");
                    return i + "/marker-" + t + ".png"
                }
            }), o.Icon.Default.imagePath = function () {
                var t, i, n, o, s, a = e.getElementsByTagName("script"), r = /[\/^]leaflet[\-\._]?([\w\-\._]*)\.js\??/;
                for (t = 0, i = a.length; i > t; t++)if (n = a[t].src, o = n.match(r))return s = n.split(r)[0], (s ? s + "/" : "") + "images"
            }(), o.Marker = o.Class.extend({
                includes: o.Mixin.Events, options: {icon: new o.Icon.Default, title: "", alt: "", clickable: !0, draggable: !1, keyboard: !0, zIndexOffset: 0, opacity: 1, riseOnHover: !1, riseOffset: 250}, initialize: function (t, e) {
                    o.setOptions(this, e), this._latlng = o.latLng(t)
                }, onAdd: function (t) {
                    this._map = t, t.on("viewreset", this.update, this), this._initIcon(), this.update(), this.fire("add"), t.options.zoomAnimation && t.options.markerZoomAnimation && t.on("zoomanim", this._animateZoom, this)
                }, addTo: function (t) {
                    return t.addLayer(this), this
                }, onRemove: function (t) {
                    this.dragging && this.dragging.disable(), this._removeIcon(), this._removeShadow(), this.fire("remove"), t.off({viewreset: this.update, zoomanim: this._animateZoom}, this), this._map = null
                }, getLatLng: function () {
                    return this._latlng
                }, setLatLng: function (t) {
                    return this._latlng = o.latLng(t), this.update(), this.fire("move", {latlng: this._latlng})
                }, setZIndexOffset: function (t) {
                    return this.options.zIndexOffset = t, this.update(), this
                }, setIcon: function (t) {
                    return this.options.icon = t, this._map && (this._initIcon(), this.update()), this._popup && this.bindPopup(this._popup), this
                }, update: function () {
                    return this._icon && this._setPos(this._map.latLngToLayerPoint(this._latlng).round()), this
                }, _initIcon: function () {
                    var t = this.options, e = this._map, i = e.options.zoomAnimation && e.options.markerZoomAnimation, n = i ? "leaflet-zoom-animated" : "leaflet-zoom-hide", s = t.icon.createIcon(this._icon), a = !1;
                    s !== this._icon && (this._icon && this._removeIcon(), a = !0, t.title && (s.title = t.title), t.alt && (s.alt = t.alt)), o.DomUtil.addClass(s, n), t.keyboard && (s.tabIndex = "0"), this._icon = s, this._initInteraction(), t.riseOnHover && o.DomEvent.on(s, "mouseover", this._bringToFront, this).on(s, "mouseout", this._resetZIndex, this);
                    var r = t.icon.createShadow(this._shadow), h = !1;
                    r !== this._shadow && (this._removeShadow(), h = !0), r && o.DomUtil.addClass(r, n), this._shadow = r, t.opacity < 1 && this._updateOpacity();
                    var l = this._map._panes;
                    a && l.markerPane.appendChild(this._icon), r && h && l.shadowPane.appendChild(this._shadow)
                }, _removeIcon: function () {
                    this.options.riseOnHover && o.DomEvent.off(this._icon, "mouseover", this._bringToFront).off(this._icon, "mouseout", this._resetZIndex), this._map._panes.markerPane.removeChild(this._icon), this._icon = null
                }, _removeShadow: function () {
                    this._shadow && this._map._panes.shadowPane.removeChild(this._shadow), this._shadow = null
                }, _setPos: function (t) {
                    o.DomUtil.setPosition(this._icon, t), this._shadow && o.DomUtil.setPosition(this._shadow, t), this._zIndex = t.y + this.options.zIndexOffset, this._resetZIndex()
                }, _updateZIndex: function (t) {
                    this._icon.style.zIndex = this._zIndex + t
                }, _animateZoom: function (t) {
                    var e = this._map._latLngToNewLayerPoint(this._latlng, t.zoom, t.center).round();
                    this._setPos(e)
                }, _initInteraction: function () {
                    if (this.options.clickable) {
                        var t = this._icon, e = ["dblclick", "mousedown", "mouseover", "mouseout", "contextmenu"];
                        o.DomUtil.addClass(t, "leaflet-clickable"), o.DomEvent.on(t, "click", this._onMouseClick, this), o.DomEvent.on(t, "keypress", this._onKeyPress, this);
                        for (var i = 0; i < e.length; i++)o.DomEvent.on(t, e[i], this._fireMouseEvent, this);
                        o.Handler.MarkerDrag && (this.dragging = new o.Handler.MarkerDrag(this), this.options.draggable && this.dragging.enable())
                    }
                }, _onMouseClick: function (t) {
                    var e = this.dragging && this.dragging.moved();
                    (this.hasEventListeners(t.type) || e) && o.DomEvent.stopPropagation(t), e || (this.dragging && this.dragging._enabled || !this._map.dragging || !this._map.dragging.moved()) && this.fire(t.type, {originalEvent: t, latlng: this._latlng})
                }, _onKeyPress: function (t) {
                    13 === t.keyCode && this.fire("click", {originalEvent: t, latlng: this._latlng})
                }, _fireMouseEvent: function (t) {
                    this.fire(t.type, {originalEvent: t, latlng: this._latlng}), "contextmenu" === t.type && this.hasEventListeners(t.type) && o.DomEvent.preventDefault(t), "mousedown" !== t.type ? o.DomEvent.stopPropagation(t) : o.DomEvent.preventDefault(t)
                }, setOpacity: function (t) {
                    return this.options.opacity = t, this._map && this._updateOpacity(), this
                }, _updateOpacity: function () {
                    o.DomUtil.setOpacity(this._icon, this.options.opacity), this._shadow && o.DomUtil.setOpacity(this._shadow, this.options.opacity)
                }, _bringToFront: function () {
                    this._updateZIndex(this.options.riseOffset)
                }, _resetZIndex: function () {
                    this._updateZIndex(0)
                }
            }), o.marker = function (t, e) {
                return new o.Marker(t, e)
            }, o.DivIcon = o.Icon.extend({
                options: {iconSize: [12, 12], className: "leaflet-div-icon", html: !1}, createIcon: function (t) {
                    var i = t && "DIV" === t.tagName ? t : e.createElement("div"), n = this.options;
                    return n.html !== !1 ? i.innerHTML = n.html : i.innerHTML = "", n.bgPos && (i.style.backgroundPosition = -n.bgPos.x + "px " + -n.bgPos.y + "px"), this._setIconStyles(i, "icon"), i
                }, createShadow: function () {
                    return null
                }
            }), o.divIcon = function (t) {
                return new o.DivIcon(t)
            }, o.Map.mergeOptions({closePopupOnClick: !0}), o.Popup = o.Class.extend({
                includes: o.Mixin.Events, options: {minWidth: 50, maxWidth: 300, autoPan: !0, closeButton: !0, offset: [0, 7], autoPanPadding: [5, 5], keepInView: !1, className: "", zoomAnimation: !0}, initialize: function (t, e) {
                    o.setOptions(this, t), this._source = e, this._animated = o.Browser.any3d && this.options.zoomAnimation, this._isOpen = !1
                }, onAdd: function (t) {
                    this._map = t, this._container || this._initLayout();
                    var e = t.options.fadeAnimation;
                    e && o.DomUtil.setOpacity(this._container, 0), t._panes.popupPane.appendChild(this._container), t.on(this._getEvents(), this), this.update(), e && o.DomUtil.setOpacity(this._container, 1), this.fire("open"), t.fire("popupopen", {popup: this}), this._source && this._source.fire("popupopen", {popup: this})
                }, addTo: function (t) {
                    return t.addLayer(this), this
                }, openOn: function (t) {
                    return t.openPopup(this), this
                }, onRemove: function (t) {
                    t._panes.popupPane.removeChild(this._container), o.Util.falseFn(this._container.offsetWidth), t.off(this._getEvents(), this), t.options.fadeAnimation && o.DomUtil.setOpacity(this._container, 0), this._map = null, this.fire("close"), t.fire("popupclose", {popup: this}), this._source && this._source.fire("popupclose", {popup: this})
                }, getLatLng: function () {
                    return this._latlng
                }, setLatLng: function (t) {
                    return this._latlng = o.latLng(t), this._map && (this._updatePosition(), this._adjustPan()), this
                }, getContent: function () {
                    return this._content
                }, setContent: function (t) {
                    return this._content = t, this.update(), this
                }, update: function () {
                    this._map && (this._container.style.visibility = "hidden", this._updateContent(), this._updateLayout(), this._updatePosition(), this._container.style.visibility = "", this._adjustPan())
                }, _getEvents: function () {
                    var t = {viewreset: this._updatePosition};
                    return this._animated && (t.zoomanim = this._zoomAnimation), ("closeOnClick" in this.options ? this.options.closeOnClick : this._map.options.closePopupOnClick) && (t.preclick = this._close), this.options.keepInView && (t.moveend = this._adjustPan), t
                }, _close: function () {
                    this._map && this._map.closePopup(this)
                }, _initLayout: function () {
                    var t, e = "leaflet-popup", i = e + " " + this.options.className + " leaflet-zoom-" + (this._animated ? "animated" : "hide"), n = this._container = o.DomUtil.create("div", i);
                    this.options.closeButton && (t = this._closeButton = o.DomUtil.create("a", e + "-close-button", n), t.href = "#close", t.innerHTML = "&#215;", o.DomEvent.disableClickPropagation(t), o.DomEvent.on(t, "click", this._onCloseButtonClick, this));
                    var s = this._wrapper = o.DomUtil.create("div", e + "-content-wrapper", n);
                    o.DomEvent.disableClickPropagation(s), this._contentNode = o.DomUtil.create("div", e + "-content", s), o.DomEvent.disableScrollPropagation(this._contentNode), o.DomEvent.on(s, "contextmenu", o.DomEvent.stopPropagation), this._tipContainer = o.DomUtil.create("div", e + "-tip-container", n), this._tip = o.DomUtil.create("div", e + "-tip", this._tipContainer)
                }, _updateContent: function () {
                    if (this._content) {
                        if ("string" == typeof this._content) this._contentNode.innerHTML = this._content; else {
                            for (; this._contentNode.hasChildNodes();)this._contentNode.removeChild(this._contentNode.firstChild);
                            this._contentNode.appendChild(this._content)
                        }
                        this.fire("contentupdate")
                    }
                }, _updateLayout: function () {
                    var t = this._contentNode, e = t.style;
                    e.width = "", e.whiteSpace = "nowrap";
                    var i = t.offsetWidth;
                    i = Math.min(i, this.options.maxWidth), i = Math.max(i, this.options.minWidth), e.width = i + 1 + "px", e.whiteSpace = "", e.height = "";
                    var n = t.offsetHeight, s = this.options.maxHeight, a = "leaflet-popup-scrolled";
                    s && n > s ? (e.height = s + "px", o.DomUtil.addClass(t, a)) : o.DomUtil.removeClass(t, a), this._containerWidth = this._container.offsetWidth
                }, _updatePosition: function () {
                    if (this._map) {
                        var t = this._map.latLngToLayerPoint(this._latlng), e = this._animated, i = o.point(this.options.offset);
                        e && o.DomUtil.setPosition(this._container, t), this._containerBottom = -i.y - (e ? 0 : t.y), this._containerLeft = -Math.round(this._containerWidth / 2) + i.x + (e ? 0 : t.x), this._container.style.bottom = this._containerBottom + "px", this._container.style.left = this._containerLeft + "px"
                    }
                }, _zoomAnimation: function (t) {
                    var e = this._map._latLngToNewLayerPoint(this._latlng, t.zoom, t.center);
                    o.DomUtil.setPosition(this._container, e)
                }, _adjustPan: function () {
                    if (this.options.autoPan) {
                        var t = this._map, e = this._container.offsetHeight, i = this._containerWidth, n = new o.Point(this._containerLeft, -e - this._containerBottom);
                        this._animated && n._add(o.DomUtil.getPosition(this._container));
                        var s = t.layerPointToContainerPoint(n), a = o.point(this.options.autoPanPadding), r = o.point(this.options.autoPanPaddingTopLeft || a), h = o.point(this.options.autoPanPaddingBottomRight || a), l = t.getSize(), u = 0, c = 0;
                        s.x + i + h.x > l.x && (u = s.x + i - l.x + h.x), s.x - u - r.x < 0 && (u = s.x - r.x), s.y + e + h.y > l.y && (c = s.y + e - l.y + h.y), s.y - c - r.y < 0 && (c = s.y - r.y), (u || c) && t.fire("autopanstart").panBy([u, c])
                    }
                }, _onCloseButtonClick: function (t) {
                    this._close(), o.DomEvent.stop(t)
                }
            }), o.popup = function (t, e) {
                return new o.Popup(t, e)
            }, o.Map.include({
                openPopup: function (t, e, i) {
                    if (this.closePopup(), !(t instanceof o.Popup)) {
                        var n = t;
                        t = new o.Popup(i).setLatLng(e).setContent(n)
                    }
                    return t._isOpen = !0, this._popup = t, this.addLayer(t)
                }, closePopup: function (t) {
                    return t && t !== this._popup || (t = this._popup, this._popup = null), t && (this.removeLayer(t), t._isOpen = !1), this
                }
            }), o.Marker.include({
                openPopup: function () {
                    return this._popup && this._map && !this._map.hasLayer(this._popup) && (this._popup.setLatLng(this._latlng), this._map.openPopup(this._popup)), this
                }, closePopup: function () {
                    return this._popup && this._popup._close(), this
                }, togglePopup: function () {
                    return this._popup && (this._popup._isOpen ? this.closePopup() : this.openPopup()), this
                }, bindPopup: function (t, e) {
                    var i = o.point(this.options.icon.options.popupAnchor || [0, 0]);
                    return i = i.add(o.Popup.prototype.options.offset), e && e.offset && (i = i.add(e.offset)), e = o.extend({offset: i}, e), this._popupHandlersAdded || (this.on("click", this.togglePopup, this).on("remove", this.closePopup, this).on("move", this._movePopup, this), this._popupHandlersAdded = !0), t instanceof o.Popup ? (o.setOptions(t, e), this._popup = t, t._source = this) : this._popup = new o.Popup(e, this).setContent(t), this
                }, setPopupContent: function (t) {
                    return this._popup && this._popup.setContent(t), this
                }, unbindPopup: function () {
                    return this._popup && (this._popup = null, this.off("click", this.togglePopup, this).off("remove", this.closePopup, this).off("move", this._movePopup, this), this._popupHandlersAdded = !1), this
                }, getPopup: function () {
                    return this._popup
                }, _movePopup: function (t) {
                    this._popup.setLatLng(t.latlng)
                }
            }), o.LayerGroup = o.Class.extend({
                initialize: function (t) {
                    this._layers = {};
                    var e, i;
                    if (t)for (e = 0, i = t.length; i > e; e++)this.addLayer(t[e])
                }, addLayer: function (t) {
                    var e = this.getLayerId(t);
                    return this._layers[e] = t, this._map && this._map.addLayer(t), this
                }, removeLayer: function (t) {
                    var e = t in this._layers ? t : this.getLayerId(t);
                    return this._map && this._layers[e] && this._map.removeLayer(this._layers[e]), delete this._layers[e], this
                }, hasLayer: function (t) {
                    return t ? t in this._layers || this.getLayerId(t) in this._layers : !1
                }, clearLayers: function () {
                    return this.eachLayer(this.removeLayer, this), this
                }, invoke: function (t) {
                    var e, i, n = Array.prototype.slice.call(arguments, 1);
                    for (e in this._layers)i = this._layers[e], i[t] && i[t].apply(i, n);
                    return this
                }, onAdd: function (t) {
                    this._map = t, this.eachLayer(t.addLayer, t)
                }, onRemove: function (t) {
                    this.eachLayer(t.removeLayer, t), this._map = null
                }, addTo: function (t) {
                    return t.addLayer(this), this
                }, eachLayer: function (t, e) {
                    for (var i in this._layers)t.call(e, this._layers[i]);
                    return this
                }, getLayer: function (t) {
                    return this._layers[t]
                }, getLayers: function () {
                    var t = [];
                    for (var e in this._layers)t.push(this._layers[e]);
                    return t
                }, setZIndex: function (t) {
                    return this.invoke("setZIndex", t)
                }, getLayerId: function (t) {
                    return o.stamp(t)
                }
            }), o.layerGroup = function (t) {
                return new o.LayerGroup(t)
            }, o.FeatureGroup = o.LayerGroup.extend({
                includes: o.Mixin.Events, statics: {EVENTS: "click dblclick mouseover mouseout mousemove contextmenu popupopen popupclose"}, addLayer: function (t) {
                    return this.hasLayer(t) ? this : ("on" in t && t.on(o.FeatureGroup.EVENTS, this._propagateEvent, this), o.LayerGroup.prototype.addLayer.call(this, t), this._popupContent && t.bindPopup && t.bindPopup(this._popupContent, this._popupOptions), this.fire("layeradd", {layer: t}))
                }, removeLayer: function (t) {
                    return this.hasLayer(t) ? (t in this._layers && (t = this._layers[t]), "off" in t && t.off(o.FeatureGroup.EVENTS, this._propagateEvent, this), o.LayerGroup.prototype.removeLayer.call(this, t), this._popupContent && this.invoke("unbindPopup"), this.fire("layerremove", {layer: t})) : this
                }, bindPopup: function (t, e) {
                    return this._popupContent = t, this._popupOptions = e, this.invoke("bindPopup", t, e)
                }, openPopup: function (t) {
                    for (var e in this._layers) {
                        this._layers[e].openPopup(t);
                        break
                    }
                    return this
                }, setStyle: function (t) {
                    return this.invoke("setStyle", t)
                }, bringToFront: function () {
                    return this.invoke("bringToFront")
                }, bringToBack: function () {
                    return this.invoke("bringToBack")
                }, getBounds: function () {
                    var t = new o.LatLngBounds;
                    return this.eachLayer(function (e) {
                        t.extend(e instanceof o.Marker ? e.getLatLng() : e.getBounds())
                    }), t
                }, _propagateEvent: function (t) {
                    t = o.extend({layer: t.target, target: this}, t), this.fire(t.type, t)
                }
            }), o.featureGroup = function (t) {
                return new o.FeatureGroup(t)
            }, o.Path = o.Class.extend({
                includes: [o.Mixin.Events], statics: {
                    CLIP_PADDING: function () {
                        var e = o.Browser.mobile ? 1280 : 2e3, i = (e / Math.max(t.outerWidth, t.outerHeight) - 1) / 2;
                        return Math.max(0, Math.min(.5, i))
                    }()
                }, options: {stroke: !0, color: "#0033ff", dashArray: null, lineCap: null, lineJoin: null, weight: 5, opacity: .5, fill: !1, fillColor: null, fillOpacity: .2, clickable: !0}, initialize: function (t) {
                    o.setOptions(this, t)
                }, onAdd: function (t) {
                    this._map = t, this._container || (this._initElements(), this._initEvents()), this.projectLatlngs(), this._updatePath(), this._container && this._map._pathRoot.appendChild(this._container), this.fire("add"), t.on({viewreset: this.projectLatlngs, moveend: this._updatePath}, this)
                }, addTo: function (t) {
                    return t.addLayer(this), this
                }, onRemove: function (t) {
                    t._pathRoot.removeChild(this._container), this.fire("remove"), this._map = null, o.Browser.vml && (this._container = null, this._stroke = null, this._fill = null), t.off({viewreset: this.projectLatlngs, moveend: this._updatePath}, this)
                }, projectLatlngs: function () {
                }, setStyle: function (t) {
                    return o.setOptions(this, t), this._container && this._updateStyle(), this
                }, redraw: function () {
                    return this._map && (this.projectLatlngs(), this._updatePath()), this
                }
            }), o.Map.include({
                _updatePathViewport: function () {
                    var t = o.Path.CLIP_PADDING, e = this.getSize(), i = o.DomUtil.getPosition(this._mapPane), n = i.multiplyBy(-1)._subtract(e.multiplyBy(t)._round()), s = n.add(e.multiplyBy(1 + 2 * t)._round());
                    this._pathViewport = new o.Bounds(n, s)
                }
            }), o.Path.SVG_NS = "http://www.w3.org/2000/svg", o.Browser.svg = !(!e.createElementNS || !e.createElementNS(o.Path.SVG_NS, "svg").createSVGRect), o.Path = o.Path.extend({
                statics: {SVG: o.Browser.svg}, bringToFront: function () {
                    var t = this._map._pathRoot, e = this._container;
                    return e && t.lastChild !== e && t.appendChild(e), this
                }, bringToBack: function () {
                    var t = this._map._pathRoot, e = this._container, i = t.firstChild;
                    return e && i !== e && t.insertBefore(e, i), this
                }, getPathString: function () {
                }, _createElement: function (t) {
                    return e.createElementNS(o.Path.SVG_NS, t)
                }, _initElements: function () {
                    this._map._initPathRoot(), this._initPath(), this._initStyle()
                }, _initPath: function () {
                    this._container = this._createElement("g"), this._path = this._createElement("path"), this.options.className && o.DomUtil.addClass(this._path, this.options.className), this._container.appendChild(this._path)
                }, _initStyle: function () {
                    this.options.stroke && (this._path.setAttribute("stroke-linejoin", "round"), this._path.setAttribute("stroke-linecap", "round")), this.options.fill && this._path.setAttribute("fill-rule", "evenodd"), this.options.pointerEvents && this._path.setAttribute("pointer-events", this.options.pointerEvents), this.options.clickable || this.options.pointerEvents || this._path.setAttribute("pointer-events", "none"), this._updateStyle()
                }, _updateStyle: function () {
                    this.options.stroke ? (this._path.setAttribute("stroke", this.options.color), this._path.setAttribute("stroke-opacity", this.options.opacity), this._path.setAttribute("stroke-width", this.options.weight), this.options.dashArray ? this._path.setAttribute("stroke-dasharray", this.options.dashArray) : this._path.removeAttribute("stroke-dasharray"), this.options.lineCap && this._path.setAttribute("stroke-linecap", this.options.lineCap), this.options.lineJoin && this._path.setAttribute("stroke-linejoin", this.options.lineJoin)) : this._path.setAttribute("stroke", "none"), this.options.fill ? (this._path.setAttribute("fill", this.options.fillColor || this.options.color), this._path.setAttribute("fill-opacity", this.options.fillOpacity)) : this._path.setAttribute("fill", "none")
                }, _updatePath: function () {
                    var t = this.getPathString();
                    t || (t = "M0 0"), this._path.setAttribute("d", t)
                }, _initEvents: function () {
                    if (this.options.clickable) {
                        (o.Browser.svg || !o.Browser.vml) && o.DomUtil.addClass(this._path, "leaflet-clickable"), o.DomEvent.on(this._container, "click", this._onMouseClick, this);
                        for (var t = ["dblclick", "mousedown", "mouseover", "mouseout", "mousemove", "contextmenu"], e = 0; e < t.length; e++)o.DomEvent.on(this._container, t[e], this._fireMouseEvent, this)
                    }
                }, _onMouseClick: function (t) {
                    this._map.dragging && this._map.dragging.moved() || this._fireMouseEvent(t)
                }, _fireMouseEvent: function (t) {
                    if (this._map && this.hasEventListeners(t.type)) {
                        var e = this._map, i = e.mouseEventToContainerPoint(t), n = e.containerPointToLayerPoint(i), s = e.layerPointToLatLng(n);
                        this.fire(t.type, {latlng: s, layerPoint: n, containerPoint: i, originalEvent: t}), "contextmenu" === t.type && o.DomEvent.preventDefault(t), "mousemove" !== t.type && o.DomEvent.stopPropagation(t)
                    }
                }
            }), o.Map.include({
                _initPathRoot: function () {
                    this._pathRoot || (this._pathRoot = o.Path.prototype._createElement("svg"), this._panes.overlayPane.appendChild(this._pathRoot), this.options.zoomAnimation && o.Browser.any3d ? (o.DomUtil.addClass(this._pathRoot, "leaflet-zoom-animated"),
                            this.on({zoomanim: this._animatePathZoom, zoomend: this._endPathZoom})) : o.DomUtil.addClass(this._pathRoot, "leaflet-zoom-hide"), this.on("moveend", this._updateSvgViewport), this._updateSvgViewport())
                }, _animatePathZoom: function (t) {
                    var e = this.getZoomScale(t.zoom), i = this._getCenterOffset(t.center)._multiplyBy(-e)._add(this._pathViewport.min);
                    this._pathRoot.style[o.DomUtil.TRANSFORM] = o.DomUtil.getTranslateString(i) + " scale(" + e + ") ", this._pathZooming = !0
                }, _endPathZoom: function () {
                    this._pathZooming = !1
                }, _updateSvgViewport: function () {
                    if (!this._pathZooming) {
                        this._updatePathViewport();
                        var t = this._pathViewport, e = t.min, i = t.max, n = i.x - e.x, s = i.y - e.y, a = this._pathRoot, r = this._panes.overlayPane;
                        o.Browser.mobileWebkit && r.removeChild(a), o.DomUtil.setPosition(a, e), a.setAttribute("width", n), a.setAttribute("height", s), a.setAttribute("viewBox", [e.x, e.y, n, s].join(" ")), o.Browser.mobileWebkit && r.appendChild(a)
                    }
                }
            }), o.Path.include({
                bindPopup: function (t, e) {
                    return t instanceof o.Popup ? this._popup = t : ((!this._popup || e) && (this._popup = new o.Popup(e, this)), this._popup.setContent(t)), this._popupHandlersAdded || (this.on("click", this._openPopup, this).on("remove", this.closePopup, this), this._popupHandlersAdded = !0), this
                }, unbindPopup: function () {
                    return this._popup && (this._popup = null, this.off("click", this._openPopup).off("remove", this.closePopup), this._popupHandlersAdded = !1), this
                }, openPopup: function (t) {
                    return this._popup && (t = t || this._latlng || this._latlngs[Math.floor(this._latlngs.length / 2)], this._openPopup({latlng: t})), this
                }, closePopup: function () {
                    return this._popup && this._popup._close(), this
                }, _openPopup: function (t) {
                    this._popup.setLatLng(t.latlng), this._map.openPopup(this._popup)
                }
            }), o.Browser.vml = !o.Browser.svg && function () {
                    try {
                        var t = e.createElement("div");
                        t.innerHTML = '<v:shape adj="1"/>';
                        var i = t.firstChild;
                        return i.style.behavior = "url(#default#VML)", i && "object" == typeof i.adj
                    } catch (n) {
                        return !1
                    }
                }(), o.Path = o.Browser.svg || !o.Browser.vml ? o.Path : o.Path.extend({
                    statics: {VML: !0, CLIP_PADDING: .02}, _createElement: function () {
                        try {
                            return e.namespaces.add("lvml", "urn:schemas-microsoft-com:vml"), function (t) {
                                return e.createElement("<lvml:" + t + ' class="lvml">')
                            }
                        } catch (t) {
                            return function (t) {
                                return e.createElement("<" + t + ' xmlns="urn:schemas-microsoft.com:vml" class="lvml">')
                            }
                        }
                    }(), _initPath: function () {
                        var t = this._container = this._createElement("shape");
                        o.DomUtil.addClass(t, "leaflet-vml-shape" + (this.options.className ? " " + this.options.className : "")), this.options.clickable && o.DomUtil.addClass(t, "leaflet-clickable"), t.coordsize = "1 1", this._path = this._createElement("path"), t.appendChild(this._path), this._map._pathRoot.appendChild(t)
                    }, _initStyle: function () {
                        this._updateStyle()
                    }, _updateStyle: function () {
                        var t = this._stroke, e = this._fill, i = this.options, n = this._container;
                        n.stroked = i.stroke, n.filled = i.fill, i.stroke ? (t || (t = this._stroke = this._createElement("stroke"), t.endcap = "round", n.appendChild(t)), t.weight = i.weight + "px", t.color = i.color, t.opacity = i.opacity, i.dashArray ? t.dashStyle = o.Util.isArray(i.dashArray) ? i.dashArray.join(" ") : i.dashArray.replace(/( *, *)/g, " ") : t.dashStyle = "", i.lineCap && (t.endcap = i.lineCap.replace("butt", "flat")), i.lineJoin && (t.joinstyle = i.lineJoin)) : t && (n.removeChild(t), this._stroke = null), i.fill ? (e || (e = this._fill = this._createElement("fill"), n.appendChild(e)), e.color = i.fillColor || i.color, e.opacity = i.fillOpacity) : e && (n.removeChild(e), this._fill = null)
                    }, _updatePath: function () {
                        var t = this._container.style;
                        t.display = "none", this._path.v = this.getPathString() + " ", t.display = ""
                    }
                }), o.Map.include(o.Browser.svg || !o.Browser.vml ? {} : {
                    _initPathRoot: function () {
                        if (!this._pathRoot) {
                            var t = this._pathRoot = e.createElement("div");
                            t.className = "leaflet-vml-container", this._panes.overlayPane.appendChild(t), this.on("moveend", this._updatePathViewport), this._updatePathViewport()
                        }
                    }
                }), o.Browser.canvas = function () {
                return !!e.createElement("canvas").getContext
            }(), o.Path = o.Path.SVG && !t.L_PREFER_CANVAS || !o.Browser.canvas ? o.Path : o.Path.extend({
                    statics: {CANVAS: !0, SVG: !1}, redraw: function () {
                        return this._map && (this.projectLatlngs(), this._requestUpdate()), this
                    }, setStyle: function (t) {
                        return o.setOptions(this, t), this._map && (this._updateStyle(), this._requestUpdate()), this
                    }, onRemove: function (t) {
                        t.off("viewreset", this.projectLatlngs, this).off("moveend", this._updatePath, this), this.options.clickable && (this._map.off("click", this._onClick, this), this._map.off("mousemove", this._onMouseMove, this)), this._requestUpdate(), this.fire("remove"), this._map = null
                    }, _requestUpdate: function () {
                        this._map && !o.Path._updateRequest && (o.Path._updateRequest = o.Util.requestAnimFrame(this._fireMapMoveEnd, this._map))
                    }, _fireMapMoveEnd: function () {
                        o.Path._updateRequest = null, this.fire("moveend")
                    }, _initElements: function () {
                        this._map._initPathRoot(), this._ctx = this._map._canvasCtx
                    }, _updateStyle: function () {
                        var t = this.options;
                        t.stroke && (this._ctx.lineWidth = t.weight, this._ctx.strokeStyle = t.color), t.fill && (this._ctx.fillStyle = t.fillColor || t.color), t.lineCap && (this._ctx.lineCap = t.lineCap), t.lineJoin && (this._ctx.lineJoin = t.lineJoin)
                    }, _drawPath: function () {
                        var t, e, i, n, s, a;
                        for (this._ctx.beginPath(), t = 0, i = this._parts.length; i > t; t++) {
                            for (e = 0, n = this._parts[t].length; n > e; e++)s = this._parts[t][e], a = (0 === e ? "move" : "line") + "To", this._ctx[a](s.x, s.y);
                            this instanceof o.Polygon && this._ctx.closePath()
                        }
                    }, _checkIfEmpty: function () {
                        return !this._parts.length
                    }, _updatePath: function () {
                        if (!this._checkIfEmpty()) {
                            var t = this._ctx, e = this.options;
                            this._drawPath(), t.save(), this._updateStyle(), e.fill && (t.globalAlpha = e.fillOpacity, t.fill(e.fillRule || "evenodd")), e.stroke && (t.globalAlpha = e.opacity, t.stroke()), t.restore()
                        }
                    }, _initEvents: function () {
                        this.options.clickable && (this._map.on("mousemove", this._onMouseMove, this), this._map.on("click dblclick contextmenu", this._fireMouseEvent, this))
                    }, _fireMouseEvent: function (t) {
                        this._containsPoint(t.layerPoint) && this.fire(t.type, t)
                    }, _onMouseMove: function (t) {
                        this._map && !this._map._animatingZoom && (this._containsPoint(t.layerPoint) ? (this._ctx.canvas.style.cursor = "pointer", this._mouseInside = !0, this.fire("mouseover", t)) : this._mouseInside && (this._ctx.canvas.style.cursor = "", this._mouseInside = !1, this.fire("mouseout", t)))
                    }
                }), o.Map.include(o.Path.SVG && !t.L_PREFER_CANVAS || !o.Browser.canvas ? {} : {
                    _initPathRoot: function () {
                        var t, i = this._pathRoot;
                        i || (i = this._pathRoot = e.createElement("canvas"), i.style.position = "absolute", t = this._canvasCtx = i.getContext("2d"), t.lineCap = "round", t.lineJoin = "round", this._panes.overlayPane.appendChild(i), this.options.zoomAnimation && (this._pathRoot.className = "leaflet-zoom-animated", this.on("zoomanim", this._animatePathZoom), this.on("zoomend", this._endPathZoom)), this.on("moveend", this._updateCanvasViewport), this._updateCanvasViewport())
                    }, _updateCanvasViewport: function () {
                        if (!this._pathZooming) {
                            this._updatePathViewport();
                            var t = this._pathViewport, e = t.min, i = t.max.subtract(e), n = this._pathRoot;
                            o.DomUtil.setPosition(n, e), n.width = i.x, n.height = i.y, n.getContext("2d").translate(-e.x, -e.y)
                        }
                    }
                }), o.LineUtil = {
                simplify: function (t, e) {
                    if (!e || !t.length)return t.slice();
                    var i = e * e;
                    return t = this._reducePoints(t, i), t = this._simplifyDP(t, i)
                }, pointToSegmentDistance: function (t, e, i) {
                    return Math.sqrt(this._sqClosestPointOnSegment(t, e, i, !0))
                }, closestPointOnSegment: function (t, e, i) {
                    return this._sqClosestPointOnSegment(t, e, i)
                }, _simplifyDP: function (t, e) {
                    var n = t.length, o = typeof Uint8Array != i + "" ? Uint8Array : Array, s = new o(n);
                    s[0] = s[n - 1] = 1, this._simplifyDPStep(t, s, e, 0, n - 1);
                    var a, r = [];
                    for (a = 0; n > a; a++)s[a] && r.push(t[a]);
                    return r
                }, _simplifyDPStep: function (t, e, i, n, o) {
                    var s, a, r, h = 0;
                    for (a = n + 1; o - 1 >= a; a++)r = this._sqClosestPointOnSegment(t[a], t[n], t[o], !0), r > h && (s = a, h = r);
                    h > i && (e[s] = 1, this._simplifyDPStep(t, e, i, n, s), this._simplifyDPStep(t, e, i, s, o))
                }, _reducePoints: function (t, e) {
                    for (var i = [t[0]], n = 1, o = 0, s = t.length; s > n; n++)this._sqDist(t[n], t[o]) > e && (i.push(t[n]), o = n);
                    return s - 1 > o && i.push(t[s - 1]), i
                }, clipSegment: function (t, e, i, n) {
                    var o, s, a, r = n ? this._lastCode : this._getBitCode(t, i), h = this._getBitCode(e, i);
                    for (this._lastCode = h; ;) {
                        if (!(r | h))return [t, e];
                        if (r & h)return !1;
                        o = r || h, s = this._getEdgeIntersection(t, e, o, i), a = this._getBitCode(s, i), o === r ? (t = s, r = a) : (e = s, h = a)
                    }
                }, _getEdgeIntersection: function (t, e, i, n) {
                    var s = e.x - t.x, a = e.y - t.y, r = n.min, h = n.max;
                    return 8 & i ? new o.Point(t.x + s * (h.y - t.y) / a, h.y) : 4 & i ? new o.Point(t.x + s * (r.y - t.y) / a, r.y) : 2 & i ? new o.Point(h.x, t.y + a * (h.x - t.x) / s) : 1 & i ? new o.Point(r.x, t.y + a * (r.x - t.x) / s) : void 0
                }, _getBitCode: function (t, e) {
                    var i = 0;
                    return t.x < e.min.x ? i |= 1 : t.x > e.max.x && (i |= 2), t.y < e.min.y ? i |= 4 : t.y > e.max.y && (i |= 8), i
                }, _sqDist: function (t, e) {
                    var i = e.x - t.x, n = e.y - t.y;
                    return i * i + n * n
                }, _sqClosestPointOnSegment: function (t, e, i, n) {
                    var s, a = e.x, r = e.y, h = i.x - a, l = i.y - r, u = h * h + l * l;
                    return u > 0 && (s = ((t.x - a) * h + (t.y - r) * l) / u, s > 1 ? (a = i.x, r = i.y) : s > 0 && (a += h * s, r += l * s)), h = t.x - a, l = t.y - r, n ? h * h + l * l : new o.Point(a, r)
                }
            }, o.Polyline = o.Path.extend({
                initialize: function (t, e) {
                    o.Path.prototype.initialize.call(this, e), this._latlngs = this._convertLatLngs(t)
                }, options: {smoothFactor: 1, noClip: !1}, projectLatlngs: function () {
                    this._originalPoints = [];
                    for (var t = 0, e = this._latlngs.length; e > t; t++)this._originalPoints[t] = this._map.latLngToLayerPoint(this._latlngs[t])
                }, getPathString: function () {
                    for (var t = 0, e = this._parts.length, i = ""; e > t; t++)i += this._getPathPartStr(this._parts[t]);
                    return i
                }, getLatLngs: function () {
                    return this._latlngs
                }, setLatLngs: function (t) {
                    return this._latlngs = this._convertLatLngs(t), this.redraw()
                }, addLatLng: function (t) {
                    return this._latlngs.push(o.latLng(t)), this.redraw()
                }, spliceLatLngs: function () {
                    var t = [].splice.apply(this._latlngs, arguments);
                    return this._convertLatLngs(this._latlngs, !0), this.redraw(), t
                }, closestLayerPoint: function (t) {
                    for (var e, i, n = 1 / 0, s = this._parts, a = null, r = 0, h = s.length; h > r; r++)for (var l = s[r], u = 1, c = l.length; c > u; u++) {
                        e = l[u - 1], i = l[u];
                        var d = o.LineUtil._sqClosestPointOnSegment(t, e, i, !0);
                        n > d && (n = d, a = o.LineUtil._sqClosestPointOnSegment(t, e, i))
                    }
                    return a && (a.distance = Math.sqrt(n)), a
                }, getBounds: function () {
                    return new o.LatLngBounds(this.getLatLngs())
                }, _convertLatLngs: function (t, e) {
                    var i, n, s = e ? t : [];
                    for (i = 0, n = t.length; n > i; i++) {
                        if (o.Util.isArray(t[i]) && "number" != typeof t[i][0])return;
                        s[i] = o.latLng(t[i])
                    }
                    return s
                }, _initEvents: function () {
                    o.Path.prototype._initEvents.call(this)
                }, _getPathPartStr: function (t) {
                    for (var e, i = o.Path.VML, n = 0, s = t.length, a = ""; s > n; n++)e = t[n], i && e._round(), a += (n ? "L" : "M") + e.x + " " + e.y;
                    return a
                }, _clipPoints: function () {
                    var t, e, i, n = this._originalPoints, s = n.length;
                    if (this.options.noClip)return void(this._parts = [n]);
                    this._parts = [];
                    var a = this._parts, r = this._map._pathViewport, h = o.LineUtil;
                    for (t = 0, e = 0; s - 1 > t; t++)i = h.clipSegment(n[t], n[t + 1], r, t), i && (a[e] = a[e] || [], a[e].push(i[0]), (i[1] !== n[t + 1] || t === s - 2) && (a[e].push(i[1]), e++))
                }, _simplifyPoints: function () {
                    for (var t = this._parts, e = o.LineUtil, i = 0, n = t.length; n > i; i++)t[i] = e.simplify(t[i], this.options.smoothFactor)
                }, _updatePath: function () {
                    this._map && (this._clipPoints(), this._simplifyPoints(), o.Path.prototype._updatePath.call(this))
                }
            }), o.polyline = function (t, e) {
                return new o.Polyline(t, e)
            }, o.PolyUtil = {}, o.PolyUtil.clipPolygon = function (t, e) {
                var i, n, s, a, r, h, l, u, c, d = [1, 4, 2, 8], p = o.LineUtil;
                for (n = 0, l = t.length; l > n; n++)t[n]._code = p._getBitCode(t[n], e);
                for (a = 0; 4 > a; a++) {
                    for (u = d[a], i = [], n = 0, l = t.length, s = l - 1; l > n; s = n++)r = t[n], h = t[s], r._code & u ? h._code & u || (c = p._getEdgeIntersection(h, r, u, e), c._code = p._getBitCode(c, e), i.push(c)) : (h._code & u && (c = p._getEdgeIntersection(h, r, u, e), c._code = p._getBitCode(c, e), i.push(c)), i.push(r));
                    t = i
                }
                return t
            }, o.Polygon = o.Polyline.extend({
                options: {fill: !0}, initialize: function (t, e) {
                    o.Polyline.prototype.initialize.call(this, t, e), this._initWithHoles(t)
                }, _initWithHoles: function (t) {
                    var e, i, n;
                    if (t && o.Util.isArray(t[0]) && "number" != typeof t[0][0])for (this._latlngs = this._convertLatLngs(t[0]), this._holes = t.slice(1), e = 0, i = this._holes.length; i > e; e++)n = this._holes[e] = this._convertLatLngs(this._holes[e]), n[0].equals(n[n.length - 1]) && n.pop();
                    t = this._latlngs, t.length >= 2 && t[0].equals(t[t.length - 1]) && t.pop()
                }, projectLatlngs: function () {
                    if (o.Polyline.prototype.projectLatlngs.call(this), this._holePoints = [], this._holes) {
                        var t, e, i, n;
                        for (t = 0, i = this._holes.length; i > t; t++)for (this._holePoints[t] = [], e = 0, n = this._holes[t].length; n > e; e++)this._holePoints[t][e] = this._map.latLngToLayerPoint(this._holes[t][e])
                    }
                }, setLatLngs: function (t) {
                    return t && o.Util.isArray(t[0]) && "number" != typeof t[0][0] ? (this._initWithHoles(t), this.redraw()) : o.Polyline.prototype.setLatLngs.call(this, t)
                }, _clipPoints: function () {
                    var t = this._originalPoints, e = [];
                    if (this._parts = [t].concat(this._holePoints), !this.options.noClip) {
                        for (var i = 0, n = this._parts.length; n > i; i++) {
                            var s = o.PolyUtil.clipPolygon(this._parts[i], this._map._pathViewport);
                            s.length && e.push(s)
                        }
                        this._parts = e
                    }
                }, _getPathPartStr: function (t) {
                    var e = o.Polyline.prototype._getPathPartStr.call(this, t);
                    return e + (o.Browser.svg ? "z" : "x")
                }
            }), o.polygon = function (t, e) {
                return new o.Polygon(t, e)
            }, function () {
                function t(t) {
                    return o.FeatureGroup.extend({
                        initialize: function (t, e) {
                            this._layers = {}, this._options = e, this.setLatLngs(t)
                        }, setLatLngs: function (e) {
                            var i = 0, n = e.length;
                            for (this.eachLayer(function (t) {
                                n > i ? t.setLatLngs(e[i++]) : this.removeLayer(t)
                            }, this); n > i;)this.addLayer(new t(e[i++], this._options));
                            return this
                        }, getLatLngs: function () {
                            var t = [];
                            return this.eachLayer(function (e) {
                                t.push(e.getLatLngs())
                            }), t
                        }
                    })
                }

                o.MultiPolyline = t(o.Polyline), o.MultiPolygon = t(o.Polygon), o.multiPolyline = function (t, e) {
                    return new o.MultiPolyline(t, e)
                }, o.multiPolygon = function (t, e) {
                    return new o.MultiPolygon(t, e)
                }
            }(), o.Rectangle = o.Polygon.extend({
                initialize: function (t, e) {
                    o.Polygon.prototype.initialize.call(this, this._boundsToLatLngs(t), e)
                }, setBounds: function (t) {
                    this.setLatLngs(this._boundsToLatLngs(t))
                }, _boundsToLatLngs: function (t) {
                    return t = o.latLngBounds(t), [t.getSouthWest(), t.getNorthWest(), t.getNorthEast(), t.getSouthEast()]
                }
            }), o.rectangle = function (t, e) {
                return new o.Rectangle(t, e)
            }, o.Circle = o.Path.extend({
                initialize: function (t, e, i) {
                    o.Path.prototype.initialize.call(this, i), this._latlng = o.latLng(t), this._mRadius = e
                }, options: {fill: !0}, setLatLng: function (t) {
                    return this._latlng = o.latLng(t), this.redraw()
                }, setRadius: function (t) {
                    return this._mRadius = t, this.redraw()
                }, projectLatlngs: function () {
                    var t = this._getLngRadius(), e = this._latlng, i = this._map.latLngToLayerPoint([e.lat, e.lng - t]);
                    this._point = this._map.latLngToLayerPoint(e), this._radius = Math.max(this._point.x - i.x, 1)
                }, getBounds: function () {
                    var t = this._getLngRadius(), e = this._mRadius / 40075017 * 360, i = this._latlng;
                    return new o.LatLngBounds([i.lat - e, i.lng - t], [i.lat + e, i.lng + t])
                }, getLatLng: function () {
                    return this._latlng
                }, getPathString: function () {
                    var t = this._point, e = this._radius;
                    return this._checkIfEmpty() ? "" : o.Browser.svg ? "M" + t.x + "," + (t.y - e) + "A" + e + "," + e + ",0,1,1," + (t.x - .1) + "," + (t.y - e) + " z" : (t._round(), e = Math.round(e), "AL " + t.x + "," + t.y + " " + e + "," + e + " 0,23592600")
                }, getRadius: function () {
                    return this._mRadius
                }, _getLatRadius: function () {
                    return this._mRadius / 40075017 * 360
                }, _getLngRadius: function () {
                    return this._getLatRadius() / Math.cos(o.LatLng.DEG_TO_RAD * this._latlng.lat)
                }, _checkIfEmpty: function () {
                    if (!this._map)return !1;
                    var t = this._map._pathViewport, e = this._radius, i = this._point;
                    return i.x - e > t.max.x || i.y - e > t.max.y || i.x + e < t.min.x || i.y + e < t.min.y
                }
            }), o.circle = function (t, e, i) {
                return new o.Circle(t, e, i)
            }, o.CircleMarker = o.Circle.extend({
                options: {radius: 10, weight: 2}, initialize: function (t, e) {
                    o.Circle.prototype.initialize.call(this, t, null, e), this._radius = this.options.radius
                }, projectLatlngs: function () {
                    this._point = this._map.latLngToLayerPoint(this._latlng)
                }, _updateStyle: function () {
                    o.Circle.prototype._updateStyle.call(this), this.setRadius(this.options.radius)
                }, setLatLng: function (t) {
                    return o.Circle.prototype.setLatLng.call(this, t), this._popup && this._popup._isOpen && this._popup.setLatLng(t), this
                }, setRadius: function (t) {
                    return this.options.radius = this._radius = t, this.redraw()
                }, getRadius: function () {
                    return this._radius
                }
            }), o.circleMarker = function (t, e) {
                return new o.CircleMarker(t, e)
            }, o.Polyline.include(o.Path.CANVAS ? {
                    _containsPoint: function (t, e) {
                        var i, n, s, a, r, h, l, u = this.options.weight / 2;
                        for (o.Browser.touch && (u += 10), i = 0, a = this._parts.length; a > i; i++)for (l = this._parts[i], n = 0, r = l.length, s = r - 1; r > n; s = n++)if ((e || 0 !== n) && (h = o.LineUtil.pointToSegmentDistance(t, l[s], l[n]), u >= h))return !0;
                        return !1
                    }
                } : {}), o.Polygon.include(o.Path.CANVAS ? {
                    _containsPoint: function (t) {
                        var e, i, n, s, a, r, h, l, u = !1;
                        if (o.Polyline.prototype._containsPoint.call(this, t, !0))return !0;
                        for (s = 0, h = this._parts.length; h > s; s++)for (e = this._parts[s], a = 0, l = e.length, r = l - 1; l > a; r = a++)i = e[a], n = e[r], i.y > t.y != n.y > t.y && t.x < (n.x - i.x) * (t.y - i.y) / (n.y - i.y) + i.x && (u = !u);
                        return u
                    }
                } : {}), o.Circle.include(o.Path.CANVAS ? {
                    _drawPath: function () {
                        var t = this._point;
                        this._ctx.beginPath(), this._ctx.arc(t.x, t.y, this._radius, 0, 2 * Math.PI, !1)
                    }, _containsPoint: function (t) {
                        var e = this._point, i = this.options.stroke ? this.options.weight / 2 : 0;
                        return t.distanceTo(e) <= this._radius + i
                    }
                } : {}), o.CircleMarker.include(o.Path.CANVAS ? {
                    _updateStyle: function () {
                        o.Path.prototype._updateStyle.call(this)
                    }
                } : {}), o.GeoJSON = o.FeatureGroup.extend({
                initialize: function (t, e) {
                    o.setOptions(this, e), this._layers = {}, t && this.addData(t)
                }, addData: function (t) {
                    var e, i, n, s = o.Util.isArray(t) ? t : t.features;
                    if (s) {
                        for (e = 0, i = s.length; i > e; e++)n = s[e], (n.geometries || n.geometry || n.features || n.coordinates) && this.addData(s[e]);
                        return this
                    }
                    var a = this.options;
                    if (!a.filter || a.filter(t)) {
                        var r = o.GeoJSON.geometryToLayer(t, a.pointToLayer, a.coordsToLatLng, a);
                        return r.feature = o.GeoJSON.asFeature(t), r.defaultOptions = r.options, this.resetStyle(r), a.onEachFeature && a.onEachFeature(t, r), this.addLayer(r)
                    }
                }, resetStyle: function (t) {
                    var e = this.options.style;
                    e && (o.Util.extend(t.options, t.defaultOptions), this._setLayerStyle(t, e))
                }, setStyle: function (t) {
                    this.eachLayer(function (e) {
                        this._setLayerStyle(e, t)
                    }, this)
                }, _setLayerStyle: function (t, e) {
                    "function" == typeof e && (e = e(t.feature)), t.setStyle && t.setStyle(e)
                }
            }), o.extend(o.GeoJSON, {
                geometryToLayer: function (t, e, i, n) {
                    var s, a, r, h, l = "Feature" === t.type ? t.geometry : t, u = l.coordinates, c = [];
                    switch (i = i || this.coordsToLatLng, l.type) {
                        case"Point":
                            return s = i(u), e ? e(t, s) : new o.Marker(s);
                        case"MultiPoint":
                            for (r = 0, h = u.length; h > r; r++)s = i(u[r]), c.push(e ? e(t, s) : new o.Marker(s));
                            return new o.FeatureGroup(c);
                        case"LineString":
                            return a = this.coordsToLatLngs(u, 0, i), new o.Polyline(a, n);
                        case"Polygon":
                            if (2 === u.length && !u[1].length)throw new Error("Invalid GeoJSON object.");
                            return a = this.coordsToLatLngs(u, 1, i), new o.Polygon(a, n);
                        case"MultiLineString":
                            return a = this.coordsToLatLngs(u, 1, i), new o.MultiPolyline(a, n);
                        case"MultiPolygon":
                            return a = this.coordsToLatLngs(u, 2, i), new o.MultiPolygon(a, n);
                        case"GeometryCollection":
                            for (r = 0, h = l.geometries.length; h > r; r++)c.push(this.geometryToLayer({geometry: l.geometries[r], type: "Feature", properties: t.properties}, e, i, n));
                            return new o.FeatureGroup(c);
                        default:
                            throw new Error("Invalid GeoJSON object.")
                    }
                }, coordsToLatLng: function (t) {
                    return new o.LatLng(t[1], t[0], t[2])
                }, coordsToLatLngs: function (t, e, i) {
                    var n, o, s, a = [];
                    for (o = 0, s = t.length; s > o; o++)n = e ? this.coordsToLatLngs(t[o], e - 1, i) : (i || this.coordsToLatLng)(t[o]), a.push(n);
                    return a
                }, latLngToCoords: function (t) {
                    var e = [t.lng, t.lat];
                    return t.alt !== i && e.push(t.alt), e
                }, latLngsToCoords: function (t) {
                    for (var e = [], i = 0, n = t.length; n > i; i++)e.push(o.GeoJSON.latLngToCoords(t[i]));
                    return e
                }, getFeature: function (t, e) {
                    return t.feature ? o.extend({}, t.feature, {geometry: e}) : o.GeoJSON.asFeature(e)
                }, asFeature: function (t) {
                    return "Feature" === t.type ? t : {type: "Feature", properties: {}, geometry: t}
                }
            });
            var a = {
                toGeoJSON: function () {
                    return o.GeoJSON.getFeature(this, {type: "Point", coordinates: o.GeoJSON.latLngToCoords(this.getLatLng())})
                }
            };
            o.Marker.include(a), o.Circle.include(a), o.CircleMarker.include(a), o.Polyline.include({
                toGeoJSON: function () {
                    return o.GeoJSON.getFeature(this, {type: "LineString", coordinates: o.GeoJSON.latLngsToCoords(this.getLatLngs())})
                }
            }), o.Polygon.include({
                toGeoJSON: function () {
                    var t, e, i, n = [o.GeoJSON.latLngsToCoords(this.getLatLngs())];
                    if (n[0].push(n[0][0]), this._holes)for (t = 0, e = this._holes.length; e > t; t++)i = o.GeoJSON.latLngsToCoords(this._holes[t]), i.push(i[0]), n.push(i);
                    return o.GeoJSON.getFeature(this, {type: "Polygon", coordinates: n})
                }
            }), function () {
                function t(t) {
                    return function () {
                        var e = [];
                        return this.eachLayer(function (t) {
                            e.push(t.toGeoJSON().geometry.coordinates)
                        }), o.GeoJSON.getFeature(this, {type: t, coordinates: e})
                    }
                }

                o.MultiPolyline.include({toGeoJSON: t("MultiLineString")}), o.MultiPolygon.include({toGeoJSON: t("MultiPolygon")}), o.LayerGroup.include({
                    toGeoJSON: function () {
                        var e, i = this.feature && this.feature.geometry, n = [];
                        if (i && "MultiPoint" === i.type)return t("MultiPoint").call(this);
                        var s = i && "GeometryCollection" === i.type;
                        return this.eachLayer(function (t) {
                            t.toGeoJSON && (e = t.toGeoJSON(), n.push(s ? e.geometry : o.GeoJSON.asFeature(e)))
                        }), s ? o.GeoJSON.getFeature(this, {geometries: n, type: "GeometryCollection"}) : {type: "FeatureCollection", features: n}
                    }
                })
            }(), o.geoJson = function (t, e) {
                return new o.GeoJSON(t, e)
            }, o.DomEvent = {
                addListener: function (t, e, i, n) {
                    var s, a, r, h = o.stamp(i), l = "_leaflet_" + e + h;
                    return t[l] ? this : (s = function (e) {
                            return i.call(n || t, e || o.DomEvent._getEvent())
                        }, o.Browser.pointer && 0 === e.indexOf("touch") ? this.addPointerListener(t, e, s, h) : (o.Browser.touch && "dblclick" === e && this.addDoubleTapListener && this.addDoubleTapListener(t, s, h), "addEventListener" in t ? "mousewheel" === e ? (t.addEventListener("DOMMouseScroll", s, !1), t.addEventListener(e, s, !1)) : "mouseenter" === e || "mouseleave" === e ? (a = s, r = "mouseenter" === e ? "mouseover" : "mouseout", s = function (e) {
                                            return o.DomEvent._checkMouse(t, e) ? a(e) : void 0
                                        }, t.addEventListener(r, s, !1)) : "click" === e && o.Browser.android ? (a = s, s = function (t) {
                                                return o.DomEvent._filterClick(t, a)
                                            }, t.addEventListener(e, s, !1)) : t.addEventListener(e, s, !1) : "attachEvent" in t && t.attachEvent("on" + e, s), t[l] = s, this))
                }, removeListener: function (t, e, i) {
                    var n = o.stamp(i), s = "_leaflet_" + e + n, a = t[s];
                    return a ? (o.Browser.pointer && 0 === e.indexOf("touch") ? this.removePointerListener(t, e, n) : o.Browser.touch && "dblclick" === e && this.removeDoubleTapListener ? this.removeDoubleTapListener(t, n) : "removeEventListener" in t ? "mousewheel" === e ? (t.removeEventListener("DOMMouseScroll", a, !1), t.removeEventListener(e, a, !1)) : "mouseenter" === e || "mouseleave" === e ? t.removeEventListener("mouseenter" === e ? "mouseover" : "mouseout", a, !1) : t.removeEventListener(e, a, !1) : "detachEvent" in t && t.detachEvent("on" + e, a), t[s] = null, this) : this
                }, stopPropagation: function (t) {
                    return t.stopPropagation ? t.stopPropagation() : t.cancelBubble = !0, o.DomEvent._skipped(t), this
                }, disableScrollPropagation: function (t) {
                    var e = o.DomEvent.stopPropagation;
                    return o.DomEvent.on(t, "mousewheel", e).on(t, "MozMousePixelScroll", e)
                }, disableClickPropagation: function (t) {
                    for (var e = o.DomEvent.stopPropagation, i = o.Draggable.START.length - 1; i >= 0; i--)o.DomEvent.on(t, o.Draggable.START[i], e);
                    return o.DomEvent.on(t, "click", o.DomEvent._fakeStop).on(t, "dblclick", e)
                }, preventDefault: function (t) {
                    return t.preventDefault ? t.preventDefault() : t.returnValue = !1, this
                }, stop: function (t) {
                    return o.DomEvent.preventDefault(t).stopPropagation(t)
                }, getMousePosition: function (t, e) {
                    if (!e)return new o.Point(t.clientX, t.clientY);
                    var i = e.getBoundingClientRect();
                    return new o.Point(t.clientX - i.left - e.clientLeft, t.clientY - i.top - e.clientTop)
                }, getWheelDelta: function (t) {
                    var e = 0;
                    return t.wheelDelta && (e = t.wheelDelta / 120), t.detail && (e = -t.detail / 3), e
                }, _skipEvents: {}, _fakeStop: function (t) {
                    o.DomEvent._skipEvents[t.type] = !0
                }, _skipped: function (t) {
                    var e = this._skipEvents[t.type];
                    return this._skipEvents[t.type] = !1, e
                }, _checkMouse: function (t, e) {
                    var i = e.relatedTarget;
                    if (!i)return !0;
                    try {
                        for (; i && i !== t;)i = i.parentNode
                    } catch (n) {
                        return !1
                    }
                    return i !== t
                }, _getEvent: function () {
                    var e = t.event;
                    if (!e)for (var i = arguments.callee.caller; i && (e = i.arguments[0], !e || t.Event !== e.constructor);)i = i.caller;
                    return e
                }, _filterClick: function (t, e) {
                    var i = t.timeStamp || t.originalEvent.timeStamp, n = o.DomEvent._lastClick && i - o.DomEvent._lastClick;
                    return n && n > 100 && 500 > n || t.target._simulatedClick && !t._simulated ? void o.DomEvent.stop(t) : (o.DomEvent._lastClick = i, e(t))
                }
            }, o.DomEvent.on = o.DomEvent.addListener, o.DomEvent.off = o.DomEvent.removeListener, o.Draggable = o.Class.extend({
                includes: o.Mixin.Events, statics: {START: o.Browser.touch ? ["touchstart", "mousedown"] : ["mousedown"], END: {mousedown: "mouseup", touchstart: "touchend", pointerdown: "touchend", MSPointerDown: "touchend"}, MOVE: {mousedown: "mousemove", touchstart: "touchmove", pointerdown: "touchmove", MSPointerDown: "touchmove"}}, initialize: function (t, e) {
                    this._element = t, this._dragStartTarget = e || t
                }, enable: function () {
                    if (!this._enabled) {
                        for (var t = o.Draggable.START.length - 1; t >= 0; t--)o.DomEvent.on(this._dragStartTarget, o.Draggable.START[t], this._onDown, this);
                        this._enabled = !0
                    }
                }, disable: function () {
                    if (this._enabled) {
                        for (var t = o.Draggable.START.length - 1; t >= 0; t--)o.DomEvent.off(this._dragStartTarget, o.Draggable.START[t], this._onDown, this);
                        this._enabled = !1, this._moved = !1
                    }
                }, _onDown: function (t) {
                    if (this._moved = !1, !t.shiftKey && (1 === t.which || 1 === t.button || t.touches) && (o.DomEvent.stopPropagation(t), !o.Draggable._disabled && (o.DomUtil.disableImageDrag(), o.DomUtil.disableTextSelection(), !this._moving))) {
                        var i = t.touches ? t.touches[0] : t;
                        this._startPoint = new o.Point(i.clientX, i.clientY), this._startPos = this._newPos = o.DomUtil.getPosition(this._element), o.DomEvent.on(e, o.Draggable.MOVE[t.type], this._onMove, this).on(e, o.Draggable.END[t.type], this._onUp, this)
                    }
                }, _onMove: function (t) {
                    if (t.touches && t.touches.length > 1)return void(this._moved = !0);
                    var i = t.touches && 1 === t.touches.length ? t.touches[0] : t, n = new o.Point(i.clientX, i.clientY), s = n.subtract(this._startPoint);
                    (s.x || s.y) && (o.Browser.touch && Math.abs(s.x) + Math.abs(s.y) < 3 || (o.DomEvent.preventDefault(t), this._moved || (this.fire("dragstart"), this._moved = !0, this._startPos = o.DomUtil.getPosition(this._element).subtract(s), o.DomUtil.addClass(e.body, "leaflet-dragging"), this._lastTarget = t.target || t.srcElement, o.DomUtil.addClass(this._lastTarget, "leaflet-drag-target")), this._newPos = this._startPos.add(s), this._moving = !0, o.Util.cancelAnimFrame(this._animRequest), this._animRequest = o.Util.requestAnimFrame(this._updatePosition, this, !0, this._dragStartTarget)))
                }, _updatePosition: function () {
                    this.fire("predrag"), o.DomUtil.setPosition(this._element, this._newPos), this.fire("drag")
                }, _onUp: function () {
                    o.DomUtil.removeClass(e.body, "leaflet-dragging"), this._lastTarget && (o.DomUtil.removeClass(this._lastTarget, "leaflet-drag-target"), this._lastTarget = null);
                    for (var t in o.Draggable.MOVE)o.DomEvent.off(e, o.Draggable.MOVE[t], this._onMove).off(e, o.Draggable.END[t], this._onUp);
                    o.DomUtil.enableImageDrag(), o.DomUtil.enableTextSelection(), this._moved && this._moving && (o.Util.cancelAnimFrame(this._animRequest), this.fire("dragend", {distance: this._newPos.distanceTo(this._startPos)})), this._moving = !1
                }
            }), o.Handler = o.Class.extend({
                initialize: function (t) {
                    this._map = t
                }, enable: function () {
                    this._enabled || (this._enabled = !0, this.addHooks())
                }, disable: function () {
                    this._enabled && (this._enabled = !1, this.removeHooks())
                }, enabled: function () {
                    return !!this._enabled
                }
            }), o.Map.mergeOptions({dragging: !0, inertia: !o.Browser.android23, inertiaDeceleration: 3400, inertiaMaxSpeed: 1 / 0, inertiaThreshold: o.Browser.touch ? 32 : 18, easeLinearity: .25, worldCopyJump: !1}), o.Map.Drag = o.Handler.extend({
                addHooks: function () {
                    if (!this._draggable) {
                        var t = this._map;
                        this._draggable = new o.Draggable(t._mapPane, t._container), this._draggable.on({dragstart: this._onDragStart, drag: this._onDrag, dragend: this._onDragEnd}, this), t.options.worldCopyJump && (this._draggable.on("predrag", this._onPreDrag, this), t.on("viewreset", this._onViewReset, this), t.whenReady(this._onViewReset, this))
                    }
                    this._draggable.enable()
                }, removeHooks: function () {
                    this._draggable.disable()
                }, moved: function () {
                    return this._draggable && this._draggable._moved
                }, _onDragStart: function () {
                    var t = this._map;
                    t._panAnim && t._panAnim.stop(), t.fire("movestart").fire("dragstart"), t.options.inertia && (this._positions = [], this._times = [])
                }, _onDrag: function () {
                    if (this._map.options.inertia) {
                        var t = this._lastTime = +new Date, e = this._lastPos = this._draggable._newPos;
                        this._positions.push(e), this._times.push(t), t - this._times[0] > 200 && (this._positions.shift(), this._times.shift())
                    }
                    this._map.fire("move").fire("drag")
                }, _onViewReset: function () {
                    var t = this._map.getSize()._divideBy(2), e = this._map.latLngToLayerPoint([0, 0]);
                    this._initialWorldOffset = e.subtract(t).x, this._worldWidth = this._map.project([0, 180]).x
                }, _onPreDrag: function () {
                    var t = this._worldWidth, e = Math.round(t / 2), i = this._initialWorldOffset, n = this._draggable._newPos.x, o = (n - e + i) % t + e - i, s = (n + e + i) % t - e - i, a = Math.abs(o + i) < Math.abs(s + i) ? o : s;
                    this._draggable._newPos.x = a
                }, _onDragEnd: function (t) {
                    var e = this._map, i = e.options, n = +new Date - this._lastTime, s = !i.inertia || n > i.inertiaThreshold || !this._positions[0];
                    if (e.fire("dragend", t), s) e.fire("moveend"); else {
                        var a = this._lastPos.subtract(this._positions[0]), r = (this._lastTime + n - this._times[0]) / 1e3, h = i.easeLinearity, l = a.multiplyBy(h / r), u = l.distanceTo([0, 0]), c = Math.min(i.inertiaMaxSpeed, u), d = l.multiplyBy(c / u), p = c / (i.inertiaDeceleration * h), _ = d.multiplyBy(-p / 2).round();
                        _.x && _.y ? (_ = e._limitOffset(_, e.options.maxBounds), o.Util.requestAnimFrame(function () {
                                e.panBy(_, {duration: p, easeLinearity: h, noMoveStart: !0})
                            })) : e.fire("moveend")
                    }
                }
            }), o.Map.addInitHook("addHandler", "dragging", o.Map.Drag), o.Map.mergeOptions({doubleClickZoom: !0}), o.Map.DoubleClickZoom = o.Handler.extend({
                addHooks: function () {
                    this._map.on("dblclick", this._onDoubleClick, this)
                }, removeHooks: function () {
                    this._map.off("dblclick", this._onDoubleClick, this)
                }, _onDoubleClick: function (t) {
                    var e = this._map, i = e.getZoom() + (t.originalEvent.shiftKey ? -1 : 1);
                    "center" === e.options.doubleClickZoom ? e.setZoom(i) : e.setZoomAround(t.containerPoint, i)
                }
            }), o.Map.addInitHook("addHandler", "doubleClickZoom", o.Map.DoubleClickZoom), o.Map.mergeOptions({scrollWheelZoom: !0}), o.Map.ScrollWheelZoom = o.Handler.extend({
                addHooks: function () {
                    o.DomEvent.on(this._map._container, "mousewheel", this._onWheelScroll, this), o.DomEvent.on(this._map._container, "MozMousePixelScroll", o.DomEvent.preventDefault), this._delta = 0
                }, removeHooks: function () {
                    o.DomEvent.off(this._map._container, "mousewheel", this._onWheelScroll), o.DomEvent.off(this._map._container, "MozMousePixelScroll", o.DomEvent.preventDefault)
                }, _onWheelScroll: function (t) {
                    var e = o.DomEvent.getWheelDelta(t);
                    this._delta += e, this._lastMousePos = this._map.mouseEventToContainerPoint(t), this._startTime || (this._startTime = +new Date);
                    var i = Math.max(40 - (+new Date - this._startTime), 0);
                    clearTimeout(this._timer), this._timer = setTimeout(o.bind(this._performZoom, this), i), o.DomEvent.preventDefault(t), o.DomEvent.stopPropagation(t)
                }, _performZoom: function () {
                    var t = this._map, e = this._delta, i = t.getZoom();
                    e = e > 0 ? Math.ceil(e) : Math.floor(e), e = Math.max(Math.min(e, 4), -4), e = t._limitZoom(i + e) - i, this._delta = 0, this._startTime = null, e && ("center" === t.options.scrollWheelZoom ? t.setZoom(i + e) : t.setZoomAround(this._lastMousePos, i + e))
                }
            }), o.Map.addInitHook("addHandler", "scrollWheelZoom", o.Map.ScrollWheelZoom), o.extend(o.DomEvent, {
                _touchstart: o.Browser.msPointer ? "MSPointerDown" : o.Browser.pointer ? "pointerdown" : "touchstart", _touchend: o.Browser.msPointer ? "MSPointerUp" : o.Browser.pointer ? "pointerup" : "touchend", addDoubleTapListener: function (t, i, n) {
                    function s(t) {
                        var e;
                        if (o.Browser.pointer ? (_.push(t.pointerId), e = _.length) : e = t.touches.length, !(e > 1)) {
                            var i = Date.now(), n = i - (r || i);
                            h = t.touches ? t.touches[0] : t, l = n > 0 && u >= n, r = i
                        }
                    }

                    function a(t) {
                        if (o.Browser.pointer) {
                            var e = _.indexOf(t.pointerId);
                            if (-1 === e)return;
                            _.splice(e, 1)
                        }
                        if (l) {
                            if (o.Browser.pointer) {
                                var n, s = {};
                                for (var a in h)n = h[a], "function" == typeof n ? s[a] = n.bind(h) : s[a] = n;
                                h = s
                            }
                            h.type = "dblclick", i(h), r = null
                        }
                    }

                    var r, h, l = !1, u = 250, c = "_leaflet_", d = this._touchstart, p = this._touchend, _ = [];
                    t[c + d + n] = s, t[c + p + n] = a;
                    var m = o.Browser.pointer ? e.documentElement : t;
                    return t.addEventListener(d, s, !1), m.addEventListener(p, a, !1), o.Browser.pointer && m.addEventListener(o.DomEvent.POINTER_CANCEL, a, !1), this
                }, removeDoubleTapListener: function (t, i) {
                    var n = "_leaflet_";
                    return t.removeEventListener(this._touchstart, t[n + this._touchstart + i], !1), (o.Browser.pointer ? e.documentElement : t).removeEventListener(this._touchend, t[n + this._touchend + i], !1), o.Browser.pointer && e.documentElement.removeEventListener(o.DomEvent.POINTER_CANCEL, t[n + this._touchend + i], !1), this
                }
            }), o.extend(o.DomEvent, {
                POINTER_DOWN: o.Browser.msPointer ? "MSPointerDown" : "pointerdown", POINTER_MOVE: o.Browser.msPointer ? "MSPointerMove" : "pointermove", POINTER_UP: o.Browser.msPointer ? "MSPointerUp" : "pointerup", POINTER_CANCEL: o.Browser.msPointer ? "MSPointerCancel" : "pointercancel", _pointers: [], _pointerDocumentListener: !1, addPointerListener: function (t, e, i, n) {
                    switch (e) {
                        case"touchstart":
                            return this.addPointerListenerStart(t, e, i, n);
                        case"touchend":
                            return this.addPointerListenerEnd(t, e, i, n);
                        case"touchmove":
                            return this.addPointerListenerMove(t, e, i, n);
                        default:
                            throw"Unknown touch event type"
                    }
                }, addPointerListenerStart: function (t, i, n, s) {
                    var a = "_leaflet_", r = this._pointers, h = function (t) {
                        "mouse" !== t.pointerType && t.pointerType !== t.MSPOINTER_TYPE_MOUSE && o.DomEvent.preventDefault(t);
                        for (var e = !1, i = 0; i < r.length; i++)if (r[i].pointerId === t.pointerId) {
                            e = !0;
                            break
                        }
                        e || r.push(t), t.touches = r.slice(), t.changedTouches = [t], n(t)
                    };
                    if (t[a + "touchstart" + s] = h, t.addEventListener(this.POINTER_DOWN, h, !1), !this._pointerDocumentListener) {
                        var l = function (t) {
                            for (var e = 0; e < r.length; e++)if (r[e].pointerId === t.pointerId) {
                                r.splice(e, 1);
                                break
                            }
                        };
                        e.documentElement.addEventListener(this.POINTER_UP, l, !1), e.documentElement.addEventListener(this.POINTER_CANCEL, l, !1), this._pointerDocumentListener = !0
                    }
                    return this
                }, addPointerListenerMove: function (t, e, i, n) {
                    function o(t) {
                        if (t.pointerType !== t.MSPOINTER_TYPE_MOUSE && "mouse" !== t.pointerType || 0 !== t.buttons) {
                            for (var e = 0; e < a.length; e++)if (a[e].pointerId === t.pointerId) {
                                a[e] = t;
                                break
                            }
                            t.touches = a.slice(), t.changedTouches = [t], i(t)
                        }
                    }

                    var s = "_leaflet_", a = this._pointers;
                    return t[s + "touchmove" + n] = o, t.addEventListener(this.POINTER_MOVE, o, !1), this
                }, addPointerListenerEnd: function (t, e, i, n) {
                    var o = "_leaflet_", s = this._pointers, a = function (t) {
                        for (var e = 0; e < s.length; e++)if (s[e].pointerId === t.pointerId) {
                            s.splice(e, 1);
                            break
                        }
                        t.touches = s.slice(), t.changedTouches = [t], i(t)
                    };
                    return t[o + "touchend" + n] = a, t.addEventListener(this.POINTER_UP, a, !1), t.addEventListener(this.POINTER_CANCEL, a, !1), this
                }, removePointerListener: function (t, e, i) {
                    var n = "_leaflet_", o = t[n + e + i];
                    switch (e) {
                        case"touchstart":
                            t.removeEventListener(this.POINTER_DOWN, o, !1);
                            break;
                        case"touchmove":
                            t.removeEventListener(this.POINTER_MOVE, o, !1);
                            break;
                        case"touchend":
                            t.removeEventListener(this.POINTER_UP, o, !1), t.removeEventListener(this.POINTER_CANCEL, o, !1)
                    }
                    return this
                }
            }), o.Map.mergeOptions({touchZoom: o.Browser.touch && !o.Browser.android23, bounceAtZoomLimits: !0}), o.Map.TouchZoom = o.Handler.extend({
                addHooks: function () {
                    o.DomEvent.on(this._map._container, "touchstart", this._onTouchStart, this)
                }, removeHooks: function () {
                    o.DomEvent.off(this._map._container, "touchstart", this._onTouchStart, this)
                }, _onTouchStart: function (t) {
                    var i = this._map;
                    if (t.touches && 2 === t.touches.length && !i._animatingZoom && !this._zooming) {
                        var n = i.mouseEventToLayerPoint(t.touches[0]), s = i.mouseEventToLayerPoint(t.touches[1]), a = i._getCenterLayerPoint();
                        this._startCenter = n.add(s)._divideBy(2), this._startDist = n.distanceTo(s), this._moved = !1, this._zooming = !0, this._centerOffset = a.subtract(this._startCenter), i._panAnim && i._panAnim.stop(), o.DomEvent.on(e, "touchmove", this._onTouchMove, this).on(e, "touchend", this._onTouchEnd, this), o.DomEvent.preventDefault(t)
                    }
                }, _onTouchMove: function (t) {
                    var e = this._map;
                    if (t.touches && 2 === t.touches.length && this._zooming) {
                        var i = e.mouseEventToLayerPoint(t.touches[0]), n = e.mouseEventToLayerPoint(t.touches[1]);
                        this._scale = i.distanceTo(n) / this._startDist, this._delta = i._add(n)._divideBy(2)._subtract(this._startCenter), 1 !== this._scale && (e.options.bounceAtZoomLimits || !(e.getZoom() === e.getMinZoom() && this._scale < 1 || e.getZoom() === e.getMaxZoom() && this._scale > 1)) && (this._moved || (o.DomUtil.addClass(e._mapPane, "leaflet-touching"), e.fire("movestart").fire("zoomstart"), this._moved = !0), o.Util.cancelAnimFrame(this._animRequest), this._animRequest = o.Util.requestAnimFrame(this._updateOnMove, this, !0, this._map._container), o.DomEvent.preventDefault(t))
                    }
                }, _updateOnMove: function () {
                    var t = this._map, e = this._getScaleOrigin(), i = t.layerPointToLatLng(e), n = t.getScaleZoom(this._scale);
                    t._animateZoom(i, n, this._startCenter, this._scale, this._delta, !1, !0)
                }, _onTouchEnd: function () {
                    if (!this._moved || !this._zooming)return void(this._zooming = !1);
                    var t = this._map;
                    this._zooming = !1, o.DomUtil.removeClass(t._mapPane, "leaflet-touching"), o.Util.cancelAnimFrame(this._animRequest), o.DomEvent.off(e, "touchmove", this._onTouchMove).off(e, "touchend", this._onTouchEnd);
                    var i = this._getScaleOrigin(), n = t.layerPointToLatLng(i), s = t.getZoom(), a = t.getScaleZoom(this._scale) - s, r = a > 0 ? Math.ceil(a) : Math.floor(a), h = t._limitZoom(s + r), l = t.getZoomScale(h) / this._scale;
                    t._animateZoom(n, h, i, l)
                }, _getScaleOrigin: function () {
                    var t = this._centerOffset.subtract(this._delta).divideBy(this._scale);
                    return this._startCenter.add(t)
                }
            }), o.Map.addInitHook("addHandler", "touchZoom", o.Map.TouchZoom), o.Map.mergeOptions({tap: !0, tapTolerance: 15}), o.Map.Tap = o.Handler.extend({
                addHooks: function () {
                    o.DomEvent.on(this._map._container, "touchstart", this._onDown, this)
                }, removeHooks: function () {
                    o.DomEvent.off(this._map._container, "touchstart", this._onDown, this)
                }, _onDown: function (t) {
                    if (t.touches) {
                        if (o.DomEvent.preventDefault(t), this._fireClick = !0, t.touches.length > 1)return this._fireClick = !1, void clearTimeout(this._holdTimeout);
                        var i = t.touches[0], n = i.target;
                        this._startPos = this._newPos = new o.Point(i.clientX, i.clientY), n.tagName && "a" === n.tagName.toLowerCase() && o.DomUtil.addClass(n, "leaflet-active"), this._holdTimeout = setTimeout(o.bind(function () {
                            this._isTapValid() && (this._fireClick = !1, this._onUp(), this._simulateEvent("contextmenu", i))
                        }, this), 1e3), o.DomEvent.on(e, "touchmove", this._onMove, this).on(e, "touchend", this._onUp, this)
                    }
                }, _onUp: function (t) {
                    if (clearTimeout(this._holdTimeout), o.DomEvent.off(e, "touchmove", this._onMove, this).off(e, "touchend", this._onUp, this), this._fireClick && t && t.changedTouches) {
                        var i = t.changedTouches[0], n = i.target;
                        n && n.tagName && "a" === n.tagName.toLowerCase() && o.DomUtil.removeClass(n, "leaflet-active"), this._isTapValid() && this._simulateEvent("click", i)
                    }
                }, _isTapValid: function () {
                    return this._newPos.distanceTo(this._startPos) <= this._map.options.tapTolerance
                }, _onMove: function (t) {
                    var e = t.touches[0];
                    this._newPos = new o.Point(e.clientX, e.clientY)
                }, _simulateEvent: function (i, n) {
                    var o = e.createEvent("MouseEvents");
                    o._simulated = !0, n.target._simulatedClick = !0, o.initMouseEvent(i, !0, !0, t, 1, n.screenX, n.screenY, n.clientX, n.clientY, !1, !1, !1, !1, 0, null), n.target.dispatchEvent(o)
                }
            }), o.Browser.touch && !o.Browser.pointer && o.Map.addInitHook("addHandler", "tap", o.Map.Tap), o.Map.mergeOptions({boxZoom: !0}), o.Map.BoxZoom = o.Handler.extend({
                initialize: function (t) {
                    this._map = t, this._container = t._container, this._pane = t._panes.overlayPane, this._moved = !1
                }, addHooks: function () {
                    o.DomEvent.on(this._container, "mousedown", this._onMouseDown, this)
                }, removeHooks: function () {
                    o.DomEvent.off(this._container, "mousedown", this._onMouseDown), this._moved = !1
                }, moved: function () {
                    return this._moved
                }, _onMouseDown: function (t) {
                    return this._moved = !1, !t.shiftKey || 1 !== t.which && 1 !== t.button ? !1 : (o.DomUtil.disableTextSelection(), o.DomUtil.disableImageDrag(), this._startLayerPoint = this._map.mouseEventToLayerPoint(t), void o.DomEvent.on(e, "mousemove", this._onMouseMove, this).on(e, "mouseup", this._onMouseUp, this).on(e, "keydown", this._onKeyDown, this))
                }, _onMouseMove: function (t) {
                    this._moved || (this._box = o.DomUtil.create("div", "leaflet-zoom-box", this._pane), o.DomUtil.setPosition(this._box, this._startLayerPoint), this._container.style.cursor = "crosshair", this._map.fire("boxzoomstart"));
                    var e = this._startLayerPoint, i = this._box, n = this._map.mouseEventToLayerPoint(t), s = n.subtract(e), a = new o.Point(Math.min(n.x, e.x), Math.min(n.y, e.y));
                    o.DomUtil.setPosition(i, a), this._moved = !0, i.style.width = Math.max(0, Math.abs(s.x) - 4) + "px", i.style.height = Math.max(0, Math.abs(s.y) - 4) + "px"
                }, _finish: function () {
                    this._moved && (this._pane.removeChild(this._box), this._container.style.cursor = ""), o.DomUtil.enableTextSelection(), o.DomUtil.enableImageDrag(), o.DomEvent.off(e, "mousemove", this._onMouseMove).off(e, "mouseup", this._onMouseUp).off(e, "keydown", this._onKeyDown)
                }, _onMouseUp: function (t) {
                    this._finish();
                    var e = this._map, i = e.mouseEventToLayerPoint(t);
                    if (!this._startLayerPoint.equals(i)) {
                        var n = new o.LatLngBounds(e.layerPointToLatLng(this._startLayerPoint), e.layerPointToLatLng(i));
                        e.fitBounds(n), e.fire("boxzoomend", {boxZoomBounds: n})
                    }
                }, _onKeyDown: function (t) {
                    27 === t.keyCode && this._finish()
                }
            }), o.Map.addInitHook("addHandler", "boxZoom", o.Map.BoxZoom), o.Map.mergeOptions({keyboard: !0, keyboardPanOffset: 80, keyboardZoomOffset: 1}), o.Map.Keyboard = o.Handler.extend({
                keyCodes: {left: [37], right: [39], down: [40], up: [38], zoomIn: [187, 107, 61, 171], zoomOut: [189, 109, 173]}, initialize: function (t) {
                    this._map = t, this._setPanOffset(t.options.keyboardPanOffset), this._setZoomOffset(t.options.keyboardZoomOffset)
                }, addHooks: function () {
                    var t = this._map._container;
                    -1 === t.tabIndex && (t.tabIndex = "0"), o.DomEvent.on(t, "focus", this._onFocus, this).on(t, "blur", this._onBlur, this).on(t, "mousedown", this._onMouseDown, this), this._map.on("focus", this._addHooks, this).on("blur", this._removeHooks, this)
                }, removeHooks: function () {
                    this._removeHooks();
                    var t = this._map._container;
                    o.DomEvent.off(t, "focus", this._onFocus, this).off(t, "blur", this._onBlur, this).off(t, "mousedown", this._onMouseDown, this), this._map.off("focus", this._addHooks, this).off("blur", this._removeHooks, this)
                }, _onMouseDown: function () {
                    if (!this._focused) {
                        var i = e.body, n = e.documentElement, o = i.scrollTop || n.scrollTop, s = i.scrollLeft || n.scrollLeft;
                        this._map._container.focus(), t.scrollTo(s, o)
                    }
                }, _onFocus: function () {
                    this._focused = !0, this._map.fire("focus")
                }, _onBlur: function () {
                    this._focused = !1, this._map.fire("blur")
                }, _setPanOffset: function (t) {
                    var e, i, n = this._panKeys = {}, o = this.keyCodes;
                    for (e = 0, i = o.left.length; i > e; e++)n[o.left[e]] = [-1 * t, 0];
                    for (e = 0, i = o.right.length; i > e; e++)n[o.right[e]] = [t, 0];
                    for (e = 0, i = o.down.length; i > e; e++)n[o.down[e]] = [0, t];
                    for (e = 0, i = o.up.length; i > e; e++)n[o.up[e]] = [0, -1 * t]
                }, _setZoomOffset: function (t) {
                    var e, i, n = this._zoomKeys = {}, o = this.keyCodes;
                    for (e = 0, i = o.zoomIn.length; i > e; e++)n[o.zoomIn[e]] = t;
                    for (e = 0, i = o.zoomOut.length; i > e; e++)n[o.zoomOut[e]] = -t
                }, _addHooks: function () {
                    o.DomEvent.on(e, "keydown", this._onKeyDown, this)
                }, _removeHooks: function () {
                    o.DomEvent.off(e, "keydown", this._onKeyDown, this)
                }, _onKeyDown: function (t) {
                    var e = t.keyCode, i = this._map;
                    if (e in this._panKeys) {
                        if (i._panAnim && i._panAnim._inProgress)return;
                        i.panBy(this._panKeys[e]), i.options.maxBounds && i.panInsideBounds(i.options.maxBounds)
                    } else {
                        if (!(e in this._zoomKeys))return;
                        i.setZoom(i.getZoom() + this._zoomKeys[e])
                    }
                    o.DomEvent.stop(t)
                }
            }), o.Map.addInitHook("addHandler", "keyboard", o.Map.Keyboard), o.Handler.MarkerDrag = o.Handler.extend({
                initialize: function (t) {
                    this._marker = t
                }, addHooks: function () {
                    var t = this._marker._icon;
                    this._draggable || (this._draggable = new o.Draggable(t, t)), this._draggable.on("dragstart", this._onDragStart, this).on("drag", this._onDrag, this).on("dragend", this._onDragEnd, this), this._draggable.enable(), o.DomUtil.addClass(this._marker._icon, "leaflet-marker-draggable")
                }, removeHooks: function () {
                    this._draggable.off("dragstart", this._onDragStart, this).off("drag", this._onDrag, this).off("dragend", this._onDragEnd, this), this._draggable.disable(), o.DomUtil.removeClass(this._marker._icon, "leaflet-marker-draggable")
                }, moved: function () {
                    return this._draggable && this._draggable._moved
                }, _onDragStart: function () {
                    this._marker.closePopup().fire("movestart").fire("dragstart")
                }, _onDrag: function () {
                    var t = this._marker, e = t._shadow, i = o.DomUtil.getPosition(t._icon), n = t._map.layerPointToLatLng(i);
                    e && o.DomUtil.setPosition(e, i), t._latlng = n, t.fire("move", {latlng: n}).fire("drag")
                }, _onDragEnd: function (t) {
                    this._marker.fire("moveend").fire("dragend", t)
                }
            }), o.Control = o.Class.extend({
                options: {position: "topright"}, initialize: function (t) {
                    o.setOptions(this, t)
                }, getPosition: function () {
                    return this.options.position
                }, setPosition: function (t) {
                    var e = this._map;
                    return e && e.removeControl(this), this.options.position = t, e && e.addControl(this), this
                }, getContainer: function () {
                    return this._container
                }, addTo: function (t) {
                    this._map = t;
                    var e = this._container = this.onAdd(t), i = this.getPosition(), n = t._controlCorners[i];
                    return o.DomUtil.addClass(e, "leaflet-control"), -1 !== i.indexOf("bottom") ? n.insertBefore(e, n.firstChild) : n.appendChild(e), this
                }, removeFrom: function (t) {
                    var e = this.getPosition(), i = t._controlCorners[e];
                    return i.removeChild(this._container), this._map = null, this.onRemove && this.onRemove(t), this
                }, _refocusOnMap: function () {
                    this._map && this._map.getContainer().focus()
                }
            }), o.control = function (t) {
                return new o.Control(t)
            }, o.Map.include({
                addControl: function (t) {
                    return t.addTo(this), this
                }, removeControl: function (t) {
                    return t.removeFrom(this), this
                }, _initControlPos: function () {
                    function t(t, s) {
                        var a = i + t + " " + i + s;
                        e[t + s] = o.DomUtil.create("div", a, n)
                    }

                    var e = this._controlCorners = {}, i = "leaflet-", n = this._controlContainer = o.DomUtil.create("div", i + "control-container", this._container);
                    t("top", "left"), t("top", "right"), t("bottom", "left"), t("bottom", "right")
                }, _clearControlPos: function () {
                    this._container.removeChild(this._controlContainer)
                }
            }), o.Control.Zoom = o.Control.extend({
                options: {position: "topleft", zoomInText: "+", zoomInTitle: "Zoom in", zoomOutText: "-", zoomOutTitle: "Zoom out"}, onAdd: function (t) {
                    var e = "leaflet-control-zoom", i = o.DomUtil.create("div", e + " leaflet-bar");
                    return this._map = t, this._zoomInButton = this._createButton(this.options.zoomInText, this.options.zoomInTitle, e + "-in", i, this._zoomIn, this), this._zoomOutButton = this._createButton(this.options.zoomOutText, this.options.zoomOutTitle, e + "-out", i, this._zoomOut, this), this._updateDisabled(), t.on("zoomend zoomlevelschange", this._updateDisabled, this), i
                }, onRemove: function (t) {
                    t.off("zoomend zoomlevelschange", this._updateDisabled, this)
                }, _zoomIn: function (t) {
                    this._map.zoomIn(t.shiftKey ? 3 : 1)
                }, _zoomOut: function (t) {
                    this._map.zoomOut(t.shiftKey ? 3 : 1)
                }, _createButton: function (t, e, i, n, s, a) {
                    var r = o.DomUtil.create("a", i, n);
                    r.innerHTML = t, r.href = "#", r.title = e;
                    var h = o.DomEvent.stopPropagation;
                    return o.DomEvent.on(r, "click", h).on(r, "mousedown", h).on(r, "dblclick", h).on(r, "click", o.DomEvent.preventDefault).on(r, "click", s, a).on(r, "click", this._refocusOnMap, a), r
                }, _updateDisabled: function () {
                    var t = this._map, e = "leaflet-disabled";
                    o.DomUtil.removeClass(this._zoomInButton, e), o.DomUtil.removeClass(this._zoomOutButton, e), t._zoom === t.getMinZoom() && o.DomUtil.addClass(this._zoomOutButton, e), t._zoom === t.getMaxZoom() && o.DomUtil.addClass(this._zoomInButton, e)
                }
            }), o.Map.mergeOptions({zoomControl: !0}), o.Map.addInitHook(function () {
                this.options.zoomControl && (this.zoomControl = new o.Control.Zoom, this.addControl(this.zoomControl))
            }), o.control.zoom = function (t) {
                return new o.Control.Zoom(t)
            }, o.Control.Attribution = o.Control.extend({
                options: {position: "bottomright", prefix: '<a href="http://leafletjs.com" title="A JS library for interactive maps">Leaflet</a>'}, initialize: function (t) {
                    o.setOptions(this, t), this._attributions = {}
                }, onAdd: function (t) {
                    this._container = o.DomUtil.create("div", "leaflet-control-attribution"), o.DomEvent.disableClickPropagation(this._container);
                    for (var e in t._layers)t._layers[e].getAttribution && this.addAttribution(t._layers[e].getAttribution());
                    return t.on("layeradd", this._onLayerAdd, this).on("layerremove", this._onLayerRemove, this), this._update(), this._container
                }, onRemove: function (t) {
                    t.off("layeradd", this._onLayerAdd).off("layerremove", this._onLayerRemove)
                }, setPrefix: function (t) {
                    return this.options.prefix = t, this._update(), this
                }, addAttribution: function (t) {
                    return t ? (this._attributions[t] || (this._attributions[t] = 0), this._attributions[t]++, this._update(), this) : void 0
                }, removeAttribution: function (t) {
                    return t ? (this._attributions[t] && (this._attributions[t]--, this._update()), this) : void 0
                }, _update: function () {
                    if (this._map) {
                        var t = [];
                        for (var e in this._attributions)this._attributions[e] && t.push(e);
                        var i = [];
                        this.options.prefix && i.push(this.options.prefix), t.length && i.push(t.join(", ")), this._container.innerHTML = i.join(" | ")
                    }
                }, _onLayerAdd: function (t) {
                    t.layer.getAttribution && this.addAttribution(t.layer.getAttribution())
                }, _onLayerRemove: function (t) {
                    t.layer.getAttribution && this.removeAttribution(t.layer.getAttribution())
                }
            }), o.Map.mergeOptions({attributionControl: !0}), o.Map.addInitHook(function () {
                this.options.attributionControl && (this.attributionControl = (new o.Control.Attribution).addTo(this))
            }), o.control.attribution = function (t) {
                return new o.Control.Attribution(t)
            }, o.Control.Scale = o.Control.extend({
                options: {position: "bottomleft", maxWidth: 100, metric: !0, imperial: !0, updateWhenIdle: !1}, onAdd: function (t) {
                    this._map = t;
                    var e = "leaflet-control-scale", i = o.DomUtil.create("div", e), n = this.options;
                    return this._addScales(n, e, i), t.on(n.updateWhenIdle ? "moveend" : "move", this._update, this), t.whenReady(this._update, this), i
                }, onRemove: function (t) {
                    t.off(this.options.updateWhenIdle ? "moveend" : "move", this._update, this)
                }, _addScales: function (t, e, i) {
                    t.metric && (this._mScale = o.DomUtil.create("div", e + "-line", i)), t.imperial && (this._iScale = o.DomUtil.create("div", e + "-line", i))
                }, _update: function () {
                    var t = this._map.getBounds(), e = t.getCenter().lat, i = 6378137 * Math.PI * Math.cos(e * Math.PI / 180), n = i * (t.getNorthEast().lng - t.getSouthWest().lng) / 180, o = this._map.getSize(), s = this.options, a = 0;
                    o.x > 0 && (a = n * (s.maxWidth / o.x)), this._updateScales(s, a)
                }, _updateScales: function (t, e) {
                    t.metric && e && this._updateMetric(e), t.imperial && e && this._updateImperial(e)
                }, _updateMetric: function (t) {
                    var e = this._getRoundNum(t);
                    this._mScale.style.width = this._getScaleWidth(e / t) + "px", this._mScale.innerHTML = 1e3 > e ? e + " m" : e / 1e3 + " km"
                }, _updateImperial: function (t) {
                    var e, i, n, o = 3.2808399 * t, s = this._iScale;
                    o > 5280 ? (e = o / 5280, i = this._getRoundNum(e), s.style.width = this._getScaleWidth(i / e) + "px", s.innerHTML = i + " mi") : (n = this._getRoundNum(o), s.style.width = this._getScaleWidth(n / o) + "px", s.innerHTML = n + " ft")
                }, _getScaleWidth: function (t) {
                    return Math.round(this.options.maxWidth * t) - 10
                }, _getRoundNum: function (t) {
                    var e = Math.pow(10, (Math.floor(t) + "").length - 1), i = t / e;
                    return i = i >= 10 ? 10 : i >= 5 ? 5 : i >= 3 ? 3 : i >= 2 ? 2 : 1, e * i
                }
            }), o.control.scale = function (t) {
                return new o.Control.Scale(t)
            }, o.Control.Layers = o.Control.extend({
                options: {collapsed: !0, position: "topright", autoZIndex: !0}, initialize: function (t, e, i) {
                    o.setOptions(this, i), this._layers = {}, this._lastZIndex = 0, this._handlingClick = !1;
                    for (var n in t)this._addLayer(t[n], n);
                    for (n in e)this._addLayer(e[n], n, !0)
                }, onAdd: function (t) {
                    return this._initLayout(), this._update(), t.on("layeradd", this._onLayerChange, this).on("layerremove", this._onLayerChange, this), this._container
                }, onRemove: function (t) {
                    t.off("layeradd", this._onLayerChange, this).off("layerremove", this._onLayerChange, this)
                }, addBaseLayer: function (t, e) {
                    return this._addLayer(t, e), this._update(), this
                }, addOverlay: function (t, e) {
                    return this._addLayer(t, e, !0), this._update(), this
                }, removeLayer: function (t) {
                    var e = o.stamp(t);
                    return delete this._layers[e], this._update(), this
                }, _initLayout: function () {
                    var t = "leaflet-control-layers", e = this._container = o.DomUtil.create("div", t);
                    e.setAttribute("aria-haspopup", !0), o.Browser.touch ? o.DomEvent.on(e, "click", o.DomEvent.stopPropagation) : o.DomEvent.disableClickPropagation(e).disableScrollPropagation(e);
                    var i = this._form = o.DomUtil.create("form", t + "-list");
                    if (this.options.collapsed) {
                        o.Browser.android || o.DomEvent.on(e, "mouseover", this._expand, this).on(e, "mouseout", this._collapse, this);
                        var n = this._layersLink = o.DomUtil.create("a", t + "-toggle", e);
                        n.href = "#", n.title = "Layers", o.Browser.touch ? o.DomEvent.on(n, "click", o.DomEvent.stop).on(n, "click", this._expand, this) : o.DomEvent.on(n, "focus", this._expand, this), o.DomEvent.on(i, "click", function () {
                            setTimeout(o.bind(this._onInputClick, this), 0)
                        }, this), this._map.on("click", this._collapse, this)
                    } else this._expand();
                    this._baseLayersList = o.DomUtil.create("div", t + "-base", i), this._separator = o.DomUtil.create("div", t + "-separator", i), this._overlaysList = o.DomUtil.create("div", t + "-overlays", i), e.appendChild(i)
                }, _addLayer: function (t, e, i) {
                    var n = o.stamp(t);
                    this._layers[n] = {layer: t, name: e, overlay: i}, this.options.autoZIndex && t.setZIndex && (this._lastZIndex++, t.setZIndex(this._lastZIndex))
                }, _update: function () {
                    if (this._container) {
                        this._baseLayersList.innerHTML = "", this._overlaysList.innerHTML = "";
                        var t, e, i = !1, n = !1;
                        for (t in this._layers)e = this._layers[t], this._addItem(e), n = n || e.overlay, i = i || !e.overlay;
                        this._separator.style.display = n && i ? "" : "none"
                    }
                }, _onLayerChange: function (t) {
                    var e = this._layers[o.stamp(t.layer)];
                    if (e) {
                        this._handlingClick || this._update();
                        var i = e.overlay ? "layeradd" === t.type ? "overlayadd" : "overlayremove" : "layeradd" === t.type ? "baselayerchange" : null;
                        i && this._map.fire(i, e)
                    }
                }, _createRadioElement: function (t, i) {
                    var n = '<input type="radio" class="leaflet-control-layers-selector" name="' + t + '"';
                    i && (n += ' checked="checked"'), n += "/>";
                    var o = e.createElement("div");
                    return o.innerHTML = n, o.firstChild
                }, _addItem: function (t) {
                    var i, n = e.createElement("label"), s = this._map.hasLayer(t.layer);
                    t.overlay ? (i = e.createElement("input"), i.type = "checkbox", i.className = "leaflet-control-layers-selector", i.defaultChecked = s) : i = this._createRadioElement("leaflet-base-layers", s), i.layerId = o.stamp(t.layer), o.DomEvent.on(i, "click", this._onInputClick, this);
                    var a = e.createElement("span");
                    a.innerHTML = " " + t.name, n.appendChild(i), n.appendChild(a);
                    var r = t.overlay ? this._overlaysList : this._baseLayersList;
                    return r.appendChild(n), n
                }, _onInputClick: function () {
                    var t, e, i, n = this._form.getElementsByTagName("input"), o = n.length;
                    for (this._handlingClick = !0, t = 0; o > t; t++)e = n[t], i = this._layers[e.layerId], e.checked && !this._map.hasLayer(i.layer) ? this._map.addLayer(i.layer) : !e.checked && this._map.hasLayer(i.layer) && this._map.removeLayer(i.layer);
                    this._handlingClick = !1, this._refocusOnMap()
                }, _expand: function () {
                    o.DomUtil.addClass(this._container, "leaflet-control-layers-expanded")
                }, _collapse: function () {
                    this._container.className = this._container.className.replace(" leaflet-control-layers-expanded", "")
                }
            }), o.control.layers = function (t, e, i) {
                return new o.Control.Layers(t, e, i)
            }, o.PosAnimation = o.Class.extend({
                includes: o.Mixin.Events, run: function (t, e, i, n) {
                    this.stop(), this._el = t, this._inProgress = !0, this._newPos = e, this.fire("start"), t.style[o.DomUtil.TRANSITION] = "all " + (i || .25) + "s cubic-bezier(0,0," + (n || .5) + ",1)", o.DomEvent.on(t, o.DomUtil.TRANSITION_END, this._onTransitionEnd, this), o.DomUtil.setPosition(t, e), o.Util.falseFn(t.offsetWidth), this._stepTimer = setInterval(o.bind(this._onStep, this), 50)
                }, stop: function () {
                    this._inProgress && (o.DomUtil.setPosition(this._el, this._getPos()), this._onTransitionEnd(), o.Util.falseFn(this._el.offsetWidth))
                }, _onStep: function () {
                    var t = this._getPos();
                    return t ? (this._el._leaflet_pos = t, void this.fire("step")) : void this._onTransitionEnd()
                }, _transformRe: /([-+]?(?:\d*\.)?\d+)\D*, ([-+]?(?:\d*\.)?\d+)\D*\)/, _getPos: function () {
                    var e, i, n, s = this._el, a = t.getComputedStyle(s);
                    if (o.Browser.any3d) {
                        if (n = a[o.DomUtil.TRANSFORM].match(this._transformRe), !n)return;
                        e = parseFloat(n[1]), i = parseFloat(n[2])
                    } else e = parseFloat(a.left), i = parseFloat(a.top);
                    return new o.Point(e, i, !0)
                }, _onTransitionEnd: function () {
                    o.DomEvent.off(this._el, o.DomUtil.TRANSITION_END, this._onTransitionEnd, this), this._inProgress && (this._inProgress = !1, this._el.style[o.DomUtil.TRANSITION] = "", this._el._leaflet_pos = this._newPos, clearInterval(this._stepTimer), this.fire("step").fire("end"))
                }
            }), o.Map.include({
                setView: function (t, e, n) {
                    if (e = e === i ? this._zoom : this._limitZoom(e), t = this._limitCenter(o.latLng(t), e, this.options.maxBounds), n = n || {}, this._panAnim && this._panAnim.stop(), this._loaded && !n.reset && n !== !0) {
                        n.animate !== i && (n.zoom = o.extend({animate: n.animate}, n.zoom), n.pan = o.extend({animate: n.animate}, n.pan));
                        var s = this._zoom !== e ? this._tryAnimatedZoom && this._tryAnimatedZoom(t, e, n.zoom) : this._tryAnimatedPan(t, n.pan);
                        if (s)return clearTimeout(this._sizeTimer), this
                    }
                    return this._resetView(t, e), this
                }, panBy: function (t, e) {
                    if (t = o.point(t).round(), e = e || {}, !t.x && !t.y)return this;
                    if (this._panAnim || (this._panAnim = new o.PosAnimation, this._panAnim.on({step: this._onPanTransitionStep, end: this._onPanTransitionEnd}, this)), e.noMoveStart || this.fire("movestart"), e.animate !== !1) {
                        o.DomUtil.addClass(this._mapPane, "leaflet-pan-anim");
                        var i = this._getMapPanePos().subtract(t);
                        this._panAnim.run(this._mapPane, i, e.duration || .25, e.easeLinearity)
                    } else this._rawPanBy(t), this.fire("move").fire("moveend");
                    return this
                }, _onPanTransitionStep: function () {
                    this.fire("move")
                }, _onPanTransitionEnd: function () {
                    o.DomUtil.removeClass(this._mapPane, "leaflet-pan-anim"), this.fire("moveend")
                }, _tryAnimatedPan: function (t, e) {
                    var i = this._getCenterOffset(t)._floor();
                    return (e && e.animate) === !0 || this.getSize().contains(i) ? (this.panBy(i, e), !0) : !1
                }
            }), o.PosAnimation = o.DomUtil.TRANSITION ? o.PosAnimation : o.PosAnimation.extend({
                    run: function (t, e, i, n) {
                        this.stop(), this._el = t, this._inProgress = !0, this._duration = i || .25, this._easeOutPower = 1 / Math.max(n || .5, .2), this._startPos = o.DomUtil.getPosition(t), this._offset = e.subtract(this._startPos), this._startTime = +new Date, this.fire("start"), this._animate()
                    }, stop: function () {
                        this._inProgress && (this._step(), this._complete())
                    }, _animate: function () {
                        this._animId = o.Util.requestAnimFrame(this._animate, this), this._step()
                    }, _step: function () {
                        var t = +new Date - this._startTime, e = 1e3 * this._duration;
                        e > t ? this._runFrame(this._easeOut(t / e)) : (this._runFrame(1), this._complete())
                    }, _runFrame: function (t) {
                        var e = this._startPos.add(this._offset.multiplyBy(t));
                        o.DomUtil.setPosition(this._el, e), this.fire("step")
                    }, _complete: function () {
                        o.Util.cancelAnimFrame(this._animId), this._inProgress = !1, this.fire("end")
                    }, _easeOut: function (t) {
                        return 1 - Math.pow(1 - t, this._easeOutPower)
                    }
                }), o.Map.mergeOptions({zoomAnimation: !0, zoomAnimationThreshold: 4}), o.DomUtil.TRANSITION && o.Map.addInitHook(function () {
                this._zoomAnimated = this.options.zoomAnimation && o.DomUtil.TRANSITION && o.Browser.any3d && !o.Browser.android23 && !o.Browser.mobileOpera, this._zoomAnimated && o.DomEvent.on(this._mapPane, o.DomUtil.TRANSITION_END, this._catchTransitionEnd, this)
            }), o.Map.include(o.DomUtil.TRANSITION ? {
                    _catchTransitionEnd: function (t) {
                        this._animatingZoom && t.propertyName.indexOf("transform") >= 0 && this._onZoomTransitionEnd()
                    }, _nothingToAnimate: function () {
                        return !this._container.getElementsByClassName("leaflet-zoom-animated").length
                    }, _tryAnimatedZoom: function (t, e, i) {
                        if (this._animatingZoom)return !0;
                        if (i = i || {}, !this._zoomAnimated || i.animate === !1 || this._nothingToAnimate() || Math.abs(e - this._zoom) > this.options.zoomAnimationThreshold)return !1;
                        var n = this.getZoomScale(e), o = this._getCenterOffset(t)._divideBy(1 - 1 / n), s = this._getCenterLayerPoint()._add(o);
                        return i.animate === !0 || this.getSize().contains(o) ? (this.fire("movestart").fire("zoomstart"), this._animateZoom(t, e, s, n, null, !0), !0) : !1
                    }, _animateZoom: function (t, e, i, n, s, a, r) {
                        r || (this._animatingZoom = !0), o.DomUtil.addClass(this._mapPane, "leaflet-zoom-anim"), this._animateToCenter = t, this._animateToZoom = e, o.Draggable && (o.Draggable._disabled = !0), o.Util.requestAnimFrame(function () {
                            this.fire("zoomanim", {center: t, zoom: e, origin: i, scale: n, delta: s, backwards: a}), setTimeout(o.bind(this._onZoomTransitionEnd, this), 250)
                        }, this)
                    }, _onZoomTransitionEnd: function () {
                        this._animatingZoom && (this._animatingZoom = !1, o.DomUtil.removeClass(this._mapPane, "leaflet-zoom-anim"), o.Util.requestAnimFrame(function () {
                            this._resetView(this._animateToCenter, this._animateToZoom, !0, !0), o.Draggable && (o.Draggable._disabled = !1)
                        }, this))
                    }
                } : {}), o.TileLayer.include({
                _animateZoom: function (t) {
                    this._animating || (this._animating = !0, this._prepareBgBuffer());
                    var e = this._bgBuffer, i = o.DomUtil.TRANSFORM, n = t.delta ? o.DomUtil.getTranslateString(t.delta) : e.style[i], s = o.DomUtil.getScaleString(t.scale, t.origin);
                    e.style[i] = t.backwards ? s + " " + n : n + " " + s
                }, _endZoomAnim: function () {
                    var t = this._tileContainer, e = this._bgBuffer;
                    t.style.visibility = "", t.parentNode.appendChild(t), o.Util.falseFn(e.offsetWidth);
                    var i = this._map.getZoom();
                    (i > this.options.maxZoom || i < this.options.minZoom) && this._clearBgBuffer(), this._animating = !1
                }, _clearBgBuffer: function () {
                    var t = this._map;
                    !t || t._animatingZoom || t.touchZoom._zooming || (this._bgBuffer.innerHTML = "", this._bgBuffer.style[o.DomUtil.TRANSFORM] = "")
                }, _prepareBgBuffer: function () {
                    var t = this._tileContainer, e = this._bgBuffer, i = this._getLoadedTilesPercentage(e), n = this._getLoadedTilesPercentage(t);
                    return e && i > .5 && .5 > n ? (t.style.visibility = "hidden", void this._stopLoadingImages(t)) : (e.style.visibility = "hidden", e.style[o.DomUtil.TRANSFORM] = "", this._tileContainer = e, e = this._bgBuffer = t, this._stopLoadingImages(e), void clearTimeout(this._clearBgBufferTimer))
                }, _getLoadedTilesPercentage: function (t) {
                    var e, i, n = t.getElementsByTagName("img"), o = 0;
                    for (e = 0, i = n.length; i > e; e++)n[e].complete && o++;
                    return o / i
                }, _stopLoadingImages: function (t) {
                    var e, i, n, s = Array.prototype.slice.call(t.getElementsByTagName("img"));
                    for (e = 0, i = s.length; i > e; e++)n = s[e], n.complete || (n.onload = o.Util.falseFn, n.onerror = o.Util.falseFn, n.src = o.Util.emptyImageUrl, n.parentNode.removeChild(n))
                }
            }), o.Map.include({
                _defaultLocateOptions: {watch: !1, setView: !1, maxZoom: 1 / 0, timeout: 1e4, maximumAge: 0, enableHighAccuracy: !1}, locate: function (t) {
                    if (t = this._locateOptions = o.extend(this._defaultLocateOptions, t), !navigator.geolocation)return this._handleGeolocationError({code: 0, message: "Geolocation not supported."}), this;
                    var e = o.bind(this._handleGeolocationResponse, this), i = o.bind(this._handleGeolocationError, this);
                    return t.watch ? this._locationWatchId = navigator.geolocation.watchPosition(e, i, t) : navigator.geolocation.getCurrentPosition(e, i, t), this
                }, stopLocate: function () {
                    return navigator.geolocation && navigator.geolocation.clearWatch(this._locationWatchId), this._locateOptions && (this._locateOptions.setView = !1), this
                }, _handleGeolocationError: function (t) {
                    var e = t.code, i = t.message || (1 === e ? "permission denied" : 2 === e ? "position unavailable" : "timeout");
                    this._locateOptions.setView && !this._loaded && this.fitWorld(), this.fire("locationerror", {code: e, message: "Geolocation error: " + i + "."})
                }, _handleGeolocationResponse: function (t) {
                    var e = t.coords.latitude, i = t.coords.longitude, n = new o.LatLng(e, i), s = 180 * t.coords.accuracy / 40075017, a = s / Math.cos(o.LatLng.DEG_TO_RAD * e), r = o.latLngBounds([e - s, i - a], [e + s, i + a]), h = this._locateOptions;
                    if (h.setView) {
                        var l = Math.min(this.getBoundsZoom(r), h.maxZoom);
                        this.setView(n, l)
                    }
                    var u = {latlng: n, bounds: r, timestamp: t.timestamp};
                    for (var c in t.coords)"number" == typeof t.coords[c] && (u[c] = t.coords[c]);
                    this.fire("locationfound", u)
                }
            })
        }(window, document);
    }, {}], 4: [function (require, module, exports) {
        !function (e, t) {
            "object" == typeof exports && exports && "string" != typeof exports.nodeName ? t(exports) : "function" == typeof define && define.amd ? define(["exports"], t) : (e.Mustache = {}, t(e.Mustache))
        }(this, function (e) {
            function t(e) {
                return "function" == typeof e
            }

            function n(e) {
                return g(e) ? "array" : typeof e
            }

            function r(e) {
                return e.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&")
            }

            function i(e, t) {
                return null != e && "object" == typeof e && t in e
            }

            function o(e, t) {
                return v.call(e, t)
            }

            function s(e) {
                return !o(w, e)
            }

            function a(e) {
                return String(e).replace(/[&<>"'`=\/]/g, function (e) {
                    return y[e]
                })
            }

            function u(t, n) {
                function i() {
                    if (w && !y)for (; v.length;)delete d[v.pop()]; else v = [];
                    w = !1, y = !1
                }

                function o(e) {
                    if ("string" == typeof e && (e = e.split(k, 2)), !g(e) || 2 !== e.length)throw new Error("Invalid tags: " + e);
                    a = new RegExp(r(e[0]) + "\\s*"), u = new RegExp("\\s*" + r(e[1])), h = new RegExp("\\s*" + r("}" + e[1]))
                }

                if (!t)return [];
                var a, u, h, f = [], d = [], v = [], w = !1, y = !1;
                o(n || e.tags);
                for (var U, T, j, S, V, C, A = new l(t); !A.eos();) {
                    if (U = A.pos, j = A.scanUntil(a))for (var I = 0, R = j.length; R > I; ++I)S = j.charAt(I), s(S) ? v.push(d.length) : y = !0, d.push(["text", S, U, U + 1]), U += 1, "\n" === S && i();
                    if (!A.scan(a))break;
                    if (w = !0, T = A.scan(E) || "name", A.scan(x), "=" === T ? (j = A.scanUntil(b), A.scan(b), A.scanUntil(u)) : "{" === T ? (j = A.scanUntil(h), A.scan(m), A.scanUntil(u), T = "&") : j = A.scanUntil(u), !A.scan(u))throw new Error("Unclosed tag at " + A.pos);
                    if (V = [T, j, U, A.pos], d.push(V), "#" === T || "^" === T) f.push(V); else if ("/" === T) {
                        if (C = f.pop(), !C)throw new Error('Unopened section "' + j + '" at ' + U);
                        if (C[1] !== j)throw new Error('Unclosed section "' + C[1] + '" at ' + U)
                    } else"name" === T || "{" === T || "&" === T ? y = !0 : "=" === T && o(j)
                }
                if (C = f.pop())throw new Error('Unclosed section "' + C[1] + '" at ' + A.pos);
                return p(c(d))
            }

            function c(e) {
                for (var t, n, r = [], i = 0, o = e.length; o > i; ++i)t = e[i], t && ("text" === t[0] && n && "text" === n[0] ? (n[1] += t[1], n[3] = t[3]) : (r.push(t), n = t));
                return r
            }

            function p(e) {
                for (var t, n, r = [], i = r, o = [], s = 0, a = e.length; a > s; ++s)switch (t = e[s], t[0]) {
                    case"#":
                    case"^":
                        i.push(t), o.push(t), i = t[4] = [];
                        break;
                    case"/":
                        n = o.pop(), n[5] = t[2], i = o.length > 0 ? o[o.length - 1][4] : r;
                        break;
                    default:
                        i.push(t)
                }
                return r
            }

            function l(e) {
                this.string = e, this.tail = e, this.pos = 0
            }

            function h(e, t) {
                this.view = e, this.cache = {".": this.view}, this.parent = t
            }

            function f() {
                this.cache = {}
            }

            var d = Object.prototype.toString, g = Array.isArray || function (e) {
                    return "[object Array]" === d.call(e)
                }, v = RegExp.prototype.test, w = /\S/, y = {"&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;", "/": "&#x2F;", "`": "&#x60;", "=": "&#x3D;"}, x = /\s*/, k = /\s+/, b = /\s*=/, m = /\s*\}/, E = /#|\^|\/|>|\{|&|=|!/;
            l.prototype.eos = function () {
                return "" === this.tail
            }, l.prototype.scan = function (e) {
                var t = this.tail.match(e);
                if (!t || 0 !== t.index)return "";
                var n = t[0];
                return this.tail = this.tail.substring(n.length), this.pos += n.length, n
            }, l.prototype.scanUntil = function (e) {
                var t, n = this.tail.search(e);
                switch (n) {
                    case-1:
                        t = this.tail, this.tail = "";
                        break;
                    case 0:
                        t = "";
                        break;
                    default:
                        t = this.tail.substring(0, n), this.tail = this.tail.substring(n)
                }
                return this.pos += t.length, t
            }, h.prototype.push = function (e) {
                return new h(e, this)
            }, h.prototype.lookup = function (e) {
                var n, r = this.cache;
                if (r.hasOwnProperty(e)) n = r[e]; else {
                    for (var o, s, a = this, u = !1; a;) {
                        if (e.indexOf(".") > 0)for (n = a.view, o = e.split("."), s = 0; null != n && s < o.length;)s === o.length - 1 && (u = i(n, o[s])), n = n[o[s++]]; else n = a.view[e], u = i(a.view, e);
                        if (u)break;
                        a = a.parent
                    }
                    r[e] = n
                }
                return t(n) && (n = n.call(this.view)), n
            }, f.prototype.clearCache = function () {
                this.cache = {}
            }, f.prototype.parse = function (e, t) {
                var n = this.cache, r = n[e];
                return null == r && (r = n[e] = u(e, t)), r
            }, f.prototype.render = function (e, t, n) {
                var r = this.parse(e), i = t instanceof h ? t : new h(t);
                return this.renderTokens(r, i, n, e)
            }, f.prototype.renderTokens = function (e, t, n, r) {
                for (var i, o, s, a = "", u = 0, c = e.length; c > u; ++u)s = void 0, i = e[u], o = i[0], "#" === o ? s = this.renderSection(i, t, n, r) : "^" === o ? s = this.renderInverted(i, t, n, r) : ">" === o ? s = this.renderPartial(i, t, n, r) : "&" === o ? s = this.unescapedValue(i, t) : "name" === o ? s = this.escapedValue(i, t) : "text" === o && (s = this.rawValue(i)), void 0 !== s && (a += s);
                return a
            }, f.prototype.renderSection = function (e, n, r, i) {
                function o(e) {
                    return s.render(e, n, r)
                }

                var s = this, a = "", u = n.lookup(e[1]);
                if (u) {
                    if (g(u))for (var c = 0, p = u.length; p > c; ++c)a += this.renderTokens(e[4], n.push(u[c]), r, i); else if ("object" == typeof u || "string" == typeof u || "number" == typeof u) a += this.renderTokens(e[4], n.push(u), r, i); else if (t(u)) {
                        if ("string" != typeof i)throw new Error("Cannot use higher-order sections without the original template");
                        u = u.call(n.view, i.slice(e[3], e[5]), o), null != u && (a += u)
                    } else a += this.renderTokens(e[4], n, r, i);
                    return a
                }
            }, f.prototype.renderInverted = function (e, t, n, r) {
                var i = t.lookup(e[1]);
                return !i || g(i) && 0 === i.length ? this.renderTokens(e[4], t, n, r) : void 0
            }, f.prototype.renderPartial = function (e, n, r) {
                if (r) {
                    var i = t(r) ? r(e[1]) : r[e[1]];
                    return null != i ? this.renderTokens(this.parse(i), n, r, i) : void 0
                }
            }, f.prototype.unescapedValue = function (e, t) {
                var n = t.lookup(e[1]);
                return null != n ? n : void 0
            }, f.prototype.escapedValue = function (t, n) {
                var r = n.lookup(t[1]);
                return null != r ? e.escape(r) : void 0
            }, f.prototype.rawValue = function (e) {
                return e[1]
            }, e.name = "mustache.js", e.version = "2.2.1", e.tags = ["{{", "}}"];
            var U = new f;
            e.clearCache = function () {
                return U.clearCache()
            }, e.parse = function (e, t) {
                return U.parse(e, t)
            }, e.render = function (e, t, r) {
                if ("string" != typeof e)throw new TypeError('Invalid template! Template should be a "string" but "' + n(e) + '" was given as the first argument for mustache#render(template, view, partials)');
                return U.render(e, t, r)
            }, e.to_html = function (n, r, i, o) {
                var s = e.render(n, r, i);
                return t(o) ? void o(s) : s
            }, e.escape = a, e.Scanner = l, e.Context = h, e.Writer = f
        });
    }, {}], 5: [function (require, module, exports) {
        function cleanUrl(t) {
            "use strict";
            return /^https?/.test(t.getScheme()) ? t.toString() : /^mailto?/.test(t.getScheme()) ? t.toString() : "data" == t.getScheme() && /^image/.test(t.getPath()) ? t.toString() : void 0
        }

        function cleanId(t) {
            return t
        }

        var html_sanitize = require("./sanitizer-bundle.js");
        module.exports = function (t) {
            return t ? html_sanitize(t, cleanUrl, cleanId) : ""
        };
    }, {"./sanitizer-bundle.js": 6}], 6: [function (require, module, exports) {
        var URI = function () {
            function e(e) {
                var t = ("" + e).match(p);
                return t ? new s(c(t[1]), c(t[2]), c(t[3]), c(t[4]), c(t[5]), c(t[6]), c(t[7])) : null
            }

            function t(e, t, o, i, l, c, m) {
                var u = new s(n(e, d), n(t, d), a(o), i > 0 ? i.toString() : null, n(l, f), null, a(m));
                return c && ("string" == typeof c ? u.setRawQuery(c.replace(/[^?&=0-9A-Za-z_\-~.%]/g, r)) : u.setAllParameters(c)), u
            }

            function a(e) {
                return "string" == typeof e ? encodeURIComponent(e) : null
            }

            function n(e, t) {
                return "string" == typeof e ? encodeURI(e).replace(t, r) : null
            }

            function r(e) {
                var t = e.charCodeAt(0);
                return "%" + "0123456789ABCDEF".charAt(t >> 4 & 15) + "0123456789ABCDEF".charAt(15 & t)
            }

            function o(e) {
                return e.replace(/(^|\/)\.(?:\/|$)/g, "$1").replace(/\/{2,}/g, "/")
            }

            function i(e) {
                if (null === e)return null;
                for (var t, a = o(e), n = u; (t = a.replace(n, "$1")) != a; a = t);
                return a
            }

            function l(e, t) {
                var a = e.clone(), n = t.hasScheme();
                n ? a.setRawScheme(t.getRawScheme()) : n = t.hasCredentials(), n ? a.setRawCredentials(t.getRawCredentials()) : n = t.hasDomain(), n ? a.setRawDomain(t.getRawDomain()) : n = t.hasPort();
                var r = t.getRawPath(), o = i(r);
                if (n) a.setPort(t.getPort()), o = o && o.replace(h, ""); else if (n = !!r) {
                    if (47 !== o.charCodeAt(0)) {
                        var l = i(a.getRawPath() || "").replace(h, ""), s = l.lastIndexOf("/") + 1;
                        o = i((s ? l.substring(0, s) : "") + i(r)).replace(h, "")
                    }
                } else o = o && o.replace(h, ""), o !== r && a.setRawPath(o);
                return n ? a.setRawPath(o) : n = t.hasQuery(), n ? a.setRawQuery(t.getRawQuery()) : n = t.hasFragment(), n && a.setRawFragment(t.getRawFragment()), a
            }

            function s(e, t, a, n, r, o, i) {
                this.scheme_ = e, this.credentials_ = t, this.domain_ = a, this.port_ = n, this.path_ = r, this.query_ = o, this.fragment_ = i, this.paramCache_ = null
            }

            function c(e) {
                return "string" == typeof e && e.length > 0 ? e : null
            }

            var m = new RegExp("(/|^)(?:[^./][^/]*|\\.{2,}(?:[^./][^/]*)|\\.{3,}[^/]*)/\\.\\.(?:/|$)"), u = new RegExp(m), h = /^(?:\.\.\/)*(?:\.\.$)?/;
            s.prototype.toString = function () {
                var e = [];
                return null !== this.scheme_ && e.push(this.scheme_, ":"), null !== this.domain_ && (e.push("//"), null !== this.credentials_ && e.push(this.credentials_, "@"), e.push(this.domain_), null !== this.port_ && e.push(":", this.port_.toString())), null !== this.path_ && e.push(this.path_), null !== this.query_ && e.push("?", this.query_), null !== this.fragment_ && e.push("#", this.fragment_), e.join("")
            }, s.prototype.clone = function () {
                return new s(this.scheme_, this.credentials_, this.domain_, this.port_, this.path_, this.query_, this.fragment_)
            }, s.prototype.getScheme = function () {
                return this.scheme_ && decodeURIComponent(this.scheme_).toLowerCase()
            }, s.prototype.getRawScheme = function () {
                return this.scheme_
            }, s.prototype.setScheme = function (e) {
                return this.scheme_ = n(e, d), this
            }, s.prototype.setRawScheme = function (e) {
                return this.scheme_ = e ? e : null, this
            }, s.prototype.hasScheme = function () {
                return null !== this.scheme_
            }, s.prototype.getCredentials = function () {
                return this.credentials_ && decodeURIComponent(this.credentials_)
            }, s.prototype.getRawCredentials = function () {
                return this.credentials_
            }, s.prototype.setCredentials = function (e) {
                return this.credentials_ = n(e, d), this
            }, s.prototype.setRawCredentials = function (e) {
                return this.credentials_ = e ? e : null, this
            }, s.prototype.hasCredentials = function () {
                return null !== this.credentials_
            }, s.prototype.getDomain = function () {
                return this.domain_ && decodeURIComponent(this.domain_)
            }, s.prototype.getRawDomain = function () {
                return this.domain_
            }, s.prototype.setDomain = function (e) {
                return this.setRawDomain(e && encodeURIComponent(e))
            }, s.prototype.setRawDomain = function (e) {
                return this.domain_ = e ? e : null, this.setRawPath(this.path_)
            }, s.prototype.hasDomain = function () {
                return null !== this.domain_
            }, s.prototype.getPort = function () {
                return this.port_ && decodeURIComponent(this.port_)
            }, s.prototype.setPort = function (e) {
                if (e) {
                    if (e = Number(e), e !== (65535 & e))throw new Error("Bad port number " + e);
                    this.port_ = "" + e
                } else this.port_ = null;
                return this
            }, s.prototype.hasPort = function () {
                return null !== this.port_
            }, s.prototype.getPath = function () {
                return this.path_ && decodeURIComponent(this.path_)
            }, s.prototype.getRawPath = function () {
                return this.path_
            }, s.prototype.setPath = function (e) {
                return this.setRawPath(n(e, f))
            }, s.prototype.setRawPath = function (e) {
                return e ? (e = String(e), this.path_ = !this.domain_ || /^\//.test(e) ? e : "/" + e) : this.path_ = null, this
            }, s.prototype.hasPath = function () {
                return null !== this.path_
            }, s.prototype.getQuery = function () {
                return this.query_ && decodeURIComponent(this.query_).replace(/\+/g, " ")
            }, s.prototype.getRawQuery = function () {
                return this.query_
            }, s.prototype.setQuery = function (e) {
                return this.paramCache_ = null, this.query_ = a(e), this
            }, s.prototype.setRawQuery = function (e) {
                return this.paramCache_ = null, this.query_ = e ? e : null, this
            }, s.prototype.hasQuery = function () {
                return null !== this.query_
            }, s.prototype.setAllParameters = function (e) {
                if ("object" == typeof e && !(e instanceof Array) && (e instanceof Object || "[object Array]" !== Object.prototype.toString.call(e))) {
                    var t = [], a = -1;
                    for (var n in e) {
                        var r = e[n];
                        "string" == typeof r && (t[++a] = n, t[++a] = r)
                    }
                    e = t
                }
                this.paramCache_ = null;
                for (var o = [], i = "", l = 0; l < e.length;) {
                    var n = e[l++], r = e[l++];
                    o.push(i, encodeURIComponent(n.toString())), i = "&", r && o.push("=", encodeURIComponent(r.toString()))
                }
                return this.query_ = o.join(""), this
            }, s.prototype.checkParameterCache_ = function () {
                if (!this.paramCache_) {
                    var e = this.query_;
                    if (e) {
                        for (var t = e.split(/[&\?]/), a = [], n = -1, r = 0; r < t.length; ++r) {
                            var o = t[r].match(/^([^=]*)(?:=(.*))?$/);
                            a[++n] = decodeURIComponent(o[1]).replace(/\+/g, " "), a[++n] = decodeURIComponent(o[2] || "").replace(/\+/g, " ")
                        }
                        this.paramCache_ = a
                    } else this.paramCache_ = []
                }
            }, s.prototype.setParameterValues = function (e, t) {
                "string" == typeof t && (t = [t]), this.checkParameterCache_();
                for (var a = 0, n = this.paramCache_, r = [], o = 0; o < n.length; o += 2)e === n[o] ? a < t.length && r.push(e, t[a++]) : r.push(n[o], n[o + 1]);
                for (; a < t.length;)r.push(e, t[a++]);
                return this.setAllParameters(r), this
            }, s.prototype.removeParameter = function (e) {
                return this.setParameterValues(e, [])
            }, s.prototype.getAllParameters = function () {
                return this.checkParameterCache_(), this.paramCache_.slice(0, this.paramCache_.length)
            }, s.prototype.getParameterValues = function (e) {
                this.checkParameterCache_();
                for (var t = [], a = 0; a < this.paramCache_.length; a += 2)e === this.paramCache_[a] && t.push(this.paramCache_[a + 1]);
                return t
            }, s.prototype.getParameterMap = function (e) {
                this.checkParameterCache_();
                for (var t = {}, a = 0; a < this.paramCache_.length; a += 2) {
                    var n = this.paramCache_[a++], r = this.paramCache_[a++];
                    n in t ? t[n].push(r) : t[n] = [r]
                }
                return t
            }, s.prototype.getParameterValue = function (e) {
                this.checkParameterCache_();
                for (var t = 0; t < this.paramCache_.length; t += 2)if (e === this.paramCache_[t])return this.paramCache_[t + 1];
                return null
            }, s.prototype.getFragment = function () {
                return this.fragment_ && decodeURIComponent(this.fragment_)
            }, s.prototype.getRawFragment = function () {
                return this.fragment_
            }, s.prototype.setFragment = function (e) {
                return this.fragment_ = e ? encodeURIComponent(e) : null, this
            }, s.prototype.setRawFragment = function (e) {
                return this.fragment_ = e ? e : null, this
            }, s.prototype.hasFragment = function () {
                return null !== this.fragment_
            };
            var p = new RegExp("^(?:([^:/?#]+):)?(?://(?:([^/?#]*)@)?([^/?#:@]*)(?::([0-9]+))?)?([^?#]+)?(?:\\?([^#]*))?(?:#(.*))?$"), d = /[#\/\?@]/g, f = /[\#\?]/g;
            return s.parse = e, s.create = t, s.resolve = l, s.collapse_dots = i, s.utils = {
                mimeTypeOf: function (t) {
                    var a = e(t);
                    return /\.html$/.test(a.getPath()) ? "text/html" : "application/javascript"
                }, resolve: function (t, a) {
                    return t ? l(e(t), e(a)).toString() : "" + a
                }
            }, s
        }(), html4 = {};
        if (html4.atype = {NONE: 0, URI: 1, URI_FRAGMENT: 11, SCRIPT: 2, STYLE: 3, HTML: 12, ID: 4, IDREF: 5, IDREFS: 6, GLOBAL_NAME: 7, LOCAL_NAME: 8, CLASSES: 9, FRAME_TARGET: 10, MEDIA_QUERY: 13}, html4.atype = html4.atype, html4.ATTRIBS = {
                "*::class": 9,
                "*::dir": 0,
                "*::draggable": 0,
                "*::hidden": 0,
                "*::id": 4,
                "*::inert": 0,
                "*::itemprop": 0,
                "*::itemref": 6,
                "*::itemscope": 0,
                "*::lang": 0,
                "*::onblur": 2,
                "*::onchange": 2,
                "*::onclick": 2,
                "*::ondblclick": 2,
                "*::onfocus": 2,
                "*::onkeydown": 2,
                "*::onkeypress": 2,
                "*::onkeyup": 2,
                "*::onload": 2,
                "*::onmousedown": 2,
                "*::onmousemove": 2,
                "*::onmouseout": 2,
                "*::onmouseover": 2,
                "*::onmouseup": 2,
                "*::onreset": 2,
                "*::onscroll": 2,
                "*::onselect": 2,
                "*::onsubmit": 2,
                "*::onunload": 2,
                "*::spellcheck": 0,
                "*::style": 3,
                "*::title": 0,
                "*::translate": 0,
                "a::accesskey": 0,
                "a::coords": 0,
                "a::href": 1,
                "a::hreflang": 0,
                "a::name": 7,
                "a::onblur": 2,
                "a::onfocus": 2,
                "a::shape": 0,
                "a::tabindex": 0,
                "a::target": 10,
                "a::type": 0,
                "area::accesskey": 0,
                "area::alt": 0,
                "area::coords": 0,
                "area::href": 1,
                "area::nohref": 0,
                "area::onblur": 2,
                "area::onfocus": 2,
                "area::shape": 0,
                "area::tabindex": 0,
                "area::target": 10,
                "audio::controls": 0,
                "audio::loop": 0,
                "audio::mediagroup": 5,
                "audio::muted": 0,
                "audio::preload": 0,
                "bdo::dir": 0,
                "blockquote::cite": 1,
                "br::clear": 0,
                "button::accesskey": 0,
                "button::disabled": 0,
                "button::name": 8,
                "button::onblur": 2,
                "button::onfocus": 2,
                "button::tabindex": 0,
                "button::type": 0,
                "button::value": 0,
                "canvas::height": 0,
                "canvas::width": 0,
                "caption::align": 0,
                "col::align": 0,
                "col::char": 0,
                "col::charoff": 0,
                "col::span": 0,
                "col::valign": 0,
                "col::width": 0,
                "colgroup::align": 0,
                "colgroup::char": 0,
                "colgroup::charoff": 0,
                "colgroup::span": 0,
                "colgroup::valign": 0,
                "colgroup::width": 0,
                "command::checked": 0,
                "command::command": 5,
                "command::disabled": 0,
                "command::icon": 1,
                "command::label": 0,
                "command::radiogroup": 0,
                "command::type": 0,
                "data::value": 0,
                "del::cite": 1,
                "del::datetime": 0,
                "details::open": 0,
                "dir::compact": 0,
                "div::align": 0,
                "dl::compact": 0,
                "fieldset::disabled": 0,
                "font::color": 0,
                "font::face": 0,
                "font::size": 0,
                "form::accept": 0,
                "form::action": 1,
                "form::autocomplete": 0,
                "form::enctype": 0,
                "form::method": 0,
                "form::name": 7,
                "form::novalidate": 0,
                "form::onreset": 2,
                "form::onsubmit": 2,
                "form::target": 10,
                "h1::align": 0,
                "h2::align": 0,
                "h3::align": 0,
                "h4::align": 0,
                "h5::align": 0,
                "h6::align": 0,
                "hr::align": 0,
                "hr::noshade": 0,
                "hr::size": 0,
                "hr::width": 0,
                "iframe::align": 0,
                "iframe::frameborder": 0,
                "iframe::height": 0,
                "iframe::marginheight": 0,
                "iframe::marginwidth": 0,
                "iframe::width": 0,
                "img::align": 0,
                "img::alt": 0,
                "img::border": 0,
                "img::height": 0,
                "img::hspace": 0,
                "img::ismap": 0,
                "img::name": 7,
                "img::src": 1,
                "img::usemap": 11,
                "img::vspace": 0,
                "img::width": 0,
                "input::accept": 0,
                "input::accesskey": 0,
                "input::align": 0,
                "input::alt": 0,
                "input::autocomplete": 0,
                "input::checked": 0,
                "input::disabled": 0,
                "input::inputmode": 0,
                "input::ismap": 0,
                "input::list": 5,
                "input::max": 0,
                "input::maxlength": 0,
                "input::min": 0,
                "input::multiple": 0,
                "input::name": 8,
                "input::onblur": 2,
                "input::onchange": 2,
                "input::onfocus": 2,
                "input::onselect": 2,
                "input::placeholder": 0,
                "input::readonly": 0,
                "input::required": 0,
                "input::size": 0,
                "input::src": 1,
                "input::step": 0,
                "input::tabindex": 0,
                "input::type": 0,
                "input::usemap": 11,
                "input::value": 0,
                "ins::cite": 1,
                "ins::datetime": 0,
                "label::accesskey": 0,
                "label::for": 5,
                "label::onblur": 2,
                "label::onfocus": 2,
                "legend::accesskey": 0,
                "legend::align": 0,
                "li::type": 0,
                "li::value": 0,
                "map::name": 7,
                "menu::compact": 0,
                "menu::label": 0,
                "menu::type": 0,
                "meter::high": 0,
                "meter::low": 0,
                "meter::max": 0,
                "meter::min": 0,
                "meter::value": 0,
                "ol::compact": 0,
                "ol::reversed": 0,
                "ol::start": 0,
                "ol::type": 0,
                "optgroup::disabled": 0,
                "optgroup::label": 0,
                "option::disabled": 0,
                "option::label": 0,
                "option::selected": 0,
                "option::value": 0,
                "output::for": 6,
                "output::name": 8,
                "p::align": 0,
                "pre::width": 0,
                "progress::max": 0,
                "progress::min": 0,
                "progress::value": 0,
                "q::cite": 1,
                "select::autocomplete": 0,
                "select::disabled": 0,
                "select::multiple": 0,
                "select::name": 8,
                "select::onblur": 2,
                "select::onchange": 2,
                "select::onfocus": 2,
                "select::required": 0,
                "select::size": 0,
                "select::tabindex": 0,
                "source::type": 0,
                "table::align": 0,
                "table::bgcolor": 0,
                "table::border": 0,
                "table::cellpadding": 0,
                "table::cellspacing": 0,
                "table::frame": 0,
                "table::rules": 0,
                "table::summary": 0,
                "table::width": 0,
                "tbody::align": 0,
                "tbody::char": 0,
                "tbody::charoff": 0,
                "tbody::valign": 0,
                "td::abbr": 0,
                "td::align": 0,
                "td::axis": 0,
                "td::bgcolor": 0,
                "td::char": 0,
                "td::charoff": 0,
                "td::colspan": 0,
                "td::headers": 6,
                "td::height": 0,
                "td::nowrap": 0,
                "td::rowspan": 0,
                "td::scope": 0,
                "td::valign": 0,
                "td::width": 0,
                "textarea::accesskey": 0,
                "textarea::autocomplete": 0,
                "textarea::cols": 0,
                "textarea::disabled": 0,
                "textarea::inputmode": 0,
                "textarea::name": 8,
                "textarea::onblur": 2,
                "textarea::onchange": 2,
                "textarea::onfocus": 2,
                "textarea::onselect": 2,
                "textarea::placeholder": 0,
                "textarea::readonly": 0,
                "textarea::required": 0,
                "textarea::rows": 0,
                "textarea::tabindex": 0,
                "textarea::wrap": 0,
                "tfoot::align": 0,
                "tfoot::char": 0,
                "tfoot::charoff": 0,
                "tfoot::valign": 0,
                "th::abbr": 0,
                "th::align": 0,
                "th::axis": 0,
                "th::bgcolor": 0,
                "th::char": 0,
                "th::charoff": 0,
                "th::colspan": 0,
                "th::headers": 6,
                "th::height": 0,
                "th::nowrap": 0,
                "th::rowspan": 0,
                "th::scope": 0,
                "th::valign": 0,
                "th::width": 0,
                "thead::align": 0,
                "thead::char": 0,
                "thead::charoff": 0,
                "thead::valign": 0,
                "tr::align": 0,
                "tr::bgcolor": 0,
                "tr::char": 0,
                "tr::charoff": 0,
                "tr::valign": 0,
                "track::default": 0,
                "track::kind": 0,
                "track::label": 0,
                "track::srclang": 0,
                "ul::compact": 0,
                "ul::type": 0,
                "video::controls": 0,
                "video::height": 0,
                "video::loop": 0,
                "video::mediagroup": 5,
                "video::muted": 0,
                "video::poster": 1,
                "video::preload": 0,
                "video::width": 0
            }, html4.ATTRIBS = html4.ATTRIBS, html4.eflags = {OPTIONAL_ENDTAG: 1, EMPTY: 2, CDATA: 4, RCDATA: 8, UNSAFE: 16, FOLDABLE: 32, SCRIPT: 64, STYLE: 128, VIRTUALIZED: 256}, html4.eflags = html4.eflags, html4.ELEMENTS = {
                a: 0,
                abbr: 0,
                acronym: 0,
                address: 0,
                applet: 272,
                area: 2,
                article: 0,
                aside: 0,
                audio: 0,
                b: 0,
                base: 274,
                basefont: 274,
                bdi: 0,
                bdo: 0,
                big: 0,
                blockquote: 0,
                body: 305,
                br: 2,
                button: 0,
                canvas: 0,
                caption: 0,
                center: 0,
                cite: 0,
                code: 0,
                col: 2,
                colgroup: 1,
                command: 2,
                data: 0,
                datalist: 0,
                dd: 1,
                del: 0,
                details: 0,
                dfn: 0,
                dialog: 272,
                dir: 0,
                div: 0,
                dl: 0,
                dt: 1,
                em: 0,
                fieldset: 0,
                figcaption: 0,
                figure: 0,
                font: 0,
                footer: 0,
                form: 0,
                frame: 274,
                frameset: 272,
                h1: 0,
                h2: 0,
                h3: 0,
                h4: 0,
                h5: 0,
                h6: 0,
                head: 305,
                header: 0,
                hgroup: 0,
                hr: 2,
                html: 305,
                i: 0,
                iframe: 16,
                img: 2,
                input: 2,
                ins: 0,
                isindex: 274,
                kbd: 0,
                keygen: 274,
                label: 0,
                legend: 0,
                li: 1,
                link: 274,
                map: 0,
                mark: 0,
                menu: 0,
                meta: 274,
                meter: 0,
                nav: 0,
                nobr: 0,
                noembed: 276,
                noframes: 276,
                noscript: 276,
                object: 272,
                ol: 0,
                optgroup: 0,
                option: 1,
                output: 0,
                p: 1,
                param: 274,
                pre: 0,
                progress: 0,
                q: 0,
                s: 0,
                samp: 0,
                script: 84,
                section: 0,
                select: 0,
                small: 0,
                source: 2,
                span: 0,
                strike: 0,
                strong: 0,
                style: 148,
                sub: 0,
                summary: 0,
                sup: 0,
                table: 0,
                tbody: 1,
                td: 1,
                textarea: 8,
                tfoot: 1,
                th: 1,
                thead: 1,
                time: 0,
                title: 280,
                tr: 1,
                track: 2,
                tt: 0,
                u: 0,
                ul: 0,
                "var": 0,
                video: 0,
                wbr: 2
            }, html4.ELEMENTS = html4.ELEMENTS, html4.ELEMENT_DOM_INTERFACES = {
                a: "HTMLAnchorElement",
                abbr: "HTMLElement",
                acronym: "HTMLElement",
                address: "HTMLElement",
                applet: "HTMLAppletElement",
                area: "HTMLAreaElement",
                article: "HTMLElement",
                aside: "HTMLElement",
                audio: "HTMLAudioElement",
                b: "HTMLElement",
                base: "HTMLBaseElement",
                basefont: "HTMLBaseFontElement",
                bdi: "HTMLElement",
                bdo: "HTMLElement",
                big: "HTMLElement",
                blockquote: "HTMLQuoteElement",
                body: "HTMLBodyElement",
                br: "HTMLBRElement",
                button: "HTMLButtonElement",
                canvas: "HTMLCanvasElement",
                caption: "HTMLTableCaptionElement",
                center: "HTMLElement",
                cite: "HTMLElement",
                code: "HTMLElement",
                col: "HTMLTableColElement",
                colgroup: "HTMLTableColElement",
                command: "HTMLCommandElement",
                data: "HTMLElement",
                datalist: "HTMLDataListElement",
                dd: "HTMLElement",
                del: "HTMLModElement",
                details: "HTMLDetailsElement",
                dfn: "HTMLElement",
                dialog: "HTMLDialogElement",
                dir: "HTMLDirectoryElement",
                div: "HTMLDivElement",
                dl: "HTMLDListElement",
                dt: "HTMLElement",
                em: "HTMLElement",
                fieldset: "HTMLFieldSetElement",
                figcaption: "HTMLElement",
                figure: "HTMLElement",
                font: "HTMLFontElement",
                footer: "HTMLElement",
                form: "HTMLFormElement",
                frame: "HTMLFrameElement",
                frameset: "HTMLFrameSetElement",
                h1: "HTMLHeadingElement",
                h2: "HTMLHeadingElement",
                h3: "HTMLHeadingElement",
                h4: "HTMLHeadingElement",
                h5: "HTMLHeadingElement",
                h6: "HTMLHeadingElement",
                head: "HTMLHeadElement",
                header: "HTMLElement",
                hgroup: "HTMLElement",
                hr: "HTMLHRElement",
                html: "HTMLHtmlElement",
                i: "HTMLElement",
                iframe: "HTMLIFrameElement",
                img: "HTMLImageElement",
                input: "HTMLInputElement",
                ins: "HTMLModElement",
                isindex: "HTMLUnknownElement",
                kbd: "HTMLElement",
                keygen: "HTMLKeygenElement",
                label: "HTMLLabelElement",
                legend: "HTMLLegendElement",
                li: "HTMLLIElement",
                link: "HTMLLinkElement",
                map: "HTMLMapElement",
                mark: "HTMLElement",
                menu: "HTMLMenuElement",
                meta: "HTMLMetaElement",
                meter: "HTMLMeterElement",
                nav: "HTMLElement",
                nobr: "HTMLElement",
                noembed: "HTMLElement",
                noframes: "HTMLElement",
                noscript: "HTMLElement",
                object: "HTMLObjectElement",
                ol: "HTMLOListElement",
                optgroup: "HTMLOptGroupElement",
                option: "HTMLOptionElement",
                output: "HTMLOutputElement",
                p: "HTMLParagraphElement",
                param: "HTMLParamElement",
                pre: "HTMLPreElement",
                progress: "HTMLProgressElement",
                q: "HTMLQuoteElement",
                s: "HTMLElement",
                samp: "HTMLElement",
                script: "HTMLScriptElement",
                section: "HTMLElement",
                select: "HTMLSelectElement",
                small: "HTMLElement",
                source: "HTMLSourceElement",
                span: "HTMLSpanElement",
                strike: "HTMLElement",
                strong: "HTMLElement",
                style: "HTMLStyleElement",
                sub: "HTMLElement",
                summary: "HTMLElement",
                sup: "HTMLElement",
                table: "HTMLTableElement",
                tbody: "HTMLTableSectionElement",
                td: "HTMLTableDataCellElement",
                textarea: "HTMLTextAreaElement",
                tfoot: "HTMLTableSectionElement",
                th: "HTMLTableHeaderCellElement",
                thead: "HTMLTableSectionElement",
                time: "HTMLTimeElement",
                title: "HTMLTitleElement",
                tr: "HTMLTableRowElement",
                track: "HTMLTrackElement",
                tt: "HTMLElement",
                u: "HTMLElement",
                ul: "HTMLUListElement",
                "var": "HTMLElement",
                video: "HTMLVideoElement",
                wbr: "HTMLElement"
            }, html4.ELEMENT_DOM_INTERFACES = html4.ELEMENT_DOM_INTERFACES, html4.ueffects = {NOT_LOADED: 0, SAME_DOCUMENT: 1, NEW_DOCUMENT: 2}, html4.ueffects = html4.ueffects, html4.URIEFFECTS = {"a::href": 2, "area::href": 2, "blockquote::cite": 0, "command::icon": 1, "del::cite": 0, "form::action": 2, "img::src": 1, "input::src": 1, "ins::cite": 0, "q::cite": 0, "video::poster": 1}, html4.URIEFFECTS = html4.URIEFFECTS, html4.ltypes = {
                UNSANDBOXED: 2,
                SANDBOXED: 1,
                DATA: 0
            }, html4.ltypes = html4.ltypes, html4.LOADERTYPES = {"a::href": 2, "area::href": 2, "blockquote::cite": 2, "command::icon": 1, "del::cite": 2, "form::action": 2, "img::src": 1, "input::src": 1, "ins::cite": 2, "q::cite": 2, "video::poster": 1}, html4.LOADERTYPES = html4.LOADERTYPES, "i" !== "I".toLowerCase())throw"I/i problem";
        var html = function (e) {
            function t(e) {
                if (S.hasOwnProperty(e))return S[e];
                var t = e.match(P);
                if (t)return String.fromCharCode(parseInt(t[1], 10));
                if (t = e.match(D))return String.fromCharCode(parseInt(t[1], 16));
                if (I && k.test(e)) {
                    I.innerHTML = "&" + e + ";";
                    var a = I.textContent;
                    return S[e] = a, a
                }
                return "&" + e + ";"
            }

            function a(e, a) {
                return t(a)
            }

            function n(e) {
                return e.replace(x, "")
            }

            function r(e) {
                return e.replace(N, a)
            }

            function o(e) {
                return ("" + e).replace(F, "&amp;").replace(B, "&lt;").replace(q, "&gt;").replace(z, "&#34;")
            }

            function i(e) {
                return e.replace(U, "&amp;$1").replace(B, "&lt;").replace(q, "&gt;")
            }

            function l(e) {
                var t = {cdata: e.cdata || e.cdata, comment: e.comment || e.comment, endDoc: e.endDoc || e.endDoc, endTag: e.endTag || e.endTag, pcdata: e.pcdata || e.pcdata, rcdata: e.rcdata || e.rcdata, startDoc: e.startDoc || e.startDoc, startTag: e.startTag || e.startTag};
                return function (e, a) {
                    return s(e, t, a)
                }
            }

            function s(e, t, a) {
                var n = u(e), r = {noMoreGT: !1, noMoreEndComments: !1};
                m(t, n, 0, r, a)
            }

            function c(e, t, a, n, r) {
                return function () {
                    m(e, t, a, n, r)
                }
            }

            function m(t, a, n, r, o) {
                try {
                    t.startDoc && 0 == n && t.startDoc(o);
                    for (var i, l, s, m = n, u = a.length; u > m;) {
                        var f = a[m++], g = a[m];
                        switch (f) {
                            case"&":
                                O.test(g) ? (t.pcdata && t.pcdata("&" + g, o, Y, c(t, a, m, r, o)), m++) : t.pcdata && t.pcdata("&amp;", o, Y, c(t, a, m, r, o));
                                break;
                            case"</":
                                (i = /^([-\w:]+)[^\'\"]*/.exec(g)) ? i[0].length === g.length && ">" === a[m + 1] ? (m += 2, s = i[1].toLowerCase(), t.endTag && t.endTag(s, o, Y, c(t, a, m, r, o))) : m = h(a, m, t, o, Y, r) : t.pcdata && t.pcdata("&lt;/", o, Y, c(t, a, m, r, o));
                                break;
                            case"<":
                                if (i = /^([-\w:]+)\s*\/?/.exec(g))if (i[0].length === g.length && ">" === a[m + 1]) {
                                    m += 2, s = i[1].toLowerCase(), t.startTag && t.startTag(s, [], o, Y, c(t, a, m, r, o));
                                    var E = e.ELEMENTS[s];
                                    if (E & j) {
                                        var T = {name: s, next: m, eflags: E};
                                        m = d(a, T, t, o, Y, r)
                                    }
                                } else m = p(a, m, t, o, Y, r); else t.pcdata && t.pcdata("&lt;", o, Y, c(t, a, m, r, o));
                                break;
                            case"<!--":
                                if (!r.noMoreEndComments) {
                                    for (l = m + 1; u > l && (">" !== a[l] || !/--$/.test(a[l - 1])); l++);
                                    if (u > l) {
                                        if (t.comment) {
                                            var L = a.slice(m, l).join("");
                                            t.comment(L.substr(0, L.length - 2), o, Y, c(t, a, l + 1, r, o))
                                        }
                                        m = l + 1
                                    } else r.noMoreEndComments = !0
                                }
                                r.noMoreEndComments && t.pcdata && t.pcdata("&lt;!--", o, Y, c(t, a, m, r, o));
                                break;
                            case"<!":
                                if (/^\w/.test(g)) {
                                    if (!r.noMoreGT) {
                                        for (l = m + 1; u > l && ">" !== a[l]; l++);
                                        u > l ? m = l + 1 : r.noMoreGT = !0
                                    }
                                    r.noMoreGT && t.pcdata && t.pcdata("&lt;!", o, Y, c(t, a, m, r, o))
                                } else t.pcdata && t.pcdata("&lt;!", o, Y, c(t, a, m, r, o));
                                break;
                            case"<?":
                                if (!r.noMoreGT) {
                                    for (l = m + 1; u > l && ">" !== a[l]; l++);
                                    u > l ? m = l + 1 : r.noMoreGT = !0
                                }
                                r.noMoreGT && t.pcdata && t.pcdata("&lt;?", o, Y, c(t, a, m, r, o));
                                break;
                            case">":
                                t.pcdata && t.pcdata("&gt;", o, Y, c(t, a, m, r, o));
                                break;
                            case"":
                                break;
                            default:
                                t.pcdata && t.pcdata(f, o, Y, c(t, a, m, r, o))
                        }
                    }
                    t.endDoc && t.endDoc(o)
                } catch (M) {
                    if (M !== Y)throw M
                }
            }

            function u(e) {
                var t = /(<\/|<\!--|<[!?]|[&<>])/g;
                if (e += "", $)return e.split(t);
                for (var a, n = [], r = 0; null !== (a = t.exec(e));)n.push(e.substring(r, a.index)), n.push(a[0]), r = a.index + a[0].length;
                return n.push(e.substring(r)), n
            }

            function h(e, t, a, n, r, o) {
                var i = f(e, t);
                return i ? (a.endTag && a.endTag(i.name, n, r, c(a, e, t, o, n)), i.next) : e.length
            }

            function p(e, t, a, n, r, o) {
                var i = f(e, t);
                return i ? (a.startTag && a.startTag(i.name, i.attrs, n, r, c(a, e, i.next, o, n)), i.eflags & j ? d(e, i, a, n, r, o) : i.next) : e.length
            }

            function d(t, a, n, r, o, l) {
                var s = t.length;
                Q.hasOwnProperty(a.name) || (Q[a.name] = new RegExp("^" + a.name + "(?:[\\s\\/]|$)", "i"));
                for (var m = Q[a.name], u = a.next, h = a.next + 1; s > h && ("</" !== t[h - 1] || !m.test(t[h])); h++);
                s > h && (h -= 1);
                var p = t.slice(u, h).join("");
                if (a.eflags & e.eflags.CDATA) n.cdata && n.cdata(p, r, o, c(n, t, h, l, r)); else {
                    if (!(a.eflags & e.eflags.RCDATA))throw new Error("bug");
                    n.rcdata && n.rcdata(i(p), r, o, c(n, t, h, l, r))
                }
                return h
            }

            function f(t, a) {
                var n = /^([-\w:]+)/.exec(t[a]), r = {};
                r.name = n[1].toLowerCase(), r.eflags = e.ELEMENTS[r.name];
                for (var o = t[a].substr(n[0].length), i = a + 1, l = t.length; l > i && ">" !== t[i]; i++)o += t[i];
                if (!(i >= l)) {
                    for (var s = []; "" !== o;)if (n = G.exec(o)) {
                        if (n[4] && !n[5] || n[6] && !n[7]) {
                            for (var c = n[4] || n[6], m = !1, u = [o, t[i++]]; l > i; i++) {
                                if (m) {
                                    if (">" === t[i])break
                                } else 0 <= t[i].indexOf(c) && (m = !0);
                                u.push(t[i])
                            }
                            if (i >= l)break;
                            o = u.join("");
                            continue
                        }
                        var h = n[1].toLowerCase(), p = n[2] ? g(n[3]) : "";
                        s.push(h, p), o = o.substr(n[0].length)
                    } else o = o.replace(/^[\s\S][^a-z\s]*/, "");
                    return r.attrs = s, r.next = i + 1, r
                }
            }

            function g(e) {
                var t = e.charCodeAt(0);
                return (34 === t || 39 === t) && (e = e.substr(1, e.length - 2)), r(n(e))
            }

            function E(t) {
                var a, n, r = function (e, t) {
                    n || t.push(e)
                };
                return l({
                    startDoc: function (e) {
                        a = [], n = !1
                    }, startTag: function (r, i, l) {
                        if (!n && e.ELEMENTS.hasOwnProperty(r)) {
                            var s = e.ELEMENTS[r];
                            if (!(s & e.eflags.FOLDABLE)) {
                                var c = t(r, i);
                                if (!c)return void(n = !(s & e.eflags.EMPTY));
                                if ("object" != typeof c)throw new Error("tagPolicy did not return object (old API?)");
                                if (!("attribs" in c))throw new Error("tagPolicy gave no attribs");
                                i = c.attribs;
                                var m, u;
                                if ("tagName" in c ? (u = c.tagName, m = e.ELEMENTS[u]) : (u = r, m = s), s & e.eflags.OPTIONAL_ENDTAG) {
                                    var h = a[a.length - 1];
                                    !h || h.orig !== r || h.rep === u && r === u || l.push("</", h.rep, ">")
                                }
                                s & e.eflags.EMPTY || a.push({orig: r, rep: u}), l.push("<", u);
                                for (var p = 0, d = i.length; d > p; p += 2) {
                                    var f = i[p], g = i[p + 1];
                                    null !== g && void 0 !== g && l.push(" ", f, '="', o(g), '"')
                                }
                                l.push(">"), s & e.eflags.EMPTY && !(m & e.eflags.EMPTY) && l.push("</", u, ">")
                            }
                        }
                    }, endTag: function (t, r) {
                        if (n)return void(n = !1);
                        if (e.ELEMENTS.hasOwnProperty(t)) {
                            var o = e.ELEMENTS[t];
                            if (!(o & (e.eflags.EMPTY | e.eflags.FOLDABLE))) {
                                var i;
                                if (o & e.eflags.OPTIONAL_ENDTAG)for (i = a.length; --i >= 0;) {
                                    var l = a[i].orig;
                                    if (l === t)break;
                                    if (!(e.ELEMENTS[l] & e.eflags.OPTIONAL_ENDTAG))return
                                } else for (i = a.length; --i >= 0 && a[i].orig !== t;);
                                if (0 > i)return;
                                for (var s = a.length; --s > i;) {
                                    var c = a[s].rep;
                                    e.ELEMENTS[c] & e.eflags.OPTIONAL_ENDTAG || r.push("</", c, ">")
                                }
                                i < a.length && (t = a[i].rep), a.length = i, r.push("</", t, ">")
                            }
                        }
                    }, pcdata: r, rcdata: r, cdata: r, endDoc: function (e) {
                        for (; a.length; a.length--)e.push("</", a[a.length - 1].rep, ">")
                    }
                })
            }

            function T(e, t, a, n, r) {
                if (!r)return null;
                try {
                    var o = URI.parse("" + e);
                    if (o && (!o.hasScheme() || V.test(o.getScheme()))) {
                        var i = r(o, t, a, n);
                        return i ? i.toString() : null
                    }
                } catch (l) {
                    return null
                }
                return null
            }

            function L(e, t, a, n, r) {
                if (a || e(t + " removed", {change: "removed", tagName: t}), n !== r) {
                    var o = "changed";
                    n && !r ? o = "removed" : !n && r && (o = "added"), e(t + "." + a + " " + o, {change: o, tagName: t, attribName: a, oldValue: n, newValue: r})
                }
            }

            function M(e, t, a) {
                var n;
                return n = t + "::" + a, e.hasOwnProperty(n) ? e[n] : (n = "*::" + a, e.hasOwnProperty(n) ? e[n] : void 0)
            }

            function b(t, a) {
                return M(e.LOADERTYPES, t, a)
            }

            function y(t, a) {
                return M(e.URIEFFECTS, t, a)
            }

            function v(t, a, n, r, o) {
                for (var i = 0; i < a.length; i += 2) {
                    var l, s = a[i], c = a[i + 1], m = c, u = null;
                    if (l = t + "::" + s, (e.ATTRIBS.hasOwnProperty(l) || (l = "*::" + s, e.ATTRIBS.hasOwnProperty(l))) && (u = e.ATTRIBS[l]), null !== u)switch (u) {
                        case e.atype.NONE:
                            break;
                        case e.atype.SCRIPT:
                            c = null, o && L(o, t, s, m, c);
                            break;
                        case e.atype.STYLE:
                            if ("undefined" == typeof A) {
                                c = null, o && L(o, t, s, m, c);
                                break
                            }
                            var h = [];
                            A(c, {
                                declaration: function (t, a) {
                                    var r = t.toLowerCase(), o = C[r];
                                    o && (R(r, o, a, n ? function (t) {
                                            return T(t, e.ueffects.SAME_DOCUMENT, e.ltypes.SANDBOXED, {TYPE: "CSS", CSS_PROP: r}, n)
                                        } : null), h.push(t + ": " + a.join(" ")))
                                }
                            }), c = h.length > 0 ? h.join(" ; ") : null, o && L(o, t, s, m, c);
                            break;
                        case e.atype.ID:
                        case e.atype.IDREF:
                        case e.atype.IDREFS:
                        case e.atype.GLOBAL_NAME:
                        case e.atype.LOCAL_NAME:
                        case e.atype.CLASSES:
                            c = r ? r(c) : c, o && L(o, t, s, m, c);
                            break;
                        case e.atype.URI:
                            c = T(c, y(t, s), b(t, s), {TYPE: "MARKUP", XML_ATTR: s, XML_TAG: t}, n), o && L(o, t, s, m, c);
                            break;
                        case e.atype.URI_FRAGMENT:
                            c && "#" === c.charAt(0) ? (c = c.substring(1), c = r ? r(c) : c, null !== c && void 0 !== c && (c = "#" + c)) : c = null, o && L(o, t, s, m, c);
                            break;
                        default:
                            c = null, o && L(o, t, s, m, c)
                    } else c = null, o && L(o, t, s, m, c);
                    a[i + 1] = c
                }
                return a
            }

            function H(t, a, n) {
                return function (r, o) {
                    return e.ELEMENTS[r] & e.eflags.UNSAFE ? void(n && L(n, r, void 0, void 0, void 0)) : {attribs: v(r, o, t, a, n)}
                }
            }

            function _(e, t) {
                var a = [];
                return E(t)(e, a), a.join("")
            }

            function w(e, t, a, n) {
                var r = H(t, a, n);
                return _(e, r)
            }

            var A, R, C;
            "undefined" != typeof window && (A = window.parseCssDeclarations, R = window.sanitizeCssProperty, C = window.cssSchema);
            var S = {
                lt: "<",
                LT: "<",
                gt: ">",
                GT: ">",
                amp: "&",
                AMP: "&",
                quot: '"',
                apos: "'",
                nbsp: " "
            }, P = /^#(\d+)$/, D = /^#x([0-9A-Fa-f]+)$/, k = /^[A-Za-z][A-za-z0-9]+$/, I = "undefined" != typeof window && window.document ? window.document.createElement("textarea") : null, x = /\0/g, N = /&(#[0-9]+|#[xX][0-9A-Fa-f]+|\w+);/g, O = /^(#[0-9]+|#[xX][0-9A-Fa-f]+|\w+);/, F = /&/g, U = /&([^a-z#]|#(?:[^0-9x]|x(?:[^0-9a-f]|$)|$)|$)/gi, B = /[<]/g, q = />/g, z = /\"/g, G = new RegExp("^\\s*([-.:\\w]+)(?:\\s*(=)\\s*((\")[^\"]*(\"|$)|(')[^']*('|$)|(?=[a-z][-\\w]*\\s*=)|[^\"'\\s]*))?", "i"), $ = 3 === "a,b".split(/(,)/).length, j = e.eflags.CDATA | e.eflags.RCDATA, Y = {}, Q = {}, V = /^(?:https?|mailto|data)$/i, X = {};
            return X.escapeAttrib = X.escapeAttrib = o, X.makeHtmlSanitizer = X.makeHtmlSanitizer = E, X.makeSaxParser = X.makeSaxParser = l, X.makeTagPolicy = X.makeTagPolicy = H, X.normalizeRCData = X.normalizeRCData = i, X.sanitize = X.sanitize = w, X.sanitizeAttribs = X.sanitizeAttribs = v, X.sanitizeWithPolicy = X.sanitizeWithPolicy = _, X.unescapeEntities = X.unescapeEntities = r, X
        }(html4), html_sanitize = html.sanitize;
        html4.ATTRIBS["*::style"] = 0, html4.ELEMENTS.style = 0, html4.ATTRIBS["a::target"] = 0, html4.ELEMENTS.video = 0, html4.ATTRIBS["video::src"] = 0, html4.ATTRIBS["video::poster"] = 0, html4.ATTRIBS["video::controls"] = 0, html4.ELEMENTS.audio = 0, html4.ATTRIBS["audio::src"] = 0, html4.ATTRIBS["video::autoplay"] = 0, html4.ATTRIBS["video::controls"] = 0, "undefined" != typeof module && (module.exports = html_sanitize);
    }, {}], 7: [function (require, module, exports) {
        module.exports = {
            "author": "Mapbox",
            "name": "mapbox.js",
            "description": "mapbox javascript api",
            "version": "2.3.0",
            "homepage": "http://mapbox.com/",
            "repository": {"type": "git", "url": "git://github.com/mapbox/mapbox.js.git"},
            "main": "src/index.js",
            "dependencies": {"corslite": "0.0.6", "isarray": "0.0.1", "leaflet": "0.7.7", "mustache": "2.2.1", "sanitize-caja": "0.1.3"},
            "scripts": {"test": "eslint --no-eslintrc -c .eslintrc src && mocha-phantomjs test/index.html"},
            "license": "BSD-3-Clause",
            "devDependencies": {"browserify": "^6.3.2", "clean-css": "~2.0.7", "eslint": "^0.23.0", "expect.js": "0.3.1", "happen": "0.1.3", "leaflet-fullscreen": "0.0.4", "leaflet-hash": "0.2.1", "marked": "~0.3.0", "minifyify": "^6.1.0", "minimist": "0.0.5", "mocha": "1.17.1", "mocha-phantomjs": "3.1.6", "sinon": "1.10.2"},
            "optionalDependencies": {},
            "engines": {"node": "*"}
        }
    }, {}], 8: [function (require, module, exports) {
        "use strict";
        module.exports = {HTTP_URL: "http://a.tiles.mapbox.com/v4", HTTPS_URL: "https://a.tiles.mapbox.com/v4", FORCE_HTTPS: !1, REQUIRE_ACCESS_TOKEN: !0};
    }, {}], 9: [function (require, module, exports) {
        "use strict";
        var util = require("./util"), format_url = require("./format_url"), request = require("./request"), marker = require("./marker"), simplestyle = require("./simplestyle"), FeatureLayer = L.FeatureGroup.extend({
            options: {
                filter: function () {
                    return !0
                }, sanitizer: require("sanitize-caja"), style: simplestyle.style, popupOptions: {closeButton: !1}
            }, initialize: function (e, t) {
                L.setOptions(this, t), this._layers = {}, "string" == typeof e ? util.idUrl(e, this) : e && "object" == typeof e && this.setGeoJSON(e)
            }, setGeoJSON: function (e) {
                return this._geojson = e, this.clearLayers(), this._initialize(e), this
            }, getGeoJSON: function () {
                return this._geojson
            }, loadURL: function (e) {
                return this._request && "abort" in this._request && this._request.abort(), this._request = request(e, L.bind(function (t, i) {
                    this._request = null, t && "abort" !== t.type ? (util.log("could not load features at " + e), this.fire("error", {error: t})) : i && (this.setGeoJSON(i), this.fire("ready"))
                }, this)), this
            }, loadID: function (e) {
                return this.loadURL(format_url("/v4/" + e + "/features.json", this.options.accessToken))
            }, setFilter: function (e) {
                return this.options.filter = e, this._geojson && (this.clearLayers(), this._initialize(this._geojson)), this
            }, getFilter: function () {
                return this.options.filter
            }, _initialize: function (e) {
                var t, i, r = L.Util.isArray(e) ? e : e.features;
                if (r)for (t = 0, i = r.length; i > t; t++)(r[t].geometries || r[t].geometry || r[t].features) && this._initialize(r[t]); else if (this.options.filter(e)) {
                    var s = {accessToken: this.options.accessToken}, o = this.options.pointToLayer || function (e, t) {
                            return marker.style(e, t, s)
                        }, n = L.GeoJSON.geometryToLayer(e, o), u = marker.createPopup(e, this.options.sanitizer), a = this.options.style, l = a === simplestyle.style;
                    !(a && "setStyle" in n) || l && (n instanceof L.Circle || n instanceof L.CircleMarker) || ("function" == typeof a && (a = a(e)), n.setStyle(a)), n.feature = e, u && n.bindPopup(u, this.options.popupOptions), this.addLayer(n)
                }
            }
        });
        module.exports.FeatureLayer = FeatureLayer, module.exports.featureLayer = function (e, t) {
            return new FeatureLayer(e, t)
        };
    }, {"./format_url": 11, "./marker": 25, "./request": 26, "./simplestyle": 28, "./util": 31, "sanitize-caja": 5}], 10: [function (require, module, exports) {
        "use strict";
        var Feedback = L.Class.extend({
            includes: L.Mixin.Events, data: {}, record: function (e) {
                L.extend(this.data, e), this.fire("change")
            }
        });
        module.exports = new Feedback;
    }, {}], 11: [function (require, module, exports) {
        "use strict";
        var config = require("./config"), version = require("../package.json").version;
        module.exports = function (e, o) {
            if (o = o || L.mapbox.accessToken, !o && config.REQUIRE_ACCESS_TOKEN)throw new Error("An API access token is required to use Mapbox.js. See https://www.mapbox.com/mapbox.js/api/v" + version + "/api-access-tokens/");
            var s = "https:" === document.location.protocol || config.FORCE_HTTPS ? config.HTTPS_URL : config.HTTP_URL;
            if (s = s.replace(/\/v4$/, ""), s += e, config.REQUIRE_ACCESS_TOKEN) {
                if ("s" === o[0])throw new Error("Use a public access token (pk.*) with Mapbox.js, not a secret access token (sk.*). See https://www.mapbox.com/mapbox.js/api/v" + version + "/api-access-tokens/");
                s += -1 !== s.indexOf("?") ? "&access_token=" : "?access_token=", s += o
            }
            return s
        }, module.exports.tileJSON = function (e, o) {
            if (-1 !== e.indexOf("/"))return e;
            var s = module.exports("/v4/" + e + ".json", o);
            return 0 === s.indexOf("https") && (s += "&secure"), s
        }, module.exports.style = function (e, o) {
            if (-1 === e.indexOf("mapbox://styles/"))throw new Error("Incorrectly formatted Mapbox style at " + e);
            var s = e.split("mapbox://styles/")[1], t = module.exports("/styles/v1/" + s, o).replace("http://", "https://");
            return t
        };
    }, {"../package.json": 7, "./config": 8}], 12: [function (require, module, exports) {
        "use strict";
        var isArray = require("isarray"), util = require("./util"), format_url = require("./format_url"), feedback = require("./feedback"), request = require("./request");
        module.exports = function (e, r) {
            function t(e, r) {
                var t = Math.pow(10, r);
                return e.lat = Math.round(e.lat * t) / t, e.lng = Math.round(e.lng * t) / t, e
            }

            r || (r = {});
            var n = {};
            return util.strict(e, "string"), -1 === e.indexOf("/") && (e = format_url("/geocoding/v5/" + e + "/{query}.json", r.accessToken, 5)), n.getURL = function () {
                return e
            }, n.queryURL = function (e) {
                var r = !(isArray(e) || "string" == typeof e), u = r ? e.query : e;
                if (isArray(u)) {
                    for (var o = [], i = 0; i < u.length; i++)o[i] = encodeURIComponent(u[i]);
                    u = o.join(";")
                } else u = encodeURIComponent(u);
                feedback.record({geocoding: u});
                var a = L.Util.template(n.getURL(), {query: u});
                if (r && e.types && (a += isArray(e.types) ? "&types=" + e.types.join() : "&types=" + e.types), r && e.proximity) {
                    var l = t(L.latLng(e.proximity), 3);
                    a += "&proximity=" + l.lng + "," + l.lat
                }
                return a
            }, n.query = function (e, r) {
                return util.strict(r, "function"), request(n.queryURL(e), function (e, t) {
                    if (t && (t.length || t.features)) {
                        var n = {results: t};
                        t.features && t.features.length && (n.latlng = [t.features[0].center[1], t.features[0].center[0]], t.features[0].bbox && (n.bounds = t.features[0].bbox, n.lbounds = util.lbounds(n.bounds))), r(null, n)
                    } else r(e || !0)
                }), n
            }, n.reverseQuery = function (e, r) {
                function u(e) {
                    var r;
                    return r = void 0 !== e.lat && void 0 !== e.lng ? L.latLng(e.lat, e.lng) : void 0 !== e.lat && void 0 !== e.lon ? L.latLng(e.lat, e.lon) : L.latLng(e[1], e[0]), r = t(r, 5), r.lng + "," + r.lat
                }

                var o = "";
                if (e.length && e[0].length) {
                    for (var i = 0, a = []; i < e.length; i++)a.push(u(e[i]));
                    o = a.join(";")
                } else o = u(e);
                return request(n.queryURL(o), function (e, t) {
                    r(e, t)
                }), n
            }, n
        };
    }, {"./feedback": 10, "./format_url": 11, "./request": 26, "./util": 31, "isarray": 2}], 13: [function (require, module, exports) {
        "use strict";
        var geocoder = require("./geocoder"), util = require("./util"), GeocoderControl = L.Control.extend({
            includes: L.Mixin.Events, options: {proximity: !0, position: "topleft", pointZoom: 16, keepOpen: !1, autocomplete: !1}, initialize: function (t, e) {
                L.Util.setOptions(this, e), this.setURL(t), this._updateSubmit = L.bind(this._updateSubmit, this), this._updateAutocomplete = L.bind(this._updateAutocomplete, this), this._chooseResult = L.bind(this._chooseResult, this)
            }, setURL: function (t) {
                return this.geocoder = geocoder(t, {accessToken: this.options.accessToken}), this
            }, getURL: function () {
                return this.geocoder.getURL()
            }, setID: function (t) {
                return this.setURL(t)
            }, setTileJSON: function (t) {
                return this.setURL(t.geocoder)
            }, _toggle: function (t) {
                t && L.DomEvent.stop(t), L.DomUtil.hasClass(this._container, "active") ? (L.DomUtil.removeClass(this._container, "active"), this._results.innerHTML = "", this._input.blur()) : (L.DomUtil.addClass(this._container, "active"), this._input.focus(), this._input.select())
            }, _closeIfOpen: function () {
                L.DomUtil.hasClass(this._container, "active") && !this.options.keepOpen && (L.DomUtil.removeClass(this._container, "active"), this._results.innerHTML = "", this._input.blur())
            }, onAdd: function (t) {
                var e = L.DomUtil.create("div", "leaflet-control-mapbox-geocoder leaflet-bar leaflet-control"), i = L.DomUtil.create("a", "leaflet-control-mapbox-geocoder-toggle mapbox-icon mapbox-icon-geocoder", e), o = L.DomUtil.create("div", "leaflet-control-mapbox-geocoder-results", e), s = L.DomUtil.create("div", "leaflet-control-mapbox-geocoder-wrap", e), n = L.DomUtil.create("form", "leaflet-control-mapbox-geocoder-form", s), r = L.DomUtil.create("input", "", n);
                return i.href = "#", i.innerHTML = "&nbsp;", r.type = "text", r.setAttribute("placeholder", "Search"), L.DomEvent.addListener(n, "submit", this._geocode, this), L.DomEvent.addListener(r, "keyup", this._autocomplete, this), L.DomEvent.disableClickPropagation(e), this._map = t, this._results = o, this._input = r, this._form = n, this.options.keepOpen ? L.DomUtil.addClass(e, "active") : (this._map.on("click", this._closeIfOpen, this), L.DomEvent.addListener(i, "click", this._toggle, this)), e
            }, _updateSubmit: function (t, e) {
                if (L.DomUtil.removeClass(this._container, "searching"), this._results.innerHTML = "", t || !e) this.fire("error", {error: t}); else {
                    var i = [];
                    e.results && e.results.features && (i = e.results.features), 1 === i.length ? (this.fire("autoselect", {feature: i[0]}), this.fire("found", {results: e.results}), this._chooseResult(i[0]), this._closeIfOpen()) : i.length > 1 ? (this.fire("found", {results: e.results}), this._displayResults(i)) : this._displayResults(i)
                }
            }, _updateAutocomplete: function (t, e) {
                if (this._results.innerHTML = "", t || !e) this.fire("error", {error: t}); else {
                    var i = [];
                    e.results && e.results.features && (i = e.results.features), i.length && this.fire("found", {results: e.results}), this._displayResults(i)
                }
            }, _displayResults: function (t) {
                for (var e = 0, i = Math.min(t.length, 5); i > e; e++) {
                    var o = t[e], s = o.place_name;
                    if (s.length) {
                        var n = L.DomUtil.create("a", "", this._results), r = "innerText" in n ? "innerText" : "textContent";
                        n[r] = s, n.setAttribute("title", s), n.href = "#", L.bind(function (t) {
                            L.DomEvent.addListener(n, "click", function (e) {
                                this._chooseResult(t), L.DomEvent.stop(e), this.fire("select", {feature: t})
                            }, this)
                        }, this)(o)
                    }
                }
                if (t.length > 5) {
                    var l = L.DomUtil.create("span", "", this._results);
                    l.innerHTML = "Top 5 of " + t.length + "  results"
                }
            }, _chooseResult: function (t) {
                t.bbox ? this._map.fitBounds(util.lbounds(t.bbox)) : t.center && this._map.setView([t.center[1], t.center[0]], void 0 === this._map.getZoom() ? this.options.pointZoom : Math.max(this._map.getZoom(), this.options.pointZoom))
            }, _geocode: function (t) {
                return L.DomEvent.preventDefault(t), "" === this._input.value ? this._updateSubmit() : (L.DomUtil.addClass(this._container, "searching"), void this.geocoder.query({query: this._input.value, proximity: this.options.proximity ? this._map.getCenter() : !1}, this._updateSubmit))
            }, _autocomplete: function () {
                return this.options.autocomplete ? "" === this._input.value ? this._updateAutocomplete() : void this.geocoder.query({query: this._input.value, proximity: this.options.proximity ? this._map.getCenter() : !1}, this._updateAutocomplete) : void 0
            }
        });
        module.exports.GeocoderControl = GeocoderControl, module.exports.geocoderControl = function (t, e) {
            return new GeocoderControl(t, e)
        };
    }, {"./geocoder": 12, "./util": 31}], 14: [function (require, module, exports) {
        "use strict";
        function utfDecode(t) {
            return t >= 93 && t--, t >= 35 && t--, t - 32
        }

        module.exports = function (t) {
            return function (e, r) {
                if (t) {
                    var u = utfDecode(t.grid[r].charCodeAt(e)), n = t.keys[u];
                    return t.data[n]
                }
            }
        };
    }, {}], 15: [function (require, module, exports) {
        "use strict";
        var util = require("./util"), Mustache = require("mustache"), GridControl = L.Control.extend({
            options: {pinnable: !0, follow: !1, sanitizer: require("sanitize-caja"), touchTeaser: !0, location: !0}, _currentContent: "", _pinned: !1, initialize: function (t, o) {
                L.Util.setOptions(this, o), util.strict_instance(t, L.Class, "L.mapbox.gridLayer"), this._layer = t
            }, setTemplate: function (t) {
                return util.strict(t, "string"), this.options.template = t, this
            }, _template: function (t, o) {
                if (o) {
                    var i = this.options.template || this._layer.getTileJSON().template;
                    if (i) {
                        var e = {};
                        return e["__" + t + "__"] = !0, this.options.sanitizer(Mustache.to_html(i, L.extend(e, o)))
                    }
                }
            }, _show: function (t, o) {
                t !== this._currentContent && (this._currentContent = t, this.options.follow ? (this._popup.setContent(t).setLatLng(o.latLng), this._map._popup !== this._popup && this._popup.openOn(this._map)) : (this._container.style.display = "block", this._contentWrapper.innerHTML = t))
            }, hide: function () {
                return this._pinned = !1, this._currentContent = "", this._map.closePopup(), this._container.style.display = "none", this._contentWrapper.innerHTML = "", L.DomUtil.removeClass(this._container, "closable"), this
            }, _mouseover: function (t) {
                if (t.data ? L.DomUtil.addClass(this._map._container, "map-clickable") : L.DomUtil.removeClass(this._map._container, "map-clickable"), !this._pinned) {
                    var o = this._template("teaser", t.data);
                    o ? this._show(o, t) : this.hide()
                }
            }, _mousemove: function (t) {
                this._pinned || this.options.follow && this._popup.setLatLng(t.latLng)
            }, _navigateTo: function (t) {
                window.top.location.href = t
            }, _click: function (t) {
                var o = this._template("location", t.data);
                if (this.options.location && o && 0 === o.search(/^https?:/))return this._navigateTo(this._template("location", t.data));
                if (this.options.pinnable) {
                    var i = this._template("full", t.data);
                    !i && this.options.touchTeaser && L.Browser.touch && (i = this._template("teaser", t.data)), i ? (L.DomUtil.addClass(this._container, "closable"), this._pinned = !0, this._show(i, t)) : this._pinned && (L.DomUtil.removeClass(this._container, "closable"), this._pinned = !1, this.hide())
                }
            }, _onPopupClose: function () {
                this._currentContent = null, this._pinned = !1
            }, _createClosebutton: function (t, o) {
                var i = L.DomUtil.create("a", "close", t);
                return i.innerHTML = "close", i.href = "#", i.title = "close", L.DomEvent.on(i, "click", L.DomEvent.stopPropagation).on(i, "mousedown", L.DomEvent.stopPropagation).on(i, "dblclick", L.DomEvent.stopPropagation).on(i, "click", L.DomEvent.preventDefault).on(i, "click", o, this), i
            }, onAdd: function (t) {
                this._map = t;
                var o = "leaflet-control-grid map-tooltip", i = L.DomUtil.create("div", o), e = L.DomUtil.create("div", "map-tooltip-content");
                return i.style.display = "none", this._createClosebutton(i, this.hide), i.appendChild(e), this._contentWrapper = e, this._popup = new L.Popup({autoPan: !1, closeOnClick: !1}), t.on("popupclose", this._onPopupClose, this), L.DomEvent.disableClickPropagation(i).addListener(i, "mousewheel", L.DomEvent.stopPropagation), this._layer.on("mouseover", this._mouseover, this).on("mousemove", this._mousemove, this).on("click", this._click, this), i
            }, onRemove: function (t) {
                t.off("popupclose", this._onPopupClose, this), this._layer.off("mouseover", this._mouseover, this).off("mousemove", this._mousemove, this).off("click", this._click, this)
            }
        });
        module.exports.GridControl = GridControl, module.exports.gridControl = function (t, o) {
            return new GridControl(t, o)
        };
    }, {"./util": 31, "mustache": 4, "sanitize-caja": 5}], 16: [function (require, module, exports) {
        "use strict";
        var util = require("./util"), request = require("./request"), grid = require("./grid"), GridLayer = L.Class.extend({
            includes: [L.Mixin.Events, require("./load_tilejson")], options: {
                template: function () {
                    return ""
                }
            }, _mouseOn: null, _tilejson: {}, _cache: {}, initialize: function (t, i) {
                L.Util.setOptions(this, i), this._loadTileJSON(t)
            }, _setTileJSON: function (t) {
                return util.strict(t, "object"), L.extend(this.options, {grids: t.grids, minZoom: t.minzoom, maxZoom: t.maxzoom, bounds: t.bounds && util.lbounds(t.bounds)}), this._tilejson = t, this._cache = {}, this._update(), this
            }, getTileJSON: function () {
                return this._tilejson
            }, active: function () {
                return !!(this._map && this.options.grids && this.options.grids.length)
            }, addTo: function (t) {
                return t.addLayer(this), this
            }, onAdd: function (t) {
                this._map = t, this._update(), this._map.on("click", this._click, this).on("mousemove", this._move, this).on("moveend", this._update, this)
            }, onRemove: function () {
                this._map.off("click", this._click, this).off("mousemove", this._move, this).off("moveend", this._update, this)
            }, getData: function (t, i) {
                if (this.active()) {
                    var e = this._map, o = e.project(t.wrap()), s = 256, n = 4, a = Math.floor(o.x / s), h = Math.floor(o.y / s), r = e.options.crs.scale(e.getZoom()) / s;
                    return a = (a + r) % r, h = (h + r) % r, this._getTile(e.getZoom(), a, h, function (t) {
                        var e = Math.floor((o.x - a * s) / n), r = Math.floor((o.y - h * s) / n);
                        i(t(e, r))
                    }), this
                }
            }, _click: function (t) {
                this.getData(t.latlng, L.bind(function (i) {
                    this.fire("click", {latLng: t.latlng, data: i})
                }, this))
            }, _move: function (t) {
                this.getData(t.latlng, L.bind(function (i) {
                    i !== this._mouseOn ? (this._mouseOn && this.fire("mouseout", {latLng: t.latlng, data: this._mouseOn}), this.fire("mouseover", {latLng: t.latlng, data: i}), this._mouseOn = i) : this.fire("mousemove", {latLng: t.latlng, data: i})
                }, this))
            }, _getTileURL: function (t) {
                var i = this.options.grids, e = (t.x + t.y) % i.length, o = i[e];
                return L.Util.template(o, t)
            }, _update: function () {
                if (this.active()) {
                    var t = this._map.getPixelBounds(), i = this._map.getZoom(), e = 256;
                    if (!(i > this.options.maxZoom || i < this.options.minZoom))for (var o = L.bounds(t.min.divideBy(e)._floor(), t.max.divideBy(e)._floor()), s = this._map.options.crs.scale(i) / e, n = o.min.x; n <= o.max.x; n++)for (var a = o.min.y; a <= o.max.y; a++)this._getTile(i, (n % s + s) % s, (a % s + s) % s)
                }
            }, _getTile: function (t, i, e, o) {
                var s = t + "_" + i + "_" + e, n = L.point(i, e);
                if (n.z = t, this._tileShouldBeLoaded(n)) {
                    if (s in this._cache) {
                        if (!o)return;
                        return void("function" == typeof this._cache[s] ? o(this._cache[s]) : this._cache[s].push(o))
                    }
                    this._cache[s] = [], o && this._cache[s].push(o), request(this._getTileURL(n), L.bind(function (t, i) {
                        var e = this._cache[s];
                        this._cache[s] = grid(i);
                        for (var o = 0; o < e.length; ++o)e[o](this._cache[s])
                    }, this))
                }
            }, _tileShouldBeLoaded: function (t) {
                if (t.z > this.options.maxZoom || t.z < this.options.minZoom)return !1;
                if (this.options.bounds) {
                    var i = 256, e = t.multiplyBy(i), o = e.add(new L.Point(i, i)), s = this._map.unproject(e), n = this._map.unproject(o), a = new L.LatLngBounds([s, n]);
                    if (!this.options.bounds.intersects(a))return !1
                }
                return !0
            }
        });
        module.exports.GridLayer = GridLayer, module.exports.gridLayer = function (t, i) {
            return new GridLayer(t, i)
        };
    }, {"./grid": 14, "./load_tilejson": 21, "./request": 26, "./util": 31}], 17: [function (require, module, exports) {
        "use strict";
        var leaflet = require("./leaflet");
        require("./mapbox"), module.exports = leaflet;
    }, {"./leaflet": 19, "./mapbox": 23}], 18: [function (require, module, exports) {
        "use strict";
        var InfoControl = L.Control.extend({
            options: {position: "bottomright", sanitizer: require("sanitize-caja")}, initialize: function (t) {
                L.setOptions(this, t), this._info = {}, console.warn("infoControl has been deprecated and will be removed in mapbox.js v3.0.0. Use the default attribution control instead, which is now responsive.")
            }, onAdd: function (t) {
                this._container = L.DomUtil.create("div", "mapbox-control-info mapbox-small"), this._content = L.DomUtil.create("div", "map-info-container", this._container);
                var i = L.DomUtil.create("a", "mapbox-info-toggle mapbox-icon mapbox-icon-info", this._container);
                i.href = "#", L.DomEvent.addListener(i, "click", this._showInfo, this), L.DomEvent.disableClickPropagation(this._container);
                for (var n in t._layers)t._layers[n].getAttribution && this.addInfo(t._layers[n].getAttribution());
                return t.on("layeradd", this._onLayerAdd, this).on("layerremove", this._onLayerRemove, this), this._update(), this._container
            }, onRemove: function (t) {
                t.off("layeradd", this._onLayerAdd, this).off("layerremove", this._onLayerRemove, this)
            }, addInfo: function (t) {
                return t ? (this._info[t] || (this._info[t] = 0), this._info[t] = !0, this._update()) : this
            }, removeInfo: function (t) {
                return t ? (this._info[t] && (this._info[t] = !1), this._update()) : this
            }, _showInfo: function (t) {
                return L.DomEvent.preventDefault(t), this._active === !0 ? this._hidecontent() : (L.DomUtil.addClass(this._container, "active"), this._active = !0, void this._update())
            }, _hidecontent: function () {
                this._content.innerHTML = "", this._active = !1, L.DomUtil.removeClass(this._container, "active")
            }, _update: function () {
                if (!this._map)return this;
                this._content.innerHTML = "";
                var t = "none", i = [];
                for (var n in this._info)this._info.hasOwnProperty(n) && this._info[n] && (i.push(this.options.sanitizer(n)), t = "block");
                return this._content.innerHTML += i.join(" | "), this._container.style.display = t, this
            }, _onLayerAdd: function (t) {
                t.layer.getAttribution && t.layer.getAttribution() ? this.addInfo(t.layer.getAttribution()) : "on" in t.layer && t.layer.getAttribution && t.layer.on("ready", L.bind(function () {
                        this.addInfo(t.layer.getAttribution())
                    }, this))
            }, _onLayerRemove: function (t) {
                t.layer.getAttribution && this.removeInfo(t.layer.getAttribution())
            }
        });
        module.exports.InfoControl = InfoControl, module.exports.infoControl = function (t) {
            return new InfoControl(t)
        };
    }, {"sanitize-caja": 5}], 19: [function (require, module, exports) {
        module.exports = window.L = require("leaflet/dist/leaflet-src");
    }, {"leaflet/dist/leaflet-src": 3}], 20: [function (require, module, exports) {
        "use strict";
        var LegendControl = L.Control.extend({
            options: {position: "bottomright", sanitizer: require("sanitize-caja")}, initialize: function (e) {
                L.setOptions(this, e), this._legends = {}
            }, onAdd: function () {
                return this._container = L.DomUtil.create("div", "map-legends wax-legends"), L.DomEvent.disableClickPropagation(this._container), this._update(), this._container
            }, addLegend: function (e) {
                return e ? (this._legends[e] || (this._legends[e] = 0), this._legends[e]++, this._update()) : this
            }, removeLegend: function (e) {
                return e ? (this._legends[e] && this._legends[e]--, this._update()) : this
            }, _update: function () {
                if (!this._map)return this;
                this._container.innerHTML = "";
                var e = "none";
                for (var t in this._legends)if (this._legends.hasOwnProperty(t) && this._legends[t]) {
                    var n = L.DomUtil.create("div", "map-legend wax-legend", this._container);
                    n.innerHTML = this.options.sanitizer(t), e = "block"
                }
                return this._container.style.display = e, this
            }
        });
        module.exports.LegendControl = LegendControl, module.exports.legendControl = function (e) {
            return new LegendControl(e)
        };
    }, {"sanitize-caja": 5}], 21: [function (require, module, exports) {
        "use strict";
        var request = require("./request"), format_url = require("./format_url"), util = require("./util");
        module.exports = {
            _loadTileJSON: function (e) {
                "string" == typeof e ? (e = format_url.tileJSON(e, this.options && this.options.accessToken), request(e, L.bind(function (t, r) {
                        t ? (util.log("could not load TileJSON at " + e), this.fire("error", {error: t})) : r && (this._setTileJSON(r), this.fire("ready"))
                    }, this))) : e && "object" == typeof e && this._setTileJSON(e)
            }
        };
    }, {"./format_url": 11, "./request": 26, "./util": 31}], 22: [function (require, module, exports) {
        "use strict";
        function withAccessToken(t, o) {
            return !o || t.accessToken ? t : L.extend({accessToken: o}, t)
        }

        var tileLayer = require("./tile_layer").tileLayer, featureLayer = require("./feature_layer").featureLayer, gridLayer = require("./grid_layer").gridLayer, gridControl = require("./grid_control").gridControl, infoControl = require("./info_control").infoControl, shareControl = require("./share_control").shareControl, legendControl = require("./legend_control").legendControl, mapboxLogoControl = require("./mapbox_logo").mapboxLogoControl, feedback = require("./feedback"), LMap = L.Map.extend({
            includes: [require("./load_tilejson")],
            options: {tileLayer: {}, featureLayer: {}, gridLayer: {}, legendControl: {}, gridControl: {}, infoControl: !1, shareControl: !1, sanitizer: require("sanitize-caja")},
            _tilejson: {},
            initialize: function (t, o, e) {
                if (L.Map.prototype.initialize.call(this, t, L.extend({}, L.Map.prototype.options, e)), this.attributionControl) {
                    this.attributionControl.setPrefix("");
                    var i = this.options.attributionControl.compact;
                    (i || i !== !1 && this._container.offsetWidth <= 640) && L.DomUtil.addClass(this.attributionControl._container, "leaflet-compact-attribution"), void 0 === i && this.on("resize", function () {
                        this._container.offsetWidth > 640 ? L.DomUtil.removeClass(this.attributionControl._container, "leaflet-compact-attribution") : L.DomUtil.addClass(this.attributionControl._container, "leaflet-compact-attribution")
                    })
                }
                this.options.tileLayer && (this.tileLayer = tileLayer(void 0, withAccessToken(this.options.tileLayer, this.options.accessToken)), this.addLayer(this.tileLayer)), this.options.featureLayer && (this.featureLayer = featureLayer(void 0, withAccessToken(this.options.featureLayer, this.options.accessToken)), this.addLayer(this.featureLayer)), this.options.gridLayer && (this.gridLayer = gridLayer(void 0, withAccessToken(this.options.gridLayer, this.options.accessToken)), this.addLayer(this.gridLayer)), this.options.gridLayer && this.options.gridControl && (this.gridControl = gridControl(this.gridLayer, this.options.gridControl), this.addControl(this.gridControl)), this.options.infoControl && (this.infoControl = infoControl(this.options.infoControl), this.addControl(this.infoControl)), this.options.legendControl && (this.legendControl = legendControl(this.options.legendControl), this.addControl(this.legendControl)), this.options.shareControl && (this.shareControl = shareControl(void 0, withAccessToken(this.options.shareControl, this.options.accessToken)), this.addControl(this.shareControl)), this._mapboxLogoControl = mapboxLogoControl(this.options.mapboxLogoControl), this.addControl(this._mapboxLogoControl), this._loadTileJSON(o), this.on("layeradd", this._onLayerAdd, this).on("layerremove", this._onLayerRemove, this).on("moveend", this._updateMapFeedbackLink, this), this.whenReady(function () {
                    feedback.on("change", this._updateMapFeedbackLink, this)
                }), this.on("unload", function () {
                    feedback.off("change", this._updateMapFeedbackLink, this)
                })
            },
            _setTileJSON: function (t) {
                return this._tilejson = t, this._initialize(t), this
            },
            getTileJSON: function () {
                return this._tilejson
            },
            _initialize: function (t) {
                if (this.tileLayer && (this.tileLayer._setTileJSON(t), this._updateLayer(this.tileLayer)), this.featureLayer && !this.featureLayer.getGeoJSON() && t.data && t.data[0] && this.featureLayer.loadURL(t.data[0]), this.gridLayer && (this.gridLayer._setTileJSON(t), this._updateLayer(this.gridLayer)), this.infoControl && t.attribution && (this.infoControl.addInfo(this.options.sanitizer(t.attribution)), this._updateMapFeedbackLink()), this.legendControl && t.legend && this.legendControl.addLegend(t.legend), this.shareControl && this.shareControl._setTileJSON(t), this._mapboxLogoControl._setTileJSON(t), !this._loaded && t.center) {
                    var o = void 0 !== this.getZoom() ? this.getZoom() : t.center[2], e = L.latLng(t.center[1], t.center[0]);
                    this.setView(e, o)
                }
            },
            _updateMapFeedbackLink: function () {
                if (this._controlContainer.getElementsByClassName) {
                    var t = this._controlContainer.getElementsByClassName("mapbox-improve-map");
                    if (t.length && this._loaded) {
                        var o = this.getCenter().wrap(), e = this._tilejson || {}, i = e.id || "", n = "#" + i + "/" + o.lng.toFixed(3) + "/" + o.lat.toFixed(3) + "/" + this.getZoom();
                        for (var r in feedback.data)n += "/" + r + "=" + feedback.data[r];
                        for (var a = 0; a < t.length; a++)t[a].hash = n
                    }
                }
            },
            _onLayerAdd: function (t) {
                "on" in t.layer && t.layer.on("ready", this._onLayerReady, this), window.setTimeout(L.bind(this._updateMapFeedbackLink, this), 0)
            },
            _onLayerRemove: function (t) {
                "on" in t.layer && t.layer.off("ready", this._onLayerReady, this), window.setTimeout(L.bind(this._updateMapFeedbackLink, this), 0)
            },
            _onLayerReady: function (t) {
                this._updateLayer(t.target)
            },
            _updateLayer: function (t) {
                t.options && (this.infoControl && this._loaded && this.infoControl.addInfo(t.options.infoControl), this.attributionControl && this._loaded && t.getAttribution && this.attributionControl.addAttribution(t.getAttribution()), L.stamp(t) in this._zoomBoundLayers || !t.options.maxZoom && !t.options.minZoom || (this._zoomBoundLayers[L.stamp(t)] = t), this._updateMapFeedbackLink(), this._updateZoomLevels())
            }
        });
        module.exports.Map = LMap, module.exports.map = function (t, o, e) {
            return new LMap(t, o, e)
        };
    }, {"./feature_layer": 9, "./feedback": 10, "./grid_control": 15, "./grid_layer": 16, "./info_control": 18, "./legend_control": 20, "./load_tilejson": 21, "./mapbox_logo": 24, "./share_control": 27, "./tile_layer": 30, "sanitize-caja": 5}], 23: [function (require, module, exports) {
        "use strict";
        var geocoderControl = require("./geocoder_control"), gridControl = require("./grid_control"), featureLayer = require("./feature_layer"), legendControl = require("./legend_control"), shareControl = require("./share_control"), tileLayer = require("./tile_layer"), infoControl = require("./info_control"), map = require("./map"), gridLayer = require("./grid_layer"), styleLayer = require("./style_layer");
        L.mapbox = module.exports = {
            VERSION: require("../package.json").version,
            geocoder: require("./geocoder"),
            marker: require("./marker"),
            simplestyle: require("./simplestyle"),
            tileLayer: tileLayer.tileLayer,
            TileLayer: tileLayer.TileLayer,
            styleLayer: styleLayer.styleLayer,
            StyleLayer: styleLayer.StyleLayer,
            infoControl: infoControl.infoControl,
            InfoControl: infoControl.InfoControl,
            shareControl: shareControl.shareControl,
            ShareControl: shareControl.ShareControl,
            legendControl: legendControl.legendControl,
            LegendControl: legendControl.LegendControl,
            geocoderControl: geocoderControl.geocoderControl,
            GeocoderControl: geocoderControl.GeocoderControl,
            gridControl: gridControl.gridControl,
            GridControl: gridControl.GridControl,
            gridLayer: gridLayer.gridLayer,
            GridLayer: gridLayer.GridLayer,
            featureLayer: featureLayer.featureLayer,
            FeatureLayer: featureLayer.FeatureLayer,
            map: map.map,
            Map: map.Map,
            config: require("./config"),
            sanitize: require("sanitize-caja"),
            template: require("mustache").to_html,
            feedback: require("./feedback")
        }, window.L.Icon.Default.imagePath = ("https:" === document.location.protocol || "http:" === document.location.protocol ? "" : "https:") + "//api.tiles.mapbox.com/mapbox.js/v" + require("../package.json").version + "/images";
    }, {"../package.json": 7, "./config": 8, "./feature_layer": 9, "./feedback": 10, "./geocoder": 12, "./geocoder_control": 13, "./grid_control": 15, "./grid_layer": 16, "./info_control": 18, "./legend_control": 20, "./map": 22, "./marker": 25, "./share_control": 27, "./simplestyle": 28, "./style_layer": 29, "./tile_layer": 30, "mustache": 4, "sanitize-caja": 5}], 24: [function (require, module, exports) {
        "use strict";
        var MapboxLogoControl = L.Control.extend({
            options: {position: "bottomleft"}, initialize: function (o) {
                L.setOptions(this, o)
            }, onAdd: function () {
                return this._container = L.DomUtil.create("div", "mapbox-logo"), this._container
            }, _setTileJSON: function (o) {
                o.mapbox_logo && L.DomUtil.addClass(this._container, "mapbox-logo-true")
            }
        });
        module.exports.MapboxLogoControl = MapboxLogoControl, module.exports.mapboxLogoControl = function (o) {
            return new MapboxLogoControl(o)
        };
    }, {}], 25: [function (require, module, exports) {
        "use strict";
        function icon(r, e) {
            r = r || {};
            var i = {small: [20, 50], medium: [30, 70], large: [35, 90]}, t = r["marker-size"] || "medium", o = "marker-symbol" in r && "" !== r["marker-symbol"] ? "-" + r["marker-symbol"] : "", s = (r["marker-color"] || "7e7e7e").replace("#", "");
            return L.icon({iconUrl: format_url("/v4/marker/pin-" + t.charAt(0) + o + "+" + s + (L.Browser.retina ? "@2x" : "") + ".png", e && e.accessToken), iconSize: i[t], iconAnchor: [i[t][0] / 2, i[t][1] / 2], popupAnchor: [0, -i[t][1] / 2]})
        }

        function style(r, e, i) {
            return L.marker(e, {icon: icon(r.properties, i), title: util.strip_tags(sanitize(r.properties && r.properties.title || ""))})
        }

        function createPopup(r, e) {
            if (!r || !r.properties)return "";
            var i = "";
            return r.properties.title && (i += '<div class="marker-title">' + r.properties.title + "</div>"), r.properties.description && (i += '<div class="marker-description">' + r.properties.description + "</div>"), (e || sanitize)(i)
        }

        var format_url = require("./format_url"), util = require("./util"), sanitize = require("sanitize-caja");
        module.exports = {icon: icon, style: style, createPopup: createPopup};
    }, {"./format_url": 11, "./util": 31, "sanitize-caja": 5}], 26: [function (require, module, exports) {
        "use strict";
        var corslite = require("corslite"), strict = require("./util").strict, config = require("./config"), protocol = /^(https?:)?(?=\/\/(.|api)\.tiles\.mapbox\.com\/)/;
        module.exports = function (t, o) {
            function r(t, r) {
                !t && r && (r = JSON.parse(r.responseText)), o(t, r)
            }

            return strict(t, "string"), strict(o, "function"), t = t.replace(protocol, function (t, o) {
                return "withCredentials" in new window.XMLHttpRequest ? "https:" === o || "https:" === document.location.protocol || config.FORCE_HTTPS ? "https:" : "http:" : document.location.protocol
            }), corslite(t, r)
        };
    }, {"./config": 8, "./util": 31, "corslite": 1}], 27: [function (require, module, exports) {
        "use strict";
        var format_url = require("./format_url"), ShareControl = L.Control.extend({
            includes: [require("./load_tilejson")], options: {position: "topleft", url: ""}, initialize: function (t, e) {
                L.setOptions(this, e), this._loadTileJSON(t)
            }, _setTileJSON: function (t) {
                this._tilejson = t
            }, onAdd: function (t) {
                this._map = t;
                var e = L.DomUtil.create("div", "leaflet-control-mapbox-share leaflet-bar"), o = L.DomUtil.create("a", "mapbox-share mapbox-icon mapbox-icon-share", e);
                return o.href = "#", this._modal = L.DomUtil.create("div", "mapbox-modal", this._map._container), this._mask = L.DomUtil.create("div", "mapbox-modal-mask", this._modal), this._content = L.DomUtil.create("div", "mapbox-modal-content", this._modal), L.DomEvent.addListener(o, "click", this._shareClick, this), L.DomEvent.disableClickPropagation(e), this._map.on("mousedown", this._clickOut, this), e
            }, _clickOut: function (t) {
                return this._sharing ? (L.DomEvent.preventDefault(t), L.DomUtil.removeClass(this._modal, "active"), this._content.innerHTML = "", void(this._sharing = null)) : void 0
            }, _shareClick: function (t) {
                function e(t, e, o) {
                    var i = document.createElement("a");
                    return i.setAttribute("class", t), i.setAttribute("href", e), i.setAttribute("target", "_blank"), o = document.createTextNode(o), i.appendChild(o), i
                }

                if (L.DomEvent.stop(t), this._sharing)return this._clickOut(t);
                var o = this._tilejson || this._map._tilejson || {}, i = encodeURIComponent(this.options.url || o.webpage || window.location), a = encodeURIComponent(o.name), n = format_url("/v4/" + o.id + "/" + this._map.getCenter().lng + "," + this._map.getCenter().lat + "," + this._map.getZoom() + "/600x600.png", this.options.accessToken), r = format_url("/v4/" + o.id + ".html", this.options.accessToken), s = "//twitter.com/intent/tweet?status=" + a + " " + i, l = "//www.facebook.com/sharer.php?u=" + i + "&t=" + a, m = "//www.pinterest.com/pin/create/button/?url=" + i + "&media=" + n + "&description=" + a, c = '<iframe width="100%" height="500px" frameBorder="0" src="' + r + '"></iframe>', h = "Copy and paste this <strong>HTML code</strong> into documents to embed this map on web pages.";
                L.DomUtil.addClass(this._modal, "active"), this._sharing = L.DomUtil.create("div", "mapbox-modal-body", this._content);
                var p = e("mapbox-button mapbox-button-icon mapbox-icon-twitter", s, "Twitter"), d = e("mapbox-button mapbox-button-icon mapbox-icon-facebook", l, "Facebook"), u = e("mapbox-button mapbox-button-icon mapbox-icon-pinterest", m, "Pinterest"), b = document.createElement("h3"), _ = document.createTextNode("Share this map");
                b.appendChild(_);
                var v = document.createElement("div");
                v.setAttribute("class", "mapbox-share-buttons"), v.appendChild(d), v.appendChild(p), v.appendChild(u), this._sharing.appendChild(b), this._sharing.appendChild(v);
                var x = L.DomUtil.create("input", "mapbox-embed", this._sharing);
                x.type = "text", x.value = c;
                var f = L.DomUtil.create("label", "mapbox-embed-description", this._sharing);
                f.innerHTML = h;
                var g = L.DomUtil.create("a", "leaflet-popup-close-button", this._sharing);
                g.href = "#", L.DomEvent.disableClickPropagation(this._sharing), L.DomEvent.addListener(g, "click", this._clickOut, this), L.DomEvent.addListener(x, "click", function (t) {
                    t.target.focus(), t.target.select()
                })
            }
        });
        module.exports.ShareControl = ShareControl, module.exports.shareControl = function (t, e) {
            return new ShareControl(t, e)
        };
    }, {"./format_url": 11, "./load_tilejson": 21}], 28: [function (require, module, exports) {
        "use strict";
        function fallback(t, l) {
            var i = {};
            for (var r in l)void 0 === t[r] ? i[r] = l[r] : i[r] = t[r];
            return i
        }

        function remap(t) {
            for (var l = {}, i = 0; i < mapping.length; i++)l[mapping[i][1]] = t[mapping[i][0]];
            return l
        }

        function style(t) {
            return remap(fallback(t.properties || {}, defaults))
        }

        var defaults = {stroke: "#555555", "stroke-width": 2, "stroke-opacity": 1, fill: "#555555", "fill-opacity": .5}, mapping = [["stroke", "color"], ["stroke-width", "weight"], ["stroke-opacity", "opacity"], ["fill", "fillColor"], ["fill-opacity", "fillOpacity"]];
        module.exports = {style: style, defaults: defaults};
    }, {}], 29: [function (require, module, exports) {
        "use strict";
        var util = require("./util"), format_url = require("./format_url"), request = require("./request"), StyleLayer = L.TileLayer.extend({
            options: {sanitizer: require("sanitize-caja")}, initialize: function (t, i) {
                L.TileLayer.prototype.initialize.call(this, void 0, i), this.options.tiles = this._formatTileURL(t), this.options.tileSize = 512, this.options.zoomOffset = -1, this.options.tms = !1, this._getAttribution(t)
            }, _getAttribution: function (t) {
                var i = format_url.style(t, this.options && this.options.accessToken);
                request(i, L.bind(function (e, r) {
                    e && (util.log("could not load Mapbox style at " + i), this.fire("error", {error: e}));
                    var o = [];
                    for (var s in r.sources) {
                        var l = r.sources[s].url.split("mapbox://")[1];
                        o.push(l)
                    }
                    request(format_url.tileJSON(o.join(), this.options.accessToken), L.bind(function (i, e) {
                        i ? (util.log("could not load TileJSON at " + t), this.fire("error", {error: i})) : e && (util.strict(e, "object"), this.options.attribution = this.options.sanitizer(e.attribution), this._tilejson = e, this.fire("ready"))
                    }, this))
                }, this))
            }, setUrl: null, _formatTileURL: function (t) {
                var i = L.Browser.retina ? "@2x" : "";
                if ("string" == typeof t) {
                    -1 === t.indexOf("mapbox://styles/") && (util.log("Incorrectly formatted Mapbox style at " + t), this.fire("error"));
                    var e = t.split("mapbox://styles/")[1];
                    return format_url("/styles/v1/" + e + "/tiles/{z}/{x}/{y}" + i, this.options.accessToken)
                }
                return "object" == typeof t ? format_url("/styles/v1/" + t.owner + "/" + t.id + "/tiles/{z}/{x}/{y}" + i, this.options.accessToken) : void 0
            }, getTileUrl: function (t) {
                var i = L.Util.template(this.options.tiles, t);
                return i
            }
        });
        module.exports.StyleLayer = StyleLayer, module.exports.styleLayer = function (t, i) {
            return new StyleLayer(t, i)
        };
    }, {"./format_url": 11, "./request": 26, "./util": 31, "sanitize-caja": 5}], 30: [function (require, module, exports) {
        "use strict";
        var util = require("./util"), formatPattern = /\.((?:png|jpg)\d*)(?=$|\?)/, TileLayer = L.TileLayer.extend({
            includes: [require("./load_tilejson")], options: {sanitizer: require("sanitize-caja")}, formats: ["png", "jpg", "png32", "png64", "png128", "png256", "jpg70", "jpg80", "jpg90"], scalePrefix: "@2x.", initialize: function (t, i) {
                L.TileLayer.prototype.initialize.call(this, void 0, i), this._tilejson = {}, i && i.format && util.strict_oneof(i.format, this.formats), this._loadTileJSON(t)
            }, setFormat: function (t) {
                return util.strict(t, "string"), this.options.format = t, this.redraw(), this
            }, setUrl: null, _setTileJSON: function (t) {
                return util.strict(t, "object"), this.options.format = this.options.format || t.tiles[0].match(formatPattern)[1], L.extend(this.options, {tiles: t.tiles, attribution: this.options.sanitizer(t.attribution), minZoom: t.minzoom || 0, maxZoom: t.maxzoom || 18, tms: "tms" === t.scheme, bounds: t.bounds && util.lbounds(t.bounds)}), this._tilejson = t, this.redraw(), this
            }, getTileJSON: function () {
                return this._tilejson
            }, getTileUrl: function (t) {
                var i = this.options.tiles, e = Math.floor(Math.abs(t.x + t.y) % i.length), o = i[e], r = L.Util.template(o, t);
                return r ? r.replace(formatPattern, (L.Browser.retina ? this.scalePrefix : ".") + this.options.format) : r
            }, _update: function () {
                this.options.tiles && L.TileLayer.prototype._update.call(this)
            }
        });
        module.exports.TileLayer = TileLayer, module.exports.tileLayer = function (t, i) {
            return new TileLayer(t, i)
        };
    }, {"./load_tilejson": 21, "./util": 31, "sanitize-caja": 5}], 31: [function (require, module, exports) {
        "use strict";
        function contains(n, t) {
            if (!t || !t.length)return !1;
            for (var r = 0; r < t.length; r++)if (t[r] === n)return !0;
            return !1
        }

        module.exports = {
            idUrl: function (n, t) {
                -1 === n.indexOf("/") ? t.loadID(n) : t.loadURL(n)
            }, log: function (n) {
                "object" == typeof console && "function" == typeof console.error && console.error(n)
            }, strict: function (n, t) {
                if (typeof n !== t)throw new Error("Invalid argument: " + t + " expected")
            }, strict_instance: function (n, t, r) {
                if (!(n instanceof t))throw new Error("Invalid argument: " + r + " expected")
            }, strict_oneof: function (n, t) {
                if (!contains(n, t))throw new Error("Invalid argument: " + n + " given, valid values are " + t.join(", "))
            }, strip_tags: function (n) {
                return n.replace(/<[^<]+>/g, "")
            }, lbounds: function (n) {
                return new L.LatLngBounds([[n[1], n[0]], [n[3], n[2]]])
            }
        };
    }, {}]
}, {}, [17])


//# sourceMappingURL=mapbox.js.map