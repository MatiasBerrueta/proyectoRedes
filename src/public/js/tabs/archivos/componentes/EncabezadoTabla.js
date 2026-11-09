import { html, useRef, useEffect } from "../preact.js";
import { IconoOrden } from "../iconos.js";

const COLUMNAS = [
  { campo: "nombre", etiqueta: "Nombre" },
  { campo: "tamano", etiqueta: "Tamano" },
  { campo: "modificado", etiqueta: "Modificado" },
];

export function EncabezadoTabla({
  orden,
  onOrdenar,
  todos,
  indeterminado,
  onAlternarTodos,
}) {
  const checkboxTodos = useRef(null);

  useEffect(() => {
    if (!checkboxTodos.current) return;
    checkboxTodos.current.indeterminate = indeterminado;
  }, [indeterminado]);

  return html`
    <div class="contenedor-archivos-header">
      <input
        type="checkbox"
        value="all"
        name="archivos-seleccionados"
        ref=${checkboxTodos}
        checked=${todos}
        onChange=${onAlternarTodos}
      />
      ${COLUMNAS.map(({ campo, etiqueta }) => {
        const activo = orden.campo === campo;
        const clases = [
          "columna-boton",
          activo ? "activo" : "",
          activo ? orden.direccion : "",
        ]
          .join(" ")
          .trim();

        return html`
          <button
            key=${campo}
            type="button"
            class=${clases}
            onClick=${() => onOrdenar(campo)}
          >
            ${etiqueta}
            <${IconoOrden} />
          </button>
        `;
      })}
    </div>
  `;
}
