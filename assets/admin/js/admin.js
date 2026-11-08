/* GIRZOCK admin panel behaviour. No dependencies except Chart.js on the dashboard. */
(function () {
  "use strict";

  var meta = function (name) {
    var el = document.querySelector('meta[name="' + name + '"]');
    return el ? el.getAttribute("content") : "";
  };
  var ADMIN = meta("gz-base").replace(/\/$/, "");

  function post(url, fields) {
    var data = new FormData();
    data.append(meta("gz-csrf-name"), meta("gz-csrf-hash"));
    Object.keys(fields || {}).forEach(function (key) {
      data.append(key, fields[key]);
    });
    return fetch(url, { method: "POST", body: data, headers: { Accept: "application/json", "X-Requested-With": "XMLHttpRequest" }, credentials: "same-origin" }).then(function (r) {
      return r.json();
    });
  }
  function getJSON(url) {
    return fetch(url, { headers: { Accept: "application/json", "X-Requested-With": "XMLHttpRequest" }, credentials: "same-origin" }).then(function (r) {
      if (!r.ok) throw new Error("HTTP " + r.status);
      return r.json();
    });
  }
  function text(value) {
    var span = document.createElement("span");
    span.textContent = value == null ? "" : String(value);
    return span.innerHTML;
  }

  /* ---------- sidebar and dropdowns ---------- */
  document.querySelectorAll("[data-gz-sidebar-toggle]").forEach(function (button) {
    button.addEventListener("click", function () {
      var cls = window.innerWidth <= 860 ? "gz-sidebar-open" : "gz-collapsed";
      document.body.classList.toggle(cls);
    });
  });
  document.addEventListener("click", function (event) {
    var trigger = event.target.closest("[data-gz-dropdown]");
    document.querySelectorAll(".gz-dropdown.open").forEach(function (dropdown) {
      if (!trigger || dropdown !== trigger.parentNode) {
        dropdown.classList.remove("open");
        dropdown.querySelector("[data-gz-dropdown]").setAttribute("aria-expanded", "false");
      }
    });
    if (trigger) {
      var open = trigger.parentNode.classList.toggle("open");
      trigger.setAttribute("aria-expanded", open ? "true" : "false");
    }
  });
  document.addEventListener("keydown", function (event) {
    if (event.key !== "Escape") return;
    document.querySelectorAll(".gz-dropdown.open").forEach(function (d) {
      d.classList.remove("open");
    });
  });

  /* ---------- confirm before destructive actions ---------- */
  document.addEventListener("submit", function (event) {
    // the button that sent the form may carry its own question
    var message = (event.submitter && event.submitter.getAttribute("data-gz-confirm")) || event.target.getAttribute("data-gz-confirm");
    if (message && !window.confirm(message)) event.preventDefault();
  });

  /* ---------- enquiry delete: confirm, delete without a reload, keep the list in step ---------- */
  var deleteDialog = document.getElementById("gz-delete-dialog");
  var toastTimer;
  function toast(kind, message) {
    var el = document.getElementById("gz-toast");
    if (!el) return;
    el.textContent = message;
    el.className = "gz-toast gz-toast-" + kind;
    el.hidden = false;
    clearTimeout(toastTimer);
    toastTimer = setTimeout(function () {
      el.hidden = true;
    }, 5000);
  }
  if (deleteDialog && deleteDialog.showModal) {
    var pending = null;
    var confirmButton = deleteDialog.querySelector("[data-gz-delete-confirm]");
    document.querySelectorAll("form[data-gz-enquiry-delete]").forEach(function (form) {
      form.addEventListener("submit", function (event) {
        event.preventDefault();
        pending = form;
        deleteDialog.querySelector("[data-gz-delete-text]").textContent =
          "Enquiry " + form.dataset.reference + " from " + form.dataset.name + " will be permanently deleted.";
        deleteDialog.showModal();
      });
    });
    deleteDialog.querySelector("[data-gz-delete-cancel]").addEventListener("click", function () {
      pending = null;
      deleteDialog.close();
    });
    confirmButton.addEventListener("click", function () {
      if (!pending) return;
      var form = pending;
      pending = null;
      confirmButton.disabled = true;
      fetch(form.action, {
        method: "POST",
        body: new FormData(form),
        headers: { Accept: "application/json", "X-Requested-With": "XMLHttpRequest" },
        credentials: "same-origin",
      })
        .then(function (response) {
          return response.json().then(function (reply) {
            return { ok: response.ok && reply.ok, reply: reply };
          });
        })
        .then(function (result) {
          if (!result.ok) {
            toast("error", result.reply.message || "The enquiry could not be deleted.");
            return;
          }
          var row = form.closest("tr");
          var body = row.parentNode;
          row.remove();
          toast("success", result.reply.message);
          document.querySelectorAll("[data-gz-unread]").forEach(function (badge) {
            badge.textContent = result.reply.unread;
            badge.hidden = !result.reply.unread;
          });
          var total = document.querySelector("[data-gz-enquiry-total]");
          if (total) total.textContent = result.reply.total + (result.reply.total === 1 ? " enquiry" : " enquiries");
          if (!body.querySelector("tr")) {
            if (result.reply.total > 0) {
              // This page is now empty but others are not: go back one page.
              var url = new URL(window.location.href);
              url.searchParams.set("page", Math.max(1, Number(url.searchParams.get("page") || 1) - 1));
              window.location.href = url.toString();
              return;
            }
            var empty = document.createElement("tr");
            empty.innerHTML = '<td colspan="9" class="gz-empty-row">No enquiries found.</td>';
            body.appendChild(empty);
          }
        })
        .catch(function () {
          toast("error", "The enquiry could not be deleted. Please reload the page and try again.");
        })
        .then(function () {
          confirmButton.disabled = false;
          deleteDialog.close();
        });
    });
  }

  /* ---------- status switch in lists ---------- */
  document.addEventListener("click", function (event) {
    var button = event.target.closest("[data-gz-toggle]");
    if (!button) return;
    post(button.getAttribute("data-gz-toggle"))
      .then(function (reply) {
        if (reply.ok) button.innerHTML = reply.badge;
        else window.alert(reply.message);
      })
      .catch(function () {
        window.alert("The status could not be changed. Please reload the page.");
      });
  });

  /* ---------- media alt text saves on change ---------- */
  document.querySelectorAll("[data-gz-alt]").forEach(function (input) {
    input.addEventListener("change", function () {
      post(input.getAttribute("data-gz-alt"), { alt_text: input.value });
    });
  });

  /* ---------- notifications ---------- */
  var notifyList = document.querySelector("[data-gz-notify-list]");
  function refreshNotifications() {
    getJSON(ADMIN + "/dashboard/notifications")
      .then(function (reply) {
        document.querySelectorAll("[data-gz-unread]").forEach(function (badge) {
          badge.textContent = reply.count;
          badge.hidden = !reply.count;
        });
        if (!notifyList) return;
        notifyList.innerHTML = reply.items.length
          ? reply.items.map(function (item) {
              return '<a href="' + text(item.url) + '"><strong>' + text(item.name) + "</strong><small>" + text(item.service) + " &middot; " + text(item.time) + "</small></a>";
            }).join("")
          : '<p class="gz-muted">No unread enquiries.</p>';
      })
      .catch(function () {});
  }
  if (notifyList) {
    refreshNotifications();
    setInterval(refreshNotifications, 60000);
  }

  /* ---------- rich text editor ---------- */
  document.querySelectorAll("[data-gz-editor]").forEach(function (editor) {
    var area = editor.querySelector(".gz-editor-area");
    var source = editor.querySelector("textarea");
    var showingSource = false;
    area.innerHTML = source.value;

    function sync() {
      if (!showingSource) source.value = area.innerHTML;
    }
    area.addEventListener("input", sync);
    var form = editor.closest("form");
    if (form) form.addEventListener("submit", sync);

    editor.querySelector(".gz-editor-bar").addEventListener("click", function (event) {
      var button = event.target.closest("button");
      if (!button) return;
      event.preventDefault();
      if (button.hasAttribute("data-source")) {
        showingSource = !showingSource;
        if (showingSource) {
          source.value = area.innerHTML;
        } else {
          area.innerHTML = source.value;
        }
        source.hidden = !showingSource;
        area.hidden = showingSource;
        return;
      }
      if (showingSource) return;
      area.focus();
      if (button.dataset.cmd) document.execCommand(button.dataset.cmd);
      if (button.dataset.block) document.execCommand("formatBlock", false, button.dataset.block);
      if (button.hasAttribute("data-link")) {
        var url = window.prompt("Link address (https://...)");
        if (url && /^(https?:\/\/|mailto:|tel:|\/)/i.test(url)) document.execCommand("createLink", false, url);
      }
      if (button.hasAttribute("data-image")) {
        var selection = window.getSelection();
        var range = selection.rangeCount ? selection.getRangeAt(0) : null;
        openPicker(function (item) {
          area.focus();
          if (range) {
            selection.removeAllRanges();
            selection.addRange(range);
          }
          document.execCommand("insertHTML", false, '<img src="' + text(item.path) + '" alt="' + text(item.alt) + '" loading="lazy">');
          sync();
        });
      }
      sync();
    });
  });

  /* ---------- media picker ---------- */
  var picker = document.getElementById("gz-picker");
  var pickHandler = null;
  var pickBrand = false;
  function loadPicker(query) {
    var grid = picker.querySelector("[data-gz-picker-grid]");
    getJSON(ADMIN + "/media/picker?q=" + encodeURIComponent(query || "") + (pickBrand ? "&brand=1" : ""))
      .then(function (reply) {
        grid.innerHTML = "";
        if (!reply.items.length) {
          grid.innerHTML = '<p class="gz-muted">No uploaded images found. Upload a file in the form or in the Media Library.</p>';
        }
        reply.items.forEach(function (item) {
          var button = document.createElement("button");
          button.type = "button";
          button.title = item.name;
          var img = document.createElement("img");
          img.src = item.url;
          img.alt = item.alt || item.name;
          img.loading = "lazy";
          button.appendChild(img);
          button.addEventListener("click", function () {
            picker.close();
            if (pickHandler) pickHandler(item);
          });
          grid.appendChild(button);
        });
      })
      .catch(function () {
        grid.innerHTML = '<p class="gz-muted">The media library is not available for your role.</p>';
      });
  }
  function openPicker(handler, brand) {
    if (!picker) return;
    pickHandler = handler;
    pickBrand = !!brand;
    picker.showModal();
    loadPicker("");
  }
  if (picker) {
    picker.querySelector("[data-gz-picker-close]").addEventListener("click", function () {
      picker.close();
    });
    var searchTimer;
    picker.querySelector("[data-gz-picker-search]").addEventListener("input", function (event) {
      clearTimeout(searchTimer);
      searchTimer = setTimeout(function () {
        loadPicker(event.target.value);
      }, 250);
    });
  }
  document.querySelectorAll("[data-gz-image]").forEach(function (field) {
    var hidden = field.querySelector('input[type="hidden"]');
    var preview = field.querySelector(".gz-image-preview");
    var clear = field.querySelector("[data-gz-clear]");
    var file = field.querySelector('input[type="file"]');
    var label = field.querySelector("[data-gz-image-path]");
    var pick = field.querySelector("[data-gz-pick]");
    pick.addEventListener("click", function () {
      openPicker(function (item) {
        hidden.value = item.path;
        preview.src = item.url;
        preview.hidden = false;
        clear.hidden = false;
        file.value = "";
        if (label) label.textContent = item.path;
        if (field.hasAttribute("data-gz-brand")) pick.textContent = "Replace from library";
      }, field.getAttribute("data-gz-brand") === "1");
    });
    clear.addEventListener("click", function () {
      hidden.value = "";
      preview.hidden = true;
      clear.hidden = true;
      file.value = "";
      if (label) label.textContent = "No image chosen. The default sharing image from Website Settings is used.";
    });
    file.addEventListener("change", function () {
      if (file.files[0]) {
        preview.src = URL.createObjectURL(file.files[0]);
        preview.hidden = false;
      }
    });
  });
  document.querySelectorAll("[data-gz-pick-gallery]").forEach(function (button) {
    button.addEventListener("click", function () {
      var list = button.closest(".gz-field").querySelector("[data-gz-gallery-list]");
      openPicker(function (item) {
        list.value = (list.value.trim() ? list.value.trim() + "\n" : "") + item.path;
      });
    });
  });

  /* ---------- dashboard charts ---------- */
  var charts = document.querySelector("[data-gz-charts]");
  if (!charts) return;

  // Validated reference palette: categorical slots 1 and 2. A single series uses slot 1.
  var SERIES_1 = "#2a78d6";
  var SERIES_2 = "#eb6834";
  var GRID = "#eceef3";
  var AXIS = "#5d6579";
  var instances = {};

  function table(target, headers, rows) {
    var html = "<table><thead><tr>" + headers.map(function (h) { return '<th scope="col">' + text(h) + "</th>"; }).join("") + "</tr></thead><tbody>";
    rows.forEach(function (row) {
      html += "<tr>" + row.map(function (cell) { return "<td>" + text(cell) + "</td>"; }).join("") + "</tr>";
    });
    charts.querySelector('[data-gz-table="' + target + '"]').innerHTML = html + "</tbody></table>";
  }
  function axes(horizontal) {
    var value = { beginAtZero: true, grid: { color: GRID, drawTicks: false }, border: { display: false }, ticks: { precision: 0, color: AXIS, padding: 6 } };
    var category = { grid: { display: false }, border: { color: GRID }, ticks: { color: AXIS, maxRotation: 0, autoSkipPadding: 12 } };
    return horizontal ? { x: value, y: category } : { x: category, y: value };
  }
  function base(showLegend, horizontal) {
    return {
      responsive: true,
      maintainAspectRatio: false,
      animation: false,
      indexAxis: horizontal ? "y" : "x",
      interaction: { mode: "index", intersect: false, axis: horizontal ? "y" : "x" },
      plugins: {
        legend: { display: showLegend, position: "top", align: "start", labels: { usePointStyle: true, boxWidth: 8, boxHeight: 8, color: "#1c2333" } },
        tooltip: { backgroundColor: "#1c2333", padding: 10, displayColors: showLegend, titleFont: { weight: "600" } },
      },
      scales: axes(horizontal),
    };
  }
  function bar(data, label) {
    return { label: label, data: data, backgroundColor: SERIES_1, hoverBackgroundColor: "#1f5fae", maxBarThickness: 18, borderRadius: { topLeft: 4, topRight: 4, bottomLeft: 0, bottomRight: 0 }, borderSkipped: false };
  }
  function draw(id, config) {
    if (instances[id]) instances[id].destroy();
    instances[id] = new window.Chart(document.getElementById(id), config);
  }
  function render(d) {
    Object.keys(d.stats).forEach(function (key) {
      var tile = document.querySelector('[data-gz-stat="' + key + '"]');
      if (tile) tile.textContent = d.stats[key];
    });
    draw("gz-chart-monthly", { type: "bar", data: { labels: d.months, datasets: [bar(d.enquiries, "Enquiries")] }, options: base(false) });
    var statusBar = bar(d.status_values, "Enquiries");
    statusBar.borderRadius = { topRight: 4, bottomRight: 4, topLeft: 0, bottomLeft: 0 };
    draw("gz-chart-status", { type: "bar", data: { labels: d.status_labels, datasets: [statusBar] }, options: base(false, true) });
    draw("gz-chart-conversion", {
      type: "line",
      data: {
        labels: d.months,
        datasets: [
          { label: "All enquiries", data: d.enquiries, borderColor: SERIES_1, backgroundColor: SERIES_1, borderWidth: 2, pointRadius: 4, pointHoverRadius: 5, pointBorderColor: "#fff", pointBorderWidth: 2, tension: 0 },
          { label: "Converted", data: d.converted, borderColor: SERIES_2, backgroundColor: SERIES_2, borderWidth: 2, pointRadius: 4, pointHoverRadius: 5, pointBorderColor: "#fff", pointBorderWidth: 2, pointStyle: "rectRot", tension: 0 },
        ],
      },
      options: base(true),
    });
    draw("gz-chart-posts", { type: "bar", data: { labels: d.months, datasets: [bar(d.posts, "Posts")] }, options: base(false) });

    charts.querySelector("[data-gz-conversion]").textContent = d.conversion_rate === null
      ? "No enquiries yet, so there is no conversion rate to show."
      : d.conversion_rate + "% converted (" + d.conversion_converted + " of " + d.conversion_total + " enquiries)";

    table("monthly", ["Month", "Enquiries"], d.months.map(function (m, i) { return [m, d.enquiries[i]]; }));
    table("status", ["Status", "Enquiries"], d.status_labels.map(function (s, i) { return [s, d.status_values[i]]; }));
    table("conversion", ["Month", "All enquiries", "Converted"], d.months.map(function (m, i) { return [m, d.enquiries[i], d.converted[i]]; }));
    table("posts", ["Month", "Posts"], d.months.map(function (m, i) { return [m, d.posts[i]]; }));
  }
  function refresh() {
    getJSON(charts.getAttribute("data-gz-charts")).then(render).catch(function () {});
  }
  refresh();
  setInterval(refresh, 120000);
})();

/* Search result preview in the content editors. It updates as you type and only reads the form. */
(function () {
  "use strict";
  var box = document.querySelector("[data-gz-serp]");
  if (!box) return;
  var $ = function (id) { return document.getElementById(id); };
  var title = $("f-title"), seoTitle = $("f-seo_meta_title"), desc = $("f-seo_meta_description"), slug = $("f-slug"), canon = $("f-seo_canonical_url");
  var excerpt = $("f-excerpt") || $("f-short_description") || $("f-summary");
  var out = { url: box.querySelector("[data-gz-serp-url]"), title: box.querySelector("[data-gz-serp-title]"), desc: box.querySelector("[data-gz-serp-desc]"), count: box.querySelector("[data-gz-serp-count]") };
  var company = box.getAttribute("data-company") || "";
  function slugify(s) { return s.toLowerCase().replace(/[^a-z0-9]+/g, "-").replace(/^-+|-+$/g, ""); }
  function clip(s, n) { return s.length > n ? s.slice(0, n - 1).replace(/\s+\S*$/, "") + " …" : s; }
  function update() {
    var t = (seoTitle && seoTitle.value.trim()) || ((title && title.value.trim()) ? title.value.trim() + " | " + company : "Page title");
    var d = (desc && desc.value.trim()) || (excerpt && excerpt.value.trim()) || "Search engines will choose text from the page.";
    var s = (slug && slug.value.trim()) || (title ? slugify(title.value) : "");
    out.url.textContent = (canon && canon.value.trim()) || (box.getAttribute("data-base") + s);
    out.title.textContent = clip(t, 62);
    out.desc.textContent = clip(d.replace(/\s+/g, " "), 162);
    out.count.textContent = "Title " + t.length + " characters (about 60 or fewer shows in full). Description " + ((desc && desc.value.trim()) ? desc.value.trim().length + " characters (aim for 120 to 160)." : "not set.");
  }
  [title, seoTitle, desc, slug, canon, excerpt].forEach(function (el) { if (el) el.addEventListener("input", update); });
  update();
})();

/* Job application delete: a dashboard-style confirmation dialog (no browser confirm), deletion in the background,
   the list updated in place, and a toast. On the detail page the user returns to the list, which shows the toast. */
(function () {
  "use strict";
  var dialog = document.getElementById("gz-app-delete-dialog");
  var toastEl = document.getElementById("gz-app-toast");
  var FAILED = "Unable to delete application. Please try again.";
  var timer;
  function toast(kind, message) {
    if (!toastEl) return;
    toastEl.textContent = message;
    toastEl.className = "gz-toast gz-toast-" + kind;
    toastEl.setAttribute("role", kind === "error" ? "alert" : "status");
    toastEl.hidden = false;
    clearTimeout(timer);
    timer = setTimeout(function () { toastEl.hidden = true; }, 5000);
  }
  // a toast handed over from the detail page after a delete
  try {
    var handed = sessionStorage.getItem("gzAdminToast");
    if (handed && toastEl) {
      sessionStorage.removeItem("gzAdminToast");
      var parsed = JSON.parse(handed);
      toast(parsed.kind, parsed.message);
      document.querySelectorAll(".gz-flash").forEach(function (f) { if (f.textContent.trim() === parsed.message) f.hidden = true; });
    }
  } catch (e) {}
  if (!dialog || !dialog.showModal) return;
  var pending = null;
  var confirmButton = dialog.querySelector("[data-gz-app-delete-confirm]");
  document.querySelectorAll("form[data-gz-app-delete]").forEach(function (form) {
    form.addEventListener("submit", function (event) {
      event.preventDefault();
      event.stopImmediatePropagation();
      pending = form;
      dialog.querySelector("[data-gz-app-delete-text]").textContent =
        "Application " + form.dataset.reference + " from " + form.dataset.name + " will be permanently deleted.";
      dialog.showModal();
      dialog.querySelector("[data-gz-app-delete-cancel]").focus();
    });
  });
  dialog.querySelector("[data-gz-app-delete-cancel]").addEventListener("click", function () {
    pending = null;
    dialog.close();
  });
  dialog.addEventListener("close", function () { pending = null; });
  confirmButton.addEventListener("click", function () {
    if (!pending) return;
    var form = pending;
    confirmButton.disabled = true;
    confirmButton.setAttribute("aria-busy", "true");
    fetch(form.action, {
      method: "POST",
      body: new FormData(form),
      headers: { Accept: "application/json", "X-Requested-With": "XMLHttpRequest" },
      credentials: "same-origin",
    })
      .then(function (response) {
        return response.json().then(function (reply) { return { ok: response.ok && reply.ok, reply: reply }; }, function () { return { ok: false, reply: {} }; });
      })
      .then(function (result) {
        dialog.close();
        if (!result.ok) {
          toast("error", FAILED);
          return;
        }
        if (form.dataset.redirect) {
          try { sessionStorage.setItem("gzAdminToast", JSON.stringify({ kind: "success", message: result.reply.message })); } catch (e) {}
          window.location.href = form.dataset.redirect;
          return;
        }
        var row = form.closest("tr");
        var body = row ? row.parentNode : null;
        if (row) row.remove();
        toast("success", result.reply.message);
        var total = document.querySelector("[data-gz-app-total]");
        if (total && typeof result.reply.total === "number") total.textContent = result.reply.total + (result.reply.total === 1 ? " application" : " applications");
        if (body && !body.querySelector("tr")) {
          var empty = document.createElement("tr");
          empty.innerHTML = '<td colspan="7" class="gz-empty-row">No applications found.</td>';
          body.appendChild(empty);
        }
      })
      .catch(function () {
        dialog.close();
        toast("error", FAILED);
      })
      .then(function () {
        confirmButton.disabled = false;
        confirmButton.removeAttribute("aria-busy");
      });
  });
})();
