document.addEventListener("DOMContentLoaded", theDomHasLoaded, false);

function togglePanel(panel) {
  if (panel.style.opacity == "0") {
    panel.style.opacity = "1";
    panel.style.maxHeight = "20em";
  } else {
    panel.style.opacity = "0";
    panel.style.maxHeight = "0";
  }
}

function theDomHasLoaded(e) {
  const acc = document.getElementsByClassName("accordion-button");
  const titles = document.getElementsByClassName("accordion-title");
  const panels = document.getElementsByClassName("panel");

  for (let i = 0; i < acc.length; i++) {
    let button = acc[i];
    let title = titles[i];
    button.addEventListener("click", function () {
      this.classList.toggle("accordion-button-reversed");
      this.classList.toggle("accordion-button");
      togglePanel(panels[i]);
    });
    title.addEventListener("click", function () {
      button.classList.toggle("accordion-button-reversed");
      button.classList.toggle("accordion-button");
      togglePanel(panels[i]);
    });
  }

  const buttonOpen = document.getElementById("ham-button-open");
  const buttonClose = document.getElementById("ham-button-close");
  const ham = document.getElementById("ham-menu-links");
  const body = document.getElementsByTagName("body")[0];
  buttonOpen.addEventListener("click", function () {
    body.style.overflow = "hidden";
    ham.classList.toggle("ham-menu-open");
  });

  buttonClose.addEventListener("click", function () {
    body.style.overflow = "auto";
    ham.classList.toggle("ham-menu-open");
  });
}

window.onscroll = function () {
  let btn = document.getElementById("back-to-top");
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    btn.style.display = "block";
  } else {
    btn.style.display = "none";
  }
};
