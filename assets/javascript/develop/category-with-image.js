// Category with Image

const categoryWithImage = () => {

    const texts = document.querySelectorAll( '.category-with-image__text' );
    const images= document.querySelectorAll( '.category-with-image__image-link' );
    let lastImage = null;

    // First one active
    images[0].classList.add( 'active' );

    texts.forEach( link => {
        const id = link.dataset.id;

        link.addEventListener( 'mouseenter', () => {
            const currentImage = document.getElementById( `categoryWithImageLink-image-${id}` );

            images.forEach( img => img.classList.remove( 'active' ) );
            currentImage.classList.add( 'active' );
            lastImage = currentImage;

        });

        link.addEventListener( 'mouseleave', () => {
            if( lastImage ) {
                images.forEach( img => img.classList.remove( 'active' ) );
                lastImage.classList.add( 'active' );
            }
        });

    });


}

document.addEventListener( 'DOMContentLoaded', categoryWithImage );