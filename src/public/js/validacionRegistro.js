const inputEmail = document.getElementById('input-email');
const inputContrasena = document.getElementById('input-contrasena');
const inputConfirmarContrasena = document.getElementById('input-confirmar-contrasena');

// Este regex cumple con el estandar RFC 5322 y funciona en el 99% de los casos incluyendo los mas raros. 
// Tambien corrige un error de otro similar donde se aceptaba una IP con 00 (no valido en IPV4)
// No le encuentro un uso real todavia va a quedar comentado por ahora.
// const emailRegex = /(?:[a-z0-9!#$%&'*+\x2f=?^_`\x7b-\x7d~\x2d]+(?:\.[a-z0-9!#$%&'*+\x2f=?^_`\x7b-\x7d~\x2d]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9\x2d]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9\x2d]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9\x2d]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/i;

// Regex mas simple funciona en la mayoria de los casos comunes
// por ser mas simple se va a usar hasta que empiece a fallar.
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;


// -No funciona en el confirmar contrasena del todo, si lo haces en orden si, pero si escribis la primera
//  contrasena bien despues la segunda bien y volves a cambiar la primera la segunda aparece como bien porque
//  no se cambio todavia, la segunda deberia seguir al primero tambien para que se actualice al mismo tiempo.
// -Falta agregar un mensaje que diga porque el campo no es valido.
function validarCampo(criterio, elementoValidar) {
    if(criterio) {
        elementoValidar.classList.remove('campo-no-valido')
        elementoValidar.classList.add('campo-valido')
    } else {
        elementoValidar.classList.remove('campo-valido')
        elementoValidar.classList.add('campo-no-valido')
    }
}

inputEmail.addEventListener('input', () => validarCampo(emailRegex.test(inputEmail.value), inputEmail));
inputContrasena.addEventListener('input', () => {
        validarCampo(inputContrasena.value.length >= 3, inputContrasena);
        validarCampo(inputConfirmarContrasena.value === inputContrasena.value, inputConfirmarContrasena)
    });
inputConfirmarContrasena.addEventListener('input', () => validarCampo(inputConfirmarContrasena.value === inputContrasena.value, inputConfirmarContrasena));