import { html, useState, useMemo, useRef, useEffect } from "../preact.js";
import { IconoBusqueda, IconoOrden } from "../iconos.js";
import { normalizar, comparar } from "../utilidades.js";
import { FilaArchivo } from "./FilaArchivo.js";
import { IconoPlus, IconoFilePlus, IconoSubir } from "../iconos.js";

const COLUMNAS = [
  { campo: "nombre", etiqueta: "Nombre" },
  { campo: "tamano", etiqueta: "Tamano" },
  { campo: "modificado", etiqueta: "Modificado" },
];

export function ListadoDirectorio({ archivos, onNavegar }) {
  const [busqueda, setBusqueda] = useState("");
  const [orden, setOrden] = useState({ campo: "nombre", direccion: "asc" });
  const [seleccionados, setSeleccionados] = useState(() => new Set());

  const checkboxTodos = useRef(null);

  const visibles = useMemo(() => {
    const termino = normalizar(busqueda.trim());

    return archivos
      .filter((item) => !termino || normalizar(item.nombre).includes(termino))
      .sort((a, b) => comparar(a, b, orden));
  }, [archivos, busqueda, orden]);

  const cantidadSeleccionada = useMemo(
    () => visibles.filter((item) => seleccionados.has(item.path)).length,
    [visibles, seleccionados],
  );

  useEffect(() => {
    if (!checkboxTodos.current) return;
    checkboxTodos.current.checked = visibles.length > 0 && cantidadSeleccionada === visibles.length;
    checkboxTodos.current.indeterminate = cantidadSeleccionada > 0 && cantidadSeleccionada < visibles.length;
  }, [visibles, cantidadSeleccionada]);

  const alternarItem = (path) => {
    setSeleccionados((prev) => {
      const siguiente = new Set(prev);
      if (siguiente.has(path)) siguiente.delete(path);
      else siguiente.add(path);
      return siguiente;
    });
  };

  const alternarTodos = () => {
    setSeleccionados((prev) => {
      const siguiente = new Set(prev);
      if (cantidadSeleccionada === visibles.length && visibles.length > 0) {
        visibles.forEach((item) => siguiente.delete(item.path));
      } else {
        visibles.forEach((item) => siguiente.add(item.path));
      }
      return siguiente;
    });
  };

  const ordenarPor = (campo) => {
    setOrden((prev) =>
      prev.campo === campo
        ? { campo, direccion: prev.direccion === "asc" ? "desc" : "asc" }
        : { campo, direccion: "asc" },
    );
  };

  return html`
    <div class="archivos-toolbar">
      <div class="archivos-busqueda">
        <${IconoBusqueda} />
        <input
          type="search"
          placeholder="Buscar archivos y carpetas..."
          value=${busqueda}
          onInput=${(e) => setBusqueda(e.target.value)}
        />
      </div>
      <div class="acciones">
        <button type="button" class="boton boton--s"><${IconoPlus} /> Nueva carpeta</button>
        <button type="button" class="boton boton--s"><${IconoFilePlus} /> Nuevo archivo</button>
        <button type="button" class="boton boton--s boton--primario"><${IconoSubir} /> Subir archivo</button>
      </div>
    </div>
    <span class="archivos-contador">${visibles.length} elementos</span>

    <div class="contenedor-archivos">
      <div class="contenedor-archivos-header">
        <input
          type="checkbox"
          value="all"
          name="archivos-seleccionados"
          ref=${checkboxTodos}
          onChange=${alternarTodos}
        />
        ${COLUMNAS.map(({ campo, etiqueta }) => {
          const activo = orden.campo === campo;
          const clases = ["columna-boton", activo ? "activo" : "", activo ? orden.direccion : ""].join(" ").trim();

          return html`
            <button key=${campo} type="button" class=${clases} onClick=${() => ordenarPor(campo)}>
              ${etiqueta}
              <${IconoOrden} />
            </button>
          `;
        })}
      </div>

      ${visibles.length === 0
        ? html`<div class="archivos-vacio">
            <strong>Sin resultados</strong>
            <span>No se encontraron archivos o carpetas que coincidan con la búsqueda.</span>
          </div>`
        : visibles.map(
            (item) => html`
              <${FilaArchivo}
                key=${item.path}
                item=${item}
                seleccionado=${seleccionados.has(item.path)}
                onSeleccionar=${alternarItem}
                onAbrir=${onNavegar}
              />
            `,
          )}
    </div>
  `;
}
