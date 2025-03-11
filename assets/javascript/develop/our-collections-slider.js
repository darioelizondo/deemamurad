// Our collections slider

const ourCollectionsSwiper = () => {

    const ourCollectionsSliders = document.querySelectorAll( '.our-collections-slider' );

    ourCollectionsSliders.forEach( ourCollections => {

        const currentSwiper = ourCollections.querySelector( '.our-collections-slider__swiper' );
        const next = ourCollections.querySelector( '.our-collections-slider__next-button' );
        const prev = ourCollections.querySelector( '.our-collections-slider__prev-button' );

        if( currentSwiper !== undefined ) {
            swiper = new Swiper( currentSwiper, {
                speed: 1000,
                // autoplay: {
                //     delay: 3500,
                //     disableOnInteraction: false
                // },
                autoplay: false,
                navigation: {
                    nextEl: next,
                    prevEl: prev,
                },
                loop: true,
                slidesPerView: 1.5,
                spaceBetween: 10,
                breakpoints: {
                    '640': {
                        slidesPerView: 2,
                        spaceBetween: 13
                    },
                    '1024': {
                        slidesPerView: 3,
                        spaceBetween: 13
                    },
                    '1280': {
                        slidesPerView: 4,
                        spaceBetween: 13
                    }
                },
                // on: {
                //     init: function () {
                //         checkNavButtons( this );
                //     },
                //     slideChange: function () {
                //         checkNavButtons( this );
                //     },
                // },
            });


            // function checkNavButtons( swiper ) {
            //     prev.style.display = swiper.isBeginning ? "none" : "block";
            //     next.style.display = swiper.isEnd ? "none" : "block";
            // }

        }
    });

};

document.addEventListener( 'DOMContentLoaded', ourCollectionsSwiper );