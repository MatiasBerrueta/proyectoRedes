import { html } from "../preact.js";
import { IconoRenombrar } from "../iconos.js";

export function RenombrarArchivo() {
  return html`
    <dialog class="archivos-modal" id="renombrar-archivo-modal">
      <div class="modal-header">
        <span>Renombrar archivo</span>
        <button class="boton boton--fantasma boton--cerrar-modal" commandfor="renombrar-archivo-modal" command="close">X</button>
      </div>
      <form class="modal-contenido">
        <div class="flex-align-items">
          <${ IconoRenombrar } />
          <div class="form-group">
            <label htmlFor="nombre-renombrado">Nuevo nombre</label>
            <input id="nombre-renombrado" type="text" placeholder="nombre-nuevo.txt" />
          </div>
        </div>
        <div class="flex-align-items">
          <button class="boton boton--fantasma" type="button" commandfor="renombrar-archivo-modal" command="close">Cancelar</button>
          <button class="boton boton--primario" type="submit">Renombrar</button>
        </div>
      </form>
    </dialog>
  `;
}
