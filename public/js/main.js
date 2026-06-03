// Mobile Menu Toggle & Common UI Logic
window.onPageLoad(() => {
    const mobileMenu = document.getElementById('mobile-menu');
    const closeMenu = document.getElementById('close-menu');
    const navLinks = document.querySelector('.nav-links');

    if (mobileMenu && navLinks) {
        mobileMenu.addEventListener('click', () => navLinks.classList.add('active'));
    }

    if (closeMenu && navLinks) {
        closeMenu.addEventListener('click', () => navLinks.classList.remove('active'));
    }

    // Auto-close menu when clicking a link
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', () => {
            if (navLinks) navLinks.classList.remove('active');
        });
    });

    // Header Scroll Effect
    const header = document.querySelector('header');
    window.addEventListener('scroll', () => {
        if (header) {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else if (!header.dataset.forceScrolled) {
                header.classList.remove('scrolled');
            }
        }
    });

    // Notification Auto-hide
    const notifications = document.querySelectorAll('.notification');
    if (notifications.length > 0) {
        setTimeout(() => {
            notifications.forEach(notif => {
                notif.style.opacity = '0';
                notif.style.transition = '0.5s';
                setTimeout(() => notif.style.display = 'none', 500);
            });
        }, 3000);
    }
});
