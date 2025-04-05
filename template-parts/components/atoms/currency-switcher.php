<?php

    /**
     * Component: Atom: Currency switcher
     * 
     * @package Darío Elizondo
     * 
     */

    $currency = isset( $_COOKIE[ 'currency' ] ) ? $_COOKIE[ 'currency']  : 'EUR';

?>

<!-- Currency switcher -->
<div class="currency-switcher">
    <button class="currency-switcher__button <?php if ( $currency === 'EUR' ) echo 'active'; ?>" onclick="setCurrency('EUR')">EUR</button>
    <span class="currency-switcher__span">/</span>
    <button class="currency-switcher__button <?php if ( $currency === 'USD' ) echo 'active'; ?>" onclick="setCurrency('USD')">USD</button>
</div>
<!-- End currency switcher -->