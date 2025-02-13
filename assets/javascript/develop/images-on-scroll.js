// Images on scroll
const animateImagesOnScroll = () => {

    gsap.registerPlugin(ScrollTrigger);

    console.log(gsap);
    console.log(ScrollTrigger);


    const images = document.querySelectorAll( '.images-on-scroll__wrapper-image' );

    images.forEach( ( image, index ) => {
        
        // Assign different positions every 3 images
        let positionStyles = [
            { top: "0", left: "10%" },
            { top: "10%", right: "18%" },
            { top: "20%", left: "20%" }
        ];

        // Get style based on index (every 3 images reset)
        let style = positionStyles[index % 3];
        
        // Define a different speed for each image
        let speed = ( index % 3 ) + 2; // 2x, 3x, 4x of speed

        // Apply position to element
        Object.assign(image.style, style);

        // Animation with GSAP
        gsap.fromTo(image,
            { y: 100 * speed, },
            {
                y: -100 * speed, // Movimiento hacia arriba a diferente velocidad
                duration: 1.5,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: image,
                    start: "top 100%",
                    end: "bottom 0%",
                    scrub: true, // Movimiento fluido con el scroll
                    toggleActions: "play reverse play reverse",
                }
            }
        );

    });

};

window.addEventListener( 'DOMContentLoaded', animateImagesOnScroll );