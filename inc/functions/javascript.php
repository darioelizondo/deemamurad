<?php

    /**
     * Function: Javascript
     * 
     * @package Darío Elizondo
     * 
     */

    add_action( 'wp_enqueue_scripts', 'deemamurad_javascript' );

    function deemamurad_javascript() {
        // Libs
        // wp_register_script( 'swiper', TDU . '/assets/third/swiper/swiper-bundle.min.js', array( 'jquery' ), '11.1.3', true );
        
        // App
        // wp_register_script( 'complacer.language-login', TDU . '/assets/javascript/production/language-login.js', array( 'jquery' ), filemtime( TD . '/assets/javascript/production/language-login.js' ), true );
    }