import { html } from "../preact.js";
import { NuevoDirectorio } from "./NuevoDirectorio.js";
import { NuevoArchivo } from "./NuevoArchivo.js";
import { SubirArchivo } from "./SubirArchivo.js";
import { MoverArchivo } from "./MoverArchivo.js";
import { RenombrarArchivo } from "./RenombrarArchivo.js";
import { EliminarArchivo } from "./EliminarArchivo.js";

export function ModalesArchivos({ rutaActual, onNavegar }) {
  return html`
    <${NuevoDirectorio}
      rutaActual=${rutaActual}
      onCreado=${() => onNavegar(rutaActual)}
    />
    <${NuevoArchivo}
      rutaActual=${rutaActual}
      onCrear=${() => onNavegar(rutaActual)}
    />
    <${SubirArchivo}
      rutaActual=${rutaActual}
      onSubido=${() => onNavegar(rutaActual)}
    />
    <${MoverArchivo}
      rutaActual=${rutaActual}
      onMovido=${() => onNavegar(rutaActual)}
    />
    <${RenombrarArchivo}
      rutaActual=${rutaActual}
      onRenombrar=${() => onNavegar(rutaActual)}
    />
    <${EliminarArchivo}
      rutaActual=${rutaActual}
      onEliminado=${() => onNavegar(rutaActual)}
    />
  `;
}
