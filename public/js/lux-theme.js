document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS (Animate On Scroll)
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 1000,
            once: true,
            mirror: false
        });
    }

    // Preloader removal
    const preloader = document.getElementById('preloader');
    if (preloader) {
        window.addEventListener('load', function() {
            setTimeout(() => {
                preloader.style.opacity = '0';
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 500);
            }, 1000);
        });
    }

    // GSAP Animations for cards
    if (typeof gsap !== 'undefined') {
        gsap.from(".day-card", {
            duration: 0.8,
            y: 50,
            opacity: 0,
            stagger: 0.2,
            ease: "power3.out"
        });
    }

    // Magnetic Button Effect
    const luxButtons = document.querySelectorAll('.btn-lux');
    luxButtons.forEach(btn => {
        btn.addEventListener('mousemove', function(e) {
            const position = btn.getBoundingClientRect();
            const x = e.pageX - position.left - position.width / 2;
            const y = e.pageY - position.top - position.height / 2;
            
            btn.style.transform = `translate(${x * 0.3}px, ${y * 0.5}px) scale(1.05)`;
        });
        
        btn.addEventListener('mouseout', function() {
            btn.style.transform = 'translate(0px, 0px) scale(1)';
        });
    });
});
