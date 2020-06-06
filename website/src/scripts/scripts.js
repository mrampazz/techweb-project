"use strict";

document.addEventListener("DOMContentLoaded", theDomHasLoaded, false);

function togglePanel(panel, accordion) {
  if (panel.style.opacity == "0") {
    panel.style.opacity = "1";
    panel.style.maxHeight = "20em";
    accordion.setAttribute('aria-expanded', 'true');
  } else {
    panel.style.opacity = "0";
    panel.style.maxHeight = "0";
    accordion.setAttribute('aria-expanded', 'false');
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
    body.style.overflow = "hidden";
    ham.classList.toggle("ham-menu-open");
    ham.setAttribute('aria-expanded', 'true');
  });
  buttonClose.addEventListener("click", function () {
    body.style.overflow = "auto";
    ham.classList.toggle("ham-menu-open");
    ham.setAttribute('aria-expanded', 'false');
  });
}

window.onscroll = function () {
  var btn = document.getElementById("back-to-top");

  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    btn.style.display = "block";
  } else {
    btn.style.display = "none";
  }
};