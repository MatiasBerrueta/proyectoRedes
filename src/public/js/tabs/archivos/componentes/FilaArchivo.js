import { html } from "../preact.js";
import { IconoArchivo, IconoCarpeta, IconoDots } from "../iconos.js";
import { objetivosAccion } from "../App.js";

export function FilaArchivo({
  item,
  seleccionado,
  onSeleccionar,
  onAbrir,
}) {
  const abrir = () => onAbrir(item.path);

  const accionIndividual = (event) => {
    event.stopPropagation();

    objetivosAccion.value = [item.nombre];

    console.log(`Accion sobre individual: ${objetivosAccion.value}`);
  }

  return html`
    <div class=${"item " + item.tipo} data-tipo=${item.tipo} data-path=${item.path} onClick=${abrir}>
      <input
        type="checkbox"
        name="archivos-seleccionados"
        value=${item.nombre}
        checked=${seleccionado}
        onClick=${(e) => e.stopPropagation()}
        onChange=${() => onSeleccionar(item.nombre)}
      />
      <div>${item.esArchivo ? html`<${IconoArchivo} />` : html`<${IconoCarpeta} />`} ${item.nombre}</div>
      <div>${item.tamanoTexto}</div>
      <div>${item.modificadoTexto}</div>
      <button
        type="button"
        class="boton boton--icono boton--fantasma"
        title="Más acciones"
        popovertarget="archivo-popover"
        onClick=${accionIndividual}
      >
        <${IconoDots} />
      </button>
    </div>
  `;
}
