import { html } from "../preact.js";
import { IconoFilePlus } from "../iconos.js";
import { crearArchivo } from "../../../api.js";

export function NuevoArchivo({ rutaActual, onCrear }) {
  const crear = async (event) => {
    event.preventDefault();

    const form = event.currentTarget;
    const nombre = new FormData(form).get("nombre")?.trim();

    if (!nombre) return;

    try {
      await crearArchivo(rutaActual, nombre);
      form.reset();
      form.closest("dialog").close();
      onCrear();
    } catch (error) {
      console.error("Error al crear archivo:", error);
      alert("No se pudo crear el archivo.");
    }
  }

  return html`
    <dialog class="archivos-modal" id="nuevo-archivo-modal">
      <div class="modal-header">
        <span>Nuevo archivo</span>
        <button class="boton boton--fantasma boton--cerrar-modal" commandfor="nuevo-archivo-modal" command="close">X</button>
      </div>
      <form class="modal-contenido" onSubmit=${crear}>
        <div class="flex-align-items">
          <${ IconoFilePlus } />
          <div class="form-group">
            <label htmlFor="nombre-nuevo-archivo">Nombre</label>
            <input id="nombre-nuevo-archivo" name="nombre" type="text" placeholder="nuevo-archivo.txt" autofocus/>
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
