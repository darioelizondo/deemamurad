// Size guide modal

const sizeGuideModal = () => {
    const modal = document.getElementById( 'sizeGuideModal' );
    const innerModal = modal.querySelector( '.size-guide-modal__inner' );
    const open = document.getElementById( 'sizeGuideOpen' );
    const close = document.getElementById( 'sizeGuideClose' );

    open.addEventListener( 'click', ( e ) => {
        e.preventDefault();
        modal.classList.add( 'active' );
        setTimeout( () => {
            innerModal.classList.add( 'active' );
        }, 200 );
    });

    close.addEventListener( 'click', ( e ) => {
        e.preventDefault();
        innerModal.classList.remove( 'active' );
        setTimeout( () => {
            modal.classList.remove( 'active' );
        }, 200 );
    });

}

// Away listener for size guide
const clickAwayListenerForSizeGuide = () => {

    // Menu
    const sizeGuide = document.querySelector( '.size-guide-modal' );
    const sizeGuideInner = document.querySelector( '.size-guide-modal__inner' );
    const toggleSizeGuide = document.getElementById( 'sizeGuideOpen' );

    // Función para manejar el click fuera del div
    const handleClickOutside = ( event ) => {

        // Comprueba si el click ocurrió fuera del div
        if ( !sizeGuideInner.contains( event.target ) && !toggleSizeGuide.contains( event.target )) {

            // Comprueba si el div tiene la clase 'active'
            if( sizeGuide.classList.contains( 'active' ) ) {
                setTimeout( () => {
                    sizeGuide.classList.remove( 'active' );
                }, 300 );
                sizeGuideInner.classList.remove( 'active' );
            }
        
        }
    }

    // Agrega un evento de click al documento
    document.addEventListener( 'click', handleClickOutside );

}

document.addEventListener('DOMContentLoaded', sizeGuideModal);
document.addEventListener('DOMContentLoaded', clickAwayListenerForSizeGuide);