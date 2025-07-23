// Terms and conditions popup

const termsAndConditionsPopup = () => {
    const popup = document.getElementById('termsConditionsPopup');
    const checkbox = document.getElementById('termsAndConditionsCheckbox');
    const button = document.getElementById('termsAndConditionsPopupButton');

    // 1. Verificar los términos para mostrar el popup
    const accepted = localStorage.getItem('termsAccepted');
    if ( accepted !== 'true') {
        popup.classList.add('opened');
    }

    // 2. Habilitar / deshabilitar el botón según el checkbox
    checkbox.addEventListener('change', () => {
        if (checkbox.checked) {
            button.classList.remove('disabled');
        } else {
            button.classList.add('disabled');
        }
    });

    // 3. Guardar en localStorage al aceptar y cerrar el popup
    button.addEventListener('click', () => {
        if (!checkbox.checked) return;

        localStorage.setItem('termsAccepted', 'true');
        popup.classList.remove('opened');
    });
};

document.addEventListener('DOMContentLoaded', termsAndConditionsPopup);