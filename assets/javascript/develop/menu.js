// Menu
const toggleOpenCloseMenu = () => {

    const button = document.getElementById( 'btnHamburgerIcon' );
	const hamburgerIcon = document.getElementById( 'hamburgerIcon' );
	const headerCenter = document.getElementById( 'headerCenter' );
    const submenus = document.querySelectorAll( '.wrapper-submenu' );
    const submenusSecondLevel = document.querySelectorAll( '.submenu--second-level' );
    const imagePlaceholder = document.getElementById( 'imagePlaceholder' );

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

        // Restaurar imagen de placeholder
        setTimeout( () => {
            imagePlaceholder.src = imagePlaceholder.dataset.image;
        }, 1000 );
        

	}); 

};

const toggleOpenCloseMegaMenu = () => {

    const linkFirstChild = document.querySelectorAll( '.menu__has-child--first-level' );

    linkFirstChild.forEach( ( link ) => {
        link.addEventListener( 'click', ( event ) => {
            event.preventDefault();
            // Link active
            jQuery( link ).parent().addClass( 'active' );
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
    const imagePlaceholder = document.getElementById( 'imagePlaceholder' );

    // Función para manejar el click fuera del div
    const handleClickOutside = ( event ) => {

        // Comprueba si el click ocurrió fuera del div
        if ( !menu.contains( event.target )) {

            // Comprueba si el div tiene la clase 'active'
            if( megaMenu.classList.contains( 'active' ) ) {
                // Remueve la clase 'active'
                megaMenu.classList.remove( 'active' );
                megaMenu.previousSibling.parentElement.classList.remove( 'active' );
                // Restaura la imagen de placeholder
                setTimeout( () => {
                    imagePlaceholder.src = imagePlaceholder.dataset.image;
                }, 1000 );
            }
        
        }
    }

    // Agrega un evento de click al documento
    document.addEventListener('click', handleClickOutside);
}

const addItemInSubmenuCollection = () => {

    // Mega menu
    const megaMenu = document.querySelector( '.wrapper-submenu' );

    // Collections item
    const liCollections = document.querySelector( '.all-collections-item' );
    
    // Add class to 'All Collections' for handle it
    liCollections.firstChild.classList.add( 'menu__all-collections' );

    // New back item
    const newItem = document.createElement( 'a' );
    newItem.setAttribute( 'href', '#' );
    newItem.classList.add( 'menu__back-collections' );

    // Arrow SVG
    const svgArrowString = `
        <svg width="32" height="9" viewBox="0 0 32 9" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4.52941 8L1 4.5M1 4.5L4.52941 1M1 4.5L31 4.5" stroke="#3F3F46" stroke-linecap="square" stroke-linejoin="round"/>
        </svg>`;
    const parser = new DOMParser();
    const svgDoc = parser.parseFromString( svgArrowString, 'image/svg+xml' );
    const svgElement = svgDoc.documentElement;

    // Span text
    const spanText = document.createElement( 'span' );
    spanText.textContent = 'Collections';

    // Add SVG to new link
    newItem.appendChild( svgElement );

    // Add span to new link
    newItem.appendChild( spanText );

    // Add new link with SVG to collections item
    liCollections.appendChild( newItem );

    liCollections.addEventListener( 'click', ( event ) => {
        event.preventDefault();
        megaMenu.classList.remove( 'active' );
        megaMenu.previousSibling.classList.remove( 'active' );
    });

}

const changeImagePlaceholderMenu = () => {
    
    const menuItems = document.querySelectorAll( '.menu-item' );
    const imagePlaceholder = document.getElementById( 'imagePlaceholder' );

    menuItems.forEach( ( item ) => {

        const dataImage = item.dataset.image;
        
        item.addEventListener( 'mouseover', () => {
            if( dataImage ) {
                imagePlaceholder.src = dataImage;
            }
        });

    });

}

// Ejecutar funciones al cargar el DOM
document.addEventListener( 'DOMContentLoaded', toggleOpenCloseMenu, false );
document.addEventListener( 'DOMContentLoaded', toggleOpenCloseMegaMenu, false );
document.addEventListener( 'DOMContentLoaded', toggleOpenCloseSubmenu, false );
document.addEventListener( 'DOMContentLoaded', clickAwayListenerForSubmenu, false );
document.addEventListener( 'DOMContentLoaded', addItemInSubmenuCollection, false );
document.addEventListener( 'DOMContentLoaded', changeImagePlaceholderMenu, false );