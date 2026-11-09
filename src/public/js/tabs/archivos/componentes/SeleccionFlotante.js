import { html } from "../preact.js";
import { IconoDescargar, IconoMover, IconoEliminar, IconoCerrar } from "../iconos.js";

export function SeleccionFlotante({
  cantidad,
  onDescargar,
  onMover,
  onEliminar,
  onCancelar,
}) {
  const activo = cantidad > 0;

  return html`
    <div
      class=${"archivos-seleccion-flotante" + (activo ? " activo" : "")}
      role="toolbar"
      aria-label="Acciones de la selección"
      aria-hidden=${!activo}
      inert=${activo ? undefined : ""}
    >
      <span class="archivos-seleccion-contador">
        <strong>${cantidad} </strong>
        ${cantidad <= 1 ? "seleccionado" : "seleccionados"}
      </span>
      <div class="archivos-seleccion-acciones">
        <button type="button" class="boton boton--s" onClick=${onDescargar}>
          <${IconoDescargar} /> Descargar
        </button>
        <button
          type="button"
          class="boton boton--s"
          commandfor="mover-archivo-modal"
          command="show-modal"
          onClick=${onMover}
        >
          <${IconoMover} /> Mover
        </button>
        <button
          type="button"
          class="boton boton--s boton--peligro"
          commandfor="eliminar-archivo-modal"
          command="show-modal"
          onClick=${onEliminar}
        >
          <${IconoEliminar} /> Eliminar
        </button>
        <button
          type="button"
          class="boton boton--s boton--fantasma boton--cancelar"
          title="Cancelar selección"
          onClick=${onCancelar}
        >
          <${IconoCerrar} />
        </button>
      </div>
    </div>
  `;
}
