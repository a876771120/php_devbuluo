define("pjax", ["jquery"], function(v) {
    function t(t, e, n) {
      return (
        (n = u(e, n)),
        this.on("click.pjax", t, function(t) {
          var e = n;
          e.container ||
            ((e = v.extend({}, n)).container = v(this).attr("data-pjax")),
            a(t, e);
        })
      );
    }
    function a(t, e, n) {
      n = u(e, n);
      var a = t.currentTarget,
        r = v(a);
      if ("A" !== a.tagName.toUpperCase())
        throw "$.fn.pjax or $.pjax.click requires an anchor element";
      if (
        !(
          1 < t.which ||
          t.metaKey ||
          t.ctrlKey ||
          t.shiftKey ||
          t.altKey ||
          location.protocol !== a.protocol ||
          location.hostname !== a.hostname ||
          (-1 < a.href.indexOf("#") && s(a) == s(location)) ||
          t.isDefaultPrevented()
        )
      ) {
        var i = { url: a.href, container: r.attr("data-pjax"), target: a },
          o = v.extend({}, i, n),
          c = v.Event("pjax:click");
        r.trigger(c, [o]),
          c.isDefaultPrevented() ||
            (x(o), t.preventDefault(), r.trigger("pjax:clicked", [o]));
      }
    }
    function e(t, e, n) {
      n = u(e, n);
      var a = t.currentTarget,
        r = v(a);
      if ("FORM" !== a.tagName.toUpperCase())
        throw "$.pjax.submit requires a form element";
      var i = {
        type: (r.attr("method") || "GET").toUpperCase(),
        url: r.attr("action"),
        container: r.attr("data-pjax"),
        target: a
      };
      if ("GET" !== i.type && void 0 !== window.FormData)
        (i.data = new FormData(a)), (i.processData = !1), (i.contentType = !1);
      else {
        if (r.find(":file").length) return;
        i.data = r.serializeArray();
      }
      x(v.extend({}, i, n)), t.preventDefault();
    }
    function x(d) {
      (d = v.extend(!0, {}, v.ajaxSettings, x.defaults, d)),
        v.isFunction(d.url) && (d.url = d.url());
      var f = b(d.url).hash,
        t = v.type(d.container);
      if ("string" !== t)
        throw "expected string value for 'container' option; got " + t;
      var a,
        h = (d.context = v(d.container));
      if (!h.length)
        throw "the container selector '" +
          d.container +
          "' did not match anything";
      function m(t, e, n) {
        (n = n || {}).relatedTarget = d.target;
        var a = v.Event(t, n);
        return h.trigger(a, e), !a.isDefaultPrevented();
      }
      d.data || (d.data = {}),
        v.isArray(d.data)
          ? d.data.push({ name: "_pjax", value: d.container })
          : (d.data._pjax = d.container),
        (d.beforeSend = function(t, e) {
          if (
            ("GET" !== e.type && (e.timeout = 0),
            t.setRequestHeader("X-PJAX", "true"),
            t.setRequestHeader("X-PJAX-Container", d.container),
            !m("pjax:beforeSend", [t, e]))
          )
            return !1;
          0 < e.timeout &&
            ((a = setTimeout(function() {
              m("pjax:timeout", [t, d]) && t.abort("timeout");
            }, e.timeout)),
            (e.timeout = 0));
          var n = b(e.url);
          f && (n.hash = f), (d.requestUrl = l(n));
        }),
        (d.complete = function(t, e) {
          a && clearTimeout(a),
            m("pjax:complete", [t, e, d]),
            m("pjax:end", [t, d]);
        }),
        (d.error = function(t, e, n) {
          var a = T("", t, d),
            r = m("pjax:error", [t, e, n, d]);
          "GET" == d.type && "abort" !== e && r && g(a.url);
        }),
        (d.success = function(t, e, n) {
          var a = x.state,
            r =
              "function" == typeof v.pjax.defaults.version
                ? v.pjax.defaults.version()
                : v.pjax.defaults.version,
            i = n.getResponseHeader("X-PJAX-Version"),
            o = T(t, n, d),
            c = b(o.url);
          if ((f && ((c.hash = f), (o.url = c.href)), r && i && r !== i))
            g(o.url);
          else if (o.contents) {
            if (
              ((x.state = {
                id: d.id || j(),
                url: o.url,
                title: o.title,
                container: d.container,
                fragment: d.fragment,
                timeout: d.timeout
              }),
              (d.push || d.replace) &&
                window.history.replaceState(x.state, o.title, o.url),
              v.contains(h, document.activeElement))
            )
              try {
                document.activeElement.blur();
              } catch (t) {}
            o.title && (document.title = o.title),
              m("pjax:beforeReplace", [o.contents, d], {
                state: x.state,
                previousState: a
              }),
              h.html(o.contents);
            var s = h.find("input[autofocus], textarea[autofocus]").last()[0];
            s && document.activeElement !== s && s.focus(),
              (function(t) {
                if (!t) return;
                var a = v("script[src]");
                t.each(function() {
                  var t = this.src;
                  if (
                    !a.filter(function() {
                      return this.src === t;
                    }).length
                  ) {
                    var e = document.createElement("script"),
                      n = v(this).attr("type");
                    n && (e.type = n),
                      (e.src = v(this).attr("src")),
                      document.head.appendChild(e);
                  }
                });
              })(o.scripts);
            var u = d.scrollTo;
            if (f) {
              var l = decodeURIComponent(f.slice(1)),
                p =
                  document.getElementById(l) ||
                  document.getElementsByName(l)[0];
              p && (u = v(p).offset().top);
            }
            "number" == typeof u && v(window).scrollTop(u),
              m("pjax:success", [t, e, n, d]);
          } else g(o.url);
        }),
        x.state ||
          ((x.state = {
            id: j(),
            url: window.location.href,
            title: document.title,
            container: d.container,
            fragment: d.fragment,
            timeout: d.timeout
          }),
          window.history.replaceState(x.state, document.title)),
        y(x.xhr),
        (x.options = d);
      var e = (x.xhr = v.ajax(d));
      return (
        0 < e.readyState &&
          (d.push &&
            !d.replace &&
            ((function(t, e) {
              (E[t] = e), P.push(t), C(S, 0), C(P, x.defaults.maxCacheLength);
            })(x.state.id, [d.container, w(h)]),
            window.history.pushState(null, "", d.requestUrl)),
          m("pjax:start", [e, d]),
          m("pjax:send", [e, d])),
        x.xhr
      );
    }
    function n(t, e) {
      var n = {
        url: window.location.href,
        push: !1,
        replace: !0,
        scrollTo: !1
      };
      return x(v.extend(n, u(t, e)));
    }
    function g(t) {
      window.history.replaceState(null, "", x.state.url),
        window.location.replace(t);
    }
    var p = !0,
      d = window.location.href,
      r = window.history.state;
    function i(t) {
      p || y(x.xhr);
      var e,
        n = x.state,
        a = t.state;
      if (a && a.container) {
        if (p && d == a.url) return;
        if (n) {
          if (n.id === a.id) return;
          e = n.id < a.id ? "forward" : "back";
        }
        var r = E[a.id] || [],
          i = r[0] || a.container,
          o = v(i),
          c = r[1];
        if (o.length) {
          n &&
            (function(t, e, n) {
              var a, r;
              (E[e] = n), (r = "forward" === t ? ((a = P), S) : ((a = S), P));
              a.push(e), (e = r.pop()) && delete E[e];
              C(a, x.defaults.maxCacheLength);
            })(e, n.id, [i, w(o)]);
          var s = v.Event("pjax:popstate", { state: a, direction: e });
          o.trigger(s);
          var u = {
            id: a.id,
            url: a.url,
            container: i,
            push: !1,
            fragment: a.fragment,
            timeout: a.timeout,
            scrollTo: !1
          };
          if (c) {
            o.trigger("pjax:start", [null, u]),
              (x.state = a).title && (document.title = a.title);
            var l = v.Event("pjax:beforeReplace", {
              state: a,
              previousState: n
            });
            o.trigger(l, [c, u]), o.html(c), o.trigger("pjax:end", [null, u]);
          } else x(u);
          o[0].offsetHeight;
        } else g(location.href);
      }
      p = !1;
    }
    function o(t) {
      var e = v.isFunction(t.url) ? t.url() : t.url,
        n = t.type ? t.type.toUpperCase() : "GET",
        a = v("<form>", {
          method: "GET" === n ? "GET" : "POST",
          action: e,
          style: "display:none"
        });
      "GET" !== n &&
        "POST" !== n &&
        a.append(
          v("<input>", {
            type: "hidden",
            name: "_method",
            value: n.toLowerCase()
          })
        );
      var r = t.data;
      if ("string" == typeof r)
        v.each(r.split("&"), function(t, e) {
          var n = e.split("=");
          a.append(v("<input>", { type: "hidden", name: n[0], value: n[1] }));
        });
      else if (v.isArray(r))
        v.each(r, function(t, e) {
          a.append(
            v("<input>", { type: "hidden", name: e.name, value: e.value })
          );
        });
      else if ("object" == typeof r) {
        var i;
        for (i in r)
          a.append(v("<input>", { type: "hidden", name: i, value: r[i] }));
      }
      v(document.body).append(a), a.submit();
    }
    function y(t) {
      t && t.readyState < 4 && ((t.onreadystatechange = v.noop), t.abort());
    }
    function j() {
      return new Date().getTime();
    }
    function w(t) {
      var e = t.clone();
      return (
        e.find("script").each(function() {
          this.src || v._data(this, "globalEval", !1);
        }),
        e.contents()
      );
    }
    function l(t) {
      return (
        (t.search = t.search
          .replace(/([?&])(_pjax|_)=[^&]*/g, "")
          .replace(/^&/, "")),
        t.href.replace(/\?($|#)/, "$1")
      );
    }
    function b(t) {
      var e = document.createElement("a");
      return (e.href = t), e;
    }
    function s(t) {
      return t.href.replace(/#.*/, "");
    }
    function u(t, e) {
      return t && e
        ? (((e = v.extend({}, e)).container = t), e)
        : v.isPlainObject(t)
        ? t
        : { container: t };
    }
    function f(t, e) {
      return t.filter(e).add(t.find(e));
    }
    function h(t) {
      return v.parseHTML(t, document, !0);
    }
    function T(t, e, n) {
      var a,
        r,
        i = {},
        o = /<html/i.test(t),
        c = e.getResponseHeader("X-PJAX-URL");
      if (((i.url = c ? l(b(c)) : n.requestUrl), o)) {
        r = v(h(t.match(/<body[^>]*>([\s\S.]*)<\/body>/i)[0]));
        var s = t.match(/<head[^>]*>([\s\S.]*)<\/head>/i);
        a = null != s ? v(h(s[0])) : r;
      } else a = r = v(h(t));
      if (0 === r.length) return i;
      if (
        ((i.title = f(a, "title")
          .last()
          .text()),
        n.fragment)
      ) {
        var u = r;
        "body" !== n.fragment && (u = f(u, n.fragment).first()),
          u.length &&
            ((i.contents = "body" === n.fragment ? u : u.contents()),
            i.title || (i.title = u.attr("title") || u.data("title")));
      } else o || (i.contents = r);
      return (
        i.contents &&
          ((i.contents = i.contents.not(function() {
            return v(this).is("title");
          })),
          i.contents.find("title").remove(),
          (i.scripts = f(i.contents, "script[src]").remove()),
          (i.contents = i.contents.not(i.scripts))),
        i.title && (i.title = v.trim(i.title)),
        i
      );
    }
    r && r.container && (x.state = r), "state" in window.history && (p = !1);
    var E = {},
      S = [],
      P = [];
    function C(t, e) {
      for (; t.length > e; ) delete E[t.shift()];
    }
    function c() {
      return v("meta")
        .filter(function() {
          var t = v(this).attr("http-equiv");
          return t && "X-PJAX-VERSION" === t.toUpperCase();
        })
        .attr("content");
    }
    function m() {
      (v.fn.pjax = t),
        (v.pjax = x),
        (v.pjax.enable = v.noop),
        (v.pjax.disable = A),
        (v.pjax.click = a),
        (v.pjax.submit = e),
        (v.pjax.reload = n),
        (v.pjax.defaults = {
          timeout: 650,
          push: !0,
          replace: !1,
          type: "GET",
          dataType: "html",
          scrollTo: 0,
          maxCacheLength: 20,
          version: c
        }),
        v(window).on("popstate.pjax", i);
    }
    function A() {
      (v.fn.pjax = function() {
        return this;
      }),
        (v.pjax = o),
        (v.pjax.enable = m),
        (v.pjax.disable = v.noop),
        (v.pjax.click = v.noop),
        (v.pjax.submit = v.noop),
        (v.pjax.reload = function() {
          window.location.reload();
        }),
        v(window).off("popstate.pjax", i);
    }
    v.event.props && v.inArray("state", v.event.props) < 0
      ? v.event.props.push("state")
      : "state" in v.Event.prototype || v.event.addProp("state"),
      (v.support.pjax =
        window.history &&
        window.history.pushState &&
        window.history.replaceState &&
        !navigator.userAgent.match(
          /((iPod|iPhone|iPad).+\bOS\s+[1-4]\D|WebApps\/.+CFNetwork)/
        )),
      v.support.pjax ? m() : A();
  });