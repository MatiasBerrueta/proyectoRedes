import { html } from "../preact.js";
import { IconoEliminar } from "../iconos.js";
import { objetivosAccion } from "../App.js";

export function EliminarArchivo({ rutaActual, idServidor, onEliminado }) {
  const eliminarArchivo = async (event) => {
    event.preventDefault();

    const form = event.currentTarget;

    const ruta = "/" + String(rutaActual ?? "").replace(/^\/+|\/+$/g, "");

    const body = JSON.stringify({
      "ruta": ruta,
      "archivos": objetivosAccion.value,
    })

    try {
      const respuesta = await fetch(`/api/servidores/${idServidor}/archivos/eliminar`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: body
      });
      if (!respuesta.ok) throw new Error(await respuesta.text());

      form.closest("dialog").close();
      onEliminado();
    } catch (error) {
      console.error("Error al eliminar archivo:", error);
      alert("No se pudo eliminar el archivo.");
    }
  }

  return html`
    <dialog class="archivos-modal" id="eliminar-archivo-modal">
      <div class="modal-header">
        <span>Eliminar archivo</span>
        <button class="boton boton--fantasma boton--cerrar-modal" commandfor="eliminar-archivo-modal" command="close">X</button>
      </div>
      <form class="modal-contenido" onSubmit=${eliminarArchivo}>
        <div class="flex-align-items">
          <${ IconoEliminar } />
          <div class="form-group">
            ${objetivosAccion.value.length === 1
                ? html`<p>Se eliminará el archivo <b>${objetivosAccion.value[0]}</b>.</p>`
                : html`<p>Se eliminarán ${objetivosAccion.value.length} archivos seleccionados</p>`
              }
          </div>
        </div>
        <div class="flex-align-items">
          <button class="boton boton--fantasma" type="button" commandfor="eliminar-archivo-modal" command="close">Cancelar</button>
          <button class="boton boton--peligro" type="submit">Eliminar</button>
        </div>
      </form>
    </dialog>
  `;
}
