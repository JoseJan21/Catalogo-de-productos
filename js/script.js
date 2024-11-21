function toggleMenu() {
    const nav = document.querySelector('nav');
    const menuHamburguesa = document.querySelector('.menu-hamburguesa');
    const links = document.querySelectorAll('nav a');

    nav.classList.toggle('active'); // Alterna la clase 'active' que muestra u oculta el menú

    if (nav.classList.contains('active')) {
        // Si el menú está activo, mostrar los enlaces
        links.forEach(link => link.style.display = 'block');
    } else {
        // Si el menú no está activo, ocultar los enlaces
        links.forEach(link => link.style.display = 'none');
    }
}
