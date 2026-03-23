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

function toggleTema() {
    if(document.documentElement.classList.contains('tema-oscuro')) {
        document.documentElement.classList.remove('tema-oscuro');
        document.documentElement.classList.add('tema-claro');
        localStorage.setItem('tema', 'claro');
    } else if(document.documentElement.classList.contains('tema-claro')) {
        document.documentElement.classList.remove('tema-claro');
        localStorage.removeItem('tema');
    } else {
        document.documentElement.classList.add('tema-oscuro');
        localStorage.setItem('tema', 'oscuro');
  }
}

botonCambiarTema.addEventListener('click', (evento) => {
    if(!document.startViewTransition) { return toggleTema(); }

    document.documentElement.style.setProperty("--x", evento.clientX + "px");
    document.documentElement.style.setProperty("--y", evento.clientY + "px");

    document.startViewTransition(() => { toggleTema(); })
});