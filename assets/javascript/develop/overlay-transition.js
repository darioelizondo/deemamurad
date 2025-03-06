// Overlay transition

const animeOverlayTransition = () => {

    const overlay = document.querySelector('.overlay-transition');

    anime({
        targets: overlay,
        easing: 'easeInOutSine',
        scaleY: [ 1, 0 ],
        delay: 200,
    });

};

// document.addEventListener('DOMContentLoaded', animeOverlayTransition);