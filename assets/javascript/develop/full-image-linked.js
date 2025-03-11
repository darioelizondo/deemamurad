// Full image linked
const parallaxFullImageLinked = () => {

    document.addEventListener( 'scroll', () => {
        const images = document.querySelectorAll( '.full-image-linked__picture' );
        let scrollPos = window.scrollY;

        images.forEach( image => {
            let speed = image.dataset.speed || 0.3;
            image.style.transform = `translate(-50%, ${scrollPos * speed}px)`;
        }); 
    });

};

// document.addEventListener( 'DOMContentLoaded', parallaxFullImageLinked );