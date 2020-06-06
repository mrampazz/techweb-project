"use strict";

document.addEventListener("DOMContentLoaded", theDomHasLoaded, false);

function togglePanel(panel, accordion) {
  if (accordion.getAttribute("aria-expanded") == "false") {
    panel.classList.add("accordion-panel-open");
    panel.classList.remove("accordion-panel-closed");
    accordion.setAttribute("aria-expanded", "true");
  } else {
    panel.classList.add("accordion-panel-closed");
    panel.classList.remove("accordion-panel-open");
    accordion.setAttribute("aria-expanded", "false");
  }
}

function theDomHasLoaded(e) {
  var acc = document.getElementsByClassName("accordion-button");
  var panels = document.getElementsByClassName("panel");
  var accordion = document.getElementsByClassName("accordion");

  var _loop = function _loop(i) {
    var button = acc[i];
    button.addEventListener("click", function () {
      this.classList.toggle("accordion-button-reversed");
      this.classList.toggle("accordion-button");
      togglePanel(panels[i], accordion[i]);
    });
  };

  for (var i = 0; i < acc.length; i++) {
    _loop(i);
  }

  var buttonOpen = document.getElementById("ham-button-open");
  var buttonClose = document.getElementById("ham-button-close");
  var ham = document.getElementById("ham-menu-links");
  var body = document.getElementsByTagName("body")[0];
  buttonOpen.addEventListener("click", function () {
    body.classList.toggle("body-no-overflow");
    ham.classList.toggle("ham-menu-open");
    ham.setAttribute("aria-expanded", "true");
  });
  buttonClose.addEventListener("click", function () {
    body.classList.toggle("body-no-overflow");
    ham.classList.toggle("ham-menu-open");
    ham.setAttribute("aria-expanded", "false");
  });
}

window.onscroll = function () {
  var btn = document.getElementsByClassName("back-to-top")[0];

  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    btn.classList.add("back-to-top-visible");
    btn.classList.remove("back-to-top-hidden");
  } else {
    btn.classList.add("back-to-top-hidden");
    btn.classList.remove("back-to-top-visible");
  }
};
