export class DisplayToggle extends HTMLElement {
  constructor() {
    super();
  }

  connectedCallback() {
    this.toggle = this.querySelector("button");
    this.darkModeLabel = this.dataset.darkModeLabel;
    this.lightModeLabel = this.dataset.lightModeLabel;

    if (
      localStorage.theme === "dark" ||
      (!("theme" in localStorage) &&
        window.matchMedia("(prefers-color-scheme: dark)").matches)
    ) {
      this.setDarkMode();
    } else {
      this.setLightMode();
    }

    this.toggle.addEventListener("click", () => {
      localStorage.theme == "light" ? this.setDarkMode() : this.setLightMode();
    });

    this.classList.remove("hidden");
  }

  setLightMode() {
    localStorage.theme = "light";
    this.toggle.innerHTML = this.darkModeLabel;
    document.documentElement.classList.remove("dark");
  }

  setDarkMode() {
    localStorage.theme = "dark";
    this.toggle.innerHTML = this.lightModeLabel;
    document.documentElement.classList.add("dark");
  }
}
