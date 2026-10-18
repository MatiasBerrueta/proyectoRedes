import { html, render } from "./preact.js";
import { App } from "./App.js";

// Punto de entrada del tab de archivos.
// `init` lo invoca cambiarTabs.js al cargar/refrescar el tab y `destroy`
// desmonta el arbol de Preact antes de reemplazar el contenido.

let contenedorActual = null;

function leerDatos() {
  const script = document.getElementById("archivos-datos");
  if (!script) return null;

  try {
    return JSON.parse(script.textContent);
  } catch (error) {
    console.error("No se pudieron leer los datos del tab de archivos:", error);
    return null;
  }
}

export function init(servidor) {
  const contenedor = document.getElementById("archivos-app");
  if (!contenedor) return;

  const datosIniciales = leerDatos();
  if (!datosIniciales) return;

  contenedorActual = contenedor;
  render(html`<${App} datosIniciales=${datosIniciales} servidor=${servidor} />`, contenedor);
}

export function destroy() {
  if (contenedorActual) {
    render(null, contenedorActual);
    contenedorActual = null;
  }
}
