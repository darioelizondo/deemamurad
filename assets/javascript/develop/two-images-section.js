// Two images section
const twoImagesSection = () =>  {

    const sliders = document.querySelectorAll( '.two-images-section__swiper' );

    if ( window.innerWidth < 768 ) {

        sliders.forEach( slider => {
            if( slider !== undefined ) {
                new Swiper( slider, {
                    slidesPerView: 1.2,
                    spaceBetween: 13,
                    navigation: false,
                    speed: 1000,
                    autoplay: false,
                });
            }
        });

    }
};

document.addEventListener( 'DOMContentLoaded', twoImagesSection );