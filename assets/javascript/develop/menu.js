// Menu
const toggleOpenCloseMenu = () => {

    const button = document.getElementById( 'btnHamburgerIcon' );
	const hamburgerIcon = document.getElementById( 'hamburgerIcon' );
	const headerCenter = document.getElementById( 'headerCenter' );
    const submenus = document.querySelectorAll( '.wrapper-submenu' );
    const submenusSecondLevel = document.querySelectorAll( '.submenu--second-level' );

	button.addEventListener( 'click', ( event ) => {
        event.preventDefault();
		hamburgerIcon.classList.toggle( 'active' );
		headerCenter.classList.toggle( 'active' );

        // Cerrar los submenus de primer nivel
        submenus.forEach( ( submenu ) => {
            jQuery( submenu ).removeClass( 'active' );
            jQuery( submenu ).prev().removeClass( 'active' );
        });

        // Cerrar los submenus de segundo nivel
        submenusSecondLevel.forEach( ( submenu ) => {
            jQuery( submenu ).slideUp();
            jQuery( submenu ).find( '.menu__plus-minus-toggle' ).removeClass( 'collapsed' );
        });

	}); 

};

const toggleOpenCloseMegaMenu = () => {

    const linkFirstChild = document.querySelectorAll( '.menu__has-child--first-level' );

    linkFirstChild.forEach( ( link ) => {
        link.addEventListener( 'click', ( event ) => {
            event.preventDefault();
            // Link active
            jQuery( link ).addClass( 'active' );
            // Megamenu active
            jQuery( link ).next().addClass( 'active' );
        });
    });

}

const toggleOpenCloseSubmenu = () => {

    let flagIsMobile = false;

    const allLinkWithChild_secondLevel = document.querySelectorAll( '.submenu--first-level .menu__has-child' );

    // Configurar la media query y manejar el cambio inicial
    const mediaQuery = window.matchMedia('(max-width: 1024px)');

    const handleMediaChange = (e) => {
        flagIsMobile = e.matches;
        toggleSubmenu();
    };

    const handleToggleSubmenu = ( event, link ) => {
        event.preventDefault();
        jQuery( link ).next().slideToggle();
        jQuery( link ).find( '.menu__plus-minus-toggle' ).toggleClass( 'collapsed' );
    }

    // Verificar el estado inicial de la media query
    flagIsMobile = mediaQuery.matches;

    // Agregar el listener para cambios en la media query
    mediaQuery.addEventListener( 'change', handleMediaChange );

    // Función para alternar los submenús
    const toggleSubmenu = () => {
        allLinkWithChild_secondLevel.forEach( ( link ) => {

            if ( flagIsMobile ) {
                jQuery( link).next().slideUp(); // Cerrar submenús en modo mobile

                link.addEventListener( 'click', ( event ) => handleToggleSubmenu( event, link ) ); // Comportamiento solo en mobile

            }
            if ( !flagIsMobile ) {
                jQuery( link ).next().slideDown(); // Abrir submenús en modo escritorio
                link.removeEventListener('change', handleToggleSubmenu); // Cleanup
            }

        });
    };

    // Inicializar el estado inicial de los submenús
    toggleSubmenu();
};

// Away listener para cerrar megamenu
const clickAwayListenerForSubmenu = () => {

    // Menu
    const menu = document.querySelector( '.menu' );
    const megaMenu = document.querySelector( '.wrapper-submenu' );

    // Función para manejar el click fuera del div
    const handleClickOutside = ( event ) => {

        // Comprueba si el click ocurrió fuera del div
        if ( !menu.contains( event.target )) {

            // Comprueba si el div tiene la clase 'active'
            if( megaMenu.classList.contains( 'active' ) ) {
                // Remueve la clase 'active'
                megaMenu.classList.remove( 'active' );
                megaMenu.previousSibling.classList.remove( 'active' );
            }
        
        }
    }

    // Agrega un evento de click al documento
    document.addEventListener('click', handleClickOutside);
}


// Ejecutar la función al cargar el DOM
document.addEventListener( 'DOMContentLoaded', toggleOpenCloseMenu, false );
document.addEventListener( 'DOMContentLoaded', toggleOpenCloseMegaMenu, false );
document.addEventListener( 'DOMContentLoaded', toggleOpenCloseSubmenu, false );
document.addEventListener( 'DOMContentLoaded', clickAwayListenerForSubmenu, false );