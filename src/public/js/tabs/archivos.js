import { cargarTab } from "/js/servidor/cambiarTabs.js";

export function init(servidor) {
  const contenedorArchivos = document.querySelector(".contenedor-archivos");
  console.log(contenedorArchivos);
  if (!contenedorArchivos) return;

  contenedorArchivos.addEventListener("click", (e) => {
    const elementoCarpeta = e.target.closest("[data-tipo]");
    console.log(e.target);

    if (elementoCarpeta) {
      e.preventDefault();
      const nuevaRuta = elementoCarpeta.dataset.path;

      const nuevaUrl = `/servidores/${servidor.identifier}/archivos?path=${encodeURIComponent(nuevaRuta)}`;
      window.history.pushState({ tab: "archivos", path: nuevaRuta }, "", nuevaUrl);

      cargarTab("archivos", { path: nuevaRuta });
    }
  });
}

export function destroy() {}
