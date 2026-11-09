import { html, useState } from "../preact.js";
import { IconoMover } from "../iconos.js";
import { objetivosAccion } from "../App.js";
import { moverArchivo } from "../../../api.js";

export function MoverArchivo({ rutaActual, onMovido }) {
  const [moviendo, setMoviendo] = useState(false);

  const mover = async (event) => {
    event.preventDefault();

    const form = event.currentTarget;
    const destino = new FormData(form).get("destino")?.trim();
    const archivos = [...objetivosAccion.value];

    if (!destino || archivos.length === 0) return;

    setMoviendo(true);

    try {
      for (const nombre of archivos) {
        await moverArchivo(rutaActual, nombre, destino);
      }

      form.reset();
      form.closest("dialog").close();
      onMovido?.();
    } catch (error) {
      console.error("Error al mover archivo:", error);
      alert(error?.message || "No se pudo mover el archivo.");
    } finally {
      setMoviendo(false);
    }
  };

  return html`
    <dialog class="archivos-modal" id="mover-archivo-modal">
      <div class="modal-header">
        <span>Mover archivo</span>
        <button class="boton boton--fantasma boton--cerrar-modal" commandfor="mover-archivo-modal" command="close">X</button>
      </div>
      <form class="modal-contenido" onSubmit=${mover}>
        <div class="flex-align-items">
          <${ IconoMover } />
          <div class="form-group">
            <label htmlFor="ruta-destino">Ruta de destino</label>
            <input id="ruta-destino" name="destino" type="text" placeholder="carpeta/destino" />
          </div>
        </div>
        <div class="nueva-carpeta-info">
          <span>Se moverá desde:</span>
          <p>${rutaActual}</p>
        </div>
        <div class="nueva-carpeta-info">
          <span>Elementos:</span>
          <p>${objetivosAccion.value.join(", ") || "Ninguno seleccionado"}</p>
        </div>
        <div class="flex-align-items">
          <button class="boton boton--fantasma" type="button" commandfor="mover-archivo-modal" command="close">Cancelar</button>
          <button class="boton boton--primario" type="submit" disabled=${moviendo}>
            ${moviendo ? "Moviendo..." : "Mover"}
          </button>
        </div>
      </form>
    </dialog>
  `;
}
