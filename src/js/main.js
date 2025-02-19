import "../css/main.css";
import { DisplayToggle } from "./components/display-toggle";

customElements.define("display-toggle", DisplayToggle);

window.addEventListener("beforeprint", () => {
  // we’re doing this to remove dark mode styles during printing
  document.documentElement.classList.add("print");
});

window.addEventListener("afterprint", () => {
  document.documentElement.classList.remove("print");
});

if (import.meta.hot) {
  import.meta.hot.accept();
}
