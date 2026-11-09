import { html, useState } from "../preact.js";
import { IconoSubir } from "../iconos.js";
import { subirArchivos } from "../../../api.js";

export function SubirArchivo({ rutaActual, onSubido }) {
  const [subiendo, setSubiendo] = useState(false);

  const subir = async (event) => {
    event.preventDefault();

    const form = event.currentTarget;
    const input = form.querySelector('input[type="file"]');
    const archivos = input?.files;

    if (!archivos || archivos.length === 0) return;

    setSubiendo(true);

    try {
      const resultado = await subirArchivos(rutaActual, archivos);

      form.reset();
      form.closest("dialog").close();
      onSubido?.();

      if (resultado?.errores?.length) {
        alert(resultado.errores.join("\n"));
      }
    } catch (error) {
      console.error("Error al subir archivos:", error);
      alert(error?.message || "No se pudieron subir los archivos.");
    } finally {
      setSubiendo(false);
    }
  };

  return html`
    <dialog class="archivos-modal" id="subir-archivo-modal">
      <div class="modal-header">
        <span>Subir archivo</span>
        <button class="boton boton--fantasma boton--cerrar-modal" commandfor="subir-archivo-modal" command="close">X</button>
      </div>
      <form class="modal-contenido" onSubmit=${subir}>
        <div class="flex-align-items">
          <${ IconoSubir } />
          <div class="form-group">
            <label htmlFor="archivos-a-subir">Archivos</label>
            <input id="archivos-a-subir" name="archivos[]" type="file" multiple />
          </div>
        </div>
        <div class="nueva-carpeta-info">
          <span>Los archivos se subirán a:</span>
          <p>${rutaActual}</p>
        </div>
        <div class="flex-align-items">
          <button class="boton boton--fantasma" type="button" commandfor="subir-archivo-modal" command="close">Cancelar</button>
          <button class="boton boton--primario" type="submit" disabled=${subiendo}>
            ${subiendo ? "Subiendo..." : "Subir archivo"}
          </button>
        </div>
      </form>
    </dialog>
  `;
}
