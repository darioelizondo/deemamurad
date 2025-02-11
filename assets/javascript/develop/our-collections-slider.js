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
                autoplay: {
                    delay: 3500,
                    disableOnInteraction: false
                },
                navigation: {
                    nextEl: next,
                    prevEl: prev,
                },
                slidesPerView: 1.5,
                spaceBetween: 13,
                breakpoints: {
                    '640': {
                        slidesPerView: 2,
                        spaceBetween: 20
                    },
                    '1024': {
                        slidesPerView: 3,
                        spaceBetween: 26
                    },
                    '1280': {
                        slidesPerView: 4,
                        spaceBetween: 26
                    }
                },
                on: {
                    init: function () {
                        checkNavButtons( this );
                    },
                    slideChange: function () {
                        checkNavButtons( this );
                    },
                },
            });


            function checkNavButtons( swiper ) {
                prev.style.display = swiper.isBeginning ? "none" : "block";
                next.style.display = swiper.isEnd ? "none" : "block";
            }

        }
    });

};

document.addEventListener( 'DOMContentLoaded', ourCollectionsSwiper );