import { html } from "../preact.js";
import { IconoFilePlus } from "../iconos.js";

export function NuevoArchivo({ rutaActual }) {
  return html`
    <dialog class="archivos-modal" id="nuevo-archivo-modal">
      <div class="modal-header">
        <span>Nuevo archivo</span>
        <button class="boton boton--fantasma boton--cerrar-modal" commandfor="nuevo-archivo-modal" command="close">X</button>
      </div>
      <form class="modal-contenido">
        <div class="flex-align-items">
          <${ IconoFilePlus } />
          <div class="form-group">
            <label htmlFor="nombre-nuevo-archivo">Nombre</label>
            <input id="nombre-nuevo-archivo" type="text" placeholder="nuevo-archivo.txt" />
          </div>
        </div>
        <div class="nueva-carpeta-info">
          <span>El archivo se creara en:</span>
          <p>${rutaActual}</p>
        </div>
        <div class="flex-align-items">
          <button class="boton boton--fantasma" type="button" commandfor="nuevo-archivo-modal" command="close">Cancelar</button>
          <button class="boton boton--primario" type="submit">Crear archivo</button>
        </div>
      </form>
    </dialog>
  `;
}
