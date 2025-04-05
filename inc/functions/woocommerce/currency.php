<?php

    /**
     * Function: Currency
     * 
     * @package Darío Elizondo
     * 
     */

    
     /** 
     * Change currency in WooCommerce
     */
    add_filter('woocommerce_currency', 'chance_currency');

    function chance_currency( $currency ) {

        if ( isset( $_COOKIE[ 'currency' ] ) ) {
            return $_COOKIE[ 'currency' ]; // Usa la moneda seleccionada
        }

        return 'EUR'; // Moneda por defecto

    }

     /** 
     * Add currency cookie function
     */

    add_action( 'wp_footer', 'set_currency_cookie_script');

    function set_currency_cookie_script() {
       ?>

            <script>
                function setCurrency(currency) {
                    document.cookie = "currency=" + currency + "; path=/";
                    location.reload(); // Recargar para aplicar cambios
                }
            </script>

        <?php
    }

     /** 
     * Apply currency conversion to prices
     */

    // Regular price
    add_filter('woocommerce_product_get_price', 'convert_prices_according_to_currenct', 10, 2);
    add_filter('woocommerce_product_get_regular_price', 'convert_prices_according_to_currenct', 10, 2);
    add_filter('woocommerce_product_get_sale_price', 'convert_prices_according_to_currenct', 10, 2);
    // Variations 
    add_filter('woocommerce_product_variation_get_regular_price', 'convert_prices_according_to_currenct', 99, 2 );
    add_filter('woocommerce_product_variation_get_price', 'convert_prices_according_to_currenct', 99, 2 );

    // Variable (price range)
    // add_filter('woocommerce_variation_prices_price', 'convert_prices_according_to_currenct', 99, 3 );
    // add_filter('woocommerce_variation_prices_regular_price', 'convert_prices_according_to_currenct', 99, 3 );

    // Handling price caching (see explanations at the end)
    // add_filter( 'woocommerce_get_variation_prices_hash', 'convert_prices_according_to_currenct', 99, 3 );

    function convert_prices_according_to_currenct( $price, $product ) {
        $currency = isset( $_COOKIE[ 'currency' ] ) ? $_COOKIE[ 'currency']  : 'EUR';
        $exchange_rate = get_exchange_rate(); // Calcular la tasa de cambio
    
        if ( $currency === 'USD' ) {
            $price = round( $price * $exchange_rate, 2 ); // Convierte a EUR a USD
            return $price; 
        }

        return $price; // Mantiene EUR por defecto
        
    }

    function get_exchange_rate() {

        // Intentar obtener la tasa desde el caché
        $cached_rate = get_transient( 'eur_usd_exchange_rate' );

        if ( $cached_rate !== false ) {
            return $cached_rate;
        }

        // Si no hay caché, hacer la consulta a la API
        $response = wp_remote_get('https://api.exchangerate-api.com/v4/latest/EUR');

        // Valor por defecto si falla todo
        $usd_exchange_rate_field = get_field( 'exchange_rate', 'option' );
        $default_exchange_rate = $usd_exchange_rate_field[ 'usd_exchange_rate' ] ?? 1.08;

        if ( is_wp_error( $response ) ) {
            return $default_exchange_rate;
        }

        $body = json_decode( wp_remote_retrieve_body( $response ), true );
        $rate = isset( $body['rates']['USD'] ) ? $body['rates']['USD'] : $default_exchange_rate;

        // Guardar en caché por 3 horas (3 * 3600 segundos = 10800 segundos)
        set_transient('eur_usd_exchange_rate', $rate, 3 * 3600);

        return $rate;

    }

     /** 
     * Change currency symbol
     */

    add_filter('woocommerce_currency_symbol', 'change_currency_symbol', 10, 2);

    function change_currency_symbol($currency_symbol, $currency) {
        if ( isset( $_COOKIE[ 'currency' ])) {
            $currency = $_COOKIE[ 'currency' ];
        }
        
        switch ( $currency ) {
            case 'EUR': return '€';
            case 'USD': return '$';
        }

        return $currency_symbol;
    }