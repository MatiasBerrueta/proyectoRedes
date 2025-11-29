const header = document.querySelector('header');
const menuDropdown = document.getElementById('menu-dropdown');
const botonMenuUsuario = document.getElementById('boton-menu-usuario');
const botonCambiarTema = document.getElementById('boton-cambiar-tema');

botonMenuUsuario.addEventListener('click', () => {
    const estaAbierto = menuDropdown.hasAttribute('hidden') === false;

    menuDropdown.toggleAttribute('hidden');
    botonMenuUsuario.setAttribute('aria-expanded', !estaAbierto)
});

document.addEventListener('click', (evento) => {
    if(!botonMenuUsuario.contains(evento.target) && !menuDropdown.contains(evento.target)) {
        menuDropdown.setAttribute('hidden', '');
        botonMenuUsuario.setAttribute('aria-expanded', 'false')
    }
});

botonCambiarTema.addEventListener('click', (evento) => {
    if(!document.startViewTransition) {
        document.documentElement.classList.toggle('tema-oscuro');
        return;
    }

    document.documentElement.style.setProperty("--x", evento.clientX + "px");
    document.documentElement.style.setProperty("--y", evento.clientY + "px");

    document.startViewTransition(() => {
        document.documentElement.classList.toggle('tema-oscuro');
    })
});