// Shop filters

// Away listener for close filters
const clickAwayListenerForFilters = () => {

    // Menu
    const filters = document.querySelector( '.products-filters' );
    const filtersInner = document.querySelector( '.products-filters__inner' );
    const toggleFilters = document.getElementById( 'toggleFilters' );

    // Función para manejar el click fuera del div
    const handleClickOutside = ( event ) => {

        // Comprueba si el click ocurrió fuera del div
        if ( !filtersInner.contains( event.target ) && !toggleFilters.contains( event.target )) {

            // Comprueba si el div tiene la clase 'active'
            if( filters.classList.contains( 'active' ) ) {
                setTimeout( () => {
                    filters.classList.remove( 'active' );
                }, 300 );
                filtersInner.classList.remove( 'active' );
            }
        
        }
    }

    // Agrega un evento de click al documento
    document.addEventListener( 'click', handleClickOutside );

}

document.addEventListener( 'DOMContentLoaded', clickAwayListenerForFilters );