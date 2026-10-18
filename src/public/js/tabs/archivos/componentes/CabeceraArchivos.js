import { html } from "../preact.js";

export function CabeceraArchivos({ pathSeparado, onNavegar }) {
  const segmentos = [];
  let acumulado = "";

  pathSeparado.forEach((segmento) => {
    acumulado += "/" + segmento;
    segmentos.push({ nombre: segmento, ruta: acumulado.replace(/^\/+/, "") });
  });

  const breadcrumbs = [
    html`<span key="sep-inicio">/</span>`,
    html`<a
      key="home"
      href="?path="
      onClick=${(e) => {
        e.preventDefault();
        onNavegar("");
      }}
      >home</a
    >`,
  ];

  segmentos.forEach(({ nombre, ruta }) => {
    breadcrumbs.push(html`<span key=${"sep-" + ruta}>/</span>`);
    breadcrumbs.push(
      html`<a
        key=${ruta}
        href=${"?path=" + encodeURIComponent(ruta)}
        onClick=${(e) => {
          e.preventDefault();
          onNavegar(ruta);
        }}
        >${nombre}</a
      >`,
    );
  });

  return html`
    <div class="archivos-header">
      <div class="breadcrumbs">${breadcrumbs}</div>
    </div>
  `;
}
