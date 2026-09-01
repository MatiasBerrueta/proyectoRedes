const handlers = [];

export function init(servidor) {
  const styles = getComputedStyle(document.documentElement);
  const colorRelleno = styles.getPropertyValue("--azul-logo");
  const colorSuperficie = styles.getPropertyValue("--color-superficie-2");

  function updateFill(input) {
    const min = +input.min;
    const max = +input.max;
    const thumbW = 12;
    const padding = 4;
    const trackW = input.offsetWidth;
    const ratio = (input.value - min) / (max - min);
    const travelW = trackW - thumbW - padding * 2;
    const pxPos = 2 * padding + thumbW + ratio * travelW + 1;
    const pct = (pxPos / trackW) * 100;

    input.style.background = `linear-gradient(
            to right,
            ${colorRelleno} 0%,
            ${colorRelleno} ${pct}%,
            ${colorSuperficie} ${pct}%
        )`;
  }

  document.querySelectorAll(".range-group").forEach((group) => {
    const input = group.querySelector('input[type="range"]');
    const counter = group.querySelector("[data-range-value]");
    if (!input) return;

    updateFill(input);
    if (counter) counter.textContent = input.value;

    const onInput = () => {
      updateFill(input);
      if (counter) counter.textContent = input.value;
    };

    input.addEventListener("input", onInput);
    handlers.push({ input, onInput });
  });
}

export function destroy() {
  handlers.forEach(({ input, onInput }) => {
    input.removeEventListener("input", onInput);
  });
  handlers.length = 0;
}
