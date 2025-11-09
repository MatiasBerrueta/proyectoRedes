const formularioRegistro = document.getElementById('formulario-registro');

const inputEmail = document.getElementById('input-email');
const inputContrasena = document.getElementById('input-contrasena');
const inputConfirmarContrasena = document.getElementById('input-confirmar-contrasena');

const mensajeErrorEmail = document.getElementById('mensaje-error-email');
const mensajeErrorContrasena = document.getElementById('mensaje-error-contrasena');
const mensajeErrorConfirmarContrasena = document.getElementById('mensaje-error-confirmar-contrasena');
const mensajeErrorGeneral = document.getElementById('mensaje-error-general');

// Este regex cumple con el estandar RFC 5322 y funciona en el 99% de los casos incluyendo los mas raros. 
// Tambien corrige un error de otro similar donde se aceptaba una IP con 00 (no valido en IPV4)
// No le encuentro un uso real todavia va a quedar comentado por ahora.
// const emailRegex = /(?:[a-z0-9!#$%&'*+\x2f=?^_`\x7b-\x7d~\x2d]+(?:\.[a-z0-9!#$%&'*+\x2f=?^_`\x7b-\x7d~\x2d]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9\x2d]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9\x2d]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9\x2d]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/i;

// Regex mas simple funciona en la mayoria de los casos comunes
// por ser mas simple se va a usar hasta que empiece a fallar.
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

function validarInputEmail(elementoValidar) {
    if(emailRegex.test(elementoValidar.value)) {
        elementoValidar.classList.remove('campo-no-valido');
        // elementoValidar.classList.add('campo-valido');
    } else {
        // elementoValidar.classList.remove('campo-valido');
        elementoValidar.classList.add('campo-no-valido');
    }
}

function validarInputContrasena(elementoValidar) {
    if(elementoValidar.value.length >= 3) {
        elementoValidar.classList.remove('campo-no-valido');
        // elementoValidar.classList.add('campo-valido');
    } else {
        // elementoValidar.classList.remove('campo-valido');
        elementoValidar.classList.add('campo-no-valido');
    }
}

function validarInputConfirmarContrasena(elementoValidar) {
    if(elementoValidar.value === inputContrasena.value) {
        elementoValidar.classList.remove('campo-no-valido');
        // elementoValidar.classList.add('campo-valido');
    } else {
        // elementoValidar.classList.remove('campo-valido');
        elementoValidar.classList.add('campo-no-valido');
    }
}


inputEmail.addEventListener('blur', () => validarInputEmail(inputEmail));
inputContrasena.addEventListener('blur', () => validarInputContrasena(inputContrasena));
inputConfirmarContrasena.addEventListener('blur', () => validarInputConfirmarContrasena(inputConfirmarContrasena));

// formularioRegistro.addEventListener('submit', (event) => {
//     event.preventDefault();

//     fetch('/registrarCliente', {
//         method: 'POST',
//         body: new FormData(formularioRegistro),
//     })
//     .then(res => res.json())
//     .then(data => {
//         console.log(data);
//         if(data.success) {
//             window.location = data.redirect;
//         }
        
//         mensajeErrorEmail.textContent = data.errores.email;
//         mensajeErrorContrasena.textContent = data.errores.contrasena;
//         mensajeErrorConfirmarContrasena.textContent = data.errores.confirmarContrasena;
//         mensajeErrorGeneral.textContent = data.errores.general;
//     })
    
// })