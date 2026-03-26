const consola = document.querySelector('.contenido-consola');
const botonIniciar = document.querySelector('.boton.iniciar');
const botonDetener = document.querySelector('.boton.detener');
const botonReiniciar = document.querySelector('.boton.reiniciar');
const textoEstado = document.querySelector('.texto-estado');

const pathName = window.location.pathname;
const serverId = pathName.split('/').at(-2);

const ansi_up = new AnsiUp();
ansi_up.use_classes = true;

async function obtenerDatosWebSocket(serverId) {
    const form = new FormData();
    form.append("servidor_id", serverId);

    const res = await fetch("/api/websocket", {
        method: "POST",
        body: form
    });

    return await res.json();
}

let webSocket;

async function iniciarWebSocket(serverId) {
    const datosWS = await obtenerDatosWebSocket(serverId);

    const socketUrl = datosWS.data.socket;
    const token = datosWS.data.token;

    webSocket = new WebSocket(socketUrl, [], {
        headers: {
            'Authorization': `Bearer ${token}`,
            'Origin': 'http://localhost:8081'
        }
    });

    webSocket.onopen = function(event) {
        console.log('WebSocket connection established');
        
        webSocket.send(JSON.stringify({
            event: 'auth',
            args: [token]
        }));
    };

    webSocket.onmessage = function(event) {
        const message = JSON.parse(event.data);
    
        switch(message.event) {
            case 'console output':
                console.log('Console:', message.args[0]);

                const raw = message.args[0];
                const html = ansi_up.ansi_to_html(raw);
                const div = document.createElement('div');
                div.className = 'line';
                div.innerHTML = html.replace(/\n/g, '<br>');

                consola.appendChild(div);

                consola.scrollTop = consola.scrollHeight;
                break;
            case 'status':
                console.log('Status changed:', message.args[0]);
                textoEstado.innerText = message.args[0];
                break;
            case 'stats':
                const stats = JSON.parse(message.args[0]);
                console.log('Resource usage:', stats);
                break;
        }
    };
}

iniciarWebSocket(serverId);

botonIniciar.addEventListener('click', () => {
    webSocket.send(JSON.stringify({
        event: 'set state',
        args: ['start']
    }));
})

botonDetener.addEventListener('click', () => {
    webSocket.send(JSON.stringify({
        event: 'set state',
        args: ['stop']
    }));
})

botonReiniciar.addEventListener('click', () => {
    webSocket.send(JSON.stringify({
        event: 'set state',
        args: ['restart']
    }));
})