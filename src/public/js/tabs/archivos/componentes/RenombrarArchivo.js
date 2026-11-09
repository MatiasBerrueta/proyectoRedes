import { html } from "../preact.js";
import { IconoRenombrar } from "../iconos.js";
import { objetivosAccion } from "../App.js";
import { renombrarArchivo } from "../../../api.js";

export function RenombrarArchivo({ rutaActual, onRenombrar }) {
  const renombrar = async (event) => {
    event.preventDefault();

    const form = event.currentTarget;
    const nombreNuevo = new FormData(form).get("nombreNuevo")?.trim();

    if (!nombreNuevo) return;

    try {
      await renombrarArchivo(rutaActual, objetivosAccion.value[0], nombreNuevo);
      form.reset();
      form.closest("dialog").close();
      onRenombrar();
    } catch (error) {
      console.error("Error al renombrar archivo:", error);
      alert("No se pudo renombrar el archivo.");
    }
  }

  return html`
    <dialog class="archivos-modal" id="renombrar-archivo-modal">
      <div class="modal-header">
        <span>Renombrar archivo</span>
        <button class="boton boton--fantasma boton--cerrar-modal" commandfor="renombrar-archivo-modal" command="close">X</button>
      </div>
      <form class="modal-contenido" onSubmit=${renombrar}>
        <div class="flex-align-items">
          <${ IconoRenombrar } />
          <div class="form-group">
            <label htmlFor="nombre-renombrado">Nuevo nombre</label>
            <input id="nombre-renombrado" name="nombreNuevo" value=${objetivosAccion.value[0]} type="text" placeholder="nombre-nuevo.txt" autofocus />
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
