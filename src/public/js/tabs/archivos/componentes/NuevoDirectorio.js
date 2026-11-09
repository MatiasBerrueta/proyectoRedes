import { html } from "../preact.js";
import { IconoCarpeta } from "../iconos.js";
import { crearDirectorio } from "../../../api.js";

export function NuevoDirectorio({ rutaActual, onCreado }) {
  const crear = async (event) => {
    event.preventDefault();

    const form = event.currentTarget;
    const nombre = new FormData(form).get("nombre")?.trim();

    if (!nombre) return;

    try {
      await crearDirectorio(rutaActual, nombre);
      form.reset();
      form.closest("dialog").close();
      onCreado();
    } catch (error) {
      console.error("Error al crear carpeta:", error);
      alert("No se pudo crear la carpeta.");
    }
  }

  return html`
    <dialog class="archivos-modal" id="nueva-carpeta-modal">
      <div class="modal-header">
        <span>Nueva carpeta</span>
        <button class="boton boton--fantasma boton--cerrar-modal" commandfor="nueva-carpeta-modal" command="close">X</button>
      </div>
      <form class="modal-contenido" onSubmit=${crear}>
        <div class="flex-align-items">
          <${ IconoCarpeta } />
          <div class="form-group">
            <label htmlFor="nombre-nueva-carpeta">Nombre</label>
            <input name="nombre" id="nombre-nueva-carpeta" type="text" placeholder="nueva-carpeta" />
          </div>
        </div>
        <div class="nueva-carpeta-info">
          <span>La carpeta se creara en:</span>
          <p>/home/${rutaActual}</p>
        </div>
        <div class="flex-align-items">
          <button class="boton boton--secundario" type="button" commandfor="nueva-carpeta-modal" command="close">Cancelar</button>
          <button class="boton boton--primario" type="submit">Crear carpeta</button>
        </div>
      </form>
    </dialog>
  `;
}
