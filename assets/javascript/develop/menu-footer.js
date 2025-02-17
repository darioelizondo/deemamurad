// Menu footer

const menuFooter = () => {

    let flagIsMobile = false;

    const allLinkWithChild_firstLevel = document.querySelectorAll( '.menu-footer .menu-item-has-children .menu-footer__has-child' );

    // Configurar la media query y manejar el cambio inicial
    const mediaQuery = window.matchMedia('(max-width: 1024px)');

    const handleMediaChange = (e) => {
        flagIsMobile = e.matches;
        toggleSubmenu();
    };

    const handleToggleSubmenu = ( event, link ) => {
        event.preventDefault();
        jQuery( link ).next().slideToggle();
        jQuery( link ).find( '.menu-footer__plus-minus-toggle' ).toggleClass( 'collapsed' );
    }

    // Verificar el estado inicial de la media query
    flagIsMobile = mediaQuery.matches;

    // Agregar el listener para cambios en la media query
    mediaQuery.addEventListener( 'change', handleMediaChange );

    // Función para alternar los submenús
    const toggleSubmenu = () => {
        allLinkWithChild_firstLevel.forEach( ( link ) => {

            if ( flagIsMobile ) {
                jQuery( link ).next().slideUp(); // Cerrar submenús en modo mobile

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

document.addEventListener( 'DOMContentLoaded', menuFooter );