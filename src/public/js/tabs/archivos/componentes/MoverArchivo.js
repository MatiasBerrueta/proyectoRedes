import { html } from "../preact.js";
import { IconoMover } from "../iconos.js";

export function MoverArchivo({ rutaActual }) {
  return html`
    <dialog class="archivos-modal" id="mover-archivo-modal">
      <div class="modal-header">
        <span>Mover archivo</span>
        <button class="boton boton--fantasma boton--cerrar-modal" commandfor="mover-archivo-modal" command="close">X</button>
      </div>
      <form class="modal-contenido">
        <div class="flex-align-items">
          <${ IconoMover } />
          <div class="form-group">
            <label htmlFor="ruta-destino">Ruta de destino</label>
            <input id="ruta-destino" type="text" placeholder="carpeta/destino" />
          </div>
        </div>
        <div class="nueva-carpeta-info">
          <span>Se movera desde:</span>
          <p>${rutaActual}</p>
        </div>
        <div class="flex-align-items">
          <button class="boton boton--fantasma" type="button" commandfor="mover-archivo-modal" command="close">Cancelar</button>
          <button class="boton boton--primario" type="submit">Mover</button>
        </div>
      </form>
    </dialog>
  `;
}
