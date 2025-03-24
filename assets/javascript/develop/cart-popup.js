// Cart popup

// Away listener for close the cart popup
const clickAwayListenerForCartPopup = () => {

    // Menu
    const cartPopup = document.querySelector( '.cart-popup' );
    const cartPopupInner = document.querySelector( '.cart-popup__inner' );
    const openCartPopup = document.getElementById( 'headerCartButton' );

    // Función para manejar el click fuera del div
    const handleClickOutside = ( event ) => {

        // Comprueba si el click ocurrió fuera del div
        if ( !cartPopupInner.contains( event.target ) && !openCartPopup.contains( event.target )) {

            // Comprueba si el div tiene la clase 'active'
            if( cartPopup.classList.contains( 'active' ) ) {
                setTimeout( () => {
                    cartPopup.classList.remove( 'active' );
                }, 300 );
                cartPopupInner.classList.remove( 'active' );
            }
        
        }
    }

    // Agrega un evento de click al documento
    document.addEventListener( 'click', handleClickOutside );

}

document.addEventListener( 'DOMContentLoaded', clickAwayListenerForCartPopup );