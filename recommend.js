document.addEventListener("DOMContentLoaded", function() {
    const submitBtn = document.getElementById('submitBtn');

    submitBtn.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default form submission
        
        const form = document.getElementById('ratingForm');
        const ratingInput = form.querySelector('input[name="rating"]');
        const glowingStar = document.querySelector('.r_star.glow');

        if (glowingStar) {
            const rating = parseInt(glowingStar.getAttribute('data-rating'));
            ratingInput.value = rating;
        }
        
        form.submit();
    });

    const starContainers = document.querySelectorAll('.r_star-rating');
    starContainers.forEach(function(container) {
        const stars = container.querySelectorAll('.r_star');

        stars.forEach(function(star) {
            star.addEventListener('mouseover', function() {
                resetStars(container);
                const rating = parseInt(star.getAttribute('data-rating'));
                highlightStars(container, rating);
            });

            star.addEventListener('mouseleave', function() {
                const glowingStar = container.querySelector('.r_star.glow');
                if (glowingStar) {
                    const rating = parseInt(glowingStar.getAttribute('data-rating'));
                    highlightStars(container, rating);
                }
            });

            star.addEventListener('click', function() {
                resetStars(container);
                star.classList.add('glow');
                const rating = parseInt(star.getAttribute('data-rating'));
                highlightStars(container, rating);
            });
        });
    });

    function resetStars(container) {
        const stars = container.querySelectorAll('.r_star');
        stars.forEach(function(star) {
            star.classList.remove('hover');
            star.classList.remove('glow');
        });
    }

    function highlightStars(container, num) {
        const stars = container.querySelectorAll('.r_star');
        for (let i = 0; i < num; i++) {
            stars[i].classList.add('hover');
        }
    }
});
