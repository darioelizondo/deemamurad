// Terms and conditions popup

const termsAndConditionsPopup = () => {

    const popup = document.getElementById( 'termsConditionsPopup' );
    const checkbox = document.getElementById( 'termsAndConditionsCheckbox' );
    const button = document.getElementById( 'termsAndConditionsPopupButton' );

    checkbox.addEventListener( 'change', () => {
        if ( checkbox.checked ) {
            button.classList.remove( 'disabled' );
        } else {
            button.classList.add( 'disabled' );
        }
    });

    button.addEventListener( 'click', () => {
        if ( !checkbox.checked ) {
            return;
        }
        popup.classList.add( 'closed' );
    });

}

document.addEventListener('DOMContentLoaded', termsAndConditionsPopup);