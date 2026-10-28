const seccionesDesplegables = document.querySelectorAll(".seccion-desplegable");
const botonesAbrir = document.querySelectorAll("[data-abrir-seccion]");
const botonesCerrar = document.querySelectorAll("[data-cerrar-seccion]");

function actualizarBoton(id, abierta) {
  document.querySelectorAll(`[data-abrir-seccion="${id}"]`).forEach((boton) => {
    boton.setAttribute("aria-expanded", abierta ? "true" : "false");
    boton.classList.toggle("selector-planes__opcion--activa", abierta);
  });
}

function abrirSeccion(id) {
  const seccion = document.getElementById(id);
  if (!seccion) return;

  seccionesDesplegables.forEach((otra) => {
    if (otra === seccion) return;
    otra.hidden = true;
    actualizarBoton(otra.id, false);
  });

  seccion.hidden = false;
  actualizarBoton(id, true);
  seccion.scrollIntoView({ behavior: "smooth", block: "start" });
}

function cerrarSeccion(id) {
  const seccion = document.getElementById(id);
  if (!seccion) return;

  seccion.hidden = true;
  actualizarBoton(id, false);
}

botonesAbrir.forEach((boton) => {
  boton.addEventListener("click", () => {
    const id = boton.dataset.abrirSeccion;
    const seccion = document.getElementById(id);

    if (seccion && !seccion.hidden) {
      cerrarSeccion(id);
      return;
    }

    abrirSeccion(id);
  });
});

botonesCerrar.forEach((boton) => {
  boton.addEventListener("click", () => {
    cerrarSeccion(boton.dataset.cerrarSeccion);
  });
});
