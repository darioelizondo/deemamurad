<?php

    /**
     * Component: Molecule: Terms and Conditions Popup
     * 
     * @package Darío Elizondo
     * 
     */

    $terms_and_conditions_popup = get_field( 'popup_terms_and_conditions', 'option' );

    wp_enqueue_script( 'deemamurad.terms-and-conditions-popup' );

?>

<!-- Terms and Conditions Popup -->
<?php if( $terms_and_conditions_popup && !empty( $terms_and_conditions_popup[ 'content' ] ) ) : ?>
    <div id="termsConditionsPopup" class="terms-and-conditions-popup">
        <div class="terms-and-conditions-popup__inner">
            <!-- Content -->
            <div class="terms-and-conditions-popup__content">
                <?php echo wp_kses_post( $terms_and_conditions_popup[ 'content' ] ); ?>
            </div>
            <!-- Separator -->
            <div class="terms-and-conditions-popup__separator"></div>
            <!-- Checkboxes -->
            <div class="terms-and-conditions-popup__wrapper-checkbox">
                <label class="terms-and-conditions-popup__label-checkbox">
                    <input type="checkbox" class="terms-and-conditions-popup__input terms-and-conditions-popup__input-checkbox" name="terms-and-conditions-popup-checkbox" id="termsAndConditionsCheckbox_understood" />
                    <span class="checkmark"></span>
                </label>
                <span class="terms-and-conditions-popup__checkbox-span">
                    I confirm that I have read and understood Deema Murad’s Privacy Policy.
                </span>
            </div>
            <div class="terms-and-conditions-popup__wrapper-checkbox">
                <label class="terms-and-conditions-popup__label-checkbox">
                    <input type="checkbox" class="terms-and-conditions-popup__input terms-and-conditions-popup__input-checkbox" name="terms-and-conditions-popup-checkbox" id="termsAndConditionsCheckbox_readTerms" />
                    <span class="checkmark"></span>
                </label>
                <span class="terms-and-conditions-popup__checkbox-span">
                    I have read and I agree with Deema Murad’s Terms and Conditions.
                </span>
            </div>
            <!-- Accept -->
            <div class="terms-and-conditions-popup__wrapper-button">
                <button class="terms-and-conditions-popup__button disabled" id="termsAndConditionsPopupButton">Accept</button>
            </div>                
        </div>
    </div>
<?php endif; ?>
<!-- End terms and Conditions Popup -->