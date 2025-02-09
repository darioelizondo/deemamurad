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
        wp_register_script( 'animejs', TDU . '/assets/third/anime-js/anime.min.js', array( 'jquery' ), '3.2.2', true );
        wp_register_script( 'swiper', TDU . '/assets/third/swiper/swiper-bundle.min.js', array( 'jquery' ), '11.2.2', true );

        
        // App
        wp_register_script( 'deemamurad.menu', TDU . '/assets/javascript/production/menu.js', array( 'jquery' ), filemtime( TD . '/assets/javascript/production/menu.js' ), true );
        wp_register_script( 'deemamurad.header', TDU . '/assets/javascript/production/header.js', array( 'jquery' ), filemtime( TD . '/assets/javascript/production/header.js' ), true );
        wp_register_script( 'deemamurad.overlay-transition', TDU . '/assets/javascript/production/overlay-transition.js', array( 'jquery' ), filemtime( TD . '/assets/javascript/production/overlay-transition.js' ), true );
        wp_register_script( 'deemamurad.hero', TDU . '/assets/javascript/production/hero.js', array( 'jquery' ), filemtime( TD . '/assets/javascript/production/hero.js' ), true );

    }