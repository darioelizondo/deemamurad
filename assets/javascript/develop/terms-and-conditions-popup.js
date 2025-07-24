// Terms and conditions popup

const termsAndConditionsPopup = () => {
    const popup = document.getElementById('termsConditionsPopup');
    const checkboxUnderstood = document.getElementById('termsAndConditionsCheckbox_understood');
    const checkboxReadTerms = document.getElementById('termsAndConditionsCheckbox_readTerms');
    const button = document.getElementById('termsAndConditionsPopupButton');

    // 1. Verificar los términos para mostrar el popup
    const accepted = localStorage.getItem('termsAccepted');
    if ( accepted !== 'true') {
        popup.classList.add('opened');
    }

    // 2. Habilitar / deshabilitar el botón según el checkbox
    checkboxUnderstood.addEventListener('change', () => {
        if ( checkboxUnderstood.checked && checkboxReadTerms.checked ) {
            button.classList.remove('disabled');
        } else {
            button.classList.add('disabled');
        }
    });

    checkboxReadTerms.addEventListener('change', () => {
        if ( checkboxUnderstood.checked && checkboxReadTerms.checked ) {
            button.classList.remove('disabled');
        } else {
            button.classList.add('disabled');
        }
    });

    // 3. Guardar en localStorage al aceptar y cerrar el popup
    button.addEventListener('click', () => {
        if ( !checkboxUnderstood.checked && checkboxReadTerms.checked ) return;
        
        localStorage.setItem('termsAccepted', 'true');
        popup.classList.remove('opened');
    });
};

document.addEventListener('DOMContentLoaded', termsAndConditionsPopup);