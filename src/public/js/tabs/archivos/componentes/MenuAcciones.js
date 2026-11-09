import { html } from "../preact.js";
import { IconoRenombrar, IconoDescargar, IconoMover, IconoEliminar } from "../iconos.js";

export function MenuAcciones({ onDescargar }) {
  return html`
    <div
      id="archivo-popover"
      class="archivos-popover"
      popover
      aria-label="Acciones del archivo"
    >
      <div class="archivos-popover__opciones">
        <button
          type="button"
          class="archivos-popover__opcion"
          commandfor="renombrar-archivo-modal"
          command="show-modal"
        >
          <${IconoRenombrar} /> Renombrar
        </button>
        <button
          type="button"
          class="archivos-popover__opcion"
          onClick=${onDescargar}
        >
          <${IconoDescargar} /> Descargar
        </button>
        <button
          type="button"
          class="archivos-popover__opcion"
          commandfor="mover-archivo-modal"
          command="show-modal"
        >
          <${IconoMover} /> Mover
        </button>
        <button
          type="button"
          class="archivos-popover__opcion archivos-popover__opcion--peligro"
          commandfor="eliminar-archivo-modal"
          command="show-modal"
        >
          <${IconoEliminar} /> Eliminar
        </button>
      </div>
    </div>
  `;
}
