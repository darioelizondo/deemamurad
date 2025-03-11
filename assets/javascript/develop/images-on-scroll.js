// Images on scroll
const animateImagesOnScroll = () => {

    gsap.registerPlugin(ScrollTrigger);

    const images = document.querySelectorAll( '.images-on-scroll__wrapper-image' );

    let mm = gsap.matchMedia(); // Init GSAP Media Queries

    // Behavior for large devices
    mm.add("(min-width: 768px)", () => {
        images.forEach( ( image, index ) => {
            
            // Assign different positions every 3 images
            let positionStyles = [
                { top: "0", left: "7%" },
                { top: "30%", right: "14%" },
                { top: "54%", left: "20%" }
            ];

            // Get style based on index (every 3 images reset)
            let style = positionStyles[index % 3];
            
            // Define a different speed for each image
            let speed = ( index % 3 ) + 1; // 1x, 2x, 3x of speed

            // Apply position to element
            Object.assign(image.style, style);

            // Animation with GSAP
            gsap.fromTo(image,
                { 
                    y: 100 * speed,
                    opacity: 0
                },
                {
                    y: -100 * ( speed / 5 ), // Movimiento hacia arriba a diferente velocidad
                    opacity: 1,
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
    });

    mm.add("(min-width: 1700px)", () => {
        images.forEach( ( image, index ) => {
            
            // Assign different positions every 3 images
            let positionStyles = [
                { top: "0", left: "7%" },
                { top: "30%", right: "14%" },
                { top: "52%", left: "20%" }
            ];

            // Get style based on index (every 3 images reset)
            let style = positionStyles[index % 3];
            
            // Define a different speed for each image
            let speed = ( index % 3 ) + 1; // 1x, 2x, 3x of speed

            // Apply position to element
            Object.assign(image.style, style);

            // Animation with GSAP
            gsap.fromTo(image,
                { 
                    y: 100 * speed,
                    opacity: 0
                },
                {
                    y: -100 * ( speed / 5 ), // Movimiento hacia arriba a diferente velocidad
                    opacity: 1,
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
    });


    mm.add("(max-width: 767px)", () => {
        images.forEach( ( image, index ) => {
            
            // Assign different positions every 3 images
            let positionStyles = [
                { top: "0", left: "7%" },
                { top: "38%", right: "14%" },
                { top: "65%", left: "12%" }
            ];

            // Get style based on index (every 3 images reset)
            let style = positionStyles[index % 3];
            
            // Define a different speed for each image
            let speed = ( index % 3 ); // 0x, 1x, 2x of speed

            // Apply position to element
            Object.assign(image.style, style);

            // Animation with GSAP
            gsap.fromTo(image,
                { 
                    y: 100 * speed,
                    opacity: 0
                },
                {
                    y: -100 * ( speed / 5 ) , // Movimiento hacia arriba a diferente velocidad
                    opacity: 1,
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
    });


    setTimeout(() => {
        ScrollTrigger.refresh();
    }, 500 );

};

window.addEventListener( 'load', animateImagesOnScroll );