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
        wp_register_script( 'aos', TDU . '/assets/third/aos/aos.js', array( 'jquery' ), '3.0.0', true );
        wp_register_script( 'gsap', TDU . '/assets/third/gsap/gsap.min.js', array( 'jquery' ), '3.12.7', true );
        wp_register_script( 'gsap.scrollTrigger', TDU . '/assets/third/gsap/ScrollTrigger.min.js', array( 'jquery' ), '3.12.7', true );

        
        // App
        wp_register_script( 'deemamurad.menu', TDU . '/assets/javascript/production/menu.js', array( 'jquery' ), filemtime( TD . '/assets/javascript/production/menu.js' ), true );
        wp_register_script( 'deemamurad.header', TDU . '/assets/javascript/production/header.js', array( 'jquery' ), filemtime( TD . '/assets/javascript/production/header.js' ), true );
        wp_register_script( 'deemamurad.overlay-transition', TDU . '/assets/javascript/production/overlay-transition.js', array( 'jquery' ), filemtime( TD . '/assets/javascript/production/overlay-transition.js' ), true );
        wp_register_script( 'deemamurad.hero', TDU . '/assets/javascript/production/hero.js', array( 'jquery' ), filemtime( TD . '/assets/javascript/production/hero.js' ), true );
        wp_register_script( 'deemamurad.our-collections-slider', TDU . '/assets/javascript/production/our-collections-slider.js', array( 'jquery' ), filemtime( TD . '/assets/javascript/production/our-collections-slider.js' ), true );
        wp_register_script( 'deemamurad.aos-init', TDU . '/assets/javascript/production/aos.js', array( 'jquery' ), filemtime( TD . '/assets/javascript/production/aos.js' ), true );
        wp_register_script( 'deemamurad.full-image-linked', TDU . '/assets/javascript/production/full-image-linked.js', array( 'jquery' ), filemtime( TD . '/assets/javascript/production/full-image-linked.js' ), true );
        wp_register_script( 'deemamurad.images-on-scroll', TDU . '/assets/javascript/production/images-on-scroll.js', array( 'jquery' ), filemtime( TD . '/assets/javascript/production/images-on-scroll.js' ), true );

    }