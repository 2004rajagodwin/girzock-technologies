/* GIRZOCK Technologies: small additions to the template's main.js. */
(function () {
  "use strict";

  var SITE = window.GIRZOCK_SITE || {};
  var EMAIL = SITE.email || "girzock@gmail.com";
  var PHONE = SITE.phone || "+91 6379362330";

  // Posts a form to the server with its CSRF token and resolves with the parsed JSON reply.
  // 422 and 429 replies carry a message for the visitor; other failures reject.
  function postForm(form) {
    var controller = "AbortController" in window ? new AbortController() : null;
    var timer = controller && setTimeout(function () {
      controller.abort();
    }, 30000);
    return fetch(form.getAttribute("action"), {
      method: "POST",
      headers: { Accept: "application/json", "X-Requested-With": "XMLHttpRequest" },
      body: new FormData(form),
      credentials: "same-origin",
      signal: controller ? controller.signal : undefined,
    })
      .then(function (response) {
        if (response.ok || response.status === 422 || response.status === 429) return response.json();
        throw new Error("HTTP " + response.status);
      })
      .finally(function () {
        if (timer) clearTimeout(timer);
      });
  }

  // The side panel links have a real target for crawlers, but must not jump the page when clicked.
  document.querySelectorAll("a[href='#sideMenu']").forEach(function (link) {
    link.addEventListener("click", function (event) {
      event.preventDefault();
    });
  });

  // Portfolio gallery titles open the project page instead of the lightbox.
  document.querySelectorAll("a[data-gz-nav]").forEach(function (link) {
    link.addEventListener("click", function (event) {
      event.stopPropagation();
    });
  });

  // Development process: on desktop the cards stay in a sticky stage and change with scroll.
  // Small screens and reduced-motion users get the plain stacked list from the CSS.
  (function () {
    var section = document.getElementById("process");
    if (!section || !section.classList.contains("girzock-process")) return;
    var track = section.querySelector(".girzock-process-track");
    var stage = section.querySelector(".girzock-process-stage");
    var cards = Array.prototype.slice.call(section.querySelectorAll(".girzock-step"));
    var wide = window.matchMedia("(min-width: 992px)");
    var calm = window.matchMedia("(prefers-reduced-motion: reduce)");
    var active = -1;
    var ticking = false;

    function setActive(index) {
      if (index === active) return;
      active = index;
      cards.forEach(function (card, i) {
        card.setAttribute("data-pos", String(Math.max(-1, Math.min(3, i - index))));
      });
    }
    function update() {
      ticking = false;
      if (!section.classList.contains("is-enhanced")) return;
      var box = track.getBoundingClientRect();
      var range = box.height - stage.offsetHeight;
      var offset = parseFloat(getComputedStyle(stage).top) || 0;
      var progress = range > 0 ? Math.max(0, Math.min(1, (offset - box.top) / range)) : 0;
      setActive(Math.min(cards.length - 1, Math.floor(progress * cards.length)));
    }
    function requestUpdate() {
      if (!ticking) {
        ticking = true;
        requestAnimationFrame(update);
      }
    }
    function apply() {
      var on = wide.matches && !calm.matches;
      section.classList.toggle("is-enhanced", on);
      if (!on) {
        active = -1;
        cards.forEach(function (card) {
          card.removeAttribute("data-pos");
        });
      }
      update();
    }
    apply();
    window.addEventListener("scroll", requestUpdate, { passive: true });
    window.addEventListener("resize", requestUpdate);
    [wide, calm].forEach(function (query) {
      query.addEventListener("change", function () {
        apply();
        if (window.ScrollTrigger) window.ScrollTrigger.refresh();
      });
    });
  })();

  // One notification style for every form. Success is shown only after the server confirms the save.
  var Toast = (function () {
    var box = null;
    var ICON = { success: "\u2713", error: "!" };
    function container() {
      if (box) return box;
      box = document.createElement("div");
      box.className = "gz-toasts";
      document.body.appendChild(box);
      return box;
    }
    function show(kind, message, detail) {
      var item = document.createElement("div");
      item.className = "gz-toast gz-toast-" + kind;
      item.setAttribute("role", kind === "error" ? "alert" : "status");
      item.setAttribute("aria-live", kind === "error" ? "assertive" : "polite");
      item.innerHTML = '<span class="gz-toast-icon" aria-hidden="true"></span><div class="gz-toast-text"><p></p><small></small></div><button type="button" class="gz-toast-close" aria-label="Close notification">&times;</button>';
      item.querySelector(".gz-toast-icon").textContent = ICON[kind] || "i";
      item.querySelector("p").textContent = message;
      var small = item.querySelector("small");
      if (detail) small.textContent = detail;
      else small.remove();
      container().appendChild(item);
      var timer = null;
      function remove() {
        clearTimeout(timer);
        item.classList.remove("is-shown");
        setTimeout(function () {
          if (item.parentNode) item.parentNode.removeChild(item);
        }, 350);
      }
      function schedule() {
        clearTimeout(timer);
        timer = setTimeout(remove, 3500);
      }
      item.querySelector(".gz-toast-close").addEventListener("click", remove);
      item.addEventListener("mouseenter", function () { clearTimeout(timer); });
      item.addEventListener("mouseleave", schedule);
      requestAnimationFrame(function () {
        requestAnimationFrame(function () { item.classList.add("is-shown"); });
      });
      schedule();
      return item;
    }
    return { show: show };
  })();
  window.GirzockToast = Toast;
  var MSG_ERROR = "Something went wrong. Please try again or contact us directly.";
  var MSG_INVALID = "Please check the highlighted fields and try again.";
  function referenceLine(reply) {
    return reply && reply.reference ? "Reference: " + reply.reference : "";
  }
  // "Get in Touch" forms on the inner pages. Without JavaScript they post normally to the same URL.
  document.querySelectorAll("form[data-girzock-form]").forEach(function (form) {
    var busy = false;
    var serviceSelect = form.elements.service;
    var serviceTrigger = serviceSelect && serviceSelect.id ? enhanceSelect(serviceSelect, form) : null;
    if (serviceTrigger) {
      // The real select is hidden, so its "required" message is shown beside the dropdown instead
      var serviceError = document.getElementById(serviceSelect.id + "-error");
      var clearServiceError = function () {
        serviceTrigger.removeAttribute("aria-invalid");
        serviceError.textContent = "";
      };
      serviceSelect.addEventListener("invalid", function (event) {
        event.preventDefault();
        serviceTrigger.setAttribute("aria-invalid", "true");
        serviceError.textContent = "Please select a service.";
        if (form.querySelector(":invalid") === serviceSelect) serviceTrigger.focus();
      });
      serviceSelect.addEventListener("change", clearServiceError);
      form.addEventListener("reset", clearServiceError);
    }
    form.addEventListener("submit", function (event) {
      event.preventDefault();
      if (busy) return;
      var status = form.querySelector(".girzock-form-status");
      var button = form.querySelector("button[type='submit']");
      function say(kind, message) {
        status.className = "girzock-form-status" + (kind ? " is-" + kind : "");
        status.textContent = message;
      }
      busy = true;
      button.disabled = true;
      button.setAttribute("aria-busy", "true");
      button.classList.add("is-loading");
      say("", "Sending...");
      postForm(form)
        .then(function (reply) {
          if (reply.ok) {
            form.reset();
            say("", "");
            Toast.show("success", reply.message);
          } else {
            var errors = reply.errors ? Object.keys(reply.errors).map(function (key) { return reply.errors[key]; }) : [];
            say("error", errors.length ? errors.join(" ") : reply.message);
            Toast.show("error", reply.errors ? MSG_INVALID : reply.message || MSG_ERROR);
          }
        })
        .catch(function () {
          say("error", "Your details are still here, so you can try again, or write to " + EMAIL + ".");
          Toast.show("error", MSG_ERROR);
        })
        .then(function () {
          busy = false;
          button.disabled = false;
          button.removeAttribute("aria-busy");
          button.classList.remove("is-loading");
        });
    });
  });

  // Custom dropdown over a real select, which keeps the value and is the fallback without JavaScript.
  // Follows the ARIA select-only combobox pattern. Returns the button that takes focus.
  function enhanceSelect(select, form) {
    if (!select) return null;
    var wrap = document.createElement("div");
    wrap.className = "girzock-select is-enhanced";
    select.parentNode.insertBefore(wrap, select);
    wrap.appendChild(select);
    select.tabIndex = -1;
    select.setAttribute("aria-hidden", "true");

    var listId = select.id + "-list";
    var trigger = document.createElement("button");
    trigger.type = "button";
    trigger.id = select.id + "-trigger";
    trigger.className = "girzock-select-trigger";
    trigger.setAttribute("role", "combobox");
    trigger.setAttribute("aria-haspopup", "listbox");
    trigger.setAttribute("aria-expanded", "false");
    trigger.setAttribute("aria-controls", listId);
    trigger.setAttribute("aria-labelledby", select.id + "-label " + trigger.id);
    trigger.setAttribute("aria-required", "true");
    trigger.setAttribute("aria-describedby", select.getAttribute("aria-describedby"));
    var valueEl = document.createElement("span");
    trigger.appendChild(valueEl);
    trigger.insertAdjacentHTML("beforeend", '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="m6 9 6 6 6-6"/></svg>');
    wrap.appendChild(trigger);

    var list = document.createElement("ul");
    list.id = listId;
    list.className = "girzock-select-list";
    list.setAttribute("role", "listbox");
    list.setAttribute("aria-labelledby", select.id + "-label");
    list.setAttribute("data-lenis-prevent", "");
    var optionEls = [];
    Array.prototype.forEach.call(select.options, function (option, i) {
      if (!option.value) return;
      var li = document.createElement("li");
      li.id = select.id + "-opt-" + i;
      li.setAttribute("role", "option");
      li.setAttribute("aria-selected", "false");
      li.setAttribute("data-value", option.value);
      li.textContent = option.textContent;
      list.appendChild(li);
      optionEls.push(li);
    });
    wrap.appendChild(list);

    var activeIndex = -1;
    var typed = "";
    var typedTimer = null;
    function isOpen() {
      return wrap.classList.contains("is-open");
    }
    function sync() {
      var chosen = select.options[select.selectedIndex];
      valueEl.textContent = chosen ? chosen.textContent : "";
      trigger.classList.toggle("is-placeholder", !select.value);
      optionEls.forEach(function (li) {
        li.setAttribute("aria-selected", li.getAttribute("data-value") === select.value ? "true" : "false");
      });
    }
    function setActive(index) {
      activeIndex = index;
      optionEls.forEach(function (li, i) {
        li.classList.toggle("is-active", i === index);
      });
      if (index >= 0) {
        trigger.setAttribute("aria-activedescendant", optionEls[index].id);
        var li = optionEls[index];
        if (li.offsetTop < list.scrollTop) list.scrollTop = li.offsetTop;
        else if (li.offsetTop + li.offsetHeight > list.scrollTop + list.clientHeight) list.scrollTop = li.offsetTop + li.offsetHeight - list.clientHeight;
      } else {
        trigger.removeAttribute("aria-activedescendant");
      }
    }
    function open() {
      if (isOpen()) return;
      var box = trigger.getBoundingClientRect();
      // Fit the list inside both the screen and the rounded panel, which clips anything past its edge
      var panel = wrap.closest(".girzock-contact-panel, .gz-popup-scroll");
      var bounds = panel ? panel.getBoundingClientRect() : { top: 0, bottom: window.innerHeight };
      var below = Math.min(window.innerHeight, bounds.bottom) - box.bottom - 16;
      var above = box.top - Math.max(115, bounds.top) - 16;
      var up = below < 240 && above > below;
      wrap.classList.toggle("opens-up", up);
      list.style.maxHeight = Math.max(160, Math.min(340, up ? above : below)) + "px";
      wrap.classList.add("is-open");
      trigger.setAttribute("aria-expanded", "true");
      var current = -1;
      optionEls.forEach(function (li, i) {
        if (li.getAttribute("data-value") === select.value) current = i;
      });
      setActive(current >= 0 ? current : 0);
    }
    function close() {
      wrap.classList.remove("is-open");
      trigger.setAttribute("aria-expanded", "false");
      setActive(-1);
    }
    function choose(index) {
      if (index < 0) return;
      select.value = optionEls[index].getAttribute("data-value");
      sync();
      select.dispatchEvent(new Event("change", { bubbles: true }));
    }
    trigger.addEventListener("click", function () {
      if (isOpen()) close();
      else open();
    });
    trigger.addEventListener("keydown", function (event) {
      var key = event.key;
      if (key === "Tab") {
        if (isOpen()) {
          choose(activeIndex);
          close();
        }
        return;
      }
      if (!isOpen()) {
        if (key === "ArrowDown" || key === "ArrowUp" || key === "Enter" || key === " ") {
          event.preventDefault();
          open();
        } else if (key.length === 1) {
          open();
        } else {
          return;
        }
        if (key.length !== 1 || key === " ") return;
      }
      if (key === "ArrowDown") setActive(Math.min(optionEls.length - 1, activeIndex + 1));
      else if (key === "ArrowUp") setActive(Math.max(0, activeIndex - 1));
      else if (key === "Home") setActive(0);
      else if (key === "End") setActive(optionEls.length - 1);
      else if (key === "Enter" || key === " ") {
        choose(activeIndex);
        close();
      } else if (key === "Escape") {
        close();
      } else if (key.length === 1) {
        typed += key.toLowerCase();
        clearTimeout(typedTimer);
        typedTimer = setTimeout(function () {
          typed = "";
        }, 600);
        for (var i = 0; i < optionEls.length; i++) {
          if (optionEls[i].textContent.toLowerCase().indexOf(typed) === 0) {
            setActive(i);
            break;
          }
        }
      } else {
        return;
      }
      event.preventDefault();
    });
    list.addEventListener("mousedown", function (event) {
      event.preventDefault();
    });
    list.addEventListener("mousemove", function (event) {
      var index = optionEls.indexOf(event.target);
      if (index >= 0 && index !== activeIndex) setActive(index);
    });
    list.addEventListener("click", function (event) {
      var index = optionEls.indexOf(event.target);
      if (index < 0) return;
      choose(index);
      close();
      trigger.focus();
    });
    trigger.addEventListener("blur", close);
    // Safari does not focus a button when it is clicked, so Escape is also handled here
    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape" && isOpen()) close();
    });
    select.addEventListener("change", sync);
    document.addEventListener("click", function (event) {
      if (!wrap.contains(event.target)) close();
    });
    form.addEventListener("reset", function () {
      setTimeout(sync);
    });
    sync();
    return trigger;
  }

  // Homepage project enquiry form. Posts to Contact::submit, which validates again on the server,
  // saves the enquiry and sends the emails. Success is shown only after the server confirms the save.
  document.querySelectorAll("form[data-girzock-enquiry]").forEach(function (form) {
    var status = form.querySelector(".girzock-enquiry-status");
    var button = form.querySelector("button[type='submit']");
    var buttonLabel = button.querySelector("span");
    var idleLabel = buttonLabel.textContent;
    var busy = false;
    var CONTACT_HINT = "Please write to " + EMAIL + " or call " + PHONE + ".";
    var serviceTrigger = enhanceSelect(form.elements.service, form);

    var checks = {
      name: function (v) {
        return v.length >= 2 ? "" : "Please enter your full name.";
      },
      email: function (v) {
        if (!v) return "Please enter your email address.";
        return /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v) ? "" : "Please enter a valid email address, like name@company.com.";
      },
      phone: function (v) {
        if (!v) return "Please enter your phone number.";
        return /^\+?[0-9(][0-9\s()-]{6,20}$/.test(v) && v.replace(/\D/g, "").length >= 8 && v.replace(/\D/g, "").length <= 15
          ? ""
          : "Please enter a valid phone number, with the country code if you are outside India.";
      },
      service: function (v) {
        return v ? "" : "Please choose a service.";
      },
      details: function () {
        // Optional on every form; the length limit is set on the field itself.
        return "";
      },
    };
    function validate(name) {
      var field = form.elements[name];
      var message = checks[name](field.value.trim());
      var error = form.querySelector("[id$='-" + name + "-error']");
      error.textContent = message;
      [field, name === "service" ? serviceTrigger : null].forEach(function (el) {
        if (!el) return;
        if (message) el.setAttribute("aria-invalid", "true");
        else el.removeAttribute("aria-invalid");
      });
      return !message;
    }
    function say(kind, message) {
      status.className = "girzock-enquiry-status" + (kind ? " is-" + kind : "");
      status.textContent = message;
    }
    function setBusy(on) {
      busy = on;
      button.disabled = on;
      button.setAttribute("aria-busy", on ? "true" : "false");
      buttonLabel.textContent = on ? "Sending..." : idleLabel;
    }
    Object.keys(checks).forEach(function (name) {
      var field = form.elements[name];
      function recheck() {
        if (field.hasAttribute("aria-invalid")) validate(name);
      }
      field.addEventListener("input", recheck);
      field.addEventListener("change", recheck);
      field.addEventListener("blur", function () {
        if (field.value.trim()) validate(name);
      });
    });

    form.addEventListener("submit", function (event) {
      event.preventDefault();
      if (busy) return;
      var names = Object.keys(checks);
      var invalid = names.filter(function (name) {
        return !validate(name);
      });
      if (invalid.length) {
        say("error", MSG_INVALID);
        Toast.show("error", MSG_INVALID);
        (invalid[0] === "service" && serviceTrigger ? serviceTrigger : form.elements[invalid[0]]).focus();
        return;
      }

      setBusy(true);
      say("", "");
      postForm(form)
        .then(function (reply) {
          if (reply.ok) {
            form.reset();
            if (serviceTrigger) form.elements.service.dispatchEvent(new Event("change"));
            say("", "");
            Toast.show("success", reply.message);
            // A popup form closes once the notification is on screen above it.
            var popup = form.closest(".gz-popup");
            if (popup) {
              popup.dispatchEvent(new Event("gz:submitted"));
              setTimeout(function () { var close = popup.querySelector(".gz-popup-close"); if (close) close.click(); }, 700);
            }
            return;
          }
          // Show the server's field errors in the same places as the browser checks.
          Object.keys(reply.errors || {}).forEach(function (name) {
            var error = form.querySelector("[id$='-" + name + "-error']");
            if (error) error.textContent = reply.errors[name];
            if (form.elements[name]) form.elements[name].setAttribute("aria-invalid", "true");
          });
          say("error", reply.message);
          Toast.show("error", reply.errors ? MSG_INVALID : reply.message || MSG_ERROR);
        })
        .catch(function () {
          say("error", "Your details are still here, so you can try again. " + CONTACT_HINT);
          Toast.show("error", MSG_ERROR);
        })
        .then(function () {
          setBusy(false);
        });
    });
  });

  // "Start a Project" buttons reuse the template's video button style. Without a data-video
  // attribute they act as normal links; adding one restores the original video popup.
  document.addEventListener(
    "click",
    function (event) {
      var link = event.target.closest && event.target.closest("a.video-popup:not([data-video])");
      if (link) {
        event.stopPropagation();
      }
    },
    true
  );

  // Close the mobile menu after choosing an in-page link
  document.querySelectorAll(".side-menu2 a[href*='#']").forEach(function (link) {
    if (link.getAttribute("href") === "#") return;
    link.addEventListener("click", function () {
      var overlay = document.querySelector(".overlay2");
      if (overlay) overlay.click();
    });
  });

  // Same-page links and links arriving with a #fragment: scroll through the template's Lenis
  // instance, once images have loaded, so the sticky header doesn't cover the target.
  var HEADER_OFFSET = -110;
  var activeScroll = null;
  function scrollToTarget(target, immediate) {
    var lenis = typeof LenisScroll !== "undefined" && LenisScroll.getInstance && LenisScroll.getInstance();
    var destination = target.getBoundingClientRect().top + window.pageYOffset + HEADER_OFFSET;
    if (lenis) {
      // Lenis's own animated scrollTo stalls here because the template ticks it from two clocks,
      // so a GSAP tween moves it instead.
      if (immediate || typeof gsap === "undefined") {
        lenis.scrollTo(destination, { immediate: true, force: true });
        return;
      }
      var position = { y: window.pageYOffset };
      if (activeScroll) activeScroll.kill();
      activeScroll = gsap.to(position, {
        y: destination,
        duration: 1.2,
        ease: "power2.inOut",
        onUpdate: function () {
          lenis.scrollTo(position.y, { immediate: true, force: true });
        },
      });
    } else {
      window.scrollTo(0, destination);
    }
  }
  document.addEventListener("click", function (event) {
    var link = event.target.closest && event.target.closest("a[href*='#']");
    if (!link || link.getAttribute("href") === "#") return;
    if (link.pathname !== window.location.pathname || !link.hash || link.hash === "#sideMenu") return;
    var target = document.getElementById(link.hash.slice(1));
    if (target) {
      event.preventDefault();
      history.pushState(null, "", link.hash);
      scrollToTarget(target);
    }
  });
  window.addEventListener("load", function () {
    if (!window.location.hash) return;
    var target = document.getElementById(window.location.hash.slice(1));
    if (target) {
      setTimeout(function () {
        if (typeof ScrollTrigger !== "undefined") ScrollTrigger.refresh();
        scrollToTarget(target, true);
      }, 500);
    }
  });

  // The template measures section labels before the web font arrives, which clips their last
  // letter. Re-measure once fonts are ready; the reveal animation itself is unchanged.
  function fixSubtitleWidths() {
    if (typeof gsap === "undefined") return;
    document.querySelectorAll(".sec-title .sub-title .sub-text").forEach(function (span) {
      var width = span.scrollWidth + 1;
      var tween = gsap.getTweensOf(span)[0];
      if (tween && tween.progress() < 1) {
        tween.vars.width = width;
        tween.invalidate();
      } else {
        gsap.set(span, { width: width });
      }
    });
  }
  if (document.fonts) {
    document.fonts.ready.then(fixSubtitleWidths);
    document.fonts.addEventListener("loadingdone", fixSubtitleWidths);
  }
  window.addEventListener("load", function () {
    setTimeout(fixSubtitleWidths, 100);
  });

  // Services mega menu: the hovered or focused item drives the preview
  document.querySelectorAll(".girzock-mega").forEach(function (panel) {
    var links = panel.querySelectorAll(".girzock-mega-link");
    var preview = panel.querySelector(".girzock-mega-preview");
    var imgs = panel.querySelectorAll(".girzock-mega-images img");
    var title = panel.querySelector(".girzock-mega-title");
    var desc = panel.querySelector(".girzock-mega-desc");
    var wanted = null;
    function show(link) {
      links.forEach(function (l) {
        l.classList.toggle("is-active", l === link);
      });
      preview.setAttribute("href", link.getAttribute("href"));
      title.textContent = link.textContent;
      desc.textContent = link.getAttribute("data-desc");
      var src = link.getAttribute("data-img");
      var next = imgs[0].classList.contains("is-current") ? imgs[1] : imgs[0];
      var current = next === imgs[0] ? imgs[1] : imgs[0];
      wanted = src;
      if (current.getAttribute("src") === src) return;
      var loader = new Image();
      loader.onload = function () {
        if (wanted !== src) return;
        next.setAttribute("src", src);
        next.classList.add("is-current");
        current.classList.remove("is-current");
      };
      loader.src = src;
    }
    links.forEach(function (link) {
      link.addEventListener("mouseenter", function () {
        show(link);
      });
      link.addEventListener("focus", function () {
        show(link);
      });
    });
    if (links[0]) links[0].classList.add("is-active");

    // Touch screens with the desktop menu: first tap opens, second follows the link
    var item = panel.parentElement;
    var trigger = item.querySelector(":scope > a");
    trigger.addEventListener("click", function (event) {
      if (!window.matchMedia("(hover: none)").matches) return;
      if (!item.classList.contains("girzock-mega-open")) {
        event.preventDefault();
        item.classList.add("girzock-mega-open");
      }
    });
    document.addEventListener("click", function (event) {
      if (item.contains(event.target)) return;
      item.classList.remove("girzock-mega-open");
      // a click elsewhere also closes a panel held open by keyboard focus
      if (item.contains(document.activeElement)) document.activeElement.blur();
    });

    // Announce the state and let Escape close the panel
    trigger.setAttribute("aria-haspopup", "true");
    trigger.setAttribute("aria-expanded", "false");
    function place() {
      var box = item.getBoundingClientRect();
      var width = panel.offsetWidth;
      if (!width) return;
      var left = box.left + box.width / 2 - width / 2;
      left = Math.max(20, Math.min(left, document.documentElement.clientWidth - width - 20));
      panel.style.left = left - box.left + "px";
      panel.style.marginLeft = "0";
    }
    place();
    window.addEventListener("resize", place);
    function setOpen(open) {
      if (open) place();
      trigger.setAttribute("aria-expanded", open ? "true" : "false");
    }
    item.addEventListener("mouseenter", function () {
      setOpen(true);
    });
    item.addEventListener("mouseleave", function () {
      item.classList.remove("girzock-mega-closed");
      if (!item.contains(document.activeElement)) setOpen(false);
    });
    item.addEventListener("focusin", function () {
      if (!item.classList.contains("girzock-mega-closed")) setOpen(true);
    });
    item.addEventListener("focusout", function (event) {
      if (!item.contains(event.relatedTarget)) {
        item.classList.remove("girzock-mega-closed");
        setOpen(false);
      }
    });
    item.addEventListener("keydown", function (event) {
      if (event.key !== "Escape") return;
      item.classList.add("girzock-mega-closed");
      item.classList.remove("girzock-mega-open");
      setOpen(false);
      trigger.focus();
    });
  });

  if (document.body.classList.contains("girzock-home") && window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    window.addEventListener("load", function () {
      document.querySelectorAll(".swiper").forEach(function (el) {
        if (el.swiper && el.swiper.autoplay) el.swiper.autoplay.stop();
      });
    });
  }

  // Homepage cards fade up once as they enter the view
  if (document.body.classList.contains("girzock-home") && "IntersectionObserver" in window && !window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    var revealObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
          revealObserver.unobserve(entry.target);
        }
      });
    }, { rootMargin: "0px 0px -8% 0px" });
    document.querySelectorAll(".girzock-feature, .girzock-insights .blog-card").forEach(function (el) {
      el.classList.add("girzock-reveal");
      revealObserver.observe(el);
    });
  }
  // Floating WhatsApp button: shown from 700px down the page. The listener is passive and does its
  // work once per frame; it is removed when the page is left and added back if the page is restored.
  (function () {
    var button = document.getElementById("gz-whatsapp");
    if (!button) return;
    var THRESHOLD = 700;
    var queued = false;
    function update() {
      queued = false;
      button.classList.toggle("is-visible", window.scrollY >= THRESHOLD);
    }
    function onScroll() {
      if (queued) return;
      queued = true;
      requestAnimationFrame(update);
    }
    function start() {
      window.addEventListener("scroll", onScroll, { passive: true });
      update();
    }
    window.addEventListener("pagehide", function () {
      window.removeEventListener("scroll", onScroll);
    });
    window.addEventListener("pageshow", function (event) {
      if (event.persisted) start();
    });
    start();
  })();

  // Promotional popup. The delay counts from when the page opened. Only the image for the current
  // screen size is requested, shortly before opening, so the page's own loading is not affected.
  (function () {
    var popup = document.getElementById("gz-popup");
    if (!popup) return;
    var d = popup.dataset;
    var preview = d.preview === "1";
    var previewMode = new URLSearchParams(location.search).get("gz_popup_preview");
    // What this browser remembers: when the visitor closed the popup or sent the form, tied to the
    // admin's reset number. Nothing personal is stored.
    var STORE = "gzPopup";
    var SESSION = "gzPopupSession";
    var DAY = 86400000;
    var mobileQuery = window.matchMedia("(max-width: 767px)");
    var dialog = popup.querySelector(".gz-popup-dialog");
    var media = popup.querySelector(".gz-popup-media");
    var closeButton = popup.querySelector(".gz-popup-close");
    var lastFocus = null;
    var lenis = function () { return window.gzLenis || null; };

    function isMobile() {
      return mobileQuery.matches;
    }
    function allowedHere() {
      return preview || (isMobile() ? d.showMobile === "1" : d.showDesktop === "1");
    }
    function readState() {
      try {
        var s = JSON.parse(localStorage.getItem(STORE) || "{}");
        return s && s.v === d.version ? s : { v: d.version };
      } catch (e) {
        return { v: d.version };
      }
    }
    function writeState(change) {
      try {
        var s = readState();
        for (var k in change) s[k] = change[k];
        s.v = d.version;
        localStorage.setItem(STORE, JSON.stringify(s));
      } catch (e) {}
    }
    function shownThisSession() {
      try {
        return sessionStorage.getItem(SESSION) === d.version;
      } catch (e) {
        return false;
      }
    }
    function alreadySeen() {
      if (preview) return false;
      var s = readState(), now = Date.now();
      if (s.submitted && now - s.submitted < parseInt(d.submitDays, 10) * DAY) return true;
      if (d.reappear === "refresh") return false;
      if (d.reappear === "session") return shownThisSession();
      if (d.reappear === "closed") return !!s.closed || shownThisSession();
      return (s.closed && now - s.closed < parseInt(d.dismissDays, 10) * DAY) || shownThisSession();
    }
    function markSeen() {
      if (preview) return;
      try {
        sessionStorage.setItem(SESSION, d.version);
      } catch (e) {}
    }
    popup.addEventListener("gz:submitted", function () {
      if (!preview) writeState({ submitted: Date.now() });
    });
    function setImage() {
      var src = isMobile() ? d.mobileSrc : d.desktopSrc;
      var w = isMobile() ? d.mobileW : d.desktopW;
      var h = isMobile() ? d.mobileH : d.desktopH;
      var img = media.querySelector("img");
      popup.classList.toggle("gz-popup-no-image", !src);
      if (!src) {
        media.textContent = "";
        return;
      }
      if (img && img.getAttribute("src") === src) return;
      if (!img) {
        img = document.createElement("img");
        img.alt = d.alt || "";
        img.decoding = "async";
        img.addEventListener("error", function () {
          popup.classList.add("gz-popup-no-image");
          media.textContent = "";
        });
        media.appendChild(img);
      }
      img.width = w;
      img.height = h;
      img.style.setProperty("--gz-popup-ratio", w + " / " + h);
      img.src = src;
    }
    function focusables() {
      return Array.prototype.filter.call(dialog.querySelectorAll("a[href], button:not([disabled]), input:not([type=hidden]):not([tabindex='-1']), textarea, select:not([tabindex='-1'])"), function (el) {
        return el.offsetParent !== null;
      });
    }
    function onKey(event) {
      if (event.key === "Escape") {
        if (popup.querySelector(".girzock-select.is-open")) return;
        close();
      } else if (event.key === "Tab") {
        var list = focusables();
        if (!list.length) return;
        var first = list[0], last = list[list.length - 1];
        if (event.shiftKey && (document.activeElement === first || !dialog.contains(document.activeElement))) {
          event.preventDefault();
          last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
          event.preventDefault();
          first.focus();
        }
      }
    }
    function open() {
      if (popup.classList.contains("is-open") || !allowedHere()) return;
      setImage();
      lastFocus = document.activeElement;
      popup.hidden = false;
      document.documentElement.classList.add("gz-popup-lock");
      if (lenis()) lenis().stop();
      markSeen();
      requestAnimationFrame(function () {
        requestAnimationFrame(function () {
          popup.classList.add("is-open");
        });
      });
      closeButton.focus({ preventScroll: true });
      document.addEventListener("keydown", onKey, true);
      mobileQuery.addEventListener("change", setImage);
    }
    function close() {
      if (!popup.classList.contains("is-open")) return;
      if (!preview) writeState({ closed: Date.now() });
      popup.classList.remove("is-open");
      document.documentElement.classList.remove("gz-popup-lock");
      if (lenis()) lenis().start();
      document.removeEventListener("keydown", onKey, true);
      mobileQuery.removeEventListener("change", setImage);
      setTimeout(function () {
        popup.hidden = true;
      }, 260);
      if (lastFocus && lastFocus.focus) lastFocus.focus({ preventScroll: true });
    }
    closeButton.addEventListener("click", close);
    popup.addEventListener("click", function (event) {
      if (event.target === popup) close();
    });
    if (preview || previewMode) {
      open();
      return;
    }
    if (alreadySeen() || !allowedHere()) return;
    var due = parseInt(d.delay, 10) * 1000;
    function attempt() {
      var loader = document.getElementById("preloader");
      if (loader && loader.dataset.hidden !== "true" && loader.style.display !== "none" && getComputedStyle(loader).display !== "none") {
        setTimeout(attempt, 200);
        return;
      }
      open();
    }
    var left = Math.max(0, due - performance.now());
    // Fetches the image a moment early, so it is ready when the popup opens.
    setTimeout(function () {
      if (allowedHere()) {
        var src = isMobile() ? d.mobileSrc : d.desktopSrc;
        if (src) new Image().src = src;
      }
    }, Math.max(0, left - 1500));
    setTimeout(attempt, left);
  })();

  // Homepage background video: downloaded only when it comes near the screen.
  document.querySelectorAll("video[data-gz-lazy-video]").forEach(function (video) {
    function start() {
      var source = document.createElement("source");
      source.src = video.getAttribute("data-gz-lazy-video");
      source.type = "video/mp4";
      video.appendChild(source);
      video.load();
      var playing = video.play();
      if (playing && playing.catch) playing.catch(function () {});
    }
    if (!("IntersectionObserver" in window)) {
      start();
      return;
    }
    var watcher = new IntersectionObserver(function (entries) {
      if (entries[0].isIntersecting) {
        watcher.disconnect();
        start();
      }
    }, { rootMargin: "600px 0px" });
    watcher.observe(video);
  });

  // Forms that post without JavaScript (careers) show the server's result as the same toast.
  document.querySelectorAll(".gz-alert-success, .gz-alert-error").forEach(function (alert) {
    var kind = alert.classList.contains("gz-alert-success") ? "success" : "error";
    Toast.show(kind, alert.textContent.trim());
    // A success is shown once, as the toast; the inline copy stays only for browsers without JavaScript.
    if (kind === "success") alert.hidden = true;
  });

})();
