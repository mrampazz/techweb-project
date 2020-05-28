document.addEventListener("DOMContentLoaded", theDomHasLoaded, false);

const togglePanel = (panel) => {
  if (panel.style.opacity == "0") {
    panel.style.opacity = "1";
    panel.style.height = "5em";
  } else {
    panel.style.opacity = "0";
    panel.style.height = "0";
  }
};

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
    title.addEventListener("click", () => {
      button.classList.toggle("accordion-button-reversed");
      button.classList.toggle("accordion-button");
      togglePanel(panels[i]);
    });
  }
}

window.onscroll = function () {
  let btn = document.getElementById("back-to-top");
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    btn.style.display = "block";
  } else {
    btn.style.display = "none";
  }
};
