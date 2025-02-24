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

document.addEventListener('DOMContentLoaded', sizeGuideModal);