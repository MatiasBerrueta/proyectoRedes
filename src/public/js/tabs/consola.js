import {
  enviarComando,
  iniciarServidor,
  detenerServidor,
  reiniciarServidor,
  suscribir,
} from "/js/servidor/servidorWebsocket.js";

const ansi_up = new AnsiUp();
ansi_up.use_classes = true;

const estadosMap = {
  running: "Activo",
  starting: "Iniciando",
  stopping: "Deteniendo",
  offline: "Inactivo",
};

function formatearMilisegundos(milisegundos) {
  let segundos = Math.floor(milisegundos / 1000);
  const dias = Math.floor(segundos / 86400);
  const horas = Math.floor((segundos % 86400) / 3600);
  const minutos = Math.floor((segundos % 3600) / 60);
  segundos = segundos % 60;

  if (dias > 0) {
    return `${dias}d ${horas}h ${minutos}m`;
  } else if (horas > 0) {
    return `${horas}h ${minutos}m`;
  } else if (minutos > 0) {
    return `${minutos}m ${segundos}s`;
  } else {
    return `${segundos}s`;
  }
}

let limpiadores = [];

export function init() {
  const formComando = document.getElementById("form-comando");
  const inputComando = document.getElementById("comando-input");
  const logsContenedor = document.getElementById("logs-contenedor");
  const textoEstado = document.querySelector(".texto-estado");
  const textoUptime = document.querySelector("[data-uptime]");

  if (logsContenedor) {
    logsContenedor.scrollTop = logsContenedor.scrollHeight;
  }

  document.querySelectorAll("[data-action]").forEach((boton) => {
    const accion = boton.dataset.action;
    const handler = () => {
      if (accion === "iniciar") iniciarServidor();
      if (accion === "detener") detenerServidor();
      if (accion === "reiniciar") reiniciarServidor();
    };
    boton.addEventListener("click", handler);
    limpiadores.push(() => boton.removeEventListener("click", handler));
  });

  const onComandoSubmit = (e) => {
    e.preventDefault();
    const comando = inputComando.value.trim();
    if (!comando) return;

    enviarComando(comando);
    inputComando.value = "";
  };

  formComando?.addEventListener("submit", onComandoSubmit);
  limpiadores.push(() => formComando?.removeEventListener("submit", onComandoSubmit));

  limpiadores.push(
    suscribir("console output", (raw) => {
      if (!logsContenedor) return;

      const html = ansi_up.ansi_to_html(raw);
      const div = document.createElement("div");
      div.className = "line";
      div.innerHTML = html.replace(/\n/g, "<br>");

      logsContenedor.appendChild(div);
      logsContenedor.scrollTop = logsContenedor.scrollHeight;
    }),
    suscribir("status", (estado) => {
      if (textoEstado) {
        textoEstado.innerText = estadosMap[estado] || "Desconocido";
      }
    }),
    suscribir("stats", (raw) => {
      const stats = JSON.parse(raw);
      if (textoUptime) {
        textoUptime.innerText = formatearMilisegundos(stats.uptime);
      }
    }),
  );
}

export function destroy() {
  limpiadores.forEach((limpiar) => limpiar());
  limpiadores = [];
}
