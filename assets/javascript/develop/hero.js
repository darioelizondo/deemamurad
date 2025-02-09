// Hero
const animeHero = () => {

    const heros = document.querySelectorAll( '.hero' );

    heros.forEach( ( hero ) => {

        const images = hero.querySelectorAll( '.hero__wrapper-image' );

        anime({
            targets: images,
            easing: 'easeInOutSine',
            translateY: [ 1000, 0 ],
            delay: anime.stagger( 200 ),
        });       

    });

};

document.addEventListener( 'DOMContentLoaded', animeHero );