<?php

    /**
     * Function: Add Wocoommerce Support
     * 
     * @package Darío Elizondo
     * 
     */

    add_action( 'after_setup_theme', 'add_woocommerce_support' );

    function add_woocommerce_support() {
        add_theme_support( 'woocommerce' );
    }