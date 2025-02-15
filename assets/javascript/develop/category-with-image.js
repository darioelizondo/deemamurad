// Category with Image

const categoryWithImage = () => {

    const links = document.querySelectorAll( '.category-with-image__link' );
    const images= document.querySelectorAll( '.category-with-image__image' );
    let lastImage = null;

    // First one active
    images[0].classList.add( 'active' );

    links.forEach( link => {
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