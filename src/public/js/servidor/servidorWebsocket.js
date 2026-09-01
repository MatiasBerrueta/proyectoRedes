const match = window.location.pathname.match(/\/servidores\/([^\/]+)/);
const serverId = match ? match[1] : null;

let webSocket = null;
const suscriptores = new Map();

function emitir(evento, args) {
  const callbacks = suscriptores.get(evento);
  if (!callbacks) return;
  callbacks.forEach((callback) => callback(...args));
}

export function suscribir(evento, callback) {
  if (!suscriptores.has(evento)) {
    suscriptores.set(evento, new Set());
  }
  suscriptores.get(evento).add(callback);
  return () => suscriptores.get(evento)?.delete(callback);
}

function enviarEvento(evento, args) {
  if (!webSocket) return;
  webSocket.send(JSON.stringify({ event: evento, args }));
}

export function enviarComando(comando) {
  enviarEvento("send command", [comando]);
}

export function iniciarServidor() {
  enviarEvento("set state", ["start"]);
  console.log("inciando");
}

export function detenerServidor() {
  enviarEvento("set state", ["stop"]);
}

export function reiniciarServidor() {
  enviarEvento("set state", ["restart"]);
}

async function obtenerDatosWebSocket(id) {
  const form = new FormData();
  form.append("servidor_id", id);

  const res = await fetch("/api/websocket", {
    method: "POST",
    body: form,
  });

  return await res.json();
}

async function iniciarWebSocket(id) {
  const datosWS = await obtenerDatosWebSocket(id);

  const socketUrl = datosWS.data.socket;
  const token = datosWS.data.token;

  webSocket = new WebSocket(socketUrl, [], {
    headers: {
      Authorization: `Bearer ${token}`,
      Origin: "http://localhost:8081",
    },
  });

  webSocket.onopen = function (event) {
    console.log("WebSocket conectado");

    webSocket.send(
      JSON.stringify({
        event: "auth",
        args: [token],
      }),
    );
  };

  webSocket.onmessage = function (event) {
    const message = JSON.parse(event.data);
    emitir(message.event, message.args ?? []);
  };
}

iniciarWebSocket(serverId);
