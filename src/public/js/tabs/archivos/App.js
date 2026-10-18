import { html, useState } from "./preact.js";
import { cargarTab } from "/js/servidor/cambiarTabs.js";
import { CabeceraArchivos } from "./componentes/CabeceraArchivos.js";
import { ListadoDirectorio } from "./componentes/ListadoDirectorio.js";
import { EditorArchivo } from "./componentes/EditorArchivo.js";

export function App({ datosIniciales, servidor }) {
  const [datos, setDatos] = useState(datosIniciales);

  const navegar = async (ruta) => {
    const rutaLimpia = String(ruta ?? "").replace(/^\/+|\/+$/g, "");
    console.log(rutaLimpia);
    const url = `/api/servidores/${servidor.identifier}/archivos${rutaLimpia ? "?path=" + encodeURIComponent(rutaLimpia) : "?path="}`;
    console.log(url);

    // window.history.pushState({ tab: "archivos", path: rutaLimpia }, "", url);

    const respuesta = await fetch(url, { method: "GET" });
    const datos = await respuesta.json();
    console.log(datos);
    setDatos(datos);
    // cargarTab("archivos", { path: rutaLimpia });
  };

  return html`
    <div class="archivos-tab">
      <h2 class="texto-xl">Directorio de archivos</h2>

      <${CabeceraArchivos} pathSeparado=${datos.pathSeparado || []} onNavegar=${navegar} />

      ${datos.esDirectorio
        ? html`<${ListadoDirectorio} archivos=${datos.archivos || []} onNavegar=${navegar} />`
        : html`<${EditorArchivo} path=${datos.path} contenido=${datos.contenido} />`}
    </div>
  `;
}
