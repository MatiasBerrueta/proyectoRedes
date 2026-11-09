import { html, useState, useMemo } from "../preact.js";
import { normalizar, comparar } from "../utilidades.js";
import { FilaArchivo } from "./FilaArchivo.js";
import { BarraHerramientas } from "./BarraHerramientas.js";
import { SeleccionFlotante } from "./SeleccionFlotante.js";
import { EncabezadoTabla } from "./EncabezadoTabla.js";
import { MenuAcciones } from "./MenuAcciones.js";
import { ModalesArchivos } from "./ModalesArchivos.js";
import { objetivosAccion, seleccionadosIds } from "../App.js";
import { descargarArchivo } from "../../../api.js";

export function ListadoDirectorio({ path, archivos, onNavegar }) {
  const [busqueda, setBusqueda] = useState("");
  const [orden, setOrden] = useState({ campo: "nombre", direccion: "asc" });

  const accionSeleccionados = () => {
    objetivosAccion.value = [...seleccionadosIds.value];

    console.log(`Acciones sobre seleccion: ${objetivosAccion.value}`);
  };

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

  const cantidadVisibleSeleccionada = useMemo(
    () => visibles.filter((item) => seleccionadosIds.value.has(item.nombre)).length,
    [visibles, seleccionadosIds.value],
  );

  const todos = visibles.length > 0 && cantidadVisibleSeleccionada === visibles.length;
  const indeterminado = cantidadVisibleSeleccionada > 0 && !todos;

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

  const onDescargar = async () => {
    const link = await descargarArchivo(path, objetivosAccion.value[0]);
    console.log(link);

    const enlace = document.createElement('a');
    enlace.href = link;
    enlace.setAttribute('download', '');
    enlace.style.display = 'none';

    document.body.appendChild(enlace);
    enlace.click();
    document.body.removeChild(enlace);
  };

  const ordenarPor = (campo) => {
    setOrden((prev) =>
      prev.campo === campo
        ? { campo, direccion: prev.direccion === "asc" ? "desc" : "asc" }
        : { campo, direccion: "asc" },
    );
  };

  return html`
    <${BarraHerramientas} busqueda=${busqueda} onBuscar=${setBusqueda} />

    <${SeleccionFlotante}
      cantidad=${itemsSeleccionados.length}
      onDescargar=${onDescargar}
      onMover=${accionSeleccionados}
      onEliminar=${accionSeleccionados}
      onCancelar=${cancelarSeleccion}
    />

    <div class="contenedor-archivos">
      <${EncabezadoTabla}
        orden=${orden}
        onOrdenar=${ordenarPor}
        todos=${todos}
        indeterminado=${indeterminado}
        onAlternarTodos=${alternarTodos}
      />

      ${busqueda != "" && visibles.length === 0
        ? html`<div class="archivos-vacio">
          <strong>Sin resultados</strong>
          <span
            >No se encontraron archivos o carpetas que coincidan con la
            búsqueda.</span
          >
        </div>`
        : visibles.length === 0
        ? html`<div class="archivos-vacio">
            <strong>Directorio vacio</strong>
            <span
              >Este directorio no tiene contenido.</span
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

    <${MenuAcciones} onDescargar=${onDescargar} />
    <${ModalesArchivos}
      rutaActual=${path}
      onNavegar=${onNavegar}
    />
  `;
}
