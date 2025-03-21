// About Deema
const aboutDeema = () =>  {

    const sliders = document.querySelectorAll( '.about-deema__swiper' );

    if ( window.innerWidth < 768 ) {

        sliders.forEach( slider => {
            if( slider !== undefined ) {
                new Swiper( slider, {
                    slidesPerView: 1.3,
                    spaceBetween: 13,
                    navigation: false,
                    speed: 1000,
                    autoplay: false,
                });
            }
        });

    }
};

document.addEventListener( 'DOMContentLoaded', aboutDeema );