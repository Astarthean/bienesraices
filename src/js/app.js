document.addEventListener('DOMContentLoaded', function(){
    eventListeners();
    darkMode()
})

function darkMode() {
    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)')
    if (prefiereDarkMode.matches) {
        document.body.classList.add('dark-mode')
    } else {
        document.body.classList.remove('dark-mode')
    }

    //Cambia a dark mode o light mode dependiendo del modo automatico del PC
    prefiereDarkMode.addEventListener('change', function () {
        if (prefiereDarkMode.matches) {
            document.body.classList.add('dark-mode')
        } else {
            document.body.classList.remove('dark-mode')
        }
    } )

    const botonDarkMode = document.querySelector('.dark-mode-boton')
    botonDarkMode.addEventListener('click', function () {
        document.body.classList.toggle('dark-mode')
    })
}

function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu')
    mobileMenu.addEventListener('click', navegacionResponsive)
}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion')

    // if (navegacion.classList.contains('mostrar')) {
    //     navegacion.classList.remove('mostrar')
    // } else {
    //     navegacion.classList.add('mostrar')
    // }

    //Toggle hace lo mismo que el if else de arriba
    navegacion.classList.toggle('mostrar')
}