/* Sign in, forgot and reset screens: password visibility, required-field messages and the loading state.
   The password value is never read, logged or stored; the toggle only switches the field between hidden and visible. */
(function () {
  "use strict";

  document.querySelectorAll("[data-gz-reveal]").forEach(function (button) {
    var field = document.getElementById(button.getAttribute("data-gz-reveal"));
    if (!field) return;
    button.addEventListener("click", function () {
      var show = field.type === "password";
      field.type = show ? "text" : "password";
      button.setAttribute("aria-pressed", show ? "true" : "false");
      button.setAttribute("aria-label", show ? "Hide password" : "Show password");
      button.setAttribute("title", show ? "Hide password" : "Show password");
      // Focus stays on the button, so keyboard users can toggle again without typing into the field.
    });
  });

  document.querySelectorAll("[data-gz-auth-form]").forEach(function (form) {
    var submit = form.querySelector("[data-gz-submit]");
    var busy = false;

    function messageFor(input) {
      return input.id ? document.getElementById(input.id + "-error") : null;
    }
    function setError(input, on) {
      var msg = messageFor(input);
      if (on) input.setAttribute("aria-invalid", "true");
      else input.removeAttribute("aria-invalid");
      if (msg) msg.hidden = !on;
    }

    form.querySelectorAll("input[required]").forEach(function (input) {
      input.addEventListener("input", function () {
        if (input.value.trim() !== "") setError(input, false);
      });
    });

    form.addEventListener("submit", function (event) {
      if (busy) {
        event.preventDefault();
        return;
      }
      var first = null;
      form.querySelectorAll("input[required]").forEach(function (input) {
        var empty = input.value.trim() === "";
        setError(input, empty);
        if (empty && !first) first = input;
      });
      if (first) {
        event.preventDefault();
        first.focus();
        return;
      }
      // Hide the password again before the browser leaves the page, so it is never left visible
      form.querySelectorAll("[data-gz-reveal]").forEach(function (button) {
        var field = document.getElementById(button.getAttribute("data-gz-reveal"));
        if (field && field.type === "text") button.click();
      });
      busy = true;
      if (submit) {
        submit.setAttribute("aria-busy", "true");
        var label = submit.querySelector("[data-gz-label]");
        if (label) label.textContent = "Signing in…";
      }
    });

    // Coming back with the browser's Back button: clear the loading state
    window.addEventListener("pageshow", function () {
      busy = false;
      if (submit) {
        submit.removeAttribute("aria-busy");
        var label = submit.querySelector("[data-gz-label]");
        if (label) label.textContent = "Sign in";
      }
    });
  });
})();
