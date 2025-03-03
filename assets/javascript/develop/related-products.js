// Related products
const relatedProducts = () =>  {

    const relatedProductsSwiper = document.querySelector( '.related-products__swiper' );

    if ( window.innerWidth < 768 ) {

        if( relatedProductsSwiper !== undefined ) {
            new Swiper( relatedProductsSwiper, {
                slidesPerView: 1.5,
                spaceBetween: 13,
                navigation: false,
                speed: 1000,
                autoplay: {
                    delay: 3500,
                    disableOnInteraction: false
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });
        }
    }
};

document.addEventListener( 'DOMContentLoaded', relatedProducts );