import { html, useState, signal } from "./preact.js";
import { CabeceraArchivos } from "./componentes/CabeceraArchivos.js";
import { ListadoDirectorio } from "./componentes/ListadoDirectorio.js";
import { EditorArchivo } from "./componentes/EditorArchivo.js";

export const seleccionadosIds = signal(new Set());
export const objetivosAccion = signal([]);

export function App({ datosIniciales, servidor }) {
  const [datos, setDatos] = useState(datosIniciales);

  const navegar = async (ruta) => {
    // busca barras al principio o al final del texto y las borra
    const rutaLimpia = String(ruta ?? "").replace(/^\/+|\/+$/g, "");
    const url = `/servidores/${servidor.identifier}/archivos${rutaLimpia ? "?path=" + encodeURIComponent(rutaLimpia) : "?path="}`;
    const apiUrl = `/api${url}`;

    window.history.pushState({ tab: "archivos", path: rutaLimpia }, "", url);

    const respuesta = await fetch(apiUrl, { method: "GET" });
    const datos = await respuesta.json();

    seleccionadosIds.value = new Set();
    objetivosAccion.value = [];
    setDatos(datos);
  };

  return html`
    <div class="archivos-tab">
      <${CabeceraArchivos}
        pathSeparado=${datos.pathSeparado || []}
        onNavegar=${navegar}
      />
      ${datos.esDirectorio
        ? html`<${ListadoDirectorio}
            path=${datos.path}
            archivos=${datos.archivos || []}
            idServidor=${servidor.identifier}
            onNavegar=${navegar}
          />`
        : html`<${EditorArchivo}
            path=${datos.path}
            contenido=${datos.contenido}
            onNavegar=${navegar}
          />`}
    </div>
  `;
}
