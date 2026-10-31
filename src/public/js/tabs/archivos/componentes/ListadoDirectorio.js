import { html, useState, useMemo, useRef, useEffect } from "../preact.js";
import { normalizar, comparar } from "../utilidades.js";
import { FilaArchivo } from "./FilaArchivo.js";
import { NuevoDirectorio } from "./NuevoDirectorio.js";
import { NuevoArchivo } from "./NuevoArchivo.js";
import { SubirArchivo } from "./SubirArchivo.js";
import { EliminarArchivo } from "./EliminarArchivo.js";
import { MoverArchivo } from "./MoverArchivo.js";
import { RenombrarArchivo } from "./RenombrarArchivo.js";
import { IconoBusqueda, IconoOrden, IconoPlus, IconoFilePlus, IconoSubir, IconoEliminar, IconoMover, IconoCerrar, IconoDescargar, IconoRenombrar } from "../iconos.js";
import { objetivosAccion, seleccionadosIds } from "../App.js";

const COLUMNAS = [
  { campo: "nombre", etiqueta: "Nombre" },
  { campo: "tamano", etiqueta: "Tamano" },
  { campo: "modificado", etiqueta: "Modificado" },
];

export function ListadoDirectorio({ path, archivos, idServidor, onNavegar }) {
  const [busqueda, setBusqueda] = useState("");
  const [orden, setOrden] = useState({ campo: "nombre", direccion: "asc" });

  const accionSeleccionados = () => {
    objetivosAccion.value = [...seleccionadosIds.value];

    console.log(`Acciones sobre seleccion: ${objetivosAccion.value}`);
  }

  const checkboxTodos = useRef(null);

  const visibles = useMemo(() => {
    const termino = normalizar(busqueda.trim());

    return archivos
      .filter((item) => !termino || normalizar(item.nombre).includes(termino))
      .sort((a, b) => comparar(a, b, orden));
  }, [archivos, busqueda, orden]);

  const itemsSeleccionados = useMemo(
    () => archivos.filter((item) => seleccionadosIds.value.has(item.nombre)),
    [archivos, seleccionadosIds.value],
  );

  const cantidadSeleccionada = itemsSeleccionados.length;

  const cantidadVisibleSeleccionada = useMemo(
    () => visibles.filter((item) => seleccionadosIds.value.has(item.nombre)).length,
    [visibles, seleccionadosIds.value],
  );

  useEffect(() => {
    if (!checkboxTodos.current) return;
    checkboxTodos.current.checked =
      visibles.length > 0 && cantidadVisibleSeleccionada === visibles.length;
    checkboxTodos.current.indeterminate =
      cantidadVisibleSeleccionada > 0 &&
      cantidadVisibleSeleccionada < visibles.length;
  }, [visibles, cantidadVisibleSeleccionada]);

  const alternarItem = (archivo) => {
    const idsActualizados = new Set(seleccionadosIds.value);
    if (idsActualizados.has(archivo)) idsActualizados.delete(archivo);
    else idsActualizados.add(archivo);

    seleccionadosIds.value = idsActualizados;
  };

  const alternarTodos = () => {
    const idsActualizados = new Set(seleccionadosIds.value);
    if (cantidadVisibleSeleccionada === visibles.length && visibles.length > 0) {
      visibles.forEach((item) => idsActualizados.delete(item.nombre));
    } else {
      visibles.forEach((item) => idsActualizados.add(item.nombre));
    }

    seleccionadosIds.value = idsActualizados;
  };

  const cancelarSeleccion = () => {
    seleccionadosIds.value = new Set();
  };

  const onDescargar = () => {
    console.log('Descargando...');
  }

  const accionSeleccion = (callback) => () => {
    if (callback) callback(itemsSeleccionados);
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
        <button type="button" class="boton boton--s" commandfor="nueva-carpeta-modal" command="show-modal">
          <${IconoPlus} /> Nueva carpeta
        </button>
        <button type="button" class="boton boton--s" commandfor="nuevo-archivo-modal" command="show-modal">
          <${IconoFilePlus} /> Nuevo archivo
        </button>
        <button type="button" class="boton boton--s boton--primario" commandfor="subir-archivo-modal" command="show-modal">
          <${IconoSubir} /> Subir archivo
        </button>
        <!--<input type="file" id="inputArchivo" />-->
      </div>
    </div>

    ${html`
      <div
        class=${"archivos-seleccion-flotante" +
        (cantidadSeleccionada > 0 ? " activo" : "")}
        role="toolbar"
        aria-label="Acciones de la selección"
        aria-hidden=${cantidadSeleccionada === 0}
        inert=${cantidadSeleccionada === 0 ? "" : undefined}
      >
        <span class="archivos-seleccion-contador">
          <strong>${cantidadSeleccionada} </strong>
          ${cantidadSeleccionada <= 1 ? "seleccionado" : "seleccionados"}
        </span>
        <div class="archivos-seleccion-acciones">
          <button
            type="button"
            class="boton boton--s"
            onClick=${accionSeleccion(onDescargar)}
          >
            <${IconoDescargar} /> Descargar
          </button>
          <button
            type="button"
            class="boton boton--s"
            commandfor="mover-archivo-modal"
            command="show-modal"
          >
            <${IconoMover} /> Mover
          </button>
          <button
            type="button"
            class="boton boton--s boton--peligro"
            commandfor="eliminar-archivo-modal"
            command="show-modal"
            onClick=${accionSeleccionados}
          >
            <${IconoEliminar} /> Eliminar
          </button>
          <button
            type="button"
            class="boton boton--s boton--fantasma boton--cancelar"
            title="Cancelar selección"
            onClick=${cancelarSeleccion}
          >
            <${IconoCerrar} />
          </button>
        </div>
      </div>
    `}

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
              onClick=${() => ordenarPor(campo)}
            >
              ${etiqueta}
              <${IconoOrden} />
            </button>
          `;
        })}
      </div>

      ${visibles.length === 0
        ? html`<div class="archivos-vacio">
            <strong>Sin resultados</strong>
            <span
              >No se encontraron archivos o carpetas que coincidan con la
              búsqueda.</span
            >
          </div>`
        : visibles.map(
            (item) => html`
              <${FilaArchivo}
                key=${item.nombre}
                item=${item}
                seleccionado=${seleccionadosIds.value.has(item.nombre)}
                onSeleccionar=${alternarItem}
                onAbrir=${onNavegar}
              />
            `,
          )}
    </div>
    <div
      id="archivo-popover"
      class="archivos-popover"
      popover
      aria-labelledby="archivos-popover-titulo"
    >
      <div class="archivos-popover__opciones">
        <button
          type="button"
          class="archivos-popover__opcion"
          commandfor="renombrar-archivo-modal"
          command="show-modal"
        >
          <${IconoRenombrar} /> Renombrar
        </button>
        <button
          type="button"
          class="archivos-popover__opcion"
        >
          <${IconoDescargar} /> Descargar
        </button>
        <button
          type="button"
          class="archivos-popover__opcion"
          commandfor="mover-archivo-modal"
          command="show-modal"
        >
          <${IconoMover} /> Mover
        </button>
        <button
          type="button"
          class="archivos-popover__opcion archivos-popover__opcion--peligro"
          commandfor="eliminar-archivo-modal"
          command="show-modal"
        >
          <${IconoEliminar} /> Eliminar
        </button>
      </div>
    </div>
    <${NuevoDirectorio} rutaActual=${path} idServidor=${idServidor} onCreado=${() => onNavegar(path)} />
    <${NuevoArchivo} rutaActual=${path}/>
    <${SubirArchivo} rutaActual=${path}/>
    <${MoverArchivo} rutaActual=${path}/>
    <${RenombrarArchivo} />
    <${EliminarArchivo} rutaActual=${path} idServidor=${idServidor} onEliminado=${() => onNavegar(path)} />
  `;
}
