document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded'); // Debug log
    
    // Mobile menu toggle
    const menuToggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('nav');
    
    if (menuToggle) {
        console.log('Menu toggle found'); // Debug log
        
        menuToggle.addEventListener('click', function() {
            console.log('Menu clicked'); // Debug log
            nav.classList.toggle('active');
        });
    } else {
        console.log('Menu toggle not found'); // Debug log
    }
    
    // Close menu when clicking on a link
    const navLinks = document.querySelectorAll('nav ul li a');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            nav.classList.remove('active');
        });
    });
});