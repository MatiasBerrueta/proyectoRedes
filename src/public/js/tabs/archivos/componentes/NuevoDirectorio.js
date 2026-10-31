import { html } from "../preact.js";
import { IconoCarpeta } from "../iconos.js";

export function NuevoDirectorio({ rutaActual, idServidor, onCreado }) {
  const crearDirectorio = async (event) => {
    event.preventDefault();

    const form = event.currentTarget;
    const formData = new FormData(form);
    const nombre = formData.get("nombre");

    const ruta = "/" + String(rutaActual ?? "").replace(/^\/+|\/+$/g, "");

    const body = JSON.stringify({
      "ruta": ruta,
      "nombre": nombre,
    })

    try {
      const respuesta = await fetch(`/api/servidores/${idServidor}/archivos/crearDirectorio`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: body
      });
      if (!respuesta.ok) throw new Error(await respuesta.text());

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
      <form class="modal-contenido" onSubmit=${crearDirectorio}>
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
