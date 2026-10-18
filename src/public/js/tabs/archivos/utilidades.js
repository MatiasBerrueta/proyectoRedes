// Convierte todo en minusculas y sin tildes.
export function normalizar(texto) {
  return String(texto ?? "")
    .toLowerCase()
    .normalize("NFD")
    .replace(/[\u0300-\u036f]/g, "");
}

function compararPorNombre(a, b) {
  return a.nombre.localeCompare(b.nombre, "es", { sensitivity: "base", numeric: true });
}

// Ordena mostrando siempre las carpetas primero y luego segun la columna elegida.
export function comparar(a, b, orden) {
  const porTipo = Number(a.esArchivo) - Number(b.esArchivo);
  if (porTipo !== 0) return porTipo;

  const factor = orden.direccion === "asc" ? 1 : -1;

  if (orden.campo === "tamano") {
    const aTamano = a.tamano ?? -1;
    const bTamano = b.tamano ?? -1;
    if (aTamano !== bTamano) return (aTamano - bTamano) * factor;
  } else if (orden.campo === "modificado") {
    const aModificado = a.modificado ? new Date(a.modificado).getTime() : 0;
    const bModificado = b.modificado ? new Date(b.modificado).getTime() : 0;
    if (aModificado !== bModificado) return (aModificado - bModificado) * factor;
  }

  return compararPorNombre(a, b) * factor;
}
