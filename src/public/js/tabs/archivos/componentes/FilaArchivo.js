import { html } from "../preact.js";
import { IconoArchivo, IconoCarpeta, IconoDots } from "../iconos.js";

export function FilaArchivo({ item, seleccionado, onSeleccionar, onAbrir }) {
  const abrir = () => onAbrir(item.path);

  return html`
    <div class=${"item " + item.tipo} data-tipo=${item.tipo} data-path=${item.path} onClick=${abrir}>
      <input
        type="checkbox"
        name="archivos-seleccionados"
        value=${item.nombre}
        checked=${seleccionado}
        onClick=${(e) => e.stopPropagation()}
        onChange=${() => onSeleccionar(item.path)}
      />
      <div>${item.esArchivo ? html`<${IconoArchivo} />` : html`<${IconoCarpeta} />`} ${item.nombre}</div>
      <div>${item.tamanoTexto}</div>
      <div>${item.modificadoTexto}</div>
      <button type="button" class="boton boton--icono boton--fantasma" title="Más acciones" onClick=${(e) => e.stopPropagation()}>
        <${IconoDots} />
      </button>
    </div>
  `;
}
