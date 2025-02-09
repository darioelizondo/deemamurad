// Header
const animeHeader = () => {

    const logo = document.querySelector( '.logo' );
    const menu = document.querySelector( '.menu' );
    // Header right
    const currencyAndAccount = document.querySelector( '.header__wrapper-currency-account' );
    const cart = document.querySelector( '.header__wrapper-cart-header' );

    const animeHeaderTimeline = anime.timeline({
        easing: 'easeInOutSine',
    });

    if( logo ) {

        animeHeaderTimeline.add({
            targets: logo,
            translateY: [ 100, 0 ],
            delay: 200,
        });

    }

    if( menu ) {

        const items = menu.querySelectorAll( '.menu__nav > li' );

        animeHeaderTimeline.add({
            targets: items,
            opacity: [ 0, 1 ],
            duration: 500,
            delay: anime.stagger( 75 ),
        });

    }

    if( currencyAndAccount ) {

        animeHeaderTimeline.add({
            targets: currencyAndAccount,
            opacity: [ 0, 1 ],
            duration: 400,
        });

    }

    if( cart ) {

        animeHeaderTimeline.add({
            targets: cart,
            opacity: [ 0, 1 ],
            duration: 400,
        });

    }

};


document.addEventListener( 'DOMContentLoaded', animeHeader );