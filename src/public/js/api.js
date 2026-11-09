import { obtenerIdServidor } from "./servidor/contexto.js";

export const rutaAbsoluta = (ruta) => "/" + String(ruta ?? "").replace(/^\/+|\/+$/g, "");

function urlArchivos(accion) {
  const idServidor = obtenerIdServidor();

  if (!idServidor) {
    throw new Error("No se pudo determinar el servidor actual.");
  }

  return `servidores/${idServidor}/archivos/${accion}`;
}

async function leerRespuesta(respuesta) {
  const texto = await respuesta.text();
  let resultado = null;

  if (texto) {
    try {
      resultado = JSON.parse(texto);
    } catch {
      resultado = texto;
    }
  }

  if (!respuesta.ok) {
    const mensaje =
      typeof resultado === "object" && resultado?.error
        ? resultado.error
        : resultado || `Error ${respuesta.status}`;

    throw new Error(mensaje);
  }

  return resultado;
}

export async function apiRequest(ruta, datos) {
  const respuesta = await fetch(`/api/${ruta}`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(datos),
  });

  return leerRespuesta(respuesta);
}

export async function subirArchivos(directorio, archivos) {
  const datos = new FormData();
  datos.append("ruta", rutaAbsoluta(directorio));

  Array.from(archivos).forEach((archivo) => {
    datos.append("archivos[]", archivo, archivo.name);
  });

  const respuesta = await fetch(`/api/${urlArchivos("subirArchivo")}`, {
    method: "POST",
    body: datos,
  });

  return leerRespuesta(respuesta);
}

export function crearArchivo(directorio, nombre) {
  return apiRequest(urlArchivos("crearArchivo"), {
    ruta: rutaAbsoluta(directorio),
    nombre,
  });
}

export function guardarArchivo(ruta, contenido) {
  const separado = ruta.split('/');
  const nombreArchivo = separado.pop();
  const directorio = separado.join('/');

  return apiRequest(urlArchivos("guardarArchivo"), {
    ruta: rutaAbsoluta(directorio),
    nombre: nombreArchivo,
    contenido: contenido,
  });
}

export function descargarArchivo(directorio, nombre) {
  return apiRequest(urlArchivos("descargarArchivo"), {
    ruta: rutaAbsoluta(directorio),
    nombre: nombre,
  });
}

export function crearDirectorio(directorio, nombre) {
  return apiRequest(urlArchivos("crearDirectorio"), {
    ruta: rutaAbsoluta(directorio),
    nombre,
  });
}

export function eliminarArchivos(directorio, archivos) {
  return apiRequest(urlArchivos("eliminar"), {
    ruta: rutaAbsoluta(directorio),
    archivos,
  });
}

export function renombrarArchivo(directorio, nombre, nombreNuevo) {
  return apiRequest(urlArchivos("renombrarArchivo"), {
    ruta: rutaAbsoluta(directorio),
    nombre,
    nombreNuevo,
  });
}

export function moverArchivo(directorio, nombre, destino) {
  return apiRequest(urlArchivos("moverArchivo"), {
    ruta: rutaAbsoluta(directorio),
    nombre,
    destino: String(destino ?? "").trim(),
  });
}
