<?php

    /**
     * Function: Stylesheet
     * 
     * @package Darío Elizondo
     * 
     */

    add_action( 'wp_enqueue_scripts' , 'deemamurad_stylesheets', 100 );

    function deemamurad_stylesheets() {

        // Libs
        wp_enqueue_style( 'swiper', TDU . '/assets/third/swiper/swiper-bundle.min.css', array(), '11.2.2' );
        wp_enqueue_style( 'aos', TDU . '/assets/third/aos/aos.css', array(), '3.0.0' );

        // App
        wp_enqueue_style( 'stylesheets', TDU . '/assets/css/stylesheets.css', array(), filemtime( TD . '/assets/css/stylesheets.css' ) );

    }