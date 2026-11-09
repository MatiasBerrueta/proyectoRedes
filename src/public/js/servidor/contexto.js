// Acceso unico a los datos del servidor que renderiza servidor.php.
export function obtenerServidor() {
  return globalThis.estadoInicial?.servidor ?? null;
}

export function obtenerIdServidor() {
  return obtenerServidor()?.identifier ?? null;
}
