// FAQ

const faq = () => {
    const wrapperAccordion = document.querySelector( '.faq__wrapper-accordion' );
    const accordionItem = document.querySelectorAll( '.faq__accordion-item' );

    // Init
    accordionItem.forEach( item => {
        const plusMinus = item.querySelector( '.faq__plus-minus-toggle' );
        const content = item.querySelector( '.faq__accordion-content' );
        jQuery( plusMinus ).addClass( 'collapsed' );
        jQuery( content ).slideUp();
    })

    // Listener
    wrapperAccordion.addEventListener( 'click', ( e ) => {

        const clickedItem = e.target.closest( '.faq__accordion-title' );

        if( !clickedItem ) return;

        const isOpen = clickedItem.classList.contains( 'active' );

        // Cerrar todos los items
        accordionItem.forEach( item => {
            const plusMinus = item.querySelector( '.faq__plus-minus-toggle' );
            const content = item.querySelector( '.faq__accordion-content' );
            jQuery( plusMinus ).addClass( 'collapsed' );
            jQuery( content ).slideUp();
            jQuery( '.faq__accordion-title' ).removeClass( 'active' );
        });

        if( !isOpen ) {
            const plusMinus = clickedItem.querySelector( '.faq__plus-minus-toggle' );
            jQuery( clickedItem ).addClass( 'active' );
            jQuery( plusMinus ).removeClass( 'collapsed' );
            jQuery( clickedItem ).next().slideDown();
        }

    });

}

document.addEventListener( 'DOMContentLoaded', faq );