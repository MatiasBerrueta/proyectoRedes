import { html } from "../preact.js";
import { IconoBusqueda, IconoPlus, IconoFilePlus, IconoSubir } from "../iconos.js";

export function BarraHerramientas({ busqueda, onBuscar }) {
  return html`
    <div class="archivos-toolbar">
      <div class="archivos-busqueda">
        <${IconoBusqueda} />
        <input
          type="search"
          placeholder="Buscar archivos y carpetas..."
          value=${busqueda}
          onInput=${(e) => onBuscar(e.target.value)}
        />
      </div>
      <div class="acciones">
        <button
          type="button"
          class="boton boton--s"
          commandfor="nueva-carpeta-modal"
          command="show-modal"
        >
          <${IconoPlus} /> Nueva carpeta
        </button>
        <button
          type="button"
          class="boton boton--s"
          commandfor="nuevo-archivo-modal"
          command="show-modal"
        >
          <${IconoFilePlus} /> Nuevo archivo
        </button>
        <button
          type="button"
          class="boton boton--s boton--primario"
          commandfor="subir-archivo-modal"
          command="show-modal"
        >
          <${IconoSubir} /> Subir archivo
        </button>
      </div>
    </div>
  `;
}
