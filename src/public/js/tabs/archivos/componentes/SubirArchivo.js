import { html } from "../preact.js";
import { IconoSubir } from "../iconos.js";

export function SubirArchivo({ rutaActual }) {
  return html`
    <dialog class="archivos-modal" id="subir-archivo-modal">
      <div class="modal-header">
        <span>Subir archivo</span>
        <button class="boton boton--fantasma boton--cerrar-modal" commandfor="subir-archivo-modal" command="close">X</button>
      </div>
      <form class="modal-contenido">
        <div class="flex-align-items">
          <${ IconoSubir } />
          <div class="form-group">
            <label htmlFor="archivos-a-subir">Archivos</label>
            <input id="archivos-a-subir" type="file" multiple />
          </div>
        </div>
        <div class="nueva-carpeta-info">
          <span>Los archivos se subiran a:</span>
          <p>${rutaActual}</p>
        </div>
        <div class="flex-align-items">
          <button class="boton boton--fantasma" type="button" commandfor="subir-archivo-modal" command="close">Cancelar</button>
          <button class="boton boton--primario" type="submit">Subir archivo</button>
        </div>
      </form>
    </dialog>
  `;
}
